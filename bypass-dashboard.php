<?php

add_action('load-index.php', 'dashboard_Redirect');

function dashboard_Redirect()
{
    wp_redirect(admin_url('edit.php?post_type=page'));
    exit;
}

?>