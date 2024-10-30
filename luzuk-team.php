<?php
/*
Plugin Name: Luzuk Team
Plugin URI: 
Description: Luzuk Team is a plugin to create your own team member section. Its an amazing tool to showcsae your team members in diffrent layouts. You can add this shortcode [luzukteam_innerpage] for inner page and [luzukteam_slider] for home page.
Version: 0.1.0
Requires at least: 5.2
Requires PHP:      7.2
Author: Luzuk
Author URI: https://www.luzuk.com
Text Domain: luzuk-team
License: GPLv2
*/

//defining path 

define( 'LTSMP_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'LTSMP_DIR_URL', plugin_dir_url( __FILE__ ) );


$ltsmp_options=[];

if(get_option('ltsmp_options')){
  $ltsmp_options = get_option('ltsmp_options');
}


// Dynamic styles
require LTSMP_DIR_PATH . 'includes/style.php';

// Active plugin
function ltsmp_slider_activation() {
}
register_activation_hook(__FILE__, 'ltsmp_slider_activation');

// Deactive plugin
function ltsmp_slider_deactivation() {
}
register_deactivation_hook(__FILE__, 'ltsmp_slider_deactivation');




// Added styles css
add_action('wp_enqueue_scripts', 'ltsmp_styles');
function ltsmp_styles() {

    wp_register_style('lt_style', plugins_url('assets/css/style.css', __FILE__));
    wp_enqueue_style('lt_style');

    wp_register_style('lt_teammember_style', plugins_url('assets/css/teammember.min.css', __FILE__));
    wp_enqueue_style('lt_teammember_style');

    wp_register_style('lt_fontawesome_style', plugins_url('assets/css/all.css', __FILE__));
    wp_enqueue_style('lt_fontawesome_style');

    wp_register_style('lteamowl_teamcarousel_min_style', plugins_url('assets/css/lteamowl.teamcarousel.min.css', __FILE__));
    wp_enqueue_style('lteamowl_teamcarousel_min_style');

    wp_register_style('lteamowl_teamcarousel_mindefault_style', plugins_url('assets/css/lteamowl.team.default.min.css', __FILE__));
    wp_enqueue_style('lteamowl_teamcarousel_mindefault_style');

    wp_register_style('teamsimpletagination', plugins_url('assets/css/TeamsimplePagination.css', __FILE__));
    wp_enqueue_style('teamsimpletagination');


}

// Added script
add_action('wp_enqueue_scripts', 'ltsmp_scripts');
function ltsmp_scripts() {


    wp_register_script('jquery', plugins_url('assets/js/luzukteam.min.js', __FILE__),array("jquery"));
    wp_enqueue_script('jquery');

    wp_register_script('team_simplePagination', plugins_url('assets/js/team.simplePagination.js', __FILE__),array("jquery"));
    wp_enqueue_script('team_simplePagination');

    wp_register_script('lteamowl_carousel', plugins_url('assets/js/lteamowl.team.carousel.js', __FILE__),array("jquery"));
    wp_enqueue_script('lteamowl_carousel');


}



add_action('admin_enqueue_scripts', 'ltsmp_admin_styles');
function ltsmp_admin_styles() {
    wp_enqueue_style( 'wp-color-picker' ); 
    wp_enqueue_script( 'wp-color-picker' ); 
    wp_enqueue_script('team_custom_script', plugins_url('assets/js/team-custom-script.js', __FILE__),array("jquery"));
    wp_enqueue_script('team_custom_script');

    wp_register_style('team_custom_style', plugins_url('assets/css/team-custom-script.css', __FILE__));
    wp_enqueue_style('team_custom_style');

}



// Dynamic colors 
function ltsmp_lite_scripts() {
    wp_enqueue_style( 'luzuk-premium-style', get_stylesheet_uri() );
    $handle = 'luzuk-premium-style';
    $custom_css = ltsmp_totallt_dymanic_styles();
    wp_add_inline_style( $handle, $custom_css );
}
add_action( 'wp_enqueue_scripts', 'ltsmp_lite_scripts' );

// Dynamic colors patterns 
function ltsmp_css_strip_whitespace($css){
  $replace = array(
    "#/\*.*?\*/#s" => "",  // Strip C style comments.
    "#\s\s+#"      => " ", // Strip excess whitespace.
  );
  $search = array_keys($replace);
  $css = preg_replace($search, $replace, $css);

  $replace = array(
    ": "  => ":",
    "; "  => ";",
    " {"  => "{",
    " }"  => "}",
    ", "  => ",",
    "{ "  => "{",
    ";}"  => "}", // Strip optional semicolons.
    ",\n" => ",", // Don't wrap multiple selectors.
    "\n}" => "}", // Don't wrap closing braces.
    "} "  => "}\n", // Put each rule on it's own line.
  );
  $search = array_keys($replace);
  $css = str_replace($search, $replace, $css);
  return trim($css);
}

// Adding Custome Post Type
function ltsmp_create_custome_types_team() {
// team
    register_post_type( 'our-lteam',
        array(
            'labels' => array(
                'name' => __( 'Luzuk Team' , 'team-members-and-slider'),
                'singular_name' => __( 'Team Members', 'team-members-and-slider' )
            ),
            'public' => true,
            'featured_image'=>true,
            'has_archive' => true,
            'menu_icon' => 'dashicons-groups', //  The url to the icon to be used for this menu or the name of the icon from the iconfont
            'supports' => array('title', 'thumbnail','editor', 'author', 'page-attributes'),
        )
    );

    

}

// post type initialize
add_action( 'init', 'ltsmp_create_custome_types_team' );



/**
  * Custom Post Type add Subpage to Custom Post Menu
  * @description- Luzuk Team Custom Post Type Submenu Example
  * 
  *
  */
 
// Hook   
 
add_action('admin_menu', 'ltsmp_add_our_lteam_cpt_submenu');
 
//admin_menu callback function
 
function ltsmp_add_our_lteam_cpt_submenu(){
 
    add_submenu_page(
         'edit.php?post_type=our-lteam', //$parent_slug
         'Luzuk Team',  //$page_title
         'Settings',        //$menu_title
         'manage_options',           //$capability
         'ltsmp_tutorial_subpage_example',//$menu_slug
         'ltsmp_our_lteam_subpage_render_page'//$function
    );
 
}
 


function lteamp_select_template() {
    add_option( 'ltfp_option_sel_template', 'TeamTemplate1');
    register_setting( 'ltsmp-plugin-option', 'ltfp_option_sel_template', 'lsfp_callback' );
}
add_action( 'admin_init', 'lteamp_select_template' );



function lteamp_select_slidertemplate() {
    add_option( 'ltfp_option_sel_slidertemplate', 'TeamSliderTemplate1');
    register_setting( 'ltsmp-plugin-option', 'ltfp_option_sel_slidertemplate', 'lsfp_callback' );
}
add_action( 'admin_init', 'lteamp_select_slidertemplate' );


function lteamp_select_postno() {
    add_option( 'lteamp_postno', '12');
    register_setting( 'ltsmp-plugin-option', 'lteamp_postno', 'lsfp_callback' );
}
add_action( 'admin_init', 'lteamp_select_postno' );


function lteamp_select_sliderpostno() {
    add_option( 'teamsliderpostnumber', '4');
    register_setting( 'ltsmp-plugin-option', 'teamsliderpostnumber', 'lsfp_callback' );
}
add_action( 'admin_init', 'lteamp_select_sliderpostno' );


function lteamp_select_sliderarrowonoff() {
    add_option( 'ltfp_teamarrow', 'true');
    register_setting( 'ltsmp-plugin-option', 'ltfp_teamarrow', 'lsfp_callback' );
}
add_action( 'admin_init', 'lteamp_select_sliderarrowonoff' );



function lteamp_select_sliderdotonoff() {
    add_option( 'ltfp_teamdot', 'true');
    register_setting( 'ltsmp-plugin-option', 'ltfp_teamdot', 'lsfp_callback' );
}
add_action( 'admin_init', 'lteamp_select_sliderdotonoff' );


function lteamp_timedelay() {
    add_option( 'teamslidertransitionduration', '4');
    register_setting( 'ltsmp-plugin-option', 'teamslidertransitionduration', 'lsfp_callback' );
}
add_action( 'admin_init', 'lteamp_timedelay' );



//add_submenu_page callback function
 
function ltsmp_our_lteam_subpage_render_page() {
    global $title;
    global $ltsmp_options; 

  
    /* -------- slider ---------- */

    if(isset($ltsmp_options['slider_name_clr'])){
        $ltsmp_options['slider_name_clr'] = $ltsmp_options['slider_name_clr'];
    }else{
        $ltsmp_options['slider_name_clr'] = "#000000";
    }

    if(isset($ltsmp_options['slider_dsignt_clr'])){
        $ltsmp_options['slider_dsignt_clr'] = $ltsmp_options['slider_dsignt_clr'];
    }else{
        $ltsmp_options['slider_dsignt_clr'] = "#000000";
    }

    if(isset($ltsmp_options['sliderarrowcolor'])){
        $ltsmp_options['sliderarrowcolor'] = $ltsmp_options['sliderarrowcolor'];
    }else{
        $ltsmp_options['sliderarrowcolor'] = "#773afd";
    }

    if(isset($ltsmp_options['sliderarrowhovercolor'])){
        $ltsmp_options['sliderarrowhovercolor'] = $ltsmp_options['sliderarrowhovercolor'];
    }else{
        $ltsmp_options['sliderarrowhovercolor'] = "#000000";
    }

    if(isset($ltsmp_options['sliderdotcolor'])){
        $ltsmp_options['sliderdotcolor'] = $ltsmp_options['sliderdotcolor'];
    }else{
        $ltsmp_options['sliderdotcolor'] = "#773afd";
    }

    if(isset($ltsmp_options['sliderdothovercolor'])){
        $ltsmp_options['sliderdothovercolor'] = $ltsmp_options['sliderdothovercolor'];
    }else{
        $ltsmp_options['sliderdothovercolor'] = "#000000";
    }

    if(isset($ltsmp_options['slider_contbx_clr'])){
        $ltsmp_options['slider_contbx_clr'] = $ltsmp_options['slider_contbx_clr'];
    }else{
        $ltsmp_options['slider_contbx_clr'] = "#FFFFFF";
    }

    if(isset($ltsmp_options['slider_socl_icon_clr'])){
        $ltsmp_options['slider_socl_icon_clr'] = $ltsmp_options['slider_socl_icon_clr'];
    }else{
        $ltsmp_options['slider_socl_icon_clr'] = "#FFFFFF";
    }

    if(isset($ltsmp_options['slider_socl_icon_bg_clr'])){
        $ltsmp_options['slider_socl_icon_bg_clr'] = $ltsmp_options['slider_socl_icon_bg_clr'];
    }else{
        $ltsmp_options['slider_socl_icon_bg_clr'] = "#773afd";
    }

    if(isset($ltsmp_options['slider_socl_icon_hvr_clr'])){
        $ltsmp_options['slider_socl_icon_hvr_clr'] = $ltsmp_options['slider_socl_icon_hvr_clr'];
    }else{
        $ltsmp_options['slider_socl_icon_hvr_clr'] = "#000000";
    }

    if(isset($ltsmp_options['ltp_option_imgheightslider'])){
        $ltsmp_options['ltp_option_imgheightslider'] = $ltsmp_options['ltp_option_imgheightslider'];
    }else{
        $ltsmp_options['ltp_option_imgheightslider'] = "325px";
    }



    /* --------- page ---------- */

    if(isset($ltsmp_options['toneimghovercolor'])){
        $ltsmp_options['toneimghovercolor'] = $ltsmp_options['toneimghovercolor'];
    }else{
       $ltsmp_options['toneimghovercolor'] = "#FFFFFF";
    }

    if(isset($ltsmp_options['tonemembercolor'])){
        $ltsmp_options['tonemembercolor'] = $ltsmp_options['tonemembercolor'];
    }else{
       $ltsmp_options['tonemembercolor'] = "#000000";
    }

    if(isset($ltsmp_options['tonememberdesigcolor'])){
        $ltsmp_options['tonememberdesigcolor'] = $ltsmp_options['tonememberdesigcolor'];
    }else{
       $ltsmp_options['tonememberdesigcolor'] = "#000000";
    }

    if(isset($ltsmp_options['tonesocialcolor'])){
        $ltsmp_options['tonesocialcolor'] = $ltsmp_options['tonesocialcolor'];
    }else{
       $ltsmp_options['tonesocialcolor'] = "#FFFFFF";
    }

    if(isset($ltsmp_options['tonesocialbgcolor'])){
        $ltsmp_options['tonesocialbgcolor'] = $ltsmp_options['tonesocialbgcolor'];
    }else{
       $ltsmp_options['tonesocialbgcolor'] = "#773afd";
    }

    if(isset($ltsmp_options['tonesocialhvrcolor'])){
        $ltsmp_options['tonesocialhvrcolor'] = $ltsmp_options['tonesocialhvrcolor'];
    }else{
       $ltsmp_options['tonesocialhvrcolor'] = "#000000";
    }

    if(isset($ltsmp_options['teamboximgcolor'])){
        $ltsmp_options['teamboximgcolor'] = $ltsmp_options['teamboximgcolor'];
    }else{
       $ltsmp_options['teamboximgcolor'] = "#FFFFFF";
    }

    
    if(isset($ltsmp_options['ltp_option_imgheight'])){
        $ltsmp_options['ltp_option_imgheight'] = $ltsmp_options['ltp_option_imgheight'];
    }else{
       $ltsmp_options['ltp_option_imgheight'] = "325";
    }




    ?>
    <form method="post" action="options.php">
      <?php settings_fields( 'ltsmp-plugin-option' ); ?>
        <h3><?php esc_html_e('Luzuk Team','team-members-and-slider'); ?></h3>
        <div id="lzteamblock">

            <nav>
                <ul class="lzteam-block-tab">
                    <li tblock-id="lzteamblock1"><span><?php echo esc_html('Slider','team-members-and-slider'); ?></span></li>
                    <li tblock-id="lzteamblock2"><span><?php esc_html_e('Pages','team-members-and-slider'); ?></span></li>
                    <li tblock-id="lzteamblock3"><span><?php esc_html_e('Colors Setting','team-members-and-slider'); ?></span></li>
                </ul>
            </nav>
            <div class="content-section-teamlz">
                <div id='lzteamblock1' class="lzteamblock-content-wrap">
                    <div class="team-tab-row">
                        <div class="team-tab-colslider team-tab-col1slider">
                            <ul class="team-admin-tabslider">
                                <li team-idslider="team-inertabslider"><span><?php esc_html_e('Template','team-members-and-slider'); ?></span></li>
                                <li team-idslider="team-inertabslider1"><span><?php esc_html_e('Image Height','team-members-and-slider'); ?></span></li>
                                <li team-idslider="team-inertabslider5"><span><?php esc_html_e('Time Delay','team-members-and-slider'); ?></span></li>
                                <li team-idslider="team-inertabslider2"><span><?php esc_html_e('Navigation Arrows','team-members-and-slider'); ?></span></li>
                                <li team-idslider="team-inertabslider3"><span><?php esc_html_e('Navigation Dots','team-members-and-slider'); ?></span></li>
                                <li team-idslider="team-inertabslider4"><span><?php esc_html_e('Team Show In One Column','team-members-and-slider'); ?></span></li>
                            </ul>
                        </div>
                        <div class="team-tab-colslider team-tab-col2slider">
                            <div class="team-tab-contentslider">
                                <div class="team-tab-content-wrapslider" id="team-inertabslider">
                                    <?php $ltfp_option_sel_slidertemplate = get_option('ltfp_option_sel_slidertemplate'); ?>
                                    <img src="<?php echo plugin_dir_url( __FILE__ ) . 'images/dinero.png'; ?>">
                                    <label><input id="selsliderteamtemplate" type="radio" name="ltfp_option_sel_slidertemplate" value="TeamSliderTemplate1" <?php if(isset($ltfp_option_sel_slidertemplate)){checked( 'TeamSliderTemplate1' == $ltfp_option_sel_slidertemplate ); } ?>  /><?php echo esc_html('Dinero'); ?> </label>
                                </div>
                                <div class="team-tab-content-wrapslider" id="team-inertabslider1">
                                    <label><?php echo esc_html('Slider Image Height'); ?></label>
                                    <div>
                                        <input type="range" class="teamtempslider" id="myRangeSlider" name="ltsmp_options[ltp_option_imgheightslider]" min="0" max="650" value="<?php echo esc_attr($ltsmp_options['ltp_option_imgheightslider']); ?>" />
                                        <span id="teampageheightslider"></span><?php echo esc_html('px'); ?>
                                    </div>
                                    
                                    <script>
                                        var teamtempslider = document.getElementById("myRangeSlider");
                                        var outputslider = document.getElementById("teampageheightslider");
                                        outputslider.innerHTML = teamtempslider.value;

                                        teamtempslider.oninput = function() {
                                        outputslider.innerHTML = this.value;
                                        }
                                    </script>
                                </div>
                                <div class="team-tab-content-wrapslider" id="team-inertabslider5">
                                    <div class="teamsliderange">
                                        <label><?php echo esc_html('Time Delay'); ?></label>
                                        <span>
                                            <input id="lttranstduration" class="teambasic-slide" type="number" name="teamslidertransitionduration" min="1" max="120" value="<?php echo esc_attr(get_option('teamslidertransitionduration')); ?>"><label for="lttranstduration">SEC</label>
                                        </span>
                                    </div>
                                </div>
                                <div class="team-tab-content-wrapslider" id="team-inertabslider2">
                                    <?php $ltfp_teamarrow = get_option('ltfp_teamarrow'); ?>
                                    <label><?php echo esc_html('Arrow'); ?></label>
                                        <div class="teamswitch-field">
                                            <input type="radio" id="teamradioarrowone" name="ltfp_teamarrow" value="true" <?php if(isset($ltfp_teamarrow)){checked( 'true' == $ltfp_teamarrow ); } ?>  />
                                            <label for="teamradioarrowone">ON</label>
                                            <input type="radio" id="teamradio-two" name="ltfp_teamarrow" value="false" <?php if(isset($ltfp_teamarrow)){checked( 'false' == $ltfp_teamarrow ); } ?>  />
                                            <label for="teamradio-two">OFF</label>  
                                        </div>
                                    </label>

                                </div>
                                <div class="team-tab-content-wrapslider" id="team-inertabslider3">
                                    <?php $ltfp_teamdot = get_option('ltfp_teamdot'); ?>
                                    <label><?php echo esc_html('Dots'); ?></label>
                                        <div class="teamswitch-field">
                                            <input type="radio" id="teamradioonedot" name="ltfp_teamdot" value="true" <?php if(isset($ltfp_teamdot)){checked( 'true' == $ltfp_teamdot ); } ?>  />
                                            <label for="teamradioonedot">ON</label>
                                            <input type="radio" id="teamradio-twodot" name="ltfp_teamdot" value="false" <?php if(isset($ltfp_teamdot)){checked( 'false' == $ltfp_teamdot ); } ?>  />
                                            <label for="teamradio-twodot">OFF</label>  
                                        </div>
                                    </label>

                                </div>
                                <div class="team-tab-content-wrapslider" id="team-inertabslider4">
                                    <label><?php echo esc_html('Team Show'); ?></label>
                                        <input type="number" id="tspstno" name="teamsliderpostnumber" min="2" max="4" value="<?php echo esc_attr(get_option('teamsliderpostnumber')); ?>">
                                    </label>
                                </div>
                            </div>
                        </div>  
                    </div>             
                </div>

                <div id='lzteamblock2' class="lzteamblock-content-wrap">
                    <div class="team-tab-row">
                        <div class="team-tab-colpages team-tab-col1pages">
                            <ul class="team-admin-tabpages">
                                <li team-idpages="team-inertabpages"><span><?php esc_html_e('Template','team-members-and-slider'); ?></span></li>
                                <li team-idpages="team-inertabpages1"><span><?php esc_html_e('Image Height','team-members-and-slider'); ?></span></li>
                                <li team-idpages="team-inertabpages2"><span><?php esc_html_e('Show In One Page','team-members-and-slider'); ?></span></li>
                            </ul>
                        </div>
                        <div class="team-tab-colpages team-tab-col2pages">
                            <div class="team-tab-contentpages">
                                <div class="team-tab-content-wrappages" id="team-inertabpages">
                                    <?php $ltfp_option_sel_template = get_option('ltfp_option_sel_template'); ?>
                                    <img src="<?php echo plugin_dir_url( __FILE__ ) . 'images/dinero.png'; ?>">
                                    <label><input id="selteamtemplate" type="radio" name="ltfp_option_sel_template" value="TeamTemplate1" <?php if(isset($ltfp_option_sel_template)){checked( 'TeamTemplate1' == $ltfp_option_sel_template ); } ?>  /><?php echo esc_html('Dinero'); ?> </label>
                                </div>
                                <div class="team-tab-content-wrappages" id="team-inertabpages1">
                                    <label><?php echo esc_html('Image Height'); ?></label>
                                    <div>
                                        <input type="range" class="rangslider" id="myRange" name="ltsmp_options[ltp_option_imgheight]" min="0" max="500" value="<?php echo esc_attr($ltsmp_options['ltp_option_imgheight']); ?>" />
                                        <span id="teampageheight"></span><?php echo esc_html('px'); ?>
                                    </div>
                                    
                                    <script>
                                        var rangslider = document.getElementById("myRange");
                                        var output = document.getElementById("teampageheight");
                                        output.innerHTML = rangslider.value;

                                        rangslider.oninput = function() {
                                        output.innerHTML = this.value;
                                        }
                                    </script>
                                </div>
                                <div class="team-tab-content-wrappages" id="team-inertabpages2">
                                    <label><?php echo esc_html('Number of Post Show'); ?></label>
                                    <input type="number" id="teampagepostno" name="lteamp_postno" min="1" max="100" value="<?php echo esc_attr(get_option('lteamp_postno')); ?>">
                                </div>
                            </div>
                        </div>  
                    </div>   

                </div>

                <div id='lzteamblock3' class="lzteamblock-content-wrap">
                    <div class="team-tab-row">
                        <div class="team-tab-colclr team-tab-col1clr">
                            <ul class="team-admin-tabclr">
                                <li team-idclr="team-tab1"><span><?php esc_html_e('Slider Colors','team-members-and-slider'); ?></span></li>
                                <li team-idclr="team-tab2"><span><?php esc_html_e('Page Colors','team-members-and-slider'); ?></span></li>
                            </ul>
                        </div>
                        <div class="team-tab-colclr team-tab-col2clr">
                            <div class="team-tab-contentclr">
                                <div class="team-tab-content-wrapclr" id="team-tab1">
                                    <div class="lt-input-field">
                                        <label><?php esc_html_e('Name Color','team-members-and-slider'); ?></label>
                                        <input id="lt_snc" type="text" name="ltsmp_options[slider_name_clr]" value="<?php echo esc_attr($ltsmp_options['slider_name_clr']); ?>" class="ltcolor-field" />
                                    </div>
                                    <div class="lt-input-field">
                                        <label><?php esc_html_e('Designation Color','team-members-and-slider'); ?></label>
                                        <input id="lt_sdc" type="text" name="ltsmp_options[slider_dsignt_clr]" value="<?php echo esc_attr($ltsmp_options['slider_dsignt_clr']); ?>" class="ltcolor-field" />
                                    </div>
                                    <div class="lt-input-field">
                                        <label><?php esc_html_e('Navigation Arrow Color','team-members-and-slider'); ?></label>
                                        <input id="lt_snvacol" type="text" name="ltsmp_options[sliderarrowcolor]" value="<?php echo esc_attr($ltsmp_options['sliderarrowcolor']); ?>" class="ltcolor-field" />
                                    </div>
                                    <div class="lt-input-field">
                                        <label><?php esc_html_e('Navigation Arrow Hover Color','team-members-and-slider'); ?></label>
                                        <input id="lt_snvahcol" type="text" name="ltsmp_options[sliderarrowhovercolor]" value="<?php echo esc_attr($ltsmp_options['sliderarrowhovercolor']); ?>" class="ltcolor-field" />
                                    </div>
                                    <div class="lt-input-field">
                                        <label><?php esc_html_e('Navigation Dot Color','team-members-and-slider'); ?></label>
                                        <input id="lt_sdotclor" type="text" name="ltsmp_options[sliderdotcolor]" value="<?php echo esc_attr($ltsmp_options['sliderdotcolor']); ?>" class="ltcolor-field" />
                                    </div>
                                    <div class="lt-input-field">
                                        <label><?php esc_html_e('Navigation Dot Hover & Active Color','team-members-and-slider'); ?></label>
                                        <input id="lt_sdothclor" type="text" name="ltsmp_options[sliderdothovercolor]" value="<?php echo esc_attr($ltsmp_options['sliderdothovercolor']); ?>" class="ltcolor-field" />
                                    </div>
                                    <div class="lt-input-field">
                                        <label><?php esc_html_e('Content Box Background Color','team-members-and-slider'); ?></label>
                                        <input id="lt_scbclr" type="text" name="ltsmp_options[slider_contbx_clr]" value="<?php echo esc_attr($ltsmp_options['slider_contbx_clr']); ?>" class="ltcolor-field" />
                                    </div>
                                    <div class="lt-input-field">
                                        <label><?php esc_html_e('Social Icon Color','team-members-and-slider'); ?></label>
                                        <input id="lt_ssiclr" type="text" name="ltsmp_options[slider_socl_icon_clr]" value="<?php echo esc_attr($ltsmp_options['slider_socl_icon_clr']); ?>" class="ltcolor-field" />
                                    </div>
                                    <div class="lt-input-field">
                                        <label><?php esc_html_e('Social Icon Background Color','team-members-and-slider'); ?></label>
                                        <input id="lt_ssibclr" type="text" name="ltsmp_options[slider_socl_icon_bg_clr]" value="<?php echo esc_attr($ltsmp_options['slider_socl_icon_bg_clr']); ?>" class="ltcolor-field" />
                                    </div>
                                    <div class="lt-input-field">
                                        <label><?php esc_html_e('Social Icon Hover Color','team-members-and-slider'); ?></label>
                                        <input id="lt_ssihvlr" type="text" name="ltsmp_options[slider_socl_icon_hvr_clr]" value="<?php echo esc_attr($ltsmp_options['slider_socl_icon_hvr_clr']); ?>" class="ltcolor-field" />
                                    </div>
                                </div>
                                <div class="team-tab-content-wrapclr" id="team-tab2">
                                    <div class="lt-input-field">
                                        <label><?php esc_html_e('Name Color','team-members-and-slider'); ?></label>
                                        <input id="lt_smnclor" type="text" name="ltsmp_options[tonemembercolor]" value="<?php echo esc_attr($ltsmp_options['tonemembercolor']); ?>" class="ltcolor-field" />
                                    </div>
                                    <div class="lt-input-field">
                                        <label><?php esc_html_e('Designation Color','team-members-and-slider'); ?></label>
                                        <input id="lt_smdclor" type="text" name="ltsmp_options[tonememberdesigcolor]" value="<?php echo esc_attr($ltsmp_options['tonememberdesigcolor']); ?>" class="ltcolor-field" />
                                    </div>
                                    <div class="lt-input-field">
                                        <label><?php esc_html_e('Content Box Background Color','team-members-and-slider'); ?></label>
                                        <input id="lt_teamcbclor" type="text" name="ltsmp_options[teamboximgcolor]" value="<?php echo esc_attr($ltsmp_options['teamboximgcolor']); ?>" class="ltcolor-field" />
                                    </div>
                                    <div class="lt-input-field">
                                        <label><?php esc_html_e('Social Icon Color','team-members-and-slider'); ?></label>
                                        <input id="lt_stsclor" type="text" name="ltsmp_options[tonesocialcolor]" value="<?php echo esc_attr($ltsmp_options['tonesocialcolor']); ?>" class="ltcolor-field" />
                                    </div>
                                    <div class="lt-input-field">
                                        <label><?php esc_html_e('Social Icon Background Color','team-members-and-slider'); ?></label>
                                        <input id="lt_ststsbclor" type="text" name="ltsmp_options[tonesocialbgcolor]" value="<?php echo esc_attr($ltsmp_options['tonesocialbgcolor']); ?>" class="ltcolor-field" />
                                    </div>
                                    <div class="lt-input-field">
                                        <label><?php esc_html_e('Social Icon Hover Color','team-members-and-slider'); ?></label>
                                        <input id="lt_ststshclor" type="text" name="ltsmp_options[tonesocialhvrcolor]" value="<?php echo esc_attr($ltsmp_options['tonesocialhvrcolor']); ?>" class="ltcolor-field" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="team-tab-row">
            <?php submit_button(); ?>
            <button class="lt_buttonreset button-primary" onclick="lt_restbtn()" >Reset</button>
            <script>
                function lt_restbtn() {
                    document.getElementById('selsliderteamtemplate').checked='true',
                    document.getElementById('myRangeSlider').value = '325', 
                    document.getElementById('teamradioarrowone').checked='true',
                    document.getElementById('teamradioonedot').checked='true',
                    document.getElementById('tspstno').value = '4',
                    document.getElementById('selteamtemplate').checked='true',
                    document.getElementById('myRange').value = '325',
                    document.getElementById('teampagepostno').value = '12',
                    document.getElementById('lt_snc').value = '#000000',
                    document.getElementById('lt_sdc').value = '#000000',
                    document.getElementById('lt_snvacol').value = '#773afd',
                    document.getElementById('lt_snvahcol').value = '#000000',
                    document.getElementById('lt_sdotclor').value = '#773afd',
                    document.getElementById('lt_sdothclor').value = '#000000',
                    document.getElementById('lt_scbclr').value = '#FFFFFF',
                    document.getElementById('lt_ssiclr').value = '#FFFFFF',
                    document.getElementById('lt_ssibclr').value = '#773afd',
                    document.getElementById('lt_ssihvlr').value = '#000000',
                    document.getElementById('lt_smnclor').value = '#000000',           
                    document.getElementById('lt_smdclor').value = '#000000',           
                    document.getElementById('lt_teamcbclor').value = '#FFFFFF',
                    document.getElementById('lt_stsclor').value = '#FFFFFF',           
                    document.getElementById('lt_ststsbclor').value = '#773afd',           
                    document.getElementById('lt_ststshclor').value = '#000000'

                }
            </script>
        </div>
   </form>
<?php }

/* --------- New -------- */
add_action( 'admin_init', 'ltsmp_register_settings' );
function ltsmp_register_settings() {
    register_setting('ltsmp-plugin-option', 'ltsmp_options', 'ltsmp_validate_options');
}

/***** Start Add custome fields for team luzuk section *****/
/**
 * @author Luzuk <support@luzuk.com>
 **/
function ltsmp_teamluzukpostSocialURLsCutomFieldHtml(){
    global $post;
    // get the saved value 
    $teamluzukFacebook = get_post_meta($post->ID, 'teamluzukFacebook', false);
    $teamluzukFacebookValue = !empty($teamluzukFacebook[0])?$teamluzukFacebook[0]:'';
    $teamluzukTwitter = get_post_meta($post->ID, 'teamluzukTwitter', false);
    $teamluzukTwitterValue = !empty($teamluzukTwitter[0])?$teamluzukTwitter[0]:'';
    $teamluzuklinkedIn = get_post_meta($post->ID, 'teamluzuklinkedIn', false);
    $teamluzuklinkedInValue = !empty($teamluzuklinkedIn[0])?$teamluzuklinkedIn[0]:'';
    $teamluzukyoutube = get_post_meta($post->ID, 'teamluzukyoutube', false);
    $teamluzukyoutubeValue = !empty($teamluzukyoutube[0])?$teamluzukyoutube[0]:'';
    $teamluzukinstagram = get_post_meta($post->ID, 'teamluzukinstagram', false);
    $teamluzukinstagramValue = !empty($teamluzukinstagram[0])?$teamluzukinstagram[0]:'';
    $teamluzukwhatsapp = get_post_meta($post->ID, 'teamluzukwhatsapp', false);
    $teamluzukwhatsappValue = !empty($teamluzukwhatsapp[0])?$teamluzukwhatsapp[0]:'';
     

    // Use nonce for verification
    wp_nonce_field(plugin_basename(__FILE__), 'Teamluzuk_social_media_links');
    echo '<table id="socialUrls" width="100%">';
    echo '<tr> 
        <th width="10%"><span class="dashicons dashicons-facebook"></span></th>
        <td width="90%"><input type="text" name="teamluzukFacebook" width="100%" placeholder="Facebook URL" value="'.$teamluzukFacebookValue.'" /></td>
    </tr>';
    echo '<tr> 
        <th><span class="dashicons dashicons-twitter"></span></th>
        <td><input type="text" name="teamluzukTwitter" placeholder="Twitter URL" width="100%" value="'.$teamluzukTwitterValue.'" /></td>
    </tr>';

    echo '<tr> 
        <th><span class="dashicons dashicons-admin-site-alt3"></span></th>
        <td><input type="text" name="teamluzuklinkedIn" placeholder="Linkedin URL" width="100%" value="'.$teamluzuklinkedInValue.'" /></td>
    </tr>';

    echo '<tr> 
        <th><span class="dashicons dashicons-video-alt2"></span></th>
        <td><input type="text" name="teamluzukyoutube" placeholder="Youtube URL" width="100%" value="'.$teamluzukyoutubeValue.'" /></td>
    </tr>';

    echo '<tr> 
        <th><span class="dashicons dashicons-instagram"></span></th>
        <td><input type="text" name="teamluzukinstagram" placeholder="Instagram URL" width="100%" value="'.$teamluzukinstagramValue.'" /></td>
    </tr>';

    echo '<tr> 
        <th><span class="dashicons dashicons-testimonial"></span></th>
        <td><input type="text" name="teamluzukwhatsapp" placeholder="Whats App URL" width="100%" value="'.$teamluzukwhatsappValue.'" /></td>
    </tr>';

    
    echo '</table>';
}

/**
 * When the post is saved, saves our custom data 
 * @author Luzuk <support@luzuk.com>
 **/
function ltsmp_teamluzukpostDesignationCutomFieldHtml(){
    global $post;
    // get the saved value 
    $designation = get_post_meta($post->ID, 'designation', false);
    $designation = !empty($designation[0])?$designation[0]:'';

    // Use nonce for verification
    wp_nonce_field(plugin_basename(__FILE__), 'Teamluzuk_social_media_links');
    echo '<table id="socialUrls" width="100%">';
    echo '<tr> 
        <th width="10%"><span class="dashicons dashicons-welcome-learn-more"></span></th>
        <td width="90%"><input type="text" name="designation" width="100%" placeholder="Designation" value="'.$designation.'" /></td>
    </tr>';
    echo '</table>';
}

function ltsmp_addTeamluzukpostHook(){
    add_meta_box('team-social', __('Add Social media links', 'luzuk-premium'), 'ltsmp_teamluzukpostSocialURLsCutomFieldHtml', 'our-lteam', 'normal', 'high');
    add_meta_box('teamluzuk-designation', __('Add Designation', 'luzuk-premium'), 'ltsmp_teamluzukpostDesignationCutomFieldHtml', 'our-lteam', 'normal', 'high');
}
/**
 * When the post is saved, saves our custom data 
 * @author Luzuk <support@luzuk.com>
 **/
function ltsmp_saveTeamluzukpostSocialCutomData($post_id){
    // If it is our form has not been submitted, so we dont want to do anything
    if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;
    if(empty($_POST['teamluzukFacebook']) && empty($_POST['teamluzukTwitter']) && empty($_POST['teamluzuklinkedIn']) && empty($_POST['teamluzukyoutube']) && empty($_POST['teamluzukinstagram']) && empty($_POST['teamluzukwhatsapp']) && empty($_POST['designation']) && empty($_POST['ltfp_option_sel_template']) && empty($_POST['lteamp_postno']) && empty($_POST['ltfp_option_sel_slidertemplate']) && empty($_POST['teamsliderpostnumber']) && empty($_POST['ltfp_teamarrow']) && empty($_POST['ltfp_teamdot']) && empty($_POST['teamslidertransitionduration']) ){
        // echo 'empty --> '; exit;       
        return;
    }
    $teamluzukFacebook = sanitize_text_field($_POST['teamluzukFacebook']);
    update_post_meta($post_id, 'teamluzukFacebook', $teamluzukFacebook);
    $teamluzukTwitter = sanitize_text_field($_POST['teamluzukTwitter']);
    update_post_meta($post_id, 'teamluzukTwitter', $teamluzukTwitter);
    $teamluzuklinkedIn = sanitize_text_field($_POST['teamluzuklinkedIn']);
    update_post_meta($post_id, 'teamluzuklinkedIn', $teamluzuklinkedIn);
    $teamluzukyoutube = sanitize_text_field($_POST['teamluzukyoutube']);
    update_post_meta($post_id, 'teamluzukyoutube', $teamluzukyoutube);
    $teamluzukinstagram = sanitize_text_field($_POST['teamluzukinstagram']);
    update_post_meta($post_id, 'teamluzukinstagram', $teamluzukinstagram);
    $teamluzukwhatsapp = sanitize_text_field($_POST['teamluzukwhatsapp']);
    update_post_meta($post_id, 'teamluzukwhatsapp', $teamluzukwhatsapp);
 
    $designation = sanitize_text_field($_POST['designation']);
    update_post_meta($post_id, 'designation', $designation);

    $ltfp_option_sel_template = sanitize_text_field($_POST['ltfp_option_sel_template']);
    update_post_meta($post_id, 'ltfp_option_sel_template', $ltfp_option_sel_template);

    $ltfp_option_sel_slidertemplate = sanitize_text_field($_POST['ltfp_option_sel_slidertemplate']);
    update_post_meta($post_id, 'ltfp_option_sel_slidertemplate', $ltfp_option_sel_slidertemplate);

    $lteamp_postno = sanitize_text_field($_POST['lteamp_postno']);
    update_post_meta($post_id, 'lteamp_postno', $lteamp_postno);

    $teamsliderpostnumber = sanitize_text_field($_POST['teamsliderpostnumber']);
    update_post_meta($post_id, 'teamsliderpostnumber', $teamsliderpostnumber);

    $ltfp_teamarrow = sanitize_text_field($_POST['ltfp_teamarrow']);
    update_post_meta($post_id, 'ltfp_teamarrow', $ltfp_teamarrow);

    $ltfp_teamdot = sanitize_text_field($_POST['ltfp_teamdot']);
    update_post_meta($post_id, 'ltfp_teamdot', $ltfp_teamdot);

    $teamslidertransitionduration = sanitize_text_field($_POST['teamslidertransitionduration']);
    update_post_meta($post_id, 'teamslidertransitionduration', $teamslidertransitionduration);
 

}
add_action('add_meta_boxes', 'ltsmp_addTeamluzukpostHook');
add_action('save_post', 'ltsmp_saveTeamluzukpostSocialCutomData');
/***** End Add custome fields for team section *****/



/**
 * Liting the team/trainer details 
 * @param : int $pageId default is null
 * @param : boolean $isCustomizer default is false, if set to true will get the data stored with customizer
 * @param : int $i default is null, it will used as a iteration for data with customizer, this will be used only if the $isCustomizer is set to true.
 * @return: Text $text
 */
function ltsmp_teampostShortCode1($pageId = null, $isCustomizer = false, $i = null) {

    global $ltsmp_options;
   
    $args = array('post_type' => 'our-lteam');
    if (!empty($pageId)) {
        $args['page_id'] = absint($pageId);
    }
    $args['posts_per_page'] = -1;
    $colCls = '';
    // if($isCustomizer == true){
    $cols = get_theme_mod('teamluzuk_npp_count', get_option('lteamp_postno')-1);
    $cols++;
    switch($cols){
        case 1:
            $colCls = 'teamluzuk-md-12 teamluzuk-sm-12 teamluzuk-xs-12';
            break;
        case 2:
            $colCls = 'teamluzuk-md-6 teamluzuk-sm-6 teamluzuk-xs-12';
            break;
        case 3:
        case 5:
        case 6:
            $colCls = 'teamluzuk-md-4 teamluzuk-sm-6 teamluzuk-xs-12';
            break;
        default:
            $colCls = 'teamluzuk-md-3 teamluzuk-sm-6 teamluzuk-xs-12';
            break;
    }
                
    // }
    $text = '';
    $query = new WP_Query($args);
    if ($query->have_posts()):
        $postN = 0; ?>



<?php
    if (get_option('ltfp_option_sel_template') == "TeamTemplate1" ) { ?>

    <div class="team-luzuk-area"> 
        <?php
            while ($query->have_posts()) : $query->the_post();
            $luzuk_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'total-teamluzuk-thumb');
            if ($isCustomizer === true) {
                $teamluzuk_designation = get_theme_mod('teamluzuk_designation' . $i);
                $teamluzuk_facebook = get_theme_mod('teamluzuk_facebook' . $i);
                $teamluzuk_twitter = get_theme_mod('teamluzuk_twitter' . $i);
                $teamluzuk_linkedin = get_theme_mod('teamluzuk_linkedin' . $i);
                $teamluzuk_youtube = get_theme_mod('teamluzuk_youtube' . $i);
                $teamluzuk_instagram = get_theme_mod('teamluzuk_instagram' . $i);
                $teamluzuk_whatsapp = get_theme_mod('teamluzuk_whatsapp' . $i);
                
            } else {
                $teamluzuk_facebook = '';
                $teamluzuk_twitter = '';
                $teamluzuk_linkedin = '';
                $teamluzuk_youtube = '';
                $teamluzuk_instagram = '';
                $teamluzuk_whatsapp = '';
                $teamluzuk_designation = '';
            }

            $post = get_post();
            //Social media urls
            $teamluzukFacebook = get_post_meta($post->ID, 'teamluzukFacebook', false);
            $teamluzuk_facebook = !empty($teamluzukFacebook[0]) ? $teamluzukFacebook[0] : '';
            $teamluzukTwitter = get_post_meta($post->ID, 'teamluzukTwitter', false);
            $teamluzuk_twitter = !empty($teamluzukTwitter[0]) ? $teamluzukTwitter[0] : '';
            $teamluzuklinkedIn = get_post_meta($post->ID, 'teamluzuklinkedIn', false);
            $teamluzuk_linkedin = !empty($teamluzuklinkedIn[0]) ? $teamluzuklinkedIn[0] : '';
            $teamluzukyoutube = get_post_meta($post->ID, 'teamluzukyoutube', false);
            $teamluzuk_youtube = !empty($teamluzukyoutube[0]) ? $teamluzukyoutube[0] : '';
            $teamluzukinstagram = get_post_meta($post->ID, 'teamluzukinstagram', false);
            $teamluzuk_instagram = !empty($teamluzukinstagram[0]) ? $teamluzukinstagram[0] : '';
            $teamluzukwhatsapp = get_post_meta($post->ID, 'teamluzukwhatsapp', false);
            $teamluzuk_whatsapp = !empty($teamluzukwhatsapp[0]) ? $teamluzukwhatsapp[0] : '';

            //designation
            $designation = get_post_meta($post->ID, 'designation', false);
            $teamluzuk_designation = !empty($designation[0]) ? $designation[0] : '';
        ?>
        <div class="<?php echo $colCls; ?> luzuk-s luzuk-s teamitem" >
            <div class="innerteampagebox wow zoomIn">
                <div class="teammemberimage">
                    <a>
                        <?php
                            if (has_post_thumbnail()) {
                                $image_url = $luzuk_image[0];
                            } else {
                                $image_url = get_template_directory_uri() . '/images/default.png';
                            }
                        ?>   
                        <img class="secondry-bg" src="<?php echo esc_url($image_url); ?>" alt="<?php the_title(); ?>" >
                        <div class="overlay">
                        </div>
                    </a>
                </div>
                <div class="ht-team-socialbox-block"> 
                    <?php if ($teamluzuk_facebook || $teamluzuk_twitter || $teamluzuk_linkedin || $teamluzuk_youtube || $teamluzuk_instagram || $teamluzuk_whatsapp ) { ?>
                        <div class="ht-team-socialbox">        
                            <ul class="icon ht-team-social-id">
                                <li class="team-share-button"><a href="#" class="team-site-button"><i class="fa fa-share-alt"></i></a></li>
                                <?php if ($teamluzuk_facebook) { ?>
                                    <li><a class="team-site-button" target="_blank" href="<?php echo esc_url($teamluzuk_facebook) ?>"><i class="fab fa-facebook-f"></i></a></li>
                                <?php } ?>
                                <?php if ($teamluzuk_twitter) { ?>
                                    <li><a class="team-site-button" target="_blank" href="<?php echo esc_url($teamluzuk_twitter) ?>"><i class="fab fa-twitter"></i></a> </li>
                                <?php } ?>
                                <?php if ($teamluzuk_linkedin) { ?>
                                    <li><a class="team-site-button" target="_blank" href="<?php echo esc_url($teamluzuk_linkedin) ?>"><i class="fab fa-linkedin-in"></i></a></li>
                                <?php } ?>
                                <?php if ($teamluzuk_youtube) { ?>
                                    <li><a class="team-site-button" target="_blank" href="<?php echo esc_url($teamluzuk_youtube) ?>"><i class="fab fa-youtube"></i></a></li>
                                <?php } ?>
                                <?php if ($teamluzuk_instagram) { ?>
                                    <li><a class="team-site-button" target="_blank" href="<?php echo esc_url($teamluzuk_instagram) ?>"><i class="fab fa-instagram"></i></a></li>
                                <?php } ?>
                                <?php if ($teamluzuk_whatsapp) { ?>
                                    <li><a class="team-site-button" target="_blank" href="<?php echo esc_url($teamluzuk_whatsapp) ?>"><i class="fab fa-whatsapp"></i></a></li>
                                <?php } ?>
                            <div class="clearfix"></div>
                            </ul>
                        </div>
                    <?php } ?>
                </div>
                <div class="box-content">
                    <h3 class="title"><?php the_title(); ?></h3>
                    <?php if (!empty($teamluzuk_designation)) { ?>
                    <span class="team-member-designation"><?php echo($teamluzuk_designation); ?></span>
                    <?php
                    } ?>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>          
        </div>
        <?php endwhile; ?>
        <div class="clearfix"></div>
    </div>     
    
    <div id="teampagination"></div>
    <script>
        allitems = $(".team-luzuk-area .teamitem");
        numItems = allitems.length;

        if (numItems <= <?php echo esc_attr(get_option('lteamp_postno')); ?>){
            document.querySelector('#teampagination').style.display = "none";
        }
    </script>

    <!-- ** Pagination ** -->
    <script>
        var items = $(".team-luzuk-area .teamitem");
        var numItems = items.length;
        var perPage = <?php echo esc_attr(get_option('lteamp_postno')); ?>;

        items.slice(perPage).hide();

        $('#teampagination').pagination({
            items: numItems,
            itemsOnPage: perPage,
            prevText: "&laquo;",
            nextText: "&raquo;",
            onPageClick: function (pageNumber) {
                var showFrom = perPage * (pageNumber - 1);
                var showTo = showFrom + perPage;
                items.hide().slice(showFrom, showTo).show();
            }
        });
    </script>

    <?php }  ?>

    <?php
    $text = ob_get_contents();
    ob_clean();
endif;
wp_reset_postdata();
return $text;
}

