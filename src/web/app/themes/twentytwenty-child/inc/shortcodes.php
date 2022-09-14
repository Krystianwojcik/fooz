<?php
//[most_recent_book]
function most_recent_book_func() {

    $most_recent_book = false;
    $query = new WP_Query(
        array(
            'post_type' => 'books',
            'posts_per_page' => 1
        )
    );

    if ( $query->have_posts() ) :
        while ( $query->have_posts() ) :
            $query->the_post();
            $most_recent_book = get_the_title();
        endwhile;
    endif;

    wp_reset_postdata();
    return $most_recent_book;
}
add_shortcode( 'most_recent_book', 'most_recent_book_func' );

//[list_5_books_genre genre="8"]
function list_5_books_genre_func($atts) {
    $genre = false;
    $list_5_books_genre = false;

    if (isset($atts['genre'])) :
        if (is_numeric($atts['genre'])) :
            $genre = array(
                array(
                    'taxonomy' => 'book-genre',
                    'field'    => 'id',
                    'terms'    => $atts['genre'],
                ),
            );
        endif;
    endif;

    $query = new WP_Query(
        array(
            'post_type' => 'books',
            'posts_per_page' => 5,
            'orderby' => 'title',
            'order'   => 'ASC',
            'tax_query' => $genre
        )
    );

    if ( $query->have_posts() ) :
        $list_5_books_genre = "<ul>";
        while ( $query->have_posts() ) :
            $query->the_post();
            $list_5_books_genre .= "<li>".get_the_title()."</li>";
        endwhile;
        $list_5_books_genre .= "</ul>";
    endif;

    wp_reset_postdata();
    return $list_5_books_genre;
}
add_shortcode( 'list_5_books_genre', 'list_5_books_genre_func' );