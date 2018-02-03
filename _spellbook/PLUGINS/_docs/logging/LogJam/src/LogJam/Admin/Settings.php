<?php

namespace LogJam\Admin;

class Settings
{
	public function __construct()
	{
	}

	public static function get_instance()
	{
		static $instance;
		if ( ! $instance ) {
			$instance = new Settings();
		}
		return $instance;
	}

	public function display()
	{
		echo '<div class="wrap logjam-settings">';
		echo '<div class="well">
        <h1 class="wp-heading-inline">Log Jam | <span class="small-text">Settings</span></h1>
        </div>';
		echo '<form method="post">';
		wp_nonce_field( 'logjam-access-token', 'logjam-token' );
		echo '<h2>Rest API Access Token</h2>';
		$message = __( 'Regenerate token', 'logjam' );
		if ( $token = get_option( 'logjam-tmp-token' ) ) {
			delete_option( 'logjam-tmp-token' );
		} else {
			if ( get_option( 'logjam-api-token' ) ) {
				$token = str_repeat( '*', 40 );
			} else {
				$token = '';
				$message = __( 'Generate token', 'logjam' );
			}
		}
		echo '<div class="token"><span>' . esc_html( $token ) . '</span>';
		echo '<input type="submit" class="button" value="' . $message . '"></div>';
		echo '</form>';

		?>
		<h3>How to use an access token</h3>
		<p>Rest API endpoint to see logs requires Access Token.<br>
			Please generate Access Token and pass it as the value of <code>X-LogJam-API-Token</code> request header like following.</p>
		<pre>$ curl <?php echo esc_url( home_url() ); ?>/wp-json/logjam/v1/logs -H "X-LogJam-API-Token: &lt;your-access-token&gt;"</pre>
		<p><strong>Note:</strong> Access token will be displayed only once.</p>
		<?php

		echo '</div>';
	}
}
