<?php
  /**
   * @brief    Dashboard Main Page
   * @details  Stats and general summary.
   */
?>

<div class="row">
  <div class="col-sm-12 col-md-12">
      <div class="card ">
          <div class="card-header primary-color white-text">
              <p class="category pull-right">/vagrant/_spellbook</p>
              <h4 class="title">Spellbook</h4>
          </div>
          <div class="content">
              <div class="panel-body">

                <div class="123321">
                  <div class="row" style="margin:8px auto 15px auto;">
                    <div class="col-sm-12" style="margin-bottom:8px;">
                      <div class="alert alert-secondary alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>

                        <h4 class="alert-heading" style="margin-top: 10px;">Well done!</h4>
                        <p>Aww yeah, you successfully read this important alert message. This example text is going to run a bit longer so that you can see how spacing within an alert works with this kind of content.</p>
                        <hr>
                        <p class="mb-0">Whenever you need to, be sure to use margin utilities to keep things nice and tidy.</p>
                      </div>
                    </div>

                    <div class="col-md-6 col-lr-3">


                    </div>
                    <div class="col-md-6 col-lr-3">
                      <h6 class="shakey-header">Web Frameworks</h6>
                      <div class="list-group">
                        <li data-slug="laravel" data-cat="framework" class="list-group-item">Laravel <span style="text-align:right;float:right">[PHP]</span></li>
                        <li data-slug="lumen" data-cat="framework" class="list-group-item">Lumen <span style="text-align:right;float:right">[PHP]</span></li>
                        <li data-slug="react" data-cat="framework" class="list-group-item">React <span style="text-align:right;float:right">&nbsp;[JS]</span></li>
                        <li data-slug="bootstrap4" data-cat="framework" class="list-group-item">Bootstrap 4 <span style="text-align:right;float:right">&nbsp;[JS]</span></li>
                      </div>

                    </div>
                  </div>
                </div>

              </div>
          </div>
      </div>
  </div>
</div>

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
                    <?php if(is_file("/home/vagrant/utilities/dashboard/data/stylestats_".$file.".json")){ $report = true; } else { $report = false; } ?>
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
  </div>
  <div class="col-12 col-md-6">
    <div class="card-light">
      <div class="header">
        <h4 class="title">Tasks</h4>
        <p class="category">Backend development</p>
      </div>
      <div class="content">
        <div class="table-full-width">
          <table class="table">
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
                  <button type="button" rel="tooltip" title="Edit Task" class="btn btn-info btn-simple btn-xs">
                    <i class="fa fa-edit"></i>
                  </button>
                  <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs">
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
                  <button type="button" rel="tooltip" title="Edit Task" class="btn btn-info btn-simple btn-xs">
                    <i class="fa fa-edit"></i>
                  </button>
                  <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs">
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
                  <button type="button" rel="tooltip" title="Edit Task" class="btn btn-info btn-simple btn-xs">
                    <i class="fa fa-edit"></i>
                  </button>
                  <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs">
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
                  <button type="button" rel="tooltip" title="Edit Task" class="btn btn-info btn-simple btn-xs">
                    <i class="fa fa-edit"></i>
                  </button>
                  <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs">
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
                  <button type="button" rel="tooltip" title="Edit Task" class="btn btn-info btn-simple btn-xs">
                    <i class="fa fa-edit"></i>
                  </button>
                  <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs">
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
                  <button type="button" rel="tooltip" title="Edit Task" class="btn btn-info btn-simple btn-xs">
                    <i class="fa fa-edit"></i>
                  </button>
                  <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs">
                    <i class="fa fa-times"></i>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="footer">
          <hr>
          <div class="stats">
            <i class="fa fa-history"></i> Updated 3 minutes ago
          </div>
        </div>
      </div>
    </div>
  </div>

</div>


<div class="row">

  <div class="col-sm-12 col-md-6">
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

</div>
