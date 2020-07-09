<?php

include 'Route/Router.php';
include 'Route/RouteStore.php';
include 'Route/ReverseRouter.php';
include 'Route/RequestDispatcher.php';
include 'Route/RouteParser.php';
include 'Route/StaticRouteParser.php';
include 'Route/DynamicRouteParser.php';

function sombrillawp_framework_scripts()
{
    $assets       =  get_bloginfo('template_url') . '/inc/framework/assets' ;
    $assetVersion = '1.0.1';
    wp_enqueue_style('dashicons');
    wp_enqueue_script('sombrillawp-scripts-global', $assets . '/js/global.js', [], $assetVersion);
    wp_enqueue_script('sombrillawp-scripts', $assets . '/js/core.js', ['jquery'], $assetVersion, true);
    wp_enqueue_style('sombrillawp_wp_admin_css', $assets . '/css/core.css');

    // wp_enqueue_script('typerocket-editor', $assets . '/js/redactor.min.js', ['jquery'], $assetVersion, true );
}
add_action('admin_enqueue_scripts', 'sombrillawp_framework_scripts');
//add_action('wp_enqueue_scripts', 'sombrillawp_framework_scripts');

spl_autoload_register(function ($class) {
    if (preg_match('#SombrillaWP#', $class)) {

        $class    = explode('SombrillaWP\\', $class)[1];
        $filename = str_replace(['', '\\'], '/', $class) . '.php';
        $filename = dirname(__FILE__) . '/' . $filename;

        if (file_exists($filename)) {
            include ($filename);
        }

    }

});

include 'helpers.php';

add_action('after_setup_theme', function () {
    do_action('typerocket_loaded');
    SombrillaWP\Register\Registry::initHooks();
});



function sombrilla_search_api( \WP_REST_Request $request ) {
        $limit = 10;
        $params = $request->get_params();
        $results = null;
        if( array_key_exists('taxonomy', $params) ) {
            $results = get_terms( [
                'taxonomy' => $params['taxonomy'],
                'hide_empty' => false,
                'search' =>  $params['s'],
                'number' => $limit
            ] );
        } elseif (array_key_exists('model', $params)) {
            /** @var \TypeRocket\Models\Model $db */
            $db = new $params['model'];
            $results = $db->take($limit)->where($db->getSearchColumn(), 'like', '%' . $params['s'] . '%' )->getSearchResults();
        } else {
            //add_filter( 'posts_search', '\TypeRocket\Http\Rewrites\WpRestApi::posts_search', 500, 2 );
            $query = new \WP_Query( [
                'post_type' => $params['post_type'],
                's' => $params['s'],
                'post_status' => ['publish', 'pending', 'draft', 'future'],
                'posts_per_page' => $limit
            ] );
            if ( ! empty( $query->posts ) ) {
                $results =  $query->posts;
            }
        }
        return $results;
}


        add_action( 'rest_api_init', function () {
            register_rest_route( 'typerocket/v1', '/search', [
                'methods' => 'GET',
                'callback' => 'sombrilla_search_api',
                
            ]);
        } );
