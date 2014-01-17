<?



class Automatic{

	// the OAuth2 client
	private $client;
	
	private $token;

	public function __construct($client_id, $client_secret){
		$this->client = new OAuth2\Client($client_id, $client_secret);
	    $this->client->setAccessTokenType(OAuth2\Client::ACCESS_TOKEN_BEARER);
	}
	
	public function getOAuthToken(){
		return $this->token;
	}
	
	public function setOAuthToken($token){
		$this->token = $token;
		$this->client->setAccessToken($token);
	}
	
	public function isLoggedIn(){
		return strlen($this->token);
	}
	
	public function authenticationURLForScopes($scopes){
		if(!is_array($scopes)){
			throw new InvalidArgumentException("\$scopes parameter to authenticateForScopes should be an array");
		}
		$scopes = implode(" ", $scopes);
	    return $this->client->getAuthenticationUrl(AUTOMATIC_AUTHORIZATION_ENDPOINT, AUTOMATIC_REDIRECT_URI, array("scope" => $scopes));
	}
	
	public function getTokenForCode($code){
	    $params = array('code' => $_GET['code'], 'redirect_uri' => AUTOMATIC_REDIRECT_URI);
	    $response = $this->client->getAccessToken(AUTOMATIC_TOKEN_ENDPOINT, 'authorization_code', $params);
	    if($response['code'] != 200){
	    	echo "can't find: \$response['result']['access_token']\n\n";
		    print_r($response);
		    exit;
	    }else{
	    	$ret = (object) array();
	    	$ret->user_id = $response["result"]["user"]["id"];
	    	$ret->access_token = $response["result"]["access_token"];
	    	$ret->refresh_token = $response["result"]["refresh_token"];
	    	$ret->scope = $response["result"]["scope"];
	    
		    $this->client->setAccessToken($ret->access_token);
		    return $ret;
	    }
	}
	
	/**
	 * returns up to $per_page trips starting with
	 * the most recent trip after $page * $per_page trips
	 *
	 * @param $page the page of trips to start on (begins at 1)
	 * @param $per_page the number of trips to return per page
	 */
	public function getTrips($page=1, $per_page=100){
		$parameters = array("page" => $page, "per_page" => $per_page);
		$params = http_build_query($parameters, null, '&');
		return $this->client->fetch(AUTOMATIC_API_ENDPOINT . "trips?" . $params);
	}
	
	
	/**
	 * returns a single trip specified by the input id
	 *
	 * @param $trip_id the id of the trip to fetch
	 */
	public function getTrip($trip_id){
		return $this->client->fetch(AUTOMATIC_API_ENDPOINT . "trip/" . urlencode($trip_id));
	}

}