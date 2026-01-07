<?php
    //This file holds various functions that serve as sort of 'dev-tools': 

    //Import SVG code from filepath
    //https://stackoverflow.com/questions/29991284/php-get-svg-tag-from-svg-file-and-show-it-in-html-in-div 
    function import_SVG($file) {
        if (!$file) {
            return false;
        }

        $svg_file = file_get_contents($file);

        $find_string   = '<svg';
        $position = strpos($svg_file, $find_string);

        $svg_file_new = substr($svg_file, $position);

        return $svg_file_new;
    }

    //Process CSV file
    function process_csv_file($file, $callback = null, $args = null) {
        $row = 0;
        $cx = 0;

        if (($csv = fopen($file, 'r')) !== false) {
            while (($data = fgetcsv($csv, 9999, ',')) !== false) {
                $row++;

                // Callback function will include row iterator, data array and optional args
                if ($callback !== null) $callback($row, $data, $args);
            }

            fclose($csv);
        }
    }

    //Curl helper function
    function curl_get($url) {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        $return = curl_exec($curl);
        curl_close($curl);
        return $return;
    }
    
    // debug help
    if (!function_exists('write_log')) {
        function write_log($log) {
            if (is_array($log) || is_object($log)) {
                error_log(print_r($log, true));
            } else {
                error_log($log);
            }
        }
    }

    //declare function for toggling on/off local development server for the vue app
    function vue_is_local_development() {
        //When working on a local environment, and this ACF Option is toggled 'On', you're able to more quickly make changes to the Vue app because running the 'npm serve' command automatically watches your changes & recompiles the javascript

        //if this ACF option is toggled 'off', it is assumed that you're wanting only the most recently compiled version of the vue app for a production environment

        if (get_field('vue_is_local_development','options')) {
            $connection = @fsockopen('localhost', '8080');

            return $connection;
        } else {
            return false;
        }

        //eventually, we'll have a full Dendron note written that explains the Vue app dev process
    }
?>