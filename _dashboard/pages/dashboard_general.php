<?php
  /**
   * @brief    Dashboard Main Page
   * @details  Stats and general summary.
   */
?>

<!-- CIRCLE STATS ROW -->
<div class="row">
  <div class="col-sm-12 col-md-6">
      <div class="card ">
          <div class="card-header primary-color white-text">
              <p class="category pull-right">/home/vagrant/code/..</p>
              <h4 class="title">Wordpress</h4>
          </div>
          <div class="content">
              <div class="panel-body">


                <div id="psuedo-accordion">

                  <ul class="list-group list-group-header bordered-header">
                    <li class="list-group-item paper-list-heading bh btn btn-white btn-light" data-toggle="collapse" data-target="#collapseOne" style="background:#FFF" >
                      <h6 class="shakey-header"><span class="fa fa-plus-square text-success"></span> Build Wordpress Site</h6>
                    </li>
                  </ul>
                  <div class="collapsed collapse" data-parent="#psuedo-accordion" id="collapseOne">
                    <ul class="list-group list-group-body">
                      <li data-slug="wordpress" data-cat="stack" class="list-group-item d-flex justify-content-between align-items-center">Standard
                        <div class="action-buttons">
                          <a href="http://www.jquery2dotnet.com"><span class="fa fa-lg fa-copy"></span></a>
                          <a href="http://www.jquery2dotnet.com" class="trash"><span class="fa fa-lg fa-plus-square"></span></a>
                          <a href="http://www.jquery2dotnet.com" class="flag"><i class="fa fa-lg fa-bolt"></i></a>
                        </div>
                      </li>
                      <li data-slug="wordplate" data-cat="stack" class="list-group-item">Wordplate <span style="text-align:right;float:right"><i class="fa fa-car"></i></span></li>
                      <li data-slug="bedrock" data-cat="stack" class="list-group-item">Bedrock   <span style="text-align:right;float:right"><i class="fa fa-fighter-jet"></i></span></li>
                      <li data-slug="webpress" data-cat="stack" class="list-group-item">Webpress  <span style="text-align:right;float:right"><i class="fa fa-rocket"></i></span></li>
                      <li data-slug="cubi" data-cat="stack" class="list-group-item">WP Cubi   <span style="text-align:right;float:right"><i class="fa fa-question-circle"></i></span></li>
                    </ul>
                  </div>


                </div>

                <div class="push"></div>

                <ul class="list-group list-group-header" >
                    <li class="list-group-item list-group-body paper-list-heading">
                        <div class="container">

                          <div class="row">
                              <div class="col-sm-6 col-md-4 text-left">Name</div>
                              <div class="col-sm-6 col-md-4 text-right">Modified</div>
                              <div class="col-sm-6 col-md-2 text-right">Reports</div>
                              <div class="col-sm-6 col-md-2 text-right">Status</div>
                          </div>

                        </div>
                    </li>
                </ul>
                <ul class="list-group list-group-body" style="margin-bottom:8px;">
                <?php
                  $www_dir = "/home/vagrant/code";
                  $files = array_slice(scandir($www_dir), 2);
                  foreach($files as $key=>$file): ?>
                    <?php if(is_file("/home/vagrant/dashboard/data/stylestats_".$file.".json")){ $report = true; } else { $report = false; } ?>
                    <li class="list-group-item site-list-item" <?php if($report){ echo 'data-slug="'.$file.'"'; } ?> data-wpsite="true">

                        <div class="container">
                          <div class="row">
                              <div class="col-sm-6 col-md-4 text-left" style=" "><span class="fa fa-wordpress text-primary" aria-hidden="true"></span><?php echo $file; ?></div>
                              <div class="col-sm-6 col-md-4 text-right" style=""><span class="text-info">01/01/01 2018</span></div>
                              <div class="col-sm-6 col-md-2 text-right" style=""><?php if($report){ echo '<span class="fa fa-file text-primary"></span>'; } ?></div>
                              <div class="col-sm-6 col-md-2 text-right" style=""><span class="fa fa-check-circle text-success" aria-hidden="true"></span></div>
                          </div>
                        </div>

                    </li>
                <?php endforeach; ?>
                </ul>

              </div>
          </div>
      </div>


      <div class="card">
          <div class="card-header primary-color white-text">
              <p class="category pull-right">/home/vagrant/logs</p>
              <h4 class="title">Server Details</h4>
          </div>
          <div class="content">
              <p>
                <small>Note: To profile, <code>xdebug_on</code> must be set.</small>
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

              <div class="footer">
                  <div class="chart-legend">

                  </div>
                  <hr>
                  <div class="stats">
                      <i class="ti-timer"></i> XDEBUG is [DEPRICATED]
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
                <input type="text" class="form-control to1do-input" placeholder="Search for...">
                <span class="input-group-btn to1do-btn-box">
                  <button class="btn btn-primary to1do-btn" type="button">Go!</button>
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

              <!-- <table class="table todo-table">
                <tbody>
                  <tr>
                    <td>
                      <div class="checkbox">
                        <input id="checkbox1" type="checkbox">
                        <label for="checkbox1"></label>
                      </div>
                    </td>
                    <td>Sign contract for "What are conference organizers afraid of?"</td>
                    <td class="td-actions text-right">
                      <button type="button" rel="tooltip" title="Edit Task" class="btn btn-info btn-simple btn-sm">
                        <i class="fa fa-edit"></i>
                      </button>
                      <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-sm">
                        <i class="fa fa-times"></i>
                      </button>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <div class="checkbox">
                        <input id="checkbox2" type="checkbox" checked>
                        <label for="checkbox2"></label>
                      </div>
                    </td>
                    <td>Lines From Great Russian Literature? Or E-mails From My Boss?</td>
                    <td class="td-actions text-right">
                      <button type="button" rel="tooltip" title="Edit Task" class="btn btn-info btn-simple btn-sm">
                        <i class="fa fa-edit"></i>
                      </button>
                      <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-sm">
                        <i class="fa fa-times"></i>
                      </button>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <div class="checkbox">
                        <input id="checkbox3" type="checkbox">
                        <label for="checkbox3"></label>
                      </div>
                    </td>
                    <td>Flooded: One year later, assessing what was lost and what was found when a ravaging rain swept through metro Detroit
                    </td>
                    <td class="td-actions text-right">
                      <button type="button" rel="tooltip" title="Edit Task" class="btn btn-info btn-simple btn-sm">
                        <i class="fa fa-edit"></i>
                      </button>
                      <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-sm">
                        <i class="fa fa-times"></i>
                      </button>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <div class="checkbox">
                        <input id="checkbox4" type="checkbox" checked>
                        <label for="checkbox4"></label>
                      </div>
                    </td>
                    <td>Create 4 Invisible User Experiences you Never Knew About</td>
                    <td class="td-actions text-right">
                      <button type="button" rel="tooltip" title="Edit Task" class="btn btn-info btn-simple btn-sm">
                        <i class="fa fa-edit"></i>
                      </button>
                      <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-sm">
                        <i class="fa fa-times"></i>
                      </button>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <div class="checkbox">
                        <input id="checkbox5" type="checkbox">
                        <label for="checkbox5"></label>
                      </div>
                    </td>
                    <td>Read "Following makes Medium better"</td>
                    <td class="td-actions text-right">
                      <button type="button" rel="tooltip" title="Edit Task" class="btn btn-info btn-simple btn-sm">
                        <i class="fa fa-edit"></i>
                      </button>
                      <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-sm">
                        <i class="fa fa-times"></i>
                      </button>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <div class="checkbox">
                        <input id="checkbox6" type="checkbox" checked>
                        <label for="checkbox6"></label>
                      </div>
                    </td>
                    <td>Unfollow 5 enemies from twitter</td>
                    <td class="td-actions text-right">
                      <button type="button" rel="tooltip" title="Edit Task" class="btn btn-info btn-simple btn-sm">
                        <i class="fa fa-edit"></i>
                      </button>
                      <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-sm">
                        <i class="fa fa-times"></i>
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table> -->

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
