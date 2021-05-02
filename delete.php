<?php
 require_once('./config/db.php') ;
 
 
$id=$_POST['id'] ?? null;

if(!$id){
	header('location:index.php');
}


$st= $pdo->prepare('DELETE FROM posts WHERE id=:id');
$st->bindValue(':id',$id);

$st->execute();

header('location:index.php');
