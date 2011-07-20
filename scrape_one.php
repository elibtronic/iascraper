<?php

include('config.php');
include('get_files.php');

//scrape_one.php
//Do a one off scrape of the inputed URL

	global $DEBUG,$GOOD_ITEMS,$BAD_ITEMS,$LE;
	
	if (!isset($_POST["url_go"])){
	
		if ($DEBUG)
			echo "Error - No input URL inputted for single scrape.".$LE;
		exit;
	}

	echo "Scraping single URL: ".$_POST["url_go"];
	
	$blist = load_blacklist();
	
	if (on_blacklist($_POST["url_go"],$blist)){
		echo " ...found on blacklist. ".$LE;
		exit;
	}

	if (check_if_dl($_POST["url_go"])){
		echo " ...already downloaded. ".$LE;
		exit;
		}

	if (download_data($_POST["url_go"])){
		//write_single_log($_POST["url_go"],$GOOD_ITEMS);
		echo " ...Completed. ".$LE;
	}
	else{
		//write_single_log($_POST["url_go"],$BAD_ITEMS);
		echo " ...Error Encountered. Item Logged. ".$LE;
	}
	?>
