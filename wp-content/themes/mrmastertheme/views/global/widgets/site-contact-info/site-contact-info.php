<h2 class="h4">Contact Info</h2>
<?php
    if (
        get_field('contact_info_phone', 'options') || 
        get_field('contact_info_address_text', 'options') || 
        get_field('contact_info_email', 'options')
    ) :
?>
        <address>
            <ul class="contact-info">
                <?php 
                    if (get_field('contact_info_phone', 'options')) : 
                ?>
                        <li><?= do_shortcode('[contact-phone]'); ?></li>
                <?php
                    endif;

                    if (get_field('contact_info_email', 'options')) : 
                ?>
                        <li><?= do_shortcode('[contact-email]'); ?></li>
                <?php
                    endif;

                    if (get_field('contact_info_address_text', 'options') && get_field('contact_info_address_link', 'options')) : 
                ?> 
                        <li><?= do_shortcode('[contact-address]'); ?></li>
                <?php
                    endif;
                ?> 
            </ul>
        </address>
<?php
    endif;
?>