<?php

/**
 * Modal contact
 *
 * @package WordPress
 * @subpackage nathalie-mota theme
 */
?>


<div class="popup-overlay hidden">
	<div class="popup-contact">
		<div class="popup-title__container">
			<img class="titre-contact" src="<?php echo get_stylesheet_directory_uri() . '/assets/img/contact.png' ?>" alt="Titre contact">
		</div>
		<div class="popup-informations">
			<?php
			// On insère le formulaire de demandes de renseignements
			// get_field('reference')
			$refPhoto = "";
			if (get_field('reference')) {
				$refPhoto = get_field('reference');
			};
			echo do_shortcode('[contact-form-7 id="9c8764c" title="Contact form"]');
			?>
		</div>
	</div>
</div>