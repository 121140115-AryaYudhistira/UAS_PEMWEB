<?php
$dbhost = "localhost";
$dbuser = "";
$dbpass = "";
$db = "barokah";
$conn = new mysqli($dbhost, $dbuser, $dbpass, $db) or die("Connect failed: %s\n" . $conn->error);
