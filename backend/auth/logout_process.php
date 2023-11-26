<?php
session_start();
require '../../includes/database.php';
$_SESSION = [];
session_unset();
session_destroy();
header("Location: ../../login.php");