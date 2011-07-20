<?php

//bulk_file_get.php
//By providing a CSV file with the URLS this will download all the required elements

include_once('config.php');
include_once('get_files.php');

echo "Running Bulk IA Scraper with file: ".$INSTALL_DIR.$BULK_CSV." ".$LE;

$blist = load_blacklist();

$bf = fopen($INSTALL_DIR.$BULK_CSV,"r");

while (!feof($bf)) {
	
	$process = trim(fgets($bf));
	
	if ($process == NULL || $process == "")
		continue;
		
	//if it has been downloaded jump to next item
	 if(check_if_dl($process)){
		echo $process." ...already downloaded.".$LE;
		continue;
		}
			
		if (!on_blacklist($process,$blist)) {
						
				//Attempt and Check all it one
				if (!download_data($process)) {
					write_single_log($process,$INSTALL_DIR.$BAD_RSS_ITEMS);
					echo $process. " ...error downloading, item logged.".$LE;
				}
				else {
					write_single_log($process,$INSTALL_DIR.$GOOD_ITEMS);
					echo $process. " ...done.".$LE;
				}
				
		}		

	
}

echo "\n<br> Bulk Scrape Completed!";

?>