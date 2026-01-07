<?php
    //adds custom class to body via body_class filter
    // Not Home Body Class
    add_filter('body_class', 'sp_body_class');
    function sp_body_class($classes) {
        if (!is_front_page()) {
            $classes[] = 'not-home';
        }

        return $classes;
    }

    //Page Slug Body Class
    add_filter('body_class', 'add_slug_body_class');
    function add_slug_body_class($classes) {
        global $post;
        if (isset($post)) {
            $classes[] = $post->post_type . '-' . $post->post_name;
        }
        return $classes;
    }

    //Category ID in Body and Post Class
    add_filter('post_class', 'category_id_class');
    add_filter('body_class', 'category_id_class');
    function category_id_class($classes) {
        global $post;
        if (isset($post)) {
            foreach ((get_the_category($post->ID)) as $category) {
                $classes[] = 'cat-' . $category->cat_ID . '-id';
            }
        }
        return $classes;
    }

    //Add any page categories to the body 
    add_filter('body_class', 'add_page_categories_body_class');
    function add_page_categories_body_class($classes) {
        global $post;
        if (isset($post)) { 
            if (get_the_terms($post->ID, 'page_category')) {
                $page_categories = get_the_terms($post->ID, 'page_category');
                foreach($page_categories as $page_category) {
                    $classes[] = $post->post_type . '-category-' . $page_category->slug;
                }  
            } 
        }
        return $classes;
    }

    //Add classes to next and previous links
    add_filter('next_post_link', 'posts_link_class');
    add_filter('previous_post_link', 'posts_link_class');
    function posts_link_class($format) {
        $format = str_replace('href=', 'class="button" href=', $format);
        return $format;
    }

    //Excerpts
    add_filter('excerpt_length', function () {
        return 24;
    });
    add_filter('excerpt_more', 'custom_excerpt_more');
    function custom_excerpt_more($more) {
        return '&hellip;';
    }

    // Code to add imageBox filter to content images
    //add_filter('the_content', 'addMagnificTitle_replace', 99);
    //add_filter('acf_the_content', 'addMagnificTitle_replace', 99);
    function addMagnificTitle_replace($content) {
        global $post;
        if (isset($post)) {
            // [0] <a xyz href="...(.bmp|.gif|.jpg|.jpeg|.png)" zyx>yx</a> --> <a href="...(.bmp|.gif|.jpg|.jpeg|.png)" xyz zyx>yx</a>
            $pattern[0]          = "/(<a)([^\>]*?) href=('|\")([^\>]*?)(\.bmp|\.gif|\.jpg|\.jpeg|\.png)('|\")([^\>]*?)>(.*?)<\/a>/i";
            $replacement[0] = '$1 href=$3$4$5$6$2$7>$8</a>';
            // [1] <a href="...(.bmp|.gif|.jpg|.jpeg|.png)" xyz zyx>yx</a> --> <a href="...(.bmp|.gif|.jpg|.jpeg|.png)" rel="magnificMe" data-group="[POST-ID]" xyz zyx>yx</a>
            $pattern[1]          = "/(<a href=)('|\")([^\>]*?)(\.bmp|\.gif|\.jpg|\.jpeg|\.png)('|\")([^\>]*?)(>)(.*?)(<\/a>)/i";
            $replacement[1] = '$1$2$3$4$5 rel="magnificMe" data-group="[' . $post->ID . ']" $6$7$8$9';
            // [2] <a href="...(.bmp|.gif|.jpg|.jpeg|.png)" rel="magnificMe" data-group="[POST-ID]" xyz rel="(magnificMe|nomagnificMe)yxz" zyx>yx</a> --> <a href="...(.bmp|.gif|.jpg|.jpeg|.png)" xyz rel="(magnificMe|nomagnificMe)yxz" zyx>yx</a>
            $pattern[2]          = "/(<a href=)('|\")([^\>]*?)(\.bmp|\.gif|\.jpg|\.jpeg|\.png)('|\") rel=('|\")magnificMe([^\>]*?)('|\")([^\>]*?) rel=('|\")(magnificMe|nomagnificMe)([^\>]*?)('|\")([^\>]*?)(>)(.*?)(<\/a>)/i";
            $replacement[2] = '$1$2$3$4$5$9 rel=$10$11$12$13$14$15$16$17';
            // [3] <a href="...(.bmp|.gif|.jpg|.jpeg|.png)" xyz>yx title=yxz xy</a> --> <a href="...(.bmp|.gif|.jpg|.jpeg|.png)" xyz title=yxz>yx title=yxz xy</a>
            $pattern[3]          = "/(<a href=)('|\")([^\>]*?)(\.bmp|\.gif|\.jpg|\.jpeg|\.png)('|\")([^\>]*?)(>)(.*?) title=('|\")(.*?)('|\")(.*?)(<\/a>)/i";
            $replacement[3] = '$1$2$3$4$5$6 title=$9$10$11$7$8 title=$9$10$11$12$13';
            // [4] <a href="...(.bmp|.gif|.jpg|.jpeg|.png)" xyz title=zxy xzy title=yxz>yx</a> --> <a href="...(.bmp|.gif|.jpg|.jpeg|.png)" xyz title=zxy xzy>yx</a>
            $pattern[4]          = "/(<a href=)('|\")([^\>]*?)(\.bmp|\.gif|\.jpg|\.jpeg|\.png)('|\")([^\>]*?) title=([^\>]*?) title=([^\>]*?)(>)(.*?)(<\/a>)/i";
            $replacement[4] = '$1$2$3$4$5$6 title=$7$9$10$11';
            $content = preg_replace($pattern, $replacement, $content);
        }
        return $content;
    }

    // Remove Empty Paragraphs
    add_filter('the_content', 'shortcode_empty_paragraph_fix');
    add_filter('acf_the_content', 'shortcode_empty_paragraph_fix');
    function shortcode_empty_paragraph_fix($content) {
        $array = array(
            '<p>[' => '[',
            ']</p>' => ']',
            ']<br />' => ']'
        );

        $content = strtr($content, $array);

        return $content;
    }



    // Close comments on the front-end
    add_filter('comments_open', 'df_disable_comments_status', 20, 2);
    add_filter('pings_open', 'df_disable_comments_status', 20, 2);
    function df_disable_comments_status() {
        return false;
    }    

    //Force URLs in srcset attributes into HTTPS scheme.
    //This is particularly useful when you're running a Flexible SSL frontend like Cloudflare
    add_filter('wp_calculate_image_srcset', 'ssl_srcset');
    function ssl_srcset($sources) {
        if (is_ssl()) {
            foreach ($sources as &$source) {
                $source['url'] = set_url_scheme($source['url'], 'https');
            }
        }

        return $sources;
    }

    //Remove paragraphs wrapping image
    add_filter('the_content', 'filter_ptags_on_images', 99);
    add_filter('acf_the_content', 'filter_ptags_on_images', 99);
    function filter_ptags_on_images($content) {
        return preg_replace('/<p>\\s*?(<a .*?><img.*?><\\/a>|<img.*?>)?\\s*<\\/p>/s', '\1', $content);
    }

    // Wrap all <img> tags in <picture> so that we're able to use CSS pseudo elements directly on images:
    add_filter( 'the_content', 'mandr_wrap_img_with_picture', 100);
    add_filter( 'acf_the_content', 'mandr_wrap_img_with_picture', 100); //we set the priorty at 100 so it fires after our previous function that strips the parent <p> tags from <img>
    function mandr_wrap_img_with_picture( $content ) {

        //first scrub $content and search for <img> before we proceed:
        if ($content && preg_match_all('/(<img .*?>)/', $content, $img_tag)) {
            //convert the $content string to a PHP DOMDocument object:
            $dom = new DOMDocument();
            libxml_use_internal_errors(true); // Suppress errors for malformed HTML
            $dom->loadHTML('' . $content); // Add encoding declaration (I removed it, I don't think it's necessary)
            libxml_clear_errors();

            //grab all of the img tags from within the content string turned DOMDocument object:
            $images = $dom->getElementsByTagName('img');

            //loop through each image tag
            foreach ($images as $image) {
                //write a new <picture> to the DOMDocument:    
                $wrapper = $dom->createElement('picture');
                //move the <img> to within the <picture>
                $image->parentNode->insertBefore($wrapper, $image);
                $wrapper->appendChild($image); 
            }

            //save the changes to the HTML
            $dom->saveHTML();

            //re-assign the $content string to be our adjusted DOMDocument object 
            $content = $dom->saveHTML();
        }

        return $content;
    }
?>
 