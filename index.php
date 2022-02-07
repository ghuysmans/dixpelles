<?php
require_once 'lib.php';
require_once 'template.php';
require_once 'group.php';

if (isset($_GET['q'])) {
  $x = $_GET['q'];
  $q = $db->query("SELECT * FROM homepage WHERE orig='$x' OR orig_text LIKE '%$x%' OR target='$x' OR target_text LIKE '%$x%'");
  show_header('');
  ?><h1>Résultats de recherche</h1><?php
}
else {
  $q = $db->query('SELECT * FROM homepage');
  show_header('index.php');
  ?><h1>Nouveautés</h1><?php
}
$main = ['id', 'title', 'orig', 'orig_french', 'orig_text', 'target', 'target_french', 'target_text', 'url', 'ts'];
$once = false;
foreach (group($q, select($main)) as $g) {
$once = true;
?>
<div class="card mb-3">
	<div class="card-body">
		<h5 class="card-title"><?=quote($g['group']['title'])?></h5>
		<div class="card-subtitle mb-2 text-muted">
			<?php show_lang($g['group']['orig'], $g['group']['orig_french']); ?>
			&rarr;
			<?php show_lang($g['group']['target'], $g['group']['target_french']); ?>,
			envoyé<!--e--> le <?=french_dt($g['group']['ts'])?>.
			<a href="<?=quote($g['group']['url'])?>">Source 🔗</a>
		</div>
		<div class="card-text"><?=quote($g['group']['orig_text'])?></div>
		<!--<div>&darr;</div>-->
		<hr>
		<div class="card-text"><?=$g['group']['target_text']?></div>
		<ul class="list-group mt-3">
			<?php
			$can_post = isset($_SESSION['user']);
			foreach ($g['items'] as $c) {
				if (!is_null($c['score'])) {
					echo "<li class=\"list-group-item\" id=\"t{$g['group']['id']}r{$c['reviewer']}\">";
					show_stars($c['score'], 5);
					echo ' ' . quote($c['review']);
					echo '</li>';
					if ($can_post)
						$can_post = $c['reviewer'] != $_SESSION['user'];
				}
			}
			if ($can_post) {
			?>
			<li class="list-group-item">
				<form class="input-group" action="review.php?id=<?=$g['group']['id']?>" method="post">
					<input class="form-control" name="review" placeholder="Qu'en pensez-vous ?" required>
					<input type="hidden" name="score" value="4"><!--TODO-->
					<button class="btn btn-primary">💬</button>
				</form>
			</li>
			<?php
			}
			?>
		</ul>
	</div>
</div>
<?php
}
if (!$once) {
?>
<p>Nous n'avons rien trouvé.</p>
<?php
}

show_footer();
?>
