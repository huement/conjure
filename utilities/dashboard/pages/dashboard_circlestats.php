<section class="row text-centers circle_stat_rows" style="margin-top:10px;">

  <div class="col-lg-3 col-md-6 col-sm-6">
    <div class="card">
        <div class="container-edge">
            <div class="row no-gutters stat_card">
                <div class="col-5" style="background-color:#C34B35">
                  <h2 class="stat-amount" id="cpu_target">...</h2>
                </div>
                <div class="col-7">
                    <div class="numbers">

                          <span class="icon stat-icon icon-warning text-center">
                              <i class="ti-pulse" style="color:#C34B35"></i>
                          </span>

                        <p>CPU AVG LOAD</p>
                        <p class="stats"><a href="#">More Info</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
  <!-- <div class="col-md-6 col-sm-6 col-lg-3">
    <div class="card text-white bg-primary">
      <div class="card-body pb-0">
        <div class="btn-group float-right">
          <button type="button" class="btn btn-light dropdown-toggle p-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="icon-settings"></i>
          </button>
          <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <a class="dropdown-item" href="#">Something else here</a>
          </div>
        </div>
        <h4 class="mb-0" style="margin-top:10px;width:35%;float:left;font-size:2em" id="mem_free">9.823</h4>
        <p class="widgetGraph_subtitle">AVAILABLE RAM</p>
      </div>
      <div class="chart-wrapper px-3" style="height:70px;">
        <canvas id="card-chart1" class="chart" height="70"></canvas>
      </div>
    </div>
  </div> -->
  <!-- <div class="col-lg-3 col-md-6 col-sm-6">
    <div class="card text-white bg-primary">
      <div class="card-body pb-0">
        <div class="btn-group float-right" style="margin:10px 10px -10px -10px;border-color:#EEE!important">
          <button type="button" class="btn btn-transparent dropdown-toggle p-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-cog fa-lg"></i>
          </button>
          <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <a class="dropdown-item" href="#">Something else here</a>
          </div>
        </div>
        <h4 class="mb-0" style="margin-top:10px;width:35%;float:left;font-size:2em" id="mem_free">...</h4>
        <p class="widgetGraph_subtitle">AVAILABLE RAM</p>
      </div>
      <div class="chart-wrapper px-3" style="height:70px;">
        <div class="smallChart">
          <span class="line">5,3,9,6,5,9,7,3,5,2,5,3,9,6,5,9,7,3,5,2</span>
        </div>
      </div>
    </div>
  </div> -->

  <div class="col-lg-3 col-md-6 col-sm-6">
    <div class="card">
        <div class="container-edge">
            <div class="row no-gutters stat_card">
                <div class="col-5" style="background-color:#E1BA46">
                  <h2 class="stat-amount" id="mem_free">...</h2>
                </div>
                <div class="col-7">
                    <div class="numbers">
                          
                          <span class="icon stat-icon icon-warning text-center">
                              <i class="ti-dashboard" style="color:#E1BA46"></i>
                          </span>

                        <p>USED RAM</p>
                        <p class="stats"><a href="#"><span id="mem_total"></span>&nbsp;&nbsp;Total</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 col-sm-6">
    <div class="card">
        <div class="container-edge">
            <div class="row no-gutters stat_card">
                <div class="col-5" style="background-color:#94C859">
                  <h2 class="stat-amount" id="hdd_used">...</h2>
                </div>
                <div class="col-7" style="padding-left:0;padding-right:0;">
                    <div class="numbers">

                          <span class="icon stat-icon icon-warning text-center">
                              <i class="ti-layout-grid2-alt" style="color:#94C859"></i>
                          </span>

                        <p>HDD USAGE</p>
                        <p class="stats"><a href="#">View Files</a></p>
                    </div>
                    <!-- <div class="smallChart" style="margin-top:10px;margin-bottom:-10px;">
                      <span class="line">5,3,9,6,5,9,7,3,5,2,5,3,9,6,5,9,7,3,5,2</span>
                    </div>-->



                </div>
            </div>
        </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-6 col-sm-6">
    <div class="card">
        <div class="container-edge">
            <div class="row no-gutters stat_card">
              <div class="col-5" id="weather_color">
                <h2 class="stat-amount" id="weather_temp">...</h2>
              </div>
              <div class="col-7" id="weather">
                  <div class="numbers">

                      <div class="icon stat-icon text-center" id="weather_icon_wrapper">
                          <div id="weather_icon"></div>
                      </div>
                      <p id="weather_cond">...</p>
                      <p class="stats"><a href="#" id="weather_city">...</a></p>
                      <!-- <p ><a href="#"><i class="ti-link"></i> Files</a></p> -->
                  </div>
              </div>
                <!-- <div id="weather"><img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/93/loader.gif" alt="Loading..." class="loading"><br />Loading...</div> -->

            </div>
        </div>
    </div>
  </div>
</section>
