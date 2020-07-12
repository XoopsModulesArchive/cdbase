<?php
// $Id: comment_delete.php,v 1.1 2003/01/29 03:18:28 w4z004 Exp $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
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

function last_disc_show() {
    global $xoopsDB;
    $block = array();
    $myts =& MyTextSanitizer::getInstance();
    $sql = "SELECT id_art, album, seal, image FROM ".$xoopsDB->prefix("cdbase_discs")." ORDER BY id DESC LIMIT 1";
    $result = $xoopsDB->query($sql);
    list($id_art, $album, $seal, $image) = $xoopsDB->fetchRow($result);
    $album = $myts->makeTboxData4Show($album);
    $seal = $myts->makeTboxData4Show($seal);
    $image = $myts->displayTarea($image, 0, 0, 1, 1);

    $sql = "SELECT artist FROM ".$xoopsDB->prefix("cdbase_artists")." WHERE id_art='".$id_art."'";
    $result = $xoopsDB->query($sql);
    list($artist) = $xoopsDB->fetchRow($result);
    $artist = $myts->makeTboxData4Show($artist);

    $block['image']=$image;
    $block['label']=$seal;
    $block['artist']=$artist;
    $block['disc']=$album;
    $block['id_art']=$id_art;
    return $block;
}
?>