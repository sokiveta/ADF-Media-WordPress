<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Bootscore
 * @version 6.0.0
 */

// Exit if accessed directly
defined('ABSPATH') || exit;

?>


<footer class="bootscore-footer">

  <?php if (is_active_sidebar('footer-top')) : ?>
    <div class="bootscore-footer-top">
      <div class="<?= apply_filters('bootscore/class/container', 'container', 'footer-top'); ?>">  
        <?php dynamic_sidebar('footer-top'); ?>
      </div>
    </div>
  <?php endif; ?>
  
  <div class="bootscore-footer-columns">

    <div class="<?= apply_filters('bootscore/class/container', 'container', 'footer-columns'); ?>">  

      <div class="row">

        <div class="<?= apply_filters('bootscore/class/footer/col', 'col-lg-3 col-sm-12', 'footer-1'); ?>">
          <?php if (is_active_sidebar('footer-1')) : ?>
            <?php dynamic_sidebar('footer-1'); ?>
          <?php endif; ?>
        </div>

        <div class="<?= apply_filters('bootscore/class/footer/col', 'col-lg-9 col-sm-12', 'footer-2'); ?>">
          <?php if (is_active_sidebar('footer-2')) : ?>
            <?php dynamic_sidebar('footer-2'); ?>
            
            <div class="row">
              
              <div class="<?= apply_filters('bootscore/class/footer/col', 'col-6 col-lg-3', 'footer-3'); ?>">
                <?php if (is_active_sidebar('footer-3')) : ?>
                  <?php dynamic_sidebar('footer-3'); ?>
                <?php endif; ?>
              </div>
              
              <div class="<?= apply_filters('bootscore/class/footer/col', 'col-6 col-lg-3', 'footer-4'); ?>">
                <?php if (is_active_sidebar('footer-4')) : ?>
                  <?php dynamic_sidebar('footer-4'); ?>
                <?php endif; ?>
              </div>
              
              <div class="<?= apply_filters('bootscore/class/footer/col', 'col-6 col-lg-3', 'footer-5'); ?>">
                <?php if (is_active_sidebar('footer-5')) : ?>
                  <?php dynamic_sidebar('footer-5'); ?>
                <?php endif; ?>
              </div>
              
              <div class="<?= apply_filters('bootscore/class/footer/col', 'col-6 col-lg-3', 'footer-6'); ?>">
                <?php if (is_active_sidebar('footer-6')) : ?>
                  <?php dynamic_sidebar('footer-6'); ?>
                <?php endif; ?>
              </div>

            </div>

          <?php endif; ?>

        </div>
        
      </div>

      <!-- Bootstrap 5 Nav Walker Footer Menu -->
      <?php get_template_part('template-parts/footer/footer-menu'); ?>

    </div>
  </div>

  <div class="bootscore-footer-info">
    <div class="<?= apply_filters('bootscore/class/container', 'container', 'footer-info'); ?>">
      <?php if (is_active_sidebar('footer-info')) : ?>
        <?php dynamic_sidebar('footer-info'); ?>
      <?php endif; ?>
    </div>
  </div>

</footer>

<!-- To top button -->
<a href="#" class="<?= apply_filters('bootscore/class/footer/to_top_button', 'btn btn-primary shadow'); ?> position-fixed z-2 top-button"><i class="fa-solid fa-chevron-up"></i><span class="visually-hidden-focusable">To top</span></a>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>

</html>