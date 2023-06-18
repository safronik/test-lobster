

function firework(){

}

function ajax(route, data, callback, timeout){

	timeout = timeout || 15000;

	let errorHandler = function( msg ){
		alert('Ошибонька: ' + msg);
		console.log( '%cERROR', 'color: red;' );
		console.log( msg );
	}

	jQuery.ajax({
			type:     "GET",
			url:      ajax_url + route,
			data:     data,
			dataType: 'json',
			success:  function(result){
				if(result.error){
					errorHandler(result.error);
				}else if(callback){
					callback(result, data);
				}else{
					errorHandler( 'No callback defined');
				}
			},
			error:    function (jqXHR, textStatus, errorThrown) {
				errorHandler(textStatus);
			},
			timeout:  timeout,
	});
}