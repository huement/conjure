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
});
