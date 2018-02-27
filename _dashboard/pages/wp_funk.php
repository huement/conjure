<?php
/**
 * @brief    Wordpress Functions
 * @details  Helpful Development Functions for Themes, Plugins, Widgets, etc.
 */

ini_set('memory_limit','256M');

$Parsedown = new Parsedown();

$APP_URL   = getenv('APP_URL');
$sitePATH  = getenv('STORAGE_PATH');
$SpellBook = getenv('STORAGE_SB');
$FPath     = $sitePATH.$SpellBook."/DOCS";

function SetupFunctionDocs($FunkPath){
  $pages = array();
  $funky_cat = array();
  $Parsedown = new ParsedownExtra();
  $fixcats = array();
  
  $indexFiles = array_filter(glob($FunkPath."*"), 'is_dir');
  $categories = array_filter(glob($FunkPath."**/*"), 'is_dir');
  
  foreach( $categories as $category ) {
    $cat = basename($category);
    if(stripos($category, "_assets") < 1){
      
      $pages[$cat] = array_filter(glob($category."/*"), 'is_file');
      $allPages = array();
      $fixcats[] = basename($category);
    
      
      
      foreach( $pages[$cat] as $key => $file ) {
         $fileParts = pathinfo($file);
         if($fileParts['extension'] === "md" || $fileParts['extension'] === "html"){
           $filetext = file_get_contents($file);
           $lines = array_filter(preg_split('/\r\n|\r|\n/', $filetext));
           $cleanh1 = trim(preg_replace("/[^A-Za-z0-9 ]/", ' ', $lines[0]));
           
           array_shift($lines); 

           $cleantxt = preg_replace("/[^A-Za-z0-9 ]/", ' ', implode(" ",$lines) );
           $snippet = substr($cleantxt,0,150)."...";

           $allPages[] = array(
             "name"=>$cleanh1,
             "category"=>$key,
             "desc"=>$filetext,
             "snippet"=>$snippet,
             "fileName"=>$fileParts["basename"],
             "filePath"=>$file,
             "fileLink"=> "<a href='" . $FunkPath . $key . "/" . $fileParts["basename"] . "' class='funkfile'>" . $fileParts["filename"] . "</a>"
           );
         }
        
        $funky_cat[$cat] = $allPages; 
      }
    
      
    }
  }

  return array("topics"=>$funky_cat, "pages"=>$pages, "categories"=>$fixcats);
}


$funkyData = SetupFunctionDocs($FPath);

?>

<?php
  /* JUMBOTRON */
  $wpfunk_title   = "Wordpress Functions";
  $wpfunk_details = "This is a collection and loading dock for a number of Wordpress enhancements. These plugins cover the entire lifecycle of a project.";
  $wpfunk_desc    = "Starting with design and mockup helpers, all the way to high traffic performance testing, such ass critical CSS flows and lazy loading images.";
  $wpfunk_theme   = "ibiza_sun";
  $JumboHTML      = $buildify->jumbotron( $wpfunk_title, $wpfunk_desc, $wpfunk_details, $wpfunk_theme );
?>
  <div class="alert alert-with-icon alert-secondary" style="margin:0px auto 20px auto;">
    <p class="lead" style="">
      <i class="fab fa-wordpress"></i> Wordpress Function Docs: <code><?php echo $FPath; ?></code>
    </p>
  </div>
  
<div class="row" style="padding-top:6px;">
  
  
  
  <?php foreach($funkyData["pages"] as $fkey=>$fp): ?>
    <div class="col-12 col-md-6 col-lg-4">
      <div class="card-light">
        <div class="card-header primary-color white-text">
            <p class="category pull-right"><?php echo $fkey; ?></p>
            <h4 class="title"><?php echo $fkey; ?></h4>
        </div>
        <div class="content" style="padding:0px;">     
          <div class="list-group-padding" style="padding:20px;">
            <div class="list-group">
              <?php foreach($funkyData["topics"] as $key=>$pageDataArray): ?>
                <?php if($key == $fkey): ?>
                  <?php $listCount = 1; ?>
                  <?php foreach($pageDataArray as $epageData): ?>
                    <div class="list-group-item">
                      <h4 style="margin-top:5px;padding;0;"><?php echo "<small><strong>" . $listCount . "|</strong></small>&nbsp;" . $epageData["name"]; ?></h4>
                      <p style="width:100%;clear:both;display:block;padding-bottom:0;margin-bottom:0;"><?php echo $epageData["snippet"]; ?></p>
                    </div>
                    <?php $listCount++; ?>
                  <?php endforeach; ?>
                <?php endif; ?>
              <?php endforeach; ?>
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
  <?php endforeach; ?>

</div>
