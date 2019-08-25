$(document).ready(function() {

	
	$("#start_game").click(
		function() {
			var data = {};
			data.fn = "start_game";
			var dataJson = JSON.stringify(data);
			sendAjax(dataJson, 'start_game' );
		}
	);
		
	$("#make_quess").click(
		function() {
			var theNumber = parseInt($('#my_quess').val(), 10);
			if ( !Number.isInteger( theNumber ) 
				|| theNumber < 0 || theNumber > 1000
			) {
				alert( numberError );
				return;
			}
			var data = {};
			data.fn = "make_quess";
			data.number = $('#my_quess').val() 
			var dataJson = JSON.stringify(data);
			sendAjax(dataJson, 'make_quess' );
		}
	);
		
		
	
});

function sendAjax(dataJson, fnName) {
	$.ajax({
		type: "POST",
		url: "index.php",
		dataType: "json",
		data: { data: dataJson },
		success: function(msg) {

			if ( 'ok' == msg.status ) {
				if ('start_game' === fnName) {
					doAfterStart(msg);
				}
				if ('make_quess' === fnName) {
					doAfterQuess(msg);
				}
			} else {
				// TODO: deal with errors
			}
			
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			alert("Status: " + textStatus); alert("Error: " + errorThrown);
		}
	});
}

function doAfterStart(msg) {
	$('.game_btn').hide();
	$('#block_quess').show();
	$('#my_quess').val( '' ) ;
}

function doAfterQuess(msg) {
	$('.game_btn').hide();
	const nr = $('#my_quess').val();
	if ( 0 !== msg.answer ) {
		$('#block_quess').show();
		if ( -1 === msg.answer ) {
			$('#block_small').show();
			$('#nr_small').html( nr );
		} else {
			$('#block_big').show();
			$('#nr_big').html( nr );
		}
	} else {
		$('#block_start').show();
		$('#block_the_number').show();
		$('#nr_ok').html( nr );
	}
	
	
}