<?php
//-----Not in use!
//https://www.ka-gold-jewelry.com/tests/retreat-guru/index.php#

$token="ef061e1a717568ee5ca5c76a94cf5842";
$months = array('January','February','March','April','May','June','July ','August','September','October','November','December');

$month="August";
$year="2025";

//to verify we are request is safe
if (isset($_REQUEST["month"]) && in_array($months, $_REQUEST["month"]))
    $month = $_REQUEST["month"];

//to verify we are request is safe
if (isset($_REQUEST["year"]) && is_int($_REQUEST["year"]))
    $month = $_REQUEST["year"];


/*
 * @TODO - add month and year to api request
 */    
function getMonthRegstrationsAPI($token, $month, $year)
{
    $requestUrl="https://demo14.secure.retreat.guru/api/v1/registrations?token=".$token;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$requestUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 300);
    curl_setopt($ch, CURLOPT_VERBOSE, true);
    $headers = [
        'HEAD: HTTP/1.1',
        'Accept: application/json'
    ];

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $curl_response = trim(curl_exec($ch));
    if ($curl_response === false) {
        $info = curl_getinfo($ch);
        curl_close($ch);
        die('error occured during curl exec. Additioanl info: ' . var_export($info));
    }
    $info = curl_getinfo($ch);
    curl_close($ch);
    $registrations=json_decode ($curl_response,TRUE);
    return $registrations;
}

$registrations=getMonthRegstrationsAPI($token, $month, $year);