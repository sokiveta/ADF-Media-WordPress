<?php
get_header();
?>

<div id="primary" class="content-area container case-container">
    <div class="row">
        <div class="col-lg-8">
            <main id="main" class="site-main">
                <?php
                while ( have_posts() ) :
                    the_post();
                    $case_id = get_the_ID();
                    $pod = pods('case', $case_id);
                    $post_title = get_the_title();
                ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <header class="entry-header">
                            <h1 class="case-heading entry-title"><?php the_title(); ?></h1>

                            <?php if ( $pod->field( 'cases_sub_title' ) ) : ?>
                                <h2 class="entry-subtitle"><?php echo esc_html( $pod->field( 'cases_sub_title' ) ); ?></h2>
                            <?php endif; ?>

                        </header>

                        <div class="entry-content">
                            <div class="case_description">
                                <?php
                                // Display the content of the post
                                the_content();
                                ?>
                            </div>
                            
                            <hr />
                            <?php

                            // Custom SQL query to filter by related case
                            $params = array(
                                'limit' => 1, // Limit to one result
                                'where' => array(
                                    'press_release_related_cases' => $case_id
                                )
                            );
                            $press_pod = pods('press_release', $params);

                            if ($press_pod->total() > 0) {
                                while ($press_pod->fetch()) {                                    
                                    echo get_the_post_thumbnail($press_pod->ID(), 'full', array('alt' => $press_pod->field('post_title')));    
                                    echo '<h2 class="case_subtitle">'.$press_pod->field('post_title').'</h2>';
                                    echo '<p><strong>'.$press_pod->field('press_release_subtitle').'</strong></p>';
                                    echo '<p>'.date('l, M j, Y',strtotime($press_pod->field('press_release_published_on'))).'</p>';
                                    echo '<p>'.$press_pod->field('post_content').'</p>';
                                }
                            } else {
                                echo 'No related press releases found.';
                            }

                            ?>
                        </div>
                        
                        <div id="adf-page-bottom-area" class="widget-area">                         

                            <?php 
                            // Display video
                            if (!empty($pod->field( 'cases_extras' ))) {
                                echo '<div>'.$pod->field('cases_extras').'</div>
                                <hr />';
                            }

                            // create photo link
                            $params_img = array(
                                'limit' => 1, // Limit to one result
                                'where' => array(
                                    'media_photos_related_cases' => $case_id
                                )
                            );
                            $pod_img = pods('media_photos', $params_img);                            
                            if (!empty($pod_img->field( 'media_photo_images' ))) {
                                // display link to this pod's page
                                echo '<div class="bottom_item">
                                    <h4>Photos</h4>
                                    <a href="'.get_permalink($pod_img->ID()).'">'.$post_title.' photos</a>
                                    <hr />
                                </div>';
                            }

                            dynamic_sidebar( 'adf-page-bottom-area' ); ?>

                        </div>

                        <?php if ( get_edit_post_link() ) : ?>
                            <footer class="entry-footer">
                                <?php
                                // edit_post_link(
                                //     sprintf(
                                //         wp_kses(
                                //             /* translators: %s: Name of current post. Only visible to screen readers */
                                //             __( 'Edit <span class="screen-reader-text">%s</span>', 'your-text-domain' ),
                                //             array(
                                //                 'span' => array(
                                //                     'class' => array(),
                                //                 ),
                                //             )
                                //         ),
                                //         get_the_title()
                                //     ),
                                //     '<span class="edit-link btn btn-primary">',
                                //     '</span>'
                                // );
                                ?>
                            </footer>
                        <?php endif; ?>
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

    <!-- <div class="row">
        <div class="col-12">
            <div id="case-bottom-area" class="widget-area">
                <?php // dynamic_sidebar( 'case-bottom-area' ); ?>
            </div>
        </div>
    </div> -->
</div>

<?php
get_footer();
?>