function ltsmp_teampostShortCode1slider($pageId = null, $isCustomizer = false, $i = null) {

    ob_start();

    $args = array('post_type' => 'our-lteam');
    if (!empty($pageId)) {
        $args['page_id'] = absint($pageId);
    }
    $args['posts_per_page'] = -1;
    $text = '';
    $query = new WP_Query($args);
    if ($query->have_posts()):
        $postN = 0; 
 ?>


<?php if (get_option('ltfp_option_sel_slidertemplate') == "TeamSliderTemplate1" ) { ?>


    <div class="team-luzuk-slider team-luzuk-area">
        <div class="owl-carousel owl-theme">
            <?php
                while ($query->have_posts()) : $query->the_post();
                $luzuk_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'total-teamluzuk-thumb');
                if ($isCustomizer === true) {
                    $teamluzuk_designation = get_theme_mod('teamluzuk_designation' . $i);
                    $teamluzuk_facebook = get_theme_mod('teamluzuk_facebook' . $i);
                    $teamluzuk_twitter = get_theme_mod('teamluzuk_twitter' . $i);
                    $teamluzuk_linkedin = get_theme_mod('teamluzuk_linkedin' . $i);
                    $teamluzuk_youtube = get_theme_mod('teamluzuk_youtube' . $i);
                    $teamluzuk_instagram = get_theme_mod('teamluzuk_instagram' . $i);
                    $teamluzuk_whatsapp = get_theme_mod('teamluzuk_whatsapp' . $i);
                    
                } else {
                    $teamluzuk_facebook = '';
                    $teamluzuk_twitter = '';
                    $teamluzuk_linkedin = '';
                    $teamluzuk_youtube = '';
                    $teamluzuk_instagram = '';
                    $teamluzuk_whatsapp = '';
                    $teamluzuk_designation = '';
                }

                $post = get_post();
                //Social media urls
                $teamluzukFacebook = get_post_meta($post->ID, 'teamluzukFacebook', false);
                $teamluzuk_facebook = !empty($teamluzukFacebook[0]) ? $teamluzukFacebook[0] : '';
                $teamluzukTwitter = get_post_meta($post->ID, 'teamluzukTwitter', false);
                $teamluzuk_twitter = !empty($teamluzukTwitter[0]) ? $teamluzukTwitter[0] : '';
                $teamluzuklinkedIn = get_post_meta($post->ID, 'teamluzuklinkedIn', false);
                $teamluzuk_linkedin = !empty($teamluzuklinkedIn[0]) ? $teamluzuklinkedIn[0] : '';
                $teamluzukyoutube = get_post_meta($post->ID, 'teamluzukyoutube', false);
                $teamluzuk_youtube = !empty($teamluzukyoutube[0]) ? $teamluzukyoutube[0] : '';
                $teamluzukinstagram = get_post_meta($post->ID, 'teamluzukinstagram', false);
                $teamluzuk_instagram = !empty($teamluzukinstagram[0]) ? $teamluzukinstagram[0] : '';
                $teamluzukwhatsapp = get_post_meta($post->ID, 'teamluzukwhatsapp', false);
                $teamluzuk_whatsapp = !empty($teamluzukwhatsapp[0]) ? $teamluzukwhatsapp[0] : '';

                //designation
                $designation = get_post_meta($post->ID, 'designation', false);
                $teamluzuk_designation = !empty($designation[0]) ? $designation[0] : '';
            
            ?>
            <div class="item">
                <div class="innerteampagebox wow zoomIn teamslider">
                    <div class="teammemberimage">
                        <a>
                            <?php
                                if (has_post_thumbnail()) {
                                    $image_url = $luzuk_image[0];
                                } else {
                                    $image_url = get_template_directory_uri() . '/images/default.png';
                                }
                            ?>                  
                            <img class="secondry-bg" src="<?php echo esc_url($image_url); ?>" alt="<?php the_title(); ?>" >
                            <div class="overlay">
                            </div>
                        </a>
                    </div>
                    <div class="ht-team-socialbox-block"> 
                        <?php if ($teamluzuk_facebook || $teamluzuk_twitter || $teamluzuk_linkedin || $teamluzuk_youtube || $teamluzuk_instagram || $teamluzuk_whatsapp ) { ?>
                            <div class="ht-team-socialbox bgsocialbox">        
                                <ul class="icon sliderht-team-social-id">
                                    <li class="team-share-button"><a href="#" class="team-site-button"><i class="fa fa-share-alt"></i></a></li>
                                    <?php if ($teamluzuk_facebook) { ?>
                                        <li><a class="team-site-button" target="_blank" href="<?php echo esc_url($teamluzuk_facebook) ?>"><i class="fab fa-facebook-f"></i></a></li>
                                    <?php } ?>
                                    <?php if ($teamluzuk_twitter) { ?>
                                        <li><a class="team-site-button" target="_blank" href="<?php echo esc_url($teamluzuk_twitter) ?>"><i class="fab fa-twitter"></i></a> </li>
                                    <?php } ?>
                                    <?php if ($teamluzuk_linkedin) { ?>
                                        <li><a class="team-site-button" target="_blank" href="<?php echo esc_url($teamluzuk_linkedin) ?>"><i class="fab fa-linkedin-in"></i></a></li>
                                    <?php } ?>
                                    <?php if ($teamluzuk_youtube) { ?>
                                        <li><a class="team-site-button" target="_blank" href="<?php echo esc_url($teamluzuk_youtube) ?>"><i class="fab fa-youtube"></i></a></li>
                                    <?php } ?>
                                    <?php if ($teamluzuk_instagram) { ?>
                                        <li><a class="team-site-button" target="_blank" href="<?php echo esc_url($teamluzuk_instagram) ?>"><i class="fab fa-instagram"></i></a></li>
                                    <?php } ?>
                                    <?php if ($teamluzuk_whatsapp) { ?>
                                        <li><a class="team-site-button" target="_blank" href="<?php echo esc_url($teamluzuk_whatsapp) ?>"><i class="fab fa-whatsapp"></i></a></li>
                                    <?php } ?>
                                    <div class="clearfix"></div>
                                </ul>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="sliderbox-content">
                        <h3 class="slidertitle"><?php the_title(); ?></h3>
                        <?php if (!empty($teamluzuk_designation)) { ?>
                            <span class="sliderteam-member-designation"><?php echo esc_html($teamluzuk_designation); ?></span>
                            <?php
                        } ?>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <script>
                    jQuery(document).ready(function() {
                        jQuery('.team-luzuk-slider .owl-carousel').owlCarousel({
                            autoplay:true,
                            autoplayTimeout:<?php echo esc_attr(get_option('teamslidertransitionduration')); ?>000,
                            loop: true,
                            nav: <?php echo esc_attr(get_option('ltfp_teamarrow')); ?>,
                            dots: <?php echo esc_attr(get_option('ltfp_teamdot')); ?>,
                            margin: 30,
                            responsiveClass: true,
                            responsive: {
                                0: {
                                    items: 1
                                },
                                600: {
                                    items:<?php echo esc_attr(get_option('teamsliderpostnumber')); ?>
                                },
                                1000: {
                                    items:<?php echo esc_attr(get_option('teamsliderpostnumber')); ?>,
                                    loop: true,
                                    margin: 12
                                }
                            }
                        })
                    })
                </script>
                <div class="clearfix"></div>          
            </div>
            <?php endwhile; ?>
        </div>
    </div>

<?php }  ?>

<?php
$text = ob_get_contents();
ob_clean();
endif;
wp_reset_postdata();
return $text;
}



