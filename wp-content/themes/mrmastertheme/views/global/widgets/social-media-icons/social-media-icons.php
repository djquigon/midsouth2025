<?php
    $facebook_link = get_field('social_facebook','options');
    $twitter_link = get_field('social_twitter','options');
    $linkedin_link = get_field('social_linkedin','options');
    $instagram_link = get_field('social_instagram','options');
    $youtube_link = get_field('social_youtube','options');    
?>

<?php if ($facebook_link || $twitter_link || $linkedin_link || $instagram_link || $youtube_link) : ?>
	<ul 
        class="social-links"
        data-flex="flex" 
        data-align-items="center"
        data-justify-content="center"
    >
		<?php if ($facebook_link) : ?>
            <li>
                <a target="_blank" href="<?= $facebook_link; ?>" class="facebook-link" title="Like us on Facebook!">
                    <i class="icon-facebook" aria-hidden="true"></i>
                    <span class="visually-hidden">Open Facebook page</span>
                </a>
            </li>
		<?php endif; ?>
		<?php if ($twitter_link) : ?>
            <li>
                <a target="_blank" href="<?= $twitter_link; ?>" class="twitter-link" title="Follow us on X (Formerly Twitter)!">
                    <i class="icon-x" aria-hidden="true"></i>
                    <span class="visually-hidden">Open X (Formerly Twitter) page</span>
                </a>
            </li>
		<?php endif; ?>
		<?php if ($linkedin_link) : ?>
            <li>
                <a target="_blank" href="<?= $linkedin_link; ?>" class="linkedin-link" title="Follow us on LinkedIn!">
                    <i class="icon-linkedin" aria-hidden="true"></i>
                    <span class="visually-hidden">Open LinkedIn page</span>
                </a>
            </li>
		<?php endif; ?>
		<?php if ($instagram_link) : ?>
            <li>
                <a target="_blank" href="<?= $instagram_link; ?>" class="instagram-link" title="Follow us on Instagram!">
                    <i class="icon-instagram" aria-hidden="true"></i>
                    <span class="visually-hidden">Open Instagram page</span>
                </a>
            </li>
		<?php endif; ?>
		<?php if ($youtube_link) : ?>
            <li>
                <a target="_blank" href="<?= $youtube_link; ?>" class="youtube-link" title="Follow our Youtube channel!">
                    <i class="icon-youtube" aria-hidden="true"></i>
                    <span class="visually-hidden">Open YouTube page</span>
                </a>
            </li>
		<?php endif; ?>
	</ul>
<?php endif; ?>