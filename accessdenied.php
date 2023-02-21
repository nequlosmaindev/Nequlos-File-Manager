<?php
include("langselect.php");
include ('configuration.php');
if ($accessdenied == true){

}
if ($accessdenied == false){
	header('Location: index.php');
}
?>
<html>
<title><?php echo($wordACCESSDENIED);?></title>	
<body>
		<link rel="stylesheet" href="maincssfilepartforfmaccess.css"> 
		<style>
		p{
			margin-bottom:5px;
				margin-top:5px;
				font-size: 20px;
			  background:
				  linear-gradient(to right,
					  red,
					  #ff6600);
			  display: inline-block;
			
			
			  -webkit-background-clip: text;
			  background-clip: text;
			  color: transparent;
		}
		body{
			background-color:red;
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
					  red,
					  #ff6600);
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
			<p><?php echo($wordACCESSDENIED);?></p>
      <br>
      <p><?php echo($linecontactyouradmin);?></p>
</div>
			</div>
			</body>
			</html>