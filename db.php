<?php
$servername = getenv('MYSQLHOST') ?: 'localhost';
$username = getenv('MYSQLUSER') ?: 'root';
$password = getenv('MYSQLPASSWORD') ?: '';
$dbname = getenv('MYSQLDATABASE') ?: 'onlineStore';
$port = getenv('MYSQLPORT') ?: 3306;

// إنشاء الاتصال
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// التحقق من الاتصال
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
