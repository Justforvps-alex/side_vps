<?php
function Curl_avito($url,$time_sleep,$mistakes)
{
$useragent = 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/'.rand(60,72).'.0.'.rand(1000,9999).'.121 Safari/537.36';
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
$page = curl_exec($ch);
$html=str_get_html($page);
curl_close($ch);
sleep($time_sleep);
$html=check_html($html,$url,$mistakes);
return $html;
}
function check_html($html,$url,$mistakes)
{
$check_1=strpos($check_html,'Объявления');
$check_2=strpos($check_html,'user_unauth');
$check_3=strpos($check_html,'image64');
if($check_html!=''){
	if($check_1!==false or $check_2!==false or $check_3!==false) {fwrite($mistakes, "<br>Vse norm<br>"); $check_proxy_check=1;}
	else {fwrite($mistakes, "<br>Vse ploho, zabanen<br>");}
}
else {fwrite($mistakes, "<br>Vse ploho, dead proxy<br>");$check_proxy_check=0;}
	while($check_html=='' or $check_proxy_check==0)
	{
	//Проверка сигналов
    	$signal=htmlentities(file_get_contents("signal.txt"));
    	if($signal=="stop"){
        	$php_status = fopen('phpstatus.txt', 'w+');
        	fwrite($php_status, "done");
        	fclose($php_status);
        	exit;
        }
	$check_1=strpos($check_html,'Объявления');
	$check_2=strpos($check_html,'user_unauth');
	$check_3=strpos($check_html,'image64');
	if($check_html!=''){
    		if($check_1!==false or $check_2!==false or $check_3!==false) {fwrite($mistakes,"<br>Vse norm<br>"); $check_proxy_check=1; break;}
    		else {fwrite($mistakes,"<br>Vse ploho, zabanen<br>");}
	}
	else { fwrite($mistakes,"<br>Vse ploho, dead proxy<br>");}
	$useragent = 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/'.rand(60,72).'.0.'.rand(1000,9999).'.121 Safari/537.36';
	$vps_proxy[0]='34.96.248.174:443';
	$vps_proxy[1]='35.243.124.130:443';
	$string_proxy=$GLOBALS['number_proxy'];
	if($string_proxy>1){
		$proxy=$show_info[$string_proxy];
	}
	else{
		$proxy=$vps_proxy[$string_proxy];
	}
	$proxy_status = fopen('proxy_checks.txt', 'w+');
	fwrite($proxy_status, "proxy $proxy");
	fclose($proxy_status);
	if($proxy='' or $proxy=NULL){
		$url_proxy='https://api.proxyscrape.com/?request=getproxies&proxytype=socks4&timeout=10000&country=all';
    		download_proxy($url_proxy);
  	  	$GLOBALS['proxy_type']='CURLPROXY_SOCKS4';
  	  	$GLOBALS['number_proxy']=2;
 	   	$show_info = file('socks5_proxies.txt');
		$proxy=$show_info[1];
	}
	$ch = curl_init($url);
    	curl_setopt($ch, CURLOPT_URL, $url);
    	curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
    	curl_setopt($ch, CURLOPT_PROXY, $proxy);
	if($GLOBALS['proxy_type']=='CURLPROXY_SOCKS5'){
    		curl_setopt($ch, CURLOPT_PROXYUSERPWD, 'vps:12345');
	}
	curl_setopt($ch, CURLOPT_HEADER, true);
    	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    	curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
	$page = curl_exec($ch);
	curl_close($ch);
	$check_html=str_get_html($page);
	fwrite($mistakes, "<br><br>Плохой хтмл<br>");
	$string_proxy++;
    	}
	$GLOBALS['number_proxy']=$string_proxy;
	sleep(7);
	return $check_html;
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
