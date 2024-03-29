<?php
	/**
	 * Created by PhpStorm.
	 * User: Nic
	 * Date: 1/6/2017
	 * Time: 10:27 PM
	 */
	$refer         = isset( $_GET['redirect'] ) ? $_GET['redirect'] : '';
	$site_url      = get_site_url();
	$current_url   = ( ! empty( $refer ) ) ? $refer : set_url_scheme( 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );
	$atts          = wp_parse_args( $atts, array(
		'title'    => esc_html__( 'Login Register', fsUser()->domain ),
		'style'    => 'fs-popup',
		'type'     => 'both',
		'num_link' => '2',
		'active'   => 'login',
        'el_class' => ''
	) );
	$can_register  = get_option( 'users_can_register' );
	$only_login    = ( $atts['type'] == 'login' || ! $can_register ) ? true : false;
	$only_register = ( $atts['type'] == 'register' ) ? true : false;
	$settings      = fs_get_option( array(
		'login_btn',
		'register_btn',
		'login_label',
		'register_label',
		'general_label' 
	), array(
		esc_html__( 'Login', fsUser()->domain ),
		esc_html__( 'Register', fsUser()->domain ),
		esc_html__( 'Login', fsUser()->domain ),
		esc_html__( 'Register', fsUser()->domain ),
		esc_html__( 'Login or register', fsUser()->domain )
	) );
    $options = fs_get_option( array(
        'enable_facebook_checkbox',
        'enable_twitter_checkbox'
    ), array(
        '',
        ''
    ) );
 
