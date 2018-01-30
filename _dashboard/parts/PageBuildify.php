<?php

/**
 *
 * PHP v7.1
 *
 * Created: 01/27/2018, 11:33 PM
 *
 * LICENSE:    MIT
 *
 * @author         Derek Scott <dscott@myriadmobile.com>
 * @copyright  (c) 2016 Myriad Mobile
 *
 * conjure_dash
 * PageBuildify
 *
 * @brief       Contains various functions for building out the Dashboard UI.
 *
 */

namespace conjure_dash;

class PageBuildify {

	private $default_jumbo = "outrun_red";

	public function __construct() {}

  public function jumbotron( $jumbo_title, $jumbo_desc, $jumbo_details=false, $jumbo_theme=false ) {

    if(isset($jumbo_theme)){
      $grad_jumbo = $jumbo_theme;
    } else {
      $grad_jumbo = $this->default_jumbo;
    }

    $jumbo_html = '<div class="jumbotron jumbo-sex '.$grad_jumbo.'">
      <div class="container-fluid">
        <h2 class="display-4" style="margin-top:10px;">'. $jumbo_title.'</h2>
        <p class="lead">'.$jumbo_desc.'</p>';

    if(isset($jumbo_details)){
      $jumbo_html .= '<p>'.$jumbo_details.'</p>';
    }

    $jumbo_html .= '</div></div>';

    return $jumbo_html;

  }

  public function currentPage() {
    $url           = parse_url($this->curPageURL());
    $defaultPage   = "./pages/dashboard.php";
    $files1        = scandir("./pages");
    $pages         = array();
    $result        = false;
    $page_active   = "dashboard";

    $ignoreList    = array("dashboard", "dashboard_general", "dashboard_circlestats", ".DS_Store", ".", "..", "Icon");

    foreach( $files1 as $k=>$f )
    {
      if( ! in_array($f, $ignoreList) )
      {
        // Not ignored. so lets add to our page array
        $pages[] = preg_replace('/\\.[^.\\s]{3,4}$/', '', $f);
      }
    }

    if( isset($url["fragment"]) )
      $result = $this->contains($url["fragment"], $pages);
    else if(isset($url["query"]))
      $result = $this->contains($url["query"], $pages);

    if( $result ) {
      $pageString = "./pages/".$result.".php";

      if ( file_exists($pageString) ){
        $dashboardPage = $pageString;
        $page_active   = $result;
      }

    } else if( $page_active == "dashboard" ) {
      // Load Default Page
      $dashboardPage = $defaultPage;
    }

    return array("template"=>$dashboardPage, "current_nav"=>$page_active);
  }

  public function curPageURL() {

     if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") { $pageURL = "http://"; } else { $pageURL = "https://"; }

     if ($_SERVER["SERVER_PORT"] != "80") {
       $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
     } else {
       $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
     }

     return $pageURL;
   }

  public function contains($str, array $arr) {
     foreach($arr as $a) {
         if (stripos($str,$a) !== false) return $a;
     }
     return false;
   }

}

?>
