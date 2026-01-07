<?
//Import custom-theme php files:
//Note: Initialization order is important - core files first, then functions, then hooks
require_once TEMPLATEPATH . '/library/custom-theme/php/initialization.php';
require_once TEMPLATEPATH . '/library/custom-theme/php/custom-post-types.php';
require_once TEMPLATEPATH . '/library/custom-theme/php/enqueues.php';
require_once TEMPLATEPATH . '/library/custom-theme/php/shortcodes.php';
//exception made for video player shortcodes: 
require_once TEMPLATEPATH . '/views/global/widgets/video-player/video-player.php';

require_once TEMPLATEPATH . '/library/custom-theme/php/functions/exports.php';

require_once TEMPLATEPATH . '/library/custom-theme/php/hooks/front-end.php';
require_once TEMPLATEPATH . '/library/custom-theme/php/hooks/back-end.php';

//Import vendor php files:
require_once TEMPLATEPATH . '/library/vendor/php/exports.php';
