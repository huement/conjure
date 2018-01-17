
<section class="row text-center placeholders circle_stat_rows" style="margin-top:10px;">
  <div class="col-6 col-sm-3 placeholder">
    <div class="card">
        <div class="content">
            <div class="row">
                <div class="col-sm-5 col-xs-12">
                  <h2 class="stat-amount" id="cpu_target">...</h2>
                  <svg width="120" height="100">
                    <rect width="120" height="100" stroke-width="0" fill="#C34B35" />
                  </svg>
                </div>
                <div class="col-sm-7 col-xs-12">
                    <div class="numbers">

                          <span class="icon stat-icon icon-warning text-center">
                              <i class="ti-pulse" style="color:#C34B35"></i>
                          </span>

                        <p>CPU AVG LOAD</p>
                        <p class="stats"><a href="#"><i class="ti-link"></i> Details</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
  <div class="col-6 col-sm-3 placeholder">
    <div class="card">
        <div class="content">
            <div class="row">
                <div class="col-sm-5 col-xs-12">
                  <h2 class="stat-amount" id="mem_free">...</h2>
                  <svg width="120" height="100">
                    <rect width="120" height="100" stroke-width="0" fill="#E1BA46" />
                  </svg>
                </div>
                <div class="col-sm-7 col-xs-12">
                    <div class="numbers">
                          <!-- #1F556E -->
                          <span class="icon stat-icon icon-warning text-center">
                              <i class="ti-dashboard" style="color:#E1BA46"></i>
                          </span>

                        <p>USED RAM</p>
                        <p class="stats" id="mem_total"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
  <div class="col-6 col-sm-3 placeholder">
    <div class="card">
        <div class="content">
            <div class="row">
                <div class="col-sm-5 col-xs-12">
                  <h2 class="stat-amount" id="hdd_used">...</h2>
                  <svg width="120" height="100">
                    <rect width="120" height="100" stroke-width="0" fill="#94C859" />
                  </svg>
                </div>
                <div class="col-sm-7 col-xs-12">
                    <div class="numbers">

                          <span class="icon stat-icon icon-warning text-center">
                              <i class="ti-layout-grid2-alt" style="color:#94C859"></i>
                          </span>

                        <p>HDD USAGE</p>
                        <p class="stats"><a href="#">View Files</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
  <div class="col-6 col-sm-3 placeholder">
    <div class="card">
        <div class="content">
            <div class="row">
              <div class="col-sm-5 col-xs-12">
                <h2 class="stat-amount" id="weather_temp">...</h2>
                <svg width="120" height="100">
                  <rect width="120" height="100" stroke-width="0" fill="#666666" id="weather_color"/>
                </svg>
              </div>
              <div class="col-sm-7 col-xs-12" id="weather">
                  <div class="numbers">

                      <div class="icon stat-icon text-center" id="weather_icon_wrapper">
                          <div id="weather_icon"></div>
                      </div>
                      <p id="weather_cond">...</p>
                      <p class="stats" id="weather_city">...</p>
                      <!-- <p ><a href="#"><i class="ti-link"></i> Files</a></p> -->
                  </div>
              </div>
                <!-- <div id="weather"><img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/93/loader.gif" alt="Loading..." class="loading"><br />Loading...</div> -->

            </div>
        </div>
    </div>
  </div>
</section>
