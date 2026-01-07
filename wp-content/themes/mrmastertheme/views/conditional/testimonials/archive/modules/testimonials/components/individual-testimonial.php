<?php
$testimonial_id = $args['id'];

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
<li>
    <article>
        <div class="content-row">
            <div class="columns">
                <div class="column text">
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
            </div>
            <span
                class="row-settings"
                data-column-count="one"
                data-column-width="variable">
                <span class="validator-text" data-nosnippet>row settings</span>
            </span>
        </div>
    </article>
</li>