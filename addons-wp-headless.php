<?php
/**
 * Plugin Name: Add-ons WP Headless
 * Description: Restrict access to the WordPress frontend for AMO needs
 * Version: 1.0.0
 * License: MPL-2
 */

function addons_disable_frontend()
{
    global $wp;

    // We allow CRON tasks, REST API requests, requests to the admin interface,
    // GraphQL requests, requests from an authenticated user. Everything else
    // should be restricted.
    $isRequestForbbiden = !defined('DOING_CRON') && !defined('REST_REQUEST') &&
        !is_admin() && (empty($wp->query_vars['rest_oauth1']) &&
        !defined('GRAPHQL_HTTP_REQUEST')) && !is_user_logged_in();

    if ($isRequestForbbiden) {
        wp_die('Access is restricted, sorry.', 403);
    }
}

add_action('parse_request', 'addons_disable_frontend', 99);
