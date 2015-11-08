<?php get_header(); ?>
<section id="primary">
    <div id="content" role="main" style="width: 80%">
    	<br>
		<b>About <?php the_author_meta('user_firstname'); ?> <?php the_author_meta('user_lastname'); ?></b><br>
		<b>Email:</b> <a href="mailto:<?php the_author_meta('user_email');?>"><?php the_author_meta('user_email');?></a><br>
		<b>Website:</b> <a href="<?php the_author_meta('user_url'); ?>"><?php  the_author_meta('user_url'); ?></a><br></font><br>
		<?php echo get_avatar( get_the_author_meta( 'ID' ) , 32 ); ?>
		<?php if ( is_user_logged_in() ) { ?><a href="<?php home_url();?>/wp-admin/post-new.php?post_type=rex">Click me to add a new book!</a><br><br>
<?php } ?>
		<b>Posts by <?php the_author()?>:</b><br><br><br>
		
	    <?php if ( have_posts() ) : ?>
	    <b>Book Recommendations</b><br><br>
            <!-- Start the Loop -->
            <?php while ( have_posts() ) : the_post(); ?>
                <!-- Display review title and author -->
                <a href="<?php the_permalink(); ?>"></a>
                <img src="<?php echo esc_html( get_post_meta( get_the_ID(), 'book_thumbnail', true ) ); ?>" align="left" style="padding: 5px;">
                
                <b>  Book Title:</b> <?php echo esc_html( get_post_meta( get_the_ID(), 'book_title', true ) ); ?><br><br>
                <b>  By:</b> <?php echo esc_html( get_post_meta( get_the_ID(), 'book_author', true ) ); ?><br><br>
                <a href="<?php echo esc_html( get_post_meta( get_the_ID(), 'book_url', true ) ); ?>">Google Books URL</a><br><br>
                <b>Posted By:</b> <a href="<?php echo get_author_posts_url( $author_id); ?>"> <?php echo the_author_meta('user_firstname',$author_id);?> <?php echo the_author_meta('user_lastname',$author_id);?></a> <br/>
                <b>  Blurb:</b> <?php echo esc_html( get_post_meta( get_the_ID(), 'book_blurb', true ) ); ?><br><br>
                <b>Categories: </b> <?php the_terms( $post->ID, 'category_tags' ,  ' ' );?><br>
                <b>Age Group: </b> <?php the_terms( $post->ID, 'age_group_tags' ,  ' ' );?><br>
                <br><br>
            <?php endwhile; ?>
 
            <!-- Display page navigation -->
	 
	        </table>
	        <?php global $wp_query;
	        if ( isset( $wp_query->max_num_pages ) && $wp_query->max_num_pages > 1 ) { ?>
	            <nav id="<?php echo $nav_id; ?>">
	                <div class="nav-previous"><?php next_posts_link( '<span class="meta-nav">&larr;</span> Older reviews'); ?></div>
	                <div class="nav-next"><?php previous_posts_link( 'Newer reviews <span class= "meta-nav">&rarr;</span>' ); ?></div>
	            </nav>
	        <?php };
	    endif; ?>
    </div>
</section>
<br /><br />
<?php get_footer(); ?>