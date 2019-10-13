import { Foundation } from 'foundation-sites/js/foundation.core';
import { Toggler } from 'foundation-sites/js/foundation.toggler';

Foundation.addToJquery(jQuery);
Foundation.plugin(Toggler);

(function($) {

	console.log('i am alive in main', Toggler);


	$(function() {

		var $toggler = new Toggler($('#Panel'));
		$(document).foundation();
		// $('#NavTrigger').click(() => {
		// 	console.log('wtf');
		// 	$toggler.toggle();
		// });
		console.log('home', $toggler);

	});


})(jQuery);