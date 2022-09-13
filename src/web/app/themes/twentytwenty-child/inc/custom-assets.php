<?php

function enqueue_assets() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
    wp_enqueue_style( 'custom-style', get_stylesheet_directory_uri().'/assets/css/custom-style.css' );

    wp_enqueue_script('custom-script', get_stylesheet_directory_uri().'/assets/js/scripts.js', array( 'jquery' ), '1.0.0', true );
}

add_action( 'wp_enqueue_scripts', 'enqueue_assets' );
