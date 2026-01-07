<?php
    //this file holds any functions related to content formatting:

    //acf remove autop
    function the_field_without_wpautop($field_name) {

        remove_filter('acf_the_content', 'wpautop');

        the_field($field_name);

        add_filter('acf_the_content', 'wpautop');
    }

    //Limit a string by word count, append ellipses
    function my_string_limit_words($string, $word_limit = 0) {
        $words = explode(' ', $string, ($word_limit + 1));
        if ($word_limit > 0 && count($words) > $word_limit) {
            array_pop($words);
            return implode(' ', $words) . '... ';
        } else {
            return $string;
        }
    }

    //Limit a string by character count, append ellipses
    function my_string_limit_char($string, $substr = 0) {
        $string = strip_tags(str_replace('...', '...', $string));
        if ($substr > 0 && strlen($string) > $substr) {
            $string = rtrim(substr($string, 0, $substr)) . ' ...';
        }
        return $string;
    }

    //Add formatting to get_the_content
    function get_the_content_with_formatting($more_link_text = '(more...)', $stripteaser = 0, $more_file = '') {
        $content = get_the_content($more_link_text, $stripteaser, $more_file);
        $content = apply_filters('the_content', $content);
        $content = str_replace(']]>', ']]&gt;', $content);
        return $content;
    }

    //Remove invalid tags
    function remove_invalid_tags($str, $tags) {
        foreach ($tags as $tag) {
            $str = preg_replace('#^<\/' . $tag . '>|<' . $tag . '>$#', '', trim($str));
        }

        return $str;
    }

    //Validate if element is not null, an empty string or false.
    function valid_element($e) {
        if ($e === null || $e === '' || $e === false) {
            return false;
        }

        return true;
    }
    
    function email_link($email) {
        $return = "<a href='mailto:" . antispambot($email) . "' target='_blank' rel='noopener noreferrer'>" . antispambot($email) . "</a>";
        return $return;
    }
    function phone_tel_number($phone) {
        return preg_replace('/\D+/', '', $phone);
    }
    function phone_link($phone) {
        $return = "<a href='tel:" . phone_tel_number($phone) . "' target='_blank' rel='noopener noreferrer'>" . $phone . "</a>";
        return $return;
    }
?>