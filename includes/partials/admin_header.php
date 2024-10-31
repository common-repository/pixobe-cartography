<?php

/**
 * Footer page
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://pixobe.com
 * @since      1.0.0
 *
 * @package    Pixobe_Cartography
 * @subpackage Pixobe_Cartography/admin/partials
 */
?>

<nav class="navbar" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="https://cartography.page" target="_blank">
            <img src="<?= plugins_url('/../../public/images/cartography.png', __FILE__) ?>" width="192" height="28" alt="Cartography: An interactive geo maps." />
        </a>
    </div>
    <div class="navbar-menu">
        <div class="navbar-end">
            <a class="navbar-item">
                 Version <?=PIXOBE_CARTOGRAPHY_VERSION ?>
            </a>
        </div>
    </div>
    <div class="navbar-end">
    <!-- navbar items -->
  </div>
</nav>
 