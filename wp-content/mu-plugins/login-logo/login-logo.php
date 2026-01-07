<?php
/*
Plugin Name: WP Easy Custom Login
Description: Custom login screen automatically created from the logo and custom background set for the site. Essentially a hacked up version of Mark Jaquith's http://wordpress.org/plugins/login-logo/
Version: 1.0.0
License: GPL
Plugin URI: http://joshmallard.com
Author: Josh Mallard
Author URI: http://joshmallard.com
*/

class CWS_Login_Logo_Plugin {
	static $instance;
	const CUTOFF = 312;
	var $logo_locations;
	var $logo_location;
	var $width = 0;
	var $height = 0;
	var $original_width;
	var $original_height;
	var $logo_size;
	var $logo_file_exists;

	public function __construct() {
		self::$instance = $this;
		add_action( 'login_head', array( $this, 'login_head' ) );
	}

	public function init() {
		global $blog_id;
		$this->logo_locations = array();

		$this->logo_locations['global'] =  array(
			'path' => get_stylesheet_directory() . '/library/custom-theme/images/logos/logo.png',
			'url' => $this->maybe_ssl( get_stylesheet_directory_uri() . '/library/custom-theme/images/logos/logo.png' )
			);
	}

	private function maybe_ssl( $url ) {
		if ( is_ssl() )
			$url = preg_replace( '#^http://#', 'https://', $url );
		return $url;
	}

	private function logo_file_exists() {
		if ( ! isset( $this->logo_file_exists ) ) {
			foreach ( $this->logo_locations as $location ) {
				if ( file_exists( $location['path'] ) ) {
					$this->logo_file_exists = true;
					$this->logo_location = $location;
					break;
				} else {
					$this->logo_file_exists = false;
				}
			}
		}
		return !! $this->logo_file_exists;
	}

	private function get_location( $what = '' ) {
		if ( $this->logo_file_exists() ) {
			if ( 'path' == $what )
				return $this->logo_location[$what];
			elseif ( 'url' == $what )
				return $this->logo_location[$what] . '?v=' . filemtime( $this->logo_location['path'] );
			else
				return $this->logo_location;
		}
		return false;
	}

	private function get_width() {
		$this->get_logo_size();
		return absint( $this->width );
	}

	private function get_height() {
		$this->get_logo_size();
		return absint( $this->height );
	}

	private function get_original_width() {
		$this->get_logo_size();
		return absint( $this->original_width );
	}

	private function get_original_height() {
		$this->get_logo_size();
		return absint( $this->original_height );
	}

	private function get_logo_size() {
		if ( !$this->logo_file_exists() )
			return false;
		if ( !$this->logo_size ) {
			if ( $sizes = getimagesize( $this->get_location( 'path' ) ) ) {
				$this->logo_size = $sizes;
				$this->width  = $sizes[0];
				$this->height = $sizes[1];
				$this->original_height = $this->height;
				$this->original_width = $this->width;
				if ( $this->width > self::CUTOFF ) {
					// Use CSS 3 scaling
					$ratio = $this->height / $this->width;
					$this->height = ceil( $ratio * self::CUTOFF );
					$this->width = self::CUTOFF;
				}
			} else {
				$this->logo_file_exists = false;
			}
		}
		return array( $this->width, $this->height );
	}

	private function css3( $rule, $value ) {
		foreach ( array( '', '-o-', '-webkit-', '-khtml-', '-moz-', '-ms-' ) as $prefix ) {
			echo $prefix . $rule . ': ' . $value . '; ';
		}
	}

	public function login_headerurl() {
		return esc_url( trailingslashit( get_bloginfo( 'url' ) ) );
	}

	public function login_headertitle() {
		return esc_attr( get_bloginfo( 'name' ) );
	}
	
	public function custom_background_cb_dashboard() {
		// $background is the saved custom image, or the default image.
		$background = set_url_scheme( get_background_image() );
	
		// $color is the saved custom color.
		// A default has to be specified in style.css. It will not be printed here.
		$color = get_background_color();
	
		if ( $color === get_theme_support( 'custom-background', 'default-color' ) ) {
			$color = false;
		}
	
		if ( ! $background && ! $color )
			return;
	
		$style = $color ? "background-color: #$color;" : '';
	
		if ( $background ) {
			$image = " background-image: url('$background');";
	
			$repeat = get_theme_mod( 'background_repeat', get_theme_support( 'custom-background', 'default-repeat' ) );
			if ( ! in_array( $repeat, array( 'no-repeat', 'repeat-x', 'repeat-y', 'repeat' ) ) )
				$repeat = 'repeat';
			$repeat = " background-repeat: $repeat;";
	
			$position = get_theme_mod( 'background_position_x', get_theme_support( 'custom-background', 'default-position-x' ) );
			if ( ! in_array( $position, array( 'center', 'right', 'left' ) ) )
				$position = 'left';
			$position = " background-position: top $position;";
	
			$attachment = get_theme_mod( 'background_attachment', get_theme_support( 'custom-background', 'default-attachment' ) );
			if ( ! in_array( $attachment, array( 'fixed', 'scroll' ) ) )
				$attachment = 'scroll';
			$attachment = " background-attachment: $attachment;";
	
			$style .= $image . $repeat . $position . $attachment;
		}
	?>
	<style type="text/css" id="custom-background-css">
	body { <?php echo trim( $style ); ?> }
	</style>
	<?php
	}

	public function login_head() {
		$this->init();
		//if ( !$this->logo_file_exists() )
			//return;
		add_filter( 'login_headerurl', array( $this, 'login_headerurl' ) );
		add_filter( 'login_headertitle', array( $this, 'login_headertitle' ) );
	?>
	<!-- Login Logo plugin for WordPress: http://txfx.net/wordpress-plugins/login-logo/ -->
	<style type="text/css">
        body.login {
            background-color: #fff;
        }
		.login h1 a {
			background: url(<?php echo esc_url_raw( $this->get_location( 'url' ) ); ?>) no-repeat top center;
			width: <?php echo self::CUTOFF; ?>px;
			height: <?php echo $this->get_height(); ?>px;
			margin-left: 8px;
			padding-bottom: 16px;
			<?php
			if ( self::CUTOFF < $this->get_original_width() )
				$this->css3( 'background-size', 'contain' );
			else
				$this->css3( 'background-size', 'auto' );
			?>
		}
	</style>
    <?php echo $this->custom_background_cb_dashboard(); ?>
<?php if ( self::CUTOFF < $this->get_width() ) { ?>
<!--[if lt IE 9]>
	<style type="text/css">
		height: <?php echo $this->get_original_height() + 3; ?>px;
	</style>
<![endif]-->
<?php
		}
	}

}

// Bootstrap
new CWS_Login_Logo_Plugin;