<?php
function Curl_avito($phone_url,$time_sleep)
{
$useragent = 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/'.rand(60,72).'.0.'.rand(1000,9999).'.121 Safari/537.36';
$ch = curl_init($phone_url);
curl_setopt($ch, CURLOPT_URL, $phone_url);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
$page = curl_exec($ch);
curl_close($ch);
sleep($time_sleep);
//$check_2=strpos($page,'user_unauth');
//$check_3=strpos($page,'image64');
//if($check_2!==false or $check_3!==false){ continue; }
//else { echo 'ban'; exit;}
return $page;
}
function download_proxy($url)
{
	$fp = fopen('socks5_proxies.txt', 'wb'); // создаём и открываем файл для записи
	$ch = curl_init($url); // $url содержит прямую ссылку на видео
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_FILE, $fp); // записать вывод в файл
	curl_exec($ch);
	curl_close($ch);
	fclose($fp);
}
?>
