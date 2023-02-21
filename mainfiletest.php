<?php
chdir('../');
$htaccessfile = '.htaccess';
if (file_exists($htaccessfile)) {

} else {
  $fp = fopen('log.txt', 'a');//opens file in append mode  
fwrite($fp, ".htaccess Missing! " . date('Y-m-d h:i:s a') . "<br>");   
fclose($fp);
}

$accessdeniedfile = 'accessdenied.php';
if (file_exists($accessdeniedfile)) {

} else {
    $fp = fopen('log.txt', 'a');//opens file in append mode  
fwrite($fp, "accessdenied.php Missing! " . date('Y-m-d h:i:s a') . "<br>");   
fclose($fp);
}

$configurationfile = 'configuration.php';
if (file_exists($configurationfile)) {
  
} else {
    $fp = fopen('log.txt', 'a');//opens file in append mode  
fwrite($fp, "configuration.php Missing! " . date('Y-m-d h:i:s a') . "<br>");   
fclose($fp);
}

$dashboardfile = 'dashboard.php';
if (file_exists($dashboardfile)) {
  
} else {
    $fp = fopen('log.txt', 'a');//opens file in append mode  
fwrite($fp, "dashboard.php Missing! " . date('Y-m-d h:i:s a') . "<br>");   
fclose($fp);
}

$indexfile = 'index.php';
if (file_exists($indexfile)) {
  
} else {
    $fp = fopen('log.txt', 'a');//opens file in append mode  
    fwrite($fp, "index.php Missing! " . date('Y-m-d h:i:s a') . "<br>");   
    fclose($fp);
}

$jqueryfile = 'jquery.min.js';
if (file_exists($jqueryfile)) {
  
} else {
    $fp = fopen('log.txt', 'a');//opens file in append mode  
fwrite($fp, "jquery.min.js Missing! " . date('Y-m-d h:i:s a') . "<br>");   
fclose($fp);
}

$langselectfile = 'langselect.php';
if (file_exists($langselectfile)) {
  
} else {
    $fp = fopen('log.txt', 'a');//opens file in append mode  
fwrite($fp, "langselect.php Missing! " . date('Y-m-d h:i:s a') . "<br>");   
fclose($fp);
}

$logoutfile = 'logoutadmin.php';
if (file_exists($logoutfile)) {
  
} else {
    $fp = fopen('log.txt', 'a');//opens file in append mode  
fwrite($fp, "logoutadmin.php Missing! " . date('Y-m-d h:i:s a') . "<br>");   
fclose($fp);
}

$maincssfile = 'maincssfilepartforfmaccess.css';
if (file_exists($maincssfile)) {
  
} else {
    $fp = fopen('log.txt', 'a');//opens file in append mode  
fwrite($fp, "maincssfilepartforfmaccess.css Missing! " . date('Y-m-d h:i:s a') . "<br>");   
fclose($fp);
}

$helpguidefile = 'nqshelpguide.php';
if (file_exists($helpguidefile)) {
  
} else {
    $fp = fopen('log.txt', 'a');//opens file in append mode  
    fwrite($fp, "nqshelpguide.php Missing! " . date('Y-m-d h:i:s a') . "<br>");   
    fclose($fp);
}

$vulpassfile = 'vulpasslist.php';
if (file_exists($vulpassfile)) {
  
} else {
    $fp = fopen('log.txt', 'a');//opens file in append mode  
fwrite($fp, "vulpasslist.php Missing! " . date('Y-m-d h:i:s a') . "<br>");   
fclose($fp);
}

$settingsfile = 'settings.php';
if (file_exists($settingsfile)) {
  
} else {
    $fp = fopen('log.txt', 'a');//opens file in append mode  
fwrite($fp, "settings.php Missing! " . date('Y-m-d h:i:s a') . "<br>");   
fclose($fp);
}

?>