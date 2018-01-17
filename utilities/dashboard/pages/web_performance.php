<?php
  /**
   * @brief    Dashboard Main Page
   * @details  Stats and general summary.
   */
?>

<!-- CIRCLE STATS ROW -->
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
