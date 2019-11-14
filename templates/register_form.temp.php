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
<?php if ( $can_register ): ?>
	<div class="flex-register-form">
        <div class="fs-register-form-wrap">
            <form id="fs-register-form-<?php echo esc_attr( $atts['id'] ) ?>" class="fs-register-form" onsubmit="return false;">
				<?php wp_nonce_field( 'fs_register', 'fs_register' ); ?>
				<?php wp_get_referer() ?>
                <input type="hidden" name="refer" value="<?php echo esc_url( $refer ) ?>">
                <div class="fs-register-notice"></div>
                <div>
                    <input type="text" class="required fs-full" name="fs_first_name" placeholder="First Name ..." value="">
                </div>
                <div>
                    <input type="text" class="required fs-full" name="fs_last_name" placeholder="Last Name ..." value="">
                </div>
                <div>
                    <input type="email" class="required fs-full" name="fs_email" placeholder="Email ..." value="">
                </div>
                <div>
                    <input type="text" class="required fs-full" name="fs_username" placeholder="User name ..." value="">
                </div>
                <div>
                    <input type="password" class="required fs-full" name="fs_password" placeholder="Password..." value="">
                </div>
                <div>
                    <input type="password" name="fs_password_re" class="required fs-full" placeholder="Confirm Password..." value="">
                </div>
                <div class="fs-action">
                    <button type="submit"><?php echo esc_attr( $settings['register_btn'] ) ?></button>
                </div>
            </form>
            <?php if ( (isset($options['enable_facebook_checkbox']) && $options['enable_facebook_checkbox'] == 'yes') || (isset($options['enable_twitter_checkbox']) && $options['enable_twitter_checkbox'] == 'yes' )): ?>
            <div class="fs-thirdparty">
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