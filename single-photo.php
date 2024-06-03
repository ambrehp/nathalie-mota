<?php

/**
 * The single : ATRICLE PHOTO 
 *
 * @package WordPress
 * @subpackage nathalie-mota theme
 */

get_header();
?>

<?php
if (have_posts()) : while (have_posts()) : the_post(); ?>
		<section class="photo_detail">
			<!-- Section détail photo -->
			<?php
			//   Vérifier l'activation de ACF
			if (!function_exists('get_field')) return;

			// Récupérer la taxonomie actuelle
			$term = get_queried_object();

			// Récupérer les info de la photo
			$categorie  = my_acf_load_value('name', get_field('categorie-acf'));
			$format = my_acf_load_value('name', get_field('format-acf'));
			$reference = get_field('reference');
			$type = get_field('type');
			?>

			<article class="container__photo flexcolumn">
				<div class="photo__info flexrow">
					<div class="photo__info--description flexcolumn">
						<h1><?php the_title(); ?></h1>
						<ul class="flexcolumn">
							<!-- Affiche les données ACF -->
							<li class="reference">Référence :
								<?php
								if ($reference) {
									echo $reference;
								} else {
									echo ('Inconnue');
								}
								?>
							</li>
							<li>Catégorie :
								<?php
								if ($categorie) {
									echo $categorie;
								} else {
									echo ('Inconnue');
								}
								?>
							</li>
							<li>Format :
								<?php
								if ($format) {
									echo $format;
								} else {
									echo ('Inconnu');
								}
								?>
							</li>
							<li>Type :
								<?php
								if ($type) {
									echo $type;
								} else {
									echo ('Inconnu');
								}
								?>
							</li>
							<li>Année :
								<?php echo the_time('Y'); ?>
							</li>
						</ul>
					</div>
					<div class="photo__info--image flexcolumn">
						<div class="container--image brightness">
							<!-- permet d’afficher l’image mise en avant -->
							<?php the_post_thumbnail('medium_large'); ?>
							<span class="openLightbox"></span>
						</div>
						<form>
							<input type="hidden" name="postid" class="postid" value="<?php the_id(); ?>">
							<button class="openLightbox" title="Afficher la photo en plein écran" alt="Afficher la photo en plein écran" data-postid="<?php echo get_the_id(); ?>" data-arrow="false" data-nonce="<?php echo wp_create_nonce('nathalie_mota_lightbox'); ?>" data-action="nathalie_mota_lightbox" data-ajaxurl="<?php echo admin_url('admin-ajax.php'); ?>">
							</button>
						</form>
					</div>
				</div>
			</article>

			<div class="photo__contact flexrow">
				<div>
					<p>Cette photo vous intéresse ? <button class="contact" type="button"><a href="#" class="btn-contact">Contact</a></button></p>
				</div>
				<div class="site__navigation flexrow">
					<div class="site__navigation__prev">
						<?php
						$prev_post = get_previous_post();
						if ($prev_post) {
							$prev_title = strip_tags(str_replace('"', '', $prev_post->post_title));
							$prev_post_id = $prev_post->ID;
							echo '<a rel="prev" href="' . get_permalink($prev_post_id) . '" title="' . $prev_title . '" class="previous_post">';
							if (has_post_thumbnail($prev_post_id)) {
						?>
								<div>
									<?php echo get_the_post_thumbnail($prev_post_id, array(77, 60)); ?></div>
						<?php
							} else {
								echo 'Aucune photo<br>';
							}
							// fléche post précedent
							previous_post_link(' %link', '&#10229;');
						}
						?>
					</div>
					<div class="site__navigation__next">
						<?php
						$next_post = get_next_post();
						if ($next_post) {
							$next_title = strip_tags(str_replace('"', '', $next_post->post_title));
							$next_post_id = $next_post->ID;
							echo  '<a rel="next" href="' . get_permalink($next_post_id) . '" title="' . $next_title . '" class="next_post">';
							if (has_post_thumbnail($next_post_id)) {
						?>
								<div><?php echo get_the_post_thumbnail($next_post_id, array(77, 60)); ?></div>
						<?php
							} else {
								echo 'Aucune photo<br>';
							}
							// fléche post suivant
							next_post_link(' %link', '&#10230;');
						}
						?>

					</div>
				</div>
			</div>
			<div class="photo__others flexcolumn">
				<h2>Vous aimerez aussi</h2>
				<div class="photo__others--images flexrow">
					<?php
					get_template_part('template-parts/post/photo-common');
					?>
				</div>
			</div>
		</section>
<?php endwhile;
endif; ?>

<?php get_footer(); ?>