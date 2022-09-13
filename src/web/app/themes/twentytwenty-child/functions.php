<?php

function enqueue_parent_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
    wp_enqueue_style( 'custom-style', get_stylesheet_directory_uri().'/assets/css/custom-style.css' );
}

add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );