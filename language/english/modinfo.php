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
// Module Info
// The name of this module
define("_CDBASE_NAME","Discography");

// A brief description of this module
define("_CDBASE_DESC","CD Manager");

// Names of admin menu items
define("_CDBASE_MENU","Disc Manager");
define("_CDBASE_GENS","Genre Manager");
define("_CDBASE_GENERALCONF","Preferences");

// Names of blocks for this module (Not all module has blocks)
define("_CDBASE_BNAME","Discographic News");
define("_CDBASE_BDESC","Shows the last disc added");

// Notification event descriptions and mail templates
define ('_CB_DISC_NOTIFY', 'Disc');
define ('_CB_DISC_NOTIFYDSC', 'Notification options to individual artist.');

define ('_CB_GLOBAL_NOTIFY', 'Global');
define ('_CB_GLOBAL_NOTIFYDSC', 'Global Notification options.');

define ('_CB_DISC_NEWPOST_NOTIFY', 'New Disc');
define ('_CB_DISC_NEWPOST_NOTIFYCAP', 'Notify to me when a new disc is published.');
define ('_CB_DISC_NEWPOST_NOTIFYDSC', 'Receive a notification when a new disc is added to this artist.');
define ('_CB_DISC_NEWPOST_NOTIFYSBJ', '[{X_SITENAME}] New published discs."');

define ('_CB_GLOBAL_ARTIST_NEW_NOTIFY', 'New Artist');
define ('_CB_GLOBAL_ARTIST_NEW_NOTIFYCAP', 'Notify to me when a new artist is added.');
define ('_CB_GLOBAL_ARTIST_NEW_NOTIFYDSC', 'Receive a notification when a new artist is added.');
define ('_CB_GLOBAL_ARTIST_NEW_NOTIFYSBJ', '[{X_SITENAME}] New Artist"');

//General configuration
define ('_CDBASE_INTRO', 'Intro');
define ('_CDBASE_INTRO_DESC', 'Intro text that shows in the first public page of the module');

?>
