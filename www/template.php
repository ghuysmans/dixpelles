<?php
$pages = [
	'index.php' => 'Nouveautés',
	'#top' => 'Top 20',
	'submit.php' => 'Soumettre',
	'#about' => 'À propos'
];
$restricted = [
	'submit.php'
];

function show_header($cur) {
	global $pages, $restricted;
	?>
<!DOCTYPE html>
<html>
<head>
<title>Dix Pelles</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
<nav class="navbar navbar-expand-lg navbar-light bg-light">
<div class="container-fluid">
	<a class="navbar-brand" href="index.php">
		<img src="logo.svg" class="d-inline-block" width="30">
		Dix Pelles
	</a>
	<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav mb-2 mb-lg-0">
			<?php
			foreach ($pages as $url => $label) {
				echo '<li class="nav-item">';
				if (in_array($url, $restricted) && !isset($_SESSION['user']))
					;
				else if ($url == $cur) { ?>
					<a class="nav-link active" aria-current="page" href="<?=$url?>"><?=$label?></a>
				<?php } else { ?>
					<a class="nav-link" href="<?=$url?>"><?=$label?></a>
				<?php }
				echo '</li>';
			}
			?>
		</ul>
		<form class="d-flex me-auto" target="index.php">
			<input class="form-control me-2" type="search" placeholder="Rechercher..." aria-label="Rechercher" name="q">
			<!--<button class="btn btn-outline-success" type="submit">Chercher</button>-->
		</form>
		<?php
		if (isset($_SESSION['user'])) { ?>
		<ul class="navbar-nav mb-2 mb-lg-0">
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
					<?=quote($_SESSION['email'])?>
				</a>
				<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
					<li><a class="dropdown-item" href="#">Profil</a></li>
					<!--<li><hr class="dropdown-divider"></li>-->
					<li><a class="dropdown-item" href="logout.php">Déconnexion</a></li>
				</ul>
			</li>
		</ul>
		<?php
	}
		else { ?>
		<a class="btn btn-primary" href="login.php">Connexion</a>
		<?php } ?>
	</div>
</div>
</nav>
<?php
}

function show_footer() {
?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
<?php
}

function show_lang($iso, $label) {
?>
<!--<a href="search.php?lang=<?=$iso?>">-->
<abbr title="<?=$label?>">
<?=$iso?>
</abbr>
<?php
}

function show_alert($typ, $msg) {
?>
<div class="alert alert-<?=$typ?>" role="alert">
<?=$msg?>
</div>
<?php
	return false;
}

$langs = [];

function show_lang_sel($name) {
	global $langs;
	global $db;
	if (empty($langs)) {
		$q = $db->query('SELECT iso639_1, french FROM language');
		while ($r = $q->fetch())
			$langs[$r['iso639_1']] = $r['french'];
	}
?>
<select class="form-select" name="<?=$name?>" id="<?=$name?>" required>
<?php
	foreach ($langs as $iso => $fr) {
		$sel = isset($_POST[$name]) && $_POST[$name] == $iso ? ' selected' : '';
		?><option value="<?=$iso?>"<?=$sel?>><?=$fr?></option><?php
	}
?>
</select>
<?php
}

function show_stars($n, $total) {
	for ($i=0; $i<$n; $i++) echo '★';
	for ($i=$n; $i<$total; $i++) echo '☆';
}

function ask_login() {
	show_alert('warning', "Vous devez <a target=\"_blank\" href=\"login.php\">vous connecter</a> avant d'envoyer une trahison. Après votre connexion, rafraîchissez cette page sans tenir compte de l'avertissement de votre navigateur.");
}
