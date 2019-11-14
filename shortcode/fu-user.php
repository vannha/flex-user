<?php 
add_action('vc_before_init', 'add_flex_user_shortcodes');
function add_flex_user_shortcodes(){
    vc_map(array(
        'name'     => esc_html__('Flex Login Register', 'flex-login'),
        'base'     => 'fu_auth',
        'icon'     => 'icon-wpb-ui-icon',
        'category' => esc_html__('Flex User', 'flex-login'),
        'params'   => array(
            array(
                'type'       => 'dropdown',
                'param_name' => 'style',
                'heading'    => esc_html__('Style','flex-login'),
                'value'      => array(
                    esc_html__('Popup','flex-login')          => 'fs-popup',
                    esc_html__('Dropdown','flex-login')       => 'fs-dropdown'
                ),
                'std'        => 'fs-popup'
            ),
            array(
                'type'       => 'dropdown',
                'param_name' => 'type',
                'heading'    => esc_html__('Type','flex-login'),
                'value'      => array(
                    esc_html__('Both login and register','flex-login')          => 'both',
                    esc_html__('Only login','flex-login')    => 'login',
                    esc_html__('Only register','flex-login')   => 'register'
                ),
                'std'        => 'both'
            ),
            array(
                'type'       => 'dropdown',
                'param_name' => 'num_link',
                'heading'    => esc_html__('Number link','flex-login'),
                'value'      => array(
                    esc_html__('One','flex-login')          => '1',
                    esc_html__('Two','flex-login')    => '2'
                ),
                'std'        => '2',
                'dependency' => array(
                    'element' => 'type',
                    'value'   => 'both'
                )
            ),
            array(
                'type'             => 'textfield',
                'heading'          => esc_html__( 'Extra class name', 'flex-login' ),
                'param_name'       => 'el_class',
            )
        )
    ));
    vc_map(array(
        'name'     => esc_html__('Flex Login', 'flex-login'),
        'base'     => 'fu_login',
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
    vc_map(array(
        'name'     => esc_html__('Flex Register', 'flex-login'),
        'base'     => 'fu_register',
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
add_shortcode( 'fu_login', 'fu_login_func' );
function fu_login_func( $atts ) {
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
    wp_enqueue_script( 'jquery.validate.js', fsUser()->plugin_url . 'assets/vendor/jquery.validate.js', array(), '', true );
    wp_register_script( 'fs-login.js', fsUser()->plugin_url . 'assets/js/fs-login.js', array(), '', true );
    wp_localize_script( 'fs-login.js', 'fs_login', array(
        'action' => 'fs_login',
        'url'    => admin_url( 'admin-ajax.php' ),
    ) );
    wp_enqueue_script( 'fs-login.js' );
    
    return fsUser()->get_template_file__( 'login_form', array( 'atts' => $atts ), '', 'flex-login' );
}
add_shortcode( 'fu_register', 'fu_register_func' );
function fu_register_func( $atts ) {
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
    wp_enqueue_script( 'jquery.validate.js', fsUser()->plugin_url . 'assets/vendor/jquery.validate.js', array(), '', true );
    wp_enqueue_script( 'fs-register.js', fsUser()->plugin_url . 'assets/js/fs-register.js', array(), '', true );
    wp_localize_script( 'fs-register.js', 'fs_register', array(
        'action' => 'fs_register',
        'url'    => admin_url( 'admin-ajax.php' ),
    ) );
    
    return fsUser()->get_template_file__( 'register_form', array( 'atts' => $atts ), '', 'flex-login' );
}



 
