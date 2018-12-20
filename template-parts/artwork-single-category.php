<?php
get_header(); 
$obj = get_queried_object();
$taxonomy = (isset($obj->taxonomy)) ? $obj->taxonomy : '';
$category_name = (isset($obj->name)) ? $obj->name : '';
$term_slug = (isset($obj->slug) && $obj->slug) ? $obj->slug : ''; 
?>

<div id="primary" class="full-content-area clear">
	<header class="pagetitle">
		<h1><?php echo $category_name; ?></h1>
	</header>

	<?php
	$args = array(
    	'showposts' => -1,
        'post_type' => 'artwork',
        'post_status' => 'publish',
        'tax_query' => array(
            array(
                'taxonomy' => $taxonomy,
                'terms' => $term_slug
            )
        )
	);
	$items = new WP_Query( $args );  ?>
	<?php if ( $items->have_posts() )  { ?>
	<div class="art-post-entries clear">
		<div class="masonry clear">
		<?php while ( $items->have_posts() ) : $items->the_post(); 
			$image = get_the_post_thumbnail(); 
			$sub_title = get_field('second_line_title'); 
			$pagelink = get_permalink(); ?>
			<?php if($image) { ?>
			<div class="box box-with-link" data-url="<?php echo $pagelink; ?>">
				<div class="inside clear">
					<div class="wrapp clear">
						<?php the_post_thumbnail('large'); ?>
						<div class="info">
							<div class="title1"><?php echo get_the_title(); ?></div>
							<div class="title2"><?php echo $sub_title; ?></div>
							<div class="description">
								<?php the_content(); ?>
							</div>
						</div>
					</div>
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