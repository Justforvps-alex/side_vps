<?php
$connection = ssh2_connect( "ovz5.alexdumachev.mgqxn.vps.myjino.ru" , '49240'); if (ssh2_auth_password( $connection , 'root', 'Qwerty12345')) { echo "Authentication Successful!\n"; } else { die('Authentication Failed...'); }
$command="mysql -u root -p12345 phones -sse 'SELECT id FROM phones_url'";
$test=ssh2_exec($connection, $command);
stream_set_blocking($test, true);
$ident=fgets($test);
$command="mysql -u root -p12345 phones -sse 'SELECT item_url FROM phones_url where id=$ident'";
$test=ssh2_exec($connection, $command);
stream_set_blocking($test, true);
$phone_url=fgets($test);
$command="mysql -u root -p12345 phones -sse 'DELETE FROM phones_url WHERE id=$ident'";
ssh2_exec($connection, $command);
//check 
$number=;
$command="mysql -u root -p12345 phones -sse 'SELECT COUNT(*) FROM phones WHERE number='$number''";
$test=ssh2_exec($connection, $command);
stream_set_blocking($test, true);
$unique=fgets($test);
echo $unique;

?>
