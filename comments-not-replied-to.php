<?php
/*
Plugin Name: Comments Not Replied To
Plugin URI: http://github.com/pippinsplugins/Comments-Not-Replied-To/
Description: Easily see which comments have not received a reply from each post's author.
Version: 0.1
Author: Pippin Williamson, Andrew Norcross, Tom McFarlin
License:

  Copyright 2013 Pippin Williamson, Andrew Norcross, Tom McFarlin

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/

/**
 * @version 0.1
 */
class Comments_Not_Replied_To {

	/*--------------------------------------------*
	 * Constructor
	 *--------------------------------------------*/

	/**
	 * Static property to hold our singleton instance
	 *
	 * @since	1.0
	 */
	static $instance = false;

	/**
	 * Initializes the plugin by setting localization, filters, and administration functions.
	 * constructor is private to force the use of getInstance() to make this a Singleton
	 *
	 * @since	1.0
	 */
	private function __construct() {

		// Load plugin textdomain
		add_action( 'init', array( $this, 'plugin_textdomain' ) );

		// Add the 'Missing Reply' custom column
		add_filter( 'manage_edit-comments_columns', array( $this, 'missing_reply_column' ) );
		add_filter( 'manage_comments_custom_column', array( $this, 'missing_reply_display' ), 10, 2	);

		// add separate admin page in comments
		add_action( 'admin_menu', array( $this, 'missing_reply_page' ) );

	} // end constructor

	/**
	 * If an instance exists, this returns it.  If not, it creates one and
	 * retuns it.
	 *
	 * @since	1.0
	 */

	public static function getInstance() {
		if ( !self::$instance )
			self::$instance = new self;
		return self::$instance;
	} // end getInstance

	/*--------------------------------------------*
	 * Dependencies
	 *--------------------------------------------*/

	/**
	 * Loads the plugin text domain for translation
	 *
	 * @since	1.0
	 */
	public function plugin_textdomain() {
		load_plugin_textdomain( 'cnrt', false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );
	} // end plugin_textdomain

	/*--------------------------------------------*
	 * Actions and Filters
	 *--------------------------------------------*/

	/**
	 * Adds a new column to the 'All Comments' page for indicating whether or not
	 * the given comment has not received a reply from the post author.
	 *
	 * @param	array	$columns	The array of columns for the 'All Comments' page
	 * @return	array				The array of columns to display
	 *
	 * @since	1.0
	 */
	public function missing_reply_column( $columns ) {

		$columns['missing-reply'] = __( 'Missing Reply', 'cnrt' );

		return $columns;

	} // end missing_reply_column

	 /**
	  * Calls function for new page to the under the 'Comments' page for indicating whether or not
	  * the given comment has not received a reply from the post author.
	  *
	  * @return	array				The array of columns to display
	  *
	  * @since	1.0
	  */
	 public function missing_reply_display( $column_name, $comment_id ) {

		 // If we're looking at the 'Missing Reply' column...
		 if( 'missing-reply' == trim ( $column_name ) ) {

			 // If the comment is by the author, then we'll note that its been replied
			 if( $this->comment_is_by_post_author( $comment_id ) ) {

				 _e( 'This comment is by the post author.', 'cnrt' );

			 // Otherwise, let's look at the replies to determine if the author has made a reply
			 } else {

				// First, we get all of the replies for this comment
				$replies = $this->get_comment_replies( $comment_id );

				// Note whether or not the comment author has replied.
				if( $this->author_has_replied( $replies ) ) {
					_e( 'The post author has repied.', 'cnrt' );
				} else {
					_e( 'The author has not replied.', 'cnrt' );
				} // end if

			 } // end if/else


		 } // end if

	 } // end missing_reply_display

	/*--------------------------------------------*
	 * Helper Functions
	 *--------------------------------------------*/

	/**
	 * Initializes the plugin by setting localization, filters, and administration functions.
	 *
	 * @param	int		$comment_id		The ID of the comment for the given post.
	 * @return	bool					Whether or not the comment is also by the the post author
	 * @since	1.0
	 */
	 private function comment_is_by_post_author( $comment_id ) {

		 $comment = get_comment( $comment_id );
		 $post = get_post ( $comment->comment_post_ID );

		 return $comment->comment_author_email == $this->get_post_author_email( $post->ID );

	 } // end if

	/**
	 * Retrieves all of the replies for the given comment.
	 *
	 * @param	int		$comment_id		The ID of the comment for which to retrieve replies.
	 * @return	array					The array of replies
	 * @since	1.0
	 */
	 private function get_comment_replies( $comment_id ) {

		 global $wpdb;
		 $replies = $wpdb->get_results(
		 	$wpdb->prepare(
		 		"SELECT comment_ID, comment_author_email, comment_post_ID FROM $wpdb->comments WHERE comment_parent = %d",
		 		$comment_id
		 	)
		 );

		 return $replies;

	 } // end get_comment_replies

	/**
	 * Determines whether or not the author has replied to the comment.
	 *
	 * @param	array	$replies		The array of replies for a given comment.
	 * @return	bool					Whether or not the post author has replied.
	 * @since	1.0
	 */
	 private function author_has_replied( $replies ) {

		 $author_has_replied = false;

		 // If there are no replies, the author clearly hasn't replied
		 if( 0 < count( $replies ) ) {

			 $comment_count = 0;
			 while( $comment_count < count ( $replies ) && ! $author_has_replied ) {

				 // Read the current comment
				 $current_comment = $replies[ $comment_count ];

				 // If the comment author email address is the same as the post author's address, then we've found a reply by the author.
				 if( $current_comment->comment_author_email == $this->get_post_author_email( $current_comment->comment_post_ID ) ) {
					 $author_has_replied = true;
				 } // end if

				 // Now on to the next comment
				 $comment_count++;

			 } // end while

		 } // end if/else

		 return $author_has_replied;

	 } // end author_has_replied

	/**
	 * Retrieves the email address for the author of the post.
	 *
	 * @param	int		$post_id		The ID of the post for which to retrieve the email address
	 * @return	string					The email address of the post author
	 * @since	1.0
	 */
	 private function get_post_author_email( $post_id ) {

		 // Get the author information for the specified post
		 $post = get_post( $post_id );
		 $author = get_user_by( 'id', $post->post_author );

		 // Let's store the author data as the author
		 $author = $author->data;

		 return $author->user_email;

	 } // end get_post_author_email

	public function missing_reply_page() {
	    add_submenu_page('edit-comments.php', __('Missing Reply', 'cnrt'), __('Missing Reply', 'cnrt'), 'edit_posts', 'missing-reply', array( $this, 'missing_reply_layout' ));

	} // end missing_reply_page

	/**
	 * Adds a new page to the under the 'Comments' page for indicating whether or not
	 * the given comment has not received a reply from the post author.
	 *
	 * @return	array				The array of columns to display
	 *
	 * @since	1.0
	 */

	public function missing_reply_layout() {
		// bail if user doesn't have access to do this
		if (!current_user_can('edit_posts') )
			return;
		?>

		<div class="wrap">
    		<div class="icon32" id="icon-edit-comments"><br></div>
    		<h2><?php _e( 'Comments Missing Reply', 'cnrt' ); ?></h2>

    		THIS WILL HAVE THAT SWEET WORDPRESS UI WE'VE ALL GROWN TO LOVE.

		</div><!-- /.wrap -->

	<?php }  // end missing_reply_layout

} // end class

//$GLOBAL['cnrt'] = new Comments_Not_Replied_To();
// Instantiate our class
$Comments_Not_Replied_To = Comments_Not_Replied_To::getInstance();
