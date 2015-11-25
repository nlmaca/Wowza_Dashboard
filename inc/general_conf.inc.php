<?php 
// page version: 1.0

// These variables define the connection information for your MySQL database 
    $dbUserName = "DBUSERNAME"; 
    $dbUserPasswd = "DBUSERPASSWORD"; 
    $dbHost = "localhost"; 
    $dbName = "DBNAME"; 
    
    $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'); 
    try { $db = new PDO("mysql:host={$dbHost};dbname={$dbName};charset=utf8", $dbUserName, $dbUserPasswd, $options); } 
    catch(PDOException $ex){ die("Failed to connect to the database: " . $ex->getMessage());} 
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 
    header('Content-Type: text/html; charset=utf-8'); 
    session_start(); 
    


// example: 
//$DOCUMENT_ROOT = 'http://vanmarion.nl/projects/Wowza_Dashboard'; // NO trailerslash!!!!

$DOCUMENT_ROOT = '/projects/Wowza_Dashboard_1.1'; // NO trailerslash!!!!
date_default_timezone_set('Europe/Amsterdam');

$TITLE = 'Wowza Live Dashboard';
$DESCRIPTION = 'Version 1.1';


?>