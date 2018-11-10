<?php
/*
 * $searchform_id is always unique to each searchform ensuring the labels target the correct input.
 */
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">

    <label for="<?php echo $searchform_id; ?>">
        <?php echo _x( 'Search for:', 'label' ) ?>
    </label>
		
    <input type="text" id="<?php echo $searchform_id; ?>"  placeholder="Search for..." name="s" aria-label="Search for..." required>

    <button class="btn btn-secondary" type="submit"><?php echo esc_attr_x( 'Search', 'submit button' ); ?></button>

</form>