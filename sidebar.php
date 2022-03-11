<?php /* Template Part: Sidebar */ ?>

<aside>

  <div class="logo">
      <img src="<?php echo get_template_directory_uri(); ?>/images/logo/logo-corner.png" class="logo-image" height="500" width="500" />
  </div>

  <header class="site-header top-to-bottom">
    <?php get_template_part( 'template-parts/header/site', 'branding' ); ?>

		<?php get_template_part( 'template-parts/navigation/navigation', 'primary' );

    get_template_part( 'template-parts/navigation/primary', 'search' ); ?>

  </header>
</aside>
