import io
import math

from PIL import Image, ImageDraw, ImageFont

SIZE = 512
CENTER = SIZE // 2
OUTER_RADIUS = 236
LABEL_RADIUS = 179
BORDER_COLOR = (30, 30, 30, 255)
POINTER_COLOR = (255, 209, 0, 255)
HUB_COLOR = (40, 40, 40, 255)
BACKGROUND = (18, 18, 22, 255)

PALETTE = [
    (214, 40, 40, 255),
    (24, 24, 24, 255),
    (0, 129, 111, 255),
    (35, 55, 130, 255),
]


def _font(size: int) -> ImageFont.ImageFont:
    try:
        return ImageFont.load_default(size=size)
    except TypeError:
        return ImageFont.load_default()


def _font_size_for(labels: list[str], count: int) -> int:
    max_len = max(len(label) for label in labels)
    size = 32
    if count > 6:
        size -= 4
    if max_len > 2:
        size -= 4
    if max_len > 4:
        size -= 4
    return max(size, 14)


def _build_base_wheel(labels: list[str]) -> Image.Image:
    wheel = Image.new("RGBA", (SIZE, SIZE), (0, 0, 0, 0))
    draw = ImageDraw.Draw(wheel)

    count = len(labels)
    sector_angle = 360 / count
    bbox = (CENTER - OUTER_RADIUS, CENTER - OUTER_RADIUS, CENTER + OUTER_RADIUS, CENTER + OUTER_RADIUS)
    font = _font(_font_size_for(labels, count))

    for i, label in enumerate(labels):
        start = i * sector_angle
        end = start + sector_angle
        color = PALETTE[i % len(PALETTE)]
        draw.pieslice(bbox, start, end, fill=color, outline=BORDER_COLOR, width=3)

        mid_angle = start + sector_angle / 2
        text_bbox = draw.textbbox((0, 0), label, font=font)
        text_w = text_bbox[2] - text_bbox[0]
        text_h = text_bbox[3] - text_bbox[1]

        label_img = Image.new("RGBA", (text_w + 12, text_h + 12), (0, 0, 0, 0))
        label_draw = ImageDraw.Draw(label_img)
        label_draw.text((6 - text_bbox[0], 6 - text_bbox[1]), label, font=font, fill=(255, 255, 255, 255))

        rotation = -(mid_angle + 90)
        rotated_label = label_img.rotate(rotation, expand=True, resample=Image.BICUBIC)

        rad = math.radians(mid_angle)
        lx = CENTER + LABEL_RADIUS * math.cos(rad)
        ly = CENTER + LABEL_RADIUS * math.sin(rad)

        paste_x = int(lx - rotated_label.width / 2)
        paste_y = int(ly - rotated_label.height / 2)
        wheel.paste(rotated_label, (paste_x, paste_y), rotated_label)

    draw.ellipse(bbox, outline=BORDER_COLOR, width=4)
    hub_r = 26
    draw.ellipse(
        (CENTER - hub_r, CENTER - hub_r, CENTER + hub_r, CENTER + hub_r),
        fill=HUB_COLOR,
        outline=BORDER_COLOR,
        width=3,
    )
    return wheel


def _compose_frame(base_wheel: Image.Image, rotation_deg: float) -> Image.Image:
    frame = Image.new("RGBA", (SIZE, SIZE), BACKGROUND)
    rotated = base_wheel.rotate(rotation_deg, resample=Image.BICUBIC, center=(CENTER, CENTER))
    frame.paste(rotated, (0, 0), rotated)

    draw = ImageDraw.Draw(frame)
    pointer_tip = (CENTER, CENTER - OUTER_RADIUS - 8)
    pointer_left = (CENTER - 18, CENTER - OUTER_RADIUS - 40)
    pointer_right = (CENTER + 18, CENTER - OUTER_RADIUS - 40)
    draw.polygon([pointer_tip, pointer_left, pointer_right], fill=POINTER_COLOR, outline=BORDER_COLOR)

    return frame.convert("RGB")


