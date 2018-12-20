<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ACStarter
 */

get_header(); 
$wp_query = new WP_Query(array('post_status'=>'private','pagename'=>'home'));
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
	<?php if ( have_posts() ) : the_post(); ?>

	<?php endif; ?>
	</main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();