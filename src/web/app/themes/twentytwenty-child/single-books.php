<?php
/**
 * The template for displaying single posts and pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

get_header();

$ID = get_the_ID();
$title = get_the_title();
$image = get_post_thumbnail_id();
$terms = get_the_terms( $ID, 'book-genre' );
$date = get_the_date('d F Y');

?>

<main id="site-content">


    <article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

        <?php

        get_template_part( 'template-parts/entry-header' );

        ?>

        <div class="post-inner <?php echo is_page_template( 'templates/template-full-width.php' ) ? '' : 'thin'; ?> ">

            <div class="entry-content">

                <?php if ($title) : ?>
                    <h2><?= $title; ?></h2>
                <?php endif; ?>

                <?php if ( $image ) : ?>
                    <?= wp_get_attachment_image($image, 'full'); ?>
                <?php endif; ?>

                <?php if ($terms) : ?>
                    <ul>

                        <?php foreach ($terms as $term) :?>

                            <?php
                            $name = $term->name;
                            $link = get_term_link($term->term_id);
                            ?>

                            <li><a href="<?= $link ;?>"><?= $name; ?></a></li>

                        <?php endforeach; ?>

                    </ul>

                <?php endif; ?>

                <?php if ($date) : ?>
                    <p><?= $date; ?></p>
                <?php endif; ?>

            </div><!-- .entry-content -->

        </div><!-- .post-inner -->

    </article><!-- .post -->

</main><!-- #site-content -->

<?php get_template_part( 'template-parts/footer-menus-widgets' ); ?>

<?php get_footer(); ?>
