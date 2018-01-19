/*! PressCraft-Dashboard - v1.0.0 - 2018-01-19
* https://bitbucket.org/derekscott_mm/PressCraft-Dashboard
* Copyright (c) 2018 Derek Scott; Licensed MIT */
var failCount = 0;
function grabStats(){
  $.ajax({
    dataType:"json",
    url: "widgets/sys_stats.php",
    success: function(data){
      console.log(data);
      setTimeout("grabStats()",10000);
      cpuCalc(data.cpu);

      var memfree = parseInt(data.mem_free * 100).toFixed(0);
      var memfr = memfree + '<small style="color:#FEFEFE">%</span>';
      var memtotal = parseInt(data.mem_total * 1000).toFixed(0);
      var memtot = memtotal + ' <small>GB</span>';
      $("#mem_free").html(memfr);
      $("#mem_total").html(memtot);
      $("#hdd_used").html(data.hdd+ '<small style="color:#FEFEFE">%</span>');
      $("#uptime").html(data.upt);
    },
    error: function (data){
      failCount++;
      console.log("system stats could not be fetched");
      if(failCount<5){ setTimeout("grabStats()",10000); }
    }
  });
}

function cpuCalc(arr){
  var avgCPU = arr[0] + arr[1] + arr[2];
  var percentCPU = (avgCPU/3) * 100;
  console.log(avgCPU);
  // console.log(percentCPU);
  var total = parseFloat(percentCPU).toFixed(0);
  $("#cpu_target").html(total+'<small style="color:#FEFEFE">%</span>');
}

function stylestatus(site_slug){

  var statURL = "data/stylestats_"+site_slug+".json";

  $.ajax({
    dataType:"json",
    url: statURL,
    success: function(data){
      console.log(data);

    },
    error: function (data){
      console.log("Need StyleStats for that Slug!");
    }
  });

}

function statGraph(){

  $.fn.peity.defaults.line = {
    delimiter: ",",
    fill: "#94C859",
    height: 90,
    max: null,
    min: 0,
    stroke: "#3f3f3f",
    strokeWidth: 1,
    width: 200
  }


  var updatingChart = $(".line").peity("line", { width: 220 })

  setInterval(function() {
    var random = Math.round(Math.random() * 10)
    var values = updatingChart.text().split(",")
    values.shift()
    values.push(random)

    updatingChart
      .text(values.join(","))
      .change()
  }, 1000);

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

      $("#weather_icon_wrapper").addClass(tempClass);
      $("#weather_icon").addClass("icon-"+weather.code).addClass(tempClass);
      $("#weather_city").text(weather.city+', '+weather.region);
      $("#weather_color").css("backgroundColor",tempColor);
      $("#weather_temp").html(weather.temp+'<sup><small style="color:#FEFEFE">°F</small></sup>');
      $("#weather_cond").text(weather.currently);
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

  if( $(".site-list-item").length > 0 ){
    $.each($(".site-list-item"), function(index){
        var the_slug = $(this).data("slug");
        stylestatus(the_slug);
    });
  }

  statGraph();

});
