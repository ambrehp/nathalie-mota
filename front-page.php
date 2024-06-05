<?php

/**
 * The front-page : ACCUEIL 
 *
 * @package WordPress
 * @subpackage nathalie-mota theme
 */

get_header();
?>
<div id="front-page">
    <section id="content">
        <!-- Intégration du random hero -->
        <div class="hero-area">
            <div class="hero-thumbnail">
                <!-- Initialisation de post à afficher -->
                <?php
                $custom_args = array(
                    'post_type' => 'photo',
                    'orderby'   => 'rand',
                    'posts_per_page' => 1,
                );
                //On crée ensuite une instance de requête WP_Query basée sur les critères placés dans la variables $args
                $random_hero = new WP_Query($custom_args);
                ?>
                <!-- On récupère un post photo en mode aléatoire (rand) -->
                <?php while ($random_hero->have_posts()) : ?>
                    <?php $random_hero->the_post(); ?>

                    <?php if (has_post_thumbnail()) : ?>
                        <div><?php the_post_thumbnail('hero'); ?></div>
                    <?php endif; ?>

                <?php endwhile; ?>
                <h1 class="title-hero">Photographe event</h1>
            </div>
        </div>
        <?php
        // On réinitialise à la requête principale
        wp_reset_postdata();
        ?>

        <!-- Intégration des filtres -->
        <div class="filter-area">
            <form class="flexrow" method="post">
                <!--  -->
                <!-- $terms->term_id :  -->
                <!-- $terms->taxonomy : nom de la taxonomie -->
                <!-- $terms->name : nom de l'élément de la taxonomie -->
                <!-- $terms->term_taxonomy_id : n° de l'élément de la taxonomie -->
                <div class="filterleft flexrow">
                    <div id="filtre-categorie" class="select-filter flexcolumn">
                        <select class="option-filter" name="categorie_id" id="categorie_id">
                            <option id="categorie_0" value="">CATÉGORIES</option>
                            <?php
                            // On récupère la taxonomie ACF catégorie
                            $filtres_categorie_acf = get_terms('categorie-acf', array('hide_empty' => false));
                            foreach ($filtres_categorie_acf as $terms) :
                            ?>
                                <?php if ($terms->term_taxonomy_id == $categorie_id) : ?>
                                    <option id="categorie_<?php echo $terms->term_taxonomy_id; ?>" value="<?php echo $terms->term_taxonomy_id; ?>" selected><?php echo $terms->name; ?></option>
                                <?php else : ?>
                                    <option id="categorie_<?php echo $terms->term_taxonomy_id; ?>" value="<?php echo $terms->term_taxonomy_id; ?>"><?php echo $terms->name; ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div id="filtre-format" class="select-filter flexcolumn">
                        <select class="option-filter" name="format_id" id="format_id">
                            <option id="format_0" value="">FORMATS</option>
                            <?php
                            // On récupère la taxonomie ACF format
                            $filtre_format_acf = get_terms('format-acf', array('hide_empty' => false));
                            foreach ($filtre_format_acf as $terms) :
                            ?>
                                <?php if ($terms->term_taxonomy_id == $format_id) : ?>
                                    <option id="format_<?php echo $terms->term_taxonomy_id; ?>" value="<?php echo $terms->term_taxonomy_id; ?>" selected><?php echo $terms->name; ?></option>
                                <?php else : ?>
                                    <option id="format_<?php echo $terms->term_taxonomy_id; ?>" value="<?php echo $terms->term_taxonomy_id; ?>"><?php echo $terms->name; ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="filterright flexrow">
                    <div id="filtre-date" class="select-filter flexcolumn">
                        <select class="option-filter" name="date" id="date">
                            <option value="">TRIER PAR</option>
                            <option value="desc" <?php if ($order === "desc") : ?>selected<?php endif; ?>>à partir des plus récentes</option>
                            <option value="asc" <?php if ($order === "asc") : ?>selected<?php endif; ?>>à partir des plus anciennes</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>


        <?php
        // Initialisation de variable pour les filtres de requettes Query
        $categorie_id = "";
        $format_id = "";
        $order = "";
        $orderby = "date";


        // Initialisation du filtre d'affichage des posts
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        // On récupère la taxonomie actuelle
        $term = get_queried_object();
        $term_id  = my_acf_load_value('ID', $term);

        $custom_args = array(
            'post_type' => 'photo',
            'posts_per_page' => 8,
            // 'posts_per_page' => get_option('posts_per_page'), // Valeur par défaut
            'order' => $order, // "", ASC , DESC 
            'orderby' =>  $orderby, // 'date' , 'meta_value_num', rand
            'paged' => 1,
            'meta_query'    => array(
                'relation'      => 'AND',
                array(
                    'key'       => 'categorie-acf',
                    'compare'   => 'LIKE',
                    'value'     =>  $categorie_id,
                ),
                array(
                    'key'       => 'format-acf',
                    'compare'   => 'LIKE',
                    'value'     => $format_id,
                )
            ),
            'nopaging' => false,
        );
        //On crée ensuite une instance de requête WP_Query basée sur les critères placés dans la variables $args
        $query = new WP_Query($custom_args);
        $max_pages = $query->max_num_pages;

        // Création du filtre pour la lightbox pour créer un tableau 
        // avec la liste de toutes les photos correspondantes aux filtres
        $custom_args2 = array_replace($custom_args, array('posts_per_page' => -1, 'nopaging' => true,));
        $total_posts = get_posts($custom_args2);
        $nb_total_posts = count($total_posts);

        ?>
        <!-- On vérifie si le résultat de la requête contient des articles -->
        <?php if ($query->have_posts()) : ?>
            <article class="photo-list container-news flexrow">
                <!-- Mise à disposition de JS du tableau contenant toutes les données de la requette et le nombre -->
                <form>
                    <input type="hidden" name="total_posts" id="total_posts" value="<?php print_r($total_posts); ?>">
                    <input type='hidden' name='max_pages' id='max_pages' value='<?php echo $max_pages; ?>'>
                    <input type="hidden" name="nb_total_posts" id="nb_total_posts" value="<?php echo $nb_total_posts; ?>">
                </form>
                <!-- On parcourt chacun des articles de la requête -->
                <?php while ($query->have_posts()) : $query->the_post();
                    get_template_part('template-parts/photo-list');
                endwhile;
                ?>
            </article>
            <div class="lightbox hidden" id="lightbox">
                <button class="lightbox__close" title="Fermer"></button>
                <div class="lightbox__container">
                    <div class="lightbox__loader hidden"></div>
                    <div class="lightbox__container_info flexcolumn" id="lightbox__container_info">
                        <div class="lightbox__container_content flexcolumn" id="lightbox__container_content"></div>
                        <button class="lightbox__next" aria-label="photo suivante" title="Suivante">
                            <p class="text-next">Suivante</p>
                        </button>
                        <button class="lightbox__prev" aria-label="photo précédente" title="Précédente">
                            <p class="text-prev">Précédente</p>
                        </button>
                    </div>
                </div>
            </div>
        <?php else : ?>
            <p>Désolé. Aucun article ne correspond à votre demande.</p>

        <?php endif; ?>

        <?php
        // On réinitialise à la requête principale
        // wp_reset_query(); 
        wp_reset_postdata();
        ?>


        <!-- Intégration pagination infinie -->
        <div id="pagination">
            <!-- Variables qui vont pourvoir être récupérées par JavaScript -->
            <form>
                <input type="hidden" name="orderby" id="orderby" value="<?php echo $orderby; ?>">
                <input type="hidden" name="order" id="order" value="<?php echo $order; ?>">
                <input type="hidden" name="posts_per_page" id="posts_per_page" value="<?php echo get_option('posts_per_page'); ?>">
                <input type="hidden" name="currentPage" id="currentPage" value="<?php echo $paged; ?>">
                <input type="hidden" name="ajaxurl" id='ajaxurl' value="<?php echo admin_url('admin-ajax.php'); ?>">
                <!-- c’est un jeton de sécurité, pour s’assurer que la requête provient bien de ce site, et pas d’un autre -->
                <input type="hidden" name="nonce" id='nonce' value="<?php echo wp_create_nonce('nathalie_mota_nonce'); ?>">
                <!-- On cache le bouton s'il n'y a pas plus d'1 page -->
                <?php if ($max_pages > 1) : ?>
                    <button class="btn_load-more" id="load-more">Charger plus</button>
                    <span class="camera"></span>
                <?php endif ?>
            </form>
        </div>
    </section>

</div>
<?php get_footer(); ?>