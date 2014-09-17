if (typeof($) == 'undefined') {
	$ = jQuery;
}

$(function () {
	wrapper = $('#easy_t_shortcode_generator');
	if (wrapper.length > 0)
	{
		var button = wrapper.find('#sc_generate');
		button.on('click', build_shortcode);
		enable_shortcode_highlighting();
		$('#sc_gen_use_slider').parent().bind('click', function () {
			toggle_slider_options();
		});
		toggle_slider_options();		
	}
});

function highlight_shortcode()
{
	$('#sc_gen_output').select();
}

function toggle_slider_options()
{
	var $opts_trs = $('tr.slider_option');
	var $val = get_value_from_input('#sc_gen_use_slider', 0, 'yes_or_no_to_0_or_1');
	if ($val == 1) {
		$opts_trs.removeClass('disabled');
	} else {
		$opts_trs.addClass('disabled');
	}
	
}

function enable_shortcode_highlighting()
{
	$('#sc_gen_output').bind('click', function ()
	{
		highlight_shortcode();
	});
}

function get_value_from_input (selector, default_value, filter)
{
	var trg = $(selector);
	var val = '';

	if ( trg.is(':checkbox') ) {
		val = ( $(selector).is(':checked') ? $(selector).val() : '' );
	} else {
		val = $(selector).val();
	}
	
	val = (val ? val : default_value);
	
	if (filter == 'int') {
		var temp_val  = parseInt(val + '' , 10 );
		if (isNaN(temp_val)) {
			return default_value;
		} else {
			return temp_val;
		}
	}
	else if (filter == 'convert_to_milliseconds') {
		var temp_val  = parseInt(val + '' , 10 );
		if (isNaN(temp_val)) {
			return default_value;
		} else {
			return temp_val * 1000;
		}
	}
	else if (filter == 'yes_or_no_to_0_or_1') {
		if (val == 'yes') {
			return 1;
		} else if (val == 'no' || val == '') {
			return 0;			
		} else {
			return default_value;
		}
	}
	else {
		return val;
	}
}

function add_attribute($key, $val, $orderby, $use_slider)
{
	if ($key == 'use_excerpt') {
		return ($val == 1) ? " use_excerpt='1'" : '';
	}
	else if ($key == 'pager') {
		if ($use_slider && $val == 1) {
			return " pager='1'";
		} else {
			return '';
		}	
	}
	else if ($key == 'show_title') {
		return ($val == 1) ? " show_title='1'" : '';
	}
	else if ($key == 'auto_fit_container') {
		return ($use_slider && $val == 1) ? " container='1'" : '';
	}
	else if ($key == 'show_thumbs') {
		return ($val == 1) ? " show_thumbs='1'" : '';
	}
	else if ($key == 'count') {
		return ($val > 1) ? " count='" + $val + "'" : '';
	}
	else if ($key == 'testimonials_per_slide') {
		return ($use_slider && $val > 1) ? " testimonials_per_slide='" + $val + "'" : '';
	}
	else if ($key == 'category') {
		return ($val != 'all') ? " category='" + $val + "'" : '';
	}
	else if ($key == 'show_rating') {
		return ($val != 'hide') ? " show_rating='" + $val + "'" : '';
	}
	else if ($key == 'orderby') {
		return ($val != '') ? " orderby='" + $val + "'" : '';
	}
	else if ($key == 'use_slider') {
		return '';
	}
	else if ($key == 'transition') {
		if ($use_slider) {
			return " transition='" + $val + "'";
		} else {
			return '';
		}
	}
	else if ($key == 'timer') {
		if ($use_slider) {
			return " timer='" + $val + "'";
		} else {
			return '';
		}
	}
	else if ($key == 'order') {
		if ($orderby !=='random' && $orderby !=='rand') {
			return " order='" + $val + "'";
		} else {
			return '';
		}
	}
	else {
		return " " + $key + "='" + $val + "'";
	}
}

function build_shortcode()
{
	// collect variables
	var $atts = [];
	var $str = '';
	$atts['count'] = get_value_from_input('#sc_gen_count', 10, 'int');
	$atts['orderby'] = get_value_from_input('#sc_gen_order_by', 'id');
	$atts['order'] = get_value_from_input('#sc_gen_order_dir', 'ASC');
	$atts['category'] = get_value_from_input('#sc_gen_category', 'all');
	$atts['show_title'] = get_value_from_input('#sc_gen_show_title', 0, 'yes_or_no_to_0_or_1');
	$atts['use_excerpt'] = get_value_from_input("input[name='sc_gen_use_excerpt']:checked", 1, 'yes_or_no_to_0_or_1');
	$atts['show_thumbs'] = get_value_from_input('#sc_gen_show_thumbs', 0, 'yes_or_no_to_0_or_1');
	$atts['show_rating'] = get_value_from_input("input[name='sc_gen_show_ratings']:checked", 'hide');
	$atts['use_slider'] = get_value_from_input('#sc_gen_use_slider', 0, 'yes_or_no_to_0_or_1');
	$atts['transition'] = get_value_from_input('#sc_gen_transition', 'fade');
	$atts['timer'] = get_value_from_input('#sc_gen_slider_timer', 4000, 'convert_to_milliseconds');
	$atts['testimonials_per_slide'] = get_value_from_input('#sc_gen_slider_testimonials_per_slide', 1, 'int');
	$atts['pager'] = get_value_from_input('#sc_gen_show_pager', 0, 'yes_or_no_to_0_or_1');
	$atts['auto_fit_container'] = get_value_from_input('#sc_gen_auto_fit_container', 0, 'yes_or_no_to_0_or_1');
	
	// begin with either "[testimonials", "[random_testimonial", or "[testimonial_cycle"
	$str = '[';
	$use_slider = false;
	if ($atts['use_slider'] == 1) 
	{
		if ($atts['order_by'] == 'random') {	
			$str += 'testimonials_cycle random="true"';
		} else {
			$str += 'testimonials_cycle';
		}
		$use_slider = true;
	}
	else if ($atts['orderby'] == 'random') {	
		$str += 'random_testimonial';
	}
	else {
		$str += 'testimonials';	
	}
	
	// next add each attribute according to the user supplied values
	var $a;
	for ($key in $atts) {
		$str += add_attribute($key, $atts[$key], $atts['orderby'], $use_slider);
	}
	
	// finally, close and display the shortcode
	$str += ']';
	$('#sc_gen_output').val($str);
	$('#sc_gen_output_wrapper').show();
	
	highlight_shortcode();
	
}