function ltsmp_teampostShortCode2($pageId = null, $isCustomizer = false, $i = null) {
    global $ltsmp_options;

    $args = array('post_type' => 'our-lteam');
    if (!empty($pageId)) {
        $args['page_id'] = absint($pageId);
    }
    $args['posts_per_page'] = -1;
    $colCls = '';
    // if($isCustomizer == true){
    $cols = get_theme_mod('teamluzuk_npp_count', 2);
    $cols++;
    switch($cols){
        case 1:
            $colCls = 'luzuk-md-12 luzuk-sm-12 luzuk-xs-12';
            break;
        case 2:
            $colCls = 'luzuk-md-6 luzuk-sm-6 luzuk-xs-12';
            break;
        case 3:
        case 5:
        case 6:
            $colCls = 'luzuk-md-4 luzuk-sm-6 luzuk-xs-12';
            break;
        default:
            $colCls = 'luzuk-md-3 luzuk-sm-6 luzuk-xs-12';
            break;
    }
                
    // }
$text = '';
    $query = new WP_Query($args);
    if ($query->have_posts()):
        $postN = 0; ?>
<div class="team-luzuk-area"> 
    <?php

        while ($query->have_posts()) : $query->the_post();
            $luzuk_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'total-teamluzuk-thumb');
            if ($isCustomizer === true) {
                $teamluzuk_designation = get_theme_mod('teamluzuk_designation' . $i);
                $teamluzuk_facebook = get_theme_mod('teamluzuk_facebook' . $i);
                $teamluzuk_twitter = get_theme_mod('teamluzuk_twitter' . $i);
                $teamluzuk_linkedin = get_theme_mod('teamluzuk_linkedin' . $i);
                $teamluzuk_youtube = get_theme_mod('teamluzuk_youtube' . $i);
                $teamluzuk_instagram = get_theme_mod('teamluzuk_instagram' . $i);
                $teamluzuk_whatsapp = get_theme_mod('teamluzuk_whatsapp' . $i);
                
            } else {
                $teamluzuk_facebook = '';
                $teamluzuk_twitter = '';
                $teamluzuk_linkedin = '';
                $teamluzuk_youtube = '';
                $teamluzuk_instagram = '';
                $teamluzuk_whatsapp = '';
                $teamluzuk_designation = '';
            }

            $post = get_post();
            //Social media urls
            $teamluzukFacebook = get_post_meta($post->ID, 'teamluzukFacebook', false);
            $teamluzuk_facebook = !empty($teamluzukFacebook[0]) ? $teamluzukFacebook[0] : '';
            $teamluzukTwitter = get_post_meta($post->ID, 'teamluzukTwitter', false);
            $teamluzuk_twitter = !empty($teamluzukTwitter[0]) ? $teamluzukTwitter[0] : '';
            $teamluzuklinkedIn = get_post_meta($post->ID, 'teamluzuklinkedIn', false);
            $teamluzuk_linkedin = !empty($teamluzuklinkedIn[0]) ? $teamluzuklinkedIn[0] : '';
            $teamluzukyoutube = get_post_meta($post->ID, 'teamluzukyoutube', false);
            $teamluzuk_youtube = !empty($teamluzukyoutube[0]) ? $teamluzukyoutube[0] : '';
            $teamluzukinstagram = get_post_meta($post->ID, 'teamluzukinstagram', false);
            $teamluzuk_instagram = !empty($teamluzukinstagram[0]) ? $teamluzukinstagram[0] : '';
            $teamluzukwhatsapp = get_post_meta($post->ID, 'teamluzukwhatsapp', false);
            $teamluzuk_whatsapp = !empty($teamluzukwhatsapp[0]) ? $teamluzukwhatsapp[0] : '';

            //designation
            $designation = get_post_meta($post->ID, 'designation', false);
            $teamluzuk_designation = !empty($designation[0]) ? $designation[0] : '';

            
            ?>
     
                <div class="<?php echo esc_attr($colCls); ?> luzuk-s">
                    <div class="innerteampagebox3 wow zoomIn">
                        <div class="ht-team-member-image">
                            <?php
                            if (has_post_thumbnail()) {
                                $image_url = $luzuk_image[0];
                            } else {
                                $image_url = get_template_directory_uri() . '/images/default.png';
                            }
                            ?>                  
                            <img src="<?php echo esc_url($image_url); ?>" alt="<?php the_title(); ?>" />
                            <div class="team-member-content-overlay"></div>
                        </div>
                        <div class="ht-title-wrap3">
                            <div class="team-box3">
                                <h3 class="member-name"><?php the_title(); ?></h3>      
                                    <div class="innerteampagebox3-excerpt-wrap">
                                        <div class="ht-team-member-span">
                                            <?php if (!empty($teamluzuk_designation)) { ?>
                                                <div class="ht-team-designation"><?php echo esc_html($teamluzuk_designation); ?></div>
                                                <?php
                                            }?>

                                      </div>
                                  </div>
                              </div>
                              <div class="clearfix"></div>  
                               <?php if ($teamluzuk_facebook || $teamluzuk_twitter || $teamluzuk_linkedin || $teamluzuk_youtube || $teamluzuk_instagram || $teamluzuk_whatsapp ) { ?>
                                <div class="ht-team-social-id3">
                                    <?php if ($teamluzuk_facebook) { ?>
                                        <a target="_blank" href="<?php echo esc_url($teamluzuk_facebook) ?>"><i class="fab fa-facebook-f"></i></a>
                                    <?php } ?>
                                    <?php if ($teamluzuk_twitter) { ?>
                                        <a target="_blank" href="<?php echo esc_url($teamluzuk_twitter) ?>"><i class="fab fa-twitter"></i></a>
                                    <?php } ?>
                                     <?php if ($teamluzuk_linkedin) { ?>
                                        <a target="_blank" href="<?php echo esc_url($teamluzuk_linkedin) ?>"><i class="fab fa-linkedin-in"></i></a>
                                    <?php } ?>

                                    <?php if ($teamluzuk_youtube) { ?>
                                       <a target="_blank" href="<?php echo esc_url($teamluzuk_youtube) ?>"><i class="fab fa-youtube"></i></a>
                                    <?php } ?>
                                    <?php if ($teamluzuk_instagram) { ?>
                                    <a target="_blank" href="<?php echo esc_url($teamluzuk_instagram) ?>"><i class="fab fa-instagram"></i></a>
                                    <?php } ?>
                                     <?php if ($teamluzuk_whatsapp) { ?>
                                    <a target="_blank" href="<?php echo esc_url($teamluzuk_whatsapp) ?>"><i class="fab fa-whatsapp"></i></a>
                                    <?php } ?>
                                   
                                </div>                
                            <?php } ?>
                            
                        </div> 

                    <div class="clearfix"></div>  
                        <div class="clearfix"></div>

                    </div>

                <div class="clearfix"></div>          
            </div>

    <?php
    endwhile; ?>
    <div class="clearfix"></div>
