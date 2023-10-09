<?php

$shortcut = '/home/keyeduau/public_html/storage';

$target = '/home/keyeduau/public_html/key/storage/app/public';

$shortcut2 = '/home/keyeduau/public_html/key/public/storage';

if(symlink($target, $shortcut)){
    echo 'success1';
}else{
    echo 'fail1';
}

if(symlink($target, $shortcut2)){
    echo 'success2';
}else{
    echo 'fail2';
}
