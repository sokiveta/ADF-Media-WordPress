<?php get_header(); ?>
<div id="primary" class="content-area container case-container">
    <div class="row">
        <div class="col-lg-8">
            <main id="main" class="site-main">
                <?php
                while ( have_posts() ) :
                    the_post();
                    $pod = pods( 'press_release', get_the_ID() );
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>    

                        <header class="entry-header">

                            <?php // bootscore_category_badge(); ?>
                            <h1 class="case-heading entry-title press_release_h1"><?php the_title(); ?></h1>
                            
                            <?=get_the_post_thumbnail($pod->ID(), 'full', array('alt' => $pod->field('post_title')))?>
                            
                            <p class="entry-meta">
                                <small class="text-body-secondary">
                                <?php
                                // echo '<p>'.date('l, M j, Y',strtotime($pod->field('press_release_published_on'))).'</p>';
                                // bootscore_date();
                                // bootscore_author();
                                // bootscore_comment_count();
                                ?>
                                </small>
                            </p>


                            <?php if ( $pod->field( 'press_release_sub_title' ) ) : ?>
                                <h2 class="entry-subtitle"><?php echo esc_html( $pod->field( 'press_release_sub_title' ) ); ?></h2>
                            <?php endif; ?>

                        </header>

                        <div class="entry-content">
                            <?php
                            // Display the content of the post
                            the_content();
                            ?>
                        </div>

                        <hr />
                        
                        <div id="adf-page-bottom-area" class="widget-area">
                            <?php dynamic_sidebar( 'adf-page-bottom-area' ); ?>
                        </div>

                    </article>
                <?php
                endwhile;
                ?>
            </main>
        </div>

        <div class="col-lg-4">
            <aside id="adf-page-sidebar" class="widget-area">
                <?php dynamic_sidebar( 'adf-page-sidebar' ); ?>
            </aside>
        </div>
    </div>

</div>

<?php get_footer(); ?>
