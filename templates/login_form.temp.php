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
	 
	$can_register  = get_option( 'users_can_register' );
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
<div class="flex-login-form">
    <div class="fs-login-form-wrap">
        <form id="fs-login-form-<?php echo esc_attr( $atts['id'] ) ?>" class="fs-login-form" onsubmit="return false;">
			<?php wp_nonce_field( 'fs_login', 'fs_login' ); ?>
			<?php wp_get_referer() ?>
            <div class="fs-login-notice"></div>
            <input type="hidden" name="refer" value="<?php echo esc_url( $refer ) ?>">
            <div>
                <input type="text" name="username" class="required fs-full" placeholder="User name or email ..." value="">
            </div>
            <div>
                <input type="password" name="password" class="required fs-full" placeholder="Password..." value="">
            </div>
            <div>
                <input type="checkbox" name="remember" value="remember"><?php echo esc_html__('Remember me',fsUser()->domain)?>
                <a href="<?php echo wp_lostpassword_url(); ?>"><?php echo esc_html__('Forgotten your password?',fsUser()->domain)?></a>
            </div>
            <div class="fs-action">
                <button type="submit"><?php echo esc_attr( $settings['login_btn'] ) ?></button>
            </div>
        </form>
        <?php
       
        if ( (isset($options['enable_facebook_checkbox']) && $options['enable_facebook_checkbox'] == 'yes') || (isset($options['enable_twitter']) && $options['enable_twitter'] == 'yes' )): ?>
        <div class="fs-thirdparty">
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