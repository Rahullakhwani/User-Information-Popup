<?php

add_shortcode( 'info_popup', 'shortcode_func' );

	function shortcode_func($atts){

		$a= shortcode_atts( array(
		'user_id' => '',
		), $atts );
		// get_post_meta( $post_id, $key = '', $single = false )

			$data = get_post_meta ($a['user_id'],'info_popup_data');

			$html = '<h3>'.$data[0]['ip_form_first_name'].'</h3>';
			$html .= '<h3>'.$data[0]['ip_form_last_name'].'</h3>';
			$html .= '<h3>'.$data[0]['ip_form_email'].'</h3>';
			$html .= '<h3>'.$data[0]['ip_form_website'].'</h3>';

			return $html;
			?>
		<?php
		}

<?php

add_shortcode( 'info_popup', 'shortcode_func' );

	function shortcode_func($atts){

		$a= shortcode_atts( array(
		'user_id' => '',
		), $atts );
		// get_post_meta( $post_id, $key = '', $single = false )

		
		?>
		<?php add_thickbox(); ?>
		<div id="my-content-id" style="display:none;" >
			<p>
				<?php
				$data = get_post_meta ($a['user_id'],'info_popup_data');
				// echo "Inside popup";
				echo $html = '<h3>'.$data[0]['ip_form_first_name'].'</h3>';
				echo $html .= '<h3>'.$data[0]['ip_form_last_name'].'</h3>';
				echo $html .= '<h3>'.$data[0]['ip_form_email'].'</h3>';
				echo $html .= '<h3>'.$data[0]['ip_form_website'].'</h3>';

				?>
				This is my hidden content! It will appear in ThickBox when the link is clicked.
			</p>
		</div>

		<!-- <a href="#TB_inline?&width=600&height=550&inlineId=my-content-id" class="thickbox">Display Shortcode</a> -->
		<?php
			
