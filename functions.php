<?php

/**
 * @package Bootscore Child
 *
 * @version 6.0.0
 */

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * Enqueue scripts and styles
 */
add_action('wp_enqueue_scripts', 'bootscore_child_enqueue_styles');
function bootscore_child_enqueue_styles() {

  // Compiled main.css
  $modified_bootscoreChildCss = date('YmdHi', filemtime(get_stylesheet_directory() . '/assets/css/main.css'));
  wp_enqueue_style('main', get_stylesheet_directory_uri() . '/assets/css/main.css', array('parent-style'), $modified_bootscoreChildCss);

  // style.css
  wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
  
  // custom.js
  // Get modification time. Enqueue file with modification date to prevent browser from loading cached scripts when file content changes. 
  $modificated_CustomJS = date('YmdHi', filemtime(get_stylesheet_directory() . '/assets/js/custom.js'));
  wp_enqueue_script('custom-js', get_stylesheet_directory_uri() . '/assets/js/custom.js', array('jquery'), $modificated_CustomJS, false, true);
}

### Custom Widgets ###

class wpb_widget extends WP_Widget {
    function __construct() {
        parent::__construct(
        // Base ID of your widget
            'wpb_widget',
 
            // Widget name will appear in UI
            __( 'WPBeginner Widget', 'adf-bootscore-child-theme' ),
 
            // Widget description
            [
                'description' => __( 'Sample widget based on WPBeginner Tutorial', 'adf-bootscore-child-theme' ),
            ]
        );
    }
 
    // Creating widget front-end
    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance['title'] );
 
        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        if ( ! empty( $title ) ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
 
        // This is where you run the code and display the output
        echo __( 'Hello, World!', 'adf-bootscore-child-theme' );
        echo $args['after_widget'];
    }
 
    // Widget Settings Form
    public function form( $instance ) {
        if ( isset( $instance['title'] ) ) {
            $title = $instance['title'];
        } else {
            $title = __( 'New title', 'adf-bootscore-child-theme' );
        }
 
        // Widget admin form
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>">
                <?php _e( 'Title:', 'adf-bootscore-child-theme' ); ?>
            </label>
            <input
                    class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
                    name="<?php echo $this->get_field_name( 'title' ); ?>"
                    type="text"
                    value="<?php echo esc_attr( $title ); ?>"
            />
        </p>
        <?php
    }
 
    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance          = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
 
        return $instance;
    }

    // Class wpb_widget ends here
}
 
// Register and load the widget
function wpb_load_widget() {
    register_widget( 'wpb_widget' );
}
add_action( 'widgets_init', 'wpb_load_widget' );

function register_copyright_date_block() {
    // Register the block script
    wp_register_script(
        'copyright-date-block-editor-script',
        get_template_directory_uri() . '/path-to-your-block/index.js',
        array('wp-blocks', 'wp-element', 'wp-editor', 'wp-i18n')
    );

    // Register the block type
    register_block_type('your-namespace/copyright-date-block', array(
        'editor_script' => 'copyright-date-block-editor-script',
        'render_callback' => 'render_copyright_date_block',
    ));
}
add_action('init', 'register_copyright_date_block');

