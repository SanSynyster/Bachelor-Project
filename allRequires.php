<?php

require get_theme_file_path('/includes/permissions.php');
require get_theme_file_path('/includes/custom-post-types.php');
require get_theme_file_path('/includes/register-form.php');

// Ajax
require get_theme_file_path('/includes/Ajax/getVideo.php');
require get_theme_file_path('/includes/Ajax/rateVideo.php');
require get_theme_file_path('/includes/Ajax/compare-video.php');
require get_theme_file_path('/includes/Ajax/getAdvanceCompareVideos.php');
require get_theme_file_path('/includes/Ajax/getAdvanceResults.php');
require get_theme_file_path('/includes/Ajax/getAdvanceVideoResult.php');
// -- Auth
require get_theme_file_path('/includes/Ajax/Auth.php');
