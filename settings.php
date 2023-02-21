<?php
include("langselect.php");
$maindir = "your_files";
	if(is_dir($maindir)) {
		chdir('your_files');
	} else {
		mkdir('your_files');
		chdir('your_files');
		}
include("configuration.php");
if ($accessdenied == true){
	header('Location: accessdenied.php');
}
else{
  
}

chdir('../');
$file = 'log.txt';

if(!is_file($file)){
    $contents = '';       
    file_put_contents($file, $contents);   
}
chdir('your_files');




//Disable error report for undefined superglobals
error_reporting(E_ERROR | E_PARSE);
error_reporting( error_reporting() & ~E_NOTICE );

if($PASSWORD) {

	session_start();
	if(!$_SESSION['_sfm_allowed']) {
		// sha1, and random bytes to thwart timing attacks.  Not meant as secure hashing.
		$t = bin2hex(openssl_random_pseudo_bytes(10));
		if($_POST['p'] && sha1($t.$_POST['p']) === sha1($t.$PASSWORD)) {
			$_SESSION['_sfm_allowed'] = true;
			header('Location: ?');
		}
		echo '<title>';
		echo ($linelogin);
		echo '</title>';
		echo '
		<html><body>
		<link rel="stylesheet" href="maincssfilepartforfmaccess.css"> 
		<style>
		p{
			margin-bottom:5px;
				margin-top:5px;
				font-size: 20px;
			  background:
			  linear-gradient(to right,
			  #00e6e6,
			  #1ac6ff);
			  display: inline-block;
			
			
			  -webkit-background-clip: text;
			  background-clip: text;
			  color: transparent;
		}
		body{
			background-color:#242424;
			font-family: "lucida grande","Segoe UI",Arial, sans-serif;
		}
		.centeredlogin{
			position: fixed;
			left: 50%;
			top: 50%;
			transform: translate(-50%, -50%);
			background-color: white;
			padding:30px;
			box-shadow: 0 2px 6px rgb(0 0 0 / 20%);
			width: 400px;
			height: auto;
			}
			input[type=password] {
				width: 100%;
				padding: 12px 0px;
				margin: 8px 0;
				box-sizing: border-box;
				border-bottom: 1px solid black;
				border-top:none;
				border-left:none;
				border-right:none;
				outline: none !important;
			  }
			  .logo{
				color:black;
				font-family: Segoe UI;
				font-size:50px;
			  }
			  
			  .logodiv{
				text-align: center;
			  }
			  .text{
				margin-bottom:5px;
				margin-top:5px;
				font-size: 46px;
			  background:
			  linear-gradient(to right,
			  #00e6e6,
			  #1ac6ff);
			  display: inline-block;
			
			
			  -webkit-background-clip: text;
			  background-clip: text;
			  color: transparent;
			}
			</style>
			<div class="centeredlogin">
			<div class="logodiv">
			<h1 class="text">NEQULOS FILEOP</h1>
			<br>
			<p>';
			echo ($linetypepassword);
			echo '</p>
            </div>
			<form action=? method=post><input type=password name=p autofocus placeholder="';
			echo ($lineyourpassword);
			echo '"/>
			</form>
			</div>
			</body>
			</html>';
			
		exit;
	}
}


if ($filetest){
if ($filetest == true){
	include("mainfiletest.php");
}
else {
   
}
}
else{
	
}
?>
<!DOCTYPE html>
<link rel="stylesheet" href="maincssfilepartforfmaccess.css">  
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<html lang="en">
	<title><?php if ($servername){echo $servername;} else{echo "NEQULOS FILEOP";}?></title>
	<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<div class="vulcloud">
	
	<?php
	
if ($security_warnings == 'false'){

}
if ($security_warnings == 'true'){
	include 'vulpasslist.php';
}

	?>
</div>
<div class="header">

	<div class='parent'>
  <div class='child1'><h1 class="text">NEQULOS FILEOP</h1>
  <br>
  <p class="logoslogan"><?php echo($wordversionn1);?> 2.0S</p></div>
  <div class='child3'><div class="textright">
  <p class="namesr"><?php if ($servername){echo $servername;} else{echo $wordservern1;}?>
	</p>
	<p><?php if ($description){echo $description;} else{echo "NEQULOS FILEOP";}?>
	
	</p>
	
  <?php
  echo("<a href='dashboard.php'>" . $worddashboard . "</a><br>");
  if($PASSWORD){
    echo("<a href='logoutadmin.php'>" . $wordlogout . "</a>");
  }
  ?>
  
</div>
</div>
  <div class='child2'><div class="textright">
  <p class="namesr"><?php echo($wordservern1);?>
	</p>
	<p><?php echo($worddescription);?>
	</p>
	<p><?php echo ($wordlinks);?>
	</p>
</div>
</div>
</div>
<div class="headermini">
<b class="namesr" style="color:black;border-bottom:2px black solid"><?php echo($wordsettings);?>
</b>
</div>
</div>
</head>
<body>
<div class='parent1'>
<h2 style='text-align:left;padding-left:10px;'><?php echo($worddirectory);?>
</h2>
<div class='child'>	
<h2><?php echo($lineerasedir);?></h2>
<hr>
<p style="color:red;"><?php echo($linewarningdeldir);?></p>
<p>
<form method="post">
        <input type="submit" name="button1" value="<?php echo($lineerasedir);?>"/>
         
    </form>
</p>
   </div>
   </div>
   <div class='parent1'>
   <h2 style='text-align:left;padding-left:10px;'><?php echo($wordlogs);?>
</h2>
<div class='child'>	
<h2><?php echo($linedeletelogfile);?></h2>
<hr>
<p style="color:red;"><?php echo($linewarningdellog);?></p>
<p>

<form method="post">
        <input type="submit" name="button2" value="<?php echo($lineeraselog);?>"/>
         
    </form>
</p>

    <?php
        if(array_key_exists('button1', $_POST)) {
            button1();
        }
        else{
        }
		if(array_key_exists('button2', $_POST)) {
            button2();
        }
        else{
        }
        function button1() {
            function my_folder_delete($path) {
				if(!empty($path) && is_dir($path) ){
					$dir  = new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS); //upper dirs are not included,otherwise DISASTER HAPPENS :)
					$files = new RecursiveIteratorIterator($dir, RecursiveIteratorIterator::CHILD_FIRST);
					foreach ($files as $f) {if (is_file($f)) {unlink($f);} else {$empty_dirs[] = $f;} } if (!empty($empty_dirs)) {foreach ($empty_dirs as $eachDir) {rmdir($eachDir);}} rmdir($path);
				}
			}
			  
			my_folder_delete("./your_files/");
			$fp = fopen('log.txt', 'a');//opens file in append mode  
			fwrite($fp, "DIR x-x " . date('Y-m-d h:i:s a') . "<br>");   
			fclose($fp);
			$maindir = "your_files";
	if(is_dir($maindir)) {
		chdir('your_files');
	} else {
		mkdir('your_files');
		chdir('your_files');
		}
        }

		function button2() {
		
unlink("log.txt");
$file = 'log.txt';

if(!is_file($file)){
    $contents = "DIR " . date('Y-m-d h:i:s a') . "<hr>";       
    file_put_contents($file, $contents);   
}
		}
    ?>
 
    
<p>
<?php 

	if ($showlog){
	if ($showlog == true){
		include('log.txt');
	}
	else {
	   
	}
	}
	else{
		
	}
	?>

</p>
   </div>
   </div>
<style>
.footer {
   position: static;
   left: 0;
   bottom: 0;
   width: 100%;
   color: white;
   text-align: center;
}
</style>
<div class="footer">
  <p>NEQULOS &copy; <?php echo($lineallrightsreservedn1);?></p>
</div>

</body></html>