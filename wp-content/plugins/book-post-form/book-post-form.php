<?php
/*
Plugin Name: Book Post Form
Plugin URI: http://example.com
Description: The User-Facing book recommendation form. 
Version: 1.0
Author: Bookworms
*/

$post_meta    = get_post_meta( get_the_id() );

// Sanitize all fields for output.
$title        = esc_attr( $post_meta['book_title'][0] );
$isbn         = esc_attr( $post_meta['book_isbn'][0] );
$author       = esc_attr( $post_meta['book_author'][0] );
$description  = sanitize_text_field( $post_meta['book_description'][0] );
$url          = esc_attr( $post_meta['book_url'][0] );
$thumbnail    = esc_attr( $post_meta['book_thumbnail'][0] );

function get_public_page_title()
{
    echo"
    <!-- CSS Files -->
    <link href='wp-content/plugins/book-post-form/css/select2.css' rel='stylesheet'>
    <link href='wp-content/plugins/book-post-form/css/book-select.css' rel='stylesheet'>

    <!-- Actual Book Post Form -->
    <div class='book-wrap book-wrap-half'>
        <div id='book-search-text' class='book-wrap book-wrap-left book-search'></div>

        <div class='under-selector'>
            <label id='book-select-thumbnail-label' for='book-select-thumbnail'>
                <p><strong>Thumbnail</strong></p>
                <input class='large-text' type='text' name='book-select-thumbnail' id='book-select-thumbnail' value='<?php echo $thumbnail; ?>' hidden />
            </label>
            <div class='book-wrap'>
                <img id='book-select-thumbnail-img' src='<?php echo $thumbnail; ?>' />
            </div>
            
            <div class='book-tags'>
                <label id='book-select-tag-label' for='book-select-tags'>
                    <p><strong>Tags</strong></p>
                    <input type='checkbox' id='book-select-tag' name='book-select-tag' value='ui'/>UI<br>
                    <input type='checkbox' id='book-select-tag' name='book-select-tag' value='ux'/>UX<br>
                    <input type='checkbox' id='book-select-tag' name='book-select-tag' value='hci'/>HCI<br>
                </label>

                <label id='book-select-tag-label' for='book-select-tags'>
                    <p><strong>Audience</strong></p>
                    <input type='checkbox' id='book-select-audience' name='book-select-audience' value='ugrad'/>Undergraduate<br>
                    <input type='checkbox' id='book-select-audience' name='book-select-audience' value='grad'/>Graduate<br>
                    <input type='checkbox' id='book-select-audience' name='book-select-audience' value='pgrad'/>Post-Gradaute<br>
                </label>
            </div>
        </div>
    </div>

    <div class='book-wrap book-wrap-half'>
        <label id='book-select-title-label' for='book-select-title'>
            <p><strong>Title</strong></p>
            <input class='large-text' id='book-select-title' type='text' name='book-select-title' value='<?php echo $title; ?>' readonly />
        </label>

        <label id='book-select-author-label' for='book-select-author'>
            <p><strong>Author</strong></p>
            <input class='large-text' id='book-select-author' type='text' name='book-select-author' value='<?php echo $author; ?>' readonly />
        </label>

        <label id='book-select-url-label' for='book-select-url'>
            <p><strong>Book URL</strong></p>
            <input class='large-text' id='book-select-url' type='text' name='book-select-url' value='<?php echo $url; ?>' readonly />
        </label>

        <label id='book-select-isbn-label' for='book-select-isbn'>
            <p><strong>ISBN</strong></p>
            <input class='large-text' id='book-select-isbn' type='text' name='book-select-isbn' value='<?php echo $isbn; ?>' readonly />
        </label>

        <label id='book-select-description-label' for='book-select-description'>
            <p><strong>Official Description</strong></p>
            <textarea class='large-text' rows='6' id='book-select-description' name='book-select-description' readonly><?php echo $description; ?></textarea>
        </label>

        <div class='post-button' id='submit-buttom'>
            <button id='submit' text='Submit'>Submit</button>
        </div>
    </div>

    <!-- Used for clearing floats -->
    <div style='clear: both;'></div>

    <!-- JS Files -->
    <script src='wp-content/plugins/book-post-form/js/jquery.min.js' type='text/javascript'></script>
    <script src='wp-content/plugins/book-post-form/js/select2.min.js' type='text/javascript'></script>
    <script src='wp-content/plugins/book-post-form/js/book-query.js'  type='text/javascript'></script>
    <script src='wp-content/plugins/book-post-form/js/public.js'  type='text/javascript'></script>
    ";
}

function bpf_shortcode() {
	ob_start();
	get_public_page_title();
	return ob_get_clean();
}

add_shortcode( 'book-post-form', 'bpf_shortcode' );

?>