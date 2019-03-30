<?php
		require_once('./auth.php');
		require_once('./header.php');
		require_once('./login.php');

?>
<body>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="https://www.guinard-energies.bzh/fr/guinard-energies/" target=_blank >Guinard Energie</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="#">HOME</a></li>
      <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">STATIONS <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="#">Station1</a></li>
          <li><a href="#">Station2</a></li>
          <li><a href="#">Station3</a></li>
        </ul>
      </li>
      <li><a href="#">TEMPS RÉEL[SOON]</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a><span class="glyphicon glyphicon-user"></span> Connecter en tant que <?php echo $_SESSION['login']; ?></a></li>
      <li><a href="deconnexion.php"><span class="glyphicon glyphicon-log-in"></span> Déconnexion</a></li>
    </ul>
  </div>
</nav>


<?php
	$host="127.0.0.1";
	$username="Projet";
	$password="password";
	$db_name="Projet";

	try
	{
	$conn= new PDO("mysql:dbhost={$host};dbname={$db_name}",$username,$password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch(PDOException $ex)
	{
	die($ex->getMessage());
	}
	$stat=$conn->prepare("SELECT *from Mesures");
	$stat->execute();
	$json=[];
	$json2=[];
	$json3=[];
	while ($row=$stat->fetch(PDO::FETCH_ASSOC)) {
		extract($row);
		$json[]=$date;
		$json2[]=(int)$vitesse;
		$json3[]=(int)$temperature;
	}

?>

<table>
<tr>
<td style="width:50%">
<div>
<div style="width:100%">
<canvas id="myChart"></canvas>
</div>
<script>
var ctx = document.getElementById('myChart').getContext('2d');
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'line',

    // The data for our dataset
    data: {
        labels: <?php echo json_encode($json); ?>,
        datasets: [{
            label: "Vitesse en m/s",
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(255, 99, 132)',
            data: <?php echo json_encode($json2); ?>,
        }]
    },

    // Configuration options go here
    options: {}
});
</script>
</div>
</td>
<td style="width:50%">
<div>
<div style="width:100%">
<canvas id="myChart2"></canvas>
</div>
<script>
var ctx = document.getElementById('myChart2').getContext('2d');
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'line',

    // The data for our dataset
    data: {
        labels: <?php echo json_encode($json); ?>,
        datasets: [{
            label: "Température en °C",
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(255, 99, 132)',
            data: <?php echo json_encode($json3); ?>,
        }]
    },

    // Configuration options go here
    options: {
    
    
    }
});
</script>
</div>
</td>
</tr>
</table>

    <div id="map"></div>
 <script>
      var customLabel = {
        P66: {
          label: 'P66'
        }
      };

        function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: new google.maps.LatLng(48.4183217, -3.9683151,8),
          zoom: 8
        });
        var infoWindow = new google.maps.InfoWindow;

          // Change this depending on the name of your PHP or XML file
          downloadUrl('http://127.0.0.1/gen_xml.php', function(data) {
            var xml = data.responseXML;
            var markers = xml.documentElement.getElementsByTagName('marker');
            Array.prototype.forEach.call(markers, function(markerElem) {
              var name = markerElem.getAttribute('nom_station');
              var address = markerElem.getAttribute('address');
              var type = markerElem.getAttribute('type');
              var point = new google.maps.LatLng(
                  parseFloat(markerElem.getAttribute('lat')),
                  parseFloat(markerElem.getAttribute('lng')));

              var infowincontent = document.createElement('div');
              var strong = document.createElement('strong');
              strong.textContent = name
              infowincontent.appendChild(strong);
              infowincontent.appendChild(document.createElement('br'));

              var text = document.createElement('text');
              text.textContent = address
              infowincontent.appendChild(text);
              var icon = customLabel[type] || {};
              var marker = new google.maps.Marker({
                map: map,
                position: point,
                label: icon.label
              });
              marker.addListener('click', function() {
                infoWindow.setContent(infowincontent);
                infoWindow.open(map, marker);
              });
            });
          });
        }



      function downloadUrl(url, callback) {
        var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;

        request.onreadystatechange = function() {
          if (request.readyState == 4) {
            request.onreadystatechange = doNothing;
            callback(request, request.status);
          }
        };

        request.open('GET', url, true);
        request.send(null);
      }

      function doNothing() {}

    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDaQg3tHEG1UzW-fG1tte6G-xdUeI1ukR0&callback=initMap">
    </script>
</body>
</html>
