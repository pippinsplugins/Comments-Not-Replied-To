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
	 * Initializes the plugin by setting localization, filters, and administration functions.
	 * 
	 * @since	1.0
	 */
	function __construct() {
		
		// Load plugin textdomain
		add_action( 'init', array( $this, 'plugin_textdomain' ) );
		
		// Add the 'Missing Reply' custom column
		add_filter( 'manage_edit-comments_columns', array( $this, 'missing_reply_column' ) );
		add_filter( 'manage_comments_custom_column', array( $this, 'missing_reply_display' ), 10, 2 );

	} // end constructor
	
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
	 *---------------------------------------------*/
	 
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
	  * Adds a new column to the 'All Comments' page for indicating whether or not
	  * the given comment has not received a reply from the post author.
	  *
	  * @param	array	$columns	The array of columns for the 'All Comments' page
	  * @return	array				The array of columns to display
	  * 
	  * @since	1.0
	  */
	 public function missing_reply_display( $column_name, $comment_id ) {
		 
		 // If we're looking at the 'Missing Reply' column...
		 if( 'missing-reply' == trim ( $column_name ) ) {
			 // TODO
		 } // end if
		 
	 } // end missing_reply_display
  
} // end class

new Comments_Not_Replied_To();
