<?php
/**
Info Popup Loader file comment
*/

if ( ! class_exists( 'IP_Loader' ) ) :
class IP_loader{
	/**
	 * Constructor
	 */
	public function __construct(){
		//adding css to the plugin
		add_action('admin_enqueue_scripts',array( $this, 'ip_plugin_dashboard_style') );
		//adding action for custom post type.
		add_action('init', array( $this, 'ip_custom_post_type_settings' ) );
		//adding action for displaying 
		add_action('init', 'ip_register_custom_post_type' );
		//Filter to change the default names.
		add_filter( 'post_updated_messages',array( $this,'custom_post_type_post_update_messages' ) );
		//adding shortcode
		add_action('init', array($this, 'ip_generate_shortcode') );
		//require_once IP_ABSPATH . 'includes/ip-shortcode.php';
		//adding screen options
		add_action('init', array($this, 'ip_cpt_column')  );
		//adding meta box on edit post window.
		add_action('init',array($this, 'ip_show_on_edit_screen') );
	}
	/*
	* function for calling custom post type.
	*/
	public function ip_custom_post_type_settings(){

		require_once IP_ABSPATH . 'includes/ip-custom-post-type.php';

	}

	public function ip_plugin_dashboard_style(){
		// Add the color picker css file.
		wp_enqueue_style( 'wp-color-picker' );

		// Include our custom jQuery file with WordPress Color Picker dependency.
		wp_enqueue_script( 'colorpickerscript', IP_PLUGIN_URL.'/assets/js/color-picker.js', 
			array('jquery','wp-color-picker'), IP_VERSION, true );

		wp_register_style( 'ip_dashboard', IP_PLUGIN_URL . '/assets/css/ip-dashboard-css.css', null, IP_VERSION );

	}

		
	public function ip_generate_shortcode(){
		// echo "inside shortcode";
		add_shortcode( 'info_popup', 'shortcode_func' );
		require_once IP_ABSPATH . 'includes/ip-shortcode.php';
	}

	/* 
	*temporary testing for list tables_to_repair.
	*/

	// ONLY CUSTOM TYPE POSTS
	public function ip_cpt_column(){
		
		add_filter('manage_popups_posts_columns', 'ip_columns_head_only_popups', 10);
 
	// CREATE TWO FUNCTIONS TO HANDLE THE COLUMN
		function ip_columns_head_only_popups($columns) {

			unset($columns['date']);

    		$columns['ip_shortcode_name'] = 'Shortcodes';
    		$columns['date'] = 'Date';
    		return $columns;
		}
	
		add_action('manage_popups_posts_custom_column','ip_populate_custom_columns',10 , 2 );
		

		function ip_populate_custom_columns($column, $post_id){
			//Shortcode column
			$user_shortcode = "[info_popup user_id =". $post_id ." ]";

			if('ip_shortcode_name'=== $column){
				echo get_post_meta($post_id,'info_popup_shortcode', $user_shortcode);
			}

			if('date' === $column ) {
				echo get_the_date( $d = '', $post = $post_id );
			}
		}

	}

