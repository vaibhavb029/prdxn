jQuery(document).ready(function(){
  jQuery('#later').on("click", function(){
	var r = jQuery('#testimonial_reviewme').val();
	var data = {};
	data['reviewme'] = parseInt(r);
	data['action'] = 'testimonial_update_review_me';
	jQuery.post(ajaxurl, data, function(response) {
		if(response) {
			jQuery('#testimonial_reviewme').val(response);
		}
		jQuery('#reviewme').remove();
	 });
     });
  jQuery('#already').on("click", function(){
	var data = {};
	data['reviewme'] = 0;
	data['action'] = 'testimonial_update_review_me';
	jQuery.post(ajaxurl, data, function(response) {
		if(response) {
			jQuery('#testimonial_reviewme').val(response);
		}
		jQuery('#reviewme').remove();
	 });
   });
});
jQuery(function () {
  jQuery('.moreInfo').each(function () {
    // options
    var distance = 10;
    var time = 250;
    var hideDelay = 200;

    var hideDelayTimer = null;

    // tracker
    var beingShown = false;
    var shown = false;
    
    var trigger = jQuery('.trigger', this);
    var tooltip = jQuery('.tooltip', this).css('opacity', 0);
	
    // set the mouseover and mouseout on both element
    jQuery([trigger.get(0), tooltip.get(0)]).mouseover(function () {
      // stops the hide event if we move from the trigger to the tooltip element
      if (hideDelayTimer) clearTimeout(hideDelayTimer);

      // don't trigger the animation again if we're being shown, or already visible
      if (beingShown || shown) {
        return;
      } else {
        beingShown = true;

        // reset position of tooltip box
        tooltip.css({
          display: 'block' // brings the tooltip back in to view
        })

        // (we're using chaining on the tooltip) now animate it's opacity and position
        .animate({
          /*top: '-=' + distance + 'px',*/
          opacity: 1
        }, time, 'swing', function() {
          // once the animation is complete, set the tracker variables
          beingShown = false;
          shown = true;
        });
      }
    }).mouseout(function () {
      // reset the timer if we get fired again - avoids double animations
      if (hideDelayTimer) clearTimeout(hideDelayTimer);
      
      // store the timer so that it can be cleared in the mouseover if required
      hideDelayTimer = setTimeout(function () {
        hideDelayTimer = null;
        tooltip.animate({
          /*top: '-=' + distance + 'px',*/
          opacity: 0
        }, time, 'swing', function () {
          // once the animate is complete, set the tracker variables
          shown = false;
          // hide the tooltip entirely after the effect (opacity alone doesn't do the job)
          tooltip.css('display', 'none');
        });
      }, hideDelay);
    });
  });		
		/* Added for preview - start */
		var selpreview=jQuery("#testimonial_slider_preview").val();
		if(selpreview=='2')
			jQuery("#testimonial_slider_form .form-table tr.testimonial_slider_params").css("display","none");
		else if(selpreview=='1'){
			jQuery("#testimonial_slider_form .testimonial_sid").css("display","none");
			jQuery("#testimonial_slider_form .form-table tr.testimonial_slider_params").css("display","table-row");
			jQuery("#testimonial_slider_form .testimonial_catslug").css("display","block");
		}
		else if(selpreview=='0'){
			jQuery("#testimonial_slider_form .testimonial_catslug").css("display","none");
			jQuery("#testimonial_slider_form .form-table tr.testimonial_slider_params").css("display","table-row");
			jQuery("#testimonial_slider_form .testimonial_sid").css("display","block");
	 	}
		/* Added for preview - end */
		
});
/* Added for preview */
function checkpreview(curr_preview){
	if(curr_preview=='2')
		jQuery("#testimonial_slider_form .form-table tr.testimonial_slider_params").css("display","none");
	else if(curr_preview=='1'){
		jQuery("#testimonial_slider_form .testimonial_sid").css("display","none");
		jQuery("#testimonial_slider_form .form-table tr.testimonial_slider_params").css("display","table-row");
		jQuery("#testimonial_slider_form .testimonial_catslug").css("display","block");
	}
	else if(curr_preview=='0'){
		jQuery("#testimonial_slider_form .testimonial_catslug").css("display","none");
		jQuery("#testimonial_slider_form .form-table tr.testimonial_slider_params").css("display","table-row");
		jQuery("#testimonial_slider_form .testimonial_sid").css("display","block");
	}
}
/* End Of preview */

