#!/usr/bin/php
<?php
require dirname(__FILE__) . '/../src/Curl/Curl.php';

$current_version = Curl\Curl::VERSION;
list($major, $minor, $patch) = explode('.', $current_version);
$new_version = implode('.', array($major, (string)((int)$minor += 1), $patch));

foreach(
    array(
        array(
            dirname(__FILE__) . '/../composer.json',
            '/"version": "(?:\d+.\d+.\d+)"/',
            '"version": "' . $new_version . '"',
        ),
        array(
            dirname(__FILE__) . '/../src/Curl/Curl.php',
            '/const VERSION = \'(?:\d+.\d+.\d+)\';/',
            'const VERSION = \'' . $new_version . '\';',
        ),
    ) as $info) {
    list($filepath, $find, $replace)  = $info;
    $data = preg_replace($find, $replace, file_get_contents($filepath));
    file_put_contents($filepath, $data);
}
