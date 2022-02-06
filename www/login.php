<?php
require_once 'lib.php';
require_once 'template.php';

if (isset($_POST['email']) && isset($_POST['pass'])) {
	$q = $db->prepare('SELECT * FROM user WHERE email=? AND password=?');
	$q->execute([$_POST['email'], $_POST['pass']]);
	if ($r = $q->fetch()) {
		$_SESSION['user'] = $r['id'];
		$_SESSION['admin'] = $r['admin'];
		//TODO handle $_POST['rem']
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
  <div class="mb-3">
    <label class="form-label" for="email">Adresse e-mail</label>
    <input type="email" class="form-control" name="email" id="email" required>
  </div>
  <div class="mb-3">
    <label for="pass" class="form-label">Mot de passe</label>
    <input type="password" class="form-control" name="pass" id="pass" required>
  </div>
  <div class="mb-3 form-check">
    <input type="checkbox" class="form-check-input" name="rem" id="rem">
    <label class="form-check-label" for="rem">Se souvenir de moi</label>
  </div>
  <button type="submit" class="btn btn-primary">Connexion</button>
</form>
<?php
show_footer();
