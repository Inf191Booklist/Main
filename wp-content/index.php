<html>
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
			                
				$key_1_value = get_post_meta( get_the_ID(), 'book_title', true );
				$key_3_value = get_post_meta( get_the_ID(), 'book_author', true );
				//echo $key_4_value = get_post_meta( get_the_ID(), 'book_url', true );
				$key_5_value = get_post_meta( get_the_ID(), 'book_blurb', true );
				$key_6_value = get_post_meta( get_the_ID(), 'book_thumbnail', true);
				$key_7_value = get_post_meta( get_the_ID(), 'book_description', true);
				// $author_id=$post->post_author; 
				//echo $author_id;
				//echo the_author_posts_link($author_id);
				//$author = get_the_author();
		 		//echo $author;
 		?>
		<?php //$author_id=$post->post_author; ?>
		<?php // the_author_posts_link(); ?>
		<?php //echo the_author_meta( 'user_nicename' , $author_id ); ?>
		<?php // check if the custom field has a value; ?>
		
		<div id="book">
			<img src="<?php echo $key_6_value ?>" align="left">
			
			<?php
				if( ! empty( $key_1_value ) ) {
					//echo $key_1_value;
				} 
			?>
			<strong><?php echo $key_1_value ?></strong><br>
			
			<?php
				if( ! empty( $key_3_value ) ) {
					//echo $key_1_value;
				} 
			?>
			<b>By: </b><?php echo $key_3_value ?><br><br>
			
			<?php
				if( ! empty( $key_4_value ) ) {
					//echo $key_1_value;
				} 
			?>
			<a href="<?php echo get_post_meta( get_the_ID(), 'book_url', true );?>">Google Books URL</a><br><br>
			 
			<?php
				if( ! empty( $key_5_value ) ) {
					//echo $key_1_value;
				} 
			?>
			<b>Blurb: </b>"<?php echo $key_5_value ?>"<br><br>
			
			<?php $author_id=$post->post_author; ?>
			<b>Posted By:</b> <a href="<?php echo get_author_posts_url( $author_id); ?>"> <?php echo the_author_meta('user_firstname',$author_id);?> <?php echo the_author_meta('user_lastname',$author_id);?></a> <br/>
			
			
			<b>Categories: </b> <?php the_terms( $post->ID, 'category_tags' ,  ' ' );?><br>
			
			<b>Age Group: </b> <?php the_terms( $post->ID, 'age_group_tags' ,  ' ' );?><br>
			
	<!--		<b>Age Group: </b> <?php
				//var_dump(get_post_meta($post->ID));
				//echo "<pre>"; print_r($post->ID); echo "</pre>";
			?>-->
			
			<br><br><br><br>
		</div>
		
		
		<?php comments_template( '', true ); ?>
		<?php endwhile; // end of the loop. ?>

</div><!-- #content -->
</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
</html>