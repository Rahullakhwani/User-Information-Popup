<?php
/**
* Info Popup Submenu Tab display
*/

/*
* registering settings for plugin
*/
wp_enqueue_style( 'ip_dashboard' );
echo '<h1 class="ip_main_title">';
esc_attr_e('Info Popup','info-popup');
echo '</h1>';

// $options = get_option( 'ip_user_input_data' );

?>

<div>
<form method="post" name="ip_reg_form" action="edit.php?post_type=popups&page=Rahul_slug">
	<table class="form-table">
		<br>
		<p class="form-description">
			<?php
				esc_attr_e('Please enter the input in the below fields and click on submit button', 'info-popup' );
			?>
		</p>
		<tr>
			<th scope="row">
				<label for="Title"><?php esc_attr_e('Title', 'info-popup')?>:</label>
			</th>
			<td>
				<?php
					echo '<input type="text" name="ip_form_title">';
				?>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="FirstName"><?php esc_attr_e('First Name', 'info-popup')?>:</label>
			</th>
			<td>
				<?php
					echo '<input type="text" name="ip_form_first_name" required>';
				?>
			</td>
		</tr>
		
		<tr>
			<th scope="row">
				<label for="Lastname"><?php esc_attr_e('Last Name', 'info-popup')?>:</label>
			</th>
			<td>
				<?php
					echo '<input type="text" name="ip_form_last_name" required>';
				?>
			</td>
		</tr>
		<tr></tr>
		<tr></tr>
		<tr>
			<th scope="row">
				<label for="Email"><?php esc_attr_e('Email', 'info-popup')?>:</label>
			</th>
			<td>
				<?php
					echo '<input type="text" name="ip_form_email" required>';
				?>
			</td>
		</tr>

		<tr>
			<th scope="row">
				<label for="Website"><?php esc_attr_e('Website', 'info-popup')?>:</label>
			</th>
			<td>
				<?php
					echo '<input type="text" name="ip_form_website" required>';
				?>
			</td>
		</tr>
		<tr>
			<th>
				<input type="submit" value="Save" class="bt button button-primary" name="submit">
			</th>
		</tr>
	</table>
</form>
</div>





