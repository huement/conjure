<?php
/**
 * @brief    Wordpress Functions
 * @details  Helpful Development Functions for Themes, Plugins, Widgets, etc.
 */

$SpellBook = "/home/vagrant/";
$files1 = scandir($SpellBook);

// echo "<pre>
// <code>";
print_r($files1);
// echo "</code>
// </pre>";

$funky_cat = array();
$funky_cat[] = array(
  "name"=>"Example",
  "desc"=>"Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident.",
  "plug"=>array("one","two","three")
);

?>

<div class="push"></div>

<div class="jumbotron" style="padding:10px 20px 10px 20px;margin-top:-10px;">
  <div class="container-fluid">
    <h2 class="display-4" style="margin-top:10px;">Wordpress Functions</h2>
    <p>This is a collection and loading dock for a number of Wordpress enhancements. These plugins cover the entire lifecycle of a project.</p>
    <p>
      Starting with design and mockup helpers, all the way to high traffic performance testing, such ass critical CSS flows and lazy loading images.
    </p>
  </div>
</div>


<div id="accordion" role="tablist" aria-multiselectable="true">

  <?php foreach($funky_cat as $fc): ?>
    <div class="accordion_card">
      <div class="accordion_card-header" role="tab" id="headingOne">
        <div class="mb-0">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" class="collapsed">
            <i class="fa fa-file-text-o" aria-hidden="true"></i>
              <h3><?=$fc["name"]; ?></h3>
              <p><?=$fc["desc"]; ?></p>
          </a>
          <i class="fa fa-angle-right" aria-hidden="true"></i>
        </div>
      </div>

      <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne" aria-expanded="false" style="">
        <div class="accordion_card-block">
          <div class="row">


          <?php foreach($fc["plug"] as $plugin): ?>
            <div class="col-6">
              <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
              </p>
            </div>
          <?php endforeach; ?>

          </div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>

</div>
