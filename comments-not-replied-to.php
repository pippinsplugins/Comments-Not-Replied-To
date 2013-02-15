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

class Comments_Not_Replied_To {
	 
	/*--------------------------------------------*
	 * Constructor
	 *--------------------------------------------*/
	
	/**
	 * Initializes the plugin by setting localization, filters, and administration functions.
	 */
	function __construct() {
		
		// Load plugin textdomain
		add_action( 'init', array( $this, 'plugin_textdomain' ) );

	} // end constructor
	
	/*--------------------------------------------*
	 * Dependencies
	 *--------------------------------------------*/
	
	/**
	 * Loads the plugin text domain for translation
	 */
	public function plugin_textdomain() {
	
		// TODO: replace "plugin-name-locale" with a unique value for your plugin
		load_plugin_textdomain( 'cnrt', false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );
		
	} // end plugin_textdomain
	
	/*--------------------------------------------*
	 * Actions and Filters
	 *---------------------------------------------*/
  
} // end class

new Comments_Not_Replied_To();
