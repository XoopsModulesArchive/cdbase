# phpMyAdmin MySQL-Dump
# version 2.4.0
# http://www.phpmyadmin.net/ (download page)
#
# Server: localhost
# Date: 04-05-2003 00:28:51
# Version: 3.23.54
# Version PHP: 4.3.0
# Version Xoops: Xoops 2.0
# --------------------------------------------------------

#
# Structure table for `cdbase_artists`
#

CREATE TABLE cdbase_artists (
  id_art int(10) unsigned NOT NULL auto_increment,
  artist varchar(255) default NULL,
  date_of_birth varchar(255) default NULL,
  place_of_birth varchar(255) default NULL,
  ethnic varchar(255) default NULL,
  bio text,
  image varchar(250) default NULL,
  dropcap varchar(3),
  dateadd int(10) default '0',
  genre int(11) unsigned default NULL,
  url varchar(250) default NULL,
  url_target varchar(5) default NULL,
  similar varchar(250) default NULL,
  gallery varchar(250) default NULL,
  gallery_desc varchar(250) default NULL,
  gallery_target varchar(5) default NULL,
  movies varchar(250) default NULL,
  movies_desc varchar(250) default NULL,
  movies_target varchar(5) default NULL,
  votes int(10) unsigned NOT NULL default '0',
  rating int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (id_art)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Structure table for `cdbase_discs`
#

CREATE TABLE cdbase_discs (
  id int(10) unsigned NOT NULL auto_increment,
  id_art int(10) unsigned default NULL,
  album varchar(255) default NULL,
  image varchar(150) default NULL,
  image_big varchar(150) NOT NULL default '',
  image2 varchar(150) NOT NULL default '',
  image2_big varchar(150) NOT NULL default '',
  year varchar(4) default NULL,
  seal varchar(50) default NULL,
  description text,
  dateadd int(10) default NULL,
  url_buy varchar(250) default NULL,
  votes int(10) unsigned NOT NULL default '0',
  rating int(10) unsigned NOT NULL default '0',
  PRIMARY KEY (id)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Structure table for `cdbase_gens`
#

CREATE TABLE cdbase_gens (
  id_gen int(11) unsigned NOT NULL auto_increment,
  des varchar(100) NOT NULL default '',
  PRIMARY KEY  (id_gen)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Base genre `cdbase_gens`
#

INSERT INTO cdbase_gens VALUES (1, 'General');

#
# Structure table for `cdbase_lyrics`
#

CREATE TABLE cdbase_lyrics (
  id int(10) unsigned NOT NULL auto_increment,
  id_disc int(10) unsigned NOT NULL default '0',
  id_art int(10) unsigned NOT NULL default '0',
  num int(10) unsigned NOT NULL default '0',
  title varchar(250) NOT NULL default '',
  text text NOT NULL,
  mp3 varchar(250) NOT NULL default '',
  PRIMARY KEY  (id),
  KEY id_disc (id_disc)
) TYPE=MyISAM;

