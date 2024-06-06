<?php

/**
 * lightbox
 *
 * @package WordPress
 * @subpackage nathalie-mota theme
 */

// Récupérer la taxonomie actuelle
$term = get_queried_object();

// On déclare les variables pour les informations de la photo
$reference = get_field('reference');
$categorie  = my_acf_load_value('name', get_field('categorie-acf'));

?>
<?php the_post_thumbnail('lightbox'); ?>
<div class="lightbox__info flexrow">
    <p class="photo-reference"><?php echo $reference; ?></p>
    <p class="photo-category"><?php echo $categorie; ?></p>
</div>