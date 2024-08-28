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
            __( 'WPBeginner Widget', 'textdomain' ),
 
            // Widget description
            [
                'description' => __( 'Sample widget based on WPBeginner Tutorial', 'textdomain' ),
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
        echo __( 'Hello, World!', 'textdomain' );
        echo $args['after_widget'];
    }
 
    // Widget Settings Form
    public function form( $instance ) {
        if ( isset( $instance['title'] ) ) {
            $title = $instance['title'];
        } else {
            $title = __( 'New title', 'textdomain' );
        }
 
        // Widget admin form
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>">
                <?php _e( 'Title:', 'textdomain' ); ?>
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

function bluebar_widgets_init() {
    $menus = wp_get_nav_menus();
    $current_topics = '';
    foreach ( $menus as $menu /** @var WP_Term $menu */ ) {
        if ($menu->name == "Current Topics") {
            $menu_items = wp_get_nav_menu_items( $menu->term_id );
            $isFirst = true;     
            if ( ! empty( $menu_items ) ) {
                foreach ( $menu_items as $menu_item ) {
                    $current_topics .= ($isFirst === true) ? $isFirst = false : '<div class="topic_divider">|</div>';
                    $current_topics .= '<div class="current_topic"><a href="' . $menu_item->url . '">' . $menu_item->title . '</a></div>';
                }
            }
        }
    }
    register_sidebar( array(
        'name' => 'Blue Bar Header Widget',
        'id' => 'bluebar-header-widget',
        'before_widget' => '<div id="bluebar">',
        'after_widget' => $current_topics.'</div>'
    ) );
}
add_action( 'widgets_init', 'bluebar_widgets_init' );


function sidebar_currenttopics_widgets_init() {
    $menus = wp_get_nav_menus();
    $sidebar_current_topics = '<ul class="sidebar_current_topic_list">';
    foreach ( $menus as $menu /** @var WP_Term $menu */ ) {
        if ($menu->name == "Current Topics") {
            $menu_items = wp_get_nav_menu_items( $menu->term_id );
            if ( ! empty( $menu_items ) ) {
                foreach ( $menu_items as $menu_item ) {
                    $sidebar_current_topics .= '<li class="sidebar_current_topic"><a href="' . $menu_item->url . '">' . $menu_item->title . '</a></li>';
                }
            }
        }
    }
	$sidebar_current_topics .= '</ul>';
	$sidebar_current_topics .= '<hr class="wp-block-separator has-text-color has-black-color has-alpha-channel-opacity has-black-background-color has-background is-style-wide" />';
    register_sidebar( array(
        'name' => 'Sidebar Current Topics Widget',
        'id' => 'sidebar-currenttopics-widget',
        'before_widget' => '<div id="sidebar_currenttopics">',
        'after_widget' => $sidebar_current_topics.'</div>'
    ) );
}
add_action( 'widgets_init', 'sidebar_currenttopics_widgets_init' );


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

function register_adf_page_sidebars() {

    register_sidebar( array(
        'name' => 'ADF Page Sidebar',
        'id' => 'adf-page-sidebar',
        'before_widget' => '<div class="widget">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    register_sidebar( array(
        'name' => 'ADF Page Bottom Area',
        'id' => 'adf-page-bottom-area',
        'before_widget' => '<div class="widget">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
}
add_action( 'widgets_init', 'register_adf_page_sidebars' );


class adf_sidebar_section extends WP_Widget {
    // legal_documents_widget
    function __construct() {
        parent::__construct(
        // Base ID of your widget
            'adf_sidebar_section',
 
            // Widget name will appear in UI
            __( 'ADF Sidebar Section', 'textdomain' ),
 
            // Widget description
            [
                'description' => __( 'Sidebar section for ADF related info on case and press release pages', 'textdomain' ),
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

            // echo "<pre>";
            // print_r($pod_field);
            // echo "</pre>";
            
            echo __( '<ul class="sidebar_list">', 'textdomain' );
            foreach ($pod_field AS $f) {
                if (isset($f['post_title']) && $f['post_title'] != "") {
                    if ($f['post_type'] == "biography") {
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
                        $legal_file_link = "<li class='sidebar_list_item'> 
						<a href='".str_replace('https://adfmediadev.wpenginepowered.com/?cases', 'https://adfmediadev.wpenginepowered.com/?case', $f['guid'])."'>".$f['post_title']."</a></li>";                
                    } elseif ($f['post_type'] == "press_release") {
                        $legal_file_link = "<li class='below_list_item'> 
                            <a href='".$f['guid']."'>".$f['post_title']."</a>
                            <p>".date('l, M j, Y', strtotime($f['post_date']))."</p>
                        </li>";
                    } else { 
                        $legal_file_link = "<li class='sidebar_list_item'> <a href='".$f['guid']."'>".$f['post_title']."</a></li>";                        
                    }

                    echo __( $legal_file_link, 'textdomain' );
                }
            } 
            echo __( '</ul>', 'textdomain' );
            echo "</div>";
            echo $args['after_widget'];
        } 
    }
 
    // Widget Settings Form
    public function form( $instance ) {
        if ( isset( $instance['title'] ) ) {
            $title = $instance['title'];
        } else {
            $title = __( 'New title', 'textdomain' );
        } 
        $field = ! empty( $instance['field'] ) ? $instance['field'] : '';

        // Widget admin form
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>">
                <?php _e( 'Title:', 'textdomain' ); ?>
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

