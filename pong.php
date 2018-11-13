<?php 	

	echo "<script>
	var myForm = document.getElementsByTagName('form');
	for (var i = 0; i < myForm.lenght; i++) {
		myForm[i].value = '';
	}
	</script>";
	
	$parameters_names = array (
		'FPS' 				=>  "Game FPS",
		'canvasHeight'		=>	'Height of the playing area',
		'canvasWidth'		=>	'Width of the playing area',
		'playerHeight'		=>	'Player height',
		'playerWidth'		=>	'Player width',
		'playerSpeed'		=>	'Player speed',
		'middleLineWidth'	=> 	'Middle collumn width',
		'ballSpeedXMin'		=>	'Minimal X speed of the ball',
		'ballSpeedYMin'		=>	'Minimal Y speed of the ball',
		'ballspeedXMid'		=>	'Middle X speed of the ball',
		'ballspeedYMid'		=>	'Middle Y speed of the ball',
		'ballSpeedXMax'		=>	'Maximum X speed of the ball',
		'ballSpeedYMax'		=>	'Maximum Y speed of the ball',	
		'ballRadius'		=>	'Diameter of the ball',
		'fontSize'			=>	'Font size'	,
		'scoreToWin'		=>	'Score required to win'	
	);
	$default_parameters = array (
		'FPS' 				=>  60,
		'canvasHeight'		=>	700,
		'canvasWidth'		=>	700,
		'playerHeight'		=>	100,
		'playerWidth'		=>	10,
		'ballSpeedXMin'		=>	6,
		'ballSpeedYMin'		=>	1,
		'ballspeedXMid'		=>	8,
		'ballspeedYMid'		=>	3,
		'ballSpeedXMax'		=>	10,
		'ballSpeedYMax'		=>	5,
		'playerSpeed'		=>	10,
		'ballRadius'		=>	10,
		'fontSize'			=>	30,
		'scoreToWin'		=>	10,
		'middleLineWidth'	=>	4
	);
?>
<!DOCTYPE html>
<html>
<head>
	<style type="text/css">
		canvas {
    		border: 1px solid #d3d3d3;
    		background-color: black;
    		display: inline;
		}
		.canvas-container {
			margin-top: 50px;
			width: 100%;
			text-align: center;
		}
		form {
			width: 100%;
			display: inline-block;
			text-align: center;
		}
		input {
			margin-bottom: 10px;
			border-radius: 5px;
			height: 20px;
			width: 100px;
			text-align: center;
		}
		input[type=text] {
			padding: 0 5px 0 5px;
		}
		input:focus {
			outline: none;
		}
		input[type=submit] {
			width: 150px;
			height: 27px;
			border: none;
			cursor: pointer;
			background-color: #ff7b00;
			color: #eaf2eb;	
		}
		input[type=submit]:hover{
			background-color: #d66700;
		}
		input[name=default] {
			width: 200px;
		}
		button {
			width: 205px;
			height: 50px;
			border-radius: 10px;
			box-shadow: none;
			background-color: #0ece28;
			color: #eaf2eb;
			border: none;
			cursor: pointer;
			font-size: 23px;
		}
		button:focus {
			outline: 0;
			background-color: #b70505;
		}
		button span {
			display: inline-block;
			position: relative;
			transition: 0.5s;
		}

		button span:after {
			content: '\00bb';
			position: absolute;
			opacity: 0;
			top: 0;
			right: -20px;
			transition: 0.5s;
		}

		button:hover span {
			padding-right: 25px;
		}

		button:hover span:after {
			opacity: 1;
			right: 0;
		}
	</style>
	<title></title>
</head>
<body>

<form method="POST" action="index.php">

	<?php
	
	foreach ($parameters_names as $key => $value) {
		echo  "\n\t" . '<label for="' . $key . '">' . $value . ' :' . '</label><br>';
		echo '<input type="text" name="' . $key . '" value=""><br>';
	}
	?>
	<input type="submit" name="submit" value="Apply parameters">
	<input type="submit" name="clear" value="Clear parameters">
	<br>
	<input type="submit" name="default" value="Set default parameters"><br>
	<button onclick="checkParameters()"><span>Start the game !</span></button>

