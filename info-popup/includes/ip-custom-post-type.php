<?php
/*
* Info Popup Custom Post Type display.
*/

/*
* Registering Popup custom post type 
*/
global $submenu;;
// print_r($submenu);

function ip_register_custom_post_type(){

	/*add_menu_page( 'Info Popup title',
		'Info Popup Menu',
		'manage_options',
		'ip',
		'ip_func_inside_settings',
		'dashicons-email'
	);
*/
      $labels = array(
       'name'               => _x('Info Popups', 'Post Type General Name', '' ),
       'singular_name'      => _x('Popup', 'Post Type Singular Name', '' ),
       'menu_name'          => __('Popups', ''),
       'name_admin_bar'     => __('Popup', ''),
       'add_new'            => __('Add New Popup', ''),
       'add_new_item'       => __('Add New Popup', ''),
       'new_item'           => __('New Popup', ''),
       'edit_item'          => __('Edit Popup', ''),
       'view_item'          => 'View Popup',
       'all_items'          => 'All Popups',
       'search_items'       => 'Search Popups',
       'parent_item_colon'  => 'Parent Popup:', 
       'not_found'          => 'No Locations found.', 
       'not_found_in_trash' => 'No Locations found in Trash.',
     );
       //arguments for post type
      $args = array(
       'label'             =>  __( 'Popup', ''),
       'labels'            => $labels,
       'public'            => true,
       'publicly_queryable'=> true,
       'show_ui'           => true,
       'show_in_menu'      => true,
       'show_in_nav_menus' => true,
       'query_var'         => true,
       'hierarchical'      => false,
       'supports'          => array('title','custom-fields'),
       'has_archive'       => true,
       'menu_position'     => 25,
       'show_in_admin_bar' => true,
       'menu_icon'         => 'dashicons-format-status',
       'rewrite'           => array('slug' => 'Popups', 'with_front' => 'true'),
       'capability_type'   => 'page',
     );
      register_post_type('Popups',$args);
}

/*
*Function to remove the "Add new cpt submenu"
*/
// function disable_new_posts() {
//     // Hide sidebar link
//     global $submenu;
//     unset($submenu['edit.php?post_type=popups'][10]);

//     // Hide link on listing page
//     if (isset($_GET['post_type']) && $_GET['post_type'] == 'popup') {
//         echo '<style type="text/css">
//         #favorite-actions, .add-new-h2, .tablenav { display:none; }
//         </style>';
//     }
// }
// add_action('admin_menu', 'disable_new_posts');

// function ip_add_info_submenu(){
// 	/*Adding a submenu*/
// 	add_submenu_page(
// 		'edit.php?post_type=popups',
// 		'Settings',
// 		'Add new Popup',
// 		'manage_options',
// 		'Rahul_slug',
// 		'add_submenu_func'
// 	);

	/*
	* callback function for add_submenu_page
	*/
/*	function add_submenu_func(){
		require_once IP_ABSPATH . 'includes/ip-submenu.php';
	}
*/
// add_action('admin_menu','ip_add_info_submenu', 10);

