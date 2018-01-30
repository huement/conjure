<?php
  /**
   *  @brief A helper function for building out Jumbotrons
   *  @param string Title of the page (required)
   *  @param string Description (required)
   *  @param string Additional details (optional)
   */
?>

<?php if(isset($jumbo_title) && isset($jumbo_desc)): ?>
  <div class="jumbotron jumbo-sex outrun_red" style="padding:10px 20px 10px 20px;margin-top:-10px;">
    <div class="container-fluid">
      <h2 class="display-4" style="margin-top:10px;"><?php echo $jumbo_title; ?></h2>
      <p class="lead"><?php echo $jumbo_desc; ?></p>
      <?php if(isset($jumbo_details)): ?><p><?php echo $jumbo_details; ?></p><?php endif; ?>
    </div>
  </div>
<?php endif; ?>
