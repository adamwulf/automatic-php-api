<?

include("config.php");
include("Automatic/class.Automatic.php");


$automatic = new Automatic(USERNAME, PASSWORD);



// check my trips from past 24 hours
$now = time();
$yesterday = $now - 24*60*60;
$data = $automatic->getTrips($yesterday*1000, $now * 1000);


// set our timezone
date_default_timezone_set("America/Chicago");

// loop through all my trips from the past 24 hours
foreach($data->trips as $trip){
	$place_from = $trip->startLocationNickname;
	$place_to = $trip->endLocationNickname;
	$startTime = $trip->startLocationStartTime / 1000;
	$endTime = $trip->endLocationEndTime / 1000;
	$duration = round(($endTime - $startTime) / 60, 2); // calculate duration in minutes
	$mpg = round($trip->averageMPG, 2);
	
	echo $place_from . " - " . $place_to . "<br>";
	echo date("Y-m-d h:ia", $startTime) . " - " . date("Y-m-d h:ia", $endTime) . "<br>";
	echo $duration . " minutes.  " . $mpg . "MPG <br><br>";
}

/*
print_r($automatic->getLinkInfo());

print_r($automatic->getTrips($yesterday, $now));

print_r($automatic->getScores($yesterday, $now));

$info = $automatic->getLinkInfo();
print_r($automatic->getParkedLocations($info->linkInfoList[0]->associatedVehicle));

print_r($automatic->getCars());
*/

?>