<?php
/**
 * Template Name: Books2
 */

/* Edited by Bookworms
*/
 
get_header(); ?>
<link href="css/rexcss.css" rel="stylesheet">
<div class="entry-content">
  <h1>Welcome to Booklist!</h1>
  <h2>All Recommended Books </h2>
  <?php
    $loop = new WP_Query( array( 'post_type' => 'rex' ) );
    while ( $loop->have_posts() ) : 
      $loop->the_post();

      $title = esc_html( get_post_meta( get_the_ID(), 'book_title', true ) );
      $author = esc_html( get_post_meta( get_the_ID(), 'book_author', true ) );
      $url = esc_html( get_post_meta( get_the_ID(), 'book_url', true ) );
      $description = esc_html( get_post_meta( get_the_ID(), 'book_description', true ) );
      $thumbnail = esc_html( get_post_meta( get_the_ID(), 'book_thumbnail', true ) );
      $blurb = wpautop( get_post_meta( get_the_ID(), 'book_blurb', true ) );
      $author_id = $post->post_author;
      $recommender_url = get_author_posts_url( $author_id );
  ?>

  <hr />
  <div class="book_listing group">
      <img src="<?php echo $thumbnail; ?>" alt="<?php echo $title; ?>">
    <p class="book_title"><?php echo $title; ?></p>
    <p class="book_aut"><?php echo $author; ?></p>
    <p class="book_recommend">Recommended by <a href ="https://booklist.ics.uci.edu/?page_id=188">David G. Kay</a></p>

<!-- <a href="<?php echo $recommender_url; ?>"><?php the_author_meta( 'first_name', $author_id ); echo ' '; the_author_meta( 'last_name', $author_id ); ?></a></p> -->
    <p class="book_paragraph"><?php echo $blurb; ?></p>
    <p class = "description">Description: <?php echo $description;?></p>
    <a class = "gb_more" href="<?php echo $url; ?>" target="_blank">More...</a>
    <p class = "catergory_tags">Tags: <?php the_terms( $post->ID, 'category_tags');?></p>
    <p class = "age_group_tags">Level: <?php the_terms( $post->ID, 'age_group_tags');?></p>
    
  </div>

  <?php endwhile; ?>
  <hr />

</div>
<?php get_footer(); ?>