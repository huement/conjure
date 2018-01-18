<?php

/**
 *  Conjure Dashboard
 *  -- -- -- -- -- --
 */

 // Suppress DateTime warnings
 date_default_timezone_set( @date_default_timezone_get() );

?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>PressCraft Dashboard by Creative Tim</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
  <meta name="viewport" content="width=device-width" />

  <!--  Fonts and icons     -->
  <?php include "./parts/core_css.php"; ?>
</head>
<body>

<div class="wrapper">

    <!-- SIDEBAR -->
    <?php include "./parts/navigation_sidebar.php"; ?>


    <!-- MAIN PANEL -->
    <div class="main-panel">
      <!-- HEADER NAV -->
      <?php include "./parts/navigation_main_header.php"; ?>

        <!-- MAIN CONTENT -->
        <div class="content">
            <div class="container-fluid">

                <?php
                  /*
                       DIY (DIWHY?) PAGE LOADER
                   */

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

                  function contains($str, array $arr)
                  {
                      foreach($arr as $a) {
                          if (stripos($str,$a) !== false) return $a;
                      }
                      return false;
                  }

                  $url           = parse_url(curPageURL());

                  $defaultPage   = "./pages/dashboard.php";

                  $files1        = scandir("./pages");
                  $pages         = array();

                  foreach($files1 as $k=>$f){
                    if($f !== ".DS_Store" && $f !== "." && $f !== ".." && $f !== "dashboard" && $f !== "dashboard_general" && $f !== "dashboard_circlestats"){
                      $pages[] = preg_replace('/\\.[^.\\s]{3,4}$/', '', $f);
                    }
                  }

                  $result        = false;
                  $result_back   = false;
                  $page_active   = "dashboard";

                  if(isset($url["fragment"])) {
                    $result      = contains($url["fragment"], $pages);
                  } else if(isset($url["query"])){
                    $result = contains($url["query"], $pages);
                  }

                  if($result)
                  {
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
            </div>
        </div>

        <!-- FOOTER -->
        <footer class="footer">
            <div class="container-fluid">
                <nav class="pull-left">
                    <ul>

                        <li>
                            <a href="https://www.myriadmobile.com">
                                Myriad Mobile
                            </a>
                        </li>
                        <li>
                            <a href="http://www.myriadmobile.com/blog">
                               Myriad Blog
                            </a>
                        </li>
                        <li>
                            <a href="http://bitbucket.org/myriadmobile">
                                Bitbucket.org
                            </a>
                        </li>
                    </ul>
                </nav>
                <div class="copyright pull-right">
                    &copy; <script>document.write(new Date().getFullYear())</script>, made with <i class="fa fa-heart fa-lg text-danger"></i> by <a href="https://www.myriadmobile.com" class="text-primary">Myriad Mobile</a>
                </div>
            </div>
        </footer>

    </div>
</div>


<!--   Core JS Files   -->
<script src="dist/libs/jquery-3.2.1.js" type="text/javascript"></script>

<!-- PressCraft Dashboard Core javascript and methods for Demo purpose -->
<script src="dist/dash-libs.js"></script>

<!-- Used for Weather Widget -->
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery.simpleWeather/3.1.0/jquery.simpleWeather.min.js"></script>
<!-- Used for Feedback Reporter -->
<script src="//cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>

<script src="dist/libs/bootstrap.js" type="text/javascript"></script>
<script src="dist/bs-libs.js" type="text/javascript"></script>

<!-- PressCraft Dashboard Core javascript and methods for Demo purpose -->
<script src="dist/dash.min.js"></script>

<script type="text/javascript">
	$(document).ready(function(){
      var activeNav = $("#act_nav").text();
      activeNav += "-nav";

      $("#"+activeNav).addClass("active").parent("li").addClass("active");

      $("#dynpagename").html("<span class='red'>D</span>ash<span>B</span>oard");
	});
</script>

<?php
  if (file_exists($jsPage)) {
    include $jsPage;
  }
?>
</body>
</html>
