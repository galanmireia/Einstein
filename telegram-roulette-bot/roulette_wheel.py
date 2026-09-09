import io
import math

from PIL import Image, ImageDraw, ImageFont

SIZE = 500
CENTER = SIZE // 2
OUTER_RADIUS = 230
LABEL_RADIUS = 175
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


def _build_base_wheel(numbers: list[int]) -> Image.Image:
    wheel = Image.new("RGBA", (SIZE, SIZE), (0, 0, 0, 0))
    draw = ImageDraw.Draw(wheel)

    count = len(numbers)
    sector_angle = 360 / count
    bbox = (CENTER - OUTER_RADIUS, CENTER - OUTER_RADIUS, CENTER + OUTER_RADIUS, CENTER + OUTER_RADIUS)
    font = _font(30)

    for i, number in enumerate(numbers):
        start = i * sector_angle
        end = start + sector_angle
        color = PALETTE[i % len(PALETTE)]
        draw.pieslice(bbox, start, end, fill=color, outline=BORDER_COLOR, width=3)

        mid_angle = start + sector_angle / 2
        label = str(number)
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


def build_spin_gif(
    numbers: list[int], winning_index: int, frame_count: int = 28
) -> tuple[io.BytesIO, int]:
    base_wheel = _build_base_wheel(numbers)

    count = len(numbers)
    sector_angle = 360 / count
    sector_center = winning_index * sector_angle + sector_angle / 2

    target_rotation = (sector_center - 270) % 360
    full_spins = 3 * 360
    total_rotation = full_spins + target_rotation

    frames = []
    durations = []
    for frame_idx in range(frame_count + 1):
        t = frame_idx / frame_count
        eased_t = _ease_out_cubic(t)
        rotation = eased_t * total_rotation
        frames.append(_compose_frame(base_wheel, rotation))
        durations.append(45 + int(eased_t * 90))

    durations[-1] = 1800

    buffer = io.BytesIO()
    frames[0].save(
        buffer,
        format="GIF",
        save_all=True,
        append_images=frames[1:],
        duration=durations,
        loop=1,
        optimize=False,
    )
    buffer.seek(0)
    return buffer, sum(durations)
