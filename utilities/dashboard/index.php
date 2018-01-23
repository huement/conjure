<?php

/**
 *  Conjure Dashboard
 *  -- -- -- -- -- --
 */

 // Suppress DateTime warnings
 date_default_timezone_set( @date_default_timezone_get() );

 /**
  * @brief  Super quick and dirty page loader.
  * @return HTML string of the requested (or default) layout.
  */

 function curPageURL() {

   if ($_SERVER["HTTPS"] == "on") { $pageURL = "http://"; } else { $pageURL = "https://"; }

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
   $result = contains($url["fragment"], $pages);
 else if(isset($url["query"]))
   $result = contains($url["query"], $pages);

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

 // Potentially this contains page specific javascript (if file exists)
 $jsPage = "./pages/scripts/".$page_active.".php";

 // The identifier PHP echos out to JS for Nav highlights, page title etc.
 $jsPageHTML = "<div id='act_nav' style='display:none'>".$page_active."</div>";

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

  <link href="dist/dash_orgy.css" rel="stylesheet"/>
  <link href="dist/ui_ux.css" rel="stylesheet" />

  <link href="https://fonts.googleapis.com/css?family=Fira+Mono:400,700|Open+Sans:300,400" rel="stylesheet">
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

                /**
                 * Important! This loads the individual page content.
                 * @var String of HTML
                 */
                include $dashboardPage;

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


<!--   jQuery  -->
<script src="dist/libs/jquery-3.2.1.js" type="text/javascript"></script>
<!-- Used for Weather Widget -->
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js" type="text/javascript"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery.simpleWeather/3.1.0/jquery.simpleWeather.min.js" type="text/javascript"></script>

<!--   Bootstrap4   -->
<script src="dist/libs/bootstrap.bundle.min.js" type="text/javascript"></script>

<!-- Used for Feedback Reporter -->
<script src="//cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js" type="text/javascript"></script>
<script src="node_modules/chart.js/dist/Chart.min.js"></script>


<!--   Bootstrap4   -->
<script src="dist/bs4.min.js" type="text/javascript"></script>

<!-- PressCraft Dashboard Core -->
<script src="dist/dash.min.js" type="text/javascript"></script>


<script type="text/javascript">
  /**
   *  @brief   Core Dashboard UI Functions. Updates Active Name, Page Title etc.
   */
  $(document).ready(function(){

      var aNav = $("#act_nav").text();
      aNav += "-nav";
      var activeNav = "#" + aNav;
      var activeNavString = $(activeNav).children(".nav-item p").text();

      $(activeNav).addClass("active").parent("li").addClass("active");

      $("#dynpagename").html("<span class='red'>" + activeNavString + "</span>");

      var newTitle = "Conjure | " + activeNavString;

      $(document).prop('title', newTitle);

      $('.nav-link.dropdown-toggle').on('click',function(e){
         let dropdown=$(e.target).closest('.nav-link.dropdown-toggle');
         dropdown.toggleClass('show');
      });

  /**
   *  @BRIEF  NAVBAR HIGHLIGHT FUNCTION
   *  @TODO   MAKE THE TOPNAV NOT DROPDOWNS
   */

  //$(function() {
  //  var $el,
  //    leftPos,
  //    newWidth,
  //    $mainNav = $(".navbar-nav");
  //
  //  $mainNav.append("<li id='magic-line'></li>");
  //  var $magicLine = $("#magic-line");
  //
  //  $magicLine
  //    .width($(".active").width())
  //    .css("left", $(".active a").position().left)
  //    .data("origLeft", $magicLine.position().left)
  //    .data("origWidth", $magicLine.width());
  //
  //  $(".navbar-nav li a").hover(
  //    function() {
  //      $el = $(this);
  //      leftPos = $el.position().left;
  //      newWidth = $el.parent().width();
  //      $magicLine.stop().animate({
  //        left: leftPos,
  //        width: newWidth
  //      });
  //    },
  //    function() {
  //      $magicLine.stop().animate({
  //        left: $magicLine.data("origLeft"),
  //        width: $magicLine.data("origWidth")
  //      });
  //    }
  //  );
  //});

  });
</script>

<?php

  /**
   * Allow for individual pages to load their own JS library and functions AFTER all required JS.
   * @var [type]
   */
  if (file_exists($jsPage)) {
    include $jsPage;
  }

  /**
   * @brief active page indicator [ PHP to JS ]
   */
  echo $jsPageHTML;

?>

</body>
</html>