def _ease_out_cubic(t: float) -> float:
    return 1 - (1 - t) ** 3


def build_spin_video(
    labels: list[str],
    winning_index: int,
    frame_count: int = 28,
    fps: int = 20,
    hold_seconds: float = 1.5,
) -> tuple[bytes, int, int, int, bytes]:
    import os
    import subprocess
    import tempfile

    import imageio.v2 as imageio
    import imageio_ffmpeg
    import numpy as np

    base_wheel = _build_base_wheel(labels)

    count = len(labels)
    sector_angle = 360 / count
    sector_center = winning_index * sector_angle + sector_angle / 2

    target_rotation = (sector_center - 270) % 360
    full_spins = 3 * 360
    total_rotation = full_spins + target_rotation

    ms_per_video_frame = 1000 / fps
    video_frames = []
    for frame_idx in range(frame_count + 1):
        t = frame_idx / frame_count
        eased_t = _ease_out_cubic(t)
        rotation = eased_t * total_rotation
        frame = _compose_frame(base_wheel, rotation)
        duration_ms = 45 + int(eased_t * 90)
        repeat = max(1, round(duration_ms / ms_per_video_frame))
        video_frames.extend([frame] * repeat)

    hold_repeat = max(1, round((hold_seconds * 1000) / ms_per_video_frame))
    video_frames.extend([video_frames[-1]] * hold_repeat)

    total_duration_ms = int(len(video_frames) * ms_per_video_frame)

    thumbnail_buffer = io.BytesIO()
    video_frames[-1].save(thumbnail_buffer, format="PNG")
    thumbnail_bytes = thumbnail_buffer.getvalue()

    silent_path = tempfile.mktemp(suffix=".mp4")
    final_path = tempfile.mktemp(suffix=".mp4")
    try:
        with imageio.get_writer(
            silent_path, fps=fps, codec="libx264", quality=8, pixelformat="yuv420p"
        ) as writer:
            for frame in video_frames:
                writer.append_data(np.array(frame))

        # Telegram auto-loops videos it detects as having no (or negligible)
        # sound, like GIFs. A real, audible sound effect avoids that, and
        # also fits a spinning roulette: a trilling "drumroll" while it
        # spins, then a short "ding" when it lands on the number.
        ding_seconds = 0.4
        spin_seconds = max(0.1, total_duration_ms / 1000 - ding_seconds)
        filter_complex = (
            "[1:a]tremolo=f=18:d=0.85,volume=0.35[spin];"
            f"[2:a]afade=t=out:st=0:d={ding_seconds},volume=0.5[ding];"
            "[spin][ding]concat=n=2:v=0:a=1[aout]"
        )

        ffmpeg_exe = imageio_ffmpeg.get_ffmpeg_exe()
        subprocess.run(
            [
                ffmpeg_exe,
                "-y",
                "-i",
                silent_path,
                "-f",
                "lavfi",
                "-t",
                f"{spin_seconds:.3f}",
                "-i",
                "sine=frequency=700:sample_rate=44100",
                "-f",
                "lavfi",
                "-t",
                f"{ding_seconds:.3f}",
                "-i",
                "sine=frequency=1200:sample_rate=44100",
                "-filter_complex",
                filter_complex,
                "-map",
                "0:v",
                "-map",
                "[aout]",
                "-c:v",
                "copy",
                "-c:a",
                "aac",
                "-b:a",
                "96k",
                "-shortest",
                final_path,
            ],
            check=True,
            capture_output=True,
        )

        with open(final_path, "rb") as f:
            video_bytes = f.read()
    finally:
        for path in (silent_path, final_path):
            if os.path.exists(path):
                os.remove(path)
    return video_bytes, total_duration_ms, SIZE, SIZE, thumbnail_bytes
