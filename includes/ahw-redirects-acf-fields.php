<?php
add_action("acf/init", function () {
    acf_add_options_page([
        "page_title" => __("Redirects", "akka-redirects"),
        "menu" => __("Redirects", "akka-redirects"),
        "menu_slug" => "global-redirects",
        "post_id" => "global",
        "position" => 60,
        "capability" => "edit_posts",
        "parent" => "options-general.php",
    ]);

    $redirects_fields = apply_filters("ahw_redirects_acf_fields", []);

    acf_add_local_field_group([
        "key" => "group_global_redirects",
        "title" => "Redirects",
        "fields" => [
            [
                "key" => "field_global_redirects",
                "label" => "Redirects",
                "name" => "global_redirects",
                "type" => "repeater",
                "layout" => "row",
                "button_label" => __("Add redirect", "akka-redirects"),
                "rows_per_page" => 50,
                "sub_fields" => array_merge($redirects_fields, [
                    [
                        "key" => "field_source",
                        "label" => "Source",
                        "name" => "source",
                        "type" => "text",
                        "instructions" => __("Url to redirect from", "akka-redirects"),
                        "required" => 1,
                        "placeholder" => "/foo/bar",
                        "parent_repeater" => "field_global_redirects",
                    ],
                    [
                        "key" => "field_target",
                        "label" => "Target",
                        "name" => "target",
                        "type" => "text",
                        "instructions" => __("Url to redirect to", "akka-redirects"),
                        "required" => 1,
                        "placeholder" => "/bar/foo",
                        "parent_repeater" => "field_global_redirects",
                    ],
                    [
                        "key" => "field_url_parameters",
                        "label" => "URL parameters",
                        "name" => "url_parameters",
                        "type" => "radio",
                        "instructions" => __(
                            "If you choose Keep any query parameters that are not included in the source field will be included in the redirect. (/foo/bar?utm_source=baz => /bar/foo?utm_source=baz)\nIf you choose Remove they will be excluded (/foo/bar? utm_source=baz => /bar/foo)",
                            "akka-redirects"
                        ),
                        "choices" => [
                            "" => __("Keep", "akka-redirects"),
                            "remove" => __("Remove", "akka-redirects"),
                        ],
                        "parent_repeater" => "field_global_redirects",
                    ],
                ]),
            ],
        ],
        "location" => [
            [
                [
                    "param" => "options_page",
                    "operator" => "==",
                    "value" => "global-redirects",
                ],
            ],
        ],
        "position" => "normal",
        "active" => true,
        "show_in_rest" => 0,
    ]);
});
