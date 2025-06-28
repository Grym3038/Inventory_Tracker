
<?php 
require "vendor/autoload.php";
$client = new Google\Client;

$client->setAuthConfig( '../credentials.json');

$client->addScope("email");
$client->addScope("profile");

$url = $client->createAuthUrl();
if ( !isset($_GET["code"])){
    $action="login";
}

$token = $client->fetchAccessTokenWithAuthCode($_GET["code"]);

var_dump($token);

$_SESSION['access_token'] = $token;
$client->setAccessToken($token["access_token"]);

$oauth = new Google\Service\Oauth2($client);

$userInfo = $oauth->userinfo->get();

$_SESSION["name"] = $userInfo->name;

    header('Location:?action=dashboard');




?>