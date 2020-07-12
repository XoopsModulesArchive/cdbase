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

include 'header.php';

if ( file_exists(XOOPS_ROOT_PATH."/modules/cdbase/language/".$xoopsConfig['language']."/main.php") ) {
    include_once XOOPS_ROOT_PATH."/modules/cdbase/language/".$xoopsConfig['language']."/main.php";
} else {
    include_once XOOPS_ROOT_PATH."/modules/cdbase/language/english/main.php";
}

$id_art = "";
$art_alb = "";
$id_lyric = "";

$myts =& MyTextSanitizer::getInstance();
$id_art = isset($_GET['id_art']) ? intval($_GET['id_art']) : 0;
$art_alb = isset($_GET['art_alb']) ? intval($_GET['art_alb']) : 0;
$id_lyric = isset($_GET['id_lyric']) ? intval($_GET['id_lyric']) : NULL;

if ($id_art < 1 && $id_lyric == NULL) {
    // this page uses smarty template
    // this must be set before including main header.php
    $xoopsOption['template_main'] = 'cdbase_index.html';
    if ($xoopsConfig['startpage'] == 'cdbase') {
        $xoopsOption['show_rblock'] = 1;
        include XOOPS_ROOT_PATH.'/header.php';
        make_cblock();
    } else {
        $xoopsOption['show_rblock'] = 0;
        include XOOPS_ROOT_PATH.'/header.php';
    }
    $xoopsTpl->assign('intro', $xoopsModuleConfig['intro']);
    $xoopsTpl->assign('lang_cdbase', _XD_DOCS);
    $xoopsTpl->assign('lang_categories', _XD_CATEGORIES);
    $result2 = $xoopsDB->query('SELECT id_gen, des FROM '.$xoopsDB->prefix('cdbase_gens').' ORDER BY des');
	while (list($id_gen, $des) = $xoopsDB->fetchRow($result2)) {
        $genres = array();
        $genres['des'] = $des;
		$genres['artists'] = "";
        $hay = 0;
        $myCount = 0;
        $result = $xoopsDB->query('SELECT id_art, artist, image, image_border, dateadd FROM '.$xoopsDB->prefix('cdbase_artists').' WHERE genre='.$id_gen.' ORDER BY artist ASC');
        while (list($id_art, $artist, $image, $image_border, $dateadd) = $xoopsDB->fetchRow($result)) {
			$path_url = parse_url($image);
			$url_path = XOOPS_ROOT_PATH . $path_url['path'];
			$imageThumbSize = getimagesize($url_path);
			
			$imageThumbSize[0] = 100;
			$imageThumbSize[1] = 100;
            if ($myCount < 4) {
                $new = "";
                $startdate = (time()-(43200 * 7));
                if ($startdate < $dateadd) {
                    $new = " <img src='".XOOPS_URL."/modules/cdbase/images/new.gif'>";
                }
            
                if ($new == "") {
                    $result3 = $xoopsDB->query('SELECT id_art FROM '.$xoopsDB->prefix('cdbase_discs').' WHERE id_art = '.$id_art.' AND dateadd >='.$startdate);
                    list ($x) =  $xoopsDB->fetchRow($result3);
                    if (!empty($x)){
                        $new = " <img src='".XOOPS_URL."/modules/cdbase/images/update.gif'>";
                    }
                }
                
                if (!empty($image)) {
                    if ($image_border == 'Yes') {
                        $genres['artists'] .= "<td align='center'><p><a href='index.php?id_art=$id_art'><img src='$image' width='$imageThumbSize[0]' height='$imageThumbSize[1]' class='thinbordermain'></p>$artist</a>  $new</td>";
                    } else {
                        $genres['artists'] .= "<td align='center'><p><a href='index.php?id_art=$id_art'><img src='$image' width='$imageThumbSize[0]' height='$imageThumbSize[1]'></p>$artist</a>  $new</td>";
                    }
                } else {
                    $genres["artists"] .= "<td align='center'><a href='index.php?id_art=$id_art'>$artist</a>  $new</td>";
                }
                $hay = 1;
                $myCount++;
            } else {
                $genres['artists'] .= "</tr><tr>";
                if (!empty($image)) {
                    if ($image_border == 'Yes') {
                        $genres['artists'] .= "<td align='center'><a href='index.php?id_art=$id_art'><img src='$image' width='$imageThumbSize[0]' height='$imageThumbSize[1]' class='thinbordermain'><br />$artist</a>  $new</td>";
                    } else {
                        $genres['artists'] .= "<td align='center'><a href='index.php?id_art=$id_art'><img src='$image' width='$imageThumbSize[0]' height='$imageThumbSize[1]'><br />$artist</a>  $new</td>";
                    }
                } else {
                    $genres['artists'] .= "<td align='center'><a href='index.php?id_art=$id_art'>$artist</a>  $new</td>";
                }
                $myCount = 0;                
            }
        }
        
        if ($hay==1) $xoopsTpl->append_by_ref('genres', $genres);
        unset($genres);
    }



} else {

    if ($art_alb == 0 and $id_lyric == NULL) {
    	// this page uses smarty template
    	// this must be set before including main header.php
    	$xoopsOption['template_main'] = 'cdbase_artist.html';
    	if ($xoopsConfig['startpage'] == 'cdbase') {
            $xoopsOption['show_rblock'] = 1;
            include XOOPS_ROOT_PATH.'/header.php';
            make_cblock();
    	} else {
            $xoopsOption['show_rblock'] = 0;
            include XOOPS_ROOT_PATH.'/header.php';
    	}
	
		$websiteURL = _XD_URL;
		$galleryURL = _XD_GALLERY;
		$albumsURL = _XD_ALBUM;
	
    	$xoopsTpl->assign('lang_cdbase', _XD_DOCS);
    	$xoopsTpl->assign('lang_artist', _XD_ARTIST);
    	$xoopsTpl->assign('lang_bio', _XD_BIO);	
		$xoopsTpl->assign('lang_dob', _XD_DOB);
		$xoopsTpl->assign('lang_pob', _XD_POB);
		$xoopsTpl->assign('lang_ethnic',_XD_ETHNIC);
    	$xoopsTpl->assign('lang_main', _XD_MAIN);
    	$xoopsTpl->assign('lang_backtotop', _XD_BACKTOTOP);
    	$xoopsTpl->assign('lang_backtoindex', _XD_BACKTOINDEX);
   		$xoopsTpl->assign('lang_genre', _XD_GENRE);
    	$xoopsTpl->assign('lang_url', _XD_URL);
    	$xoopsTpl->assign('lang_similar', _XD_SIMILAR);
    	$xoopsTpl->assign('lang_album', _XD_ALBUM);
    	$xoopsTpl->assign('lang_year', _XD_YEAR);
    	$xoopsTpl->assign('lang_seal', _XD_SEAL);
    	$xoopsTpl->assign('lang_tracks', _XD_SONGS);
    	$xoopsTpl->assign('lang_movies', _XD_MOVIES);
		$xoopsTpl->assign('lang_sim_artist', _XD_SIM_ARTIST);

    	$result = $xoopsDB->query('SELECT artist, image, image_border, date_of_birth, place_of_birth, ethnic, bio, genre, url, url_target, similar, gallery, gallery_desc, gallery_target, movies, movies_desc, movies_target, dropcap FROM '.$xoopsDB->prefix('cdbase_artists').' WHERE id_art='.$id_art);
    	list($artist, $image_art, $img_border, $date_of_birth, $place_of_birth, $ethnic, $bio, $genre, $url, $url_target, $similar, $gallery, $gallery_desc, $gallery_target, $movies, $movies_desc, $movies_target, $dropcap) = $xoopsDB->fetchRow($result);
    	$xoopsTpl->assign('artist', $myts->makeTboxData4Show($artist));
		$path_url = parse_url($image_art);
		$url_path = XOOPS_ROOT_PATH . $path_url['path'];	
		$imageSize = getimagesize($url_path);
		
        if (!empty($image_art)) { 
			if ($img_border == "Yes") {
		    	$imageArt = "<img src='$image_art' class='thinborder' alt='$artist' width='$imageSize[0]' height='$imageSize[1]' hspace='10' vspace='10' align='left' />"; 
		    	$xoopsTpl->assign('image_art', $imageArt);
			} else {
		    	$imageArt = "<img src='$image_art' alt='$artist' width='$imageSize[0]' height='$imageSize[1]' hspace='10' vspace='10' align='left' />";
		    	$xoopsTpl->assign('image_art', $imageArt);
			}
        }
		
		if ($dropcap == "Yes") {
		    $descDropcap = $artist{0};
		    $artist = substr($artist, 1, strlen($artist));
		    $descDropcap = "<span class='dropcap'>$descDropcap</span>$artist";
		    $xoopsTpl->assign('descDropcap', $descDropcap);
		    $xoopsTpl->assign('bio', $myts->makeTareaData4Show($bio, 0, 1, 1));
		} else {
		    $descDropcap = "$artist";
		    $xoopsTpl->assign('descDropcap', $descDropcap);
		    $xoopsTpl->assign('bio', $myts->makeTareaData4Show($bio, 0, 1, 1));
		}
		
    	//$xoopsTpl->assign('image_art', $myts->displayTarea($image_art, 0, 0, 1, 1));	
		$xoopsTpl->assign('date_of_birth', $myts->makeTboxData4Show($date_of_birth));
		$xoopsTpl->assign('place_of_birth', $myts->makeTboxData4Show($place_of_birth));
		$xoopsTpl->assign('ethnic', $myts->makeTboxData4Show($ethnic));
    	
	
		$xoopsTpl->assign('movies_target', $movies_target);
	
		if ($movies !== "") {
		
            if ($movies_target == "No") {
				$moviesURL = "<a href='$movies'>"._XD_MOVIES."</a>";				
				$xoopsTpl->assign('movies',$moviesURL);
	    	} else {
				$moviesURL = "<a href='$movies' target='_blank'>"._XD_MOVIES."</a>";
				$xoopsTpl->assign('movies',$moviesURL);
	    	}
		} else {
	    	$xoopsTpl->assign('movies',"");
		}
		
		if ($gallery !== "") {
	    	if ($gallery_target == "No") {
				$xoopsTpl->assign('gallery', "<a href='".$gallery."'>".$galleryURL."</a>");
	    	} else {
				$xoopsTpl->assign('gallery', "<a href='".$gallery."' target='_blank'>".$galleryURL."</a>");
	    	}
		} else {
	    	$xoopsTpl->assign('gallery', "");
		}	
			
		if ($url !== "") {
	    	if ($url_target == "No") {
				$xoopsTpl->assign('url', "<a href='".$url."'>".$websiteURL."</a>");
	    	} else {
				$xoopsTpl->assign('url', "<a href='".$url."' target='_blank'>".$websiteURL."</a>");
	    	}
		} else {
	    	$xoopsTpl->assign('url', "");
		}
	    
    	$xoopsTpl->assign('similar', $myts->makeTareaData4Show($similar));

    	$result3 = $xoopsDB->query('SELECT des FROM '.$xoopsDB->prefix('cdbase_gens').' WHERE id_gen='.$genre);
    	list($des) = $xoopsDB->fetchRow($result3);
    	$xoopsTpl->assign('genre', $myts->makeTboxData4Show($des));

    	if (!empty($gallery_desc)) {
            $gallery = $myts->makeTboxData4Show($gallery);
	    if($gallery_target == 'blank') {
        	$gallery = "<a href='".$gallery."' target='_blank'>".$gallery_desc."</a>";
	    } else {
		$gallery = "<a href='".$gallery."'>".$gallery_desc."</a>";
	    }
            $xoopsTpl->assign('gallery', $gallery);
    	}
		
    	if (!empty($movies_desc)) {
            $movies = $myts->makeTboxData4Show($movies);
            if($movies_target == 'blank') {
        		$movies = "<a href='".$movies."' target='_blank'>".$movies_desc."</a>";
            } else {
				$movies = "<a href='".$movies."'>".$movies_desc."</a>";
	    	}
	    	$xoopsTpl->assign('movies', $movies);
        } 
		
		$sql = "SELECT id FROM ".$xoopsDB->prefix('cdbase_discs')." WHERE id_art=".$id_art." ";  
		$result = $xoopsDB->query($sql);
		$albumsFound = $xoopsDB->getRowsNum($result);
        
		if ($albumsFound !== 0) {			
	    	$xoopsTpl->assign('albums', "<a href='index.php?id_art=$id_art&art_alb=1'>$albumsURL</a>");			
		} else {
	    	$xoopsTpl->assign('albums', "");
		}
		
	//$xoopsTpl->append('discs', $disc);	
        
    } elseif ($art_alb == 0 and $id_lyric !== "") {
        
        $xoopsOption['template_main'] = 'cdbase_lyric.html';
        if ($xoopsConfig['startpage'] == 'cdbase') {
            $xoopsOption['show_rblock'] = 1;
            include XOOPS_ROOT_PATH.'/header.php';
            make_cblock();
        } else {
            $xoopsOption['show_rblock'] = 0;
            include XOOPS_ROOT_PATH.'/header.php';
        }
        
        $artist = $_GET['artist'];
        $album = $_GET['album'];
        
        $myts =& MyTextSanitizer::getInstance();
                
        $lyrics_result = $xoopsDB->query('SELECT id, num, title, text FROM '.$xoopsDB->prefix('cdbase_lyrics').' WHERE id='.$id_lyric);
        $lyrics_result2 = $xoopsDB->query('SELECT id_art, image_border FROM '.$xoopsDB->prefix('cdbase_artists')." WHERE artist='$artist'");
        $lyrics_result3 = $xoopsDB->query('SELECT id, image FROM '.$xoopsDB->prefix('cdbase_discs')." WHERE album='$album'");
        
        list($id, $num, $title, $text) = $xoopsDB->fetchRow($lyrics_result);
        list($id_art, $image_border) = $xoopsDB->fetchRow($lyrics_result2);
        list($art_alb, $image) = $xoopsDB->fetchRow($lyrics_result3);
        
        $albumPath = "<a href='index.php?id_art=$id_art&art_alb=$art_alb'>"._XD_ALBUM."</a>";
		        
        if (!empty($image)) {
			$path_url = parse_url($image);
			$url_path = XOOPS_ROOT_PATH . $path_url['path'];
        	$imageThumbSize = getimagesize($url_path);
            if ($image_border == 'Yes') {
                $image = "<img src='$image' class='thinborder' alt='$artist' width='$imageThumbSize[0]' height='$imageThumbSize[1]'>";
            } else {
                $image = "<img src='$image' width='$imageThumbSize[0]' height='$imageThumbSize[1]'>";
            }
        }
        
        $xoopsTpl->assign('art_alb', $art_alb);
        $xoopsTpl->assign('id_art', $id_art);
        $xoopsTpl->assign('title', $myts->makeTboxData4Show($title));        
        $xoopsTpl->assign('text', $myts->makeTareaData4Show($text));
        $xoopsTpl->assign('artist', $artist);
        $xoopsTpl->assign('albumPath', $albumPath);
        $xoopsTpl->assign('album', $album);
        $xoopsTpl->assign('image', $image);
        $xoopsTpl->assign('lang_main', _XD_MAIN);
        
    } else {
        
		$xoopsOption['template_main'] = 'cdbase_album.html';
    	if ($xoopsConfig['startpage'] == 'cdbase') {
            $xoopsOption['show_rblock'] = 1;
            include XOOPS_ROOT_PATH.'/header.php';
            make_cblock();
    	} else {
            $xoopsOption['show_rblock'] = 0;
            include XOOPS_ROOT_PATH.'/header.php';
    	}
        
        $disc = array();
        
        
    	$sql = "SELECT id, album, image, image_big, image2, image2_big, year, seal, description, url_buy FROM ".$xoopsDB->prefix('cdbase_discs')." WHERE id_art=".$id_art." ORDER BY year ";
		$result2 = $xoopsDB->query('SELECT artist, image_border FROM '.$xoopsDB->prefix('cdbase_artists').' WHERE id_art='.$id_art);	
    	$result = $xoopsDB->query($sql);
        list($artist, $img_border) = $xoopsDB->fetchRow($result2);
        
        $xoopsTpl->assign('artist', $myts->makeTboxData4Show($artist));
        $xoopsTpl->assign('id_art', $myts->makeTboxData4Show($id_art));
        $xoopsTpl->assign('lang_album_path', _XD_ALBUM);
        $xoopsTpl->assign('lang_main', _XD_MAIN);
        
        while (list($id_disc, $album, $image, $image_big, $image2, $image2_big, $year, $seal, $description, $url_buy) = $xoopsDB->fetchRow($result)) {
            
            $album = $myts->makeTboxData4Show($album);
            $disc['album'] = $album;
            $path_url = parse_url($image);
			$url_path = XOOPS_ROOT_PATH . $path_url['path'];
            $imageThumbSize = getimagesize($url_path);
            
            if (empty($image_big)) {
                if (!empty($image)) {
                    if ($img_border == 'Yes') {
                        $disc['image'] = "<img src='$image' class='thinborder' alt='$artist' width='$imageThumbSize[0]' height='$imageThumbSize[1]'>";
                    } else {
                        $disc['image'] = "<img src='$image' width='$imageThumbSize[0]' height='$imageThumbSize[1]'>";
                    }
                }
            } else {
                if (!empty($image)) {
                    if ($img_border == 'Yes') {
                        $disc['image'] = "<a href='javascript:;' onclick='openWithSelfMain(\"".XOOPS_URL."/modules/cdbase/cover.php?image=".$image_big."\",\"cover\",420,430)'><img src='$image' class='thinborder' alt='$artist' width='$imageThumbSize[0]' height='$imageThumbSize[1]'></a>";
                    } else {
                        $disc['image'] = "<a href='javascript:;' onclick='openWithSelfMain(\"".XOOPS_URL."/modules/cdbase/cover.php?image=".$image_big."\",\"cover\",420,430)'><img src='$image' alt='$artist' width='$imageThumbSize[0]' height='$imageThumbSize[1]'></a>";
                    }
                }
            }
	
        
        
        //$image2 = $myts->displayTarea($image2, 0, 0, 1, 1);
        //if (empty($image2_big)) {
        //    $disc['image2'] = $image2;
        //} else {
        //    $disc['image2'] = "<a href='javascript:;' onclick='openWithSelfMain(\"".XOOPS_URL."/modules/cdbase/cover.php?image=".$image2_big."\",\"cover\",420,430)'>".$image2."</a>";
        //}
        
        $disc['id_art'] = $id_art;
        $disc['year'] = $year;
        $seal = $myts->makeTboxData4Show($seal);
        $disc['seal'] = $seal;
        $disc['description'] = $myts->makeTareaData4Show($description, 0, 1, 1);
        $url_buy = $myts->makeTboxData4Show($url_buy);
        if (strlen($url_buy)>7) {
            $disc['url_buy'] = "<a href='".$url_buy."' target='_blank'>"._XD_URL_BUY."</a>";
        }
        $result2 = $xoopsDB->query('SELECT id, num, title, text FROM '.$xoopsDB->prefix('cdbase_lyrics').' WHERE id_disc='.$id_disc.' ORDER BY num');
        $disc['lists'] = "";
		
        while (list($id, $num, $title, $text) = $xoopsDB->fetchRow($result2)) {
            $title = $myts->makeTboxData4Show($title);
			
            if (strlen($text) > 5) {
            $disc['lists'] .= $num.". <a href='index.php?id_lyric=".$id."&artist=".$artist."&album=".$album."'>".$title."</a><br />";
            
	    } else {
            	$disc['lists'] .= $num.". ".$title."<br />";
            }
			
	    
        }
        $xoopsTpl->assign('lang_year', _XD_YEAR);
    	$xoopsTpl->assign('lang_seal', _XD_SEAL);
        $xoopsTpl->assign('lang_tracks', _XD_TRACKS);
        $xoopsTpl->append('discs', $disc);
        }
        
    }
    include XOOPS_ROOT_PATH.'/include/comment_view.php';
    }

include XOOPS_ROOT_PATH.'/footer.php';
?>
