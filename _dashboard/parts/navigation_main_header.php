<!-- <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#" id="dynpagename">LOADING...</a>
  <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarSupportedContent">
      <span class="sr-only">Toggle navigation</span>
      <span class="fa fa-star"></span>
  </button>

  <div class="navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
          <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                      <p class="notification"><i class="ti-plus"></i></p>
                      <p>ADD SITE</p>
                      <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                  <li class="dropdown-item"><a href="#">Wordpress</a></li>
                  <li class="dropdown-item"><a href="#">Wordplate</a></li>
                  <li class="dropdown-item"><a href="#">Bedrock  </a></li>
                  <li class="dropdown-item"><a href="#">Webpress </a></li>
                  <li class="dropdown-item"><a href="#">WP_Cubi  </a></li>
                </ul>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="#">
                <i class="ti-settings"></i>
                <p>Settings</p>
              </a>
          </li>
      </ul>
  </div>
</nav> -->

<!-- <div class="container-fluid">
  <div class="row">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary rounded">
      <a class="navbar-brand" href="#">Navbar</a>
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link">Left Link 1</a>
        </li>
        <li class="nav-item">
          <a class="nav-link">Left Link 2</a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link">Right Link 1</a>
        </li>
        <li class="navbar-item">
          <a class="nav-link">Right Link 2</a>
        </li>
      </ul>
    </nav>
  </div>
</div> -->

<nav class="navbar navbar-toggleable-md navbar-purple bg-purple">

  <button class="hamburger hamburger--squeezenavbar-toggler navbar-toggler-right" type="button" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
    <span class="hamburger-box">
      <span class="hamburger-inner"></span>
    </span>
  </button>

  <div class="collapse navbar-collapse" id="navbarsExampleDefault">
    <div class="navbar-nav mr-auto"></div>

    <ul class="navbar-nav ml-auto conjure-navbar">

      <li class="nav-item">&nbsp;&nbsp;&nbsp;</li>

      <!-- SITE LINKS -->
      <li class="nav-item dropdown nav-linkage dropdown-slide dropdown-hover">

          <button type="button" class="nav-link dropdown-toggle btn-dark" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            &nbsp;<i class="fa fa-clipboard fa-lg" title="Utility Links"></i>&nbsp;&nbsp;UTILITIES
          </button>

          <ul class="dropdown-menu dropdown-menu-right dropdown-menu-links">
            <li class="dropdown-item">
              <a name="phpMyAdmin" href="https://magic.app/apps/database-admin/">
              phpMyAdmin <i class="fa fa-external-link-square"></i>
              </a>
            </li>
            <li class="dropdown-item">
                <a name="phpMemcachedAdmin" href="https://magic.app/apps/memcached-admin/">
                phpMemcachedAdmin <i class="fa fa-cubes"></i>
                </a>
            </li>
            <li class="dropdown-item">
                <a name="Opcache Status" href="https://magic.app/apps/opcache-status/opcache.php">
                Opcache Status <i class="fa fa-pie-chart"></i>
                </a>
            </li>
            <li class="dropdown-item">
                <a name="Webgrind" href="https://magic.app/apps/webgrind/">
                Webgrind <i class="fa fa-cog"></i>
                </a>
            </li>
            <li class="dropdown-item">
                <a name="PHP Info" href="https://magic.app/apps/phpinfo/">
                PHP <i class="fa fa-info-circle"></i>
                </a>
            </li>
            <li class="dropdown-item">
                <a name="Mailcatcher" href="http://magic.app:1080/">
                Mailcatcher <i class="fa fa-external-link-square"></i>
                </a>
            </li>
            <li class="dropdown-item">
                <a name="Help" href="javascript:void(0);" onclick="javascript:introJs().start();">
                Help <i class="fa fa-question-circle"></i>
                </a>
            </li>
          </ul>

      </li>

      <li class="nav-item">
        <a href="#" id="terminal_toogle" class="nav-link btn-dark">&nbsp;<i class="fa fa-tasks fa-lg" title="Utility Links"></i>&nbsp;&nbsp;TERMINAL</a>
      </li>

      <!-- FEEDBACK MODAL -->
      <li class="nav-item dropdown nav-right-first">
        <button type="button" class="nav-link dropdown-toggle btn-dark" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          &nbsp;<i class="fa fa-bug fa-lg" title="Report Bug"></i>&nbsp;&nbsp;BUG
        </button>
        <ul class="dropdown-menu dropdown-menu-right dropdown-menu-form">
          <li class="dropdown-item">
            <div class="feedback">
              <div class="report">
                <h4 class="dropdown-header" style="margin-top:0px;">Report Bug</h4>
                <form class="doo" method="post" action="report.php">
                  <div class="col-sm-12">
                    <textarea required id="bug_txt" name="comment" class="form-control" placeholder="Please tell us what bug or issue you've found, provide as much detail as possible."></textarea>
                    <input name="screenshot" type="hidden" class="screen-uri">
                    <span class="screenshot pull-right"><i class="fa fa-camera cam" title="Take Screenshot"></i></span>
                   </div>
                   <div class="col-sm-12 clearfix" style="padding:0px;">
                    <button class="btn btn-primary btn-block">Submit Report</button>
                   </div>
               </form>
              </div>
              <div class="loading text-center hideme">
                <h2>Please wait...</h2>
                <h2><i class="fa fa-refresh fa-spin"></i></h2>
              </div>
              <div class="reported text-center hideme">
                <h2>Thank you!</h2>
                <p>Your submission has been received, we will review it shortly.</p>
                 <div class="col-sm-12 clearfix" style="padding:0px;">
                    <button class="btn btn-success btn-block do-close">Close</button>
                 </div>
              </div>
              <div class="failed text-center hideme">
                <h2>Oh no!</h2>
                <p>It looks like your submission was not sent.<br><br><a href="mailto:">Try contacting us by the old method.</a></p>
                 <div class="col-sm-12 clearfix">
                    <button class="btn btn-danger btn-block do-close">Close</button>
                 </div>
              </div>
            </div>
          </li>
        </ul>
      </li>

    </ul>
  </div>
</nav>