</form>


<?php 
	if (isset($_POST["FPS"])) {
		$parameters = array (
			'FPS' 				=>  $_POST["FPS"],
			'canvasHeight'		=>	$_POST["canvasHeight"],
			'canvasWidth'		=>	$_POST["canvasWidth"],
			'playerHeight'		=>	$_POST["playerHeight"],
			'playerWidth'		=>	$_POST["playerWidth"],
			'ballSpeedXMin'		=>	$_POST["ballSpeedXMin"],	
			'ballSpeedYMin'		=>	$_POST["ballSpeedYMin"],	
			'ballspeedXMid'		=>	$_POST["ballspeedXMid"],
			'ballspeedYMid'		=>	$_POST["ballspeedYMid"],
			'ballSpeedXMax'		=>	$_POST["ballSpeedXMax"],
			'ballSpeedYMax'		=>	$_POST["ballSpeedYMax"],	
			'playerSpeed'		=>	$_POST["playerSpeed"],
			'ballRadius'		=>	$_POST["ballRadius"],
			'fontSize'			=>	$_POST["fontSize"],
			'scoreToWin'		=>	$_POST["scoreToWin"],
			'middleLineWidth'	=>	$_POST["middleLineWidth"]
		);	
	}
	
	if (isset($_POST['clear'])) {
		$_POST = null;
	} 
	if (isset($_POST['default'])) {
		echo "<script>\n";
		foreach ($default_parameters as $key => $value) {
			echo 'document.getElementsByName("' . $key . '")[0].value = "' . $value . '"'."\n";
		}
		echo '</script>';
	}
	if (isset($_POST["submit"])) {
		echo "<script>\n";		
		foreach ($parameters as $key => $value) {
			echo "var " . $key . " = " . $value . ";\n";
		}			
		echo "</script>";
		
	} 
?>

<script type="text/javascript">

var myCanvas = { // create canvas
	div : document.createElement("div"),
	canvas : document.createElement("canvas"),
	start : function() {
		document.getElementsByTagName("form")[0].remove(),
		this.div.classList.add("canvas-container"),
		document.body.insertBefore(this.div, document.body.childNodes[0]),
		this.div.appendChild(this.canvas),
		this.context = this.canvas.getContext("2d"),
		this.canvas.width = canvasWidth,
		this.canvas.height = canvasHeight,
		this.interval = setInterval(uptadeCanvas , 1000 / FPS),		
		this.context.font = fontSize.toString() + "px Comic Sans MS",
		this.context.fillStyle = "white",
		// listeners for keys
		window.addEventListener('keydown', function(e) {	// listener for pushing down the key
			if(!myCanvas.keys) { // create array if its not created
        		myCanvas.keys = [];
        	}
        	myCanvas.keys[e.keyCode] = true; 
		}),
		window.addEventListener('keyup', function(e) {		// listener for stop pushing the key
			if (!myCanvas.keys) {
				myCanvas.keys = [];	
			}
			myCanvas.keys[e.keyCode] = false;
		})
	},
	clear : function () {
		this.context.clearRect(0, 0, canvasWidth, canvasHeight);
	},
	stopGame : function () {
		clearInterval(this.interval);

	}
}