</div>
    <?php
    $text = ob_get_contents();
    ob_clean();
endif;
wp_reset_postdata();
return $text;
}


function ltsmp_teampostShortCode2slider($pageId = null, $isCustomizer = false, $i = null) {

    ob_start();

    $args = array('post_type' => 'our-lteam');
    if (!empty($pageId)) {
        $args['page_id'] = absint($pageId);
    }
    $args['posts_per_page'] = -1;
    $colCls = '';
    // if($isCustomizer == true){
    $cols = get_theme_mod('teamluzuk_npp_count', 2);
    $cols++;
    switch($cols){
        case 1:
            $colCls = 'luzuk-md-12 luzuk-sm-12 luzuk-xs-12';
            break;
        case 2:
            $colCls = 'luzuk-md-6 luzuk-sm-6 luzuk-xs-12';
            break;
        case 3:
        case 5:
        case 6:
            $colCls = 'luzuk-md-4 luzuk-sm-6 luzuk-xs-12';
            break;
        default:
            $colCls = 'luzuk-md-3 luzuk-sm-6 luzuk-xs-12';
            break;
    }
                
    // }
    $text = '';
    $query = new WP_Query($args);
    if ($query->have_posts()):
        $postN = 0; ?>
 <?php ?>
<div class="team-luzuk-slider team-luzuk-area">
<div class="owl-carousel owl-theme">
    <?php
        while ($query->have_posts()) : $query->the_post();
            $luzuk_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'total-teamluzuk-thumb');
            if ($isCustomizer === true) {
                $teamluzuk_designation = get_theme_mod('teamluzuk_designation' . $i);
                $teamluzuk_facebook = get_theme_mod('teamluzuk_facebook' . $i);
                $teamluzuk_twitter = get_theme_mod('teamluzuk_twitter' . $i);
                $teamluzuk_linkedin = get_theme_mod('teamluzuk_linkedin' . $i);
                $teamluzuk_youtube = get_theme_mod('teamluzuk_youtube' . $i);
                $teamluzuk_instagram = get_theme_mod('teamluzuk_instagram' . $i);
                $teamluzuk_whatsapp = get_theme_mod('teamluzuk_whatsapp' . $i);
                
            } else {
                $teamluzuk_facebook = '';
                $teamluzuk_twitter = '';
                $teamluzuk_linkedin = '';
                $teamluzuk_youtube = '';
                $teamluzuk_instagram = '';
                $teamluzuk_whatsapp = '';
                $teamluzuk_designation = '';
            }

            $post = get_post();
            //Social media urls
            $teamluzukFacebook = get_post_meta($post->ID, 'teamluzukFacebook', false);
            $teamluzuk_facebook = !empty($teamluzukFacebook[0]) ? $teamluzukFacebook[0] : '';
            $teamluzukTwitter = get_post_meta($post->ID, 'teamluzukTwitter', false);
            $teamluzuk_twitter = !empty($teamluzukTwitter[0]) ? $teamluzukTwitter[0] : '';
            $teamluzuklinkedIn = get_post_meta($post->ID, 'teamluzuklinkedIn', false);
            $teamluzuk_linkedin = !empty($teamluzuklinkedIn[0]) ? $teamluzuklinkedIn[0] : '';
            $teamluzukyoutube = get_post_meta($post->ID, 'teamluzukyoutube', false);
            $teamluzuk_youtube = !empty($teamluzukyoutube[0]) ? $teamluzukyoutube[0] : '';
            $teamluzukinstagram = get_post_meta($post->ID, 'teamluzukinstagram', false);
            $teamluzuk_instagram = !empty($teamluzukinstagram[0]) ? $teamluzukinstagram[0] : '';
            $teamluzukwhatsapp = get_post_meta($post->ID, 'teamluzukwhatsapp', false);
            $teamluzuk_whatsapp = !empty($teamluzukwhatsapp[0]) ? $teamluzukwhatsapp[0] : '';

            //designation
            $designation = get_post_meta($post->ID, 'designation', false);
            $teamluzuk_designation = !empty($designation[0]) ? $designation[0] : '';

            
            ?>
      
                <div class="item">
                    <div class="innerteampagebox3 wow zoomIn">
                        <div class="ht-team-member-image">
                            <?php
                            if (has_post_thumbnail()) {
                                $image_url = $luzuk_image[0];
                            } else {
                                $image_url = get_template_directory_uri() . '/images/default.png';
                            }
                            ?>                  
                            <img src="<?php echo esc_url($image_url); ?>" alt="<?php the_title(); ?>" />
                            <div class="team-member-content-overlay"></div>
                        </div>
                        <div class="ht-title-wrap3">
                            <div class="team-box3">
                                <h3 class="member-name"><?php the_title(); ?></h3>      
                                    <div class="innerteampagebox3-excerpt-wrap">
                                        <div class="ht-team-member-span">
                                            <?php if (!empty($teamluzuk_designation)) { ?>
                                                <div class="ht-team-designation"><?php echo esc_html($teamluzuk_designation); ?></div>
                                                <?php
                                            }?>

                                      </div>
                                  </div>
                              </div>
                              <div class="clearfix"></div>  
                              <?php if ($teamluzuk_facebook || $teamluzuk_twitter || $teamluzuk_linkedin || $teamluzuk_youtube || $teamluzuk_instagram || $teamluzuk_whatsapp ) { ?>
                                <div class="ht-team-social-id3">
                                    <?php if ($teamluzuk_facebook) { ?>
                                        <a target="_blank" href="<?php echo esc_url($teamluzuk_facebook) ?>"><i class="fab fa-facebook-f"></i></a>
                                    <?php } ?>
                                    <?php if ($teamluzuk_twitter) { ?>
                                        <a target="_blank" href="<?php echo esc_url($teamluzuk_twitter) ?>"><i class="fab fa-twitter"></i></a>
                                    <?php } ?>
                                     <?php if ($teamluzuk_linkedin) { ?>
                                        <a target="_blank" href="<?php echo esc_url($teamluzuk_linkedin) ?>"><i class="fab fa-linkedin-in"></i></a>
                                    <?php } ?>

                                    <?php if ($teamluzuk_youtube) { ?>
                                       <a target="_blank" href="<?php echo esc_url($teamluzuk_youtube) ?>"><i class="fab fa-youtube"></i></a>
                                    <?php } ?>
                                    <?php if ($teamluzuk_instagram) { ?>
                                    <a target="_blank" href="<?php echo esc_url($teamluzuk_instagram) ?>"><i class="fab fa-instagram"></i></a>
                                <?php } ?>
                                 <?php if ($teamluzuk_whatsapp) { ?>
                                    <a target="_blank" href="<?php echo esc_url($teamluzuk_whatsapp) ?>"><i class="fab fa-whatsapp"></i></a>
                                <?php } ?>
                                   
                                </div>                
                            <?php } ?>
                            <!--  </div> -->
                        </div> 

                    </div>
