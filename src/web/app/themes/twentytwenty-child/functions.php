<?php

include 'inc/custom-post-type/init.php';
include 'inc/custom-taxonomy/init.php';
include 'inc/custom-assets.php';
include 'inc/shortcodes.php';
require_once('inc/class-posts-stream-manager.php');

add_action( 'after_setup_theme', array( Posts_Stream_Manager::class, 'get_instance' ) );