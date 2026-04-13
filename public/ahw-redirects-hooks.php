<?php
add_filter(
    "akka_post_not_found_response",
    function ($permalink) {
        $redirect = \Akka\Redirects::maybe_get_redirect($permalink);
        if ($redirect) {
            return $redirect;
        }
        return $permalink;
    },
    10,
    1
);
