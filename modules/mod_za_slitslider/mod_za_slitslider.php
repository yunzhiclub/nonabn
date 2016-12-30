<?php

// no direct access

defined('_JEXEC') or die('Restricted access');

require_once (dirname(__FILE__) . DIRECTORY_SEPARATOR . 'helper.php');

$linktarget = $params->get('linktarget');

$shownavigation = ($params->get('shownavigation') == '1') ? TRUE : FALSE;

$showarrows = ($params->get('showarrows') == '1') ? TRUE : FALSE;

$moduleclass_sfx = $params->get('moduleclass_sfx');

$navigationalign = $params->get('navigationalign');


$bgcontrolcolor = "";
$bgactive = "";
if ($params->get('setbgcontrol') == '1') {
    $bgcontrolcolor = "style='background-color: " . $params->get('bgcontrolcolor') . ";'";
    $bgactive = "<style type='text/css' >
                 .nav-dots span.nav-dot-current {
                box-shadow: 
                0 1px 1px rgba(255,255,255,0.6), 
                inset 0 1px 1px rgba(0,0,0,0.1), 
                inset 0 0 0 3px ".$params->get('bgcontrolcolor') .",
                inset 0 0 0 8px #fff;}
                </style>";
}

$images = array();

//cтроим массив картинок

for ($i = 1; $i < 20; $i++) {
    $timag = array();
    if ($params->get('img' . $i) != '') {
        $timag['path'] = $params->get('img' . $i);
        $timag['description'] = $params->get('desc' . $i);
        $timag['link'] = $params->get('link' . $i);
			$timag['orientation'] = $params->get('orientation' . $i);
        $images[] = $timag;
    }
}

modSlitSliderHelper::SetCSS();
modSlitSliderHelper::SetScript($params);

require( JModuleHelper::getLayoutPath( 'mod_za_slitslider' , $params->get('layout', 'default')) );
