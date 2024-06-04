<?php

/**
 * footer
 *
 * @package WordPress
 * @subpackage nathalie-mota theme
 */
?>
<footer id="footer">
	<div class="menu-footer">
		<?php
		// Affichage du menu footer déclaré dans functions.php
		wp_nav_menu(array('theme_location' => 'footer'));
		?>

		<span>TOUS DROITS RÉSERVÉS </span>
	</div>

</footer>

<!-- Appel de la popup contact -->
<?php
get_template_part('template-parts/modal/contact');
?>

<?php wp_footer(); ?>

</body>

</html>