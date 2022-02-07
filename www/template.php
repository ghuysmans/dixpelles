<?php
function show_header() {
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
<h1>Dix Pelles</h1>
<figure>
<blockquote class="blockquote">
<p title="même s'il faut parfois creuser un peu">Nos traducteurs ont du talent<!--,
même s'il faut parfois creuser pour le trouver-->.</p>
</blockquote>
<figcaption class="blockquote-footer">
Le développeur
</figcaption>
</figure>
<?php
}

function show_footer() {
?>
</div>
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
