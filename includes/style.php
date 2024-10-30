<?php
/**
 * @package Luzuk Premium
 */

function ltsmp_totallt_dymanic_styles() {

    $ltsmp_options="";
    $ltsmp_options = get_option('ltsmp_options');

    global $post;

      $custom_css = '';


// teaminnerpage 1

if (isset($ltsmp_options['ltp_option_imgheight'])){
  $teamimageheight = $ltsmp_options['ltp_option_imgheight'];
}else{
  $teamimageheight = '325';
}

if (isset($ltsmp_options['toneimghovercolor'])){
  $teaminnerimgimghoverupborderColor = $ltsmp_options['toneimghovercolor'];
}else{
  $teaminnerimgimghoverupborderColor = '#FFFFFF';
}

if (isset($ltsmp_options['tonemembercolor'])){
  $teaminnermembernametextColor = $ltsmp_options['tonemembercolor'];
}else{
  $teaminnermembernametextColor = '#000000';
}

if (isset($ltsmp_options['tonememberdesigcolor'])){
  $teaminnermemberdesignationtextColor = $ltsmp_options['tonememberdesigcolor'];
}else{
  $teaminnermemberdesignationtextColor = '#000000';
}

if (isset($ltsmp_options['tonesocialcolor'])){
  $teaminnersocialColor = $ltsmp_options['tonesocialcolor'];
}else{
  $teaminnersocialColor = '#FFFFFF';
}

if (isset($ltsmp_options['tonesocialbgcolor'])){
  $teaminnersocialbgColor = $ltsmp_options['tonesocialbgcolor'];
}else{
  $teaminnersocialbgColor = '#773afd';
}

if (isset($ltsmp_options['tonesocialhvrcolor'])){
  $teaminnersocialhoverColor = $ltsmp_options['tonesocialhvrcolor'];
}else{
  $teaminnersocialhoverColor = '#000000';
}

if (isset($ltsmp_options['tonesocialhoverbgcolor'])){
  $teaminnersocialbghoverColor = $ltsmp_options['tonesocialhoverbgcolor'];
}else{
  $teaminnersocialbghoverColor = '';
}

if (isset($ltsmp_options['teamboximgcolor'])){
  $teamcontentboxcolor = $ltsmp_options['teamboximgcolor'];
}else{
  $teamcontentboxcolor = '#FFFFFF';
}



$custom_css .= '
.innerteampagebox img, .innerteampagebox3 .ht-team-member-image img, .innerteampagebox4 img, .innerteampagebox5 img {height: '.$teamimageheight.'px !important;} 

#innerpage-box #content-box .innerteampagebox:hover .box-content,
.innerteampagebox:hover .box-content{background-color: '.$teaminnerimgimghoverupborderColor.';}

#innerpage-box #content-box .innerteampagebox .title, #innerpage-box #content-box .innerteampagebox .title small,
.innerteampagebox .title, .innerteampagebox .title small{color: '.$teaminnermembernametextColor.' !important;}
#innerpage-box #content-box .innerteampagebox .team-member-designation,
.innerteampagebox .team-member-designation{color: '.$teaminnermemberdesignationtextColor.' !important;}

#innerpage-box #content-box .innerteampagebox .ht-team-social-id li a i,
.innerteampagebox .ht-team-social-id li a i{color: '.$teaminnersocialColor.' !important;}
#innerpage-box #content-box .innerteampagebox .ht-team-social-id li a,
.innerteampagebox .ht-team-socialbox ul:hover li,
.innerteampagebox .ht-team-social-id li a{background-color: '.$teaminnersocialbgColor.' !important;}
#innerpage-box #content-box .innerteampagebox .ht-team-social-id li a:hover i,
.innerteampagebox .ht-team-social-id li a i:hover{color: '.$teaminnersocialhoverColor.' !important;}
#innerpage-box #content-box .innerteampagebox .ht-team-social-id li a:hover,
.innerteampagebox .ht-team-social-id li a:hover{background-color: '.$teaminnersocialbghoverColor.';}

.innerteampagebox .box-content{background-color: '.$teamcontentboxcolor.' !important;}

';


    
// slider team

if (isset($ltsmp_options['ltp_option_imgheightslider'])){
  $teamimageheightslider = $ltsmp_options['ltp_option_imgheightslider'];
}else{
  $teamimageheightslider = '325';
}

if (isset($ltsmp_options['slider_name_clr'])){
  $slidernamecolor = $ltsmp_options['slider_name_clr'];
}else{
  $slidernamecolor = '#000000';
}

if (isset($ltsmp_options['slider_dsignt_clr'])){
  $sliderdesignationclr = $ltsmp_options['slider_dsignt_clr'];
}else{
  $sliderdesignationclr = '#000000';
}

if (isset($ltsmp_options['sliderarrowcolor'])){
  $sliderarrowcolor = $ltsmp_options['sliderarrowcolor'];
}else{
  $sliderarrowcolor = '#773afd';
}

if (isset($ltsmp_options['sliderarrowhovercolor'])){
  $slidernavarrowhoverColor = $ltsmp_options['sliderarrowhovercolor'];
}else{
  $slidernavarrowhoverColor = '#000000';
}

if (isset($ltsmp_options['sliderdotcolor'])){
  $slidernavdotColor = $ltsmp_options['sliderdotcolor'];
}else{
  $slidernavdotColor = '#773afd';
}

if (isset($ltsmp_options['sliderdothovercolor'])){
  $sliderdotactivehoverColor = $ltsmp_options['sliderdothovercolor'];
}else{
  $sliderdotactivehoverColor = '#000000';
}

if (isset($ltsmp_options['slider_contbx_clr'])){
  $slidercontentboxcolor = $ltsmp_options['slider_contbx_clr'];
}else{
  $slidercontentboxcolor = '#FFFFFF';
}

if (isset($ltsmp_options['slider_socl_icon_clr'])){
  $slidersocialiconcolor = $ltsmp_options['slider_socl_icon_clr'];
}else{
  $slidersocialiconcolor = '#FFFFFF';
}

if (isset($ltsmp_options['slider_socl_icon_bg_clr'])){
  $slidersocialiconbgcolor = $ltsmp_options['slider_socl_icon_bg_clr'];
}else{
  $slidersocialiconbgcolor = '#773afd';
}

if (isset($ltsmp_options['slider_socl_icon_hvr_clr'])){
  $slidersocialiconhrvcolor = $ltsmp_options['slider_socl_icon_hvr_clr'];
}else{
  $slidersocialiconhrvcolor = '#000000';
}



    $custom_css .= '

.teamslider img {height: '.$teamimageheightslider.'px !important;} 

.innerteampagebox .slidertitle{color:'.$slidernamecolor.' !important;}

.innerteampagebox .sliderteam-member-designation{color:'.$sliderdesignationclr.' !important;}

.team-luzuk-slider .owl-carousel .owl-nav-team button.owl-prev-team span, .team-luzuk-slider .owl-carousel .owl-nav-team button.owl-next-team span{color:'.$sliderarrowcolor.' !important;}

.team-luzuk-slider .owl-carousel .owl-nav-team button.owl-prev-team span:hover, .team-luzuk-slider .owl-carousel .owl-nav-team button.owl-next-team span:hover{color: '.$slidernavarrowhoverColor.' !important;}

.team-luzuk-slider .owl-theme .owl-dots .owl-dot span {background-color: '.$slidernavdotColor.';}

.team-luzuk-slider .owl-theme .owl-dots .owl-dot.active span, .team-luzuk-slider .owl-theme .owl-dots .owl-dot:hover span {background-color: '.$sliderdotactivehoverColor.' !important;}

.innerteampagebox .sliderbox-content{background:'.$slidercontentboxcolor.' !important;}


#innerpage-box #content-box .innerteampagebox .sliderht-team-social-id li a i,
.innerteampagebox .sliderht-team-social-id li a i{color: '.$slidersocialiconcolor.' !important;}


#innerpage-box #content-box .innerteampagebox .sliderht-team-social-id a,
.innerteampagebox .bgsocialbox ul:hover li,
.innerteampagebox .sliderht-team-social-id a{background-color: '.$slidersocialiconbgcolor.' !important;}

#innerpage-box #content-box .innerteampagebox .sliderht-team-social-id li a:hover i,
.innerteampagebox .sliderht-team-social-id li a i:hover{color: '.$slidersocialiconhrvcolor.' !important;}

.team-luzuk-slider .owl-theme .owl-dots .owl-dot.active span, .team-luzuk-slider .owl-theme .owl-dots .owl-dot:hover span {
  color: '.$slidersocialiconhrvcolor.' !important;
    ';



  return ltsmp_css_strip_whitespace($custom_css);

}
