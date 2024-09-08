<?php
/**
 * E2m functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package E2m
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function e2m_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on E2m, use a find and replace
		* to change 'e2m' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'e2m', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'e2m' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'e2m_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'e2m_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function e2m_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'e2m_content_width', 640 );
}
add_action( 'after_setup_theme', 'e2m_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function e2m_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'e2m' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'e2m' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'e2m_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function e2m_scripts() {
	wp_enqueue_style( 'e2m-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'e2m-style', 'rtl', 'replace' );

	wp_enqueue_script( 'e2m-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'e2m_scripts' );

function custom_enqueue_style(){
	wp_enqueue_style('style', get_template_directory_uri() . '/css/style.css');	
}
add_action( 'wp_enqueue_scripts', 'custom_enqueue_style' );

// Main Js impliment

function custom_enqueue_script(){
	wp_enqueue_script('main', get_template_directory_uri() . '/js/main.js');
}
add_action( 'wp_enqueue_scripts', 'custom_enqueue_script' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

// Property Post Type
function create_property_post_type() {
    register_post_type('property', array(
        'labels'      => array(
            'name'          => __('Properties'),
            'singular_name' => __('Property'),
        ),
        'public'      => true,
        'has_archive' => true,
        'supports'    => array('title', 'editor', 'thumbnail'),
        'rewrite'     => array('slug' => 'properties'),
    ));
}
add_action('init', 'create_property_post_type');

// Property Category Taxonomy
function create_property_category_taxonomy() {
    $labels = array(
        'name'              => _x('Property Categories', 'taxonomy general name'),
        'singular_name'     => _x('Property Category', 'taxonomy singular name'),
        'search_items'      => __('Search Property Categories'),
        'all_items'         => __('All Property Categories'),
        'parent_item'       => __('Parent Property Category'),
        'parent_item_colon' => __('Parent Property Category:'),
        'edit_item'         => __('Edit Property Category'),
        'update_item'       => __('Update Property Category'),
        'add_new_item'      => __('Add New Property Category'),
        'new_item_name'     => __('New Property Category Name'),
        'menu_name'         => __('Property Categories'),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'property-category'),
    );

    register_taxonomy('property_category', array('property'), $args);
}
add_action('init', 'create_property_category_taxonomy');



// Option Page
if( function_exists('acf_add_options_page') ) {

    acf_add_options_page(array(
        'page_title'    => 'Theme Options',
        'menu_title'    => 'Theme Options',
        'menu_slug'     => 'theme-options',
        'capability'    => 'edit_posts',
        'redirect'      => false
    ));
}



function load_more_properties_with_tabs() {
    $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;
    $category_id = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : 'all';

    $args = array(
        'post_type' => 'property',
        'posts_per_page' => 6,
        'paged' => $paged,
    );

    
    if ($category_id != 'all') {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'property_category',
                'field'    => 'term_id',
                'terms'    => $category_id,
            ),
        );
    }

    $property_query = new WP_Query($args);

    if ($property_query->have_posts()) :
        while ($property_query->have_posts()) : $property_query->the_post(); ?>
            <div class="property-item property-card">
            <div class="card-head">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="property-image">
                                    <?php the_post_thumbnail('full'); ?>
                                </div>
                            <?php endif; ?>
                            <label class="property-active">Active</label>
                        </div>
                        <div class="pro-bottom">
                            <div class="propertyid">
                            <h2><?php the_title(); ?></h2>
                            </div>
                            <div class="property-add">
                    <p><?php the_field('property_add'); ?></p>
                    </div>
                    <div class="property-detail">
                    <p><img src="/e2m/wp-content/uploads/2024/09/bed.png" alt=""><?php the_field('beds'); ?></p>
                    <p><img src="/e2m/wp-content/uploads/2024/09/bath.png" alt=""><?php the_field('bathroom'); ?></p>
                    <p><img src="/e2m/wp-content/uploads/2024/09/sqft.png" alt=""><?php the_field('property_area'); ?></p>
                    </div>
                    <div class="price">
                    <h5 class="amount"><?php the_field('property_price'); ?></h5>      
                    </div>
                        </div>
            </div>
        <?php endwhile;
        
        echo '<div class="max-pages" data-max-pages="' . $property_query->max_num_pages . '"></div>';
        wp_reset_postdata(); 
    else :
        echo '<p>No more properties found.</p>';
    endif;

    wp_die();
}
add_action('wp_ajax_load_more_properties_with_tabs', 'load_more_properties_with_tabs');
add_action('wp_ajax_nopriv_load_more_properties_with_tabs', 'load_more_properties_with_tabs');


function property_with_tabs_and_load_more_shortcode() {
    ob_start();

    // categories tabs
    $categories = get_terms(array(
        'taxonomy' => 'property_category',
        'hide_empty' => true,
    ));
    ?>

    <!-- Tabs -->
    <div class="property-tab-links">
        <a href="#" data-category="all" class="active">All</a>
        <?php foreach ($categories as $category) : ?>
            <a href="#" data-category="<?php echo $category->term_id; ?>"><?php echo $category->name; ?></a>
        <?php endforeach; ?>
    </div>

    <!-- Property content -->
    <div class="property-content">
        <?php
        $args = array(
            'post_type' => 'property',
            'posts_per_page' => 6,
            'paged' => 1,
        );
        $property_query = new WP_Query($args);

        if ($property_query->have_posts()) :
            while ($property_query->have_posts()) : $property_query->the_post(); ?>
                <div class="property-item property-card">
                        <div class="card-head">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="property-image">
                                    <?php the_post_thumbnail('full'); ?>
                                </div>
                            <?php endif; ?>
                            <label class="property-active">Active</label>
                        </div>
                        <div class="pro-bottom">
                            <div class="propertyid">
                            <h2><?php the_title(); ?></h2>
                            </div>
                            <div class="property-add">
                    <p><?php the_field('property_add'); ?></p>
                    </div>
                    <div class="property-detail">
                    <p><img src="/e2m/wp-content/uploads/2024/09/bed.png" alt=""><?php the_field('beds'); ?></p>
                    <p><img src="/e2m/wp-content/uploads/2024/09/bath.png" alt=""><?php the_field('bathroom'); ?></p>
                    <p><img src="/e2m/wp-content/uploads/2024/09/sqft.png" alt=""><?php the_field('property_area'); ?></p>
                    </div>
                    <div class="price">
                    <h5 class="amount"><?php the_field('property_price'); ?></h5>      
                    </div>
                        </div>
                       
                   
                    
                    

                
                    
                   
                </div>
            <?php endwhile;
            wp_reset_postdata(); // Query reset
        else :
            echo '<p>No properties found.</p>';
        endif;
        ?>
    </div>

    <!-- Load More Button -->
     <div class="load-more-button">
     <button id="load-more" data-category="all">Load More</button>
     </div>
    

    <script>
    jQuery(document).ready(function($) {
        var paged = 1;
        var category = 'all'; 
        var maxPages = <?php echo $property_query->max_num_pages; ?>;

       
        if (paged >= maxPages) {
            $('#load-more').hide();
        }

        // Load more properties
        $('#load-more').click(function(e) {
            e.preventDefault();
            paged++; 
            $.ajax({
                type: 'POST',
                url: ajax_var.url, 
                data: {
                    action: 'load_more_properties_with_tabs',
                    paged: paged,
                    category: category
                },
                success: function(response) {
                    $('.property-content').append(response); 
                    maxPages = $(response).filter('.max-pages').data('max-pages'); 
                    if (paged >= maxPages) {
                        $('#load-more').hide(); 
                    }
                }
            });
        });

        
        $('.property-tab-links a').click(function(e) {
            e.preventDefault();
            paged = 1; 
            category = $(this).data('category'); 

           
            $('.property-tab-links a').removeClass('active');
            $(this).addClass('active');

            
            $.ajax({
                type: 'POST',
                url: ajax_var.url, 
                data: {
                    action: 'load_more_properties_with_tabs',
                    paged: paged,
                    category: category
                },
                success: function(response) {
                    $('.property-content').html(response); 
                    $('#load-more').show(); 
                    maxPages = $(response).filter('.max-pages').data('max-pages'); 
                    paged++; 
                    if (paged >= maxPages) {
                        $('#load-more').hide(); 
                    }
                }
            });
        });
    });
    </script>

    <?php
    return ob_get_clean();
}
add_shortcode('property_tabs_load_more', 'property_with_tabs_and_load_more_shortcode');


function enqueue_property_scripts() {
    wp_enqueue_script('jquery'); 
    wp_enqueue_script('property-ajax', get_template_directory_uri() . '/js/property-ajax.js', array('jquery'), null, true);

    wp_localize_script('property-ajax', 'ajax_var', array(
        'url' => admin_url('admin-ajax.php'),
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_property_scripts');









