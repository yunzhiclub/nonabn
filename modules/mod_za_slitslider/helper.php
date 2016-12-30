<?php

/**

 * @package   slitslider

 * @copyright 

 * @license   

 * Contact to : design@za-studio.ru, www.za-studio.net

 * */
defined('_JEXEC') or die('Restricted access');

class modSlitSliderHelper {

    static function getScript($params) {

        
        $optOpacity = ($params->get('optOpacity') == '0') ? 'false' : 'true';

        $speed = $params->get('speed');
		$translateFactor = $params->get('translateFactor');

        $maxAngle = $params->get('maxAngle');
	
		$maxScale = $params->get('maxScale');
		 $maxAngl = $params->get('maxAngl');
	
		$maxScal = $params->get('maxScal');

        $autoplay = ($params->get('autoplay') == '0') ? 'false' : 'true';

        $interval = $params->get('interval');

        $keyboard = $params->get('keyboard');

        $javascript = "
                jQuery(function() {
                            var Page = (function() {

                                    var navArrows = jQuery( '#nav-arrows' ),
						nav = jQuery( '#nav-dots > span' ),
						slitslider = jQuery( '#slider' ).slitslider( {
							onBeforeChange : function( slide, pos ) {

								nav.removeClass( 'nav-dot-current' );
								nav.eq( pos ).addClass( 'nav-dot-current' );


                                                    },
                                                    
                                                    optOpacity : '" . $optOpacity . "',
                                                    
                                                    translateFactor : " . $translateFactor . ",
                                                    
                                                    maxAngle : " . $maxAngle . ",
                                                   
                                                    maxScale : " . $maxScale . ",
													 maxAngl : " . $maxAngl . ",
                                                   
                                                    maxScal : " . $maxScal . ",
                                                    
                                                    keyboard : " . $keyboard . ",
                                                   
                                                    speed : " . $speed . ",
													
                                                    autoplay : " . $autoplay . ",
                                                   
                                                    interval: " . $interval . "
                                            } ),

                                            init = function() {

							initEvents();
							
						},
						initEvents = function() {

							// add navigation events
							navArrows.children( ':last' ).on( 'click', function() {

								slitslider.next();
								return false;

							} );

							navArrows.children( ':first' ).on( 'click', function() {
								
								slitslider.previous();
								return false;

							} );

							nav.each( function( i ) {
							
								jQuery( this ).on( 'click', function( event ) {
									
									var dot = jQuery( this );
									
									if( !slitslider.isActive() ) {

										nav.removeClass( 'nav-dot-current' );
										dot.addClass( 'nav-dot-current' );
									
									}
									
									slitslider.jump( i + 1 );
									return false;
								
								} );
								
							} );

						};

						return { init : init };

				})();

				Page.init();
                    });
            ";
        return $javascript;
    }

    static function SetCSS() {
        $document = JFactory::getDocument();
        //$document->addStyleDeclaration();
        $document->addStyleSheet('modules/mod_za_slitslider/css/style.css');
        $document->addStyleSheet('modules/mod_za_slitslider/css/custom.css');
        
    }

    static function SetScript($params) {
        $document = JFactory::getDocument();
        $load = $params->get('load');
        $jver = $params->get('jver');
        $show_jquery = $params->get('show_jquery');

        $jquerypath = ($jver == "1.9.1") ? "modules/mod_za_slitslider/js/jquery-1.9.1.min.js" : ("http://ajax.googleapis.com/ajax/libs/jquery/" . $jver . "/jquery.min.js");

        if ($load == "onmod") {
            if ($jver == '1.9.1')
                $jquerypath = JUri::root() . $jquerypath;
            if ($show_jquery == '1')  echo "<script src='" . $jquerypath . "' type='text/javascript'></script>";
            echo "<script src='" . JUri::root() . "modules/mod_za_slitslider/js/modernizr.custom.79639.js' type='text/javascript'></script>" .
            "<script src='" . JUri::root() . "modules/mod_za_slitslider/js/jquery.slitslider.js' type='text/javascript'></script>" .
            "<script src='" . JUri::root() . "modules/mod_za_slitslider/js/jquery.ba-cond.min.js' type='text/javascript'></script>" .
            "<script type='text/javascript'>" .
            modSlitSliderHelper::getScript($params) .
            "</script>";
        } else {
            if ($show_jquery == "1")
                $document->addScript($jquerypath);
            $document->addScript('modules/mod_za_slitslider/js/modernizr.custom.79639.js');
			$document->addScript('modules/mod_za_slitslider/js/jquery.ba-cond.min.js');
            $document->addScript('modules/mod_za_slitslider/js/jquery.slitslider.js');
            $document->addScriptDeclaration(modSlitSliderHelper::getScript($params));
        }
    }

}

?>