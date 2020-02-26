#!/usr/bin/env php
<?php

$itemList = array(
    // file or directory's absolute path which you want clean

);

$dryRun = (isset($argv[1]) ? $argv[1] : '') != 'del';
define('DRY_RUN', $dryRun);

/**
 * @param $item
 */
function doWithItem($item)
{
    if (is_dir($item)) {
        doAsDir($item);
    } else if (file_exists($item)) {
        doAsFile($item);
    }
}

foreach ($itemList as $item) {
    doWithItem($item);
}


function doAsDir($dirName)
{
    $dir = dir($dirName);
    while ($item = $dir->read()) {
        if ($item == '.' || $item == '..') {
            continue;
        }
        $itemCat = $dirName . '/' . $item;
//        echo "A item:", "$itemCat", "\n";
        doWithItem($itemCat);
    }
    $dir->close();
}

function doAsFile($item)
{
    if (DRY_RUN) {
        echo "file:", $item, "\n";
        return;
    }
    $fp = fopen($item, 'w');
    fwrite($fp, 'clear');
    fclose($fp);
}
