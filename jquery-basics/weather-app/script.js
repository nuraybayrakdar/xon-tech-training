$(document).ready(function() {
    $("#form-submit").submit(function(event){
         performSearch(event);
    });
 });
 
 function performSearch(event) {
     var request;
     event.preventDefault();
     
     request = $.ajax({
         url: 'https://api.openweathermap.org/data/2.5/weather',
         type: 'GET',
         data: {
             q: $('#city').val(),
             appid: 'cdef610d007b7e12b5355764ae3060f0',
             units: 'metric',
         },
     });
 
     request.done(function(response) {
         formatSearch(response);
     });
 
     request.fail(function(jqXHR, textStatus, errorThrown) {
         console.error('AJAX request failed:', textStatus, errorThrown);
     });
 }
 
 function formatSearch(jsonObject) {
     var city_name = jsonObject.name;
     var city_weather = jsonObject.weather[0].main;
     var city_temp = jsonObject.main.temp;
 
     $('#city-name').text(city_name);
     $('#city-weather').text(city_weather);
     $('#city-temp').text(city_temp + '°C');
 }
 