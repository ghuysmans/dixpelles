<?php
require_once 'lib.php';
require_once 'template.php';

if (!isset($_SESSION['user'])) {
	header('HTTP/1.1 401 Unauthorized');
	show_header('');
	ask_login();
	show_footer();
}
else if (isset($_GET['id']) && is_numeric($_GET['id']) && !empty($_POST['review']) && isset($_POST['score']) && is_numeric($_POST['score'])) {
	$q = $db->prepare('INSERT INTO review(mistranslation, reviewer, review, score) VALUES (?, ?, ?, ?)');
	if ($q->execute([$_GET['id'], $_SESSION['user'], $_POST['review'], $_POST['score']])) {
		header("Location: index.php#t{$_GET['id']}r{$_SESSION['user']}");
		exit();
	}
}

header('HTTP/1.1 400 Bad Request');
show_header('');
show_alert('danger', "Paramètres invalides.");
show_footer();
