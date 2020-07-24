<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://localhost/chitra-wordpress/
 * @since             1.0.0
 * @package           Wp_Book
 *
 * @wordpress-plugin
 * Plugin Name:       wp_book
 * Plugin URI:        http://localhost/chitra-wordpress/?page_id=2
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            cvdeshmukh
 * Author URI:        http://localhost/chitra-wordpress/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-book
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


add_action('init', 'create_wp_book_type' ,0);
function create_wp_book_type() 
{
   register_post_type( 'book',
      array(
         'labels' => array(
            'name' => __( 'Books' ),
            'singular_name' => __( 'Book' )
         ),
      'public' => true,
      'has_archive' => true,
      'supports' => array('title','editor','thumbnail')
      )
   );
}


//hook into the init action and call create_book_taxonomies when it fires
add_action( 'init', 'create_wp_book_Category_hierarchical_taxonomy', 0 );
 
//create a custom taxonomy name it topics for your posts
 
function create_wp_book_Category_hierarchical_taxonomy() {
 
// Add new taxonomy, make it hierarchical like categories
//first do the translations part for GUI
 
  $labels = array(
    'name' => _x( 'wp_book_Category', 'taxonomy general name' ),
    'singular_name' => _x( 'wp_book_Category', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search wp_book_Category' ),
    'all_items' => __( 'All wp_book_Category' ),
    'parent_item' => __( 'Parent wp_book_Category' ),
    'parent_item_colon' => __( 'Parent wp_book_Category:' ),
    'edit_item' => __( 'Edit wp_book_Category' ), 
    'update_item' => __( 'Update wp_book_Category' ),
    'add_new_item' => __( 'Add New wp_book_Category' ),
    'new_item_name' => __( 'New wp_book_Category' ),
    'menu_name' => __( 'wp_book_Category' ),
  );    
 
// Now register the taxonomy
 
  register_taxonomy('wp_book_Category',array('post'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'wp_book_Category' ),
  ));
 
}




//hook into the init action and call create_topics_nonhierarchical_taxonomy when it fires
 
add_action( 'init', 'create_wp_book_tag_nonhierarchical_taxonomy');
 
function create_wp_book_tag_nonhierarchical_taxonomy() {
 
// Labels part for the GUI
 
  $labels = array(
    'name' => _x( 'wp_book_tag', 'taxonomy general name' ),
    'singular_name' => _x( 'wp_book_tag', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search wp_book_tag' ),
    'popular_items' => __( 'Popular wp_book_tag' ),
    'all_items' => __( 'All wp_book_tag' ),
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' => __( 'Edit wp_book_tag' ), 
    'update_item' => __( 'Update wp_book_tag' ),
    'add_new_item' => __( 'Add New wp_book_tag' ),
    'new_item_name' => __( 'New Topic Name' ),
    'separate_items_with_commas' => __( 'Separate wp_book_tag with commas' ),
    'add_or_remove_items' => __( 'Add or remove wp_book_tag' ),
    'choose_from_most_used' => __( 'Choose from the most used wp_book_tag' ),
    'menu_name' => __( 'wp_book_tag' ),
  ); 
 
// Now register the non-hierarchical taxonomy like tag
 
  register_taxonomy('wp_book_tag','post',array(
    'hierarchical' => false,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var' => true,
    'rewrite' => array( 'slug' => 'wp_book_tag' ),
  ));
}


  /**
 * Register meta boxes.
 */
function wp_book_mb_register_meta_boxes() {
    add_meta_box( 'wp_book_mb', __( 'New_Metabox wp_book_mb', 'wp_book' ), 'wp_book_mb_display_callback', 'post' );
}
add_action( 'add_meta_boxes', 'wp_book_mb_register_meta_boxes' );

/**
 * Meta box display callback.
 *
 * @param WP_Post $post Current post object.
 */
 

/**
 * Save meta box content.
 *
 * @param int $post_id Post ID
 */
function wp_book_mb_save_meta_box( $post_id ) 
{
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( $parent_id = wp_is_post_revision( $post_id ) ) 
	{
        $post_id = $parent_id;
    }
    $fields = array('wp_book_mb_author','wp_book_mb_published_year','wp_book_mb_price','wp_book_mb_publisher','wp_book_mb_edition');
		
		
     foreach($fields as $value ) 
	 {
        if ( array_key_exists($value, $_POST ) )
			{
            update_post_meta( $post_id, $value, sanitize_text_field( $_POST[$value] ) );
            }
     }
}
add_action( 'save_post', 'wp_book_mb_save_meta_box' );

//function wp_book_mb_display1_callback( $post ) {
   // include 'new1.js';
//}

function wp_book_mb_display_callback( $post ) {
    include 'form.php';
	//include 'single.php';
	

}



 // function slideshow_fun(){

  // }
 //  add_shortcode('slideshow_shortcode','slideshow_fun'); 
  ?>

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WP_BOOK_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-book-activator.php
 */
function activate_wp_book() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-book-activator.php';
	Wp_Book_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-book-deactivator.php
 */
function deactivate_wp_book() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-book-deactivator.php';
	Wp_Book_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_book' );
register_deactivation_hook( __FILE__, 'deactivate_wp_book' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-book.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_book() {

	$plugin = new Wp_Book();
	$plugin->run();

}
run_wp_book();
