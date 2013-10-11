<?php

/*
Plugin Name: Offerchat
Plugin URI: http://www.offerchat.com/
Description: This plugin will automatically insert offerchat code snippet to your site.
Version: 2.0
Author: Eralph Amodia
Author URI: http://www.offerchat.com/
License: Offerchat
*/

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
  echo "Hi there!  I'm just a plugin, not much I can do when called directly.";
  exit;
}

add_action('admin_menu', 'add_configuration_link');
add_action('admin_init', 'init_settings');

add_action('wp_head', 'ofc_code_snippet');

function add_configuration_link(){
  if ( function_exists('add_submenu_page') )
    add_submenu_page('plugins.php', __('Offerchat'), __('Offerchat'), 'manage_options', 'offerchat-key-config', 'offerchat_conf');
}

function init_settings(){
  register_setting( 'offerchat_settings', 'ofc_insert_key', 'trim' );
}

function offerchat_conf(){
?>

  <style type="text/css">
  #ofc-metabox{  float: left; position:relative;z-index:0;max-width:360px;background:white;border:1px solid #dfdfdf; border-radius:5px;padding:7px 25px; margin-top:30px;}
  #ofc-screenshot{ margin-left: 20px; margin-top: 30px; float: left; width: 300px; height: 408px; background: url('https://www.offerchat.com/wp-content/uploads/plugin-screenshot.png') no-repeat; }
  </style>

  <div class="wrap">
    <?php screen_icon(); ?>
    <h2>Offerchat - Configuration</h2>
    <div id="ofc-metabox">
      <form name="dofollow" action="options.php" method="post">
        <?php settings_fields('offerchat_settings'); ?>
        <h3>Offerchat API Configuration</h3>
        <p>Please enter your Offerchat API Key:</p>
        <p><input type="text" value="<?php echo get_option('ofc_insert_key'); ?>" name="ofc_insert_key" size="25" class="regular-text code" style="font-size: 14px; padding: 8px 5px;"/></p>
        <p><input type="submit" class="button-primary" value="Submit" name="submit" /></p>
        <div class="form-wrap">
          <p><strong>Where to find your API key?</strong><br>Click on your profile image > Websites > Select your website. <br><br>You can find the API key under the 'Websites' section</p>
        </div>
      </form>
    </div>
    <div id="ofc-screenshot">
      
    </div>
  </div>

<?php
}

function ofc_code_snippet(){
  $key = get_option("ofc_insert_key", '');
  if($key){
    echo '<!--start of Offerchat js code-->';
    echo '<script type="text/javascript">';
    echo '  var ofc_key = "'.$key.'";' ;
    echo '  (function(){';
    echo '    var oc = document.createElement("script");';
    echo '    oc.type = "text/javascript";';
    echo '    oc.async = true;';
    echo '    oc.src = ("https:" == document.location.protocol ? "https://" : "http://") + "d1cpaygqxflr8n.cloudfront.net/p/js/widget.min.js?r=1";';
    // echo '    oc.src = ("https:" == document.location.protocol ? "https://" : "http://") + "local.offerchat.com:3000/widget.js?r=1";';
    echo '    var s = document.getElementsByTagName("script")[0];';
    echo '    s.parentNode.insertBefore(oc, s);';
    echo '  }());';
    echo '</script>';
    echo '<!--end of Offerchat js code-->';
  }
}


?>