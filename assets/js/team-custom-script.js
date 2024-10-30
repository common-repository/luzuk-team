jQuery(document).ready(function(){

	jQuery( '.ltcolor-field' ).wpColorPicker();
	
	jQuery('.team-admin-tab li:nth-child(1)').addClass('active');
	jQuery('#team-maintab1').addClass('active');

	jQuery('.team-admin-tab li').click(function(){
		jQuery('.team-admin-tab li').removeClass('active');
		jQuery('#team-maintab1').removeClass('active');
		jQuery('.team-tab-content-wrap').removeClass('active');

		jQuery(this).addClass('active');
		let current_tab = jQuery(this).attr('team-id');
		jQuery('#' + current_tab).addClass('active');
		
	});

});


// pages
jQuery(document).ready(function(){

	jQuery( '.ltcolor-field' ).wpColorPicker();
	
	jQuery('.team-admin-tabpages li:nth-child(1)').addClass('active');
	jQuery('#team-inertabpages').addClass('active');

	jQuery('.team-admin-tabpages li').click(function(){
		jQuery('.team-admin-tabpages li').removeClass('active');
		jQuery('#team-inertabpages').removeClass('active');
		jQuery('.team-tab-content-wrappages').removeClass('active');

		jQuery(this).addClass('active');
		let current_tab = jQuery(this).attr('team-idpages');
		jQuery('#' + current_tab).addClass('active');
		
	});

});


// slider
jQuery(document).ready(function(){

	jQuery( '.ltcolor-field' ).wpColorPicker();
	
	jQuery('.team-admin-tabslider li:nth-child(1)').addClass('active');
	jQuery('#team-inertabslider').addClass('active');

	jQuery('.team-admin-tabslider li').click(function(){
		jQuery('.team-admin-tabslider li').removeClass('active');
		jQuery('#team-inertabslider').removeClass('active');
		jQuery('.team-tab-content-wrapslider').removeClass('active');

		jQuery(this).addClass('active');
		let current_tab = jQuery(this).attr('team-idslider');
		jQuery('#' + current_tab).addClass('active');
		
	});

});




jQuery(document).ready(function(){

	jQuery( '.ltcolor-field' ).wpColorPicker();
	
	jQuery('.team-admin-tabclr li:nth-child(1)').addClass('active');
	jQuery('#team-tab1').addClass('active');

	jQuery('.team-admin-tabclr li').click(function(){
		jQuery('.team-admin-tabclr li').removeClass('active');
		jQuery('#team-tab1').removeClass('active');
		jQuery('.team-tab-content-wrapclr').removeClass('active');

		jQuery(this).addClass('active');
		let current_tab = jQuery(this).attr('team-idclr');
		jQuery('#' + current_tab).addClass('active');
		
	});

});





/* tab dashboard content */
// main tabs
jQuery(document).ready(function(){
    
    jQuery('.lzteam-block-tab li:nth-child(1)').addClass('active');
    jQuery('#lzteamblock1').addClass('active');

    jQuery('.lzteam-block-tab li').click(function(){

    });

    jQuery('.lzteam-block-tab li').click(function(){
        jQuery('.lzteam-block-tab li').removeClass('active');
        jQuery('#lzteamblock1').removeClass('active');
        jQuery('.lzteamblock-content-wrap').removeClass('active');

        jQuery(this).addClass('active');
        let current_tab = jQuery(this).attr('tblock-id');
        jQuery('#' + current_tab).addClass('active');

    });

});