<script>
    jQuery(document).ready(function() {
      jQuery('.team-luzuk-slider .owl-carousel').owlCarousel({
        slideSpeed : 1500,
        autoplay: true,
        loop: true,
        margin: 30,
        responsiveClass: true,
        responsive: {
          0: {
            items: 1,
            nav: true
          },
          600: {
            items:2,
            nav: true
          },
          1000: {
            items:3,
            nav: true,
            loop: true,
            margin: 12
          }
        }
      })
    })
</script>
    <div class="clearfix"></div>          
</div>

    <?php
    endwhile;
    ?>
    </div>
</div>
    <?php

    $text = ob_get_contents();
    ob_clean();
endif;
wp_reset_postdata();
return $text;
}


function ltsmp_teampostShortCode3($pageId = null, $isCustomizer = false, $i = null) {
    global $ltsmp_options;

    $args = array('post_type' => 'our-lteam');
    if (!empty($pageId)) {
        $args['page_id'] = absint($pageId);
    }
    $args['posts_per_page'] = -1;
    $colCls = '';
    // if($isCustomizer == true){
    $cols = get_theme_mod('teamluzuk_npp_count', 2);
    $cols++;
    switch($cols){
        case 1:
            $colCls = 'luzuk-md-12 luzuk-sm-12 luzuk-xs-12';
            break;
        case 2:
            $colCls = 'luzuk-md-6 luzuk-sm-6 luzuk-xs-12';
            break;
        case 3:
        case 5:
        case 6:
            $colCls = 'luzuk-md-4 luzuk-sm-6 luzuk-xs-12';
            break;
        default:
            $colCls = 'luzuk-md-3 luzuk-sm-6 luzuk-xs-12';
            break;
    }
                
    // }
$text = '';
    $query = new WP_Query($args);
    if ($query->have_posts()):
        $postN = 0; ?>
<div class="team-luzuk-area"> 
    <?php

        while ($query->have_posts()) : $query->the_post();
            $luzuk_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'total-teamluzuk-thumb');
             if ($isCustomizer === true) {
                $teamluzuk_designation = get_theme_mod('teamluzuk_designation' . $i);
                $teamluzuk_facebook = get_theme_mod('teamluzuk_facebook' . $i);
                $teamluzuk_twitter = get_theme_mod('teamluzuk_twitter' . $i);
                $teamluzuk_linkedin = get_theme_mod('teamluzuk_linkedin' . $i);
                $teamluzuk_youtube = get_theme_mod('teamluzuk_youtube' . $i);
                $teamluzuk_instagram = get_theme_mod('teamluzuk_instagram' . $i);
                $teamluzuk_whatsapp = get_theme_mod('teamluzuk_whatsapp' . $i);
                
            } else {
                $teamluzuk_facebook = '';
                $teamluzuk_twitter = '';
                $teamluzuk_linkedin = '';
                $teamluzuk_youtube = '';
                $teamluzuk_instagram = '';
                $teamluzuk_whatsapp = '';
                $teamluzuk_designation = '';
            }

            $post = get_post();
            //Social media urls
            $teamluzukFacebook = get_post_meta($post->ID, 'teamluzukFacebook', false);
            $teamluzuk_facebook = !empty($teamluzukFacebook[0]) ? $teamluzukFacebook[0] : '';
            $teamluzukTwitter = get_post_meta($post->ID, 'teamluzukTwitter', false);
            $teamluzuk_twitter = !empty($teamluzukTwitter[0]) ? $teamluzukTwitter[0] : '';
            $teamluzuklinkedIn = get_post_meta($post->ID, 'teamluzuklinkedIn', false);
            $teamluzuk_linkedin = !empty($teamluzuklinkedIn[0]) ? $teamluzuklinkedIn[0] : '';
            $teamluzukyoutube = get_post_meta($post->ID, 'teamluzukyoutube', false);
            $teamluzuk_youtube = !empty($teamluzukyoutube[0]) ? $teamluzukyoutube[0] : '';
            $teamluzukinstagram = get_post_meta($post->ID, 'teamluzukinstagram', false);
            $teamluzuk_instagram = !empty($teamluzukinstagram[0]) ? $teamluzukinstagram[0] : '';
            $teamluzukwhatsapp = get_post_meta($post->ID, 'teamluzukwhatsapp', false);
            $teamluzuk_whatsapp = !empty($teamluzukwhatsapp[0]) ? $teamluzukwhatsapp[0] : '';

            //designation
            $designation = get_post_meta($post->ID, 'designation', false);
            $teamluzuk_designation = !empty($designation[0]) ? $designation[0] : '';

            
            ?>
                <div class="<?php echo esc_attr($colCls); ?> luzuk-s">
                    <div class="innerteampagebox4 wow zoomIn">
                        <div class="lt-team-member-image">
                            <?php
                            if (has_post_thumbnail()) {
                                $image_url = $luzuk_image[0];
                            } else {
                                $image_url = get_template_directory_uri() . '/images/default.png';
                            }
                            ?>                  
                            <img src="<?php echo esc_url($image_url); ?>" alt="<?php the_title(); ?>" />
                             <?php if ($teamluzuk_facebook || $teamluzuk_twitter || $teamluzuk_linkedin || $teamluzuk_youtube || $teamluzuk_instagram || $teamluzuk_whatsapp ) { ?>
                                <ul class="lt-team-social-id4">
                                    <?php if ($teamluzuk_facebook) { ?>
                                        <li><a target="_blank" href="<?php echo esc_url($teamluzuk_facebook) ?>"><i class="fab fa-facebook-f"></i></a></li>
                                    <?php } ?>
                                    <?php if ($teamluzuk_twitter) { ?>
                                        <li><a target="_blank" href="<?php echo esc_url($teamluzuk_twitter) ?>"><i class="fab fa-twitter"></i></a></li>
                                    <?php } ?>
                                     <?php if ($teamluzuk_linkedin) { ?>
                                        <li><a target="_blank" href="<?php echo esc_url($teamluzuk_linkedin) ?>"><i class="fab fa-linkedin-in"></i></a></li>
                                    <?php } ?>

                                    <?php if ($teamluzuk_youtube) { ?>
                                       <li><a target="_blank" href="<?php echo esc_url($teamluzuk_youtube) ?>"><i class="fab fa-youtube"></i></a></li>
                                    <?php } ?>
                                    <?php if ($teamluzuk_instagram) { ?>
                                        <li><a target="_blank" href="<?php echo esc_url($teamluzuk_instagram) ?>"><i class="fab fa-instagram"></i></a></li>
                                    <?php } ?>
                                     <?php if ($teamluzuk_whatsapp) { ?>
                                        <li><a target="_blank" href="<?php echo esc_url($teamluzuk_whatsapp) ?>"><i class="fab fa-whatsapp"></i></a></li>
                                    <?php } ?>
                                   
                                </ul>                
                            <?php } ?>
                        </div>
                            <div class="team-box4">
                                <h3 class="member-name"><?php the_title(); ?></h3>   
                                    <?php if (!empty($teamluzuk_designation)) { ?>
                                        <div class="lt-team-designation"><?php echo esc_html($teamluzuk_designation); ?></div>
                                        <?php
                                    }?>
                            </div>
                            <div class="team-layer">
                                <a><?php the_title(); ?></a>
                                <?php if (!empty($teamluzuk_designation)) { ?>
                                    <div class="lt-team-designation"><?php echo esc_html($teamluzuk_designation); ?></div>
                                    <?php
                                }?>
                            </div>
 <div class="clearfix"></div>  

    </div>

    <div class="clearfix"></div>          
