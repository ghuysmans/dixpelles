<?php
function maybe($name) {
	return isset($_POST[$name]) ? $_POST[$name] : '';
}

function quote($x) {
	return htmlspecialchars($x, ENT_QUOTES, 'utf-8');
}

function french_dt($ts) {
	return substr($ts, 8, 2) . '/' . substr($ts, 5, 2) . '/' . substr($ts, 0, 4) . ' à ' .
		substr($ts, 11, 2) . 'h' . substr($ts, 14, 2);
}


require_once 'config.php';
//$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

session_start();
