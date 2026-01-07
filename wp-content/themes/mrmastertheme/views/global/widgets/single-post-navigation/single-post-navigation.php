<nav class="single-post-navigation-row">
    <ul 
        class="links columns"
        data-flex="flex"
        data-justify-content="space-between"
    >
        <?php
            if (get_previous_post_link()) :
        ?>
            <li class="previous">
                <?= get_previous_post_link('%link', '%title', false); ?>
            </li>
        <?php
            endif;
            
            //

            if (get_next_post_link()) :
        ?>
            <li class="next">
                <?= next_post_link('%link', '%title', false); ?>
            </li>
        <?php
            endif;
        ?>
    </ul>
    <span 
        class="row-settings" 
        data-container-width="standard"        
    >
        <span class="validator-text" data-nosnippet="">settings</span>
    </span>
    <span 
        class="padding"
        data-top-padding-desktop="single"
        data-bottom-padding-desktop="single"
        data-padding-top-mobile="single"
        data-padding-bottom-mobile="single"
    >
        <span class="validator-text" data-nosnippet>settings</span>
    </span>
</nav>