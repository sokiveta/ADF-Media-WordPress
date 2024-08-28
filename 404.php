<?php

/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Bootscore
 * @version 6.0.0
 */

// Exit if accessed directly
defined('ABSPATH') || exit;

get_header();
?>
  <div id="content" class="site-content <?= apply_filters('bootscore/class/container', 'container', '404'); ?> <?= apply_filters('bootscore/class/content/spacer', 'pt-4 pb-5', '404'); ?>">
    <div id="primary" class="content-area">

      <main id="main" class="site-main">

        <section class="error-404 not-found">
          <div class="page-404">

            <h1 class="mb-3">Page Not Found (404)</h1>
            <!-- Remove this line and place some widgets -->
            <p class="alert alert-info mb-4"><?php esc_html_e("We're sorry, we couldn't find the page you requested. Here is a quick search based on the page address; maybe the results have what you are looking for?", 'bootscore'); ?></p>
			<form class="adf-ajax-search row g-1">
			  <div class="col-10 col-lg-6">
				<div class="form-floating"><input id="adf-ajax-search-input1" class="adf-ajax-search-input form-control" type="text" placeholder="freedom of speech"><label for="adf-ajax-search-input1">Search Text</label></div>
			  </div>
			  <div class="col-2 col-lg-1">
				<button class="adf-ajax-search-go btn btn-dark p-3 d-block w-100" type="button">Search</button>
			  </div>
			  <div class="col-12 adf-ajax-search-results"></div>
			  <div class="col-12 adf-ajax-search-pagination-buttons text-center"></div>
			</form>
            <!-- 404 Widget -->
            <?php if (is_active_sidebar('404-page')) : ?>
              <div><?php dynamic_sidebar('404-page'); ?></div>
            <?php endif; ?>
            <a class="btn btn-outline-primary" href="<?= esc_url(home_url()); ?>" role="button"><?php esc_html_e('Back Home &raquo;', 'bootscore'); ?></a>
          </div>
        </section><!-- .error-404 -->

      </main><!-- #main -->

    </div><!-- #primary -->
  </div><!-- #content -->

<?php
get_footer();
