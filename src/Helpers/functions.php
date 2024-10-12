<?php

function view($name, $data = [])
{
    extract($data);
    require_once __DIR__ . "/../Views/$name.php";
}

function redirect($url)
{
    header("Location: $url");
    exit();
}
