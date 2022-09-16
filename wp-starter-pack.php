<?php
/*
Plugin Name:  WP StarterPack
Plugin URI:   https://www.ex2.com.br
Description:  Disable XML-RPC - Custom Login - Redirect Login. 
Version:      1.2
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

add_action('wp_dashboard_setup', 'welcome_widgets');
function welcome_widgets() {
global $wp_meta_boxes;
 
wp_add_dashboard_widget('custom_help_widget', 'Novidades EX2', 'custom_dashboard_help');
}
 
function custom_dashboard_help() {
echo '<p>Welcome to Custom Blog Theme! Need help? Contact the developer <a href="mailto:suporte@ex2.com.br">here</a>. 
For WordPress Tutorials visit: <a href="https://www.betarex.com.br" target="_blank">BetaRex</a></p><hr />';

$url = "https://www.ex2.com.br/feed/rss/";
$invalidurl = false;
    if(@simplexml_load_file($url)){
        $feeds = simplexml_load_file($url);
    }else{
        $invalidurl = true;
        echo "<h2>Invalid RSS feed URL.</h2>";
    }

    $i=0;
    if(!empty($feeds)){
        $site = $feeds->channel->title;
        $sitelink = $feeds->channel->link;
        foreach ($feeds->channel->item as $item) {
            $title = $item->title;
            $link = $item->link;
            $description = $item->description;
            $postDate = $item->pubDate;
            $pubDate = date('D, d M Y',strtotime($postDate));

            if($i>=5) break;
            ?>
            <div class="post">
                <div class="post-head">
                    <p><a class="feed_title" href="<?php echo $link; ?>" target="_blank"><?php echo $title; ?></a></p>
                    <span><?php echo $pubDate; ?></span>
                </div>
                <div class="post-content">
                <?php echo implode(' ', array_slice(explode(' ', $description), 0, 20)) . "..."; ?> <a href="<?php echo $link; ?>">Leia Mais</a>
                </div>
            </div>

            <?php $i++;
        }
    }else{
        if(!$invalidurl){
            echo "<h2>No item found</h2>";
        }
    }
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
