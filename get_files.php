<?php

////
/// Does most of the heavy lifting
//
function download_data($url_in){

	global $DEBUG,$DATA_DIR;

	$html_data = file_get_contents($url_in);

	$dom = new DOMDocument();
	@$dom->loadHTML($html_data);
	$xpath = new DOMXPath($dom);


	$hrefs = $xpath->evaluate("/html/body//a");

	for ($i = 0; $i < $hrefs->length; $i++) {
		$href = $hrefs->item($i);
		$url = $href->getAttribute('href');
		if (preg_match('/^http:\/\//',$url))
			if (!preg_match('/^http:\/\/www/',$url)){
					$download_url = $url;
					break;
					}
	}

	ini_set('default_socket_timeout',    120);
	
	$document_name = substr(strrchr($url_in, ("/")),1);
	mkdir($DATA_DIR.$document_name);
	chmod($DATA_DIR.$document_name,0777);
	
	
	$epub_url = $download_url.strrchr($url_in,"/").".epub";
	$epub_file = file_get_contents($epub_url);
	$epub_file_local = fopen($DATA_DIR.$document_name."/".$document_name.".epub","w+");
	fwrite($epub_file_local, $epub_file);
	fclose($epub_file_local);
	chmod($DATA_DIR.$document_name."/".$document_name.".epub",0777);
	
	$meta_url = $download_url.strrchr($url_in,"/")."_dc.xml";
	$meta_file = file_get_contents($meta_url);
	$meta_file_local = fopen($DATA_DIR.$document_name."/".$document_name."_dc.xml","w+");
	fwrite($meta_file_local, $meta_file);
	fclose($meta_file_local);
	chmod($DATA_DIR.$document_name."/".$document_name."_dc.xml",0777);
	
	
	$pdf_url = $download_url.strrchr($url_in,"/").".pdf";
	$pdf_file_local = fopen($DATA_DIR.$document_name."/".$document_name.".pdf","w+");
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $pdf_url);
	curl_setopt($ch, CURLOPT_FILE, $pdf_file_local);
	$data = curl_exec($ch);
	fclose($pdf_file_local);
	chmod($DATA_DIR.$document_name."/".$document_name.".pdf",0777);


	
	return true;
	}

////
///  Before attempting to download the files this will check to see if it is already downloaded
//
	function check_if_dl($url_in) {

		global $DATA_DIR, $DEBUG, $LE;
	
		$document_name = substr(strrchr($url_in, ("/")),1);

		if (file_exists($DATA_DIR.$document_name) && 
		file_exists($DATA_DIR.$document_name."/".$document_name.".pdf") &&
		file_exists($DATA_DIR.$document_name."/".$document_name."_dc.xml")
		){
			if ($DEBUG)
				echo "  ***All files for: ".$document_name." already exist. ".$LE;
			return true;
		}
		
		return false;
	}	

////
///  Load Black List into memory
//
	function load_blacklist()  {
	
	global $INSTALL_DIR,$BLACK_LIST_FILE;
	
	$blist = fopen($INSTALL_DIR.$BLACK_LIST_FILE, "r");
	$b_array = array();
	do{
		$in = trim(fgets($blist));
		if($in != null)
			$b_array[]=$in;

	}
	while(!feof($blist));
	fclose($blist);
	
	return $b_array;
	}

////
///  Check url against Blacklist
//
	function on_blacklist($url_in, $blist){
	
	global $DEBUG,$LE;
	
		if(in_array($url_in,$blist)) {
			if ($DEBUG)
				echo $url_in." Found in Black List. ".$LE;
			return true;
			}
	return false;
	
	}

////
///  Simple Log file writer
//
	function write_single_log($url_in, $log_file){
	
		$lf = fopen($log_file,"a+");
		fwrite($lf,$url_in.",".date("Y M d : H:i:s")."\n");
		fclose($lf);
	}
?>
