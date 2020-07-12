<?php
// $Id: notification.inc.php,v 1.2 2003/03/16 22:39:47 w4z004 Exp $
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

// RMV-NOTIFY

// Get tags for notification emails

function item_info($category, $item_id)
{
    global $xoopsModule, $xoopsModuleConfig, $xoopsConfig;

    if (empty($xoopsModule) || $xoopsModule->getVar('dirname') != 'cdbase') {
        $module_handler =& xoops_gethandler('module');
        $module =& $module_handler->getByDirname('cdbase');
        $config_handler =& xoops_gethandler('config');
        $config =& $config_handler->getConfigsByCat(0,$module->getVar('mid'));
    } else {
        $module =& $xoopsModule;
        $config =& $xoopsModuleConfig;
    }

    include_once XOOPS_ROOT_PATH . '/modules/' . $module->getVar('dirname') . '/language/' . $xoopsConfig['language'] . '/main.php';

    if ($category=='global') {
        $item['name'] = '';
        $item['url'] = '';
        return $item;
    }

    global $xoopsDB;
    if ($category=='disc') {
        // Assume we have a valid forum id
        $sql = 'SELECT album FROM ' . $xoopsDB->prefix('cdbase_discs') . ' WHERE id_art = '.$item_id;
        $result = $xoopsDB->query($sql); // TODO: error check
        $result_array = $xoopsDB->fetchArray($result);
        $item['name'] = $result_array['album'];
        $item['url'] = XOOPS_URL . '/modules/' . $module->getVar('dirname') . '/index.php?id_art=' . $item_id;
        return $item;
    }
}
?>