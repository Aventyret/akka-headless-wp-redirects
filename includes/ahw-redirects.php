<?php
use \Akka_headless_wp_utils as Utils;
use \Akka_headless_wp_resolvers as Resolvers;

class Akka_headless_wp_redirects {
    public static function maybe_get_redirect($permalink)
    {
        $redirects = Resolvers::resolve_global_field("redirects");
        $redirect_match = null;
        foreach ($redirects as $redirect) {
            if (
                self::match_redirect_path($redirect, $permalink) &&
                self::match_redirect_query($redirect)
            ) {
                $redirect_target = $redirect["target"];
                if (!$redirect["url_parameters"] && !empty($_GET)) {
                    $target_parameters_strings = [];
                    $source_parameters = self::get_redirect_source_parameters(
                        $redirect
                    );
                    foreach ($_GET as $query_name => $query_value) {
                        if (
                            !isset($source_parameters[$query_name]) &&
                            $query_name != "lang"
                        ) {
                            $target_parameters_strings[] =
                                $query_name . "=" . $query_value;
                        }
                    }
                    if (!empty($target_parameters_strings)) {
                        $redirect_target .=
                            (strpos($redirect_target, "?") !== false
                                ? "&"
                                : "?") .
                            implode("&", $target_parameters_strings);
                    }
                }
                $redirect_url = Utils::parseUrl($redirect_target);
                $redirect_url = apply_filters("ahw_redirects_redirect_url", $redirect_url, $redirect);
                return [
                    "post_type" => "redirect",
                    "redirect" => $redirect_url,
                ];
            }
        }
        return null;
    }

    private static function match_redirect_path($redirect, $permalink)
    {
        $source = apply_filters("ahw_redirects_redirect_source", $redirect["source"], $redirect);
        $source_path = array_shift(explode("?", $source));

        $source_path = str_replace(
            [WP_HOME, AKKA_FRONTEND_BASE],
            ["", ""],
            $source_path
        );
        return strtolower($source_path) == "/" . $permalink;
    }

    private static function get_redirect_source_parameters($redirect)
    {
        $parameters = [];
        $parts = explode("?", $redirect["source"]);
        if (count($parts) > 1) {
            foreach (explode("&", $parts[1]) as $part) {
                $part_parts = explode("=", $part);
                $query_name = $part_parts[0];
                $query_value = isset($part_parts[1]) ? $part_parts[1] : "";
                $parameters[$query_name] = $query_value;
            }
        }
        return $parameters;
    }

    private static function match_redirect_query($redirect)
    {
        foreach (
            self::get_redirect_source_parameters($redirect)
            as $query_name => $query_value
        ) {
            if (
                !isset($_GET[$query_name]) ||
                $_GET[$query_name] != $query_value
            ) {
                return false;
            }
        }
        return true;
    }
}
