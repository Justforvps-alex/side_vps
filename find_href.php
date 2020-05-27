<?php
ignore_user_abort(true);
ini_set('max_execution_time', 0);
set_time_limit(0);
error_reporting(1);
$connection = ssh2_connect( "ovz5.alexdumachev.mgqxn.vps.myjino.ru" , '49240'); 
if (ssh2_auth_password( $connection , 'root', 'Qwerty12345')) { echo "Authentication Successful!\n"; } 
else { die('Authentication Failed...'); }
include  'simple_html_dom.php';
include  'classes.php';
include  'functions.php';
$mistakes = fopen('mistakes.txt', 'a+');
fwrite($mistakes, date('l jS \of F Y h:i:s A'));
//достаем первый id
while(1){
$phpstatus=file_get_contents('http://ovz5.alexdumachev.mgqxn.vps.myjino.ru/phpstatus.txt');
  if($phpstatus=='done'){sleep(60);}
  else{
  $command="mysql -u root -p12345 phones -sse 'SELECT id FROM phones_url'";
  $test=ssh2_exec($connection, $command);
  stream_set_blocking($test, true);
  $ident=fgets($test);
  if($ident!='')
  {
//dostaem href
$command="mysql -u root -p12345 phones -sse 'SELECT item_url FROM phones_url where id=$ident'";
$test=ssh2_exec($connection, $command);
stream_set_blocking($test, true);
$phone_url=fgets($test);
$command="mysql -u root -p12345 phones -sse 'DELETE FROM phones_url WHERE id=$ident'";
ssh2_exec($connection, $command);
//check 
$time_sleep=rand(8,9);
$phone_url=str_replace("
","",$phone_url);
$imgContent=Curl_avito($phone_url,$time_sleep);
$avitoContact = new AvitoContact;
$imgContent = explode('base64,', $imgContent)[1];
$a = fopen('phone.png', 'wb');
fwrite($a, base64_decode($imgContent));
fclose($a);
$image='phone.png';
$result = $avitoContact->recognize('phone.png');
if ($result) {
  $number=$result;
  echo $number;
  $command="mysql -u root -p12345 phones -sse 'SELECT COUNT(*) FROM phones WHERE number='$number''";
  $test=ssh2_exec($connection, $command);
  stream_set_blocking($test, true);
  $unique=fgets($test);
  if($unique==0){
    $command="mysql -u root -p12345 phones -sse 'INSERT INTO phones (id, number, vpn) VALUES (NULL, '$number', 'DE')'";
    ssh2_exec($connection, $command);
  }
}
}
else
{sleep(5);}
}
}
fclose($mistakes);
?>
