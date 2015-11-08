<?php
/**
 * Template Name: Recipes Page
 *
 * Selectable from a dropdown menu on the edit page screen.
 */


get_header(); ?>

	<div id="primary" class="site-content">
		<div id="content" role="main">
			

			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>
				<?php

		$args = array(

		
	'posts_per_page'   => 5,
	'offset'           => 0,
	'category'         => '',
	'orderby'          => 'post_date',
	'order'            => 'DESC',
	'include'          => '',
	'exclude'          => '',
	'meta_key'         => '',
	'meta_value'       => '',
	'post_type'        => 'rex',
	'post_mime_type'   => '',
	'post_parent'      => '',
	'post_status'      => 'publish',
	'suppress_filters' => true ); 


		$posts_array = get_posts($args);
		if ($posts) {
foreach($posts_array as $post) {


$key_6_value = get_post_meta( get_the_ID(), 'book_thumbnail', true);                
$key_1_value = get_post_meta( get_the_ID(), 'book_title', true );
$key_3_value = get_post_meta( get_the_ID(), 'book_author', true );
$key_4_value = get_post_meta( get_the_ID(), 'book_url', true );
$key_5_value = get_post_meta( get_the_ID(), 'book_blurb', true );
$author_id=$post->post_author; 



// check if the custom field has a value
?>
<?php
if( ! empty( $key_1_value ) ) {
  //echo $key_1_value;
} 
?>

<b><img src="<?php echo $key_6_value ?>"></b><br>
 <b> Book Title: <?php echo $key_1_value ?></b><br>
 <b> Book Author<?php echo $key_2_value ?></b><br>
 <?php
if( ! empty( $key_3_value ) ) {
  //echo $key_1_value;
} 
?>
 <b><?php echo $key_3_value ?></b><br>
 <?php
if( ! empty( $key_4_value ) ) {
  //echo $key_1_value;
} 
?>
 <a href="<?php echo $key_4_value ?>"> Google Books URL</a>
 <?php
if( ! empty( $key_5_value ) ) {
  //echo $key_1_value;
} 
?>
 <b> What this professor says about it: <?php echo $key_5_value ?></b><br><br>

The Professor: <?php get_author_posts_url( $author_id ); ?><br/>


<?php
the_terms( $post->ID, 'category_tags' ,  ' ' );
                    ?>
					  <strong>Categories: </strong>
                <?php  
                the_terms( $post->ID, 'age_group_tags' ,  ' ' );
                    ?>
					 <strong>Age Group: </strong>
					<?php
	//var_dump(get_post_meta($post->ID));
//echo "<pre>"; print_r($post->ID); echo "</pre>";
					?>
					<br><br>
<?php
}	
}

	?>
				<?php comments_template( '', true ); ?>
			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>