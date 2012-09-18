<?php 
	// https://github.com/squeeks/Pusher-PHP
	require('/var/www/html/application/libraries/Pusher/lib/Pusher.php');

	$key = '131de32e0bed65790199';
	$secret = '69d5b8a4d4f0696b3c7a';
	$app_id = '27903';

	$pusher = new Pusher($key, $secret, $app_id);
	//$pusher->trigger('my-channel', 'my-event', array('message' => 'hello world') );
?>

<div class="row" style="margin-top:2em;">
	<div class="six columns">
		<!-- image -->
		<div style="margin-bottom: 2em;">
			<img src="<?php echo $image; ?>" style="height:500px;"/>
		</div>
		<!-- description -->
		<div class="panel" style="margin-bottom: 2em;">
			<?php echo $description; ?>
		</div>
	</div>
	<div class="six columns">
		<!-- timer -->
		<div id="javascript_countdown_time" style="margin-bottom: 0.5em;font-size: 37px;color:red;padding: 2em;border-radius: 4px;background-color: #F7F7F7;text-align: center;"></div>
		<!-- button -->
		<a href="#" class="button" id="bid" style="margin-bottom: 0.5em;font-size:22px;">5</a> <span style="font-size:22px;">+ 2 €</span>
		<span class="panel"><span style="font-size: 22px;">Bids:</span><span id="actual_bid" style="font-size: 22px;">5</span>€</span>
		<div class="panel" style="min-height: 400px;">
			<ul id="bids">
				<h1>Bids</h1>
				<li id="bids-li"></li>
			</ul>
		</div>
		<br/>
		<!-- activity -->
		
	</div>
</div>
<div class="row">
	<div class="twelve columns">
		<!-- people -->
	</div>
</div>

<script>
	var pusher = new Pusher('131de32e0bed65790199'); // Replace with your app key
	var channel = pusher.subscribe('my-channel');
	var base_url = 'http://sldm.co/';
	
	channel.bind('my-event', function(data) {
		var user = '<?php echo $this->session->userdata('fb_username'); ?>';
		var b = '<p>' + user + ' bids ' + data.message + ' €</p>';
	  $('#bids-li').after(b);
	  $('#actual_bid').html(data.message);
	  $('#bid').html(data.message);
	  javascript_countdown.reset(60, 'javascript_countdown_time');
	});
	
	$("#bid").click(function() {
		var msg = parseInt($('#bid').html()) + 2;
  		$.ajax({
		  type: "GET",
		  url: base_url + "auction/push/" + msg,
		}).done(function( msg ) {
		});
	});
</script>

<script>
	var javascript_countdown = function () {
	var time_left = 10; //number of seconds for countdown
	var output_element_id = 'javascript_countdown_time';
	var keep_counting = 1;
	var no_time_left_message = 'Bid is over!!!';
 
	function countdown() {
		if(time_left < 2) {
			keep_counting = 0;
		}
 
		time_left = time_left - 1;
	}
 
	function add_leading_zero(n) {
		if(n.toString().length < 2) {
			return '0' + n;
		} else {
			return n;
		}
	}
 
	function format_output() {
		var hours, minutes, seconds;
		seconds = time_left % 60;
		minutes = Math.floor(time_left / 60) % 60;
		hours = Math.floor(time_left / 3600);
 
		seconds = add_leading_zero( seconds );
		minutes = add_leading_zero( minutes );
		hours = add_leading_zero( hours );
 
		return hours + ':' + minutes + ':' + seconds;
	}
 
	function show_time_left() {
		document.getElementById(output_element_id).innerHTML = format_output();//time_left;
	}
 
	function no_time_left() {
		document.getElementById(output_element_id).innerHTML = no_time_left_message;
		$('#bid').remove();
	}
 
	return {
		count: function () {
			countdown();
			show_time_left();
		},
		timer: function () {
			javascript_countdown.count();
 
			if(keep_counting) {
				setTimeout("javascript_countdown.timer();", 1000);
			} else {
				no_time_left();
			}
		},
		//Kristian Messer requested recalculation of time that is left
		setTimeLeft: function (t) {
			time_left = t;
			if(keep_counting == 0) {
				javascript_countdown.timer();
			}
		},
		init: function (t, element_id) {
			time_left = t;
			output_element_id = element_id;
			javascript_countdown.timer();
		},
		reset: function (t, element_id) {
			time_left = t;
			output_element_id = element_id;
		}
	};
}();
 
//time to countdown in seconds, and element ID
javascript_countdown.init(60, 'javascript_countdown_time');
</script>