function rename_widget_areas() {
    // Unregister the old sidebars
    unregister_sidebar('sidebar-1'); // Sidebar
    unregister_sidebar('footer-1');  // Footer 1
    unregister_sidebar('footer-2');  // Footer 2
    unregister_sidebar('footer-3');  // Footer 3
    unregister_sidebar('footer-4');  // Footer 4
    unregister_sidebar('footer-info');  // Footer Info

    // Register the new sidebars with the desired names
    register_sidebar(array(
        'name'          => __('Sidebar - Global', 'adf-theme-2024'),
        'id'            => 'sidebar-1',
        'description'   => __('Widgets in this area will be shown on the global sidebar.', 'adf-theme-2024'),
        'before_widget' => '<section id="%1$s" class="widget mb-4 %2$s">',
        'after_widget'  => '</section>',
    ));

    register_sidebar( array(
        'name' => 'Sidebar - Cases / Press Releases',
        'id' => 'adf-page-sidebar',
        'before_widget' => '<div class="widget">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    register_sidebar( array(
        'name' => 'Bottom Area - Cases / Press Releases',
        'id' => 'adf-page-bottom-area',
        'before_widget' => '<div class="widget">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name'          => __('Footer Logo', 'adf-theme-2024'),
        'id'            => 'footer-1',
        'description'   => __('Widgets in this area will be shown in the footer logo area.', 'adf-theme-2024'),
        'before_widget' => '<div id="%1$s" class="widget footer_widget mb-3 %2$s">',
        'after_widget'  => '</div>',
    ));

    register_sidebar(array(
        'name'          => __('Footer Text', 'adf-theme-2024'),
        'id'            => 'footer-2',
        'description'   => __('Widgets in this area will be shown in the footer text area.', 'adf-theme-2024'),
        'before_widget' => '<div id="%1$s" class="widget footer_widget mb-3 %2$s">',
        'after_widget'  => '</div>',
    ));

    register_sidebar(array(
        'name'          => __('Footer Column 1', 'adf-theme-2024'),
        'id'            => 'footer-3',
        'description'   => __('Widgets in this area will be shown in the first footer column.', 'adf-theme-2024'),
        'before_widget' => '<div id="%1$s" class="widget footer_widget mb-3 %2$s">',
        'after_widget'  => '</div>',
    ));

    register_sidebar(array(
        'name'          => __('Footer Column 2', 'adf-theme-2024'),
        'id'            => 'footer-4',
        'description'   => __('Widgets in this area will be shown in the second footer column.', 'adf-theme-2024'),
        'before_widget' => '<div id="%1$s" class="widget footer_widget mb-3 %2$s">',
        'after_widget'  => '</div>',
    ));

    register_sidebar(array(
        'name'          => __('Footer Copyright Info', 'adf-theme-2024'),
        'id'            => 'footer-info',
        'description'   => __('Widgets in this area will be shown in the footer copyright info area.', 'adf-theme-2024'),
        'before_widget' => '<div id="%1$s" class="widget footer_widget mb-3 %2$s">',
        'after_widget'  => '</div>',
    ));
}

add_action('widgets_init', 'rename_widget_areas', 11);

function unregister_unwanted_widgets() {
    // Remove WordPress widgets
    unregister_sidebar('top-bar');
    unregister_sidebar('top-nav');
    unregister_sidebar('top-nav-2');
    unregister_sidebar('footer-top');
    unregister_sidebar('404-page'); 
}

add_action('widgets_init', 'unregister_unwanted_widgets', 11);

class adf_sidebar_section extends WP_Widget {
    // legal_documents_widget
    function __construct() {
        parent::__construct(
        // Base ID of your widget
            'adf_sidebar_section',
 
            // Widget name will appear in UI
            __( 'ADF Sidebar Section', 'adf-bootscore-child-theme' ),
 
            // Widget description
            [
                'description' => __( 'Sidebar section for ADF related info on case and press release pages', 'adf-bootscore-child-theme' ),
            ]
        );
    }
 
