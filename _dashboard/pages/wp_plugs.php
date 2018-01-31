<?php
/**
 *  @brief    Wordpress Plugin Information
 *  @details  Contains all the info and links for important plugins.
*/

$widgetData = $dashData->getStorage();
$sitePATH   = getenv('STORAGE_PATH');
$pluginPATH = getenv('STORAGE_SB');
$wpPlugins  = $sitePATH.$pluginPATH."/PLUGINS/*";

function loadPlugins($dir){

    // Scan the "PLUGINS" folder for categories
    $allPlugins = array_filter(glob($dir), 'is_dir');
    $pluginList = array();

    // Get each plugin for given category
    foreach($allPlugins as $key=>$plug){
        $dirName = basename($plug);
        if($dirName !== "_docs" && $dirName !== "docs"){
          $zips = array_filter(glob($plug."/*"), 'is_file');
          $files = array();
          foreach($zips as $zip){

            $dir = basename($zip);
            $doc = "";
            $url = "//app.com/".basename($zip);

            $files[] = array(
              "name"   => $dir,
              "path"   => $zip,
              "readme" => $doc,
              "url"    => $url
            );

          }
          $pluginList[] = array("name"=>$dirName,"files"=>$files);
        }
    }

    // Return the results
    return $pluginList;
}

$colors = array("purple","red","green","orange","dark-gray","blue","dark-blue","yellow","teal");
$plugins = loadPlugins($wpPlugins);
?>

<div class="alert alert-with-icon alert-secondary" style="margin:0px auto 20px auto;">
  <p class="lead" style="">
    <i class="fa fa-wordpress"></i>Loading Wordpress Plugins from: <code><?php echo $wpPlugins; ?></code>
  </p>
</div>


<?php $rowcount = 0; ?>
<?php foreach($plugins as $kp=>$plug): ?>
  <?php if($rowcount === 0): ?>
    <div class="row" style="margin-top:40px;">
  <?php endif; ?>
  <div class="col-lg-4 col-sm-6">
      <div class="circle-tile">
          <a href="#">
              <div class="circle-tile-heading <?php echo $colors[$kp]; ?>">
                  <i class="fa fa-users fa-fw fa-3x"></i>
              </div>
          </a>
          <div class="circle-tile-content <?php echo $colors[$kp]; ?>">
              <div class="circle-tile-description text-faded">
                  LINE ONE MSG
              </div>
              <div class="circle-tile-number text-faded">
                  <span style="text-transform:uppercase"><?php echo $plug["name"]; ?></span>
                  <span id="sparklineA"></span>
              </div>
              <a href="#" class="circle-tile-footer">More Info <i class="fa fa-chevron-circle-right"></i></a>
          </div>
          <div class="circle-tile-list-group">
            <div class="list-group list-group-flush">
              <?php foreach($plug["files"] as $key=>$file): ?>
                <a href="#" class="list-group-item list-group-item-action"><?php echo $file["name"]; ?></a>
              <?php endforeach; ?>
            </div>
          </div>
      </div>
  </div>
  <?php $rowcount++; ?>
  <?php if($rowcount === 3): ?>
    <?php $rowcount = 0; ?>
    </div>
  <?php endif; ?>
<?php endforeach; ?>


<div class="push"></div>
<div class="push"></div>
