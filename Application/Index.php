<?php
// Something will be here, eventually
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
        var summonerResults = xmlhttp.responseText;

        document.getElementById("summonerNameInput").innerHTML = summonerName_split;
        document.getElementById("summonerResults").innerHTML = summonerResults;
      }
    }
    xmlhttp.open("GET", "classes/Search.php?summoner=" + summonerName + "&server=" + summonerServer, true);
    xmlhttp.send();
  }
  </script>
  <select id="summonerServerInput">
   <option value="na">North America</option>
   <option value="euw">Europe West</option>
   <option value="eune">Europe North and East</option>
   <option value="oce">Oceania</option>
   <option value="lan">Latin America North</option>
   <option value="las">Latin America South</option>
   <option value="br">Brazil</option>
   <option value="tr">Turkey</option>
  </select>
  <label id="summonerResults"></label>
  <textarea id="summonerNameInput"></textarea>
  <button id="summonerTrigger" onclick="getInformation()">Search</button>
 </body>
</html>
