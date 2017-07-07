<!DOCTYPE html>
<html>
<head>
	<title>異常回報</title>
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.css" />
	<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script>
	<script type="text/javascript">
		var isSign = false;
		var leftMButtonDown = false;
		
		jQuery(function(){
			init_Sign_Canvas();
			$('#submit_btn').prop('disabled', true);
		});
		
		function fun_submit() {
			if(isSign) {
				var canvas = $("#canvas").get(0);
				var imgData = canvas.toDataURL();
				jQuery('#signature_pad').find('p').remove();
				jQuery('#signature_pad').find('img').remove();
				jQuery('#signature_pad').append(jQuery('<p>簽章</p>'));
				jQuery('#signature_pad').append($('<img/>').attr('src', imgData));
				$('#signature').val(canvas.toDataURL());
				$('#submit_btn').prop('disabled', false);
			} else {
				alert('請簽章！');
			}
		}

		function init_Sign_Canvas() {
			isSign = false;
			leftMButtonDown = false;

			var sizedWindowWidth = $(window).width();
			if(sizedWindowWidth > 700)
				sizedWindowWidth = $(window).width() / 2;
			else if(sizedWindowWidth > 400)
				sizedWindowWidth = sizedWindowWidth - 100;
			else
				sizedWindowWidth = sizedWindowWidth - 50;
			 
			 $("#canvas").width(sizedWindowWidth);
			 $("#canvas").height(200);
			 $("#canvas").css("border", "1px solid #000");
			
			 var canvas = $("#canvas").get(0);
			
			 canvasContext = canvas.getContext('2d');

			 if(canvasContext)
			 {
				 canvasContext.canvas.width  = sizedWindowWidth;
				 canvasContext.canvas.height = 200;

				 canvasContext.fillStyle = "#fff";
				 canvasContext.fillRect(0, 0, sizedWindowWidth, 200);
				 
				 canvasContext.moveTo(50, 150);
				 canvasContext.lineTo(sizedWindowWidth-50, 150);
				 canvasContext.stroke();
				
				 canvasContext.fillStyle = "#000";
				 canvasContext.font="20px DFKai-sb";
			 }

			 $(canvas).on('mousedown', function (e) {
				 if(e.which === 1) { 
					 leftMButtonDown = true;
					 canvasContext.fillStyle = "#000";
					 var x = e.pageX - $(e.target).offset().left;
					 var y = e.pageY - $(e.target).offset().top;
					 canvasContext.moveTo(x, y);
				 }
				 e.preventDefault();
				 return false;
			 });
			
			 $(canvas).on('mouseup', function (e) {
				 if(leftMButtonDown && e.which === 1) {
					 leftMButtonDown = false;
					 isSign = true;
				 }
				 e.preventDefault();
				 return false;
			 });

			 $(canvas).on('mousemove', function (e) {
				 if(leftMButtonDown == true) {
					 canvasContext.fillStyle = "#000";
					 var x = e.pageX - $(e.target).offset().left;
					 var y = e.pageY - $(e.target).offset().top;
					 canvasContext.lineTo(x,y);
					 canvasContext.stroke();
				 }
				 e.preventDefault();
				 return false;
			 });

			 $(canvas).on('touchstart', function (e) {
				leftMButtonDown = true;
				canvasContext.fillStyle = "#000";
				var t = e.originalEvent.touches[0];
				var x = t.pageX - $(e.target).offset().left;
				var y = t.pageY - $(e.target).offset().top;
				canvasContext.moveTo(x, y);
				
				e.preventDefault();
				return false;
			 });
			 
			 $(canvas).on('touchmove', function (e) {
				canvasContext.fillStyle = "#000";
				var t = e.originalEvent.touches[0];
				var x = t.pageX - $(e.target).offset().left;
				var y = t.pageY - $(e.target).offset().top;
				canvasContext.lineTo(x,y);
				canvasContext.stroke();
				
				e.preventDefault();
				return false;
			 });
			 
			 $(canvas).on('touchend', function (e) {
				if(leftMButtonDown) {
					leftMButtonDown = false;
					isSign = true;
				}
			 
			 });
		}
	</script>
	<style>
		.alert {
			padding: 20px;
			background-color: #4CAF50;
			color: white;
		}

		.closebtn {
			margin-left: 15px;
			color: white;
			font-weight: bold;
			float: right;
			font-size: 22px;
			line-height: 20px;
			cursor: pointer;
			transition: 0.3s;
		}

		.closebtn:hover {
			color: black;
		}
	</style>
</head>
<body>
	<div data-role="page">
		<div data-role="header">
			<h1>異常回報</h1>
		</div>
		<div id="page" data-role="content">
			@if ($msg = Session::get('success'))
				<div class="alert success">
					<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
					<strong>{{ $msg }}</strong>請返回APP繼續檢核。
				</div>
			@else
			<form method="post" action="{{ url('/api/Sign') }}">
				<canvas id="canvas"></canvas>
				<div id="signature_pad"></div>
				<input type="hidden" id="eqpt_id" name="eqpt_id" value="{{ $eqpt_id }}">
				<input type="hidden" id="form_id" name="form_id" value="{{ $form_id }}">
				<input type="hidden" id="username" name="username" value="{{ $username }}">
				<input type="hidden" id="token" name="token" value="{{ $token }}">
				<input type="hidden" id="signature" name="signature">
				<input type="button" data-inline="true" value="簽章" onclick="fun_submit()" />
				<input type="button" data-inline="true" value="清除" onclick="init_Sign_Canvas()" />
				<input type="submit" id="submit_btn" data-inline="true" value="送出">
			</form>
			@endif
		</div>
	</div>	
</body>
</html>