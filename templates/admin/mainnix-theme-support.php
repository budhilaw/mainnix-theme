<h1>Mainnix Theme Support</h1>
<?php settings_errors();?>

<form action="options.php" method="post" class="mainnix-general-form">
    <?php settings_fields( 'mainnix-theme-support' );?>
    <?php do_settings_sections( 'kai_mainnix_theme' );?>
    <?php submit_button();?>
</form>