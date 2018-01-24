<script type="text/javascript">
  $.getJSON("//freegeoip.net/json/?callback=?", function(data) {
    $(".realip td:last").html(data.ip);
  });
</script>
