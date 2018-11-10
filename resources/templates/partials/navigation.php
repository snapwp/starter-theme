<nav role="navigation">

    <a href="<?php echo  esc_attr(get_home_url()); ?>">
        <?php echo get_bloginfo('name'); ?>
    </a>

    <?php
    wp_nav_menu([
        'theme_location'  => 'primary',
        'container'       => 'div',
        'container_id'    => 'primary-navigation',
        'container_class' => '',
        'menu_id'         => false,
        'menu_class'      => '',
        'depth'           => 2,
        'walker'          => new Theme\Walkers\Navbar()
    ]);
    ?>

</nav>