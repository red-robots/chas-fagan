<?php
get_header(); 
$obj = get_queried_object();
$taxonomy = (isset($obj->taxonomy)) ? $obj->taxonomy : '';
$category_name = (isset($obj->name)) ? $obj->name : '';
$term_slug = (isset($obj->slug) && $obj->slug) ? $obj->slug : '';
$term_id = (isset($obj->term_id) && $obj->term_id) ? $obj->term_id : '';
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
			$sub_title = get_field('second_line_title'); 
			$short_description = get_field('short_description'); 
			$pagelink = get_permalink(); ?>
			<?php if($image) { ?>
			<div class="box box-with-link" data-url="<?php echo $pagelink; ?>">
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
		<?php endwhile; ?>
		</div>
	</div>
	<?php } ?>
</div>



<?php
get_footer();