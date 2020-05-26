<?php
$url='https://www.avito.ru/items/phone/1870699661?pkey=643a70c4818ac390816a30e2499155e1&vsrc=r';
$useragent = 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/'.rand(60,72).'.0.'.rand(1000,9999).'.121 Safari/537.36';
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
$page = curl_exec($ch);
//$html=str_get_html($page);
curl_close($ch);
sleep($time_sleep);
echo $page;
?>