function ball(radius, x, y, color, speedX, speedY) { // constructor for ball
	this.radius = radius;
	this.x = x;
	this.y = y; 
	this.speedX = speedX;
	this.speedY = speedY;
	this.update = function() {
		this.y += this.speedY;
		this.x += this.speedX;
		this.context = myCanvas.context;
		this.context.fillStyle = color;
		this.context.beginPath();
		this.context.arc(this.x, this.y, radius, 0, 2 * Math.PI, true);		
		this.context.fill();		
	}
	this.isNearAWall = function() {		// function for chceking walls
		if (this.x + this.radius >= canvasWidth) {			// right  wall
			firstPlayer.score++;
			this.reset(firstPlayer);	
		} else if (this.x - this.radius <= 0) {				// left wall
			secondPlayer.score++;
			this.reset(secondPlayer);
		} else if (this.y + this.radius >= canvasHeight) {	// bottom wall
			this.speedY = -this.speedY;
		} else if (this.y - this.radius <= 0) {				// top wall
			this.speedY = Math.abs(this.speedY);
		}
	}
	this.bounceOnPlayer = function() { // funcation for checking collision with player
		if (this.x - this.radius <= firstPlayer.x + firstPlayer.width) {  
			this.checkOnPlayerY(firstPlayer);
		}
		if (this.x + this.radius >= secondPlayer.x ) {
			this.checkOnPlayerY(secondPlayer);
		}
	}
	this.checkOnPlayerY = function(player) { // function for chcecking which part collided
		if ((this.y >= player.y && this.y <= player.y + playerHeight * 0.2) || 
			(this.y >= player.y + playerHeight * 0.8 && this.y <= player.y + playerHeight)) { 		 				  // most outer edge - 0 - 20 80 - 100
			if (this.speedY <= 0 && player.id == 1) {
				this.speedX = ballSpeedXMax;
				this.speedY = - ballSpeedYMax;
				console.log("najviac1");
			} 
			else if(this.speedY > 0 && player.id == 1) {
				this.speedX = ballSpeedXMax;
				this.speedY = ballSpeedYMax;
				console.log("najviac1");
			}
			else if(this.speedY <= 0 && player.id == 2) {
				this.speedX = - ballSpeedXMax;
				this.speedY = - ballSpeedYMax;
				console.log("najviac2");
			}	
			else if(this.speedY > 0 && player.id == 2) {
				this.speedX = - ballSpeedXMax;
				this.speedY = ballSpeedYMax;
				console.log("najviac2");
			}						
		}
		else if ((this.y >= player.y + playerHeight * 0.2 + 1 && this.y <= player.y + playerHeight * 0.4) || 
			(this.y >= player.y + playerHeight * 0.6 && this.y <= player.y + playerHeight * 0.8 - 1)) { 			// middle partts - 21 - 40 60 - 79
			if (this.speedY <= 0 && player.id == 1) {
				this.speedX = ballspeedXMid;
				this.speedY = - ballspeedYMid;
				console.log("menej ako najviac1");
			} 
			else if(this.speedY > 0 && player.id == 1) {
				this.speedX = ballspeedXMid;
				this.speedY = ballspeedYMid;
				console.log("menej ako najviac1");
			}
			else if(this.speedY <= 0 && player.id == 2) {
				this.speedX = - ballspeedXMid;
				this.speedY = - ballspeedYMid;
				console.log("menej ako najviac2");
			}	
			else if(this.speedY > 0 && player.id == 2) {
				this.speedX = -ballspeedXMid;
				this.speedY = ballspeedYMid;
				console.log("menej ako najviac2");
			}	
		}
		else if (this.y >= player.y + playerHeight * 0.4 + 1 && this.y <= player.y + playerHeight * 0.6 - 1) {	// most middle part - 41 - 59
			if (this.speedY <= 0 && player.id == 1) {
				this.speedX = ballSpeedXMin;
				this.speedY = ballSpeedYMin;
				console.log("stred 1");
			} 
			else if(this.speedY > 0 && player.id == 1){
				this.speedX = ballSpeedXMin;
				this.speedY = ballSpeedYMin;
				console.log("stred 1");
			}
			else if(this.speedY <= 0 && player.id == 2) {
				this.speedX = -(ballSpeedXMin);
				this.speedY = ballSpeedYMin;
				console.log("stred 2");
			}	
			else if(this.speedY > 0 && player.id == 2) {
				this.speedX = -(ballSpeedXMin);
				this.speedY = ballSpeedYMin;
				console.log("stred 2");
			}	
		}
	}

	this.reset = function(player) { // when ball touches the wall
		this.y = (canvasHeight * 0.2) + (Math.floor(Math.random() * (canvasHeight * 0.6)));
		this.x = canvasWidth / 2;
		if (player.id == 1) {
			this.speedY = speedY;
			this.speedX = speedX;
		} else if (player.id == 2) {
			this.speedY = speedY;
			this.speedX = - speedX;
		}
		
	}
}

