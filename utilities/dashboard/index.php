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

	<title>C o n j u r e</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
  <meta name="viewport" content="width=device-width" />

  <!--  Fonts and icons     -->
  <?php include_once "./parts/core_css.php"; ?>
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
                <?php include "./parts/navigation_route_logic.php"; ?>
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

<!-- PressCraft Dashboard Core -->
<script src="dist/dash-libs.js"></script>

<!--   Graph JS   -->
<!-- <script src="assets/js/morris.js"></script> -->
<script src="assets/js/jquery.peity.js"></script>

<!-- Used for Weather Widget -->
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery.simpleWeather/3.1.0/jquery.simpleWeather.min.js"></script>

<!-- Used for Feedback Reporter -->
<script src="//cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>

<!--   Bootstrap4   -->
<script src="dist/libs/bootstrap.bundle.min.js" type="text/javascript"></script>
<script src="dist/bs-libs.js" type="text/javascript"></script>

<!-- PressCraft Dashboard Core javascript and methods for Demo purpose -->
<script src="dist/dash.min.js"></script>

<script type="text/javascript">
	$(document).ready(function(){
      var activeNav = $("#act_nav").text();
      activeNav += "-nav";

      $("#"+activeNav).addClass("active").parent("li").addClass("active");

      $("#dynpagename").html("<span class='red'>D</span>ash<span>B</span>oard");

      $('body').on('click','.nav-link.dropdown-toggle',function(e){
         let dropdown=$(e.target).closest('.nav-link.dropdown-toggle');
          dropdown.addClass('show');

        setTimeout(function(){
              dropdown[dropdown.is(':hover')?'addClass':'removeClass']('show');
          },300);
      });
	});
</script>

<?php
  if (file_exists($jsPage)) {
    include $jsPage;
  }
?>
</body>
</html>
