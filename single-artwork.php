<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package ACStarter
 */

get_header(); 
$obj = get_queried_object();
?>

	<div id="primary" class="full-content-area clear">
		<main id="main" class="site-main" role="main">
			<?php while ( have_posts() ) : the_post(); ?>
				<header class="page-header">
					<h1 class="page-title"><?php the_title() ?></h1>
					<div class="breadcrumb">
						<a href="<?php echo get_site_url()?>/artwork/">Artwork</a>
						<?php 
							$post_id = get_the_ID();
							$taxonomy = 'arttypes';
							$categories = get_the_terms($post_id,$taxonomy);
							$the_categories = '';  
							if($categories) { 
							$i=1; foreach($categories as $cat) { 
								$comma = ($i>1) ? ', ':'';
								$link = get_term_link($cat->term_id);
								$the_categories .= $comma . '<a href="'.$link.'">'.$cat->name.'</a>';
							$i++; }
						} ?>

						<?php if($the_categories) { ?>
							&raquo;
							<?php echo $the_categories; ?>
						<?php } ?>
						&raquo;
						<span class="current"><?php echo get_the_title();?></span>
					</div>
				</header>
				<?php if( get_the_content() ) { ?>
				<div class="entry-content"><?php the_content() ?></div>
				<?php } ?>
			<?php endwhile;  ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
