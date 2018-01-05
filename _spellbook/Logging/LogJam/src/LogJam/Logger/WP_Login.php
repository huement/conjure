<?php

namespace LogJam\Logger;
use LogJam\Logger;

class WP_Login extends Logger
{
	protected $label = 'User';
	protected $hooks = array( 'wp_login' );
	protected $log_level = \LogJam::DEFAULT_LEVEL;
	protected $priority = 10;
	protected $accepted_args = 1;

	/**
	 * Set the properties to the `LogJam\Log` object for the log.
	 *
	 * @param mixed $additional_args An array of the args that was passed from WordPress hook.
	 */
	public function log( $additional_args )
	{
		list( $user_login ) = $additional_args;

		$title = sprintf(
			__( 'User "%s" logged in.', 'logjam' ),
			esc_html( $user_login )
		);

		$this->set_title( $title );
	}
}
