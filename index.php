<?

include("config.php");

$host = "https://secure.milesense.com/v3/link/info?";

$opts = array(
  'http'=>array(
    'method'=>"GET",
    'header'=>"Authorization: Basic ".base64_encode(USERNAME . ":" . PASSWORD)."\r\n"
  )
);

$context = stream_context_create($opts);
$fp = fopen($host, 'r', false, $context);
$contents = stream_get_contents($fp);
// read the content from $fp here.
fclose($fp);

print_r($contents);

echo "\n\n\n\n";




$host = "https://secure.milesense.com/v3/user/trips/";

$data = array("end_time" => 1381872653000, "start_time" => 1000);
$data_string = json_encode($data);
$data_string = http_build_query(array("data" => $data_string));

$opts = array(
  'http'=>array(
    'method'=>"POST",
    'header'=>"Authorization: Basic ".base64_encode(USERNAME . ":" . PASSWORD)."\r\n"
             . "Content-Length: " . strlen($data_string) . "\r\n",
    'content' => $data_string
  )
);

$context = stream_context_create($opts);
$fp = fopen($host, 'r', false, $context);
$contents = stream_get_contents($fp);
// read the content from $fp here.
fclose($fp);

print_r($contents);


?>