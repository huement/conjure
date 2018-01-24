<?php

/**
 * SysHosts Dashboard Class
 */

namespace conjure_dash;

require "host_interface.php";

abstract class SysHosts implements host_interface {

  protected $hostname;
	protected $domain;
	protected $web_root         = '/home/vagrant/dashboard';
	protected $host_path;
	protected $host_info;
	protected $public_dir;
	protected $wp_path;
	protected $version;
	protected $composer_path    = '';
	protected $env_path         = '';
	protected $debug_log        = '';
	protected $config_settings  = '';
	protected $host_directories = array();
	protected $host_list         = array();


  public function set_hostname( $hostname ) {
		$this->hostname = $hostname;
	}

  public function set_debug_log_path( $log_file = '' ) {
		if ( file_exists( $this->wp_content_path . '/debug.log' ) ) {

			$this->debug_log = $this->wp_content_path . '/debug.log';
		} else {
			$this->debug_log = $log_file;
		}

	}

  protected function get_host_info() {

		$data = array(
			'hostname'        => $this->hostname,
			'domain'          => $this->domain,
			'web_root'        => $this->web_root,
			'host_path'       => $this->host_path,
			'public_dir'      => $this->public_dir,
			'wp_path'         => $this->wp_path,
			'composer_path'   => $this->composer_path,
			'debug_log'       => $this->debug_log,
		);

		return $data;
	}

  /**
   * Get an array that represents directory tree
   *
   * @param string $directory Directory path
   * @param bool   $recursive Include sub directories
   * @param bool   $listDirs  Include directories on listing
   * @param bool   $listFiles Include files on listing
   * @param string $exclude   Exclude paths that matches this regex
   *
   * @return array
   */
  public function dir_to_array( $directory, $recursive = true, $listDirs = false, $listFiles = true, $exclude = '' ) {
  	$arrayItems    = array();
  	$skipByExclude = false;
  	$handle        = opendir( $directory );
  	if ( $handle ) {
  		while ( false !== ( $file = readdir( $handle ) ) ) {
  			preg_match( "/(^(([\.]){1,2})$|(\.(svn|git|md))|(Thumbs\.db|\.DS_STORE))$/iu", $file, $skip );
  			if ( $exclude ) {
  				preg_match( $exclude, $file, $skipByExclude );
  			}
  			if ( ! $skip && ! $skipByExclude ) {
  				if ( is_dir( $directory . DIRECTORY_SEPARATOR . $file ) ) {
  					if ( $recursive ) {
  						$arrayItems = array_merge( $arrayItems, dir_to_array( $directory . DIRECTORY_SEPARATOR . $file, $recursive, $listDirs, $listFiles, $exclude ) );
  					}
  					if ( $listDirs ) {
  						$file         = $directory . DIRECTORY_SEPARATOR . $file;
  						$arrayItems[] = $file;
  					}
  				} else {
  					if ( $listFiles ) {
  						$file         = $directory . DIRECTORY_SEPARATOR . $file;
  						$arrayItems[] = $file;
  					}
  				}
  			}
  		}
  		closedir( $handle );
  	}

  	return $arrayItems;
  }

}

?>
