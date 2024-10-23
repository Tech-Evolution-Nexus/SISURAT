<?php

if (!function_exists("show404")) {
    function show404()
    {
        include_once __DIR__ . '/404.html';
    }
}
if (!function_exists("show400")) {
    function show400()
    {
        include_once __DIR__ . '/400.html';
    }
}
if (!function_exists("show500")) {
    function show500()
    {
        include_once __DIR__ . '/500.html';
    }
}