</div>

          <?php
    endwhile; ?>
    <div class="clearfix"></div>
</div>
    <?php
    $text = ob_get_contents();
    ob_clean();
endif;
wp_reset_postdata();
return $text;
}

function ltsmp_teampostShortCode3slider($pageId = null, $isCustomizer = false, $i = null) {

    ob_start();

    $args = array('post_type' => 'our-lteam');
    if (!empty($pageId)) {
        $args['page_id'] = absint($pageId);
    }
    $args['posts_per_page'] = -1;
    $colCls = '';
    // if($isCustomizer == true){
    $cols = get_theme_mod('teamluzuk_npp_count', 2);
    $cols++;
    switch($cols){
        case 1:
            $colCls = 'luzuk-md-12 luzuk-sm-12 luzuk-xs-12';
            break;
        case 2:
            $colCls = 'luzuk-md-6 luzuk-sm-6 luzuk-xs-12';
            break;
        case 3:
        case 5:
        case 6:
            $colCls = 'luzuk-md-4 luzuk-sm-6 luzuk-xs-12';
            break;
        default:
            $colCls = 'luzuk-md-3 luzuk-sm-6 luzuk-xs-12';
            break;
    }
                
    // }
    $text = '';
    $query = new WP_Query($args);
    if ($query->have_posts()):
        $postN = 0;
?>
<div class="team-luzuk-slider team-luzuk-area">
<div class="owl-carousel owl-theme">
    <?php
        while ($query->have_posts()) : $query->the_post();
            $luzuk_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'total-teamluzuk-thumb');
             if ($isCustomizer === true) {
                $teamluzuk_designation = get_theme_mod('teamluzuk_designation' . $i);
                $teamluzuk_facebook = get_theme_mod('teamluzuk_facebook' . $i);
                $teamluzuk_twitter = get_theme_mod('teamluzuk_twitter' . $i);
                $teamluzuk_linkedin = get_theme_mod('teamluzuk_linkedin' . $i);
                $teamluzuk_youtube = get_theme_mod('teamluzuk_youtube' . $i);
                $teamluzuk_instagram = get_theme_mod('teamluzuk_instagram' . $i);
                $teamluzuk_whatsapp = get_theme_mod('teamluzuk_whatsapp' . $i);
                
            } else {
                $teamluzuk_facebook = '';
                $teamluzuk_twitter = '';
                $teamluzuk_linkedin = '';
                $teamluzuk_youtube = '';
                $teamluzuk_instagram = '';
                $teamluzuk_whatsapp = '';
                $teamluzuk_designation = '';
            }

            $post = get_post();
            //Social media urls
            $teamluzukFacebook = get_post_meta($post->ID, 'teamluzukFacebook', false);
            $teamluzuk_facebook = !empty($teamluzukFacebook[0]) ? $teamluzukFacebook[0] : '';
            $teamluzukTwitter = get_post_meta($post->ID, 'teamluzukTwitter', false);
            $teamluzuk_twitter = !empty($teamluzukTwitter[0]) ? $teamluzukTwitter[0] : '';
            $teamluzuklinkedIn = get_post_meta($post->ID, 'teamluzuklinkedIn', false);
            $teamluzuk_linkedin = !empty($teamluzuklinkedIn[0]) ? $teamluzuklinkedIn[0] : '';
            $teamluzukyoutube = get_post_meta($post->ID, 'teamluzukyoutube', false);
            $teamluzuk_youtube = !empty($teamluzukyoutube[0]) ? $teamluzukyoutube[0] : '';
            $teamluzukinstagram = get_post_meta($post->ID, 'teamluzukinstagram', false);
            $teamluzuk_instagram = !empty($teamluzukinstagram[0]) ? $teamluzukinstagram[0] : '';
            $teamluzukwhatsapp = get_post_meta($post->ID, 'teamluzukwhatsapp', false);
            $teamluzuk_whatsapp = !empty($teamluzukwhatsapp[0]) ? $teamluzukwhatsapp[0] : '';

            //designation
            $designation = get_post_meta($post->ID, 'designation', false);
            $teamluzuk_designation = !empty($designation[0]) ? $designation[0] : '';

            
            ?>
                <div class="item">
                    <div class="innerteampagebox4 wow zoomIn">
                        <div class="lt-team-member-image">
                            <?php
                            if (has_post_thumbnail()) {
                                $image_url = $luzuk_image[0];
                            } else {
                                $image_url = get_template_directory_uri() . '/images/default.png';
                            }
                            ?>                  
                            <img src="<?php echo esc_url($image_url); ?>" alt="<?php the_title(); ?>" />
                             <?php if ($teamluzuk_facebook || $teamluzuk_twitter || $teamluzuk_linkedin || $teamluzuk_youtube || $teamluzuk_instagram || $teamluzuk_whatsapp ) { ?>
                                <ul class="lt-team-social-id4">
                                    <?php if ($teamluzuk_facebook) { ?>
                                        <li><a target="_blank" href="<?php echo esc_url($teamluzuk_facebook) ?>"><i class="fab fa-facebook-f"></i></a></li>
                                    <?php } ?>
                                    <?php if ($teamluzuk_twitter) { ?>
                                        <li><a target="_blank" href="<?php echo esc_url($teamluzuk_twitter) ?>"><i class="fab fa-twitter"></i></a></li>
                                    <?php } ?>
                                     <?php if ($teamluzuk_linkedin) { ?>
                                        <li><a target="_blank" href="<?php echo esc_url($teamluzuk_linkedin) ?>"><i class="fab fa-linkedin-in"></i></a></li>
                                    <?php } ?>

                                    <?php if ($teamluzuk_youtube) { ?>
                                       <li><a target="_blank" href="<?php echo esc_url($teamluzuk_youtube) ?>"><i class="fab fa-youtube"></i></a></li>
                                    <?php } ?>
                                    <?php if ($teamluzuk_instagram) { ?>
                                        <li><a target="_blank" href="<?php echo esc_url($teamluzuk_instagram) ?>"><i class="fab fa-instagram"></i></a></li>
                                    <?php } ?>
                                     <?php if ($teamluzuk_whatsapp) { ?>
                                        <li><a target="_blank" href="<?php echo esc_url($teamluzuk_whatsapp) ?>"><i class="fab fa-whatsapp"></i></a></li>
                                    <?php } ?>
                                   
                                </ul>                
                            <?php } ?>
                        </div>
                            <div class="team-box4">
                                <h3 class="member-name"><?php the_title(); ?></h3>   
                                    <?php if (!empty($teamluzuk_designation)) { ?>
                                        <div class="lt-team-designation"><?php echo esc_html($teamluzuk_designation); ?></div>
                                        <?php
                                    }?>
                            </div>
                            <div class="team-layer">
                                <a><?php the_title(); ?></a>
                                <?php if (!empty($teamluzuk_designation)) { ?>
                                  <div class="lt-team-designation"><?php echo esc_html($teamluzuk_designation); ?></div>
                                <?php
                                }?>
                            </div>
                               

    </div>
