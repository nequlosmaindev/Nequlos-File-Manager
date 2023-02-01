<?php
include 'configuration.php';
error_reporting( error_reporting() & ~E_NOTICE );
if($recoverypassword) {
	ob_start();
		echo '<html><body><style>
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
			<h1 class="text">NEQULOS</h1>
			<br>
			<p>Type in your Recovery Password:</p>
</div>
			<form action=? method=post><input type=password name=p autofocus placeholder="Your Password"/>
			</form>
			</div>
			</body>
			</html>';
			if($_POST['p'] === ($recoverypassword)) {
				ob_end_clean();
				echo "<html><body><style>
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
					background-color:#242424;
					font-family: 'lucida grande','Segoe UI',Arial, sans-serif;
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
					<div class='centeredlogin'>
					<div class='logodiv'>
					<h1 class='text'>NEQULOS</h1>
					<br>
					<p>Your Password is: $PASSWORD</p>
		</div>
		<p><a href='index.php'>Back</a></p>
					</div>
					</body>
					</html>";
					}
		
		
}
if($recoverypassword == '') {
	header("Location: index.php");
		}

?>

  