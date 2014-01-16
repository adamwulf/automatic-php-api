# Automatic PHP API

This is a PHP client library for the Automatic API (http://www.automatic.com/). The Automatic Link plugs into your car's data port and connects to your phone to help you track and improve your driving habits. This API gives you access to the data stored in your Automatic account, including some of your car information and driving history. The Automatic API is in early alpha, and more functionality is expected to be released soon.

## Authentication

The Automatic API uses OAuth2 to authenticate against their website.

## Usage

```
$automatic = new Automatic($your_client_id, $your_client_secret);

// logging in with OAuth2 code
if (/* have a stored token somewhere in $_SESSION or the database */){
    $automatic->setOAuthToken($the_stored_token_to_reuse);
}else if (!isset($_GET['code'])){
	// we don't have a token stored, so fetch one
	$scopes = array("scope:notification:speeding", "scope:location", "scope:vehicle", "scope:trip:summary");
	$auth_url = $automatic->authenticationURLForScopes($scopes);
    header('Location: ' . $auth_url);
    die('Redirect');
}
else
{
    $response_token = $automatic->getTokenForCode($_GET["code"]);
    // store and re-use this $response_token to save the user's login
    // across multiple requests
    $automatic->setOAuthToken($response_token);
}

$trip_data = $automatic->getTrips();
```

## Documentation

The Automatic API documentation is available at: https://www.automatic.com/developer/documentation/

More information is available at: https://www.automatic.com/developer/