<script>
    jQuery(document).ready(function() {
      jQuery('.team-luzuk-slider .owl-carousel').owlCarousel({
        slideSpeed : 1500,
        autoplay: true,
        loop: true,
        margin: 30,
        responsiveClass: true,
        responsive: {
          0: {
            items: 1,
            nav: true
          },
          600: {
            items:2,
            nav: true
          },
          1000: {
            items:3,
            nav: true,
            loop: true,
            margin: 12
          }
        }
      })
    })
</script>

    <div class="clearfix"></div>          
</div>

<?php
    endwhile;
    ?>
    </div>
</div>
    <?php
    $text = ob_get_contents();
    ob_clean();
endif;
wp_reset_postdata();
return $text;
}


function ltsmp_teampostShortCode4($pageId = null, $isCustomizer = false, $i = null) {
    global $ltsmp_options;

    $args = array('post_type' => 'our-lteam');
    if (!empty($pageId)) {
        $args['page_id'] = absint($pageId);
    }
    $args['posts_per_page'] = -1;
    $colCls = '';
    // if($isCustomizer == true){
    $cols = get_theme_mod('teamluzuk_npp_count', 2);
    $cols++;
    switch($cols){
        case 1:
            $colCls = 'luzuk-md-12 luzuk-sm-12 luzuk-xs-12';
            break;
        case 2:
            $colCls = 'luzuk-md-6 luzuk-sm-6 luzuk-xs-12';
            break;
        case 3:
        case 5:
        case 6:
            $colCls = 'luzuk-md-4 luzuk-sm-6 luzuk-xs-12';
            break;
        default:
            $colCls = 'luzuk-md-3 luzuk-sm-6 luzuk-xs-12';
            break;
    }
                
    // }
$text = '';
    $query = new WP_Query($args);
    if ($query->have_posts()):
        $postN = 0; ?>
<div class="team-luzuk-area"> 
    <?php

        while ($query->have_posts()) : $query->the_post();
            $luzuk_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'total-teamluzuk-thumb');
              if ($isCustomizer === true) {
                $teamluzuk_designation = get_theme_mod('teamluzuk_designation' . $i);
                $teamluzuk_facebook = get_theme_mod('teamluzuk_facebook' . $i);
                $teamluzuk_twitter = get_theme_mod('teamluzuk_twitter' . $i);
                $teamluzuk_linkedin = get_theme_mod('teamluzuk_linkedin' . $i);
                $teamluzuk_youtube = get_theme_mod('teamluzuk_youtube' . $i);
                $teamluzuk_instagram = get_theme_mod('teamluzuk_instagram' . $i);
                $teamluzuk_whatsapp = get_theme_mod('teamluzuk_whatsapp' . $i);
                
            } else {
                $teamluzuk_facebook = '';
                $teamluzuk_twitter = '';
                $teamluzuk_linkedin = '';
                $teamluzuk_youtube = '';
                $teamluzuk_instagram = '';
                $teamluzuk_whatsapp = '';
                $teamluzuk_designation = '';
            }

            $post = get_post();
            //Social media urls
            $teamluzukFacebook = get_post_meta($post->ID, 'teamluzukFacebook', false);
            $teamluzuk_facebook = !empty($teamluzukFacebook[0]) ? $teamluzukFacebook[0] : '';
            $teamluzukTwitter = get_post_meta($post->ID, 'teamluzukTwitter', false);
            $teamluzuk_twitter = !empty($teamluzukTwitter[0]) ? $teamluzukTwitter[0] : '';
            $teamluzuklinkedIn = get_post_meta($post->ID, 'teamluzuklinkedIn', false);
            $teamluzuk_linkedin = !empty($teamluzuklinkedIn[0]) ? $teamluzuklinkedIn[0] : '';
            $teamluzukyoutube = get_post_meta($post->ID, 'teamluzukyoutube', false);
            $teamluzuk_youtube = !empty($teamluzukyoutube[0]) ? $teamluzukyoutube[0] : '';
            $teamluzukinstagram = get_post_meta($post->ID, 'teamluzukinstagram', false);
            $teamluzuk_instagram = !empty($teamluzukinstagram[0]) ? $teamluzukinstagram[0] : '';
            $teamluzukwhatsapp = get_post_meta($post->ID, 'teamluzukwhatsapp', false);
            $teamluzuk_whatsapp = !empty($teamluzukwhatsapp[0]) ? $teamluzukwhatsapp[0] : '';

          
            //designation
            $designation = get_post_meta($post->ID, 'designation', false);
            $teamluzuk_designation = !empty($designation[0]) ? $designation[0] : '';

            
            ?>
         <!--  <div class="row"> -->
                <div class="<?php echo esc_attr($colCls); ?> luzuk-s">
                    <div class="innerteampagebox5 wow zoomIn">
                        <div class="lt-team-member-image5">
                            <?php
                            if (has_post_thumbnail()) {
                                $image_url = $luzuk_image[0];
                            } else {
                                $image_url = get_template_directory_uri() . '/images/default.png';
                            }
                            ?>                  
                            <img class="secondry-bg" src="<?php echo esc_url($image_url); ?>" alt="<?php the_title(); ?>" />
                        </div>
                             <?php if ($teamluzuk_facebook || $teamluzuk_twitter || $teamluzuk_linkedin || $teamluzuk_youtube || $teamluzuk_instagram || $teamluzuk_whatsapp ) { ?>
                        <div class="lt-team-socialbox5">        
                            <ul class="icon lt-team-social-id5">
                            <?php if ($teamluzuk_facebook) { ?>
                                <li><a target="_blank" href="<?php echo esc_url($teamluzuk_facebook) ?>"><i class="fab fa-facebook-f"></i></a></li>
                                <?php } ?>
                                <?php if ($teamluzuk_twitter) { ?>
                                 <li><a target="_blank" href="<?php echo esc_url($teamluzuk_twitter) ?>"><i class="fab fa-twitter"></i></a> </li>
                                <?php } ?>
                                 <?php if ($teamluzuk_linkedin) { ?>
                                <li><a target="_blank" href="<?php echo esc_url($teamluzuk_linkedin) ?>"><i class="fab fa-linkedin-in"></i></a></li>
                                <?php } ?>
                                <?php if ($teamluzuk_youtube) { ?>
                                <li><a target="_blank" href="<?php echo esc_url($teamluzuk_youtube) ?>"><i class="fab fa-youtube"></i></a></li>
                                <?php } ?>
                                <?php if ($teamluzuk_instagram) { ?>
                                <li><a target="_blank" href="<?php echo esc_url($teamluzuk_instagram) ?>"><i class="fab fa-instagram"></i></a></li>
                                <?php } ?>
                                 <?php if ($teamluzuk_whatsapp) { ?>
                                <li><a target="_blank" href="<?php echo esc_url($teamluzuk_whatsapp) ?>"><i class="fab fa-whatsapp"></i></a></li>
                                <?php } ?>
                                <div class="clearfix"></div>
                            </ul>
                        </div>
                          <?php } ?>

                          <div class="lt-title-wrap5">
                             
                                <div class="team-box5">
                                    <h3 class="member-name5"><?php the_title(); ?></h3>  
                                    <div class="ht-team-member-excerpt-wrap5">
                                        <div class="ht-team-member-span5">
                                            <?php if (!empty($teamluzuk_designation)) { ?>
                                            <div class="team-member-designation5"><?php echo esc_html($teamluzuk_designation); ?></div>
                                            <?php
                                            } ?>
                                        </div>
                                    </div>
                                </div>
                        </div> 





    <div class="clearfix"></div>
                    </div>
                <div class="clearfix"></div>          
            </div>
    <?php
    endwhile; ?>
    <div class="clearfix"></div>
