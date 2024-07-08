<?php

function get_img($type, $seed, $img_list)
{
    if (!in_array($type, ["h", "v", "s"]))
        $type = "h";
    $list = $img_list[$type];
    srand($seed);
    $index = rand(0, count($list) - 1);
    return $list[$index];
}

function get_list($type)
{
    $file_name = 'resource/images/blog/' . $type . '.csv';
    if (file_exists('../' . $file_name)) {
        $imgs_array = file('../' . $file_name);
    } else {
        // for vercel runtime
        $server = 'https://cdn.jsdelivr.net/gh/taochenyue/resource/';
        $imgs_array = file($server . $file_name);
    }
    return $imgs_array;
}

$name_list = ["h", "v", "s"];
$img_list = [];

foreach (["h", "v", "s"] as $name) {
    $img_list[$name] = get_list($name);
}

if (isset($_REQUEST["type"])) {
    $type = $_REQUEST["type"];
} else {
    $type = "horizontal";
}


if (isset($_REQUEST["seed"])) {
    $seed = $_REQUEST["seed"];
} else {
    $seed = time();
}

$img = get_img($type, $seed, $img_list);
header("Location: $img");

?>