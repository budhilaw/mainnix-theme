<?php
defined( 'ABSPATH' ) or die( 'Hey, what are you doing here ?' );

/**
 * Function of Theme Supports
 * 
 * @package WordPress
 * @subpackage Mainnix
 * @since Mainnix 1.0.0
*/

class ThemeSupport
{
    function __construct()
    {
        // Run function 'custom support'
        //==============================
        add_action( 'init', $this->checkMethod('mainnix_custom_support') );
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

    function mainnix_custom_support()
    {
        // Check uncheck Post Format
        //===========================
        $options    = get_option( 'post_formats' );
        if( !empty($options) )
        {
            add_theme_support( 'post-formats', array_keys($options) );
        }

        // Check uncheck Custom Header
        //=============================
        $header     = get_option( 'custom_header' );
        if( @$header == 1 )
        {
            add_theme_support( 'custom-header' );
        }

        // Check uncheck Custom Background
        //================================
        $background = get_option( 'custom_background' );
        if( @$background == 1 )
        {
            add_theme_support( 'custom-background' );
        }
    }
}

//=======================
// Check class if exist
//=======================
if( class_exists( 'ThemeSupport' ) ) {
    $ThemeSupport    = new ThemeSupport();
}