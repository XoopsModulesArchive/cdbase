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

$op = "options";
$image_border = "";
$dropcap = "";

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


if ($op == "options") {
    xoops_cp_header();
    echo  "<h4 style='text-align:left;'>"._XD_DOCS."</h4>";
    OpenTable();

    echo " - <a href=index.php?op=listcat>"._CDBASE_MENU."</a>";
    echo "<br><br>";
    echo " - <a href=gen.php>"._CDBASE_GENS."</a>";
    echo "<br><br>";
    echo " - <a href='".XOOPS_URL.'/modules/system/admin.php?fct=preferences&amp;op=showmod&amp;mod='.$xoopsModule->getVar('mid')."'>"._CDBASE_GENERALCONF."</a>\n";

    CloseTable();
    xoops_cp_footer();
    exit();
}

if ($op == "listcat") {
    
    $myts =& MyTextSanitizer::getInstance();
    xoops_cp_header();

    echo "
    <h4 style='text-align:left;'>"._XD_DOCS."</h4>
    <table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td class='bg2'>
    <table width='100%' border='0' cellpadding='4' cellspacing='1'>
    <tr class='bg3' align='center'><td align='left'>"._XD_ARTIST."</td><td>&nbsp;</td></tr>";
    $result = $xoopsDB->query("SELECT id_art, artist FROM ".$xoopsDB->prefix("cdbase_artists")." ORDER BY artist ASC");
    while ( list($id_art, $artist) = $xoopsDB->fetchRow($result) ) {
        $artist=$myts->makeTboxData4Show($artist);
        echo "<tr class='bg1'><td align='left'><a href='index.php?op=listcontents&amp;id_art=".$id_art."'>" .$artist."</a></td>
        <td nowrap='nowrap' align='right'><a href='index.php?op=editcat&amp;id_art=".$id_art."'>" ._EDIT."</a> | <a href='index.php?op=delcat&amp;id_art=".$id_art."&amp;ok=0'>"._DELETE."</a></td></tr>";
    }
    echo "</table></td></tr></table>
    <br /><br />
    <h4 style='text-align:left;'>"._XD_ADDCAT."</h4>
    <form action='index.php' method='post'>
    <table border='0' cellpadding='0' cellspacing='0' width='100%'>
        <tr>
        <td class='bg2'>
            <table width='100%' border='0' cellpadding='4' cellspacing='1'>
                <tr nowrap='nowrap'>
                <td class='bg3'>"._XD_NAME." </td>
                <td class='bg1'>
                    <input type='text' name='artist' size='50' maxlength='255' />
                </td></tr>
				
				<tr nowrap='nowrap'>
                <td class='bg3'>"._XD_DOB." </td>
                <td class='bg1'>
                    <input type='text' name='date_of_birth' size='50' maxlength='255' />
                </td></tr>
				
				<tr nowrap='nowrap'>
                <td class='bg3'>"._XD_POB." </td>
                <td class='bg1'>
                    <input type='text' name='place_of_birth' size='50' maxlength='255' />
                </td></tr>
				
				<tr nowrap='nowrap'>
                <td class='bg3'>"._XD_ETHNIC." </td>
                <td class='bg1'>
                    <input type='text' name='ethnic' size='50' maxlength='255' />
                </td></tr>

                <tr nowrap='nowrap'>
                <td class='bg3'>"._XD_IMAGE." </td>
                <td class='bg1'>
                    <input type='text' name='image' size='50' maxlength='250' />
                    <img src='".XOOPS_URL."/images/image.gif' alt='image' onmouseover=style.cursor='hand' onclick='openWithSelfMain(\"".XOOPS_URL."/imagemanager.php?target=image\",\"imgmanager\",400,430);' />
                </td></tr>
				<tr nowrap='nowrap'>
                <td class='bg3'>"._XD_IMAGEBORDER." </td>
                <td class='bg1'>                    
					<select name='image_border' id='image_border'>";
					if ($image_border == "No") {
            			echo "<option value='No' selected='selected'>No</option>
            			<option value='Yes'>Yes</option>					
            			</select>"; 
					} else {
						echo "<option value='Yes' selected='selected'>Yes</option>
            			<option value='No'>No</option>
						</select>";
					}
                echo "</td></tr>
				<tr nowrap='nowrap'>
                <td class='bg3'>"._XD_DROPCAP." </td>
                <td class='bg1'>                    
					<select name='dropcap' id='dropcap'>";
					if ($dropcap == "No") {
            			echo "<option value='No' selected='selected'>No</option>
            			<option value='Yes'>Yes</option>					
            			</select>"; 
					} else {
						echo "<option value='Yes' selected='selected'>Yes</option>
            			<option value='No'>No</option>
						</select>";
					}
                echo "<tr nowrap='nowrap'>
                <td class='bg3'>"._XD_BIO." </td>
                <td class='bg1'>";

                include_once XOOPS_ROOT_PATH."/include/xoopscodes.php";
                xoopsCodeTarea("bio", 60, 10);
                xoopsSmilies("bio");

                echo "</td></tr>
                <tr nowrap='nowrap'>
                <td class='bg3'>"._XD_GENRE." </td>
                <td class='bg1'>

                <select name='genre'>";
                $sql = "SELECT id_gen, des FROM ".$xoopsDB->prefix("cdbase_gens");
                $result = $xoopsDB->query($sql);
                while ( list($id_gen, $des) = $xoopsDB->fetchRow($result) ) {
                        echo "<option value='$id_gen'>$des</option>";
                        }
                echo "</select>

                </td></tr>
                <tr nowrap='nowrap'>
                <td class='bg3'>"._XD_URL." </td>
                <td class='bg1'>
                    <input type='text' name='url' size='50' maxlength='255'/> Open in new window:&nbsp;
					<select name='url_target' id='url_target'>
            		<option selected='selected'>No</option>
            		<option value='_blank'>Yes</option>
            		</select>
                </td></tr>

                <tr nowrap='nowrap'>
                <td class='bg3'>"._XD_GALLERY." </td>
                <td class='bg1'>                    
                    <input type='text' name='gallery' size='50' maxlength='250'/> Open in new window:&nbsp;
					<select name='gallery_target' id='gallery_target'>
            		<option selected='selected'>No</option>
            		<option value='_blank'>Yes</option>
            		</select>
                </td></tr>

                <tr nowrap='nowrap'>
                <td class='bg3'>"._XD_MOVIES." </td>
                <td class='bg1'>                    
                    <input type='text' name='movies' size='50' maxlength='250'/> Open in new window:&nbsp;
					<select name='movies_target' id='movies_target'>
            		<option selected='selected'>No</option>
            		<option value='_blank'>Yes</option>
            		</select>
                </td></tr>

                <tr nowrap='nowrap'>
                <td class='bg3'>"._XD_SIMILAR." </td>
                <td class='bg1'>
                    <input type='text' name='similar' size='50' maxlength='255' />
                </td></tr>

                <tr>
                <td class='bg3'>&nbsp;</td>
                <td class='bg1'>
                    <input type='hidden' name='op' value='addcatgo' />
                    <input type='submit' value='"._SUBMIT."' />
                </td></tr>
            </table>
        </td></tr>
    </table>
    </form>";

    xoops_cp_footer();
    exit();
}

