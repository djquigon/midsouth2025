<header>
    <div class="container">
        <?php
        //Breadcrumb(s):
        echo get_template_part('views/conditional/testimonials/single/widgets/breadcrumbs/back-to-archive');

        //Post title:
        ?>
        <h1><?= get_the_title() ?></h1>
        <?php
        //Date info:
        $post_date = get_the_date('F j, Y');
        $post_date_datetime_format = get_the_date('Y-m-d');
        ?>
        <time datetime="<?= $post_date_datetime_format ?>"><?= $post_date ?></time>
        <span class="container-settings" data-container-width="standard">
            <span class="validator-text" data-nosnippet>settings</span>
        </span>
    </div>
    <span
        class="padding"
        data-top-padding-desktop="double"
        data-bottom-padding-desktop="double"
        data-top-padding-mobile="single"
        data-bottom-padding-mobile="single">
        <span class="validator-text" data-nosnippet>padding settings</span>
    </span>
</header>