    // Creating widget front-end
    public function widget( $args, $instance ) {
        global $post;
        $title = apply_filters( 'widget_title', $instance['title'] );
        $field = ! empty( $instance['field'] ) ? $instance['field'] : '';
        if ($post->post_type == "press_release") {
            $pod = pods( "press_release", $post->ID );
        } elseif ($post->post_type == "case") {
            $pod = pods( "case", $post->ID );
        } else {
            $pod = pods( "case", $post->ID );
        }
        $pod_field = $pod->field($field);        

        if (is_array($pod_field) && count($pod_field) > 0) {
			
            // before and after widget arguments are defined by themes
            echo $args['before_widget'];

            echo "<div id='case-top-area'>";
            if ( ! empty( $title ) ) {
                echo "<h4 class='wp-block-heading'>" . $title . "</h4>";
            }      
			
			$adf_ul_class = "sidebar_list";		
            if (isset($pod_field[0]['post_type']) && $pod_field[0]['post_type'] != "") {				
             	if ($pod_field[0]['post_type'] == "press_release" || $pod_field[0]['post_type'] == "commentory" || $pod_field[0]['post_type'] == "commentary") {
			 		$adf_ul_class .= " threecol_ul";
             	} 
			}
            
			// echo "<pre>";
			// print_r($pod_field);
			// echo "</pre>";
			
            echo __( '<ul class="'.$adf_ul_class.'">', 'adf-bootscore-child-theme' );
            if (!is_array($pod_field)) {
              $legal_file_link = "<li class='sidebar_list_item'>".$pod_field."</li>";
            } else { 
              foreach ($pod_field AS $f) {
                if (!is_array($f)) {
                    $legal_file_link = "<li class='sidebar_list_item sidebar_link'>".$f."</li>";						
                } elseif ($f['post_type'] == "biography") {
                    $legal_file_link = "<li class='sidebar_list_item'>
                        <div class='case_biography'>
                            <div class='biography_header'>
                                <div class='biography_photo'><a href='".$f['guid']."'>".get_the_post_thumbnail($f['ID'], 'thumbnail', array('alt' => $f['post_title']))."</a></div>
                                <h6 class='below_list_item'><a href='".$f['guid']."'>ABOUT ".$f['post_title']."</a></h6>                        
                            </div>
                            <p>".$f['post_content']."</p>
                        </div>
                        </li>";
                    } elseif ($f['post_type'] == "attachment") {
                        $legal_file_link = "<li class='sidebar_list_item'>
						<a href='".str_replace('/home/wpe-user/sites/adfmediadev', '', $f['guid'])."' target='_blank'>".$f['post_excerpt']."</a></li>";
					} elseif ($f['post_type'] == "case") {  
                        $legal_file_link = "<li class='sidebar_list_item'> <a href='/case/". $f['post_name']."'>".$f['post_title']."</a></li>";                
                    } elseif ($f['post_type'] == "press_release") {
                        $legal_file_link = "<li class='below_list_item threecol_li'>
                            <a href='/press_release/".$f['post_name']."'>".$f['post_title']."</a>
                            <p>".date('l, M j, Y', strtotime($f['post_date']))."</p>
                        </li>";
                    } elseif ($f['post_type'] == "commentory" || $f['post_type'] == "commentary") {                 
                        $commentary_link = get_post_meta($f['ID'], 'link_url', true);
                        $link_url = ($commentary_link) ? esc_url($commentary_link) : $f['guid'];
                        $commentary_author = get_post_meta($f['ID'], 'link_author', true);       
                        $author_name = ($commentary_author) ? esc_html($commentary_author) : get_the_author_meta('display_name', $f['post_author']);
                        $legal_file_link = "<li class='below_list_item threecol_li'>
                            <a href='".$link_url."' target='_blank'>".$f['post_title']."</a>
                            <p>".$author_name."</p>
                        </li>";
                    } else { 
                        $legal_file_link = "<li class='sidebar_list_item'>
						<a href='".$f['guid']."'>".$f['post_title']."</a> ... </li>";
                    }

                    echo __( $legal_file_link, 'adf-bootscore-child-theme' );
                }
            } 
            echo __( '</ul>', 'adf-bootscore-child-theme' );
            echo "</div>";
            echo $args['after_widget'];
        } 
    }
 
