<?php
add_filter(
    "ahw_post_not_found_post_data",
    function ($post_id, $permalink) {
        if (!$post_id) {
            $redirect = ApiRedirect::maybe_get_redirect($permalink);
            if ($redirect) {
                return $redirect;
            }
        }
        return $post_id;
    },
    10,
    2
);
