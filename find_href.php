<?php
ignore_user_abort(true);
ini_set('max_execution_time', 0);
set_time_limit(0);
error_reporting(0);
$connection = ssh2_connect( "ovz5.alexdumachev.mgqxn.vps.myjino.ru" , '49240'); 
if (ssh2_auth_password( $connection , 'root', 'Qwerty12345')) { echo "Authentication Successful!\n"; } 
else { die('Authentication Failed...'); }
require_once 'simple_html_dom.php';
require_once 'classes.php';
require_once 'functions.php';
$mistakes = fopen('mistakes.txt', 'a+');
fwrite($mistakes, date('l jS \of F Y h:i:s A'));
//достаем первый id
$command="mysql -u root -p12345 phones -sse 'SELECT id FROM phones_url'";
$test=ssh2_exec($connection, $command);
stream_set_blocking($test, true);
$ident=fgets($test);
//dostaem href
$command="mysql -u root -p12345 phones -sse 'SELECT item_url FROM phones_url where id=$ident'";
$test=ssh2_exec($connection, $command);
stream_set_blocking($test, true);
$url=fgets($test);
$command="mysql -u root -p12345 phones -sse 'DELETE FROM phones_url WHERE id=$ident'";
ssh2_exec($connection, $command);
//check 
$time_sleep=rand(8,9);
$imgContent = Curl_avito($url,$time_sleep,$mistakes);
$avitoContact = new AvitoContact;
$imgContent = explode('base64,', $imgContent)[1];
$a = fopen('phone.png', 'wb');
fwrite($a, base64_decode($imgContent));
fclose($a);
$image='phone.png';
$result = $avitoContact->recognize('phone.png');
if ($result) {
  $number=$result;
  $command="mysql -u root -p12345 phones -sse 'SELECT COUNT(*) FROM phones WHERE number='$number''";
  $test=ssh2_exec($connection, $command);
  stream_set_blocking($test, true);
  $unique=fgets($test);
  if($unique==0){
    $command="mysql -u root -p12345 phones -sse 'INSERT INTO phones (id, number) VALUES (NULL,'$number')'";
    ssh2_exec($connection, $command);
  }
}  
fclose($mistakes);

?>
