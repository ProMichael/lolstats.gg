<?php
// Something will be here
?>
<!DOCTYPE html>
<html>
 <head>
  <title>Home | LoLStats.gg</title>
  <meta charset="utf-8">
 </head>
 <body>
  <script type="text/javascript">
  function getInformation() {
    var summonerName = document.getElementById('summonerNameInput').value;
    var summonerServer = document.getElementById('summonerServerInput').value;

    summonerName = summonerName.split(' ').join('_');

    if(window.XMLHttpRequest) {
      xmlhttp = new XMLHttpRequest();
    } else {
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange=function() {
      if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        var summonerName_split = xmlhttp.responseText;
        var summonerServer_split = xmlhttp.responseText;

        document.getElementById("summonerServerInput").innerHTML = summonerServer_split;
        document.getElementById("summonerNameLabel").innerHTML = summonerName_split;
      }
    }
    xmlhttp.open("GET", "classes/Search.php?summoner=" + summonerName + "&server=" + summonerServer, true);
    xmlhttp.send();
  }
  </script>
 </body>
</html>
