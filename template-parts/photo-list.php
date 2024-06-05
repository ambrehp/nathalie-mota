<?php

/**
 * @package WordPress
 * @subpackage nathalie-mota theme
 */
?>

<?php if (has_post_thumbnail()) : ?>

    <?php
    // On récupère la taxonomie ACF actuelle
    $term = get_queried_object();
    // On déclare les variables pour les informations de la photo
    $reference = get_field('reference');
    $categorie  = my_acf_load_value('name', get_field('categorie-acf'));
    ?>

    <!-- On génère le nombre de photo en fonction de l'option dans WordPress -->
    <div class="news-info overlay">
        <p class="photo-reference"><?php echo $reference; ?></p>
        <h3 class="info-tax"><?php echo $categorie; ?></h3>
        <a href="<?php the_permalink() ?>" aria-label="Voir le détail de la photo <?php the_title(); ?>" alt="<?php the_title(); ?>" title="Voir le détail de la photo"><span class="detail-photo"></span></a>
        <?php the_post_thumbnail(); ?>
        <p><?php the_terms($post->ID, 'categorie-acf', ''); ?></p>
        <form>
            <input type="hidden" name="postid" class="postid" value="<?php the_id(); ?>">

            <a class="openLightbox" title="Afficher la photo en plein écran" alt="Afficher la photo en plein écran" data-postid="<?php echo get_the_id(); ?>" data-arrow="true">
            </a>
        </form>
    </div>

<?php endif; ?>