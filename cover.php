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
$image = $_GET['image'];
//$image = substr($image, 5);
//$image = substr($image, 0, (strlen($image)-6));
echo "<IMG SRC='".$image."' WIDTH='380' HEIGHT='380' ALT='"._XD_RESIZED."'><BR />";
echo "<DIV ALIGN='center'>".$xoopsConfig['sitename']." (".XOOPS_URL.")</DIV>";

?>