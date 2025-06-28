
<?php 
require "Vendor/autoload.php";
$client = new Google\Client;

$client->setAuthConfig( 'credentials.json');

$client->addScope("email");
$client->addScope("profile");

$url = $client->createAuthUrl();
if ( !isset($_GET["code"])){
    $action="login";
}else{
    $token = $client->fetchAccessTokenWithAuthCode($_GET["code"]);

$client->setAccessToken($token["access_token"]);

$oauth = new Google\Service\Oauth2($client);

$userInfo = $oauth->userinfo->get();

$_SESSION["name"] = $userInfo->name;

$action="dashboard";
}



?>