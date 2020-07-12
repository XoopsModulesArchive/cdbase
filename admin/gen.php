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
include_once "admin_header.php";

$op = "listgen";

if (isset($_GET)) {
    foreach ($_GET as $k => $v) {
        $$k = $v;
    }
}

if (isset($_POST)) {
    foreach ($_POST as $k => $v) {
        $$k = $v;
    }
}

if ($op == "listgen") {
    // página inicial, lista los artists y presenta el formulario de agregar artist
    $myts =& MyTextSanitizer::getInstance();
    xoops_cp_header();

    echo "
    <h4 style='text-align:left;'>"._XD_DOCS."</h4>
    <form action='gen.php' method='post'>
    <table border='0' cellpadding='0' cellspacing='0' width='60%'><tr><td class='bg2'>
    <table width='100%' border='0' cellpadding='4' cellspacing='1'>
    <tr class='bg3' align='center'><td align='left'>"._XD_GENS."</td>";
    //"<td>&nbsp;</td></tr>";
    $result = $xoopsDB->query("SELECT id_gen, des FROM ".$xoopsDB->prefix("cdbase_gens")." ORDER BY des ASC");
    $count = 0;
    while (list($id_gen, $des) = $xoopsDB->fetchRow($result) ) {
        $des=$myts->makeTboxData4Edit($des);
        echo "<tr class='bg1'><td align='left'>
               <input type='hidden' value='$id_gen' name='id_gen[]' />
               <input type='hidden' value='$des' name='olddes[]' />
               <input type='text' value='$des' name='newdes[]' maxlength='100' size='40' /></td>";
        //<td align='right'><a href='gen.php?op=delgen&amp;id_gen=".$id_gen."&amp;ok=0'>"._DELETE."</a></td></tr>";
        $count++;
    }
    if ($count > 0) {
        echo "<tr align='center' class='bg3'><td colspan='4'><input type='submit' value='"._SUBMIT."' /><input type='hidden' name='op' value='editgengo' /></td></tr>";
    }
    echo "</table></td></tr></table></form>
    <br /><br />
    <h4 style='text-align:left;'>"._XD_ADDGEN."</h4>
    <form action='gen.php' method='post'>
    <table border='0' cellpadding='0' cellspacing='0' width='100%'>
        <tr>
        <td class='bg2'>
            <table width='100%' border='0' cellpadding='4' cellspacing='1'>
                <tr nowrap='nowrap'>
                <td class='bg3'>"._XD_GENRE." </td>
                <td class='bg1'>
                    <input type='text' name='des' size='50' maxlength='50' />
                </td></tr>
                <tr>
                <td class='bg3'>&nbsp;</td>
                <td class='bg1'>
                    <input type='hidden' name='op' value='addgengo' />
                    <input type='submit' value='"._SUBMIT."' />
                </td></tr>
            </table>
        </td></tr>
    </table>
    </form>";

    xoops_cp_footer();
    exit();
}

if ($op == "addgengo") {
    // agregar artist
    $myts =& MyTextSanitizer::getInstance();
    $newid = $xoopsDB->genId($xoopsDB->prefix("cdbase_gens")."_id_gen_seq");
    $dateadd = time();
    $sql = "INSERT INTO ".$xoopsDB->prefix("cdbase_gens")."(id_gen, des) VALUES (".$newid.", '".$des."')";
    if (!$xoopsDB->query($sql)) {
        xoops_cp_header();
        echo "Could not add genegory";
        xoops_cp_footer();
    } else {
        redirect_header("gen.php?op=listgen",1,_XD_DBSUCCESS);
    }
    exit();
}

if ($op == "editgengo") {
    //editar genre
    $myts =& MyTextSanitizer::getInstance();
    $count = count($newdes);
    for ($i = 0; $i < $count; $i++) {
        if ( $newdes[$i] != $olddes[$i]) {
            $des = $myts->makeTboxData4Save($newdes[$i]);
            $sql = "UPDATE ".$xoopsDB->prefix("cdbase_gens")." SET des='".$des."' WHERE id_gen=".$id_gen[$i]."";
            $xoopsDB->query($sql);
        }
    }
    redirect_header("gen.php?op=listgen",1,_XD_DBSUCCESS);
    exit();
}

if ($op == "delgen") {
    // borrar genre
    //ojo, falta borrar en cascada artists y discos para que funcione
    if ($ok == 1) {
        $sql = "DELETE FROM ".$xoopsDB->prefix("cdbase_gens")." WHERE id_gen = $id_gen)";
        if (!$xoopsDB->query($sql)) {
            xoops_cp_header();
            echo "Could not delete genre";
            xoops_cp_footer();
        } else {
            redirect_header("gen.php?op=listgen",1,_XD_DBSUCCESS);
        }
        exit();
    } else {
        xoops_cp_header();
        xoops_confirm(array('op' => 'delgen', 'id_gen' => $id_art, 'ok' => 1), 'gen.php', _XD_RUSUREGEN);
        xoops_cp_footer();
        exit();
    }
}


?>