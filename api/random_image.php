<?php
const ALLOW_RAW_OUTPUT = false;
// 是否开启 ?raw 选项，可能会消耗服务器较多流量

function has_query($query)
{
    return isset($_GET[$query]);
}

$file_name = 'image/pixiv/file_list.csv';
$server = 'https://cdn.jsdelivr.net/gh/taochenyue/static_resource/';

if (file_exists($file_name))
    $imgs_array = file($file_name);
else                                   // for vercel runtime
    $imgs_array = file($server . $file_name);

if (isset($_REQUEST["type"])) {
    $type = $_REQUEST["type"];
} else {
    $type = "horizontal";
}

if (!in_array($type, ["horizontal", "vertical", "square"])) {
    $type = "horizontal";
}

if (isset($_REQUEST["name"])) {
    $name = $_REQUEST["name"];
} else {
    $name = "*";
}

$filter_array = [];
foreach ($imgs_array as $key => $value) {
    if (preg_match("/\/$type\/$name/i", $value))
        array_push($filter_array, $value);
}

if (count($filter_array) == 0) {
    die("No image found!");
}

$img = $filter_array[array_rand($filter_array)];
// echo "Location: $server" . $img;
die(header("Location: $server" . $img));
?>