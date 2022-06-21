<?php
/*
Plugin Name:  WP StarterPack
Plugin URI:   https://www.ex2.com.br
Description:  Disable XML-RPC - Custom Login - Redirect Login. 
Version:      1.0
Author:       Arthur Maia 
Author URI:   https://github.com/arthurmaia94
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  wp-starter-pack
Domain Path:  /languages
*/

// Disable use XML-RPC
add_filter( 'xmlrpc_enabled', '__return_false' );

// Disable X-Pingback to header
add_filter( 'wp_headers', 'disable_x_pingback' );
function disable_x_pingback( $headers ) {
    unset( $headers['X-Pingback'] );

return $headers;
}

add_filter('login_redirect', 'admin_default_page');
function admin_default_page() {
  $home = get_home_url();
  return $home;
}

function cutom_login_logo() {
	$homeURL = get_home_url();
    echo "<style type=\"text/css\">
    body.login div#login h1 a {
        background-image: url(".$homeURL."/wp-content/plugins/wp-starter/img/logo.png);
        -webkit-background-size: auto;
        background-size: auto;
        margin: 0 0 25px;
        width: 320px;height: 120px;
    }
    body.login {background: url(".$homeURL."/wp-content/plugins/wp-starter/img/bg-abstract-grey.png);background-position:center;}
    body.login div#login form#loginform {box-shadow: none;border: 5px solid #ffa200;background: #fff;}
    body.login form #wp-submit{background: #ff6800;box-shadow: none;border: none;text-shadow: none;}
    </style>";
}
add_action( 'login_enqueue_scripts', 'cutom_login_logo' );
function remove_footer_admin () {
    echo 'Desenvolvido por: <a href="http://ex2.com.br/">Ex2</a>';
}
add_filter('admin_footer_text', 'remove_footer_admin');
 
function my_login_logo_url() {
    return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'my_login_logo_url' );
 
function my_login_logo_url_title() {
    return 'Ex2 - Criação de Sites';
}
add_filter( 'login_headertitle', 'my_login_logo_url_title' );
?>
