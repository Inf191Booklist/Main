<?php
 /*Template Name: New Template
 */
 
get_header(); ?>
<div id="primary">
    <div id="content" role="main" style="padding:10px">
    <!-- Display review title and author -->
    	<img src="<?php echo esc_html( get_post_meta( get_the_ID(), 'book_thumbnail', true ) ); ?>" align="left" style="padding: 5px;">
    
		<b>Book Title:</b> <?php echo esc_html( get_post_meta( get_the_ID(), 'book_title', true ) ); ?><br><br>
        <a href="<?php the_permalink(); ?>"></a><br><br>
        <b>By:</b> <?php echo esc_html( get_post_meta( get_the_ID(), 'book_author', true ) ); ?><br><br>
        <b>URL:</b> <?php echo esc_html( get_post_meta( get_the_ID(), 'book_url', true ) ); ?><br><br>
        <b>Description:</b> <?php echo esc_html( get_post_meta( get_the_ID(), 'book_description', true ) ); ?><br><br>
</div>
<?php wp_reset_query(); ?>
<?php get_footer(); ?>