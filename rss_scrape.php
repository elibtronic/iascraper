<?php

//rss_scrape.php
//runs the automatic harvest of IA with the designated RSS feed

include_once('config.php');
include_once('get_files.php');

echo "\nRunning RSS IA Scraper. ".$LE;

if (!isset($RSS_URL)){
	echo "RSS URL has not been set. ".$LE;
	exit;
}


$rss_url_c = curl_init($RSS_URL);
curl_setopt($rss_url_c, CURLOPT_RETURNTRANSFER, true);
curl_setopt($rss_url_c, CURLOPT_HEADER, 0);
$rss_data = curl_exec($rss_url_c);
curl_close($rss_url_c);
$rss_xml = new SimpleXmlElement($rss_data, LIBXML_NOCDATA);

$blist = load_blacklist();

//iterate through whole RSS file
$cnt = count($rss_xml->channel->item);

for($i=0; $i < $cnt; $i++)
{
	//Relevant items from feed
	$url = $rss_xml->channel->item[$i]->link;
		echo $LE."Item number $i - Processing: ".$url;
	
	//if it has been downloaded jump to next item
	 if(check_if_dl($url)){
		echo " ...already downloaded. ".$LE;
		continue;
		}
		
	//If no particular search term is set download everything
	if (!isset($SEARCH_TERM) || $SEARCH_TERM == "")
	{
	
			if (!on_blacklist($url,$blist)) {
					//Attempt and Check all in one
					if (!download_data($url)) {
						write_single_log($url,$INSTALL_DIR.$BAD_RSS_ITEMS);
						echo " ...error encounter. Item logged. ".$LE;
					}
					else {
						write_single_log($url,$INSTALL_DIR.$GOOD_ITEMS);
						echo "...done. ".$LE;
					}
				}
			continue;
	}
	else if (preg_match($SEARCH_TERM,$rss_xml->channel->item[$i]->description))
	{
			
			if (!on_blacklist($url,$blist)) {
						
					//Attempt and Check all it one
					if (!download_data($url)) {
						write_single_log($url,$INSTALL_DIR.$BAD_RSS_ITEMS);
						echo " ...error encounter. Item logged. ".$LE;
					}
					else {
						write_single_log($url,$INSTALL_DIR.$GOOD_ITEMS);
						echo "...done. ".$LE;
					}
				}
	}
				
	else
	{
	write_single_log($url, $INSTALL_DIR.$BAD_ITEMS);
	if($DEBUG)
		echo "... Item not recognized.  Logged in $INSTALL_DIR.$BAD_ITEMS".$LE.$LE;
	}

}

echo $LE."RSS Scrape Complete";

?>