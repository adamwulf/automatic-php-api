<?



class Automatic{

	protected $username;
	protected $password;

	/**
	 * for instructions on how to find your username
	 * and password for the Automatic API, view
	 * the instructions in the README
	 */
	public function __construct($username, $password){
		$this->username = $username;
		$this->password = $password;
	}

	/**
	 * This method will return preference and account
	 * information, including name, timezone, audio
	 * preferences, vin numbers, etc
	 */	
	public function getPreferences(){
		return $this->getRequest("/v3/user/preferences");
	}
	
	/**
	 * This method will return information about
	 * the Automatic links on your account.
	 */
	public function getLinkInfo(){
		return $this->getRequest("/v3/link/info");
	}
	
	/**
	 * This will return detailed information about
	 * the cars in your account
	 */
	public function getCars(){
		return $this->getRequest("/v3/car");
	}
	
	/**
	 * this will update the audio notifications in the server,
	 * however, the iPhone app seems to also store its audio
	 * settings locally. After the iPhone checks in to the server,
	 * even though it gets the values that you've set here, it'll
	 * reset it to whatever was set on the phone, overriding
	 * whatever you set here.
	 *
	 * this method is kept in this API in case the iPhone app ever
	 * starts to respect the values sent back from the server instead
	 * of overriding it with its local values.
	 */
	public function updateAudioNotifications($brake, $speed, $accel){
		$data = array("brake" => $brake, "speed_warn" => $speed, "accel" => $accel);
		$data = array("audioSettings" => $data);
		$data_string = json_encode($data);
		$data_string = http_build_query(array("data" => $data_string));
		return $this->postRequest("/v3/user/preferences", $data_string);
	}	
	
	/**
	 * returns all trips that are between the start and end
	 * timestamps.
	 *
	 * input timestamps in milliseconds
	 */
	public function getTrips($start_time, $end_time){
		$data = array("end_time" => $end_time, "start_time" => $start_time);
		$data_string = json_encode($data);
		$data_string = http_build_query(array("data" => $data_string));
		return $this->postRequest("/v3/user/trips/", $data_string);
	}
	
	/**
	 * returns an array of weekly scores that fall between the input
	 * start and end timestamps
	 *
	 * input timestamps in milliseconds
	 */
	public function getScores($start_time, $end_time){
		$data = array("end_time" => $end_time, "start_time" => $start_time);
		$data_string = json_encode($data);
		$data_string = http_build_query(array("data" => $data_string));
		return $this->postRequest("/v3/user/scores/", $data_string);
	}
	
	/**
	 * returns the current parked location for the vehicle
	 * of the input vin number
	 */
	public function getParkedLocations($vin){
		$data = array("vin" => $vin);
		$data_string = json_encode($data);
		$data_string = http_build_query(array("data" => $data_string));
		return $this->postRequest("/v3/car/parked_location/", $data_string);
	}


	/**
	 * helper method to send a GET request
	 * to the API
	 */	
	protected function getRequest($endpoint){
		$host = "https://secure.milesense.com" . $endpoint;
	
		$opts = array(
		  'http'=>array(
		    'method'=>"GET",
		    'header'=>"Authorization: Basic ".base64_encode($this->username . ":" . $this->password)."\r\n"
		  )
		);
		
		$context = stream_context_create($opts);
		$fp = fopen($host, 'r', false, $context);
		$contents = stream_get_contents($fp);
		// read the content from $fp here.
		fclose($fp);
		
		if($contents){
			$contents = json_decode($contents);
		}
		
		return $contents;
	}
	
	/**
	 * helper method to send a POST request
	 * to the API
	 */	
	protected function postRequest($endpoint, $data_string){
		$host = "https://secure.milesense.com" . $endpoint;
	
		$opts = array(
		  'http'=>array(
		    'method'=>"POST",
		    'header'=>"Authorization: Basic ".base64_encode($this->username . ":" . $this->password)."\r\n"
             . "Content-Length: " . strlen($data_string) . "\r\n"
             . "Content-Type: application/x-www-form-urlencoded\r\n",
			'content' => $data_string
		  )
		);
		
		$context = stream_context_create($opts);
		$fp = fopen($host, 'r', false, $context);
		$contents = stream_get_contents($fp);
		// read the content from $fp here.
		fclose($fp);
		
		if($contents){
			$contents = json_decode($contents);
		}
		
		return $contents;
	}
	
}