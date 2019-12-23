<div id="map"></div>
  <script>
    function initMap() {

      var options = {
        zoom: 10,
        center: {
          lat: 49.640988,
          lng: 20.920947
        }
      }

      // New map
      var map = new google.maps.Map(document.getElementById('map'), options);


      google.maps.event.addListener(map, 'click', function (event) {

        addMarker({
          coords: event.latLng
        });
      });


      var markers = [{
          coords: {
            lat: 49.640988,
            lng: 20.920947
          },
         

          iconImage: 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png',
          content:  '<a href="https://tiny.pl/t9pj2" target="_blank" rel="noopener noreferrer"><h3 class="text-dark">Siołkowa 455</h3></a>'
        },
      ];
     

      for (var i = 0; i < markers.length; i++) {

        addMarker(markers[i]);
      }


      function addMarker(props) {
        var marker = new google.maps.Marker({
          position: props.coords,
          map: map,

        });


        if (props.iconImage) {

          marker.setIcon(props.iconImage);
        }

        // Check content
        if (props.content) {
          var infoWindow = new google.maps.InfoWindow({
            content: props.content
          });

          marker.addListener('click', function () {
            infoWindow.open(map, marker);
          });
        }
      }
    }
  </script>
  <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCVUpAMdupBo3cNPVaZLiVJaRdUpIYjYLw&callback=initMap">
  </script>
