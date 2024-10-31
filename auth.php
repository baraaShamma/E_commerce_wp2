<?php
session_start();
$is_logged_in = isset($_SESSION['user_id']);
