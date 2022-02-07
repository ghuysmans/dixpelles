<?php
require_once 'lib.php';
require_once 'template.php';

show_header('submit.php');

$ok = false;
if (empty($_SESSION['user']))
	ask_login();
else if (isset($_POST['orig']))
	if (empty($_POST['title']) || empty($_POST['orig']) || empty($_POST['orig_text']) || empty($_POST['target']) || empty($_POST['target_text']) || empty($_POST['url']))
		show_alert('danger', "Un des champs a été mal rempli. Au passage, adoptez un navigateur plus récent (ou cherchez des problèmes sur une autre page...) !");
	else {
		$q = $db->prepare('INSERT INTO mistranslation(title, orig, orig_text, target, target_text, url, submitted_by) VALUES (?, ?, ?, ?, ?, ?, ?)');
		if ($q->execute(array($_POST['title'], $_POST['orig'], $_POST['orig_text'], $_POST['target'], $_POST['target_text'], $_POST['url'], $_SESSION['user']))) {
			show_alert('success', 'Merci pour votre participation ! Votre trahison a bien été enregistrée, elle paraîtra après relecture par un de nos modérateurs. <a href="index.php">Retour à la page d\'accueil</a>');
			$ok = true;
		}
		else
			show_alert('danger', "Impossible d'insérer vos données.");
	}

if (!$ok) {
?>
<form method="post">
<h1>Rapporter une trahison</h1>
<div class="row mb-3">
	<div class="col">
		<label class="form-label" for="title">Titre</label>
		<input class="form-control" name="title" id="title" value="<?=quote(maybe('title'))?>" required>
	</div>
</div>
<div class="row">
	<div class="col-md-6 mb-2">
		<h2>Original</h2>
		<label class="form-label" for="orig">Langue</label>
		<?php show_lang_sel('orig');?>
		<label class="form-label" for="orig_text">Texte</label>
		<textarea class="w-100" name="orig_text" id="orig_text"><?=quote(maybe('orig_text'))?></textarea>
	</div>
	<div class="col-md-6 mb-2">
		<h2>Trahison</h2>
		<label class="form-label" for="target">Langue</label>
		<?php show_lang_sel('target');?>
		<label class="form-label" for="target_text">Texte</label>
		<textarea class="w-100" name="target_text" id="target_text"><?=quote(maybe('target_text'))?></textarea>
		<label class="form-label" for="url">Adresse (URL)</label>
		<input class="form-control" type="url" name="url" id="url" value="<?=quote(maybe('url'))?>" required>
	</div>
</div>
<button class="btn btn-primary">Envoyer</button>
</form>
<?php
}

show_footer();