?>
<div class="fs-widget flex_authenticate <?php echo esc_attr($atts['el_class'])?>">
    <div class="fs-link">
            <span>
                <?php if ( ( ! $only_register && ! $only_login && $atts['type'] == 'both' && $atts['num_link'] == '1' ) ): ?>
                    <a href="#fs-general-form-<?php echo esc_attr( $atts['id'] ) ?>" data-active="<?php echo esc_attr( $atts['active'] ) ?>"><?php echo esc_attr( $settings['general_label'] ) ?></a>
                <?php elseif ( ( $atts['type'] == 'both' && $atts['num_link'] == '2' ) ): ?>
                    <a href="#fs-login-form-<?php echo esc_attr( $atts['id'] ) ?>" data-active="login"><?php echo esc_attr( $settings['login_label'] ) ?></a> 
                    <a href="#fs-register-form-<?php echo esc_attr( $atts['id'] ) ?>" data-active="register"><?php echo esc_attr( $settings['register_label'] ) ?></a>
                <?php elseif ( $only_register ): ?>
                    <a href="#fs-register-form-<?php echo esc_attr( $atts['id'] ) ?>" data-active="register"><?php echo esc_attr( $settings['register_label'] ) ?></a>
                <?php elseif ( $only_login ): ?>
                    <a href="#fs-login-form-<?php echo esc_attr( $atts['id'] ) ?>" data-active="login"><?php echo esc_attr( $settings['login_label'] ) ?></a>
                <?php endif; ?>
            </span>
    </div>
    <div class="fs-form <?php echo esc_attr( $atts['style'] ) ?>">
        <div class="fs-card card">
            <?php if ( $atts['style'] !== 'dropdown' ): ?>
                <span class="fs-close">&times;</span>
            <?php endif; ?>
            <?php if(!empty($atts['title'])):?>
            <div class="fs-header">
                <h3 class="fs-center"><?php echo esc_attr( $atts['title'] ) ?></h3>
            </div>
            <?php endif; ?>
            <div class="fs-body">
				<?php if ( ! $only_register ): ?>
                    <div class="form">
                        <div class="fs-login-form-wrap">
                            <form id="fs-login-form-<?php echo esc_attr( $atts['id'] ) ?>" class="fs-login-form" onsubmit="return false;">
								<?php wp_nonce_field( 'fs_login', 'fs_login' ); ?>
								<?php wp_get_referer() ?>
                                <div class="fs-login-notice"></div>
                                <input type="hidden" name="refer" value="<?php echo esc_url( $refer ) ?>">
                                <p>
                                    <input type="text" name="username" class="required fs-full" placeholder="User name or email ..." value="">
                                </p>
                                <p>
                                    <input type="password" name="password" class="required fs-full" placeholder="Password..." value="">
                                </p>
                                <p>
                                    <input type="checkbox" name="remember" value="remember"><?php echo esc_html__('Remember me',fsUser()->domain)?>
                                    <a href="<?php echo wp_lostpassword_url(); ?>"><?php echo esc_html__('Forgotten your password?',fsUser()->domain)?></a>
                                </p>
                                <p class="fs-action">
                                    <button type="submit"><?php echo esc_attr( $settings['login_btn'] ) ?></button>
                                </p>
								<?php if ( $can_register ): ?>
                                    <div class="fs-singin-up">
                                        <p><?php esc_html_e('Don\'t have an account?',fsUser()->domain)?> <a href="#" class="fs-register"><?php esc_html_e('Create an account',fsUser()->domain)?></a></p>
                                    </div>
								<?php endif; ?>
                            </form>
                            <?php
                           
                            if ( (isset($options['enable_facebook_checkbox']) && $options['enable_facebook_checkbox'] == 'yes') || (isset($options['enable_twitter']) && $options['enable_twitter'] == 'yes' )): ?>
                            <div class="fs-thirdparty fs-center">
								<?php if ( $options['enable_facebook_checkbox'] == 'yes' ): ?>
                                    <a class="button btn-facebook" href="<?php echo $site_url ?>?login=facebook&fs-redirect=<?php echo urlencode( $current_url ) ?>"><i class="ti ti-facebook"></i> <?php esc_html_e('Facebook',fsUser()->domain)?></a>
								<?php endif; ?>
								<?php if ( $options['enable_twitter_checkbox'] == 'yes' ): ?>
                                    <a class="button btn-twitter" href="<?php echo $site_url ?>?login=twitter&fs-redirect=<?php echo urlencode( $current_url ) ?>"><i class="ti ti-twitter"></i> <?php esc_html_e('Twitter',fsUser()->domain)?></a>
								<?php endif; ?>
                            </div>
                            <?php endif; ?>
                            <div class="fs-login-desc">
                                <?php if ( ! empty( $atts['login_description'] ) )
                                    echo wpautop( $atts['login_description'] ) ?>
                            </div>
                        </div>
                    </div>
				<?php endif; ?>
				<?php if ( $can_register ): ?>
                    <div class="form">
                        <div class="fs-register-form-wrap">
                            <form id="fs-register-form-<?php echo esc_attr( $atts['id'] ) ?>" class="fs-register-form" onsubmit="return false;">
								<?php wp_nonce_field( 'fs_register', 'fs_register' ); ?>
								<?php wp_get_referer() ?>
                                <input type="hidden" name="refer" value="<?php echo esc_url( $refer ) ?>">
                                <div class="fs-register-notice"></div>
                                <p>
                                    <input type="text" class="required fs-full" name="fs_first_name" placeholder="First Name ..." value="">
                                </p>
                                <p>
                                    <input type="text" class="required fs-full" name="fs_last_name" placeholder="Last Name ..." value="">
                                </p>
                                <p>
                                    <input type="email" class="required fs-full" name="fs_email" placeholder="Email ..." value="">
                                </p>
                                <p>
                                    <input type="text" class="required fs-full" name="fs_username" placeholder="User name ..." value="">
                                </p>
                                <p>
                                    <input type="password" class="required fs-full" name="fs_password" placeholder="Password..." value="">
                                </p>
                                <p>
                                    <input type="password" name="fs_password_re" class="required fs-full" placeholder="Confirm Password..." value="">
                                </p>
                                <p class="fs-action">
                                    <button type="submit"><?php echo esc_attr( $settings['register_btn'] ) ?></button>
                                </p>
                                <div class="fs-singin-up">
                                    <p><?php esc_html_e('Already have an account?',fsUser()->domain)?> <a href="#" class="fs-login"><?php esc_html_e('Sign in now',fsUser()->domain)?></a></p>
                                </div>
                            </form>
                            <?php if ( (isset($options['enable_facebook_checkbox']) && $options['enable_facebook_checkbox'] == 'yes') || (isset($options['enable_twitter_checkbox']) && $options['enable_twitter_checkbox'] == 'yes' )): ?>
                            <div class="fs-thirdparty fs-center">
								<?php if ( $options['enable_facebook_checkbox'] == 'yes' ): ?>
                                    <a class="button btn-facebook" href="<?php echo $site_url ?>?login=facebook&fs-redirect=<?php echo urlencode( $current_url ) ?>"><i class="ti ti-facebook"></i> <?php esc_html_e('Facebook',fsUser()->domain)?></a>
								<?php endif; ?>
								<?php if ( $options['enable_twitter_checkbox'] == 'yes' ): ?>
                                    <a class="button btn-twitter" href="<?php echo $site_url ?>?login=twitter&fs-redirect=<?php echo urlencode( $current_url ) ?>"><i class="ti ti-twitter"></i> <?php esc_html_e('Twitter',fsUser()->domain)?></a>
								<?php endif; ?>
                            </div>
                            <?php endif; ?>
                            <div class="fs-register-form-desc">
                                <?php if ( ! empty( $atts['register_description'] ) )
                                    echo wpautop( $atts['register_description'] ) ?>
                            </div>
                        </div>
                    </div>
				<?php endif; ?>
            </div>
        </div>
    </div>
</div>