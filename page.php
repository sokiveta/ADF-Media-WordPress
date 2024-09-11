<?php

/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Bootscore
 * @version 6.0.0
 */

// Exit if accessed directly
defined('ABSPATH') || exit;

get_header();
?>

  <div id="content" class="site-content <?= apply_filters('bootscore/class/container', 'container', 'page'); ?>">
    <div id="primary" class="content-area">

      <div class="row">
        <div class="<?= apply_filters('bootscore/class/main/col', 'col'); ?>">

          <main id="main" class="site-main">

            <div class="entry-header">
              <?php the_post(); ?>
              <?php // the_title(); ?>
              <?php bootscore_post_thumbnail(); ?>
            </div>

            <div class="entry-content">
              <?php the_content(); ?>
            </div>

            <div class="entry-footer">
              <?php comments_template(); ?>
            </div>

          </main>

        </div>
        <?php get_sidebar(); ?>
      </div>

    </div>
  </div>

<?php
get_footer();
