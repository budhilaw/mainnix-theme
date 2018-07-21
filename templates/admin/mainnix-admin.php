<h1>Mainnix Sidebar Options</h1>
<?php settings_errors();?>
<?php 
	
	$profilePicture	= esc_attr( get_option( 'profile_picture' ) );
	$firstName      = esc_attr( get_option( 'first_name' ) );
	$lastName       = esc_attr( get_option( 'last_name' ) );
	$fullName       = $firstName . ' ' . $lastName;
	$description    = esc_attr( get_option( 'user_description' ) );
	
?>
<div class="mainnix-sidebar-preview">
	<div class="mainnix-sidebar">
		<div class="image-container">
			<div id="profile-picture-preview" class="profile-picture" style="background-image: url(<?php print $profilePicture;?>)">
			</div>
		</div>
		<h1 class="mainnix-username"><?php print $fullName; ?></h1>
		<h2 class="mainnix-description"><?php print $description; ?></h2>
		<div class="icons-wrapper">
			
		</div>
	</div>
</div>
<form action="options.php" method="post" class="mainnix-general-form">
    <?php settings_fields( 'mainnix-settings-group' );?>
    <?php do_settings_sections( 'kai_mainnix' );?>
    <?php submit_button( 'Save Changes', 'primary', 'btnSubmit' );?>
</form>