<?php
/*
Plugin Name: Front End Rex
Plugin URI: http://example.com
Description: The User-Facing book recommendation form. 
Version: 1.0
Author: Bookworms
*/

function html_form_code() {
	echo '<form action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">';
	//Book Title
	echo '<p>';
	echo 'Title of Book (required) <br/>';
	echo '<input type="text" name="br-title" pattern="[A-Za-z0-9\s\-_,\.;:()]+" value="' . ( isset( $_POST["br-title"] ) ? esc_attr( $_POST["br-title"] ) : '' ) . '" size="40" required/>';
	echo '</p>';
	//Book Author
	echo '<p>';
	echo 'Author of Book (required) <br/>';
	echo '<input type="text" name="br-author" pattern="[a-zA-Z]+" value="' . ( isset( $_POST["br-author"] ) ? esc_attr( $_POST["br-author"] ) : '' ) . '" size="40" required/>';
	echo '</p>';
	//ISBN
	echo '<p>';
	echo 'ISBN (optional) <br/>';
    /*CHECK TO MAKE SURE PATTERN WORKS*/
	echo '<input type="text" name="br-isbn" pattern="[^(97(8|9))?\d{9}(\d|X)$]+" value="' . ( isset( $_POST["br-isbn"] ) ? esc_attr( $_POST["br-isbn"] ) : '' ) . '" size="40" />';
	echo '</p>';
	echo '<p>';
	//Why
	echo 'Why Are You Recommending This Book? <br/>';
	echo '<textarea rows="10" cols="35" name="br-blurb">' . ( isset( $_POST["br-blurb"] ) ? esc_attr( $_POST["br-blurb"] ) : '' ) . '</textarea>';
	echo '</p>';
    echo '<p>';
	//Suggested Categories
	echo 'What Topics Does the Book Cover? <br/>';
	echo '<input type="checkbox" name="sug-cat[]" value="design">Design<br>';
	echo '<input type="checkbox" name="sug-cat[]" value="ui">UI<br>';
    echo '<input type="checkbox" name="sug-cat[]" value="ux">UX<br>';
    echo '<input type="checkbox" name="sug-cat[]" value="hci">HCI<br>';
    echo '<input type="checkbox" name="sug-cat[]" value="se">Software Engineering<br>';
    echo '<input type="checkbox" name="sug-cat[]" value="agile">Agile<br>'
        /*CHECK IF THIS IS FORMATTED PROPERLY*/
        . ( isset( $_POST["sug-cat"] ) ? esc_attr( $_POST["sug-cat"] ) : '' );
	echo '</p>';
    echo '<p>';
	//Audience Level
	echo 'Who Is This Book Recommended For? <br/>';
    echo '<input type="checkbox" name="br-level[]" value="gen_pub">General Public<br>';
	echo '<input type="checkbox" name="br-level[]" value="ug">Undergrad<br>';
    echo '<input type="checkbox" name="br-level[]" value="grad">Graduate<br>';
    echo '<input type="checkbox" name="br-level[]" value="pgrad">Post Graduate<br>'
        /*CHECK IF THIS IS FORMATTED PROPERLY*/
        . ( isset( $_POST["br-level"] ) ? esc_attr( $_POST["br-level"] ) : '' );
	echo '</p>';
	echo '<p><input type="submit" name="br-submitted" value="Send Recommendation"></p>';
	echo '</form>';
}

function deliver_mail() {

	// if the submit button is clicked, send the email
	if ( isset( $_POST['br-submitted'] ) ) {

		// sanitize form values
		$name    = sanitize_text_field( $_POST["br-name"] );
		$book_title   = sanitize_text_field( $_POST["br-title"] );
        	$book_isbn   = sanitize_text_field( $_POST["br-isbn"] );
       		$book_blurb   = esc_textarea( $_POST["br-blurb"] );
        	$book_categories   = esc_textarea( $_POST["br-categories"] );
		

		$book_levels = $_POST["br-level"];
		/*foreach ($book_levels as $book_level) {
			array_push($book_levels, $book_level);
		}*/
		$book_levels_together = join(', ', $book_levels);

		// get the blog administrator's email address
		$to = 'atterreri@gmail.com';//get_option( 'admin_email' );
        
        $subject = 'Booklist New Book Recommendation from '.$name;
        
        //CHECK TO MAKE SURE FORMATTING IS RIGHT
        $message = ' Title: '.$book_title.'
 ISBN (optional): '.$book_isbn.'
 Blurb: '.$book_blurb.'
 Categories: '.$book_categories.'
 Level(s): '.$book_levels_together;
        
		$headers = "From: ".$name."
";

		// If email has been process for sending, display a success message
		if ( wp_mail( $to, $subject, $message, $headers ) ) {
			echo '<div>';
			echo '<p>Thanks for sending your recommendation. It will be processed and posted shortly.</p>';
			echo '</div>';
		} else {
			echo 'An unexpected error occurred';
		}
	}
}

function br_shortcode() {
	ob_start();
	deliver_mail();
	html_form_code();

	return ob_get_clean();
}

add_shortcode( 'front-end-rex', 'br_shortcode' );

?>