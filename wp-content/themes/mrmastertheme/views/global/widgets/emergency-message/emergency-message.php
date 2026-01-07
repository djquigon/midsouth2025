<?php
    if (get_field('emergency_message_content','options')) :
        $emergency_message_content = get_field('emergency_message_content','options');
?>
        <aside id="emergency-message">
            <?= $emergency_message_content ?>
        </aside>
<?php
    endif;
?>