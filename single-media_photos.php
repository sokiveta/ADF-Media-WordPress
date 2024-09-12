<?php get_header(); ?>
<div id="primary" class="content-area container case-container">
    <div class="row">
        <div class="col-lg-9">
            <main id="main" class="site-main">
                <?php
                while ( have_posts() ) :
                    the_post();
                    $pod = pods( 'media_photos', get_the_ID() );
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>    

                        <header class="entry-header">
                            <?=get_the_post_thumbnail($pod->ID(), 'full', array('alt' => $pod->field('post_title')))?>

                            <?php // bootscore_category_badge(); ?>
                            <h1 class="case-heading entry-title press_release_h1"><?php the_title(); ?></h1>
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

                            // Assuming $images contains the array with media photo data
                            if (!empty($pod->field( 'media_photo_images' ))) {
                                foreach ($pod->field( 'media_photo_images' ) as $image) {
									$image_path = str_replace(array('/home/wpe-user/sites/adfmediadev', '/sites/adfmediadev'), '', $image['guid']);
                                    ?>
                                    <div class="row mb-4">
                                        <div class="col-md-5 text-right">
                                            <a href="<?php echo esc_url($image_path); ?>" target="_blank">
                                                <img src="<?php echo esc_url($image_path); ?>" class="img-fluid" style="max-width: 300px;" alt="<?php echo esc_attr($image['post_title']); ?>">
                                            </a>
                                        </div>
                                        <div class="col-md-7">
                                            <h3><?php echo esc_html($image['post_content']); ?></h3>
                                        </div>
                                    </div>
                                    <?php
                                }
                            } else {
                                echo 'No images found.';
                            }

                            ?>
                        </div>

                        <hr />
                        
                        <div id="adf-page-bottom-area" class="widget-area">
                            <?php // dynamic_sidebar( 'adf-page-bottom-area' ); ?>
                        </div>

                    </article>
                <?php
                endwhile;
                ?>
            </main>
        </div>

        <?php get_sidebar(); ?>
    </div>

</div>

<?php get_footer(); ?>
