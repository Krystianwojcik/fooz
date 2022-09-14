<?php
/**
 * Posts stream manager
 *
 * @package Crunch
 */

/**
 * Posts stream manager class
 */
class Posts_Stream_Manager {
    /**
     * Instance of this singletone class
     *
     * @var Posts_Stream_Manager
     */
    public static $instance = null;

    /**
     * Get instance of this class
     *
     * usage:
     * add_action( 'init', array( Posts_Stream_Manager::class, 'get_instance' ) );
     */
    public static function get_instance() {
        if ( ! self::$instance ) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * Constructor of class, initializes components
     *
     * @return void
     */
    public function __construct()
    {
        $this->register_hooks();
    }

    /**
     * Add actions and filters
     *
     * @return void
     */
    public function register_hooks() {
        add_action( 'rest_api_init', array( $this, 'rest_api_init' ) );
    }

    /**
     * REST API init
     *
     * @return void
     */
    public function rest_api_init()
    {
        /**
         * Get posts by terms
         *
         * @url GET /wp-json/posts/v1/books
         *
         * Accepts json payload
         *
         * @param string       post_preview_template Post preview template name.
         *
         * @response {
         *   json books,
         * }
         */
        register_rest_route( 'posts/v1', 'books', [
            'methods'             => 'GET',
            'permission_callback' => '__return_true',
            'callback'              => function ( WP_REST_Request $request ) {

                $payload = json_decode( file_get_contents( 'php://input' ), true );

                $posts_query = $this->get_posts_query();

                ob_start();

                if ( $posts_query->have_posts() ) {
                    $books_result = array();
                    while ( $posts_query->have_posts() ) {
                        $posts_query->the_post();

                        $ID = get_the_ID();
                        $name = get_the_title();
                        $date = get_the_date('d F Y');
                        $excerpt = get_the_excerpt();
                        $terms = get_the_terms( $ID, 'book-genre' );
                        $genre = array();
                        if ($terms) :
                            foreach ($terms as $term) :
                                array_push($genre, $term->name);
                            endforeach;
                        endif;

                        $book['name'] = $name;
                        $book['date'] = $date;
                        $book['genre'] = $genre;
                        $book['excerpt'] = $excerpt;
                        array_push($books_result, $book);
                    }

                    wp_reset_postdata();
                }

                wp_send_json( [
                    $books_result
                ] );
            },
        ] );
    }

    /**
     * Get posts query
     *
     * @return WP_Query
     */
    public function get_posts_query() {
        $query_args = array(
            'posts_per_page' => 20,
            'post_status' => 'publish',
            'post_type' => 'books',
        );

        return ( new WP_Query( $query_args ) );
    }
}