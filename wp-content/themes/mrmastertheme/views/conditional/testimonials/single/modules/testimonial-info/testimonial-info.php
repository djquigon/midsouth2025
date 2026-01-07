<?php
$testimonial_id = get_the_ID();

//testimonial title
$testimonial_title = get_the_title($testimonial_id);

//excerpt:
$testimonial_content = get_field('content', $testimonial_id);

//testimonial first name:
$testimonial_first_name = get_field('first_name', $testimonial_id);

//testimonial last name:
$testimonial_last_name = get_field('last_name', $testimonial_id);

//testimonial author title:
$testimonial_author_title = get_field('author_title', $testimonial_id);

//testimonial video link:
$testimonial_video_link = get_field('video_link', $testimonial_id);

$video_thumbnail = get_field('video_thumbnail', $testimonial_id);

if ($video_thumbnail) {
    $poster_image_array = [
        'poster_image_url' => $video_thumbnail['url'],
        'poster_image_width' => $video_thumbnail['width'],
        'poster_image_height' => $video_thumbnail['height'],
        'poster_image_alt' => $video_thumbnail['alt']
    ];
} else {
    $poster_image_array = [];
}

$description = get_field('video_description', $testimonial_id);
if (!$description) {
    $description = 'Watch ' . $testimonial_title . ' testimonial';
}

$video_aria_id = rand(0, 999);

?>
<section class="testimonial-info">
    <div class="container">
        <div class="testimonial-video">
            <?php if ($testimonial_video_link) : ?>
                <?php
                echo mandr_video_player(
                    $testimonial_video_link,
                    $poster_image_array,
                    $description,
                    $video_aria_id
                );
                ?>
            <?php endif; ?>

            <?php
            //post the testimonial content if it exists:                            
            if ($testimonial_content) :
            ?>
                <blockquote class="excerpt">
                    <?= $testimonial_content ?>
                </blockquote>
            <?php
            endif;
            ?>

            <div class="testimonial-author">
                <?php if ($testimonial_first_name || $testimonial_last_name) : ?>
                    <cite class="testimonial-author-name">
                        <?= $testimonial_first_name . ' ' . $testimonial_last_name ?>
                    </cite>
                <?php endif; ?>

                <?php if ($testimonial_author_title) : ?>
                    <span class="testimonial-author-title">
                        | <?= $testimonial_author_title ?>
                    </span>
                <?php endif; ?>
            </div>
        </div>
        <span class="container-settings" data-container-width="standard">
            <span class="validator-text" data-nosnippet>settings</span>
        </span>
    </div>
    <span
        class="padding"
        data-top-padding-desktop="none"
        data-bottom-padding-desktop="double"
        data-top-padding-mobile="single"
        data-bottom-padding-mobile="single">
        <span class="validator-text" data-nosnippet>padding settings</span>
    </span>
</section>