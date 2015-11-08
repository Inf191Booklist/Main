<?php
/**
 * Template Name: Books2
 */
 
get_header(); ?>

<div class="entry-content">
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
    <div style="float:left;text-align:center;">
      <img src="<?php echo $thumbnail; ?>" alt="<?php echo $title; ?>" class="alignnone size-full wp-image-619" style="float:none;">
      <br />
      <a href="<?php echo $url; ?>" target="_blank">Link to Google Books</a>
      <br />
      <?php the_terms( $post->ID, 'category_tags' ,  '<br />' );?>
      <?php the_terms( $post->ID, 'age_group_tags' ,  '<br />' );?>
    </div>
    <p class="book_title" style="font-family: District-Medium, Helvetica; font-weight: normal; font-style: normal;"><?php echo $title; ?></p>
    <p class="book_subtitle" style="font-family: District-BoldItalic, Helvetica; font-weight: normal; font-style: normal;">By <?php echo $author; ?></p>
    <p class="book_subtitle" style="font-family: District-BoldItalic, Helvetica; font-weight: normal; font-style: normal;">Recommended by <a href="<?php echo $recommender_url; ?>"><?php the_author_meta( 'first_name', $author_id ); echo ' '; the_author_meta( 'last_name', $author_id ); ?></a></p>
    <p class="book_paragraph" style="font-family: District-BoldItalic, Helvetica; font-weight: normal; font-style: normal;"><?php echo $blurb; ?></p>
  </div>

  <?php endwhile; ?>
  <hr />

</div>
<?php get_footer(); ?>