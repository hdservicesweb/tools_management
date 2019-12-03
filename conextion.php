<?php
$engine = '192.0.0.100';
$port = '22';

$connection = fsockopen($engine, $port);

if(!$connection){
    echo "Connection Failed";
}else{
    echo $connection;
    echo '<br/>';
    echo "Connection Succesful";
}

?>