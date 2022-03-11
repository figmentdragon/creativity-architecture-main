<?php
/**
 * The Left sidebar containing the main widget area.
 *
 * @package THEMENAE
 */

if ( ! is_active_sidebar( 'THEMENAE-sidebar-left' ) ) {
    return;
}
?>

<?php if( THEMENAE_get_sidebar_layout() == "left_sidebar" ) : ?>
    <div id="secondary" class="widget-area">
        <?php dynamic_sidebar( 'THEMENAE-sidebar-left' ); ?>
    </div><!-- #secondary -->
<?php endif;

<div class="site-branding">
  <?php has_custom_logo() ? the_custom_logo() : ''; ?>

  <div class="site-identity">
    <?php if ( is_front_page() && is_home() ) : ?>
      <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
    <?php else : ?>
      <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
    <?php
    endif;

    $description = get_bloginfo( 'description', 'display' );
    if ( $description || is_customize_preview() ) : ?>
      <p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
    <?php
    endif; ?>
  </div><!-- .site-branding-text-->
</div><!-- .site-branding -->
