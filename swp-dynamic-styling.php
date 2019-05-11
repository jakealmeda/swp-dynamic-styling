<?php
/**
 * Plugin Name: SmarterWebPackages - Dynamic Styling
 * Description: Adds selectors to target(s) upon page load
 * Version: 1.0
 * Author: Jake Almeda
 * Author URI: http://smarterwebpackages.com/
 * Network: true
 * License: GPL2
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// Register Custom Post Type
include_once( 'swp-dynamic-cpt.php' );

// Main Class
class SWPDynaStyleFunction {

	// MAIN FUNCTION TO RETRIEVE CPT ENTRIES
	public function swpdynastyling() {

		$args = array(
			'post_type' 		=> 'styling',
			'post_status'		=> 'publish',
			'posts_per_page'	=> -1,
			'orderby'			=> 'date',
			'order'				=> 'ASC'
		);

		// The Query
		$query = new WP_Query( $args );

		if ( $query->have_posts() ) {

			// The Loop
			while ( $query->have_posts() ) {

				$query->the_post();

				$target = get_post_meta( get_the_ID(), 'target', TRUE);
				//$image = wp_get_attachment_url( get_post_meta( get_the_ID(), 'image', TRUE)[ 'ID' ] );

				$return[] = array(
					'target' => get_post_meta( get_the_ID(), 'target', TRUE),
					'selectors' => get_post_meta( get_the_ID(), 'selectors', TRUE),
				);
				
			}
			
			/* Restore original Post Data 
			 * NB: Because we are using new WP_Query we aren't stomping on the 
			 * original $wp_query and it does not need to be reset with 
			 * wp_reset_query(). We just need to set the post data back up with
			 * wp_reset_postdata().
			 */
			wp_reset_postdata();

		}

		return $return;

	}

	// ENQUEUE SCRIPT
	public function swp_enqueue_jquery_script() {

		// enqueue needed native jQuery files | NOTE SURE WHY WE HAVE TO DO THIS
	    /*if( !wp_script_is( 'jquery', 'enqueued' ) ) {
	        wp_enqueue_script( 'jquery' );
	    }*/

		// Register the script
		wp_register_script( 'swp_dynastyle_js', plugins_url( 'js/asset.js', __FILE__ ), NULL, '1.1.0', TRUE );
		
		// Localize the script with new data
		$swp_ds = array(
		    'dynastyles' => $this->swpdynastyling(),
		);
		wp_localize_script( 'swp_dynastyle_js', 'swp_dynastyle', $swp_ds );

		// Enqueued script with localized data.
		wp_enqueue_script( 'swp_dynastyle_js' );

	}

	// CONSTRUCT
	public function __construct() {

		add_action( 'wp_enqueue_scripts', array( $this, 'swp_enqueue_jquery_script' ) );

	}

}

$z = new SWPDynaStyleFunction();