var failCount = 0;
function grabStats(){
  $.ajax({
    dataType:"json",
    url: "widgets/sys_stats.php",
    success: function(data){
      console.log(data);
      setTimeout("grabStats()",10000);
      cpuCalc(data.cpu);

      var memfree = data.mem_free * 100;
      memfree = memfree + '<small style="color:#FEFEFE">%</span>';
      var memtotal = data.mem_total * 1000;
      memtotal = memtotal + '<small style="color:#FEFEFE">MB</span>';
      $("#mem_free").text(memfree);
      $("#mem_total").text(memtotal);
      $("#hdd_used").text(data.hdd);
      $("#uptime").text(data.upt);
    },
    error: function (data){
      failCount++;
      console.log("system stats could not be fetched");
      if(failCount<5){ setTimeout("grabStats()",10000); }
    }
  });
}

function cpuCalc(arr){
  var total = $.parseInt(arr[0] + arr[1] + arr[2] / 3);
  $("#cpu_target").text(total);
}

// Docs at http://simpleweatherjs.com
$(document).ready(function() {
  var tempColor, tempClass = '';
  console.log("fetching weather");
  $.simpleWeather({
    woeid: '2402292', //2357536
    location: '',
    unit: 'f',
    success: function(weather) {
      console.log(weather);

      if(weather.temp > 70) {
        tempColor='#F7AC57';
        tempClass='icon-danger'
      } else {
        tempColor='#0091c2'
        tempClass='icon-info'
      }

      //var timestamp = moment(weather.updated);

      //$('body').animate({backgroundColor: tempColor}, 1500);

      $("#weather_icon_wrapper").addClass(tempClass);
      $("#weather_icon").addClass("icon-"+weather.code).addClass(tempClass);
      $("#weather_city").text(weather.city+', '+weather.region);
      $("#weather_color").attr("fill",tempColor);
      $("#weather_temp").text(weather.temp+"°");
      $("#weather_cond").text(weather.currently);
      //$("#weather").html(html);
    },
    error: function(error) {
      $("#weather").html('<p>'+error+'</p>');
    }
  });

  if($("#unitTestActivity").html() !== undefined){
    $.ajax({
      dataType:"html",
      url: "unit_tests/unit_test_results/index.html",
      success: function(data){
        var theTable = $(data).find("table.table-bordered");
        theTable.addClass("table-responsive table-striped table-sm");
        $("#unitTestActivity").html(theTable);
      },
      error: function (data){
        $("#unitTestActivity").html("<h3>Unit test error!</h3><p>You Unit Tests results could not be loaded.<br/>Please check your configured path or rerun your tests</p>");
      }
    });
  }

  setTimeout("grabStats()",500);
});
