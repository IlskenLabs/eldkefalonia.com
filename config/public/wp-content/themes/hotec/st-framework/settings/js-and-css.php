<?php
/**
 * @author Sa Truong - http://www.smooththemes.com
 * @copyright 2012
 */

function st_js_encode_object($l10n){
    foreach ( (array) $l10n as $key => $value ) {
			if ( !is_scalar($value) )
				continue;

			$l10n[$key] = html_entity_decode( (string) $value, ENT_QUOTES, 'UTF-8');
		}
        return  $l10n;
}

/**
 * Custom wp_localize_script;
 */ 
function  st_js_object_var($object_name,$l10n = array()){
     return  " var $object_name = " . json_encode($l10n) . '; ';
}




/**
 * return data type
 */ 
function st_data_type($var,$type='string'){
    switch(strtolower($type)){
        case 'bool': case 'boolean':
            $var = strtolower($var);
            if($var=='n' || $var == '' || $var ===0 || $var==false || $var=='false'){
                return  'false' ;
            }else{
                return 'true';
            }
        break;
        case 'float':
            return floatval($var);
        break;
        case  'array_join':
            return join(',',$var);
        break;
        case 'int':
             return intval($var); 
        break;
        default: 
            return $var; 
    }
    $var;
}

function st_flex_js_settings(){
    $settings =  array(
            'animation'=>'string',
            'animationLoop'=>'bool',
            'animationDuration'=>'int',
            'slideshow'=>'bool',
            'slideshowSpeed'=>'int',
            'animationSpeed'=>'int',
            'pauseOnAction'=>'bool',
            'pauseOnHover'=>'bool', 
            'controlNav'=>'bool',
            'randomize'=>'bool',
            'directionNav'=>'bool'
    );
    $js_options = array();
    foreach($settings as $name => $type){
         $v = st_get_setting('flex_'.$name,'');
         if(isset($v) && !empty($v)){
             $js_options[$name] =  st_data_type($v,$type);
         }
    }
    
    $js_options['nextText'] ='<i class="icon-chevron-right"></i>';
    $js_options['prevText'] ='<i class="icon-chevron-left"></i>';
    
    return $js_options;
}



/**
 * add localize_script to header beascau wp_localize_script not working in WP 3.6-beta
 */ 
function st_add_js_36_head(){
     $FS = st_flex_js_settings();
     $ST =  array('disable_header_floating'=>st_get_setting("disable_header_floating",'n') );
     $ajaxurl = admin_url('admin-ajax.php');
     $s='';
     $s .=  st_js_object_var('FS',$FS)."\n";
     $s .=  st_js_object_var('ST',$ST)."\n";
     $s .=  st_js_object_var('ajaxurl',$ajaxurl)."\n";
     echo    "<script type='text/javascript'>  \n  $s  </script>\n";
}


if(st_check_wp_version('3.5.1','>')){
     add_action('wp_head','st_add_js_36_head',1);
}


#-----------------------------------------------------------------
# Enqueue Style
#-----------------------------------------------------------------
if( !function_exists('st_enqueue_styles')){
    function st_enqueue_styles(){
        if(!is_admin()){
            //Register styles
            wp_enqueue_style('st_style', get_bloginfo( 'stylesheet_url' ),false, ST_VERSION );
            wp_enqueue_style('flexslider', st_css('flexslider.css'),false);
            wp_enqueue_style('font-awesome',st_css('font-awesome.min.css'));
            wp_enqueue_style('flexslider',st_css('flexslider.css'));
            wp_enqueue_style('responsive',st_css('responsive.css'));
            wp_enqueue_style('prettyPhoto',st_css('prettyPhoto.css'));
            
             if(st_is_woocommerce()){
                wp_enqueue_style('woocommerce_frontend_styles',st_css('woocommerce.css'));
             }
         
        }
    }
}
add_action('wp_print_styles','st_enqueue_styles');

#-----------------------------------------------------------------
# Enqueue Scripts
#-----------------------------------------------------------------
if(!function_exists('st_enqueue_scripts')){
    function st_enqueue_scripts(){
        if(!is_admin()){
            
            wp_enqueue_script("jquery",st_js('jquery.js'));
        
            wp_enqueue_script( 'ba-bbq', st_js('jquery.ba-bbq.min.js'), array('jquery'),ST_VERSION,true);
            wp_enqueue_script( 'fitvids', st_js('jquery.fitvids.js'), array('jquery'),ST_VERSION,true);
            wp_enqueue_script( 'prettyPhoto', st_js('jquery.prettyPhoto.js'), array('jquery'),ST_VERSION,true);
            wp_enqueue_script( 'jquery.easing', st_js('jquery.easing-1.3.js'), array('jquery'),'1.3' , true );
            wp_enqueue_script('carouFredSel',st_js('jquery.carouFredSel.js'), array('jquery'),'1.6', true);
            wp_enqueue_script( 'isotope', st_js('jquery.isotope.min.js'), array('jquery'),ST_VERSION, true);
            wp_enqueue_script( 'flexslider', st_js('jquery.flexslider.js'), array('jquery'),ST_VERSION, true);
            
             // jquery-ui.datepicker.js"
            wp_enqueue_script( 'datepicker', st_js('jquery-ui.datepicker.js'), array('jquery'),ST_VERSION, true);
            wp_enqueue_script( 'twitter', st_js('twitter.js'), array('jquery'),ST_VERSION, true);
            wp_enqueue_script( 'ddsmoothmenu', st_js('ddsmoothmenu.js'), array('jquery'),ST_VERSION, true);
            wp_enqueue_script( 'shortcodes', st_js('shortcodes.js'), array('jquery'),ST_VERSION, true);
            wp_enqueue_script( 'st_custom', st_js('custom.js'), array('jquery'),ST_VERSION, true);
    
        	if ( is_singular() && get_option( 'thread_comments' ) ){
        	     	wp_enqueue_script( 'comment-reply' );
        	}
            
           if( st_check_wp_version('3.5.1','<=') ){
                wp_localize_script( 'jquery', 'FS', st_flex_js_settings() );
                wp_localize_script('jquery','ST',array('disable_header_floating'=>st_get_setting("disable_header_floating",'n')));
                wp_localize_script('jquery','ajaxurl',admin_url('admin-ajax.php'));
            }
           
            
         
        }
    }
}
add_action('wp_print_scripts','st_enqueue_scripts');


function st_user_custom_style(){
?>
<!--[if IE 8]><link href="<?php st_css('ie8.css',true); ?>" rel="stylesheet" type="text/css" /><![endif]-->
<link href="<?php echo ST_THEME_URL .'custom.css'; ?>" rel="stylesheet" type="text/css" />
<?php
}

add_action('wp_head','st_user_custom_style',50);
