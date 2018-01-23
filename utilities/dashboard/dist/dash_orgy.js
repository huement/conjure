/*! PressCraft-Dashboard - v1.0.0 - 2018-01-23
* https://bitbucket.org/derekscott_mm/PressCraft-Dashboard
* Copyright (c) 2018 Derek Scott; Licensed MIT */
/*!

 =========================================================
 * Paper Dashboard - v1.1.2
 =========================================================

 * Product Page: http://www.creative-tim.com/product/paper-dashboard
 * Copyright 2017 Creative Tim (http://www.creative-tim.com)
 * Licensed under MIT (https://github.com/creativetimofficial/paper-dashboard/blob/master/LICENSE.md)

 =========================================================

 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

 */


var fixedTop = false;
var transparent = true;
var navbar_initialized = false;

$(document).ready(function(){
    window_width = $(window).width();

    // Init navigation toggle for small screens
    if(window_width <= 991){
        pd.initRightMenu();
    }

    //  Activate the tooltips
    //  $('[rel="tooltip"]').tooltip();

});

// activate collapse right menu when the windows is resized
$(window).resize(function(){
    if($(window).width() <= 991){
        pd.initRightMenu();
    }
});

pd = {
    misc:{
        navbar_menu_visible: 0
    },
    checkScrollForTransparentNavbar: debounce(function() {
        if($(document).scrollTop() > 381 ) {
            if(transparent) {
                transparent = false;
                $('.navbar-color-on-scroll').removeClass('navbar-transparent');
                $('.navbar-title').removeClass('hidden');
            }
        } else {
            if( !transparent ) {
                transparent = true;
                $('.navbar-color-on-scroll').addClass('navbar-transparent');
                $('.navbar-title').addClass('hidden');
            }
        }
    }),
    initRightMenu: function(){
         if(!navbar_initialized){
            $off_canvas_sidebar = $('nav').find('.navbar-collapse').first().clone(true);

            $sidebar = $('.sidebar');
            sidebar_bg_color = $sidebar.data('background-color');
            sidebar_active_color = $sidebar.data('active-color');

            $logo = $sidebar.find('.logo').first();
            logo_content = $logo[0].outerHTML;

            ul_content = '';

            // set the bg color and active color from the default sidebar to the off canvas sidebar;
            $off_canvas_sidebar.attr('data-background-color',sidebar_bg_color);
            $off_canvas_sidebar.attr('data-active-color',sidebar_active_color);

            $off_canvas_sidebar.addClass('off-canvas-sidebar');

            //add the content from the regular header to the right menu
            $off_canvas_sidebar.children('ul').each(function(){
                content_buff = $(this).html();
                ul_content = ul_content + content_buff;
            });

            // add the content from the sidebar to the right menu
            content_buff = $sidebar.find('.nav').html();
            ul_content = ul_content + '<li class="divider"></li>'+ content_buff;

            ul_content = '<ul class="nav navbar-nav">' + ul_content + '</ul>';

            navbar_content = logo_content + ul_content;
            navbar_content = '<div class="sidebar-wrapper">' + navbar_content + '</div>';

            $off_canvas_sidebar.html(navbar_content);

            $('body').append($off_canvas_sidebar);

             $toggle = $('.navbar-toggle');

             $off_canvas_sidebar.find('a').removeClass('btn btn-round btn-default');
             $off_canvas_sidebar.find('button').removeClass('btn-round btn-fill btn-info btn-primary btn-success btn-danger btn-warning btn-neutral');
             $off_canvas_sidebar.find('button').addClass('btn-simple btn-block');

             $toggle.click(function (){
                if(pd.misc.navbar_menu_visible == 1) {
                    $('html').removeClass('nav-open');
                    pd.misc.navbar_menu_visible = 0;
                    $('#bodyClick').remove();
                     setTimeout(function(){
                        $toggle.removeClass('toggled');
                     }, 400);

                } else {
                    setTimeout(function(){
                        $toggle.addClass('toggled');
                    }, 430);

                    div = '<div id="bodyClick"></div>';
                    $(div).appendTo("body").click(function() {
                        $('html').removeClass('nav-open');
                        pd.misc.navbar_menu_visible = 0;
                        $('#bodyClick').remove();
                         setTimeout(function(){
                            $toggle.removeClass('toggled');
                         }, 400);
                    });

                    $('html').addClass('nav-open');
                    pd.misc.navbar_menu_visible = 1;

                }
            });
            navbar_initialized = true;
        }

    }
}


// Returns a function, that, as long as it continues to be invoked, will not
// be triggered. The function will be called after it stops being called for
// N milliseconds. If `immediate` is passed, trigger the function on the
// leading edge, instead of the trailing.

function debounce(func, wait, immediate) {
	var timeout;
	return function() {
		var context = this, args = arguments;
		clearTimeout(timeout);
		timeout = setTimeout(function() {
			timeout = null;
			if (!immediate) func.apply(context, args);
		}, wait);
		if (immediate && !timeout) func.apply(context, args);
	};
};

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

  if( $("#card-chart1").html() !== undefined && $("#card-chart1").html().length > 10 ){
    console.log("statGraph");
    statGraph();
  }

  $('.dtopclose').on('click',function(){
    $('.dtopalert').alert('close');
  });

});
