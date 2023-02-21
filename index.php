<?php
include("langselect.php");
include("configuration.php");
if ($accessdenied == true){
	header('Location: accessdenied.php');
}
else{
  
}
?>
<!DOCTYPE html>
<link rel="stylesheet" href="maincssfilepartforfmaccess.css">  
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<html>
	<title><?php echo($linewelcometoyour);?> NEQULOS FILEOP <?php echo($wordinstallation);?></title>
	<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<div class="header">

	<div class='parent'>
  <div class='child1'><h1 class="text">NEQULOS FILEOP</h1>
  <br>
  <p class="logoslogan"><?php echo($wordversion);?> 2.0S</p></div>
  <div class='child3'><div class="textright">
  <p class="namesr"><?php if ($servername){echo $servername;} else{echo $wordserver;}?>
	</p>
</div>
</div>
  <div class='child2'><div class="textright">
  <p class="namesr"><?php echo($wordserver);?>
	</p>
</div>
</div>
</div>
<div class="headermini">
<b class="namesr" style="color:black;border-bottom:2px black solid"><?php echo($wordhomepage);?>
</b>
</div>

</div>

<div class='parent1'>
<h1 style='text-align:center;padding:10px;'><?php echo($linewelcometo);?> NEQULOS FILEOP</h1>
<div class='child' style="text-align:center;">
    <p><a href="dashboard.php"><?php echo($lineloginhere);?></a> <?php echo($lineorgodirectlytoinyourbrowser);?>.</p>
</div>
<div class="footer">
  <p>NEQULOS &copy; <?php echo($lineallrightsreserved);?>.</p>
</div>