if ($op == "editcat") {
    // editar artist
    $myts =& MyTextSanitizer::getInstance();
    xoops_cp_header();

    $sql = "SELECT artist FROM ".$xoopsDB->prefix("cdbase_artists")." WHERE id_art='".$id_art."'";
    $result = $xoopsDB->query($sql);
    list($artist) = $xoopsDB->fetchRow($result);
    $artist = $myts->makeTboxData4Show($artist);

    echo "<a href='index.php'>" ._XD_MAIN."</a>&nbsp;<span style='font-weight:bold;'>
    &raquo;&raquo;</span>&nbsp;".$artist."
    <br /><br />";

    $result = $xoopsDB->query("SELECT id_art, artist, image, image_border, bio, date_of_birth, place_of_birth, ethnic, genre, url, url_target, similar, gallery, gallery_desc, gallery_target, movies, movies_desc, movies_target, dropcap
                               FROM ".$xoopsDB->prefix("cdbase_artists")." WHERE id_art = ".$id_art);
    list($id_art, $artist, $image, $image_border, $bio, $date_of_birth, $place_of_birth, $ethnic, $genre, $url, $url_target, $similar, $gallery, $gallery_desc, $gallery_target, $movies, $movies_desc, $movies_target, $dropcap ) = $xoopsDB->fetchRow($result);
    $artist=$myts->makeTboxData4Edit($artist);
    $image=$myts->makeTboxData4Edit($image);
    $bio=$myts->makeTareaData4Edit($bio);
	$date_of_birth=$myts->makeTareaData4Edit($date_of_birth);
	$place_of_birth=$myts->makeTareaData4Edit($place_of_birth);
	$ethnic=$myts->makeTareaData4Edit($ethnic);
    $genre=$myts->makeTboxData4Edit($genre);
    $url=$myts->makeTboxData4Edit($url);
	$url_target=$myts->makeTboxData4Edit($url_target);
    $similar=$myts->makeTboxData4Edit($similar);
    $gallery=$myts->makeTboxData4Edit($gallery);
    $gallery_desc=$myts->makeTboxData4Edit($gallery_desc);
	$gallery_target=$myts->makeTboxData4Edit($gallery_target);
    $movies=$myts->makeTboxData4Edit($movies);
    $movies_desc=$myts->makeTboxData4Edit($movies_desc);
	$movies_target=$myts->makeTboxData4Edit($movies_target);

    echo "<h4 style='text-align:left;'>"._XD_EDITCAT."</h4>
    <form action='index.php' method='post'>
    <table border='0' cellpadding='0' cellspacing='0' width='100%'>
        <tr>
        <td class='bg2'>
            <table width='100%' border='0' cellpadding='4' cellspacing='1'>
                <tr nowrap='nowrap'>
                <td class='bg3'>"._XD_NAME." </td>
                <td class='bg1'>
                    <input type='text' name='artist' size='50' maxlength='255' value='$artist'/>
                </td></tr>
				
				<tr nowrap='nowrap'>
                <td class='bg3'>"._XD_DOB." </td>
                <td class='bg1'>
                    <input type='text' name='date_of_birth' size='50' maxlength='255' value='$date_of_birth'/>
                </td></tr>
				
				<tr nowrap='nowrap'>
                <td class='bg3'>"._XD_POB." </td>
                <td class='bg1'>
                    <input type='text' name='place_of_birth' size='50' maxlength='255' value='$place_of_birth'/>
                </td></tr>
				
				<tr nowrap='nowrap'>
                <td class='bg3'>"._XD_ETHNIC." </td>
                <td class='bg1'>
                    <input type='text' name='ethnic' size='50' maxlength='255' value='$ethnic'/>
                </td></tr>
				
                <tr nowrap='nowrap'>
                <td class='bg3'>"._XD_IMAGE." </td>
                <td class='bg1'>
                    <input type='text' name='image' size='50' maxlength='250' value='$image'/>
                    <img src='".XOOPS_URL."/images/image.gif' alt='image' onmouseover=style.cursor='hand' onclick='openWithSelfMain(\"".XOOPS_URL."/imagemanager.php?target=image\",\"imgmanager\",400,430);' />
                </td></tr>
				<tr nowrap='nowrap'>
                <td class='bg3'>"._XD_IMAGEBORDER." </td>
                <td class='bg1'>                    
					<select name='image_border' id='image_border'>";
					if ($image_border == "No") {
            			echo "<option value='No' selected='selected'>No</option>
            			<option value='Yes'>Yes</option>					
            			</select>"; 
					} else {
						echo "<option value='Yes' selected='selected'>Yes</option>
            			<option value='No'>No</option>
						</select>";
					}
                echo "</td></tr>
				<tr nowrap='nowrap'>
                <td class='bg3'>"._XD_DROPCAP." </td>
                <td class='bg1'>                    
					<select name='dropcap' id='dropcap'>";
					if ($dropcap == "No") {
            			echo "<option value='No' selected='selected'>No</option>
            			<option value='Yes'>Yes</option>					
            			</select>"; 
					} else {
						echo "<option value='Yes' selected='selected'>Yes</option>
            			<option value='No'>No</option>
						</select>";
					}
                echo "</td></tr>           
                <tr nowrap='nowrap'>
                <td class='bg3'>"._XD_BIO." </td>
                <td class='bg1'>";

                include_once XOOPS_ROOT_PATH."/include/xoopscodes.php";
                xoopsCodeTarea("bio", 60, 10);
                xoopsSmilies("bio");

                echo "</td></tr>
                <tr nowrap='nowrap'>
                <td class='bg3'>"._XD_GALLERY." </td>
                <td class='bg1'>                    
                    <input type='text' name='gallery' size='50' maxlength='250' value='".$gallery."'/> Open in new window:&nbsp;
					<select name='gallery_target' id='gallery_target'>";
					if ($gallery_target == "No") {
            			echo "<option value='No' selected='selected'>No</option>
            			<option value='Yes'>Yes</option>					
            			</select>"; 
					} else {
						echo "<option value='Yes' selected='selected'>Yes</option>
            			<option value='No'>No</option>
						</select>";
					}
					
                echo "</td></tr>
                <tr nowrap='nowrap'>
                <td class='bg3'>"._XD_MOVIES." </td>
                <td class='bg1'>                   
                    <input type='text' name='movies' size='50' maxlength='250' value='".$movies."'/> Open in new window:&nbsp;
					<select name='movies_target' id='movies_target'>";
					if ($movies_target == "No") {
            			echo "<option value='No' selected='selected'>No</option>
            			<option value='Yes'>Yes</option>					
            			</select>"; 
					} else {
						echo "<option value='Yes' selected='selected'>Yes</option>
            			<option value='No'>No</option>
						</select>";
					}
                echo "</td></tr>
				<tr nowrap='nowrap'>
                <td class='bg3'>"._XD_URL." </td>
                <td class='bg1'>
                    <input type='text' name='url' size='50' maxlength='255' value='$url'/> Open in new window:&nbsp;
					<select name='url_target' id='url_target'>";
					if ($url_target == "No") {
            			echo "<option value='No' selected='selected'>No</option>
            			<option value='Yes'>Yes</option>					
            			</select>"; 
					} else {
						echo "<option value='Yes' selected='selected'>Yes</option>
            			<option value='No'>No</option>
						</select>";
					}
                echo "</td></tr>
                <tr nowrap='nowrap'>
                <td class='bg3'>"._XD_SIMILAR." </td>
                <td class='bg1'>
                    <input type='text' name='similar' size='50' maxlength='255' value='$similar'/>
                </td></tr>
                <tr nowrap='nowrap'>
                <td class='bg3'>"._XD_GENRE." </td>
                <td class='bg1'>
                    <select name='genre'>";

    $sql = "SELECT id_gen, des FROM ".$xoopsDB->prefix("cdbase_gens");
    $result = $xoopsDB->query($sql);
    while ( list($id_gen, $des) = $xoopsDB->fetchRow($result) ) {
            $sel = "";
            if ($genre == $id_gen) $sel = "selected='selected'";
            echo "<option value='$id_gen' $sel>$des</option>";
    }
    echo "</select>  </td></tr>                
                <tr>
                <td class='bg3'>&nbsp;</td>
                <td class='bg1'>
                    <input type='hidden' name='op' value='editcatgo' />
                    <input type='hidden' name='id_art' value='$id_art' />
                    <input type='submit' value='"._SUBMIT."' />
                </td></tr>
            </table>
        </td></tr>
    </table>
    </form>";

    xoops_cp_footer();
    exit();
}


if ($op == "addcatgo") {
    // agregar artist
    $myts =& MyTextSanitizer::getInstance();
    $newid = $xoopsDB->genId($xoopsDB->prefix("cdbase_artists")."_id_art_seq");
    $dateadd = time();
    $sql = "INSERT INTO ".$xoopsDB->prefix("cdbase_artists").
            " (id_art, artist, image, image_border, bio, date_of_birth, place_of_birth, ethnic, dateadd, genre, url, url_target, similar, gallery, gallery_desc, gallery_target, movies, movies_desc, movies_target, dropcap)
            VALUES (".$newid.", '".$artist."', '".$image."', '".$image_border."', '".$bio."', '".$date_of_birth."', '".$place_of_birth."', '".$ethnic."', ".$dateadd.", '".$genre."', '".$url."', '".$url_target."','".$similar."', '".$gallery."', '".$gallery_desc."', '".$gallery_target."', '".$movies."', '".$movies_desc."', '".$movies_target."', '".$dropcap."')";
    if (!$xoopsDB->query($sql)) {
        xoops_cp_header();
        echo "Could not add category";
        xoops_cp_footer();
    } else {
        //notification new artist
        $extra_tags = array();
        $extra_tags['ARTIST_URL'] = XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/index.php?id_art=' . $id_art;
        $extra_tags['ARTIST_NAME'] = $artist;
        $notification_handler =& xoops_gethandler("notification");
        $notification_handler->triggerEvent ("global", $id_art, "new_artist", $extra_tags=array());
        redirect_header("index.php?op=listcat",1,_XD_DBSUCCESS);
    }
    exit();
}

if ($op == "editcatgo") {
    //editar artist
    $myts =& MyTextSanitizer::getInstance();
    $artist = $myts->makeTboxData4Save($artist);
    $image = $myts->makeTboxData4Save($image);
    $bio = $myts->makeTareaData4Save($bio);
	$date_of_birth = $myts->makeTareaData4Save($date_of_birth);
	$place_of_birth = $myts->makeTareaData4Save($place_of_birth);
	$ethnic = $myts->makeTareaData4Save($ethnic);
    $genre = $myts->makeTboxData4Save($genre);
    $url = $myts->makeTboxData4Save($url);
	$url_target = $myts->makeTboxData4Save($url_target);
    $similar = $myts->makeTboxData4Save($similar);
    $sql = "UPDATE ".$xoopsDB->prefix("cdbase_artists")." SET artist='".$artist."',image='".$image."', image_border='".$image_border."', date_of_birth='".$date_of_birth."', place_of_birth='".$place_of_birth."', ethnic='".$ethnic."', bio='".$bio."', genre='".$genre."', url='".$url."', url_target='".$url_target."', similar='".$similar."', gallery='".$gallery."', gallery_desc='".$gallery_desc."', gallery_target='".$gallery_target."', movies='".$movies."', movies_desc='".$movies_desc."', movies_target='".$movies_target."', dropcap='".$dropcap."' WHERE id_art=".$id_art."";
    $xoopsDB->query($sql);
    redirect_header("index.php?op=listcat",1,_XD_DBSUCCESS);
    exit();
}

if ($op == "delcat") {
    // borrar artist
    if ($ok == 1) {
        $sql = sprintf("DELETE FROM %s WHERE id_art = %u", $xoopsDB->prefix("cdbase_artists"), $id_art);
        if (!$xoopsDB->query($sql)) {
            xoops_cp_header();
            echo "Could not delete category";
            xoops_cp_footer();
        } else {
            $sql = sprintf("DELETE FROM %s WHERE id_art = %u", $xoopsDB->prefix("cdbase_discs"), $id_art);
            $xoopsDB->query($sql);
            // delete comments
            xoops_comment_delete($xoopsModule->getVar("mid"), $id_art);
            // delete notifications
            xoops_notification_deletebyitem ($xoopsModule->getVar("mid"), "global", $id_art);
            xoops_notification_deletebyitem ($xoopsModule->getVar("mid"), "disc", $id_art);
            redirect_header("index.php?op=listcat",1,_XD_DBSUCCESS);
        }
        exit();
    } else {
        xoops_cp_header();
        xoops_confirm(array('op' => 'delcat', 'id_art' => $id_art, 'ok' => 1), 'index.php', _XD_RUSURECAT);
        xoops_cp_footer();
        exit();
    }
}

if ($op == "listcontents") {
    // listar discos de un artist
    $myts =& MyTextSanitizer::getInstance();
    xoops_cp_header();
    $sql = "SELECT artist FROM ".$xoopsDB->prefix("cdbase_artists")." WHERE id_art='".$id_art."'";
    $result = $xoopsDB->query($sql);
    list($artist) = $xoopsDB->fetchRow($result);
    $artist = $myts->makeTboxData4Show($artist);

    echo "<a href='index.php'>" ._XD_MAIN."</a>&nbsp;<span style='font-weight:bold;'>&raquo;&raquo;</span>&nbsp;".$artist."<br /><br />
    <h4 style='text-align:left;'>"._XD_CONTENTS."</h4>
    <table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td class='bg2'>
    <table width='100%' border='0' cellpadding='4' cellspacing='1'>
    <tr class='bg3'>
        <td>"._XD_ALBUM."</td>
        <td align='center'>"._XD_IMAGE."</td>
        <td align='center'>"._XD_YEAR."</td>
        <td align='center'>"._XD_SEAL."</td>
        <td>&nbsp;</td>
        </tr>";

    $sql = "SELECT id, album, image, year, seal, url_buy FROM ".$xoopsDB->prefix("cdbase_discs")." WHERE id_art='".$id_art."' ORDER BY year";
    $result = $xoopsDB->query($sql);

    while(list($id, $album, $image, $year, $seal, $url_buy) = $xoopsDB->fetchRow($result)) {
        $image = $myts->displayTarea($image, 0, 0, 1, 1);
        echo "<tr class='bg1'>
        <td><a href='index.php?op=listlyrics&amp;id_disc=".$id."&amp;id_art=".$id_art."'>".$album."</a></td>
        <td align='center'>".$image."</td>
        <td align='center'>".$year."</td>
        <td align='center'>".$seal."</td>
        <td align='right'>
            <a href='index.php?op=editcontents&amp;id=".$id."&amp;id_art=".$id_art."'>"._EDIT."</a> |
            <a href='index.php?op=delcontents&amp;id=".$id."&amp;ok=0&amp;id_art=".$id_art."'>"._DELETE."</a>
        </td></tr>";
    }
    echo "</table></td></tr></table>
    <br /><br />
    <h4 style='text-align:left;'>"._XD_ADDCONTENTS."</h4>";
    $contents_title = "";
    $contents_contents = "";
    $contents_order = 0;
    $contents_visible = 1;
    $contents_nohtml = 0;
    $contents_nosmiley = 0;
    $contents_noxcode = 0;
    $contents_id = 0;
    $artist_id = $id_art;
    $op = "addcontentsgo";
    include "contentsform.php";

    xoops_cp_footer();
    exit();
}

if ($op == "addcontentsgo") {
    // agregar disco
    $myts =& MyTextSanitizer::getInstance();
    $album = $myts->makeTboxData4Save($album);
    $image = $myts->makeTboxData4Save($image);
    $image2 = $myts->makeTboxData4Save($image2);
    $image_big = $myts->makeTboxData4Save($image_big);
    $image2_big = $myts->makeTboxData4Save($image2_big);
    $year = $myts->makeTboxData4Save($year);
    $seal = $myts->makeTboxData4Save($seal);
    $description = $myts->makeTareaData4Save($description);
    $url_buy = $myts->makeTboxData4Save($url_buy);
    $dateadd = time();
    $newid = $xoopsDB->genId($xoopsDB->prefix("cdbase_discs")."_id_seq");
    $sql = "INSERT INTO ".$xoopsDB->prefix("cdbase_discs")." (id, id_art, album, image, image_big, image2, image2_big, year, description, seal, dateadd, url_buy) VALUES (".$newid.", ".$id_art.", '".$album."', '".$image."', '".$image_big."', '".$image2."', '".$image2_big."', '".$year."', '".$description."', '".$seal."', ".$dateadd.", '".$url_buy."')";
    if (!$xoopsDB->query($sql)) {
        xoops_cp_header();
        echo "Could not add content";
        xoops_cp_footer();
    } else {
        //notification new disc
        $extra_tags = array();
        $extra_tags['ARTIST_URL'] = XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/index.php?id_art=' . $id_art;
        $extra_tags['DISC_NAME'] = $album;
        $sql = "SELECT artist FROM ".$xoopsDB->prefix("cdbase_artists")." WHERE id_art='".$id_art."'";
        $result = $xoopsDB->query($sql);
        list($artist) = $xoopsDB->fetchRow($result);
        $extra_tags['ARTIST_NAME'] = $artist;
        $notification_handler =& xoops_gethandler("notification");
        $notification_handler->triggerEvent ("disc", $id_art, "new_disc", $extra_tags=array());
        redirect_header("index.php?op=listcontents&amp;id_art=$id_art",1,_XD_DBSUCCESS);
    }
    exit();
}

if ($op == "editcontents") {
    // editar disco
    $myts =& MyTextSanitizer::getInstance();
    xoops_cp_header();

    $sql = "SELECT artist FROM ".$xoopsDB->prefix("cdbase_artists")." WHERE id_art='".$id_art."'";
    $result = $xoopsDB->query($sql);
    list($category) = $xoopsDB->fetchRow($result);
    $artist = $myts->makeTboxData4Show($category);

    $result = $xoopsDB->query("SELECT * FROM ".$xoopsDB->prefix("cdbase_discs")." WHERE id='$id'");
    $myrow = $xoopsDB->fetchArray($result);
    $album = $myts->makeTboxData4Edit($myrow['album']);
    $description = $myts->makeTareaData4Edit($myrow['description']);
    $year = $myrow['year'];
    $seal = $myts->makeTboxData4Edit($myrow['seal']);
    $image = $myts->makeTboxData4Edit($myrow['image']);
    $image2 = $myts->makeTboxData4Edit($myrow['image2']);
    $image_big = $myts->makeTboxData4Edit($myrow['image_big']);
    $image2_big = $myts->makeTboxData4Edit($myrow['image2_big']);
    $url_buy = $myts->makeTboxData4Edit($myrow['url_buy']);
    $id = $myrow['id'];
    $id_art = $myrow['id_art'];
    $op = "editcontentsgo";

    echo "<a href='index.php'>" ._XD_MAIN."</a>&nbsp;<span style='font-weight:bold;'>
    &raquo;&raquo;</span>&nbsp;<a href='index.php?op=listcontents&amp;id_art=$id_art'>".$category."</a>&nbsp;
    <span style='font-weight:bold;'>&raquo;&raquo;</span>&nbsp;"._XD_EDITCONTENTS."<br /><br />
    <h4 style='text-align:left;'>"._XD_EDITCONTENTS."</h4>";
    include "contentsform.php";

    xoops_cp_footer();
    exit();
}

if ($op == "editcontentsgo") {
    // guardar disco editado
    $myts =& MyTextSanitizer::getInstance();
    $album = $myts->makeTboxData4Save($album);
    $image = $myts->makeTboxData4Save($image);
    $image2 = $myts->makeTboxData4Save($image2);
    $image_big = $myts->makeTboxData4Save($image_big);
    $image2_big = $myts->makeTboxData4Save($image2_big);
    $year = $myts->makeTboxData4Save($year);
    $seal = $myts->makeTboxData4Save($seal);
    $description = $myts->makeTareaData4Save($description);
    $url_buy = $myts->makeTboxData4Save($url_buy);
    $sql = "UPDATE ".$xoopsDB->prefix("cdbase_discs")." SET album='".$album."', image='".$image."', image2='".$image2."', image_big='".$image_big."', image2_big='".$image2_big."', year='".$year."', seal='".$seal."', description='".$description."', url_buy='".$url_buy."' WHERE id=".$id."";
    if (!$xoopsDB->query($sql)) {
        xoops_cp_header();
        echo "Could not update contents";
        xoops_cp_footer();
    } else {
        redirect_header("index.php?op=listcontents&amp;id_art=$id_art",1,_XD_DBSUCCESS);
    }
    exit();
}

if ($op == "delcontents") {
    // borrar disco
    if ($ok == 1) {
        $sql = "DELETE FROM ".$xoopsDB->prefix("cdbase_discs")." WHERE id=".$id;
        if (!$xoopsDB->query($sql)) {
            xoops_cp_header();
            echo "Could not delete contents";
            xoops_cp_footer();
        } else {
            redirect_header("index.php?op=listcontents&amp;id_art=$id_art",1,_XD_DBSUCCESS);
        }
        exit();
    } else {
        xoops_cp_header();
        xoops_confirm(array('op' => 'delcontents', 'id' => $id, 'id_art' => $id_art, 'ok' => 1), 'index.php', _XD_RUSUREDISC);
        xoops_cp_footer();
        exit();
    }
}

if ($op == "listlyrics") {
    // listar letras de un disco
    $myts =& MyTextSanitizer::getInstance();
    xoops_cp_header();
    $sql = "SELECT artist FROM ".$xoopsDB->prefix("cdbase_artists")." WHERE id_art='".$id_art."'";
    $result = $xoopsDB->query($sql);
    list($artist) = $xoopsDB->fetchRow($result);
    $artist = $myts->makeTboxData4Show($artist);

    $sql = "SELECT album FROM ".$xoopsDB->prefix("cdbase_discs")." WHERE id='".$id_disc."'";
    $result = $xoopsDB->query($sql);
    list($album) = $xoopsDB->fetchRow($result);
    $album = $myts->makeTboxData4Show($album);

    echo "<a href='index.php'>" ._XD_MAIN."</a>&nbsp;<span style='font-weight:bold;'>
    &raquo;&raquo;</span>&nbsp;<a href='index.php?op=listcontents&amp;id_art=$id_art'>".$artist."</a>
    <span style='font-weight:bold;'>&raquo;&raquo;</span>&nbsp;".$album."
    <br /><br />

    <h4 style='text-align:left;'>"._XD_LYRICS."</h4>

    <table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td class='bg2'>
    <table width='100%' border='0' cellpadding='4' cellspacing='1'>
    <tr class='bg3'>
        <td>"._XD_NUM."</td>
        <td align='center'>"._XD_TITLE."</td>
        <td>&nbsp;</td>
        </tr>";

    $sql = "SELECT id, title, text, num FROM ".$xoopsDB->prefix("cdbase_lyrics")." WHERE id_disc='".$id_disc."' ORDER BY num";
    $result = $xoopsDB->query($sql);
	$c = 0;
    while(list($id, $title, $text, $num) = $xoopsDB->fetchRow($result)) {
        $c = $num;
        echo "<tr class='bg1'>
        <td align='left'>".$num."</td>
        <td align='left'>".$title."</td>
        <td align='right'>
            <a href='index.php?op=editlyrics&amp;id=".$id."&amp;id_disc=".$id_disc."&amp;id_art=".$id_art."'>"._EDIT."</a> |
            <a href='index.php?op=dellyrics&amp;id=".$id."&amp;ok=0&amp;id_disc=".$id_disc."&amp;id_art=".$id_art."'>"._DELETE."</a>
        </td></tr>";
    }
    $c++;
    echo "</table></td></tr></table>
    <br /><br />
    <h4 style='text-align:left;'>"._XD_ADDLYRICS."</h4>

    <form action='index.php' method='post'>
    <table border='0' cellpadding='0' cellspacing='0' width='100%'>
        <tr>
        <td class='bg2'>
            <table width='100%' border='0' cellpadding='4' cellspacing='1'>
                <tr nowrap='nowrap'>
                <td class='bg3'>"._XD_TITLE." </td>
                <td class='bg1'>
                    <input type='text' name='title' size='50' maxlength='255' />
                </td></tr>

                <tr nowrap='nowrap'>
                <td class='bg3'>"._XD_NUM." </td>
                <td class='bg1'>
                    <input type='text' name='num' size='10' maxlength='4' value='$c'/>
                </td></tr>

                <tr nowrap='nowrap'>
                <td class='bg3'>"._XD_TEXT." </td>
                <td class='bg1'>
                    <textarea name='text' cols='20' rows='20'></textarea>
                </td></tr>

                <tr>
                <td class='bg3'>&nbsp;</td>
                <td class='bg1'>
                    <input type='hidden' name='op' value='addlyricsgo' />
                    <input type='hidden' name='id_art' value='".$id_art."' />
                    <input type='hidden' name='id_disc' value='".$id_disc."' />
                    <input type='submit' value='"._SUBMIT."' />
                </td></tr>
            </table>
        </td></tr>
    </table>
    </form>";

    echo "<br /><br />
    <h4 style='text-align:left;'>"._XD_ADD_TITLES_ONLY."</h4>

    <form action='index.php' method='post'>
    <table border='0' cellpadding='0' cellspacing='0' width='100%'>
        <tr>
        <td class='bg2'>
            <table width='100%' border='0' cellpadding='4' cellspacing='1'>";

    for($i=1; $i<=30; $i++) {
    echo "<tr nowrap='nowrap'><td class='bg3'>"._XD_TITLE." ".$i." </td><td class='bg1'>
                  <input type='text' name='title[]' size='50' maxlength='255' /></td></tr>";
    }

    echo "<tr>
                <td class='bg3'>&nbsp;</td>
                <td class='bg1'>
                    <input type='hidden' name='op' value='addtitlesgo' />
                    <input type='hidden' name='id_art' value='".$id_art."' />
                    <input type='hidden' name='id_disc' value='".$id_disc."' />
                    <input type='submit' value='"._SUBMIT."' />
                </td></tr>
          </table></td></tr></table></form>";

    xoops_cp_footer();
    exit();
}

if ($op == "addlyricsgo") {
    
    $myts =& MyTextSanitizer::getInstance();
    $title = $myts->makeTboxData4Save($title);
    $num = $myts->makeTboxData4Save($num);
    $text = $myts->makeTareaData4Save($text);
    $newid = $xoopsDB->genId($xoopsDB->prefix("cdbase_lyrics")."_id_seq");
    $sql = "INSERT INTO ".$xoopsDB->prefix("cdbase_lyrics")." (id, id_art, id_disc, title, text, num) VALUES (".$newid.", ".$id_art.", ".$id_disc.", '".$title."', '".$text."', '".$num."')";
    if (!$xoopsDB->query($sql)) {
        xoops_cp_header();
        echo "Could not add content";
        xoops_cp_footer();
    } else {
        redirect_header("index.php?op=listlyrics&amp;id_art=$id_art&amp;id_disc=$id_disc",1,_XD_DBSUCCESS);
    }
    exit();
}

if ($op == "editlyrics") {
    
    $myts =& MyTextSanitizer::getInstance();
    xoops_cp_header();
    $sql = "SELECT artist FROM ".$xoopsDB->prefix("cdbase_artists")." WHERE id_art='".$id_art."'";
    $result = $xoopsDB->query($sql);
    list($category) = $xoopsDB->fetchRow($result);
	
    $artist = $myts->makeTboxData4Show($category);

    $sql = "SELECT album FROM ".$xoopsDB->prefix("cdbase_discs")." WHERE id=".$id_disc;
    $result = $xoopsDB->query($sql);
    list($album) = $xoopsDB->fetchRow($result);
    $album = $myts->makeTboxData4Show($album);

    $result = $xoopsDB->query("SELECT * FROM ".$xoopsDB->prefix("cdbase_lyrics")." WHERE id='$id'");
    $myrow = $xoopsDB->fetchArray($result);
    $title = $myts->makeTboxData4Edit($myrow['title']);
    $text = $myts->makeTareaData4Edit($myrow['text']);
    $num = $myrow['num'];
    $id = $myrow['id'];
    $id_art = $myrow['id_art'];

    echo "<a href='index.php'>" ._XD_MAIN."</a>
           &nbsp;<span style='font-weight:bold;'>&raquo;&raquo;</span>&nbsp;<a href='index.php?op=listcontents&amp;id_art=$id_art'>".$category."</a>
           &nbsp;<span style='font-weight:bold;'>&raquo;&raquo;</span>&nbsp;<a href='index.php?op=listlyrics&amp;id_art=$id_art&amp;id_disc=$id_disc'>".$album."</a>
           &nbsp;<span style='font-weight:bold;'>&raquo;&raquo;</span>&nbsp;"._XD_EDITLYRICS."<br /><br />
    <h4 style='text-align:left;'>"._XD_EDITLYRICS."</h4>
    <form action='index.php' method='post'>
    <table border='0' cellpadding='0' cellspacing='0' width='100%'>
        <tr>
        <td class='bg2'>
            <table width='100%' border='0' cellpadding='4' cellspacing='1'>
                <tr nowrap='nowrap'>
                <td class='bg3'>"._XD_TITLE." </td>
                <td class='bg1'>
                    <input type='text' name='title' size='50' maxlength='255' value='$title'/>
                </td></tr>

                <tr nowrap='nowrap'>
                <td class='bg3'>"._XD_NUM." </td>
                <td class='bg1'>
                    <input type='text' name='num' size='10' maxlength='4' value='$num'/>
                </td></tr>

                <tr nowrap='nowrap'>
                <td class='bg3'>"._XD_TEXT." </td>
                <td class='bg1'>
                    <textarea name='text' cols='20' rows='20'>$text</textarea>
                </td></tr>

                <tr>
                <td class='bg3'>&nbsp;</td>
                <td class='bg1'>
                    <input type='hidden' name='op' value='editlyricsgo' />
                    <input type='hidden' name='id' value='".$id."' />
                    <input type='hidden' name='id_art' value='".$id_art."' />
                    <input type='hidden' name='id_disc' value='".$id_disc."' />
                    <input type='submit' value='"._SUBMIT."' />
                </td></tr>
            </table>
        </td></tr>
    </table>
    </form>";

    xoops_cp_footer();
    exit();
}

if ($op == "editlyricsgo") {
    // guardar letra editada
    $myts =& MyTextSanitizer::getInstance();
    $title = $myts->makeTboxData4Save($title);
    $num = $myts->makeTboxData4Save($num);
    $text = $myts->makeTareaData4Save($text);
    $sql = "UPDATE ".$xoopsDB->prefix("cdbase_lyrics")." SET title='".$title."', text='".$text."', num=".$num." WHERE id=".$id;
    if (!$xoopsDB->query($sql)) {
        xoops_cp_header();
        echo "Could not update lyrics";
        xoops_cp_footer();
    } else {
        redirect_header("index.php?op=listlyrics&amp;id_art=$id_art&amp;id_disc=$id_disc",1,_XD_DBSUCCESS);
    }
    exit();
}

if ($op == "addtitlesgo") {
    // agregar letras en masa
    $myts =& MyTextSanitizer::getInstance();
    $num=0;
    foreach ($title as $tit)
    {
    $num++;
        if (!empty($tit)) {
            $tit = $myts->makeTboxData4Save($tit);
            $newid = $xoopsDB->genId($xoopsDB->prefix("cdbase_lyrics")."_id_seq");
            $sql = "INSERT INTO ".$xoopsDB->prefix("cdbase_lyrics")." (id, id_art, id_disc, title, num) VALUES (".$newid.", ".$id_art.", ".$id_disc.", '".$tit."', '".$num."')";
            if (!$xoopsDB->query($sql)) {
                xoops_cp_header();
                echo "Could not add content";
                xoops_cp_footer();
            }
        }
    }
    redirect_header("index.php?op=listlyrics&amp;id_art=$id_art&amp;id_disc=$id_disc",1,_XD_DBSUCCESS);
    exit();
}


if ($op == "dellyrics") {
    // borrar letra
    if ($ok == 1) {
        $sql = "DELETE FROM ".$xoopsDB->prefix("cdbase_lyrics")." WHERE id=".$id;
        if (!$xoopsDB->query($sql)) {
            xoops_cp_header();
            echo "Could not delete lyrics";
            xoops_cp_footer();
        } else {
            redirect_header("index.php?op=listlyrics&amp;id_art=$id_art&amp;id_disc=$id_disc",1,_XD_DBSUCCESS);
        }
        exit();
    } else {
        xoops_cp_header();
        xoops_confirm(array('op' => 'dellyrics', 'id' => $id, 'id_art' => $id_art, 'id_disc' => $id_disc, 'ok' => 1), 'index.php', _XD_RUSURELYRIC);
        xoops_cp_footer();
        exit();
    }
}
?>