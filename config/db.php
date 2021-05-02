<?php 


$pdo=new PDO('mysql:host=localhost;post=3306;dbname=test','root','');
$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
