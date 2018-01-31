<?php
  /**
   * @brief    Dashboard Main Page
   * @details  Stats and general summary.
   */
  $widgetData = $dashData->getStorage();
  $siteURL = $dashData->getBaseURL();
?>

<!-- SQUARE BOX WIDGET GRID -->
<div class="row" style="padding-top:6px;">
  <div class="col-sm-12 col-md-6">
      <div class="card ">
          <div class="card-header primary-color white-text">
              <p class="category pull-right"><?php if(strlen($widgetData["wp"]) > 15){ echo substr($widgetData["wp"],-15); } else { echo $widgetData["wp"]; } ?></p>
              <h4 class="title">Vagrant Sites</h4>
          </div>
          <div class="content">
              <div class="panel-body">

                <ul class="list-group" style="margin-bottom:8px;">
                  <li class="list-group-item list-group-body list-heading" style="background-color:#f7f7f9;">
                      <div class="container">

                        <div class="row">
                            <div class="col-sm-6 col-md-4 text-left">Name</div>
                            <div class="col-sm-6 col-md-4 text-right">Modified</div>
                            <div class="col-sm-6 col-md-2 text-right">Reports</div>
                            <div class="col-sm-6 col-md-2 text-right">Status</div>
                        </div>

                      </div>
                  </li>
                <?php
                  $fileraw = array_slice(scandir($widgetData["wp"]), 2);
                  $files = array();
                  foreach($fileraw as $key=>$file){
                    if($file !== ".DS_Store" && $file !== "." && $file !== ".."){
                      $files[] = $file;
                    }
                  }
                  foreach($files as $key=>$file): ?>
                    <?php if(is_file($siteURL."/data/stylestats_".$file.".json")){ $report = true; } else { $report = false; } ?>
                    <li class="list-group-item site-list-item" <?php if($report){ echo 'data-slug="'.$file.'"'; } ?> data-wpsite="true">

                        <div class="container">
                          <div class="row">
                              <div class="col-sm-6 col-md-4 text-left" style=" "><span class="fa fa-wordpress text-primary" aria-hidden="true"></span><?php echo $file; ?></div>
                              <div class="col-sm-6 col-md-4 text-right" style=""><span class="text-info">01/01/2018</span></div>
                              <div class="col-sm-6 col-md-2 text-right" style=""><?php if($report){ echo '<span class="fa fa-file text-primary"></span>'; } ?></div>
                              <div class="col-sm-6 col-md-2 text-right" style=""><span class="fa fa-pie-chart text-success" aria-hidden="true"></span></div>
                          </div>
                        </div>

                    </li>
                <?php endforeach; ?>
                </ul>

                <div class="btn-group icon-top-group d-flex" role="group" aria-label="Basic example">
                  <button type="button" class="btn btn-secondary w-100" data-toggle="collapse" data-target="#collapseOne"><i class="fa fa-plus-circle fa-lg icon-success icon-top"></i>Fresh Start</button>
                  <button type="button" class="btn btn-secondary w-100"><i class="fa fa-refresh fa-lg icon-success icon-top"></i>Reset Site</button>
                  <button type="button" class="btn btn-secondary w-100"><i class="fa fa-plus-circle fa-lg icon-success icon-top"></i>Reports</button>
                </div>

                <div id="psuedo-accordion">

                  <ul class="list-group minimal-lines-list">
                    <div class="collapsed collapse" data-parent="#psuedo-accordion" id="collapseOne">
                    <?php
                      $wsb = array();
                      $wsb[] = array("name"=>"Standard","icon"=>"car","stars"=>0,"iden"=>"stand");
                      $wsb[] = array("name"=>"Wordplate","icon"=>"plane","stars"=>3,"iden"=>"plate");
                      $wsb[] = array("name"=>"Bedrock","icon"=>"fighter-jet","stars"=>3,"iden"=>"brock");
                      $wsb[] = array("name"=>"Webpress","icon"=>"rocket","stars"=>4,"iden"=>"spidr");
                      $wsb[] = array("name"=>"WP Cubi","icon"=>"question-circle","stars"=>3,"iden"=>"cubi", "break"=>true);
                    ?>
                      <?php foreach($wsb as $wb): ?>
                        <li data-slug="wordpress" data-cat="stack" data-iden="<?php echo $wb['iden']; ?>" class="list-group-item d-flex justify-content-between align-items-center <?php if(isset($wb["break"])){ echo "breaker"; }?>">
                          <p class="pull-left"><i class="fa fa-circle <?php if(isset($wb["break"])){ echo "icon-warning"; } else { echo "icon-success"; } ?>"></i>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $wb["name"]; ?></p>
                          <p class="action-buttons"><i class="fa fa-<?php echo $wb['icon']; ?> fa-lg"></i></p>
                        </li>
                      <?php endforeach; ?>
                      </div>
                  </ul>

                </div>

              </div>
          </div>
      </div>


      <div class="card">
          <div class="card-header primary-color white-text">
              <p class="category pull-right"><?php if(strlen($widgetData["lf"]) > 15){ echo substr($widgetData["lf"],-15); } else { echo $widgetData["lf"]; } ?></p>
              <h4 class="title">Server Details</h4>
          </div>
          <div class="content">
              <div style="display:none" id="systemStatURL"><?php echo $siteURL."/apps/status_sys/xml.php?plugin=vitals&json"; ?></div>
              <div class="table-responsive" id="vitals_table">
                  <table id="vitals" class="table table-hover table-condensed noborderattop">
                      <tbody>
                          <tr>
                              <th><span id="lang_003">Canonical Hostname</span></th>
                              <td><span id="Hostname"></span></td>
                          </tr>
                          <tr>
                              <th><span id="lang_004">Listening IP</span></th>
                              <td><span id="IPAddr"></span></td>
                          </tr>
                          <tr>
                              <th><span id="lang_005">Kernel Version</span></th>
                              <td><span id="Kernel"></td>
                          </tr>
                          <tr>
                              <th><span id="lang_006">Distro Name</span></th>
                              <td><span id="Distro"></td>
                          </tr>
                          <tr>
                              <th><span id="lang_007">Uptime</span></th>
                              <td><span id="Uptime"></span></td>
                          </tr>
                          <tr>
                              <th><span id="lang_095">Last boot</span></th>
                              <td><span id="LastBoot"></span></td>
                          </tr>
                          <tr>
                              <th><span id="lang_008">Current Users</span></th>
                              <td><span id="Users">0</span></td>
                          </tr>
                          <tr>
                              <th><span id="lang_009">Load Averages</span></th>
                              <td><span id="LoadAvg"></span></td>
                          </tr>
                          <tr id="tr_SysLang" style="display: none;">
                              <th><span id="lang_097">System Language</span></th>
                              <td><span id="SysLang"></span></td>
                          </tr>
                          <tr id="tr_CodePage" style="display: none;">
                              <th><span id="lang_098">Code Page</span></th>
                              <td><span id="CodePage"></span></td>
                          </tr>
                          <tr id="tr_Processes">
                              <th><span id="lang_110">Processes</span></th>
                              <td><span id="Processes"></span></td>
                          </tr>
                      </tbody>
                  </table>
              </div> 


              <div style="padding:5px 10px;background:#F0F0F0;margin:10px auto;width:100%:">
                <p>
                  XDEBUG DETAILS
                </p>
                <p>
                  <small>Note: To profile, <code>xdebug_on</code> must be set.</small>
                  <small>Note: XDebug has been depricated and will no longer function in PHP 7.2.</small>
                </p>
                <p>
                  <?php
                  $xdebug = ( extension_loaded( 'xdebug' ) ? true : false );
                  if ( $xdebug ) {
                    ?>
                    <span class="text-success">xDebug is currently <span class="badge badge-success">on</span></span>
                    <?php
                  } else {
                    ?>
                    <span class="text-danger">xDebug is currently <span class="badge badge-danger">off</span></span>
                    <?php
                  }
                  ?>
                </p>
              </div>

              <div class="footer">
                  <hr>
                  <div class="stats">
                      <i class="fa fa-heartbeat"></i> Full System Status
                  </div>
              </div>
          </div>
      </div>
  </div>
  <div class="col-12 col-md-6">
    <div class="card-light">
      <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs flex-wrap" id="myTab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="home-tab" href="#home" data-toggle="tab" role="tab">Tasks</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="offer-tab" href="#offer" data-toggle="tab" role="tab">Finished</a>
          </li>
        </ul>
      </div>

      <div class="content" style="padding:0px;">
        <div class="tab-content" id="couponTabContent">
          <div class="tab-pane fade show active" id="home" role="tabpanel">
            <div style="padding:12px">
              <div class="input-group to1do-input-group">
                <input type="text" class="form-control to1do-input" placeholder="Don't forget...">
                <span class="input-group-btn to1do-btn-box">
                  <button class="btn btn-primary to1do-btn" type="button"><i class="fa fa-plus"></i> ADD</button>
                </span>
              </div>
            </div>
            <hr style="margin-top:0px;">
            <div class="row">

              <div class="col-12">
                <ul class="list-group">
                <?php for($i=0; $i<5; $i++): ?>
                  <li class="list-group-item justify-content-between" style="border-left:none;border-right:none;">
                    Cras justo odio
                    <span class="badge badge-default badge-pill">02/1<?php echo $i; ?>/18</span>
                  </li>
                <?php endfor; ?>
                </ul>
              </div>

            </div>

          </div>

          <div class="tab-pane fade" id="offer" role="tabpanel">
            <div class="row" style="margin-top:15px;">

              <div class="col-12">
                <ul class="list-group">
                <?php for($i=0; $i<5; $i++): ?>
                  <li class="list-group-item justify-content-between" style="border-left:none;border-right:none;">
                    Cras justo odio
                    <span class="badge badge-default badge-pill">02/1<?php echo $i; ?>/18</span>
                  </li>
                <?php endfor; ?>
                </ul>
              </div>

            </div>

          </div>

        </div>

        <div class="footer">
          <hr>
          <div class="stats">
            Updated 3 minutes ago &nbsp;&nbsp;<i class="fa fa-history"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>


<div class="row">

  <div class="col-sm-12 col-md-6">

  </div>
  <div class="col-sm-6 col-12">



  </div>

</div>

</div>
