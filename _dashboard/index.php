<?php
/**
 *  Conjure Dashboard
 *  -- -- -- -- -- --
 */

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . "/parts/PageBuildify.php";
require __DIR__ . "/parts/DashWizard.php";

use conjure_dash\PageBuildify;
use conjure_dash\DashWizard;

date_default_timezone_set( @date_default_timezone_get() );

$buildify = new PageBuildify();
$dashData = new DashWizard();


$dashData->setupPaths(__DIR__);
$page_data = $buildify->currentPage();

// Potentially this contains page specific javascript (if file exists)
$jsPage = "./pages/scripts/".$page_data["current_nav"].".php";

// The identifier PHP echos out to JS for Nav highlights, page title etc.
$jsPageHTML = "<div id='act_nav' style='display:none'>".$page_data["current_nav"]."</div>";

?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Conjuring. .  .</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
  <meta name="viewport" content="width=device-width" />

  <link href="dist/bs4_tweaked.css" rel="stylesheet" />
  <link href="dist/dash_orgy.css" rel="stylesheet"/>
  <link href="dist/ui_ux.css" rel="stylesheet" />

  <link href="https://fonts.googleapis.com/css?family=Fira+Mono:400,700|Open+Sans:300,400" rel="stylesheet">
</head>
<body>
<div id="base_url" style="display:none!important;"><?php echo trim($dashData->getBaseURL()); ?></div>
<div class="wrapper">

    <!-- SIDEBAR -->
    <?php include "./parts/navigation_sidebar.php"; ?>

    <!-- MAIN PANEL -->
    <div class="main-panel">

      <!-- HEADER NAV -->
      <?php include "./parts/navigation_main_header.php"; ?>

        <!-- MAIN CONTENT -->
        <div class="content">
          <div class="container-terminal">
            <div class="container-fluid">
              <div class="row">
                <div class="col-12">
                  <div id="terminal_frame_box">
                    <iframe src="about:blank" frameBorder="0" data-src="http://eve.huement.com:2222/ssh/host/127.0.0.1" id="terminal_frame" width="100%" height="0"></iframe>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="container-core">
            <div class="container-fluid">
              <?php

                /**
                 * Important! This loads the individual page content.
                 * @var String of HTML
                 */
                 include $page_data["template"];
                 //echo $page_data["template"];

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
</div>


<!--   jQuery  -->
<script src="dist/libs/jquery-3.2.1.js" type="text/javascript"></script>
<!-- Used for Weather Widget -->
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js" type="text/javascript"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery.simpleWeather/3.1.0/jquery.simpleWeather.min.js" type="text/javascript"></script>

<!--   Bootstrap4   -->
<script src="dist/libs/bootstrap.bundle.min.js" type="text/javascript"></script>

<!-- Used for Feedback Reporter -->
<script src="//cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js" type="text/javascript"></script>
<script src="node_modules/chart.js/dist/Chart.min.js" type="text/javascript"></script>
<script src="dist/libs/iframeResizer.min.js" type="text/javascript"></script>

<!-- Dashboard Core -->
<script src="dist/js_orgy.min.js" type="text/javascript"></script>

<?php
  // Each pages can load their own JS AFTER all required JS.
  if (file_exists($jsPage)) {
    include $jsPage;
  }

  // Active page indicator [ PHP to JS ]
  echo $jsPageHTML;
?>

<?php
$devMode = getenv('APP_ENV');
if($devMode !== "prod" || $devMode !== "production"): ?>
  <script id="__bs_script__">//<![CDATA[
      document.write("<script async src='http://HOST:3000/browser-sync/browser-sync-client.js?v=2.23.6'><\/script>".replace("HOST", location.hostname));
  //]]></script>
<?php endif; ?>
</body>
</html>
