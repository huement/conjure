<?php
  /**
   * @brief    Dashboard Main Page
   * @details  Stats and general summary.
   */
?>

<!-- CIRCLE STATS ROW -->
<div class="row">
    <div class="col-sm-5 col-md-4">
        <div class="card">
            <div class="header">
                <h4 class="title">Todo List</h4>
                <p class="category">--- todo ---</p>
            </div>
            <div class="content">


                <div class="footer">
                    <hr>
                    <div class="stats" style="width:100%;">
                         <a href="#"><i class="fa fa-plus"></i> New List</a><a href="#" class="text-right" style="float:right;"><i class="fa fa-times"></i> Clear All</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-7 col-md-8">
        <div class="card ">
            <div class="header">
                <h4 class="title">Wordpress Sites</h4>
                <p class="category">/home/vagrant/www</p>
            </div>
            <div class="content">

                <div class="panel-body">
                  <ul class="list-group list-group-header">
                      <li class="list-group-item list-group-body">
                          <div class="container">

                            <div class="row">
                                <div class="col-sm-4 text-left">Name</div>
                                <div class="col-sm-6 text-right">Modified</div>
                                <div class="col-sm-2 text-right">Status</div>
                            </div>

                          </div>
                      </li>
                  </ul>
                  <ul class="list-group list-group-body" style="">
                  <?php
                    $www_dir = "/home/vagrant/code";
                    $files = array_slice(scandir($www_dir), 2);
                    foreach($files as $key=>$file): ?>
                      <li class="list-group-item">

                          <div class="container">
                            <div class="row">
                                <div class="col-sm-4 text-left" style=" "><span class="fa fa-wordpress text-primary" aria-hidden="true"></span> <?php echo $file; ?></div>
                                <div class="col-sm-6 text-right" style=""><span class="text-success">01/01/01 2018</span></div>
                                <div class="col-sm-2 text-right" style=""><span class="fa fa-check-circle text-success" aria-hidden="true"></span></div>
                            </div>
                          </div>

                      </li>
                  <?php endforeach; ?>
                  </ul>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h4 class="title">Page Speeds</h4>
                <p class="category">/home/vagrant/logs</p>
            </div>
            <div class="content">
                <table class="table table-bordered table-sm m-0">
                    <thead class="">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Tests Ran</th>
                            <th>Results</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php
                        $www_dir = "/home/vagrant/code";
                        $files = array_slice(scandir($www_dir), 2);
                        foreach($files as $key=>$file): ?>
                          <tr>
                              <td>
                                  <label class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input">
                                      <span class="custom-control-indicator"></span>
                                  </label>
                              </td>
                              <td><?php echo $file; ?></td>
                              <td>01/01/2018</td>
                              <td>CSSStats, PHP_CODE, i18n, A11y</td>
                              <td>BAD</td>
                          </tr>
                      <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="footer">
                    <div class="chart-legend">

                    </div>
                    <hr>
                    <div class="stats">
                        <i class="ti-timer"></i> Campaign sent 2 days ago
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
