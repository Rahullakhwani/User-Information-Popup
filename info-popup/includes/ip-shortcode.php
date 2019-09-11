<?php
/*
 *Adding the inputs into shortcode and displaying on frontend.
*/

// add_shortcode( 'info_popup', 'shortcode_func' );
	function shortcode_func($atts){
			ob_start();
		$a= shortcode_atts( array(
		'user_id' => '',
		), $atts );
		// get_post_meta( $post_id, $key = '', $single = false )

			$data = get_post_meta ($a['user_id'],'info_popup_data');

/*			$html = '<h3>'.$data[0]['ip_form_first_name'].'</h3>';
			$html .= '<h3>'.$data[0]['ip_form_last_name'].'</h3>';
			$html .= '<h3>'.$data[0]['ip_form_email'].'</h3>';
			$html .= '<h3>'.$data[0]['ip_form_website'].'</h3>';*/
			// echo var_dump($data);
			$color = $data[0]['ip_text_colour'];
			//var_dump($color);
			?>
			<div class="output">
				<style type="text/css">
					.output{
						text-align: center;	
						border: 1px solid #ef77a0;
					    padding: 10px;
					    box-shadow: 10px 10px 10px #aaa;
					    width: 400px;
					}
					    
				</style>
				<h3 style = "color: <?php esc_attr_e($color);?>"><?php echo $data[0]['ip_form_first_name'];?></h3><hr>
				<h3><?php echo $data[0]['ip_form_last_name'];?></h3><hr>
				<h3><?php echo $data[0]['ip_form_email'];?></h3><hr>
				<h3><?php echo $data[0]['ip_form_website'];?></h3><hr>
			</div>
		<?php
		// return $html;
		$myvariable = ob_get_clean();
	    return $myvariable;
		}