	/* Meta box setup function. */
	public function ip_show_on_edit_screen(){
  		/* Add meta boxes on the 'add_meta_boxes' hook. */
		add_action( 'add_meta_boxes' , array( $this , 'ip_add_edit_meta_boxes' ) , 9);

		/*Save post meta on the 'save_post' hook. */
		add_action('save_post', array ( $this,'ip_save_entered_values_meta'), 10, 2);
	}
	/*callback function for add_meta_boxes*/
	function ip_add_edit_meta_boxes(){
		/*adding add_meta-box to add_meta_boxes hook*/
		
		add_meta_box(
		    'ip-post-class',      // Unique ID
		    esc_html__( 'Info Popup Settings', 'info-popup' ),    // Title
		    array($this,'ip_edit_meta_box_callback_func'),	// Callback function
		    'popups',         // Admin page (or post type)
		    'advanced',      // Context
		    'high'         // Priority
		);

		add_meta_box(
		    'ip-post-class1',      // Unique ID
		    esc_html__( 'Copy Shortcode', 'info-popup' ),    // Title
		    array($this,'ip_display_generated_shortcode'),	// Callback function
		    'popups',         // Admin page (or post type)
		    'side',      // Context
		    'low'         // Priority
		);

	}
	/*callback function for add_meta_box */
	function ip_edit_meta_box_callback_func( $post ){

	$a = get_the_ID();
	$value = get_post_meta ($a,'info_popup_data',false);
	// Add a nonce field so we can check for it later.
	// wp_nonce_field( 'ip_nonce_action', 'ip_nonce_field' );
	
	?>

	<div>
		<label for="ip-post-class">
		<table class="form-table">
		<tr>
			<th scope="row">
				<label for="FirstName"><?php esc_attr_e('First Name', 'info-popup')?>:</label>
			</th>
			<td>
				<?php
					echo '<input type="text" name="ip_form_first_name" value = "'. esc_attr( isset ($value[0]['ip_form_first_name'] ) ? $value[0]['ip_form_first_name'] : '').'" >';
				?>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="Lastname"><?php esc_attr_e('Last Name', 'info-popup')?>:</label>
			</th>
			<td>
				<?php
					echo '<input type="text" name="ip_form_last_name" value= "'. esc_attr( isset($value[0]['ip_form_last_name'] ) ? $value[0]['ip_form_last_name'] : '').'" >';
				?>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="Email"><?php esc_attr_e('Email', 'info-popup')?>:</label>
			</th>
			<td>
				<?php
					echo '<input type="text" name="ip_form_email" value= "'. esc_attr( isset($value[0]['ip_form_email'] ) ? $value[0]['ip_form_email'] : '').'" >';
				?>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="Website"><?php esc_attr_e('Website', 'info-popup')?>:</label>
			</th>
			<td>
				<?php
					echo '<input type="text" name="ip_form_website" value= "'. esc_attr( isset($value[0]['ip_form_website'] ) ? $value[0]['ip_form_website'] : '' ).'" required>';
				?>
			</td>
		</tr>
		</table>
			<p class="description">
			<input type="checkbox" id="input_advance" name="ip_advanced_checkbox">
			<?php
				 esc_attr_e( ' &nbsp; Advanced settings: &nbsp; Check this box to set advance settings for Info Popup inputs', 'info-popup' );
				?>
			</p>
			<script type="text/javascript" >
				$(document).ready(function(){
		  			$('#input_advance').change(function() {
		  			if(this.checked) {
		    			$("#advance-settings").show();
  					}
  					else{
  						$("#advance-settings").hide();
  					}
  				})
				});
			</script>
		<div id="advance-settings">
		<table class="form-table">
			
				<tr>
				<th scope="row">
					<label for=InfoFontSize><?php esc_attr_e('Font Size', 'info-popup')?>:</label>
				</th>
				<td>
					<?php
						echo '<input type="number" name="ip_font_size" max="50" min="10" class="small-text" value= "15" required>&nbsp px';
					?>
					<p class="description">
					<?php esc_attr_e( 'Keep blank for default value of Info Popup text inputs.', 'info-popup' ); ?>
					</p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="InfoTextAlign"><?php esc_attr_e('Text Align', 'info-popup')?>:</label>
				</th>
				<td>
				<select id="ip_text_align" name="ip_text_align" required>
				
					<?php

						echo '<option value="Left">';
						esc_attr_e( 'Left', 'info-popup' );
						echo '</option>';
						echo '<option  value="above_the_post_title">';
						esc_attr_e( 'Right', 'info-popup' );
						echo '</option>';
						echo '<option  value="below_the_post_title">';
						esc_attr_e( 'Center', 'info-popup' );
						echo '</option>';
					?>
					</select> 
					<p class="description">
					<?php esc_attr_e( 'This will change the alignment of Info Popup text inputs.', 'info-popup' ); ?>
					</p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="InfoTextColour"><?php esc_attr_e('Text Colour', 'info-popup')?>:</label>
				</th>
				<td>
					<?php
					if(isset ($value[0]['ip_text_colour']) ){
						echo '<input name="ip_text_colour" class="my-color-field" value = "'. esc_attr( $value[0]['ip_text_colour'] ).'" >';
					} else {
						?>
						<input name="ip_text_colour" class="my-color-field" value="#333333">
						<?php
						}
					?>
					<p class="description">
					<?php esc_attr_e( 'This will change the text colour of Info Popup text inputs.', 'info-popup' ); ?>
					</p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="InfoBackgroundColour"><?php esc_attr_e('Background Colour', 'info-popup')?>:</label>
				</th>
				<td>
					<?php
					if(isset ($value[0]['ip_bg_colour']) ){
						echo '<input name="ip_bg_colour" class="my-color-field" value = "'. esc_attr( $value[0]['ip_bg_colour'] ).'" >';
					} else {
					?>
						<input name="ip_text_colour" class="my-color-field" value="#333333">
					<?php
						}
						// echo '<input type="text" name="ip_bg_colour" value= "'. esc_attr( isset($value[0]['ip_bg_colour'] ) ? $value[0]['ip_bg_colour'] : '' ).'" required>';
					?>
					<p class="description">
					<?php esc_attr_e( 'This will change the background colour of Info Popup Modal box.', 'info-popup' ); ?>
					</p>
				</td>
			</tr>
		</table>
		</div>
	</div>
  	<?php
	}

