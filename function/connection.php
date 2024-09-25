<?php
session_start();
$user = 'root';
$password = ''; 
$database = 'garden_roots'; 
$servername='localhost:3306';
$mysqli = new mysqli($servername, $user, $password, $database);
?>