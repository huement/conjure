<div class="sidebar" data-background-color="black" data-active-color="primary">

<!--
Tip 1: you can change the color of the sidebar's background using: data-background-color="white | black"
Tip 2: you can change the color of the active button using the data-active-color="primary | info | success | warning | danger"
-->

  <div class="sidebar-wrapper">

        <div class="logo cosmic_fusion">
            <img src="assets/img/ConjureLogo.png" class="logo_logo" />
            <a href="#" id="conjure_logo" class="simple-text">
                Conjure
            </a>
        </div>

        <ul class="nav nav-pills flex-column dashboard-list" id="v-pills-tab" role="tablist" aria-orientation="vertical">

            <li class="nav-item linked-page">
                <a class="nav-link" href="dashboard" id="dashboard-nav" aria-controls="v-pills-home" aria-selected="false">
                    <i class="fa fa-magic"></i>
                    <p>Dashboard</p>
                </a>
            </li>

            <li class="nav-item linked-page">
                <a class="nav-link" href="sys_info" id="sys_info-nav" aria-controls="v-pills-home" aria-selected="false">
                    <i class="fa fa-server"></i>
                    <p>System Info</p>
                </a>
            </li>

            <li class="nav-item collapse-item" id="wp_accordion">
              <a class="nav-link" href="#collapseWP" data-toggle="collapse" id="wp_main-nav" aria-controls="v-pills-reprep" aria-selected="false">
                  <i class="fa fa-plug"></i>
                  <p>Wordpress</p>
              </a>
              <ul class="nav flex-column sub-menu collapse hide" id="collapseWP">
                <li class="nav-item linked-page">
                  <a class="nav-link" href="wp_plugs" id="wp_plugs-nav" aria-controls="v-pills-reprep" aria-selected="false">
                      <i class="fa fa-plug"></i>
                      <p>Plugins</p>
                  </a>
                </li>

                <li class="nav-item linked-page">
                    <a class="nav-link" href="wp_funk" id="wp_funk-nav" aria-controls="v-pills-funk" aria-selected="false">
                        <i class="fa fa-asterisk"></i>
                        <p>Functions</p>
                    </a>
                </li>

                <li class="nav-item linked-page">
                    <a class="nav-link" href="docs_wp" id="docs_wp-nav" aria-controls="v-pills-docs" aria-selected="false">
                        <i class="fa fa-bookmark"></i>
                        <p>Knowledge</p>
                    </a>
                </li>

                <li class="nav-item linked-page">
                    <a class="nav-link" href="web_performance" id="web_performance-nav" aria-controls="v-pills-perf" aria-selected="false">
                        <i class="fa fa-cloud-download"></i>
                        <p>Performance</p>
                    </a>
                </li>
              </ul>
            </li>

            <li class="nav-item linked-page">
                <a class="nav-link" href="design" id="design-nav" aria-controls="v-pills-design" aria-selected="false">
                    <i class="fa fa-diamond"></i>
                    <p>Design Tools</p>
                </a>
            </li>

            <li class="nav-item linked-page">
                <a class="nav-link" href="unit_tests" id="unit_tests-nav" aria-controls="v-pills-unit-test" aria-selected="false">
                    <i class="fa fa-flag"></i>
                    <p>Unit Tests</p>
                </a>
            </li>

            <li class="nav-item linked-page">
                <a class="nav-link" href="docs_conjure" id="docs_conjure-nav" aria-controls="v-pills-docs" aria-selected="false">
                    <i class="fa fa-bookmark"></i>
                    <p>Documentation</p>
                </a>
            </li>

        </ul>

    </div>
</div>
