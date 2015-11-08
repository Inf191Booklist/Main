<?php get_header(); ?>
<section id="primary">
    <div id="content" role="main" style="width: 80%">
    <?php if ( have_posts() ) : ?>
        <header class="page-header">
            <h1 class="page-title">Books Under This Category</h1>
        </header>
        <!-- Display table headers -->
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