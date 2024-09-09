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
                                    // Check if the featured image (post thumbnail) exists
                                    $post_thumbnail = get_the_post_thumbnail($press_pod->ID(), 'full', array('alt' => $press_pod->field('post_title')));
                                    if ($post_thumbnail) {
                                        echo $post_thumbnail;
                                    }

                                    // Check if the post title exists
                                    $post_title = $press_pod->field('post_title');
                                    if (!empty($post_title)) {
                                        echo '<h2 class="case_subtitle">' . esc_html($post_title) . '</h2>';
                                    }

                                    // Check if the press release subtitle exists
                                    $press_release_subtitle = $press_pod->field('press_release_subtitle');
                                    if (!empty($press_release_subtitle)) {
                                        echo '<p><strong>' . esc_html($press_release_subtitle) . '</strong></p>';
                                    }

                                    // Check if the press release published date exists
                                    // $press_release_published_on = $press_pod->field('press_release_published_on');
                                    // if (!empty($press_release_published_on)) {
                                    //     echo '<p>' . esc_html(date('l, M j, Y', strtotime($press_release_published_on))) . '</p>';
                                    // }

                                    // Check if the post content exists
                                    $post_content = $press_pod->field('post_content');
                                    if (!empty($post_content)) {
                                        echo '<p>' . wp_kses_post($post_content) . '</p>';
                                    }
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
                                echo '<div class="adf_featured_coverage">'.$pod->field('cases_extras').'</div>
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

                            // Legal Documents: internal and external
                            if (is_array($pod->field('cases_internal_legal_files')) && 
                                count($pod->field('cases_internal_legal_files')) > 0 && 
                                is_array($pod->field('cases_external_legal_files')) && 
                                count($pod->field('cases_external_legal_files')) > 0) {
                                $combined_files = array_merge(
                                    $pod->field('cases_internal_legal_files'), 
                                    $pod->field('cases_external_legal_files')
                                );
                            } elseif (is_array($pod->field('cases_internal_legal_files')) && count($pod->field('cases_internal_legal_files')) > 0) {
                                $combined_files = $pod->field('cases_internal_legal_files'); 
                            } elseif (is_array($pod->field('cases_external_legal_files')) && count($pod->field('cases_external_legal_files')) > 0) {
                                $combined_files = $pod->field('cases_external_legal_files'); 
                            }
                            if (is_array($combined_files) && count($combined_files) > 0) {		
                                // Function to sort by date in descending order
                                usort($combined_files, function($a, $b) {
                                    $date_a = strtotime($a['post_date']); 
                                    $date_b = strtotime($b['post_date']); 
                                    return $date_b - $date_a;
                                });
                                if (!empty($combined_files)) {
                                    echo '<div class="bottom_item">';
                                    echo '<h4>Legal Documents</h4>';
                                    echo '<ul>';
                                    foreach ($combined_files as $file) {
                                        echo '<li>
                                        <a href="'.str_replace('/home/wpe-user/sites/adfmediadev', '', $file['guid']).'" target="_blank">' . esc_html($file['post_title']) . '</a> - ' . date('F j, Y', strtotime($file['post_date'])) . '</li>';
                                    }
                                    echo '</ul>';
                                    echo '</div>';
                                    echo '<hr />';
                                }					
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
