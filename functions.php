<?php
// Pour les versions antérieures à WordPress 5.2
if (!function_exists('wp_body_open')) {
    function wp_body_open()
    {
        do_action('wp_body_open');
    }
}

function nathalie_mota_theme_enqueue()
{

    //  Chargement des styles du theme
    wp_enqueue_style('nathalie-mota-style', get_stylesheet_uri(), array(), filemtime(get_stylesheet_directory() . '/style.css'), 'all');

    //  Chargement des styles pour le theme
    wp_enqueue_style('nathalie-mota-single-photo-style', get_stylesheet_directory_uri() . '/assets/css/single-photo.css', filemtime(get_stylesheet_directory() . '/assets/css/single-photo.css'));
    wp_enqueue_style('nathalie-mota-lightbox-style', get_stylesheet_directory_uri() . '/assets/css/lightbox.css', array(), filemtime(get_stylesheet_directory() . '/assets/css/lightbox.css'));
    wp_enqueue_style('select2', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css', array(), '4.1.0-rc.0');

    // Chargement des script JS personnalisés
    wp_enqueue_script('nathalie-mota-scripts', get_theme_file_uri('/assets/js/script.js'), array('jquery', 'select2'), filemtime(get_stylesheet_directory() . '/assets/js/script.js'));

    if (!is_front_page()) {
        wp_enqueue_script('nathalie-mota-scripts-lightbox', get_theme_file_uri('/assets/js/lightbox.js'), array('jquery'), filemtime(get_stylesheet_directory() . '/assets/js/lightbox.js'));
    } else {
        wp_enqueue_script('nathalie-mota-scripts-lightbox-ajax', get_theme_file_uri('/assets/js/lightbox-front-page-ajax.js'), array('jquery'), filemtime(get_stylesheet_directory() . '/assets/js/lightbox-front-page-ajax.js'));
    }
    wp_enqueue_script('nathalie-mota-scripts-photo-list-ajax', get_theme_file_uri('/assets/js/photo-list-ajax.js'), array('jquery'), filemtime(get_stylesheet_directory() . '/assets/js/photo-list-ajax.js'));

    // Chargement de Select2
    wp_enqueue_script('select2', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', array('jquery'), '4.1.0-rc.0');
}
add_action('wp_enqueue_scripts', 'nathalie_mota_theme_enqueue');


// Prise en charge des images mises en avant
add_theme_support('post-thumbnails');

// Définir la taille des images mises en avant 
// set_post_thumbnail_size(largeur, hauteur max, true = on adapte l'image aux dimensions)
set_post_thumbnail_size(600, 0, false);

// Définir d'autres tailles d'images : 
// les options de base WP : 
//      'thumbnail': 150 x 150 hard cropped 
//      'medium' : 300 x 300 max height 300px
//      'medium_large' : resolution (768 x 0 infinite height)
//      'large' : 1024 x 1024 max height 1024px
//      'full' : original size uploaded
add_image_size('hero', 1450, 960, true);
add_image_size('desktop-home', 600, 520, true);
add_image_size('lightbox', 1300, 900, true);

// créer un lien pour la gestion des menus dans l'administration
// et activation d'un menu pour le header et pour le footer

//fonction WordPress qui permet d'enregistrer une zone de menu de navigation dans le thème
function register_my_menu()
{
    register_nav_menu('main', "Menu principal");
    register_nav_menu('footer', "Menu pied de page");
}
add_action('after_setup_theme', 'register_my_menu');


/**
 * Shortcode pour ajouter un bouton contact
 */
function contact_btn($string)
{

    /** Code du bouton */
    $string = '<a href="#" class="contact">Contact</a>';

    /** On retourne le code  */
    return $string;
}

/** On publie le shortcode  */
add_shortcode('contact', 'contact_btn');

// Récupération de la valeur d'un champs personnalisé ACF
// $variable = nom de la variable dont on veut récupérer la valeur
// $field = nom du champs personnalisés
function my_acf_load_value($variable,  $field)
{
    // Initialisation de la valeur à retourner
    $return = "";
    // Recherche de la clé
    foreach ($field as $key => $value) {
        if ($key === $variable) {
            $return = $value;
        }
    }
    return $return;
}


/**
 * Show CPT in archives pages (TAG & Category)
 *
 */
function add_custom_types_to_tax($query)
{
    echo (is_category());
    echo (is_tag());
    if (is_category() || is_tag() && empty($query->query_vars['suppress_filters'])) {
        // Set post type
        $post_types = array('post', 'page', 'my_cpt_1', 'my_cpt_2', 'photo');

        $query->set('post_type', $post_types);
        return $query;
    }
}
add_filter('pre_get_posts', 'add_custom_types_to_tax');

// Partie pour gerer le padding de l'affichage des photos  
include get_template_directory() . '/includes/ajax.php';

function menu_nav()
{
    $menu2 = wp_nav_menu(array('theme_location' => 'main'));
    $menu3 = wp_nav_menu(array('menu' => 'header'));
    // echo ('Menu: ' . $menu3);
}
