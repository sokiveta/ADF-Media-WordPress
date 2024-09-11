<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Bootscore
 * @version 6.0.0
 */

// Exit if accessed directly
defined('ABSPATH') || exit;

?>
<!doctype html>
<html <?php language_attributes(); ?>  dir="ltr" prefix="content: http://purl.org/rss/1.0/modules/content/  dc: http://purl.org/dc/terms/  foaf: http://xmlns.com/foaf/0.1/  og: http://ogp.me/ns#  rdfs: http://www.w3.org/2000/01/rdf-schema#  schema: http://schema.org/  sioc: http://rdfs.org/sioc/ns#  sioct: http://rdfs.org/sioc/types#  skos: http://www.w3.org/2004/02/skos/core#  xsd: http://www.w3.org/2001/XMLSchema# ">

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="profile" href="https://gmpg.org/xfn/11">
  <meta name="description" content="<?= esc_attr(get_the_excerpt()) ?>" />
  <link rel="canonical" href="<?= esc_url(get_permalink()) ?>" />
  <meta property="og:type" content="Press Release" />
  <meta property="og:url" content="<?= esc_url(get_permalink()) ?>" />
  <meta property="og:title" content="<?= esc_attr(get_the_title()) ?>" />
  <meta property="og:description" content="<?= esc_attr(get_the_excerpt()) ?>" />
  <meta property="og:image" content="<?= esc_url(get_the_post_thumbnail_url(null, 'full')) ?>" />	
  <meta property="fb:app_id" content="119697833097399" />
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?> 

<div id="page" class="site">
  
  <a class="skip-link visually-hidden-focusable" href="#primary"><?php esc_html_e( 'Skip to content', 'bootscore' ); ?></a>

  <!-- Top Bar Widget -->
  <?php if (is_active_sidebar('top-bar')) : ?>
    <?php dynamic_sidebar('top-bar'); ?>
  <?php endif; ?>  

  <header id="masthead" class="<?= apply_filters('bootscore/class/header', 'sticky-top'); ?> site-header"> 
    <!-- bg-body-tertiary -->

    <nav id="nav-main" class="navbar <?= apply_filters('bootscore/class/header/navbar/breakpoint', 'navbar-expand-lg'); ?>">

      <div class="<?= apply_filters('bootscore/class/container', 'container', 'header'); ?>">
        <!-- Navbar Brand -->
        <a class="navbar-brand" href="<?= esc_url(home_url()); ?>">
          <img src="<?= esc_url(apply_filters('bootscore/logo', get_stylesheet_directory_uri() . '/assets/img/logo/logo.png', 'default')); ?>" alt="<?php bloginfo('name'); ?> Logo" class="d-td-none me-2">
          <img src="<?= esc_url(apply_filters('bootscore/logo', get_stylesheet_directory_uri() . '/assets/img/logo/logo-theme-dark.svg', 'theme-dark')); ?>" alt="<?php bloginfo('name'); ?> Logo" class="d-tl-none me-2">
        </a>  

        <!-- Offcanvas Navbar -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvas-navbar">
          <div class="offcanvas-header">
            <span class="h5 offcanvas-title"><?= apply_filters('bootscore/offcanvas/navbar/title', __('Menu', 'bootscore')); ?></span>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
          </div>
          <div class="offcanvas-body">

            <!-- Bootstrap 5 Nav Walker Main Menu -->
            <?php get_template_part('template-parts/header/main-menu'); ?>

            <!-- Top Nav 2 Widget -->
            <?php if (is_active_sidebar('top-nav-2')) : ?>
              <?php dynamic_sidebar('top-nav-2'); ?>
            <?php endif; ?>

          </div>
        </div>

        <div class="header-actions d-flex align-items-center">

          <!-- Top Nav Widget -->
          <?php if (is_active_sidebar('top-nav')) : ?>
            <?php dynamic_sidebar('top-nav'); ?>
          <?php endif; ?>

          <?php
          if (class_exists('WooCommerce')) :
            get_template_part('template-parts/header/actions', 'woocommerce'); 
          else :
            get_template_part('template-parts/header/actions');
          endif;
          ?>

          <!-- Navbar Toggler -->
          <button class="<?= apply_filters('bootscore/class/header/button', 'btn btn-outline-secondary', 'nav-toggler'); ?> <?= apply_filters('bootscore/class/header/navbar/toggler/breakpoint', 'd-lg-none'); ?> ms-1 ms-md-2 nav-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas-navbar" aria-controls="offcanvas-navbar">
            <i class="fa-solid fa-bars"></i><span class="visually-hidden-focusable">Menu</span>
          </button>
          
        </div><!-- .header-actions -->		  
      </div><!-- .container -->
    </nav><!-- .navbar -->


    <div id="header-widget-area" class="ql-widget-area widget-area" role="complementary">
	  <div class="container">
        <div id="bluebar">
			<h5 class="wp-block-heading">CURRENT TOPICS</h5>
<?php     
    // BLUE BAR "CURRENT TOPICS" HEADER WIDGET
    $blue_menu = wp_get_nav_menus();
    foreach ( $blue_menu as $menu /** @var WP_Term $menu */ ) {
        if ($menu->name == "Current Topics") {
            $menu_items = wp_get_nav_menu_items( $menu->term_id );
            $isFirst = true;     
            if ( ! empty( $menu_items ) ) {
                foreach ( $menu_items as $menu_item ) {
                    echo ($isFirst === true) ? $isFirst = false : '<div class="topic_divider">|</div>';
                    echo '<div class="current_topic"><a href="' . $menu_item->url . '">' . $menu_item->title . '</a></div>';
                }
            }
        }
    }
?>
		</div>
      </div>
    </div>
	  
    <?php
    if (class_exists('WooCommerce')) :
      get_template_part('template-parts/header/collapse-search', 'woocommerce');
    else :
      get_template_part('template-parts/header/collapse-search');
    endif;
    ?>

    <!-- Offcanvas User and Cart -->
    <?php
    if (class_exists('WooCommerce')) :
      get_template_part('template-parts/header/offcanvas', 'woocommerce');
    endif;
    ?>

  </header><!-- #masthead -->

<!-- Left-side buttons: share, print --> 
 <?php 
if ( $post_type == 'case' || $post_type == 'press_release' ) {
 $full_url = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; 
 $title = get_the_title();
 ?>  
<div class="social-side-bar">
	<div class="popout-button social-popup-btn">
		<i class="fa fa-share-alt"></i><br />
		Share
        </div>
        <div class="popout-container">
		<div class="fb-popout-btn"><a target="_blank" class="facebook-share-btn"><i class="fab fa-facebook-f"></i></a></div>
		<div class="tw-popout-btn"><a target="_blank" class="twitter-share-btn"><i class="fab fa-twitter"></i></a></div>
		<div class="ln-popout-btn"><a target="_blank" class="linkedin-share-btn"><i class="fab fa-linkedin"></i></i></a></div> 
		<div class="email-popout-btn"><a target="_blank" class="email-share-btn"><i class="fa fa-envelope"></i></a></div>             
        </div>
</div>
<div class="popout-button print-btn">
	<i class="far fa-newspaper"></i>
        <br />
        Print
</div>
	
<?php } ?>