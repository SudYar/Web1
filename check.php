<?php
require_once("json-encode.php");

function hitRectangle($x, $y, $r){
    return $y<=$r && $x >= (-1)*$r/2 && $x <= 0;
}

function hitTriangle($x, $y, $r){
    return $y >= ($x - $r/2);
}

function hitCircle($x, $y, $r){
    return ($x * $x + $y * $y <= $r * $r) && $x >=0 && $y <= 0;
}

function hit($x, $y, $r) {
    return (hitTriangle($x, $y, $r) && hitRectangle($x, $y, $r)) || hitCircle($x, $y, $r);
}

function checkValue($value, $min, $max){



    if (!isset($value))
        return false;

    $num = str_replace(',', '.', $value);
    return is_numeric($num) && $num >= $min && $num <= $max;
}



$xValue = $_GET["x"];
$yValue = $_GET["y"];
$rValue = $_GET["r"];
$time = $_GET["time"];
$myTime = date("H:i:s", time() - $time*60);
$flag = checkValue($xValue, -3, 4) && checkValue($yValue, -5, 5) && checkValue($rValue, 2, 5);
if (!$flag) echo toJSON(array("success" => false));
else {
    $isHit = hit($xValue, $yValue, $rValue);
    $exTime = round(microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'], 7);
    $result = array(
        "success" => true,
        "x" => $xValue,
        "y" => $yValue,
        "r" => $rValue,
        "hit" => $isHit,
        "time" => $myTime,
        "exTime" => $exTime
    );
    echo toJSON($result);
}


