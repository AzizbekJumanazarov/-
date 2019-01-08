<?php
     
    $host = 'localhost';
    $user ='root';
    $password='';
    $db_name = 'post';
    $connection = new PDO('mysql:host='.$host.';dbname='.$db_name,$user,$password); 
?>