    // Widget Settings Form
    public function form( $instance ) {
        if ( isset( $instance['title'] ) ) {
            $title = $instance['title'];
        } else {
            $title = __( 'New title', 'adf-bootscore-child-theme' );
        } 
        $field = ! empty( $instance['field'] ) ? $instance['field'] : '';

        // Widget admin form
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>">
                <?php _e( 'Title:', 'adf-bootscore-child-theme' ); ?>
            </label>
            <input
                    class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
                    name="<?php echo $this->get_field_name( 'title' ); ?>"
                    type="text"
                    value="<?php echo esc_attr( $title ); ?>"
            />
        </p>       
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'field' ) ); ?>"><?php _e( 'Field:', 'text_domain' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'field' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'field' ) ); ?>" type="text" value="<?php echo esc_attr( $field ); ?>">
        </p> 
        <?php
    }
 
    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance          = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['field'] = ! empty( $new_instance['field'] ) ? sanitize_text_field( $new_instance['field'] ) : '';

        return $instance;
    }
 
    // Class adf_sidebar_section ends here
}

// Register and load the widget
function csl_load_widget() {
    register_widget( 'adf_sidebar_section' );
}
add_action( 'widgets_init', 'csl_load_widget' );

function homepageheadlines_shortcode($atts) {
    $args = shortcode_atts(array(
        'pod_name' => 'case',
        'limit' => 3,
        'orderby' => 'date DESC',
        'where' => ''
    ), $atts);    
    $pod = pods($args['pod_name'], array(
        'limit' => $args['limit'],
        'orderby' => $args['orderby'],
        'where' => $args['where'],
    )); 
    $img_size = ($args['pod_name'] == "case")?'medium':'thumbnail';
    $output = '';    
    $pod_thumbnail_url = false;
    if ($pod->total() > 0) {
        while ($pod->fetch()) {
            $permalink = $pod->field('permalink');
            $post_title = $pod->field('post_title');
            $post_content = $pod->field('post_content');
            $post_date = $pod->field('post_date');
            $post_thumbnail_url = $pod->field('post_thumbnail_url');
            // Get the featured image of the first related press release
            $related_items = $pod->field('cases_related_press_release');
            if ($related_items && is_array($related_items)) { 
                $related_pod = pods('press_release', $related_items[0]['ID']);
                $pod_thumbnail_url = wp_get_attachment_url(get_post_thumbnail_id($related_pod->field('ID')), $img_size);
				$pod_title = $related_pod->field('post_title'); 
				$pod_content = $related_pod->field('press_release_card_summary'); 
            }
            $thumbnail_url = $pod_thumbnail_url ? $pod_thumbnail_url : "http://localhost/adfmediadev.wpenginepowered.com/wp-content/uploads/2024/08/adf-logo-gray-254x280-1.png";
            if ($args['pod_name'] == "case") {
                // case
                $output .= '<div class="homepage-headlines">';
                $output .= '<div class="headline-image">';
                $output .= '<a href="' . esc_url($permalink) . '">';
                $output .= '<img src="' . $thumbnail_url . '" alt="' . esc_attr($pod_title) . '" />';
                $output .= '</a>';
                $output .= '</div>';	
                $output .= '<div class="headline-text">';
                $output .= '<h2><a href="' . esc_url($permalink) . '">' . esc_html($pod_title) . '</a></h2>';
                $output .= '<div>' . $pod_content . ' <span class="readmore"><nobr><a href="' . esc_url($permalink) . '">Read More &gt;&gt;</a></nobr></span></div>';
                $output .= '</div>';
                $output .= '<div style="clear:both"></div>';
                $output .= '</div>';
            } else {
                // press_release
                $output .= '<div class="homepage-coreissues">';
                $output .= '<div class="coreissues-image">';
                $output .= '<a href="' . esc_url($permalink) . '">';
                $output .= '<img src="' . $post_thumbnail_url . '" alt="' . esc_attr($post_title) . '" />';
                $output .= '</a>';
                $output .= '</div>';
                $output .= '<a href="' . esc_url($permalink) . '">' . esc_attr($post_title) . '</a>';
	            $output .= '<div class="date-text">' . esc_attr(date('l, M j, Y',strtotime($post_date))) . '</div>';
                $output .= '<div style="clear:both"></div>';
                $output .= '</div>';
            }
        }
    }
    return $output;
}
add_shortcode('homepageheadlines', 'homepageheadlines_shortcode');
