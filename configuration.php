<?php
$PASSWORD = 'nequlosdefault';  // Set the password, to access the file manager... RECOMMENDED TO SET
$servername = ''; //Your Custom Server Name
$description = 'ok';
$mylanguage = 'english.php';
//Security options
$showlog = true;
$filetest = true; //recommended to leave on true
$accessdenied = false;
$security_warnings = true;
$allow_delete = true; // Set to false to disable delete button and delete POST request.
$allow_upload = true; // Set to true to allow upload files
$allow_create_folder = true; // Set to false to disable folder creation
$allow_direct_link = true; // Set to false to only allow downloads and not direct link
$allow_show_folders = true; // Set to false to hide all subdirectories

$disallowed_patterns = ['*.php','*.'];  // must be an array.  Matching files not allowed to be uploaded
$hidden_patterns = ['*.php']; // Matching files hidden in directory index
?>