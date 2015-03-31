<?php
/* ----------------------------------------------------------------
* Database Settings Below
* By default it is set to work on Localhost
*
* DB_HOST = Database Host
* DB_NAME = Database Name
* DB_USER = Database User
* DB_PASS = Database Password
*
* You should replace the fields appropriately
---------------------------------------------------------------- */
define("DB_HOST", "127.0.0.1");
define("DB_NAME", "lolstats");
define("DB_USER", "root");
define("DB_PASS", "");

/* ----------------------------------------------------------------
* Retreieve API Keys from the Database
* You have to manually add your api key to the database
* See the README.md for help
---------------------------------------------------------------- */
$dbKeys = new PDO('mysql:dbname=' . DB_NAME . ';host=' . DB_HOST . ';charset=utf8', DB_USER, DB_PASS);
$dbKeys->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$dbKeys->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$statementKeys = $dbKeys->prepare("SELECT COUNT(*) FROM apikeys");
$statementKeys->execute();
$resultKeys = $statementKeys->fetch();

$db = new PDO('mysql:dbname=' . DB_NAME . ';host=' . DB_HOST . ';charset=utf8', DB_USER, DB_PASS);

$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$statementKeys = $db->prepare("SELECT * FROM apikeys WHERE id = :id");
$statementKeys->execute(array(':id' => rand(1, $resultKeys[0])));
$result = $statementKeys->fetch();


/* ----------------------------------------------------------------
* Retreive Summoner Details
* See the README.md for help
---------------------------------------------------------------- */
// Request Summoner Name
$_GET['summoner'] = str_replace('_', '%20', $_GET['summoner']);
$requestSummoner = file_get_contents('https://' . $_GET['server'] . '.api.pvp.net/api/lol/' . $_GET['server'] . '/v1.4/summoner/by-name/' . $_GET['summoner'] . '?api_key=' . $result['key']);

// Request Summoner ID
$pos = 4 + strpos($requestSummoner, 'id');
$pos1 = strpos($requestSummoner, ',');
$id;

for($i = $pos; $i < $pos1; $i++) {
  $id .= $requestSummoner[$i];
}

// Request Summoner Ranks
$requestRank = file_get_contents('https://' . $_GET['server'] . '.api.pvp.net/api/lol/' . $_GET['server'] . '/v2.5/league/by-summoner/' . $id . '?api_key=' . $result['key']);

// Request Summoner Tier
$tierPos = 7 + strpos($requestRank, 'tier');
$tierPos1 = strpos($requestRank, 'queue') - 3;
$tier;

for($i = $tierPos; $i < $tierPos1; $i++) {
  $tier .= $requestRank[$i];
}

// Request Division
$divisionPos = 11 + strpos($requestRank, 'division');
$divisionPos1 = strpos($requestRank, 'leaguePoints') - 3;
$division;

for($i = $divisionPos; $i < $divisionPos1; $i++) {
  $division .= $requestRank[$i];
}

// Request League Points
$lpPos = 14 + strpos($requestRank, 'leaguePoints');
$lpPos1 = strpos($requestRank, 'wins') - 2;
$lp;

for($i = $lpPos; $i < $lpPos1; $i++) {
  $lp .= $requestRank[$i];
}

// Debugging
echo "<img src='Assets/Images/Ranks/" . $tier . "_" . $division . ".png'>";
echo $tier . " ";
echo $division . " ";
echo $lp . " LP";
?>
