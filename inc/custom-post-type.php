<?php
defined( 'ABSPATH' ) or die( 'Hey, what are you doing here ?' );

/*
    @package Mainnix-Theme
    =========================
        Custom Post Type
    =========================
*/

class CustomPost
{
    function __construct()
    {
        // Run function 'custom support'
        //==============================
        add_action( 'init', $this->checkMethod('mainnix_custom_post') );
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

    function mainnix_custom_post()
    {
        // Check uncheck Custom Header
        //=============================
        $contact    = get_option( 'activate_contact' );
        if( @$contact == 1 )
        {
            add_action( 'init', $this->mainnix_contact_custom_post_type() );

            add_filter( 'manage_mainnix-contact_posts_columns', $this->checkMethod('mainnix_set_contact_columns') );
            add_action( 'manage_mainnix-contact_posts_custom_column', $this->checkMethod('mainnix_contact_custom_column'), 10, 2 );
        
            add_action( 'add_meta_boxes',  $this->checkMethod('mainnix_contact_add_meta_box'));
            add_action( 'save_post', $this->checkMethod('mainnix_save_contact_email_data') );
        }
    }

    function mainnix_contact_custom_post_type()
    {
        $labels     = array(
            'name'              => 'Messages',
            'singular_name'     => 'Message',
            'menu_name'         => 'Messages',
            'name_admin_bar'    => 'Message'
        );

        $args       = array(
            'labels'            => $labels,
            'show_ui'           => true,
            'show_in_menu'      => true,
            'capability_type'   => 'post',
            'hierarchical'      => false,
            'menu_position'     => 26,
            'menu_icon'         => 'dashicons-email-alt',
            'supports'          => array( 'title', 'editor', 'author' )
        );

        register_post_type( 'mainnix-contact', $args );
    }

    function mainnix_set_contact_columns( $columns )
    {
        $newColumns             = array();
        $newColumns['title']    = 'Full Name';
        $newColumns['message']  = 'Message';
        $newColumns['email']    = 'E-mail';
        $newColumns['date']     = 'Date';
        return $newColumns;
    }

    // Looping = $column singular
    function mainnix_contact_custom_column( $column, $post_id )
    {
        switch ($column) {
            case 'message':
                // Message column
                echo get_the_excerpt();
                break;
            case 'email':
                // E-mail column
                $email      = get_post_meta( $post_id, '_contact_email_value_key', true );
                echo '<a href="mailto:'.$email.'">'.$email.'</a>';
                break;
        }
    }

    // Contact Meta Boxes
    function mainnix_contact_add_meta_box()
    {
        add_meta_box( 'contact-email', 'User Email', $this->checkMethod('mainnix_contact_email_callback'), 'mainnix-contact', 'side' );
    }

    function mainnix_contact_email_callback( $post )
    {
        wp_nonce_field( $this->checkMethod('mainnix_save_contact_email_data'), 'mainnix_contact_email_meta_box_nonce' );
        $value      = get_post_meta( $post->ID, '_contact_email_value_key', true );
        echo '<label for="mainnix_contact_email_field">User Email Address</label>&nbsp;&nbsp;&nbsp;';
        echo '<input type="email" id="mainnix_contact_email_field" name="mainnix_contact_email_field" value="'.esc_attr( $value ).'" size="25"/>';
    }

    function mainnix_save_contact_email_data( $post_id )
    {
        if( !isset( $_POST['mainnix_contact_email_meta_box_nonce'] ) )
        {
            return;
        }

        if( !wp_verify_nonce( $_POST['mainnix_contact_email_meta_box_nonce'], $this->checkMethod('mainnix_save_contact_email_data') ) )
        {
            return;
        }

        if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
        {
            return;
        }

        if( !current_user_can( 'edit_post', $post_id ) )
        {
            return;
        }

        if( !isset( $_POST['mainnix_contact_email_field'] ) )
        {
            return;
        }

        $my_data    = sanitize_text_field( $_POST['mainnix_contact_email_field'] );
        update_post_meta( $post_id, '_contact_email_value_key', $my_data );
    }
}

//=======================
// Check class if exist
//=======================
if( class_exists( 'CustomPost' ) ) {
    $CustomPost    = new CustomPost();
}