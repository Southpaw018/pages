<?php
$current = "";
$accuweather = new DOMDocument();
@$accuweather->loadHTMLFile("http://www.accuweather.com/en/us/takoma-park-md/20912/current-weather/2135463");
if ($accuweather->getElementById('detail-now')) {$current = $accuweather->saveXML($accuweather->getElementById('detail-now'));}
$current = str_replace("&#13;","",$current);
//$current = str_replace("src=\"/adc2010/images/icons-wind/","src=\"http://www.accuweather.com/adc2010/images/icons-wind/",$current);
echo($current);
?>