function player(x, y, width, height, color, keyCodeUp, keyCodeDown, id) { // constructor for players
	this.id = id;
	this.x = x;
	this.y = y;
	this.width = width;
	this.height = height;
	this.speedY = 0;
	this.keyCodeUp = keyCodeUp;
	this.keyCodeDown = keyCodeDown;
	this.score = 0;
	this.update = function() {
		this.y += this.speedY;
		this.context = myCanvas.context;
		this.context.fillStyle = color;
		this.context.fillRect(this.x, this.y, width, height);
		this.speedY = 0;
	}
	this.checkUpperWall = function() { // checking the upper wall
		if (this.y <= 0) {
			return false;
		} else {
			return true;
		}		
	}	
	this.checkBottomWall = function() { // checking the bottom wall
		if (this.y >= canvasHeight - this.height) {
			return false;
		} else {
			return true;
		}
	}
	this.checkKey = function() { // checking if key is pressed and if player is colliding with a wall and then adding speed to Y coordinate
		if (myCanvas.keys) {
			if (myCanvas.keys[this.keyCodeUp] && this.checkUpperWall()) {
				this.speedY -= playerSpeed;
			}
			if (myCanvas.keys[this.keyCodeDown] && this.checkBottomWall()) {
				this.speedY += playerSpeed;
			}	
		}
	}
	this.reset = function() { // resseting position - unused atm
		this.y = (canvasHeight / 2) - (playerHeight / 2);
	}
	this.hasWon = function() { // ending game when one player has scoreToWin points
		if (this.score == scoreToWin) {
			myCanvas.stopGame();
			alert("P" + this.id + " won");
		}
	}
}

function uptadeCanvas() {	// cycle that is repeating
	firstPlayer.hasWon();
	secondPlayer.hasWon();

	myCanvas.clear();
	myCanvas.context.fillText(firstPlayer.score, 30, 100);
	myCanvas.context.fillText("P1", 30, 50);	
	myCanvas.context.fillText(secondPlayer.score, canvasWidth - 30 - fontSize / 2, 100);
	myCanvas.context.fillText("P2", canvasWidth - 30 - fontSize, 50);	

	firstPlayer.checkKey();
	firstPlayer.update();

	secondPlayer.checkKey();
	secondPlayer.update();

	middleLine.update();

	myBall.isNearAWall();
	myBall.bounceOnPlayer();
	myBall.update();
}

function checkParameters() {
	<?php
		$isEmpty = false;
		if (isset($parameters)) {
			foreach ($parameters as $key => $value) {
				if ($value == null) {
					$isEmpty = true;
				}
			}
		}
		if ($isEmpty == false) {
			echo "startGame();\n";
		} else {
			echo 'alert("You must fill in all the options or press apply parameters.");' . "\n";
		}
	?>
}

function startGame() {	// starting the game
	myCanvas.start();	
	myBall = new ball(ballRadius, canvasWidth / 2, canvasHeight / 2, "white", -ballSpeedXMin, ballSpeedYMin);
	firstPlayer = new player(15, (canvasHeight / 2) - (playerHeight / 2), playerWidth, playerHeight, "white", 87, 83, 1);
	secondPlayer = new player(canvasWidth - (playerWidth + 15), (canvasHeight / 2) - (playerHeight / 2), playerWidth, playerHeight, "white", 38, 40, 2);
	middleLine = new player((canvasWidth / 2) - middleLineWidth / 2, 0, middleLineWidth, canvasHeight, "white", 0, 0, 0);
}
</script>

</body>
</html>
-