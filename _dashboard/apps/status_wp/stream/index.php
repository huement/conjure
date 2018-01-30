<!DOCTYPE html>



<html lan="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <!-- Latest compiled and minified CSS -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    
    </head>
    <body>
    
        
        <div class="container-fluid">
            
            <!--Header-->
            <div class="row text-center text-google-WorkSans header">
                <h1>Status Board</h1>
                <class="col-md-6" id="uptimetext"><h5></h5></class>
                
                
            </div>
            
            <!--Nav bar-->
            <div class="row navbar navbar-inverse">
                <ul class="nav navbar-nav">
                    <li class="text-google-WorkSans"><a href="#"><h4>System Information</h4></a></li>
                    <li class="text-google-WorkSans"><a href="#"><h4>About</h4></a></li>
                </ul>
                
            </div>
            
            <div class="container-fluid text-google-WorkSans">
                <!--System Info-->
                <div class="sysinfo row ">
                    <div class="row  text-center">
                        <div class="col-md-6 cpuinfo" >
                            <h3>CPU</h3>
                            <h3 id="cputextdiv"></h3>
                            <canvas id="cpuInfoCanvas" height="300px"></canvas>
                            
                        </div>
                        
                        <div class="col-md-6 meminfo" >
                            <h3>Memory</h3>
                            <h3 id="memtextdiv"></h3>
                            <canvas id="memInfoCanvas" height="300px"></canvas>
                            
                        </div>
                    </div>

                    <div class="row diskinfo text-center text-google-WorkSans">
                        <h3>Hard Drive</h3>
                        <canvas id="diskInfoCanvas"></canvas>
                            
                    </div>

                </div>

                <!--About page. The display:none is disabled when the 'About' button in navbar is clicked-->
                <div class="aboutscreen" style="display:none">

                </div>

            </div>
            
            
        
    
    
    
        <script
          src="https://code.jquery.com/jquery-1.12.4.min.js"
          
          crossorigin="anonymous"></script>
        <!--Bootstrap-->
    
        
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"   crossorigin="anonymous"></script>
        
        
        <!--Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Work+Sans" rel="stylesheet">
        
        <!--my own css/js -->
        <link href="css/styles.css" rel="stylesheet">
        <script src="js/main.js"></script>
    </body>



</html>