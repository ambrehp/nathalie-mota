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
			<?php get_template_part('template-parts/post/photo-detail'); ?>

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
						<!-- next_post_link( '%link', '%title', false );  -->
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