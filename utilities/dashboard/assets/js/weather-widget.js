// Docs at http://simpleweatherjs.com

var tempColor = '';

$(document).ready(function() {
  $.simpleWeather({
    woeid: '2357536', //2357536
    location: '',
    unit: 'f',
    success: function(weather) {

      if(weather.temp > 75) {
        tempColor='#F7AC57'
      } else {
        tempColor='#0091c2'
      }

      $('body').animate({backgroundColor: tempColor}, 1500);

      html =  '<div class="col-xs-5">';
      html += '  <h2 class="stat-amount icon-'+weather.code+'"></h2><h2>'+weather.temp+'&deg;</h2>';
      html += '  <svg width="120" height="100">';
      html += '    <rect width="120" height="100" stroke-width="0" fill="'+tempColor+'" />';
      html += '  </svg>';
      html += '</div>';

      html += '<div class="col-xs-7">';
      html += '  <div class="numbers">';
      html += '      <span class="icon stat-icon icon-warning text-center">';
      html += '          <i class="ti-receipt" style="color:'+tempColor+'"></i>';
      html += '      </span>';
      html += '      <p>'+weather.currently+'</p><p class="stats"><a href="#">'+weather.city+', '+weather.region+'</a></p>';
      html += '  </div>';
      html += '</div>';


      var timestamp = moment(weather.updated);
      html += '<p class="updated">Updated '+moment(timestamp).fromNow()+'</p>';

      $("#weather").html(html);
    },
    error: function(error) {
      $("#weather").html('<p>'+error+'</p>');
    }
  });
});
