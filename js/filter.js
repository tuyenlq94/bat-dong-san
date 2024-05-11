jQuery( function ( $ ) {
	function select_district() {
		var defaultDistrict = '<option value="">Chọn Quận/Huyện</option>';
		$( '#city' ).on( 'change', function () {
			var city = $( this ).find( 'option:selected' ).attr( 'data-ip' );
			var data = {
				action: 'display_district',
				city: city
			};
			$.post( filter.url, data ).done( function ( response ) {
				var options = get_options_from_response( response, defaultDistrict );
				$( '#districts' ).html( options ).val( null );
			} );
		} );
	}

	function get_options_from_response( response, defaultOptions ) {
		if ( response.success ) {
			var data = response.data;
			console.log( data );
			var districts = Object.entries( data );
			districts.forEach( entry => {
				const [ key, value ] = entry;
				defaultOptions += '<option value="' + key + '">' + value + '</option>';
			} );
		}
		return defaultOptions;
	}

	select_district();
} );