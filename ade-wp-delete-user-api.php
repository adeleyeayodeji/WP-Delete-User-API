<?php

/**
 * Plugin Name: WP Delete User API
 * Plugin URI:  https://biggidroid.com
 * Author:      Adeleye Ayodej
 * Author URI:  https://biggidroid.com
 * Description: A plugin to delete user from the database using the WordPress API
 * Version:     0.1.0
 * License:     GPL-2.0+
 * License URL: http://www.gnu.org/licenses/gpl-2.0.txt
 * text-domain: ade-wp-delete-user-api
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

//define api init
add_action('rest_api_init', 'ade_delete_user_api');

//define api function
function ade_delete_user_api()
{
    register_rest_route('adeuser/v1', '/user', array(
        'methods' => 'DELETE',
        'callback' => 'ade_delete_user_api_callback'
    ));
}

//define api callback function
function ade_delete_user_api_callback(WP_REST_Request $request)
{
    $user_email = $request->get_param('email');
    $user = get_user_by('email', $user_email);
    if (!$user) {
        return new WP_Error('no_user', 'Invalid user ID', array('status' => 404));
    }
    //require once
    require_once(ABSPATH . 'wp-admin/includes/user.php');
    wp_delete_user($user->ID);
    return new WP_REST_Response('User deleted', 200);
}
