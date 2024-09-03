<?php

/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Bootscore
 * @version 6.0.0
 */


// Exit if accessed directly
defined('ABSPATH') || exit;


if (!is_active_sidebar('sidebar-1')) {
  return;
}
?>
<div class="<?= apply_filters('bootscore/class/sidebar/col', 'col-lg-3 order-first order-lg-2'); ?>">
  <aside id="secondary" class="widget-area">

    <button class="<?= apply_filters('bootscore/class/sidebar/button', 'd-lg-none btn btn-outline-primary w-100 mb-4 d-flex justify-content-between align-items-center'); ?>" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-controls="sidebar">
      <?php esc_html_e('Open side menu', 'bootscore'); ?> <i class="fa-solid fa-ellipsis-vertical"></i>
    </button>

    <div class="<?= apply_filters('bootscore/class/sidebar/offcanvas', 'offcanvas-lg offcanvas-end'); ?>" tabindex="-1" id="sidebar" aria-labelledby="sidebarLabel">
      <div class="offcanvas-header">
        <span class="h5 offcanvas-title" id="sidebarLabel"><?php esc_html_e('Sidebar', 'bootscore'); ?></span>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebar" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body flex-column">     

        <!-- custom sidebar widget -->
        <div id="sidebar-top-widget" class="ql-widget-area widget-area" role="complementary">
          <div id="sidebar_currenttopics">
            <h4 class="wp-block-heading">CURRENT TOPICS</h4>
            <ul class="sidebar_current_topic_list"></ul>
            <?php            
            $side_blue_menu = wp_get_nav_menus();
            foreach ( $side_blue_menu as $menu /** @var WP_Term $menu */ ) {
              if ($menu->name == "Current Topics") {
                $menu_items = wp_get_nav_menu_items( $menu->term_id );
                if ( ! empty( $menu_items ) ) {
                  foreach ( $menu_items as $menu_item ) {
                    echo '<li class="sidebar_current_topic"><a href="' . $menu_item->url . '">' . $menu_item->title . '</a></li>';
                  }
                }
              }
            }
            ?>
            </ul>
            <hr class="wp-block-separator has-text-color has-black-color has-alpha-channel-opacity has-black-background-color has-background is-style-wide" />
          </div>
        </div>
        <!-- end custom sidebar widget -->

        <?php dynamic_sidebar('sidebar-1'); ?>		  
      </div>
    </div>

  </aside><!-- #secondary -->
</div>
