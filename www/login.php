<?php
require_once 'lib.php';
require_once 'template.php';

if (isset($_POST['email']) && isset($_POST['pass'])) {
	$q = $db->prepare('SELECT * FROM user WHERE email=? AND password=?');
	$q->execute([$_POST['email'], $_POST['pass']]);
	if ($r = $q->fetch()) {
		$_SESSION['user'] = $r['id'];
		$_SESSION['admin'] = $r['admin'];
		header('Location: index.php');
		exit();
	}
	else
		$failed = true;
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
