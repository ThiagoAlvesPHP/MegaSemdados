<?php
session_start();

if (isset($_SESSION['cLoginCliente']) && !empty($_SESSION['cLoginCliente'])) {
	session_destroy();
	header('Location: login.php');
	exit;
}