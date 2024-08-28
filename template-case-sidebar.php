<?php
/*
Template Name: Case Sidebar Template
*/
?>
<?php
get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <?php
        while ( have_posts() ) :
            the_post();
            get_template_part( 'template-parts/content', 'page' );
        endwhile;
        ?>
    </main>

    <aside id="case-sidebar" class="widget-area">
        <?php dynamic_sidebar( 'case-sidebar' ); ?>
    </aside>
</div>

<div id="case-bottom-area" class="widget-area">
    <?php dynamic_sidebar( 'case-bottom-area' ); ?>
</div>

<?php
get_footer();
?>
