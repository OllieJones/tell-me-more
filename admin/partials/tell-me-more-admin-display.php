<?php

/**
 * Provide an admin area view for the plugin
 *
 * This file is used to present the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/OllieJones
 *
 * @package    Index_Wp_Users_For_Speed
 * @subpackage Index_Wp_Users_For_Speed/admin/views
 */

settings_errors( TELL_ME_MORE_SLUG );
?>

<div class="wrap index-users">
    <h2 class="wp-heading-inline"><?php echo get_admin_page_title(); ?></h2>
    <!--suppress HtmlUnknownTarget -->
    <form id="tell-me-more-form" method="post" action="options.php">
      <?php
      settings_fields( TELL_ME_MORE_SLUG );
      do_settings_sections( TELL_ME_MORE_SLUG  );
      submit_button( );
      ?>
    </form>
</div>
