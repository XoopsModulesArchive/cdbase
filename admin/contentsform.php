<?php
//  ------------------------------------------------------------------------ //
//                    Discography Dabase Module for                          //
//               XOOPS - PHP Content Management System 2.0                   //
//                   Copyright (c) 2008 Dana Harris                          //
//                       http://www.optikool.com                             //
// ------------------------------------------------------------------------- //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //

if (empty($url_buy)) $url_buy="http://";

echo "<form action='index.php' method='post'>
<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td class='bg2'>
<table width='100%' border='0' cellpadding='4' cellspacing='1'>
<tr><td nowrap='nowrap' class='bg3'>"._XD_ALBUM." </td><td class='bg1'>
    <input type='text' name='album' value='$album' size='31' maxlength='255' />
</td></tr>
<tr><td nowrap='nowrap' class='bg3'>"._XD_IMAGE." </td><td class='bg1'>
    <input type='text' name='image' value='".$image."' size='31' maxlength='255' />
    <img src='".XOOPS_URL."/images/image.gif' alt='image' onmouseover=style.cursor='hand' onclick='openWithSelfMain(\"".XOOPS_URL."/imagemanager.php?target=image\",\"imgmanager\",400,430);' />
</td></tr>
<tr><td nowrap='nowrap' class='bg3'>"._XD_IMAGE_BIG." </td><td class='bg1'>
    <input type='text' name='image_big' value='".$image_big."' size='31' maxlength='255' />
    <img src='".XOOPS_URL."/images/image.gif' alt='image' onmouseover=style.cursor='hand' onclick='openWithSelfMain(\"".XOOPS_URL."/imagemanager.php?target=image_big\",\"imgmanager2\",400,430);' />
</td></tr>
<tr><td nowrap='nowrap' class='bg3'>"._XD_IMAGE2." </td><td class='bg1'>
    <input type='text' name='image2' value='".$image2."' size='31' maxlength='255' />
    <img src='".XOOPS_URL."/images/image.gif' alt='image' onmouseover=style.cursor='hand' onclick='openWithSelfMain(\"".XOOPS_URL."/imagemanager.php?target=image2\",\"imgmanager\",400,430);' />
</td></tr>
<tr><td nowrap='nowrap' class='bg3'>"._XD_IMAGE2_BIG." </td><td class='bg1'>
    <input type='text' name='image2_big' value='".$image2_big."' size='31' maxlength='255' />
    <img src='".XOOPS_URL."/images/image.gif' alt='image' onmouseover=style.cursor='hand' onclick='openWithSelfMain(\"".XOOPS_URL."/imagemanager.php?target=image2_big\",\"imgmanager2\",400,430);' />
</td></tr>
<tr><td nowrap='nowrap' class='bg3'>"._XD_YEAR." </td><td class='bg1'>
    <input type='text' name='year' value='$year' size='31' maxlength='255' />
</td></tr>
<tr><td nowrap='nowrap' class='bg3'>"._XD_SEAL." </td><td class='bg1'>
    <input type='text' name='seal' value='$seal' size='31' maxlength='255' />
</td></tr>
<tr><td nowrap='nowrap' class='bg3'>"._XD_URL_BUY." </td><td class='bg1'>
    <input type='text' name='url_buy' value='$url_buy' size='31' maxlength='250' />
</td></tr>
<tr><td nowrap='nowrap' class='bg3'>"._XD_COMMENT." </td><td class='bg1'>";

include_once XOOPS_ROOT_PATH."/include/xoopscodes.php";
xoopsCodeTarea("description", 60, 10);
xoopsSmilies("description");

echo "<tr><td nowrap='nowrap' class='bg3'>&nbsp;</td><td class='bg1'>
    <input type='hidden' name='id_art' value='".$id_art."' />
    <input type='hidden' name='id' value='".$id."' />
    <input type='hidden' name='op' value='$op' />
    <input type='submit' name='contents_submit' value='"._SUBMIT."' /></td></tr>
</table></td></tr></table>
</form>";

?>