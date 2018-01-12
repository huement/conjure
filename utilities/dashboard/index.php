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
    <div class="sidebar" data-background-color="white" data-active-color="danger">

    <!--
		Tip 1: you can change the color of the sidebar's background using: data-background-color="white | black"
		Tip 2: you can change the color of the active button using the data-active-color="primary | info | success | warning | danger"
	-->

    	<div class="sidebar-wrapper cosmic_fusion">

            <div class="logo">
                <a href="http://www.creative-tim.com" class="simple-text">
                    PressCraft
                </a>
            </div>

            <!-- SIDEBAR -->
            <?php include "./parts/navigation_sidebar.php"; ?>

    	</div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-panel">

        <!-- HEADER NAV -->
        <?php include "./parts/navigation_main_header.php"; ?>


        <div class="content">
            <div class="container-fluid">

                <!-- CIRCLE STATS ROW -->
                <?php include "./parts/dashboard_circlestats.php"; ?>

                <div class="row">
                    <div class="col-sm-7 col-md-8">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Email Statistics</h4>
                                <p class="category">Last Campaign Performance</p>
                            </div>
                            <div class="content">


                                <div class="footer">
                                    <hr>
                                    <div class="stats">
                                        <i class="ti-timer"></i> Campaign sent 2 days ago
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-5 col-md-4">
                        <div class="card ">
                            <div class="header">
                                <h4 class="title">Wordpress Sites</h4>
                                <p class="category">/home/vagrant/www</p>
                            </div>
                            <div class="content">
                                <div style="padding-bottom:20px;">
                                  <?php
                                    $www_dir = "/home/vagrant/code";
                                    $files = array_slice(scandir($www_dir), 2);
                                    foreach($files as $key=>$file){
                                      echo "<h3 class='site_title'>".$file."</h3>";
                                    }
                                  ?>
                                </div>

                                <div class="footer">
                                    <hr>
                                    <div class="stats">
                                        <i class="ti-crown"></i> Install New Wordpres Site
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Email Statistics</h4>
                                <p class="category">Last Campaign Performance</p>
                            </div>
                            <div class="content">
                                <div id="chartPreferences" class="ct-chart ct-perfect-fourth"></div>

                                <div class="footer">
                                    <div class="chart-legend">
                                        <i class="fa fa-circle text-info"></i> Open
                                        <i class="fa fa-circle text-danger"></i> Bounce
                                        <i class="fa fa-circle text-warning"></i> Unsubscribe
                                    </div>
                                    <hr>
                                    <div class="stats">
                                        <i class="ti-timer"></i> Campaign sent 2 days ago
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card ">
                            <div class="header">
                                <h4 class="title">2015 Sales</h4>
                                <p class="category">All products including Taxes</p>
                            </div>
                            <div class="content">
                                <div id="chartActivity" class="ct-chart"></div>

                                <div class="footer">
                                    <div class="chart-legend">
                                        <i class="fa fa-circle text-info"></i> Tesla Model S
                                        <i class="fa fa-circle text-warning"></i> BMW 5 Series
                                    </div>
                                    <hr>
                                    <div class="stats">
                                        <i class="ti-check"></i> Data information certified
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <footer class="footer">
            <div class="container-fluid">
                <nav class="pull-left">
                    <ul>

                        <li>
                            <a href="http://www.creative-tim.com">
                                Creative Tim
                            </a>
                        </li>
                        <li>
                            <a href="http://blog.creative-tim.com">
                               Blog
                            </a>
                        </li>
                        <li>
                            <a href="http://www.creative-tim.com/license">
                                Licenses
                            </a>
                        </li>
                    </ul>
                </nav>
                <div class="copyright pull-right">
                    &copy; <script>document.write(new Date().getFullYear())</script>, made with <i class="fa fa-heart heart"></i> by <a href="http://www.creative-tim.com">Creative Tim</a>
                </div>
            </div>
        </footer>

    </div>
</div>


  <!-- FEEDBACK MODAL -->
  <div class="feedback left">
    <div class="tooltips">
        <div class="btn-group dropup">
          <button type="button" class="btn btn-primary dropdown-toggle btn-circle btn-lg" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-bug fa-2x" title="Report Bug"></i>
          </button>
          <ul class="dropdown-menu dropdown-menu-right dropdown-menu-form">
            <li>
              <div class="report">
                <h2 class="text-center">Report Bug</h2>
                <form class="doo" method="post" action="report.php">
                  <div class="col-sm-12">
                    <textarea required id="bug_txt" name="comment" class="form-control" placeholder="Please tell us what bug or issue you've found, provide as much detail as possible."></textarea>
                    <input name="screenshot" type="hidden" class="screen-uri">
                    <span class="screenshot pull-right"><i class="fa fa-camera cam" title="Take Screenshot"></i></span>
                   </div>
                   <div class="col-sm-12 clearfix" style="padding:0px;">
                    <button class="btn btn-primary btn-block">Submit Report</button>
                   </div>
               </form>
              </div>
              <div class="loading text-center hideme">
                <h2>Please wait...</h2>
                <h2><i class="fa fa-refresh fa-spin"></i></h2>
              </div>
              <div class="reported text-center hideme">
                <h2>Thank you!</h2>
                <p>Your submission has been received, we will review it shortly.</p>
                 <div class="col-sm-12 clearfix" style="padding:0px;">
                    <button class="btn btn-success btn-block do-close">Close</button>
                 </div>
              </div>
              <div class="failed text-center hideme">
                <h2>Oh no!</h2>
                <p>It looks like your submission was not sent.<br><br><a href="mailto:">Try contacting us by the old method.</a></p>
                 <div class="col-sm-12 clearfix">
                    <button class="btn btn-danger btn-block do-close">Close</button>
                 </div>
              </div>
            </li>
          </ul>
        </div>
    </div>
  </div>


  <!--   Core JS Files   -->
  <script src="assets/js/jquery-1.10.2.js" type="text/javascript"></script>
  <script src="assets/js/bootstrap.min.js" type="text/javascript"></script>

  <!-- Used for Weather Widget -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery.simpleWeather/3.1.0/jquery.simpleWeather.min.js"></script>
  <!-- Used for Feedback Reporter -->
  <script src="//cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>


  <!-- PressCraft Dashboard Core javascript and methods for Demo purpose -->
  <script src="dist/dash-libs.js"></script>

  <!-- PressCraft Dashboard Core javascript and methods for Demo purpose -->
  <script src="dist/dash.min.js"></script>

  <!-- PressCraft Dashboard DEMO methods, don't include it in your project! -->
  <script src="assets/js/demo.js"></script>

  <script type="text/javascript">
  	$(document).ready(function(){

      	//demo.initChartist();

      	// $.notify({
        //   	icon: 'ti-gift',
        //   	message: "Welcome to <b>PressCraft Dashboard</b> - a beautiful Bootstrap freebie for your next project."
        //
        //   },{
        //       type: 'success',
        //       timer: 4000
        //   });

        $("#dynpagename").html("<span class='red'>D</span>ash<span>B</span>oard");
  	});
  </script>

</body>
</html>
