<?php
$conn = mysql_connect("localhost","hbanfvqkdv","tXySfqDmQ3") or die("ERROR::Not connected to SERVER"); 
$db = mysql_select_db("hbanfvqkdv",$conn) or die("ERROR::Not connected to DATABASE");

$GLOBALS['base_url'] = "http://www.sareez.com/";