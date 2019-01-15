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

	<div id="primary" class="mid-wrapper clear">
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

				<div class="content-wrapper artwork-content clear">

					<div class="image-container">
						<?php the_post_thumbnail('large'); ?>
					</div>

					<?php 
						$post_thumbnail_id = get_post_thumbnail_id( $post_id );
						$main_image = wp_get_attachment_url($post_thumbnail_id);
						$main_filename = basename($main_image);
						$sub_title = get_field('second_line_title');  
						$galleries = get_field('gallery');  
					?>

					<div class="entry-content">
						
						<?php if($galleries) { ?>
						<div class="artwork-galleries">
							<div class="row clear">
							<?php foreach($galleries as $g) {  
								$filename = $g['filename'];
								$image_src = $g['sizes']['thumbnail']; 
								$image_caption = $g['caption'];
								$title_att = '';
								if($image_caption) {
									$title_att = ' data-caption="'.$image_caption.'"';
								} ?>
								<div class="gallerydiv">
									<a class="viewImageLink" data-fancybox="images" rel="gal" href="<?php echo $g['url'];?>"<?php echo $title_att;?>><img src="<?php echo $image_src;?>" alt="<?php echo $g['title'];?>" /></a>
								</div>
							<?php } ?>
							</div>
						</div>
						<?php } ?>

						<?php if($sub_title) { ?>
						<div class="subtitle"><?php echo $sub_title; ?></div>
						<?php } ?>

						<?php the_content() ?>
					</div>

				</div>
			<?php endwhile;  ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
