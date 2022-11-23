(function(window, document, $, undefined){

	var woosat = {};

	woosat.init = function() {

		if( window.wooSatVars.is_composite && window.wooSatVars.is_composite === '1' ) {
			woosat.compositeVariationListener();
		} else {
			woosat.singleVariationListener();
		}

	}

	// listens for variation change, sends ID as necessary
	woosat.singleVariationListener = function() {

		$( ".single_variation_wrap" ).on( "show_variation", function ( event, variation ) {
		    // Fired when the user selects all the required dropdowns / attributes
		    // and a final variation is selected / shown
		    if( variation.variation_id ) {
			    var id = variation.variation_id;
			    $(".hwp-sat span").text(window.wooSatVars.variation_sats[id]);
			}
		} );

	}

	// listens for variation change, sends ID as necessary
	woosat.compositeVariationListener = function() {

		$( ".single_variation_wrap" ).on( "show_variation", function ( event, variation ) {
		    // Fired when the user selects all the required dropdowns / attributes
		    // and a final variation is selected / shown

		    if( variation.variation_id ) {
			    var id = variation.variation_id;

			    $(".hwp-sat span").text( window.wooSatVars.composite_variation_sats[id] );
			}
		} );

	}

	woosat.init();

	window.wooSat = woosat;

})(window, document, jQuery);