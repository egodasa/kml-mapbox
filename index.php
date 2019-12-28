<?php
  if($_SERVER['REQUEST_METHOD'] == "POST")
  {
    unlink("data.kml");
    // masukkan file format baru ke folder template surat
    $nama_sementara = $_FILES['kml']['tmp_name'];
    move_uploaded_file($nama_sementara, "./data.kml");
  }
?>
<!DOCTYPE html>
<html>
<head>
<meta charset=utf-8 />
<title>KML Data</title>
<meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no' />
<script src='https://api.mapbox.com/mapbox.js/v3.2.1/mapbox.js'></script>
<link href='https://api.mapbox.com/mapbox.js/v3.2.1/mapbox.css' rel='stylesheet' />
<style>
  body { margin:0; padding:0; }
  #map { position:absolute; top:0; bottom:0; width:100%; }
</style>
</head>
<body>
<script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-omnivore/v0.2.0/leaflet-omnivore.min.js'></script>
<div id='map' style="width: 100%; height: 300px;"></div>
<div style="clear: both;"></div>
<form method="POST" style="margin-top: 300px;" enctype='multipart/form-data'>
  <label>Silahkan upload file .kml melalui form dibawah : </label><br>
  <input type="file" name="kml" /><br>
  <button type="submit">Upload</button>
</form>
<script>
L.mapbox.accessToken = 'pk.eyJ1IjoiZWdvZGFzYSIsImEiOiJjamd4NWkyMmwwNms2MnhsamJvaWQ3NGZmIn0.6ok1IiPZ0sPNXmiIe-iEWA';
var map = L.mapbox.map('map')
    .addLayer(L.mapbox.styleLayer('mapbox://styles/mapbox/streets-v11'));

// omnivore will AJAX-request this file behind the scenes and parse it:
// note that there are considerations:
// - The file must either be on the same domain as the page that requests it,
//   or both the server it is requested from and the user's browser must
//   support CORS.

// Internally this uses the toGeoJSON library to decode the KML file
// into GeoJSON

var loading = setInterval(function(){
  console.log("Tunggu sebentar...");
}, 1000);
var runLayer = omnivore.kml('data.kml')
    .on('ready', function() {
        map.fitBounds(runLayer.getBounds());
        clearInterval(loading);
        console.log("Peta barhasil diload...")
    })
    .addTo(map);
</script>
</body>
</html>
