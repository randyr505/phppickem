<?php
require('includes/application_top.php');

error_reporting(E_ALL);
$weeks = 17;
$schedule = array();
$teamCodes = array( 'LA' => 'LAR', 'SD' => 'LAC', 'SDC' => 'LAC');

for ($week = 1; $week <= $weeks; $week++) {
	$url = "http://www.nfl.com/ajax/scorestrip?season=".SEASON_YEAR."&seasonType=REG&week=".$week;
	if ($xmlData = @file_get_contents($url)) {
		$xml = simplexml_load_string($xmlData);
		$json = json_encode($xml);
		$games = json_decode($json, true);
	} else {
		die('Error getting schedule from nfl.com.');
	}

	//build scores array, to group teams and scores together in games
	foreach ($games['gms']['g'] as $gameArray) {
		$game = $gameArray['@attributes'];

		//get game time (eastern)
		$eid = $game['eid']; //date
		$t = $game['t']; //time
		$date = DateTime::createFromFormat('Ymds g:i a', $eid.' '.$t.' pm');
		$gameTimeEastern = $date->format('Y-m-d H:i:00');

		//get team codes
		$away_team = $game['v'];
		$home_team = $game['h'];

		foreach ($teamCodes as $oldCode => $nflpCode) {
			if ($away_team == $oldCode) $away_team = $nflpCode;
			if ($home_team == $oldCode) $home_team = $nflpCode;
		}

		$schedule[] = array(
			'weekNum' => $week,
			'gameTimeEastern' => $gameTimeEastern,
			'homeID' => $home_team,
			'visitorID' => $away_team
		);
	}
}

//output to sql
$sched = DB_PREFIX."_schedule";

$outputsql = 'SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";'."\n".
'USE '.DB_NAME."\n".
'SET time_zone = "+00:00";'."\n".
'CREATE TABLE IF NOT EXISTS `nflp_schedule` ('."\n".
  '`gameID` int(11) NOT NULL AUTO_INCREMENT,'."\n".
  '`weekNum` int(11) NOT NULL,'."\n".
  '`gameTimeEastern` datetime DEFAULT NULL,'."\n".
  '`homeID` varchar(10) NOT NULL,'."\n".
  '`homeScore` int(11) DEFAULT NULL,'."\n".
  '`visitorID` varchar(10) NOT NULL,'."\n".
  '`visitorScore` int(11) DEFAULT NULL,'."\n".
  '`overtime` tinyint(1) NOT NULL DEFAULT \'0\','."\n".
  'PRIMARY KEY (`gameID`),'."\n".
  'KEY `GameID` (`gameID`),'."\n".
  'KEY `HomeID` (`homeID`),'."\n".
  'KEY `VisitorID` (`visitorID`)'."\n".
') ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=257 ;'."\n".
'INSERT INTO `nflp_schedule` (`gameID`, `weekNum`, `gameTimeEastern`, `homeID`, `homeScore`, `visitorID`, `visitorScore`, `overtime`) VALUES'."\n";

#(256, 17, '2017-12-31 16:25:00', 'LAR', NULL, 'SF', NULL, 0);
for ($i = 0; $i < sizeof($schedule); $i++) {
  $j = $i + 1;
  $outputsql .= "($j, ".$schedule[$i]['weekNum'].', \''.$schedule[$i]['gameTimeEastern'].'\', \''.$schedule[$i]['homeID'].'\', NULL, \''.$schedule[$i]['visitorID'].'\', NULL, 0), '."\n";
}

// fix for IE catching or PHP bug issue
header("Pragma: public");
header("Expires: 0"); // set expiration time
// browser must download file from server instead of cache
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

header("Content-Disposition: attachment; filename=nfl_schedule_".SEASON_YEAR.".sql");
echo $outputsql;
//echo '<pre>';
//print_r($schedule);
//echo '</pre>';
exit;
