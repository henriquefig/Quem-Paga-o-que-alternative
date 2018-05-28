$(document).ready(function() {
  $.simpleWeather({
    location: 'Porto, PT',
    woeid: '',
    unit: 'c',
    success: function(weather) {
      console.log(weather);
      html = weather.text+"  <img align=\"center\" src=\""+weather.thumbnail+"\"  width=\"30\" height=\"20\"/>"+weather.temp+'&deg;'+weather.units.temp;
  
      $("#weather").html(html);
    },
    error: function(error) {
      $("#weather").html('<p>'+error+'</p>');
    }
  });
});