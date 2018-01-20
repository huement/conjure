<?php
  /** DIY (DIWHY?) PAGE LOADER */

  function curPageURL() {
    $pageURL = 'http';
    if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
      $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
      $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
    } else {
      $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    }
    return $pageURL;
  }

  function contains($str, array $arr) {
      foreach($arr as $a) {
          if (stripos($str,$a) !== false) return $a;
      }
      return false;
  }

  $url           = parse_url(curPageURL());
  $defaultPage   = "./pages/dashboard.php";
  $files1        = scandir("./pages");
  $pages         = array();
  $result        = false;
  $result_back   = false;
  $page_active   = "dashboard";


  foreach($files1 as $k=>$f){
    if($f !== ".DS_Store" && $f !== "." && $f !== ".." && $f !== "dashboard" && $f !== "dashboard_general" && $f !== "dashboard_circlestats"){
      $pages[] = preg_replace('/\\.[^.\\s]{3,4}$/', '', $f);
    }
  }

  if(isset($url["fragment"])) {
    $result = contains($url["fragment"], $pages);
  } else if(isset($url["query"])){
    $result = contains($url["query"], $pages);
  }

  if($result) {
    $pageString = "./pages/".$result.".php";

    if (file_exists($pageString)) {
      include $pageString;
      $page_active = $result;
    }

  } else if($page_active == "dashboard") {
    // Load Default Page
    include $defaultPage;
  }

  $jsPage = "./pages/scripts/".$page_active.".php";

  echo "<div id='act_nav' style='display:none'>".$page_active."</div>";
?>
