<header class="title-area"> 
    <div class="container">
        <a href="<?= get_post_type_archive_link('mandr_resource') ?>" class="breadcrumb">Back to Resources</a>
        <h1><?= get_the_title(); ?></h1>
        <?=
            get_template_part('views/conditional/resources/widgets/resource-category-list/resource-category-list', null, array('id' => get_the_id()));
        ?>
        <span 
            class="container-settings"
            data-container-width="standard"
        >
            <span class="validator-text" data-nosnippet>settings</span>
        </span>
    </div>  
    <span 
        class="padding"
        data-top-padding-desktop="double"
        data-bottom-padding-desktop="double"
        data-padding-top-mobile="single"
        data-padding-bottom-mobile="single"
    >
        <span class="validator-text" data-nosnippet>settings</span>
    </span>
</header>