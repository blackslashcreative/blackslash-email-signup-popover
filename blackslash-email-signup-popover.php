<?php
/*
Plugin Name: Black Slash Email Signup Popover
Plugin URI: http://blacksla.sh
Description: A custom email signup popover plugin by BlackSla.sh.
Version: 1.0
Author: Black Slash Creative
Author Email: ross@blacksla.sh
License:

  Copyright 2015 Black Slash Creative (http://blacksla.sh // ross@blacksla.sh)

*/

class BlackSlashEmailSignupPopover {

	/*--------------------------------------------*
	 * Constants
	 *--------------------------------------------*/
	const name = 'Black Slash Email Signup Popover';
	const slug = 'black_slash_email_signup_popover';

	/**
	 * Constructor
	 */
	function __construct() {
		//register an activation hook for the plugin
		register_activation_hook( __FILE__, array( &$this, 'install_black_slash_email_signup_popover' ) );

		//Hook up to the init action
		add_action( 'init', array( &$this, 'init_black_slash_email_signup_popover' ) );
	}

	/**
	 * Runs when the plugin is activated
	 */
	function install_black_slash_email_signup_popover() {
		// do not generate any output here
	}

	/**
	 * Runs when the plugin is initialized
	 */
	function init_black_slash_email_signup_popover() {
		// Setup localization
		load_plugin_textdomain( self::slug, false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );
		// Load JavaScript and stylesheets
		$this->register_scripts_and_styles();

		// Register the shortcode [blackslash_email_signup]
		add_shortcode( 'blackslash_email_signup', array( &$this, 'render_shortcode' ) );

		if ( is_admin() ) {
			//this will run when in the WordPress admin
		} else {
			//this will run when on the frontend
		}

		/*
		 * TODO: Define custom functionality for your plugin here
		 *
		 * For more information:
		 * http://codex.wordpress.org/Plugin_API#Hooks.2C_Actions_and_Filters
		 */
		add_action( 'your_action_here', array( &$this, 'action_callback_method_name' ) );
		add_filter( 'your_filter_here', array( &$this, 'filter_callback_method_name' ) );
	}

	function action_callback_method_name() {
		// TODO define your action method here
	}

	function filter_callback_method_name() {
		// TODO define your filter method here
	}

	function render_shortcode($atts) {
		// Extract the attributes
		extract(shortcode_atts(array(
			'attr1' => 'foo', //foo is a default value
			'attr2' => 'bar'
			), $atts));
		// you can now access the attribute values using $attr1 and $attr2
	}

	/**
	 * Registers and enqueues stylesheets for the administration panel and the
	 * public facing site.
	 */
	private function register_scripts_and_styles() {
		if ( is_admin() ) {
			$this->load_file( self::slug . '-admin-script', '/js/admin.js', true );
			$this->load_file( self::slug . '-admin-style', '/css/admin.css' );
		} else {
			$this->load_file( self::slug . '-script', '/js/widget.js', true );
			$this->load_file( self::slug . '-style', '/css/widget.css' );
		} // end if/else
	} // end register_scripts_and_styles

	/**
	 * Helper function for registering and enqueueing scripts and styles.
	 *
	 * @name	The 	ID to register with WordPress
	 * @file_path		The path to the actual file
	 * @is_script		Optional argument for if the incoming file_path is a JavaScript source file.
	 */
	private function load_file( $name, $file_path, $is_script = false ) {

		$url = plugins_url($file_path, __FILE__);
		$file = plugin_dir_path(__FILE__) . $file_path;

		if( file_exists( $file ) ) {
			if( $is_script ) {
				wp_register_script( $name, $url, array('jquery') ); //depends on jquery
				wp_enqueue_script( $name );
			} else {
				wp_register_style( $name, $url );
				wp_enqueue_style( $name );
			} // end if
		} // end if

	} // end load_file

} // end class
new BlackSlashEmailSignupPopover();

/**************************************************
/* Black Slash Popover
**************************************************/

