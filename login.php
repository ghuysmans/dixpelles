<?php
require_once 'lib.php';
require_once 'template.php';

if (isset($_POST['email']) && isset($_POST['pass'])) {
	$sql = "SELECT * FROM user WHERE email='{$_POST['email']}' AND password='{$_POST['pass']}'";
	try {
	$q = $db->query($sql);
	if ($r = $q->fetch()) {
		$_SESSION['user'] = $r['id'];
		$_SESSION['admin'] = $r['admin'];
		header('Location: index.php');
		exit();
	}
	else
		$failed = true;
	}
	catch (Exception $e) {
		die("Erreur SQL !<br>$sql<br>" . $e->getMessage());
	}
}
else
	$failed = false;

show_header();
if ($failed)
	show_alert('danger', 'E-mail et/ou mot de passe incorrect(s)');
?>
<form method="post">
<label>E-mail : <input type="email" name="email"></label>
<label>Mot de passe : <input type="password" name="pass"></label>
<button>Connexion</button>
</form>
<?php
show_footer();
