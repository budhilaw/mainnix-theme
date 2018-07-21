<h1>Mainnix Contact Form</h1>
<?php settings_errors();?>

<form action="options.php" method="post" class="mainnix-general-form">
    <?php settings_fields( 'mainnix-contact-options' );?>
    <?php do_settings_sections( 'kai_mainnix_theme_contact' );?>
    <?php submit_button();?>
</form>