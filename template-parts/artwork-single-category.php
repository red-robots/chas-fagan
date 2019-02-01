<?php
get_header(); 
$obj = get_queried_object();
$taxonomy = (isset($obj->taxonomy)) ? $obj->taxonomy : '';
$category_name = (isset($obj->name)) ? $obj->name : '';
$term_slug = (isset($obj->slug) && $obj->slug) ? $obj->slug : '';
$term_id = (isset($obj->term_id) && $obj->term_id) ? $obj->term_id : '';
$perpage = 9;
$popup_categories = array(3,4);
?>

<input type="hidden" id="perpage" value="<?php echo $perpage?>">
<input type="hidden" id="termID" value="<?php echo $term_id?>">
<input type="hidden" id="taxonomy" value="<?php echo $taxonomy?>">
<input type="hidden" id="currentPage" value="1">

<div id="primary" class="full-content-area clear artworkList">
	<header class="page-header">
		<h1 class="page-title"><?php echo $category_name; ?></h1>
	</header>

	<?php

	$galleries = get_galleries($taxonomy,$term_id,1,$perpage);
	if ( $galleries )  { ?>
	<div class="art-post-entries clear">
		<div id="spinner">
			<div class="inner"><div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>
        </div>
		<div id="results" class="grid masonry2 clear">
			<div class="grid-sizer"></div>
			<?php echo $galleries; ?>
		</div>
	</div>
	<?php } ?>
</div>



<?php
get_footer();