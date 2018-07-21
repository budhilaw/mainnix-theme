<?php
defined( 'ABSPATH' ) or die( 'Hey, what are you doing here ?' );

/*
    @package Mainnix-Theme
    =========================
        Admin Enqueue
    =========================
*/

class AdminEnq
{
    function __construct() {
        add_action( 'admin_enqueue_scripts', $this->checkMethod('mainnix_load_admin_scripts') );
    }

    // Check method if exist
    function checkMethod( $name )
    {
        if( method_exists( $this, $name ) )
        {
            $arr    = [];
            array_push($arr, $this, $name);
            return $arr;
        }
    }

    function mainnix_load_admin_scripts( $hook )
    {
        if( 'toplevel_page_kai_mainnix' == $hook )
        {
            // Include Admin CSS
            wp_register_style( 'mainnix_admin', get_template_directory_uri() . './css/mainnix.admin.css', array(), '1.0.0', 'all' );
            wp_enqueue_style( 'mainnix_admin' );

            // Calling media uploader
            wp_enqueue_media();

            // Include Admin Javascript for media uploader
            wp_register_script( 'mainnix-admin-script', get_template_directory_uri() . '/js/mainnix.admin.js', array('jquery'), '1.0.0', true );
            wp_enqueue_script( 'mainnix-admin-script' );
        }
        else if( 'mainnix_page_kai_mainnix_css' == $hook )
        {
            wp_enqueue_style( 'ace', get_template_directory_uri() . './css/mainnix.ace.css', array(), '1.0.0', 'all' );
            wp_enqueue_script( 'ace', get_template_directory_uri() . '/js/ace/ace.js', array('jquery'), '1.3.3', true );
            wp_enqueue_script( 'mainnix-custom-css-script', get_template_directory_uri() . '/js/mainnix.custom_css.js', array('jquery'), '1.0.0', true );
        }
        else
        {
            return;
        }
    }
}

// Check if class is exist
if( class_exists( 'AdminEnq' ) ) {
    $AdminEnq    = new AdminEnq();
}