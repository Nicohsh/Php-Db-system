<?php
const DB_HOST = 'mysql38.unoeuro.com';
const DB_USER = 'nicolaiholm_dk';
const DB_PASS = 'quxe6atheswe';
const DB_NAME = 'nicolaiholm_dk_db';

$link = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($link->connect_error) { 
   die('Connect Error ('.$link->connect_errno.') '.$link->connect_error);
}
$link->set_charset("utf8"); 
?>