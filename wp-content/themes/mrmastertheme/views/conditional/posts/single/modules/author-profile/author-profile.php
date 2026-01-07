<?php
    //Author info:
    $post_author_id = get_post_field('post_author');
    
    //For this module specifically, we'll pull the ACF field instead of the default WordPress username field
    //$post_author_name = get_the_author_meta('display_name', $post_author_id);
    $post_author_name = get_field('post_author_name', 'user_'.$post_author_id);
    $post_author_headshot = get_field('post_author_headshot', 'user_'.$post_author_id);
    $post_author_bio = get_field('post_author_bio', 'user_'.$post_author_id);

    //based on if we actually have a headshot, configure the column count settings we'll use later:
    if ($post_author_headshot) {
        $author_profile_column_count = 'two';
    } else {
        $author_profile_column_count = 'one';
    }

    //let's at least have a name AND bio to proceed:
    if ($post_author_name && $post_author_bio) :
?>
        <aside class="author-profile">
            <div class="content-row">
                <div class="columns">
                    <?php
                        if ($post_author_headshot) :
                            //if image exists, 2 column layout for listing:
                    ?>
                            <div 
                                class="column left one-third"
                                data-mobile-hide="true"
                            >
                                <figure>
                                    <img src="<?= $post_author_headshot['url'] ?>" height="<?= $post_author_headshot['height'] ?>" width="<?= $post_author_headshot['width'] ?>" alt="<?= $post_author_headshot['alt'] ?>"> 
                                </figure>
                            </div>
                            <div class="column right two-thirds">
                                <h3>Author: <?= $post_author_name ?></h3>
                                <?= $post_author_bio ?>
                            </div>
                    <?php
                        else: 
                            //if there's no image, just a single column:
                    ?>  
                            <div class="column">
                                <h3>Author: <?= $post_author_name ?></h3>
                                <?= $post_author_bio ?>
                            </div>          
                    <?php
                        endif;
                    ?>
                </div>
                <span 
                    class="row-settings" 
                    data-column-count="<?= $author_profile_column_count ?>" 
                    data-column-width="variable" 
                    data-container-width="standard"
                >
                    <span class="validator-text" data-nosnippet>row settings</span>
                </span>
            </div>
            <span 
                class="padding"
                data-top-padding-desktop="double"
                data-bottom-padding-desktop="double"
                data-top-padding-mobile="single"
                data-bottom-padding-mobile="single"
            >
                <span class="validator-text" data-nosnippet>padding settings</span>
            </span>
        </aside>
<?php
    endif;
?>