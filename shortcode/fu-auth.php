<?php 
add_shortcode( 'fu_auth', 'fu_auth_func' );
function fu_auth_func( $atts ) {
    extract( shortcode_atts( array(
    'el_class' => 'something',
    'color' => '#FFF'
    ), $atts ) );
   
    if ( is_user_logged_in() ) {
        return fsUser()->get_template_file__( 'logout', array( 'atts' => $atts ), '', 'flex-login' );
    }
    $atts = shortcode_atts(
        array(
            'id' => '',
        ), $atts );
    wp_enqueue_style( 'fs-user-form.css', fsUser()->plugin_url . 'assets/css/fs-user-form.css', array(), '', 'all' );
    wp_enqueue_script( 'jquery.validate.js', fsUser()->plugin_url . 'assets/vendor/jquery.validate.js', array(), '', true );
    wp_register_script( 'fs-login.js', fsUser()->plugin_url . 'assets/js/fs-login.js', array(), '', true );
    wp_localize_script( 'fs-login.js', 'fs_login', array(
        'action' => 'fs_login',
        'url'    => admin_url( 'admin-ajax.php' ),
    ) );
    wp_enqueue_script( 'fs-login.js' );
    wp_enqueue_script( 'fs-login.js', fsUser()->plugin_url . 'assets/js/fs-login.js', array(), '', true );
    wp_localize_script( 'fs-login.js', 'fs_register', array(
        'action' => 'fs_register',
        'url'    => admin_url( 'admin-ajax.php' ),
    ) );
    
    return fsUser()->get_template_file__( 'auth_form', array( 'atts' => $atts ), '', 'flex-login' );
}

add_action('vc_before_init', 'add_flex_user_shortcodes');
function add_flex_user_shortcodes(){
    vc_map(array(
        'name'     => esc_html__('Flex Login Register', 'flex-login'),
        'base'     => 'fu_auth',
        'icon'     => 'icon-wpb-ui-icon',
        'category' => esc_html__('Flex User', 'flex-login'),
        'params'   => array(
            array(
                'type'             => 'textfield',
                'heading'          => esc_html__( 'Extra class name', 'flex-login' ),
                'param_name'       => 'el_class',
            )
        )
    ));
}


/*class WPBakeryShortCode_fu_auth extends WPBakeryShortCode {
    protected function content($atts, $content = null){
        $fs_boot = new fs_boot;
        if ( is_user_logged_in() ) {
                return $fs_boot->get_template_file__( 'logout', array( 'atts' => $atts ), '', 'flex-login' );
            }
            $atts = shortcode_atts(
                array(
                    'id' => '',
                ), $atts );
            wp_enqueue_style( 'fs-user-form.css', $fs_boot->plugin_url . 'assets/css/fs-user-form.css', array(), '', 'all' );
            wp_enqueue_script( 'jquery.validate.js', $fs_boot->plugin_url . 'assets/vendor/jquery.validate.js', array(), '', true );
            wp_register_script( 'fs-login.js', $fs_boot->plugin_url . 'assets/js/fs-login.js', array(), '', true );
            wp_localize_script( 'fs-login.js', 'fs_login', array(
                'action' => 'fs_login',
                'url'    => admin_url( 'admin-ajax.php' ),
            ) );
            wp_enqueue_script( 'fs-login.js' );
            wp_enqueue_script( 'fs-login.js', $fs_boot->plugin_url . 'assets/js/fs-login.js', array(), '', true );
            wp_localize_script( 'fs-login.js', 'fs_register', array(
                'action' => 'fs_register',
                'url'    => admin_url( 'admin-ajax.php' ),
            ) );
            
            return $fs_boot->get_template_file__( 'auth_form', array( 'atts' => $atts ), '', 'flex-login' );
        return parent::content($atts, $content);
    }
      
}*/
