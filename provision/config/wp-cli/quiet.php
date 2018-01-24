<?php 
/**
 *   This file can hide all your erros, but since we are on a dev box, we dont want that.
 *   So instead we are going to make things be noisy. 
 */

// error_reporting(0);
// @ini_set('display_errors', 0);
// define( 'WP_DEBUG', false );

error_reporting(1);
@ini_set('display_errors', 1);
define( 'WP_DEBUG', true );