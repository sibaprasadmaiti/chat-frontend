<!DOCTYPE html>
<html lang="en">

<head>
	<title>Client ChatRoom</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- <script>
		var name = prompt("Please enter your name");
	</script> -->
	<style>
		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}

		#intro {
			background-color: #008000;
			color: #FFFFFF;
			height: 5%;
		}


		body {
			font: 20px;
		}



		.chat-form {
			background: #000000;
			padding: 3px;
			position: fixed;
			bottom: 5px;
			width: 100%;
		}

		form input {
			background-color: #e6ffe6;
			border: 0;
			padding: 10px;
			width: 90%;
			margin-right: 0.5%;
		}

		.chat-submit-btn {
			width: 9%;
			background: #00e600;
			border: none;
			padding: 5px;
			font-size: 20px;
		}

		#messages {

			margin: 0;
			padding: 0;

		}

		#messages li {
			padding: 5px 10px;
		}

		#messages li:nth-child(odd) {
			background: #b3ffb3;
		}


		#list {
			text-align: right;
		}

		.page_content {
			display: none;
		}
	</style>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
	<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script> -->
</head>

<body>
	<div class="page_content">
		<div id="intro">
			<h1>Client ChatRoom</h1>
		</div>

		<ul id="messages"></ul>

		<form class="chat-form" action="">
			<input id="m" placeholder="Enter your message..." autocomplete="off" required />
			<input type="hidden" name="userId" id="userId" value="">
			<input type="hidden" name="storeId" id="storeId" value="">
			<button class="chat-submit-btn">Send</button>
		</form>
	</div>


	<!-- Button trigger modal -->
	<div class="call_holder" style="text-align: center;margin: 218px;">
		<button type="button" id="startChatBtn" class="btn btn-primary call_button">
			Start Chat
		</button>
	</div>

	<!-- Modal -->
	<div class="" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Chat</h5>
					<!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button> -->
				</div>
				<form id="firstForm" action="" method="post" onsubmit="return false">
					<div class="modal-body">

						<div class="form-group">
							<input type="text" class="form-control" name="name" placeholder="Name">
						</div>
						<div class="form-group">
							<input type="email" class="form-control" name="email" placeholder="Email">
						</div>
						<div class="form-group">
							<input type="text" class="form-control" name="contact_no" placeholder="Contact No.">
						</div>
						<div class="form-group">
							<textarea class="form-control" name="first_message" rows="3" placeholder="write message here..."></textarea>
						</div>
					</div>

					<div class="modal-footer">
						<!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
						<button type="submit" class="btn btn-primary">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.5.0/socket.io.js"></script>
	<!-- <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script> -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	
	<script>
		var ENDPOINT = "http://localhost:3000"
		var socket = io(ENDPOINT);
		socket.emit('site visit', null);

		$('#firstForm').submit(function() {
			$("#exampleModal").hide();
			var values = {};
			$.each($('#firstForm').serializeArray(), function(i, field) {
				values[field.name] = field.value;
			});
			socket.emit('joining msg', values);
			$('#messages').append($('<li id="list">').html('<span>Name:  ' + values.name + '</span></br>' + '<span>Email:  ' + values.email + '</span></br><span>Contact No:  ' + values.contact_no + '</span></br><span>Message:  ' + values.first_message + '</span>'));
			$('#m').val('');
			$(".close").trigger("click");
			$(".page_content").fadeToggle();
		});


		$('.chat-form').submit(function(e) {
			e.preventDefault(); // will prevent page reloading
			// socket.emit('chat message', (name + ':  ' + $('#m').val()));
			socket.emit('chat message', ({
				"userId": $('#userId').val(),
				"storeId": $('#storeId').val(),
				"clientMsg": $('#m').val(),
				"msgType": "receiver"
			}));
			$('#messages').append($('<li id="list">').text($('#m').val()));
			$('#m').val('');
			return false;
		});

		socket.on('chat message', function(msg) {
			$('#messages').append($('<li>').text(msg));
			let x = document.cookie;
			console.log(x);
		});

		socket.on('first message', function(msg) {
			console.log(msg);
			$('#userId').val(msg.userId);
			$('#storeId').val(msg.storeId);

			document.cookie = "userId=" + msg.userId;
			document.cookie = "storeId=" + msg.storeId;
			
		});


		$(".call_button").click(function() {
			let getCookie = document.cookie;
			let getCookieArr = getCookie.split(";");
			let userId = getCookie && getCookieArr[0].split("=")[1] ? getCookieArr[0].split("=")[1] : 0;
			let storeId = getCookie && getCookieArr[1].split("=")[1] ? getCookieArr[1].split("=")[1] : 0;

			socket.emit('check message', {
				"user_id": userId,
				"store_id": storeId
			});
			socket.on('check client chat data', function(msg) {
				console.log(msg);
				if (getCookie && msg.length > 0) {
					console.log(123);
					//$('#messages').append($('<li id="list">').html('<span>Name:  ' + msg[0].name + '</span></br>' + '<span>Email:  ' + msg[0].email + '</span></br><span>Contact No:  ' + msg[0].mobile_no + '</span></br><span>Message:  ' + msg[0].message + '</span>'));
					var html = "";
					$.each(msg[0].chat_messages, function(key, val) {
						// console.log("key => ", key);
						// console.log("val => ", val);

						if (val.type == "receiver") {
							$('#messages').append($('<li id="list">').text(val.message));
						} else {
							$('#messages').append($('<li>').text(val.message));
						}
					});

					$(".page_content").fadeToggle();
					$(".call_holder").hide();
				} else {
					console.log(789);
					$("#exampleModal").show();

					$(".call_holder").hide();
				}
			});

		});

		function setCookie(cname, cvalue, exdays) {
			const d = new Date();
			d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
			let expires = "expires=" + d.toUTCString();
			document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
		}
	</script>
</body>

</html>