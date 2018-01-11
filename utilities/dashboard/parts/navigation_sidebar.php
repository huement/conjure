<ul class="nav">
    <li class="active">
        <a href="dashboard.html">
            <i class="ti-panel"></i>
            <p>Dashboard</p>
        </a>
    </li>
    <li>
        <a href="user.html">
            <i class="ti-user"></i>
            <p>User Profile</p>
        </a>
    </li>
    <li>
        <a href="table.html">
            <i class="ti-view-list-alt"></i>
            <p>Table List</p>
        </a>
    </li>
    <li>
        <a href="typography.html">
            <i class="ti-text"></i>
            <p>Typography</p>
        </a>
    </li>
    <li>
        <a href="icons.html">
            <i class="ti-pencil-alt2"></i>
            <p>Icons</p>
        </a>
    </li>
    <li>
        <a href="maps.html">
            <i class="ti-map"></i>
            <p>Maps</p>
        </a>
    </li>
    <li>
        <a href="notifications.html">
            <i class="ti-bell"></i>
            <p>Notifications</p>
        </a>
    </li>
</ul>


<div class="feedback left">
  <div class="tooltips">
      <div class="btn-group dropup">
        <button type="button" class="btn btn-primary dropdown-toggle btn-circle btn-lg" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-bug fa-2x" title="Report Bug"></i>
        </button>
        <ul class="dropdown-menu dropdown-menu-right dropdown-menu-form">
          <li>
            <div class="report">
              <h2 class="text-center">Report Bug</h2>
              <form class="doo" method="post" action="report.php">
                <div class="col-sm-12">
                  <textarea required name="comment" class="form-control" placeholder="Please tell us what bug or issue you've found, provide as much detail as possible."></textarea>
                  <input name="screenshot" type="hidden" class="screen-uri">
                  <span class="screenshot pull-right"><i class="fa fa-camera cam" title="Take Screenshot"></i></span>
                 </div>
                 <div class="col-sm-12 clearfix">
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
               <div class="col-sm-12 clearfix">
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
          </li>
        </ul>
      </div>
  </div>
</div>
