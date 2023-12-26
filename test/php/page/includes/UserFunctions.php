<?php

function readFileName($data_dir){
    $dir = opendir("$data_dir");
    while ($temp=readdir($dir)) {
        if(($temp != '.') && ($temp != '..'))
            $filename[] = $temp;
    }
    closedir($dir);
    return $filename;
}

?>