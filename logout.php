<?php
	session_start();
	require('inc/config.php');
    require('inc/functions.php');

	logout();
	header('Location: ' . $website_path);
?>