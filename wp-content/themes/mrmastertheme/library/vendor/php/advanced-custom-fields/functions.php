<?php
    //This file holds any functions that relate directly to the ACF plugin:

    //Use get_the_advanced_acf_excerpt, but this is the main legwork for that function
    // to get and trim excerpt from ACF content
    function wp_trim_advanced_acf_excerpt($text = '', $post = null) {
        $raw_excerpt = $text;
        if ('' == $text) {
            $post = get_post($post);
            $meta = get_post_meta($post->ID);

            if (isset($meta['page_layouts_0_column_1'])) {
                $text .= $meta['page_layouts_0_column_1'][0];
            }
            if (isset($meta['page_layouts_0_column_2'])) {
                $text .= $meta['page_layouts_0_column_2'][0];
            }
            if (isset($meta['page_layouts_1_column_1'])) {
                $text .= $meta['page_layouts_1_column_1'][0];
            }
            if (isset($meta['page_layouts_1_column_2'])) {
                $text .= $meta['page_layouts_1_column_2'][0];
            }
            if (isset($meta['page_layouts_2_column_1'])) {
                $text .= $meta['page_layouts_2_column_1'][0];
            }
            if (isset($meta['page_layouts_2_column_2'])) {
                $text .= $meta['page_layouts_2_column_2'][0];
            }

            $text = strip_shortcodes($text);
            $text = excerpt_remove_blocks($text);

            /** This filter is documented in wp-includes/post-template.php */
            $text = apply_filters('the_content', $text);
            $text = str_replace(']]>', ']]&gt;', $text);

            /* translators: Maximum number of words used in a post excerpt. */
            $excerpt_length = intval(_x('55', 'excerpt_length'));

            /**
             * Filters the maximum number of words in a post excerpt.
             *
             * @since 2.7.0
             *
             * @param int $number The maximum number of words. Default 55.
             */
            $excerpt_length = (int) apply_filters('excerpt_length', $excerpt_length);

            /**
             * Filters the string in the "more" link displayed after a trimmed excerpt.
             *
             * @since 2.9.0
             *
             * @param string $more_string The string shown within the more link.
             */
            $excerpt_more = apply_filters('excerpt_more', ' ' . '[&hellip;]');
            $text         = wp_trim_words($text, $excerpt_length, $excerpt_more);
        }

        return apply_filters('wp_trim_excerpt', $text, $raw_excerpt);
    }

    //Get excerpt from a page with ACF content if excerpt isn't defined already
    function get_the_advanced_acf_excerpt($post = null) {
        $post = get_post($post);
        if (empty($post)) {
            return '';
        }

        if (post_password_required($post)) {
            return __('There is no excerpt because this is a protected post.');
        }

        if (!empty($post->post_excerpt)) {
            return apply_filters('get_the_excerpt', $post->post_excerpt, $post);
        } else {
            return wp_trim_advanced_acf_excerpt();
        }
    }

    //Check image if array, check width/height, and return url
    function acf_image_resize_get_url($acf_image, $width, $height) {

        if (!is_array($acf_image)) {
            $acf_image = acf_get_attachment($acf_image);
        }

        if ((int)$acf_image['width'] !== $width || (int)$acf_image['height'] !== $height) {
            return aq_resize($acf_image['url'], $width, $height, true, true, true);
        } else {
            return $acf_image['url'];
        }
    }

    function acf_image_get_alt($acf_image) {
        if (!is_array($acf_image)) {
            $acf_image = acf_get_attachment($acf_image);
        }

        if (!empty($acf_image['alt'])) {
            return $acf_image['alt'];
        } else {
            return $acf_image['title'];
        }
    }
?>