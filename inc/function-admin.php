<?php
defined( 'ABSPATH' ) or die( 'Hey, what are you doing here ?' );

/*
    @package Mainnix-Theme
    =========================
            Admin Page
    =========================
*/
class AdminFunc
{
    function __construct()
    {
        // Run function 'admin page'
        //===========================
        add_action( 'admin_menu', $this->checkMethod('mainnix_add_admin_page') );
    }

    //=======================
    // Check Method if exist
    //=======================
    function checkMethod( $name )
    {
        if( method_exists( $this, $name ) )
        {
            $arr    = [];
            array_push($arr, $this, $name);
            return $arr;
        }
    }

    function mainnix_add_admin_page()
    {
        // Generate Admin Page
        //=======================
        add_menu_page( 'Mainnix Theme Options', 'Mainnix', 'manage_options', 'kai_mainnix', $this->checkMethod('mainnix_theme_create_page'), '', 64 );
    
        // Generate Admin Sub-page
        //=========================
        add_submenu_page( 'kai_mainnix', 'Mainnix Sidebar Options', 'Sidebar', 'manage_options', 'kai_mainnix', $this->checkMethod('mainnix_theme_create_page') );
        add_submenu_page( 'kai_mainnix', 'Mainnix Theme Options', 'Theme Options', 'manage_options', 'kai_mainnix_theme', $this->checkMethod('mainnix_theme_support_page') );
        add_submenu_page( 'kai_mainnix', 'Mainnix Contact Form', 'Contact Form', 'manage_options', 'kai_mainnix_theme_contact', $this->checkMethod('mainnix_contact_form_page') );
        add_submenu_page( 'kai_mainnix', 'Mainnix CSS Options', 'Custom CSS', 'manage_options', 'kai_mainnix_css', $this->checkMethod('mainnix_theme_settings_page') );

        // Activate Custom Settings
        //==========================
        add_action( 'admin_init', $this->checkMethod('mainnix_custom_settings') );
    }

