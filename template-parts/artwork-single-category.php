<?php
get_header(); 
$obj = get_queried_object();
$taxonomy = (isset($obj->taxonomy)) ? $obj->taxonomy : '';
$category_name = (isset($obj->name)) ? $obj->name : '';
$term_slug = (isset($obj->slug) && $obj->slug) ? $obj->slug : '';
$term_id = (isset($obj->term_id) && $obj->term_id) ? $obj->term_id : '';
$popup_categories = array(3,4);
?>

<div id="primary" class="full-content-area clear">
	<header class="page-header">
		<h1 class="page-title"><?php echo $category_name; ?></h1>
	</header>

	<?php
	$args = array(
    	'showposts' => -1,
        'post_type' => 'artwork',
        'post_status' => 'publish',
        'tax_query' => array(
            array(
                'taxonomy' => $taxonomy,
                'terms' => $term_id,
                'include_children' => false 
            )
        )
	);

	$items = new WP_Query( $args );  ?>
	<?php if ( $items->have_posts() )  { ?>
	<div class="art-post-entries clear">
		<div class="grid masonry clear">
			<?php while ( $items->have_posts() ) : $items->the_post(); 
				$image = get_the_post_thumbnail(); 
				$post_id = get_the_ID();
				$post_thumbnail_id = get_post_thumbnail_id( $post_id );
				$image_src = wp_get_attachment_image_src($post_thumbnail_id,'full');
				$sub_title = get_field('second_line_title'); 
				$short_description = get_field('short_description'); 
				$pagelink = get_permalink(); ?>
				<?php if($image) { ?>
					<?php if( in_array($term_id, $popup_categories) ) { ?>

						<?php /* Pop-up image */ ?>
						<div class="box item">
							<div class="inside clear">
								<a class="effect-zoe popup-image" data-fancybox="images" rel="next" href="<?php echo $image_src[0]?>">
									<?php the_post_thumbnail('large'); ?>
								</a>
							</div>
						</div>

					<?php } else { ?>

						<?php /* Open new page */ ?>
						<div class="box box-with-link item" data-url="<?php echo $pagelink; ?>">
							<div class="inside clear">
								<figure class="effect-zoe">
									<?php the_post_thumbnail('large'); ?>
									<figcaption>
										<p class="title1"><?php echo get_the_title(); ?></p>
										<p class="title2"><?php echo $sub_title; ?></p>
										<?php if($short_description) { ?>
										<div class="description"><?php echo $short_description; ?></div>
										<?php } ?>
									</figcaption>
								</figure>
							</div>
						</div>

					<?php } ?>

				<?php } ?>
			<?php endwhile; ?>
		</div>
	</div>
	<?php } ?>
</div>



<?php
get_footer();