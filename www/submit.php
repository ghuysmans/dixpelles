<?php
require_once 'lib.php';
require_once 'template.php';

show_header();

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
<h2>Rapporter une trahison</h2>
<div class="row mb-3">
	<div class="col">
		<label class="form-label" for="title">Titre</label>
		<input class="form-control" name="title" id="title" value="<?=quote(maybe('title'))?>" required>
	</div>
</div>
<h3>Original</h3>
<label class="form-label">Langue : <?php show_lang_sel('orig');?></label>
<textarea class="form-control mb-1" name="orig_text" placeholder="Texte d'origine" required>
<?=quote(maybe('orig_text'))?>
</textarea>
<h3 title="Mauvaise traduction">Trahison</h3>
<label class="form-label">Langue : <?php show_lang_sel('target');?></label>
<textarea class="form-control mb-1" name="target_text" placeholder="Texte défiguré" required>
<?=quote(maybe('target_text'))?>
</textarea>
<h3>Source</h3>
<label class="form-label" for="url">Adresse (URL)</label>
<div class="input-group">
<input class="form-control" type="url" name="url" id="url" value="<?=quote(maybe('url'))?>" required>
</div>
<button class="btn btn-primary">Envoyer</button>
</form>
<?php
}

show_footer();
