<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package ACStarter
 */

get_header(); ?>

	<div id="primary" class="full-content-area clear">
		<main id="main" class="site-main" role="main">
			<?php while ( have_posts() ) : the_post(); ?>
				<header class="page-header">
					<h1 class="page-title"><?php the_title() ?></h1>
				</header>
				<?php if( get_the_content() ) { ?>
				<div class="entry-content"><?php the_content() ?></div>
				<?php } ?>
			<?php endwhile;  ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