    function mainnix_custom_settings()
    {
        // Sidebar Options
        //=======================
        register_setting( 'mainnix-settings-group', 'profile_picture' );
        register_setting( 'mainnix-settings-group', 'first_name', $this->checkMethod('mainnix_standart_sanitize') );
        register_setting( 'mainnix-settings-group', 'last_name', $this->checkMethod('mainnix_standart_sanitize') );
        register_setting( 'mainnix-settings-group', 'user_description', $this->checkMethod('mainnix_standart_sanitize') );
        register_setting( 'mainnix-settings-group', 'twitter_handler', $this->checkMethod('mainnix_sanitize_twitter_handler') );
        register_setting( 'mainnix-settings-group', 'facebook_handler', $this->checkMethod('mainnix_standart_sanitize') );
        register_setting( 'mainnix-settings-group', 'gplus_handler', $this->checkMethod('mainnix_standart_sanitize') );
        register_setting( 'mainnix-settings-group', 'github_handler', $this->checkMethod('mainnix_standart_sanitize') );

        add_settings_section( 'mainnix-sidebar-options', 'Sidebar Options', $this->checkMethod('mainnix_sidebar_options'), 'kai_mainnix' );
        
        add_settings_field( 'sidebar-profile-picture', 'Profile Picture', $this->checkMethod('mainnix_sidebar_profile'), 'kai_mainnix', 'mainnix-sidebar-options', '' );
        add_settings_field( 'sidebar-name', 'Full Name', $this->checkMethod('mainnix_sidebar_name'), 'kai_mainnix', 'mainnix-sidebar-options', '' );
        add_settings_field( 'sidebar-description', 'Description', $this->checkMethod('mainnix_sidebar_description'), 'kai_mainnix', 'mainnix-sidebar-options', '' );
        add_settings_field( 'sidebar-twitter', 'Twitter handler', $this->checkMethod('mainnix_sidebar_twitter'), 'kai_mainnix', 'mainnix-sidebar-options' );
        add_settings_field( 'sidebar-facebook', 'Facebook handler', $this->checkMethod('mainnix_sidebar_facebook'), 'kai_mainnix', 'mainnix-sidebar-options' );
        add_settings_field( 'sidebar-gplus', 'Google+ handler', $this->checkMethod('mainnix_sidebar_gplus'), 'kai_mainnix', 'mainnix-sidebar-options' );
        add_settings_field( 'sidebar-github', 'Github handler', $this->checkMethod('mainnix_sidebar_github'), 'kai_mainnix', 'mainnix-sidebar-options' );
    
        // Theme Support Options
        //=======================
        register_setting( 'mainnix-theme-support', 'post_formats' );
        register_setting( 'mainnix-theme-support', 'custom_header' );
        register_setting( 'mainnix-theme-support', 'custom_background' );
    
        add_settings_section( 'mainnix-theme-options', 'Theme Options', $this->checkMethod('mainnix_theme_options'), 'kai_mainnix_theme' );
    
        add_settings_field( 'post-formats', 'Post Formats', $this->checkMethod('mainnix_post_formats'), 'kai_mainnix_theme', 'mainnix-theme-options' );
        add_settings_field( 'custom-header', 'Custom Header', $this->checkMethod('mainnix_custom_header'), 'kai_mainnix_theme', 'mainnix-theme-options' );
        add_settings_field( 'custom-background', 'Custom Background', $this->checkMethod('mainnix_custom_background'), 'kai_mainnix_theme', 'mainnix-theme-options' );
    
        // Contact Form Options
        //======================
        register_setting( 'mainnix-contact-options', 'activate_contact' );

        add_settings_section( 'mainnix-contact-section', 'Contact Form', $this->checkMethod('mainnix_contact_section'), 'kai_mainnix_theme_contact' );
    
        add_settings_field( 'activate-form', 'Activate Contact Form', $this->checkMethod('mainnix_activate_contact'), 'kai_mainnix_theme_contact', 'mainnix-contact-section' );
    
        // Custom CSS Options
        //======================
        register_setting( 'mainnix-custom-css-options', 'mainnix_css', 'mainnix_sanitize_custom_css' );

        add_settings_section( 'mainnix-custom-css-section', 'Custom CSS', $this->checkMethod('mainnix_custom_css_section_callback'), 'kai_mainnix_css' );
    
        add_settings_field( 'custom-css', 'Insert your Custom CSS', $this->checkMethod('mainnix_custom_css_callback'), 'kai_mainnix_css', 'mainnix-custom-css-section' );
    }

    //=========================
    // Theme Support Functions
    //=========================
    function mainnix_theme_options()
    {
        echo 'Activate and Deactive specific Theme Support Options';
    }

    function mainnix_contact_section()
    {
        echo 'Activate and Deactive the built-in Contact Form';
    }

    function mainnix_activate_contact()
    {
        $options    = get_option( 'activate_contact' );
        $checked    = ( @$options == 1 ? 'checked' : '' );
        echo '<input type="checkbox" id="activate_contact" name="activate_contact" value="1" '.$checked.'/>';
    }

    function mainnix_post_formats()
    {
        $options    = get_option( 'post_formats' );
        $formats    = array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' );
        $output     = '';

        foreach( $formats as $format )
        {
            $checked    = ( @$options[$format] == 1 ? 'checked' : '' );
            $output .= '<label><input type="checkbox" id="'.$format.'" name="post_formats['.$format.']" value="1" '.$checked.'/>'.$format.'</label><br/>';
        }

        echo $output;
    }

    function mainnix_custom_header()
    {
        $options    = get_option( 'custom_header' );
        $checked    = ( @$options == 1 ? 'checked' : '' );
        echo '<label><input type="checkbox" id="custom_header" name="custom_header" value="1" '.$checked.'/>Activate Custom Header</label><br/>';
    }

    function mainnix_custom_background()
    {
        $options    = get_option( 'custom_background' );
        $checked    = ( @$options == 1 ? 'checked' : '' );
        echo '<label><input type="checkbox" id="custom_background" name="custom_background" value="1" '.$checked.'/>Activate Custom Background</label><br/>';
    }

    //=========================
    // Sidebar Options Functions
    //=========================
    function mainnix_sidebar_options()
    {
        echo 'Customize your sidebar information';
    }

