<?php
//  ------------------------------------------------------------------------ //
//                    Discography Dabase Module for                          //
//               XOOPS - PHP Content Management System 2.0                   //
//                            Versión 1.2                                    //
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

function cdbase_search($queryarray, $andor, $limit, $offset, $userid)
{
    global $xoopsDB;
    $ret = array();
    if ( $userid != 0 ) {
        return $ret;
    }
    $dis = $xoopsDB->prefix("cdbase_discs");
    $art = $xoopsDB->prefix("cdbase_artists");
    $lyr = $xoopsDB->prefix("cdbase_lyrics");

    $sql = "SELECT ".$dis.".id_art, ".$dis.".album, ".$art.".artist, ".$lyr.".title "
                    . "FROM ".$dis.", ".$art.", ".$lyr
                    ." WHERE ((".$art.".id_art = ".$dis.".id_art) AND (".$art.".id_art = ".$lyr.".id_art))";
    // because count() returns 1 even if a supplied variable
    // is not an array, we must check if $querryarray is really an array
    $count = count($queryarray);
    if ( $count > 0 && is_array($queryarray) ) {
        $sql .= "AND ((album LIKE '%$queryarray[0]%' OR artist LIKE '%$queryarray[0]%') ";
        for ( $i = 1; $i < $count; $i++ ) {
            $sql .= " $andor ";
            $sql .= "(album LIKE '%$queryarray[$i]%' OR artist LIKE '%$queryarray[$i]%')";
        }
        $sql .= ") ";
    }
    $sql .= "ORDER BY id_art DESC";
    $result = $xoopsDB->query($sql,$limit,$offset);
    $i = 0;
     while ( $myrow = $xoopsDB->fetchArray($result) ) {
        $ret[$i]['image'] = "images/cd.gif";
        $ret[$i]['link'] = "index.php?id_art=".$myrow['id_art'];
        $ret[$i]['title'] = $myrow['artist'].": ".$myrow['album'];
        $ret[$i]['time'] = "";
        //$ret[$i]['uid'] = $myrow['contents_uid'];
        $i++;
    }
    return $ret;
}
?>