<?php

/**
 *  
 *
 * This file is used to add/edit existing map record
 *
 * @link       https://pixobe.com
 * @since      1.0.0
 *
 */
?>

<?php
    if(!empty($_GET['id'])) {
?>
    <pixobe-cartography-admin id="<?= $_GET['id'] ?>"></pixobe-cartography-admin>
<?php
    } else {
?>
  <pixobe-cartography-admin></pixobe-cartography-admin>
<?php

    }
?>