</div>
    <?php
    $text = ob_get_contents();
    ob_clean();
endif;
wp_reset_postdata();
return $text;
}

function ltsmp_teampostShortCode4slider($pageId = null, $isCustomizer = false, $i = null) {

    ob_start();

    $args = array('post_type' => 'our-lteam');
    if (!empty($pageId)) {
        $args['page_id'] = absint($pageId);
    }
    $args['posts_per_page'] = -1;
    $colCls = '';
    // if($isCustomizer == true){
    $cols = get_theme_mod('teamluzuk_npp_count', 2);
    $cols++;
    switch($cols){
        case 1:
            $colCls = 'luzuk-md-12 luzuk-sm-12 luzuk-xs-12';
            break;
        case 2:
            $colCls = 'luzuk-md-6 luzuk-sm-6 luzuk-xs-12';
            break;
        case 3:
        case 5:
        case 6:
            $colCls = 'luzuk-md-4 luzuk-sm-6 luzuk-xs-12';
            break;
        default:
            $colCls = 'luzuk-md-3 luzuk-sm-6 luzuk-xs-12';
            break;
    }
                
    // }
    $text = '';
    $query = new WP_Query($args);
    if ($query->have_posts()):
        $postN = 0;
?>
<div class="team-luzuk-slider team-luzuk-area">
<div class="owl-carousel owl-theme">
    <?php
        while ($query->have_posts()) : $query->the_post();
            $luzuk_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'total-teamluzuk-thumb');
              if ($isCustomizer === true) {
                $teamluzuk_designation = get_theme_mod('teamluzuk_designation' . $i);
                $teamluzuk_facebook = get_theme_mod('teamluzuk_facebook' . $i);
                $teamluzuk_twitter = get_theme_mod('teamluzuk_twitter' . $i);
                $teamluzuk_linkedin = get_theme_mod('teamluzuk_linkedin' . $i);
                $teamluzuk_youtube = get_theme_mod('teamluzuk_youtube' . $i);
                $teamluzuk_instagram = get_theme_mod('teamluzuk_instagram' . $i);
                $teamluzuk_whatsapp = get_theme_mod('teamluzuk_whatsapp' . $i);
                
            } else {
                $teamluzuk_facebook = '';
                $teamluzuk_twitter = '';
                $teamluzuk_linkedin = '';
                $teamluzuk_youtube = '';
                $teamluzuk_instagram = '';
                $teamluzuk_whatsapp = '';
                $teamluzuk_designation = '';
            }

            $post = get_post();
            //Social media urls
            $teamluzukFacebook = get_post_meta($post->ID, 'teamluzukFacebook', false);
            $teamluzuk_facebook = !empty($teamluzukFacebook[0]) ? $teamluzukFacebook[0] : '';
            $teamluzukTwitter = get_post_meta($post->ID, 'teamluzukTwitter', false);
            $teamluzuk_twitter = !empty($teamluzukTwitter[0]) ? $teamluzukTwitter[0] : '';
            $teamluzuklinkedIn = get_post_meta($post->ID, 'teamluzuklinkedIn', false);
            $teamluzuk_linkedin = !empty($teamluzuklinkedIn[0]) ? $teamluzuklinkedIn[0] : '';
            $teamluzukyoutube = get_post_meta($post->ID, 'teamluzukyoutube', false);
            $teamluzuk_youtube = !empty($teamluzukyoutube[0]) ? $teamluzukyoutube[0] : '';
            $teamluzukinstagram = get_post_meta($post->ID, 'teamluzukinstagram', false);
            $teamluzuk_instagram = !empty($teamluzukinstagram[0]) ? $teamluzukinstagram[0] : '';
            $teamluzukwhatsapp = get_post_meta($post->ID, 'teamluzukwhatsapp', false);
            $teamluzuk_whatsapp = !empty($teamluzukwhatsapp[0]) ? $teamluzukwhatsapp[0] : '';

          
            //designation
            $designation = get_post_meta($post->ID, 'designation', false);
            $teamluzuk_designation = !empty($designation[0]) ? $designation[0] : '';

            
            ?>
         <!--  <div class="row"> -->
                <div class="item">
                    <div class="innerteampagebox5 wow zoomIn">
                        <div class="lt-team-member-image5">
                            <?php
                            if (has_post_thumbnail()) {
                                $image_url = $luzuk_image[0];
                            } else {
                                $image_url = get_template_directory_uri() . '/images/default.png';
                            }
                            ?>                  
                            <img class="secondry-bg" src="<?php echo esc_url($image_url); ?>" alt="<?php the_title(); ?>" />
                        </div>
                             <?php if ($teamluzuk_facebook || $teamluzuk_twitter || $teamluzuk_linkedin || $teamluzuk_youtube || $teamluzuk_instagram || $teamluzuk_whatsapp ) { ?>
                        <div class="lt-team-socialbox5">        
                            <ul class="icon lt-team-social-id5">
                            <?php if ($teamluzuk_facebook) { ?>
                                <li><a target="_blank" href="<?php echo esc_url($teamluzuk_facebook) ?>"><i class="fab fa-facebook-f"></i></a></li>
                                <?php } ?>
                                <?php if ($teamluzuk_twitter) { ?>
                                 <li><a target="_blank" href="<?php echo esc_url($teamluzuk_twitter) ?>"><i class="fab fa-twitter"></i></a> </li>
                                <?php } ?>
                                 <?php if ($teamluzuk_linkedin) { ?>
                                <li><a target="_blank" href="<?php echo esc_url($teamluzuk_linkedin) ?>"><i class="fab fa-linkedin-in"></i></a></li>
                                <?php } ?>
                                <?php if ($teamluzuk_youtube) { ?>
                                <li><a target="_blank" href="<?php echo esc_url($teamluzuk_youtube) ?>"><i class="fab fa-youtube"></i></a></li>
                                <?php } ?>
                                <?php if ($teamluzuk_instagram) { ?>
                                <li><a target="_blank" href="<?php echo esc_url($teamluzuk_instagram) ?>"><i class="fab fa-instagram"></i></a></li>
                                <?php } ?>
                                 <?php if ($teamluzuk_whatsapp) { ?>
                                <li><a target="_blank" href="<?php echo esc_url($teamluzuk_whatsapp) ?>"><i class="fab fa-whatsapp"></i></a></li>
                                <?php } ?>
                                <div class="clearfix"></div>
                            </ul>
                        </div>
                          <?php } ?>

                          <div class="lt-title-wrap5">
                             
                                <div class="team-box5">
                                    <h3 class="member-name5"><?php the_title(); ?></h3>  
                                    <div class="ht-team-member-excerpt-wrap5">
                                        <div class="ht-team-member-span5">
                                            <?php if (!empty($teamluzuk_designation)) { ?>
                                            <div class="team-member-designation5"><?php echo esc_html($teamluzuk_designation); ?></div>
                                            <?php
                                            } ?>
                                        </div>
                                    </div>
                                </div>
                        </div> 

                    </div>

                    <script>
              jQuery(document).ready(function() {
                jQuery('.team-luzuk-slider .owl-carousel').owlCarousel({
                  slideSpeed : 1500,
                  autoplay: true,
                  loop: true,
                  margin: 30,
                  responsiveClass: true,
                  responsive: {
                    0: {
                      items: 1,
                      nav: true
                    },
                    600: {
                      items:2,
                      nav: true
                    },
                    1000: {
                      items:3,
                      nav: true,
                      loop: true,
                      margin: 12
                    }
                  }
                })
              })
          </script>

          <div class="clearfix"></div>          
      </div>
<?php
    endwhile;
    ?>
    </div>
</div>
    <?php
    $text = ob_get_contents();
    ob_clean();
endif;
wp_reset_postdata();
return $text;
}


//adding a shortcode for the team / trainer list 
    add_shortcode('luzukteam_innerpage', 'ltsmp_teampostShortCode1');
    //adding a shortcode for the team / trainer list with slider
    add_shortcode('luzukteam_slider', 'ltsmp_teampostShortCode1slider');

       //adding a shortcode for the team / trainer list without slider
    add_shortcode('TEAMMEMBER2', 'ltsmp_teampostShortCode2');
 //adding a shortcode for the team / trainer list with slider
    // add_shortcode('TEAMMEMBER2SLIDER', 'ltsmp_teampostShortCode2slider');
//adding a shortcode for the team / trainer list 
    // add_shortcode('TEAMMEMBER3', 'ltsmp_teampostShortCode3');
           //adding a shortcode for the team / trainer list without slider
    // add_shortcode('TEAMMEMBER3SLIDER', 'ltsmp_teampostShortCode3slider');
    //adding a shortcode for the team / trainer list 
    // add_shortcode('TEAMMEMBER4', 'ltsmp_teampostShortCode4');
            //adding a shortcode for the team / trainer list without slider
    // add_shortcode('TEAMMEMBER4SLIDER', 'ltsmp_teampostShortCode4slider');
    
?>