    function mainnix_sidebar_profile()
    {
        $picture        = esc_attr( get_option( 'profile_picture' ) );

        if( empty($picture) )
        {
            echo '<input type="button" value="Upload Profile Picture" class="button button-secondary" id="upload-button"/><input type="hidden" name="profile_picture" id="profile-picture" value=""/>';
        }
        else
        {
            echo '<input type="button" value="Replace Upload Profile Picture" class="button button-secondary" id="upload-button"/><input type="hidden" name="profile_picture" id="profile-picture" value="'.$picture.'"/> ';
            echo '<input type="button" value="Remove" class="button button-secondary" id="remove-picture"/>';
        }
    }

    function mainnix_sidebar_name()
    {
        $firstname      = esc_attr( get_option( 'first_name' ) );
        $lastname       = esc_attr( get_option( 'last_name' ) );
        echo '<input type="text" name="first_name" value="'.$firstname.'" placeholder="First Name"/>';
        echo '<input type="text" name="last_name" value="'.$lastname.'" placeholder="Last Name"/>';
    }

    function mainnix_sidebar_description()
    {
        $description    = esc_attr( get_option( 'user_description' ) );
        echo '<input type="text" name="user_description" value="'.$description.'" placeholder="User Description"/>';
        echo '<p class="description">Write something smart.</p>';
    }

    function mainnix_sidebar_twitter()
    {
        $twitter    = esc_attr( get_option( 'twitter_handler' ) );
        echo '<input type="text" name="twitter_handler" value="'.$twitter.'" placeholder="Twitter"/>';
        echo '<p class="description">Input your Twitter username without @</p>';
    }

    function mainnix_sidebar_facebook()
    {
        $facebook   = esc_attr( get_option( 'facebook_handler' ) );
        echo '<input type="text" name="facebook_handler" value="'.$facebook.'" placeholder="Facebook"/>';
    }

    function mainnix_sidebar_gplus()
    {
        $gplus      = esc_attr( get_option( 'gplus_handler' ) );
        echo '<input type="text" name="gplus_handler" value="'.$gplus.'" placeholder="Google Plus"/>';
    }

    function mainnix_sidebar_github()
    {
        $github     = esc_attr( get_option( 'github_handler' ) );
        echo '<input type="text" name="github_handler" value="'.$github.'" placeholder="Github"/>';
    }

    //=========================
    // Custom CSS Functions
    //=========================
    function mainnix_custom_css_section_callback()
    {
        echo 'Customize Mainnix Theme with your own CSS';
    }

    function mainnix_custom_css_callback()
    {
        $css        = get_option( 'mainnix_css' );
        $css        = ( empty($css) ? "/*Mainnix Theme Custom CSS*/" : $css );
        echo '<div id="customCSS">'.$css.'</div><textarea id="mainnix_css" name="mainnix_css" style="display:none; visibility:hidden;">'.$css.'</textarea>';
    }

    //=========================
    // Sanitization Functions
    //=========================
    function mainnix_sanitize_twitter_handler( $input )
    {
        $output     = sanitize_text_field( $input );
        $output     = str_replace( '@', '', $output );
        return $output;
    }

    function mainnix_standart_sanitize( $input )
    {
        $output     = sanitize_text_field( $input );
        return $output;
    }

    function mainnix_sanitize_custom_css( $input )
    {
        $output     = esc_textarea( $input );
        return $output;
    }

    //============================
    // Template Sub-menu Functions
    //============================
    function mainnix_theme_create_page()
    {
        require_once( get_template_directory() . '/templates/admin/mainnix-admin.php' );
    }

    function mainnix_theme_support_page()
    {
        require_once( get_template_directory() . '/templates/admin/mainnix-theme-support.php' );
    }

    function mainnix_contact_form_page()
    {
        require_once( get_template_directory() . '/templates/admin/mainnix-contact-form.php' );
    }

    function mainnix_theme_settings_page()
    {
        require_once( get_template_directory() . '/templates/admin/mainnix-custom-css.php' );
    }
}

//=======================
// Check class if exist
//=======================
if( class_exists( 'AdminFunc' ) ) {
    $AdminFunc    = new AdminFunc();
}