	function ip_display_generated_shortcode(){
		echo'<p class="description"> Copy the Popup shortcode code:</p>';
		$a = get_the_ID();
		$user_shortcode = "[info_popup user_id =". $a ." ]";
		
		echo '<input type="text" name="ip_display_shortcode" size="25" value=" '. get_post_meta($a,'info_popup_shortcode', $user_shortcode) .' ">'; 
		?>
		 <?php
	}

	function ip_save_entered_values_meta($post_id, $post){
		// $post_id = get_the_ID();
		//$get_value= get_post_meta( $post_id,'info_popup_data');
		if(isset($_POST['publish'] ) || isset($_POST['save']) ) {
		$update_inputs = array(
			'ip_form_title'		 => get_the_title( $post_id ),		//1. Collecting Input Title
			'ip_form_first_name' => $_POST['ip_form_first_name'],	//2. Collecting Input First name
			'ip_form_last_name'  =>	$_POST['ip_form_last_name'],	//3. Collecting Input last name
			'ip_form_email' 	 =>	$_POST['ip_form_email'],		//4. Collecting Input email
			'ip_form_website' 	 =>	$_POST['ip_form_website'],		//5. Collecting Input website
			'ip_font_size'		 => $_POST['ip_font_size'],			//6. Collecting Input Font size
			'ip_text_align'		 => $_POST['ip_text_align'],		//7. Collecting Input Text align
			'ip_text_colour'	 => $_POST['ip_text_colour'],		//8. Collecting Input Text Colour
			'ip_bg_colour' 		 => $_POST['ip_bg_colour'],			//9. Collecting Input Bg Colour
		);

		$a=update_post_meta( $post_id,'info_popup_data', $update_inputs);

		$user_shortcode = "[info_popup user_id =". $post_id ." ]";
		//update post meta for shortcode.
		// update_post_meta( $post_id, $meta_key, $meta_value, $prev_value = '' )
		update_post_meta( $post_id, 'info_popup_shortcode' , $user_shortcode);

		// Check if our nonce is set.
		// if ( ! isset( $_POST['ip_nonce_field'] ) ) {
  //       	return;
  //   	}
  //   	// Verify that the nonce is valid.
  //   	if ( ! wp_verify_nonce( $_POST['ip_nonce_field'], 'ip_nonce_action' ) ) {
  //       	return;
  //   	}	
  //   	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	 //    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
	 //        return;
	 //    }

		
	 //    /* OK, it's safe for us to save the data now. */
	 //    if ( ! isset( $_POST['ip-post-class'] ) ) {
  //       	return;
  //   	}

		//sanitize user input
    	// $a=update_post_meta( $post_id,'ip_post_class', $updated_value );
   		 }
	}
	/**
		 * Add Update messages for any custom post type
		 *
		 * Array $messages Array of default messages.
		 */

	public function custom_post_type_post_update_messages( $messages ){

		$custom_post_type = get_post_type( get_the_ID() );
		// var_dump($custom_post_type);
		// wp_die();

		if ( 'popups' == $custom_post_type ){

			$obj 				= get_post_type_object( $custom_post_type );
			$singular_name    	= $obj->labels->singular_name;
			$messages[ $custom_post_type ]= array(
				0 => '', // Unused. Messages start at index 1.
				/* translators: %s: singular custom post type name */
				1  => sprintf( __( '%s updated.', 'Popup' ), $singular_name ),
				/* translators: %s: singular custom post type name */
				2  => sprintf( __( 'Custom %s updated.', 'Popup' ), $singular_name ),
				/* translators: %s: singular custom post type name */
				3  => sprintf( __( 'Custom %s deleted.', 'Popup' ), $singular_name ),
				/* translators: %s: singular custom post type name */
				4  => sprintf( __( '%s updated.', 'Popup' ), $singular_name ),
				/* translators: %1$s: singular custom post type name ,%2$s: date and time of the revision */
				5  => isset( $_GET['revision'] ) ? sprintf( __( '%1$s restored to revision from %2$s', 'Popup' ), $singular_name, wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
				/* translators: %s: singular custom post type name */
				6  => sprintf( __( '%s published.', 'Popup' ), $singular_name ),
				/* translators: %s: singular custom post type name */
				7  => sprintf( __( '%s saved.', 'Popup' ), $singular_name ),
				/* translators: %s: singular custom post type name */
				8  => sprintf( __( '%s submitted.', 'Popup' ), $singular_name ),
				/* translators: %s: singular custom post type name */
				9  => sprintf( __( '%s scheduled for.', 'Popup' ), $singular_name ),
				/* translators: %s: singular custom post type name */
				10 => sprintf( __( '%s draft updated.', 'Popup' ), $singular_name ),
  			);
		}
		return $messages;
	}
}
/*  
Creating the object of class
*/
$obj = new IP_loader();
endif;

?>

