

<?php 

require  '../../vendor/autoload.php';

require '../Models/FormValidator.php';

$validations = array(
    'name' => 'words',
    'phone' => 'phone',
    'email' => 'email',
    'message' => 'words'
);
$required = array('name', 'phone', 'email');
$sanitize = array('name', 'phone', 'email', 'message');

$validator = new FormValidator($validations, $required, $sanitize);

if (!$validator->validate($_POST)) {
    header("location:../index.php?action=FormError");
    exit;
}



$client = new \Google_Client();
$client->setApplicationName('Google Sheet for schedule');
$client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
$client->setAccessType('offline');
$client->setAuthConfig('../../../credentials.json');
$service = new Google_Service_Sheets($client);
$spreadsheetID = "1q8P33RtFz-A1963pJ_wqPAsK4AcSA4WyefqOO4AChbs";

$range = "ContactInfo!A2:D";

$selectedDays  = $_POST['days']  ?? [];
$selectedTimes = $_POST['hours'] ?? [];

$daysString  = count($selectedDays)
  ? implode(', ', $selectedDays)
  : 'None selected';
$timesString = count($selectedTimes)
  ? implode(', ', $selectedTimes)
  : 'None selected';


$values = [
    $_POST['name'],  $_POST['phone'], $_POST['email'], $_POST['message'], $daysString, $timesString
];

$_POST = $validator->sanitize($_POST);

try{
    $body = new Google_Service_Sheets_ValueRange([
    'values' => [$values]
    ]);
    $params = [
    'valueInputOption' => 'RAW'
    ];
    $insert = [
        "insertDataOption" => "INSERT_ROWS"
    ];
        //executing the request
        $result = $service->spreadsheets_values->append(
            $spreadsheetID, 
            $range, 
            $body, 
            $params,
            $insert);
        header("location:../index.php?action=FormSubmited");
}
catch(Exception $e) {
    echo 'Message: ' .$e->getMessage();
}


?>
