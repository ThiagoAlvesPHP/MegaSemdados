<?php
session_start();

if (isset($_SESSION['cLogin']) && !empty($_SESSION['cLogin'])) {
	session_destroy();
	header('Location: login.php');
	exit;
}