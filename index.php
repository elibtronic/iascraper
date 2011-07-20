<HTML>
<HEAD><Title>Internet Archive Scraper v0.7</Title></HEAD>
<BODY>

<?php 

include("config.php");

?>
<div style="margin-left:auto; margin-right:auto; width: 700px; border-style: solid; border-width: 2px; padding:5px;">
<H2>Internet Archive Scrapper</H2>
<A href='view_scraped.php'>View Scraped</A><br>
<A href='bulk_get_file.php'>Bulk Scrap</A><br>
<A href='rss_scrape.php'>Force Run of RSS Scrape</A><br>

<form name="scrape_one" method="post" action="scrape_one.php">
<p>Scrape One URL:</p>
<input type="text"  name="url_go" size="60" value="http://www.archive.org/details/grandlodge1857onta"></input>
<input type="submit" value="scrape"></input>
</form>
<P>Suggested RSS Cron Settings:<br>
<font face="courier" size="2">
* 0,2,4,6,8,10,12,14,16,18,20,22 * * * /usr/local/bin/php <?php echo getcwd() ?>/rss_scrape.php
</font>
</P>
<p>RSS URL:<br><em><font size="2"><?php echo $RSS_URL?></font></em></p>
</div>

</BODY>
</HTML>
