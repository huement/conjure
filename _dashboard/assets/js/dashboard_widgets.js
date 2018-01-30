/**
 * Main Homepage for the Dashboard has a number of widgets.
 * This file contains the JS functionality for those widgets.
 */

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

function weatherReport(){
  var tempColor, tempClass = '';
  //console.log("fetching weather");
  $.simpleWeather({
    woeid: '2402292', //2357536
    location: '',
    unit: 'f',
    success: function(weather) {
      //console.log(weather);

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
}

function systemReport(){

  var systemStatURL = $.trim($("#systemStatURL").text());
  console.log(systemStatURL);

  $.ajax({
    url: systemStatURL,
    dataType:"json",
    success: function(data){
      //console.log(data);
      var vd = data.Vitals;
      $.each(vd,function(name,value){
        console.log(value);
        $("#Hostname").text(value["Hostname"]);
        $("#IPAddr").text(value["IPAddr"]);
        $("#Kernel").text(value["Kernel"]);
        $("#Distro").text(value["Distro"]);
        $("#Uptime").text(value["Uptime"]);
        $("#LastBoot").text(value["LastBoot"]);
        $("#LoadAvg").text(value["LoadAvg"]);
        $("#Processes").text(value["Processes"]);
        $("#SysLang").text(value["SysLang"]);
      });
      //
    },
    error: function (data){
      console.log("Report Error!");
      console.log(data);
    }
  });
}

function unitTestReport(){
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

function statGraph(){
  var labels = ['January','February','March','April','May','June','July'];
  var data = {
    labels: labels,
    datasets: [
      {
        label: 'My First dataset',
        backgroundColor: $.brandPrimary,
        borderColor: 'rgba(255,255,255,.55)',
        data: [65, 59, 84, 84, 51, 55, 40]
      },
    ]
  };
  var options = {
    maintainAspectRatio: false,
    legend: {
      display: false
    },
    scales: {
      xAxes: [{
        gridLines: {
          color: 'transparent',
          zeroLineColor: 'transparent'
        },
        ticks: {
          fontSize: 2,
          fontColor: 'transparent',
        }

      }],
      yAxes: [{
        display: false,
        ticks: {
          display: false,
          min: Math.min.apply(Math, data.datasets[0].data) - 5,
          max: Math.max.apply(Math, data.datasets[0].data) + 5,
        }
      }],
    },
    elements: {
      line: {
        borderWidth: 1
      },
      point: {
        radius: 4,
        hitRadius: 10,
        hoverRadius: 4,
      },
    }
  };
  var ctx = $('#card-chart1');
  var cardChart1 = new Chart(ctx, {
    type: 'line',
    data: data,
    options: options
  });

  var data = {
    labels: labels,
    datasets: [
      {
        label: 'My First dataset',
        backgroundColor: $.brandInfo,
        borderColor: 'rgba(255,255,255,.55)',
        data: [1, 18, 9, 17, 34, 22, 11]
      },
    ]
  };
  var options = {
    maintainAspectRatio: false,
    legend: {
      display: false
    },
    scales: {
      xAxes: [{
        gridLines: {
          color: 'transparent',
          zeroLineColor: 'transparent'
        },
        ticks: {
          fontSize: 2,
          fontColor: 'transparent',
        }

      }],
      yAxes: [{
        display: false,
        ticks: {
          display: false,
          min: Math.min.apply(Math, data.datasets[0].data) - 5,
          max: Math.max.apply(Math, data.datasets[0].data) + 5,
        }
      }],
    },
    elements: {
      line: {
        tension: 0.00001,
        borderWidth: 1
      },
      point: {
        radius: 4,
        hitRadius: 10,
        hoverRadius: 4,
      },
    }
  };

  // $.fn.peity.defaults.bar = {
  //   delimiter: ",",
  //   fill: "#31b0d5"
  // }

  //var updatingChart = $(".line").peity("bar")

  // setInterval(function() {
  //   var random = Math.round(Math.random() * 10)
  //   var values = updatingChart.text().split(",")
  //   values.shift()
  //   values.push(random)
  //
  //   updatingChart
  //     .text(values.join(","))
  //     .change()
  // }, 1000);

}

// Docs at http://simpleweatherjs.com
$(document).ready(function() {

  weatherReport();

  systemReport();

  if($("#unitTestActivity").html() !== undefined){
    unitTestReport();
  }

  grabStats();

  if( $(".site-list-item").length > 0 ){
    $.each($(".site-list-item"), function(index){
        var the_slug = $(this).data("slug");
        if(the_slug !== undefined){
          stylestatus(the_slug);
        } else {
          console.log("WP Site w/o a slug error");
        }
    });
  }

  if( $("#card-chart1").html() !== undefined && $("#card-chart1").html().length > 10 ){
    console.log("statGraph");
    statGraph();
  }

  $('.dtopclose').on('click',function(){
    $('.dtopalert').alert('close');
  });

});
