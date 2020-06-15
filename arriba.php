<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</HEAD>
<link rel="home" title="UDM Home page" href="/" />
<link rel="search" title="Search" href="/menu/search/" />
<link rel="help" title="Accessibility information" href="/accessibility/" />
<link rel="author" title="About the author" href="/menu/author/" />
<link rel="copyright" title="Terms of use" href="/licensing/terms/" />
<link rel="index" title="Sitemap" href="/menu/sitemap/" />
<link rel="section" title="About UDM" href="/menu/" />
<link rel="section" title="Demos" href="/demos/" />
<link rel="section" title="Download" href="/licensing/download/" />
<link rel="section" title="Purchase" href="/licensing/" />
<link rel="section" title="Support" href="/menu/support/" />
<link rel="section" title="Contact" href="/contact/" />
<style type="text/css">
.genericColumn { height:2em; }
#topList {
margin:0;
padding:0;
list-style-type:none;
}
#topList li {
margin:0;
padding:0;
list-style-type:none;
display:block;
float:left;
clear:none;
}
#topList li a {
float:left;
text-decoration:none;
border:1px solid black;
padding:0.1em 0.4em;
display:block;
background-color:#ffffcc;
margin:0 0.4em 0.4em 0;
}
#topList a:hover, #topList a:focus {
background-color:#ffeaea;
}
</style>
<script>
var mainFrame = parent.frames['main'];
function openMenu(menuID,menuX)
{
if(typeof mainFrame.um != 'undefined' && typeof mainFrame.um.ready!='undefined' && mainFrame.um.ready == true){
var scrollY = (mainFrame.um.getScrollAmount() + 17);
mainFrame.um.activateMenu(menuID, menuX, scrollY + 'px');
}
}
function closeMenu(menuID)
{
if(
typeof mainFrame.um != 'undefined'
&&
typeof mainFrame.um.ready!='undefined'
&&
mainFrame.um.ready == true
)
{
mainFrame.um.deactivateMenu(menuID);
}
}
</script>
<body>
<div class="genericColumn">
<ul id="topList">
<li><a href="/" title="UDM Home page" tabindex="6" target="_top">Home</a></li>
<li><a href="/menu/" tabindex="6" target="_top" onmouseover="openMenu('about','4.7em')" onmouseout="closeMenu('about')">About UDM ..</a>
</li>
<li><a href="/demos/" tabindex="6" target="_top"
onmouseover="openMenu('demos','11.2em')"
onmouseout="closeMenu('demos')">
Demos ..</a>
</li>
<li><a href="/licensing/download" tabindex="6" target="_top">
Download</a>
</li>
<li><a href="/licensing/" tabindex="6" target="_top">
Purchase</a>
</li>
<li><a href="/menu/support/" title="Help and support" tabindex="6" target="_top"
onmouseover="openMenu('support','25.6em')"
onmouseout="closeMenu('support')">
Support ..</a>
</li>
<li><a href="/contact/" title="Contact the author for sales, support or general enquiries" tabindex="6" target="_top">Contact</a>
</li>
<li><a href="/" title="Brothercake home page" tabindex="6" target="_top">Brothercake</a>
</li>
</ul>
</div>
</BODY>
</HTML>
