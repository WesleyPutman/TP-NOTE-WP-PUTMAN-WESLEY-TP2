<?php

function mon_theme_setup() {
    add_theme_support( 'post-thumbnails' );
}
add_action( 'after_setup_theme', 'mon_theme_setup' );

function mon_theme_register_cpt_randonnees() {
    $labels = array(
        'name' => 'Randonnées',
        'singular_name' => 'Randonnée',
        'add_new' => 'Ajouter une Randonnée',
        'add_new_item' => 'Ajouter une nouvelle Randonnée',
        'edit_item' => 'Modifier la Randonnée',
        'new_item' => 'Nouvelle Randonnée',
        'view_item' => 'Voir la randonnée',
        'search_items' => 'Rechercher une Randonnée',
        'not_found' => 'Aucune Randonnée trouvée',
        'not_found_in_trash' => 'Aucune Randonnée dans la corbeille',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'randonnee'),
        'supports' => array('title', 'editor', 'thumbnail'), 
        'menu_position' => 5,
        'menu_icon' => 'dashicons-location-alt',
    );

    register_post_type('randonnee', $args);
}

function mon_theme_register_taxonomie_difficulte() {
    $labels = array(
        'name'              => 'Difficultés',
        'singular_name'     => 'Difficulté',
        'search_items'      => 'Rechercher une difficulté',
        'all_items'         => 'Toutes les difficultés',
        'edit_item'         => 'Modifier la difficulté',
        'update_item'       => 'Mettre à jour la difficulté',
        'add_new_item'      => 'Ajouter une nouvelle difficulté',
        'new_item_name'     => 'Nom de la nouvelle difficulté',
        'menu_name'         => 'Difficulté',
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'show_in_rest'      => true,
        'rewrite'           => array( 'slug' => 'difficulte' ),
    );

    register_taxonomy( 'difficulte', array( 'randonnee' ), $args );
}
add_action( 'init', 'mon_theme_register_taxonomie_difficulte' );
add_action('init', 'mon_theme_register_cpt_randonnees');
function mon_theme_scripts_carte() {
    wp_enqueue_style( 'leaflet-css', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css' );
    wp_enqueue_script( 'leaflet-js', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js', array(), null, true );
}
add_action( 'wp_enqueue_scripts', 'mon_theme_scripts_carte' );
function mon_theme_charger_styles() {
    wp_enqueue_style( 'main-style', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'mon_theme_charger_styles' );

?>