// Load Scripts and Styles
function ir_plugin_scripts() {
  // Magnific Popup Styles
  wp_register_style( 'magnific-style', plugin_dir_url( __FILE__ ) . 'css/magnific-popup.css' );
  wp_enqueue_style( 'magnific-style' );
  wp_register_script( 'magnific-script', plugin_dir_url( __FILE__ ) . 'js/jquery.magnific-popup.min.js', array(), '1.0.0', true );
  wp_enqueue_script( 'magnific-script' );
	// Ajax Mailchimp
	/*wp_register_script( 'ajax-mailchimp', plugin_dir_url( __FILE__ ) . 'js/jquery.ajaxchimp.min.js', array(), '1.0.0', true );
	wp_enqueue_script( 'ajax-mailchimp' );*/
	// Custom CSS
	wp_register_style( 'ir-custom-css', plugin_dir_url( __FILE__ ) . 'css/custom.css' );
	wp_enqueue_style( 'ir-custom-css' );
	// YouTube Subscribe Buttons
	//wp_register_script( 'youtube-subscribe', 'https://apis.google.com/js/platform.js' );
	//wp_enqueue_script( 'youtube-subscribe' );
	// Custom Scripts - Load Last!
	wp_register_script( 'ir-custom', plugin_dir_url( __FILE__ ) . 'js/custom.js', array('jquery'), null, true );
	wp_enqueue_script( 'ir-custom' );
	// Initiate Modals
	if( !is_page_template('fullpage-template.php') && !is_single(array()) ) {
		wp_register_script( 'ir-custom-popup', plugin_dir_url( __FILE__ ) . 'js/custom-popup.js', array(), '1.0.0', true );
		wp_enqueue_script( 'ir-custom-popup' );
	}
}
add_action( 'wp_enqueue_scripts', 'ir_plugin_scripts' );

// ReCaptcha
add_action('wp_head','google_recaptcha');
function google_recaptcha() {

	$output="<script src='https://www.google.com/recaptcha/api.js'></script>";
	echo $output;

}

// Initialize The Popup
function ir_modal_signup() {
if( !is_page_template('fullpage-deck-template.php') && !is_single(array()) ) {

	global $aqura_data;
	$aqura_logo_dark = $aqura_data['logo_dark']['url'];

?>

	<div id="email-pop" class="bs-popup ir-white-popup mfp-hide">

        <div="text-align: center;">
            <div id="emailbuttonwrap">

				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="popup logo">
					<img src="<?php //echo esc_url($aqura_logo_dark); ?>https://oddflower.co/wp-content/uploads/2022/01/umeboshi-hand-logo.png" alt="<?php echo get_bloginfo('name'); ?> Logo">
				</a>

            	<!-- Begin Signup Form -->
				<form id="signup-form" action="<?php echo plugin_dir_url( __FILE__ ) . 'php/signup.php'; ?>" method="POST" accept-charset="utf-8" name="signup-form">
					<div>
						<input type="text" placeholder="first name" name="name"/>
					</div>
					<div>
						<input type="text" placeholder="email" name="email"/>
					</div>
					<div class="antispam">Leave this empty: <input id="spamurl" type="text" name="url" /></div>

					<div class="g-recaptcha" data-sitekey="6Lc4H4kaAAAAAE-kk4zhQ95HJvAycES0s1po-p-z"></div>

					<div>
						<input type="submit" value="Join The List" id="submit-btn"/>
					</div>
					<div id="status"></div>

					<p style="text-align:center;margin-bottom:25px;margin-top:0;">Get on the list for early access to new arrivals.</p>

				</form>
				<!--End Signup Form -->

            </div>
        </div>

    </div>

<?php
}
}
add_action( 'wp_footer', 'ir_modal_signup' );


/******************************************************************************************************************
SIGN UP FOR THE EMAIL LIST
******************************************************************************************************************/
function bs_new_user_signup( $email,$firstname ) {

	//---------------------------------------------------------------------------//
	// SETUP: PHP SDK
	//---------------------------------------------------------------------------//
	require_once( plugin_dir_path( __FILE__ ) . 'php/Omnisend.php' );
	$apikey   = "5e3c6fd499f0b71160c83e7c-P2ARKPl7Dbg9oY3OJ8ZUPepHz8LCv5yIpwPN2P6eUDb85U855b";
	$omnisend = new Omnisend($apikey, array('timeout' => 15));

	//---------------------------------------------------------------------------//
	// SUBSCRIBE (Create New Contact)
	//---------------------------------------------------------------------------//
	$contactID = "";
	$contacts = $omnisend->post(
	    'contacts',
	    array(
	        "email" => $email,
	        "firstName" => $firstname,
	        "lastName" => "",
	        "status" => "subscribed",
	        "statusDate" => date("c"),
	    )
	);
	if ($contacts) {
	    $response = "Account Created";
	} else {
	   $response = $omnisend->lastError();
	}

	return $response;

}
?>
