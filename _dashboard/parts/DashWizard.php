<?php

/**
 *
 * PHP v7.1
 *
 * Created: 01/27/2018, 11:33 PM
 *
 * LICENSE:    MIT
 *
 * @author         Derek Scott <dscott@myriadmobile.com>
 * @copyright  (c) 2016 Myriad Mobile
 *
 * conjure_dash
 * PageBuildify
 *
 * @brief       Contains various functions for building out the Dashboard UI.
 *
 */

namespace conjure_dash;

use Dotenv\Dotenv;

class DashWizard {

  private $urlBase = "";
  private $stoageBase = "";
  private $storages = array();
  private $DBData = array();

	public function __construct() {}

  public function setupPaths($dir) {
     $dots = new Dotenv($dir);
     $dots->load();

     $item = array();
     $basePath = getenv('STORAGE_PATH');

     $item['wp'] = getenv('STORAGE_WP');
     $item['sb'] = getenv('STORAGE_SB');
     $item['gt'] = getenv('STORAGE_GT');
     $item['lf'] = getenv('STORAGE_LF');
     $item['ap'] = getenv('STORAGE_AP');

     foreach($item as $ik=>$iv){
       $this->setStorage($ik,$basePath.$iv);
     }

     $baseURL = getenv('APP_URL');
     $this->setBaseURL($baseURL);

     $un = getenv('DB_USERNAME');
     $pw = getenv('DB_PASSWORD');
     $this->setDBData($un,$pw);

     return true;
   }

   public function getStorage(){
     return $this->storages;
   }

   public function setStorage($key,$item){
     $this->storages[$key] = $item;
     return true;
   }

   public function getBaseURL(){
     return $this->urlBase;
   }

   public function setBaseURL($item){
     $this->urlBase = $item;
     return true;
   }

   public function getDBData(){
     return $this->DBData;
   }

   public function setDBData($user,$pass){
     $this->DBData = array("user"=>$user,"pass"=>$pass);
     return true;
   }

}

?>
