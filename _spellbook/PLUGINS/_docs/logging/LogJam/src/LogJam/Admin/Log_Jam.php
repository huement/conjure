<?php

namespace LogJam\Admin;
// Log_Page
final class Log_Jam
{
	private $post;
	private $meta;

	public function __construct()
	{
		if ( empty( $_GET['log_id'] ) ) {
			wp_die( 'Not found.' );
		}
		$this->post = get_post( $_GET['log_id'] );
		if ( empty( $this->post ) || 'logjam' !== $this->post->post_type ) {
			wp_die( 'Not found.' );
		}
		$this->meta = get_post_meta( $this->post->ID, '_logjam', true );
	}

	public static function get_instance()
	{
		static $instance;
		if ( ! $instance ) {
			$instance = new Log_Jam();
		}
		return $instance;
	}

	public function display()
	{
		$post = $this->post;

		if ( ! empty( $this->meta['log_level'] )) {
			$log_level = self::get_level_name( $this->meta['log_level'] );
		} else {
			$log_level = '';
		}

		echo '<div class="wrap logjam-log-details">';
		printf(
			'<p><a href="%s">%s</a></p>',
			admin_url( 'edit.php?post_type=logjam' ),
			esc_html__( 'Back to the list page.', 'logjam' )
		);

		printf(
			'<h1 class="log-title"><span class="%s log-level">[%s]</span> %s</h1>',
			esc_attr( $log_level ),
			esc_html( ucfirst( $log_level ) ),
			esc_html( $post->post_title )
		);

		echo $this->meta_contents();

		if ( ! empty( $post->post_content ) ) {
			$contents = json_decode( urldecode( $post->post_content ), true );
			if ( is_array( $contents ) ) {
				for ( $i = 0; $i < count( $contents ); $i++ ) {
					$title = $contents[ $i ]['title'];
					$content = $contents[ $i ]['content'];
					add_meta_box(
						'logjam-content-' . $i,
						$title,
						function () use ( $content ) {
							echo $content;
						},
						'logjam',
						'normal'
					);
				}
			}
		}

		echo '<div class="metabox-holder">';
		do_meta_boxes( 'logjam', 'normal', null );
		echo '</div>';

		echo '</div><!-- .wrap -->';
	}

	public function meta_contents()
	{
		if ( ! empty( $this->meta['is_cli'] ) ) {
			$author = 'WP-CLI';
		} elseif ( empty( $this->post->post_author ) ) {
			$author = 'anonymous';
		} else {
			$author = get_userdata( $this->post->post_author )->display_name;
		}

		return sprintf(
			'<p class="meta"><strong>%2$s</strong> by <strong>%1$s</strong></p>',
			esc_html( $author ),
			esc_html( get_date_from_gmt( $this->post->post_date_gmt, 'Y-m-d H:i:s' ) )
		);
	}

	protected function get_level_name( $level )
	{
		if ( ! $level ) {
			$level = '';
		}

		return $level;
	}
}
