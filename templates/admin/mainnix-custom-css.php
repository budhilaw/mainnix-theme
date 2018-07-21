<h1>Mainnix Custom CSS</h1>
<?php settings_errors();?>

<form id="save-custom-css-form" action="options.php" method="post" class="mainnix-general-form">
    <?php settings_fields( 'mainnix-custom-css-options' );?>
    <?php do_settings_sections( 'kai_mainnix_css' );?>
    <?php submit_button();?>
</form>