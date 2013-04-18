jQuery(document).ready(function() {

	jQuery("a[rel^='prettyPhoto']").prettyPhoto({ 
		show_title: false, 
		deeplinking: false,
		social_tools: false,
		theme: 'light_rounded', 
		counter_separator_label: ' of ',
		allow_resize: true
		});	
	
	if (jQuery("div.widget_style").length) {
		jQuery("div.widget_style").jCarouselLite({
			btnPrev: ".previous",
			btnNext: ".next",
			circular: true,
			visible: 4
		});
	}
			
	jQuery("div.widget_style img").click(function() {
		jQuery("img.large-image").attr("src", jQuery(this).attr("src").replace(/_ts.jpg/g,'_m.jpg') );	
		
		jQuery("a.large-image").attr("href", jQuery(this).attr("src").replace(/_ts\.jpg/g,'_l.jpg') );
		jQuery("a.large-image").attr("title", jQuery(this).attr("title"));
		
		jQuery("a.ehive-magnifying-glass").attr("href", jQuery(this).attr("src").replace(/_ts\.jpg/g,'_l.jpg') );
		jQuery("a.ehive-magnifying-glass").attr("title", jQuery(this).attr("title"));		
	});
						
	
	jQuery("div.ehive-object-multiple-images div.ehive-images-tiny-square img").click(function() {

		jQuery("img.large-image").attr("src", jQuery(this).attr("src").replace(/_ts.jpg/g,'_m.jpg') );

		jQuery("a.large-image").attr("href", jQuery(this).attr("src").replace(/_ts\.jpg/g,'_l.jpg') );
		jQuery("a.large-image").attr("title", jQuery(this).attr("title"));
				
		jQuery("a.ehive-magnifying-glass").attr("href", jQuery(this).attr("src").replace(/_ts\.jpg/g,'_l.jpg') );
		jQuery("a.ehive-magnifying-glass").attr("title", jQuery(this).attr("title"));
	});
	
});