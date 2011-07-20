<?php


//config.php for IA_Scraper

//If you want more output change to true
$DEBUG = true;

//The _l_ine _e_nd character can be specified here
//$LE = "\n"; //useful for analyzing with terminal, eg lynx
$LE = "<br>";  //useful for looking with a web browser

//installation directory
//trailing slash is needed
//might also be something like /var/www/ia_scraper/

$INSTALL_DIR = "";

//Where the saved data is to be kept
//trailing slash is needed
//should be chmod 777 so no permission problems crop up
$DATA_DIR = $INSTALL_DIR."./data/";

//The Web address of the data directory for viewing online 
$DISPLAY_DIR = "./data";

//Originally this was designed to only download Theses. (Or more specifically items that had the word 'thesis' in the description.
//Leave this set to only download an item that has $SEARCH_TERM in the description.
//Default behavior is to only download an item with the word 'Thesis' in the description, (using Grep Style notation)
//This check is only performed when the RSS Scraper runs.  Scraping one item or by bulk will not use this.
//$SEARCH_TERM = "";  //This will download everything
$SEARCH_TERM = '/Thesis/';

//BlackList File
//		any url that appears here will not be downloaded
//		somethings an item gets digitized and put on the Archive.org site and you have no intention of scraping it, put those items in this file
$BLACK_LIST_FILE = "./csv/blacklist.csv";


//Bulk Download File
//		If You Want to download a predefined set of items put them in this file
//		(one per line)
$BULK_CSV = "./csv/bulk.csv";

//RSS URL
//		For automatic harvesting using RSS, this URL will be used.  This link will be present on 
//		the Internet Archive page for your collection

$RSS_URL = "";

// Failure Log file
//		If the software examines a URL and it can't download it for some particular reason it will be logged
//		here, this doesn't log items that have already been downloaded
$BAD_ITEMS = "./csv/bad_items.csv";

// Success Log file
//		If the software can download the item it will make a record of it here
$GOOD_ITEMS = "./csv/downloaded.csv";


?>
