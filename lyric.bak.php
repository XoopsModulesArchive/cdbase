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

include "header.php";

if ( file_exists(XOOPS_ROOT_PATH."/modules/cdbase/language/".$xoopsConfig['language']."/main.php") ) {
    include_once XOOPS_ROOT_PATH."/modules/cdbase/language/".$xoopsConfig['language']."/main.php";
} else {
    include_once XOOPS_ROOT_PATH."/modules/cdbase/language/english/main.php";
}

require_once XOOPS_ROOT_PATH.'/class/template.php';
$xoopsTpl = new XoopsTpl();

$myts =& MyTextSanitizer::getInstance();
$id_art = isset($_GET['id_art']) ? intval($_GET['id_art']) : 0;
if ($id_art < 1) {

    $xoopsTpl->assign('close', _XD_CLOSE);

    $result2 = $xoopsDB->query('SELECT id, num, title, text FROM '.$xoopsDB->prefix('cdbase_lyrics').' WHERE id='.$id_lyric);
    while (list($id, $num, $title, $text) = $xoopsDB->fetchRow($result2)) {
            $title = $myts->makeTboxData4Show($title);
            $xoopsTpl->assign('title', $title);
            $text = $myts->makeTareaData4Show($text);
            $xoopsTpl->assign('text', $text);
            $xoopsTpl->assign('artist', $artist);
            $xoopsTpl->assign('album', $album);
            $xoopsTpl->assign('toprint', _CDBASE_TOPRINT);
            $xoopsTpl->assign('tomail', _CDBASE_TOMAIL);
            $mailto = "mailto:?subject=Letra de Canción en ".$xoopsConfig['sitename']."&amp;
                       body=He encontrado esta letra en ".$xoopsConfig['sitename']." ";
            $xoopsTpl->assign('mail_link', $mailto);
            $xoopsTpl->assign('css1', XOOPS_ROOT_PATH."/xoops.css");
            $xoopsTpl->assign('css2', XOOPS_ROOT_PATH."/themes/".$xoopsConfig['theme_set']."/style.css");
            $xoopsTpl->assign('poweredby', $xoopsConfig['sitename']." (".$xoopsConfig['xoops_url'].")");
    }
}
$xoopsTpl->display('db:cdbase_lyric.html');
?>