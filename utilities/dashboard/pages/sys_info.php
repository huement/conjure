<?php
/*
Version 1.3
Copyright 2012-2016 - Amaury Balmer (amaury@beapi.fr)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

require_once("parts/SysInfo.php");
require_once("parts/SysHosts.php");

use conjure_dash\SysInfo;

function phpwpinfo() {
	$info = new SysInfo();
	$info->init_all_tests();
}
?>

<div class="push"></div>

<div class="jumbotron" style="padding:10px 20px 10px 20px;margin-top:-10px;">
  <div class="container-fluid">
    <h2 class="display-4" style="margin-top:10px;">System Info</h2>
    <p>Quick summary of the current development environment and how that plays with <strong>Wordpress</strong></p>
  </div>
</div>

<?php
// Init render
phpwpinfo();
?>
