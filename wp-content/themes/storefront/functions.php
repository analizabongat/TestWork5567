<?php
/**
 * Storefront engine room
 *
 * @package storefront
 */

/**
 * Assign the Storefront version to a var
 */
$theme              = wp_get_theme( 'storefront' );
$storefront_version = $theme['Version'];

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 980; /* pixels */
}

$storefront = (object) array(
	'version'    => $storefront_version,

	/**
	 * Initialize all the things.
	 */
	'main'       => require 'inc/class-storefront.php',
	'customizer' => require 'inc/customizer/class-storefront-customizer.php',
);

require 'inc/storefront-functions.php';
require 'inc/storefront-template-hooks.php';
require 'inc/storefront-template-functions.php';
require 'inc/wordpress-shims.php';

if ( class_exists( 'Jetpack' ) ) {
	$storefront->jetpack = require 'inc/jetpack/class-storefront-jetpack.php';
}

if ( storefront_is_woocommerce_activated() ) {
	$storefront->woocommerce            = require 'inc/woocommerce/class-storefront-woocommerce.php';
	$storefront->woocommerce_customizer = require 'inc/woocommerce/class-storefront-woocommerce-customizer.php';

	require 'inc/woocommerce/class-storefront-woocommerce-adjacent-products.php';

	require 'inc/woocommerce/storefront-woocommerce-template-hooks.php';
	require 'inc/woocommerce/storefront-woocommerce-template-functions.php';
	require 'inc/woocommerce/storefront-woocommerce-functions.php';
}

if ( is_admin() ) {
	$storefront->admin = require 'inc/admin/class-storefront-admin.php';

	require 'inc/admin/class-storefront-plugin-install.php';
}

/**
 * NUX
 * Only load if wp version is 4.7.3 or above because of this issue;
 * https://core.trac.wordpress.org/ticket/39610?cversion=1&cnum_hist=2
 */
if ( version_compare( get_bloginfo( 'version' ), '4.7.3', '>=' ) && ( is_admin() || is_customize_preview() ) ) {
	require 'inc/nux/class-storefront-nux-admin.php';
	require 'inc/nux/class-storefront-nux-guided-tour.php';
	require 'inc/nux/class-storefront-nux-starter-content.php';
}

//register cities post type
function wpp_register_post_type() {

    //label parameters
    $labels = array(
        'name' => __( 'Cities', 'plural', 'wppagebuilders' ),
        'singular_name' => __( 'City', 'singular', 'wppagebuilders' ),
        'add_new' => __( 'New City', 'wppagebuilders' ),
        'add_new_item' => __( 'Add New City', 'wppagebuilders' ),
        'edit_item' => __( 'Edit City', 'wppagebuilders' ),
        'new_item' => __( 'New City', 'wppagebuilders' ),
        'view_item' => __( 'View Cities', 'wppagebuilders' ),
        'search_items' => __( 'Search Cities', 'wppagebuilders' ),
        'not_found' =>  __( 'No Cities Found', 'wppagebuilders' ),
        'not_found_in_trash' => __( 'No Cities found in Trash'),
       ); 
    
       //label parameters
       $args = array(
        'labels' => $labels,
        'has_archive' => true,
        'public' => true,
        'hierarchical' => false,
        'supports' => array(
         'title',
         'editor',
         'excerpt',
         'custom-fields',
         'thumbnail',
         'page-attributes'
        ),
        'taxonomies' => array( 'category' ),
        'rewrite'   => array( 'slug' => 'city' ),
        'show_in_rest' => true
       );
    register_post_type( 'wpp_city', $args );
}
add_action( 'init', 'wpp_register_post_type' );

/*Create Metabox*/
function latitudelongitudefield()
{
    $screen = 'post';
    add_meta_box('latitude','Latitude','displaylatitudeeditor',$screen,'normal','high');
    add_meta_box('longitude','Longitude','displaylongitudeeditor',$screen,'normal','high');
}
add_action( 'add_meta_boxes', 'latitudelongitudefield' ) ;

/*Display PostMeta*/
function displaylatitudeeditor($post)
{
    global $wbdb;
    $metalatitudeeditor = 'latitudeeditor';
    $displayeditortext = get_post_meta( $post->ID,$metalatitudeeditor, true ); 
    echo '<input type="text" name="latitude_text" id="latitude_text" value="'.$displayeditortext.'" />';
}

function displaylongitudeeditor($post)
{
    global $wbdb;
    $metalongitudeeditor = 'longitudeeditor';
    $displayeditortext = get_post_meta( $post->ID,$metalongitudeeditor, true ); 
    echo '<input type="text" name="longitude_text" id="longitude_text" value="'.$displayeditortext.'" />';
}

/*Save Post Meta*/
function saveshorttexteditor($post)
{
    $latitudeeditor = $_POST['latitude_text'];
    update_post_meta(  $post, 'metalatitudeeditor', $latitudeeditor);
    $longitudeeditor = $_POST['longitude_text'];
    update_post_meta(  $post, 'metalongitudeeditor', $$longitudeeditor);
}
add_action('save_post','saveshorttexteditor');

/*taxonomy for countries */
function wporg_register_taxonomy_countries() {
     $labels = array(
         'name'              => _x( 'Countries', 'taxonomy general name' ),
         'singular_name'     => _x( 'Countries', 'taxonomy singular name' ),
         'search_items'      => __( 'Search Countries' ),
         'all_items'         => __( 'All Countries' ),
         'parent_item'       => __( 'Parent Countries' ),
         'parent_item_colon' => __( 'Parent Country:' ),
         'edit_item'         => __( 'Edit Country' ),
         'update_item'       => __( 'Update Country' ),
         'add_new_item'      => __( 'Add New Country' ),
         'new_item_name'     => __( 'New Country Name' ),
         'menu_name'         => __( 'Countries' ),
     );
     $args   = array(
         'hierarchical'      => true,
         'labels'            => $labels,
         'show_ui'           => true,
         'show_admin_column' => true,
         'query_var'         => true,
         'rewrite'           => [ 'slug' => 'country' ],
     );
     register_taxonomy( 'countries', [ 'post' ], $args );
}
add_action( 'init', 'wporg_register_taxonomy_countries' );

// Creating the widget
class wpb_widget_temperature extends WP_Widget {
    function __construct() {
        parent::__construct(
        // Base ID of your widget
            'wpb_widget_temperature',
 
            // Widget name will appear in UI
            __( 'City Temperature', 'textdomain' ),
 
            // Widget description
            [
                'description' => __( 'Widget to get temperature of the city', 'textdomain' ),
            ]
        );
    }
 
    // Creating widget front-end
    public function widget( $args, $instance ) {
        $city = apply_filters( 'widget_city', $instance['city'] );
 
        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        if ( ! empty( $city ) ) {
            echo $args['before_city'] . $city . $args['after_city'];
        }
 
        // This is where you run the code and display the output
        
        query_posts(array('post_status' => 'publish'));
        while(have_posts()) {
            $post_title = get_the_title();
            $post_id = get_the_ID();

            if($post_title == $city){
                $latitude = get_post_meta($post_id, 'latitude', true);
                $longitude = get_post_meta($post_id, 'longitude', true);
            }

            if(empty($latitude)) $latitude = '12.879721';
            if(empty($longitude)) $longitude = '121.774017';
            $url = 'https://api.open-meteo.com/v1/forecast?latitude='.$latitude.'&longitude='.$longitude.'&hourly=temperature_2m';  
            $result = wp_remote_get( $url);

            if(!empty($result)){
                $resultarray = json_decode($result,true);
                $currrenttime = date("H");
                if(!empty($resultarray['hourly']['time'])){
                    foreach($resultarray['hourly']['time'] as $k => $time){
                        $xtime = explode('T',$time);
                        $hour = explode(':',$xtime[1]);

                        if($hour == $currrenttime){
                            echo $resultarray['hourly']['temperature'][$k];
                        }
                    }
                }                
            }

            break;
        }

    }
 
    // Widget Settings Form
    public function form( $instance ) {
        if ( isset( $instance['city'] ) ) {
            $city = $instance['city'];
        } else {
            $city = __( 'New city', 'textdomain' );
        }
 
        // Widget admin form
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'city' ); ?>">
                <?php _e( 'City:', 'textdomain' ); ?>
            </label>
            <input
                    class="widefat" id="<?php echo $this->get_field_id( 'city' ); ?>"
                    name="<?php echo $this->get_field_name( 'city' ); ?>"
                    type="text"
                    value="<?php echo esc_attr( $city ); ?>"
            />
        </p>
        <?php
    }
 
    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance          = array();
        $instance['city'] = ( ! empty( $new_instance['city'] ) ) ? strip_tags( $new_instance['city'] ) : '';
 
        return $instance;
    }
 
    // Class wpb_widget ends here
}
 
// Register and load the widget
function wpb_load_widget() {
    register_widget( 'wpb_widget_temperature' );
}
 
add_action( 'widgets_init', 'wpb_load_widget' );

add_action( 'wporg_before_settings_page_html', 'before_table_html' );
add_action( 'wporg_after_settings_page_html', 'after_table_html' );

function before_table_html(){
    echo '<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			';
}

function after_table_html(){
    echo '</main><!-- #main -->
	</div><!-- #primary -->
<?php';
}

add_action( 'wp_ajax_countriescitiestable', 'my_ajax_countriescitiestable_handler' );

function my_ajax_countriescitiestable_handler() {
    global $wpdb;
    $posts = $wpdb->wp_posts; 

    $addwhere = '';
    $search = trim($_POST['search']);
    if(!empty($search)) $addwhere = "and post_title like '%".$_POST['search']."%'";
    $result = $wpdb->get_results(" SELECT * FROM $posts WHERE 'post_type' = 'Cities' and post_status = 'publish' ".$addwhere);
    
    foreach ( $result as $post )
    {
        $html = '';
        $post_city = $post->post_title;
        $post_id = $post->ID;
        $post_country = wp_get_object_terms( $post_id, 'Countries', [] );

        if($post_city == $city){
            $latitude = get_post_meta($post_id, 'latitude', true);
            $longitude = get_post_meta($post_id, 'longitude', true);
        }

        if(empty($latitude)) $latitude = '12.879721';
        if(empty($longitude)) $longitude = '121.774017';
        $url = 'https://api.open-meteo.com/v1/forecast?latitude='.$latitude.'&longitude='.$longitude.'&hourly=temperature_2m';  
        $result = wp_remote_get( $url);

        if(!empty($result)){
            $resultarray = json_decode($result,true);
            $currrenttime = date("H");
            if(!empty($resultarray['hourly']['time'])){
                foreach($resultarray['hourly']['time'] as $k => $time){
                    $xtime = explode('T',$time);
                    $hour = explode(':',$xtime[1]);
                    $post_temperature = 0;
                    if($hour == $currrenttime){
                        $post_temperature = $resultarray['hourly']['temperature'][$k];
                    }
                }
            }                
        }

        $html += '<tr>
            <td>'.$post_country.'</td>
            <td>'.$post_city.'</td>
            <td>'.$post_temperature.'</td>
        </tr>';
    }

    $html = '<p><input type="text" name="search" id="search" /></p>
    <table width="100%">
        <tr>
            <th>Country</th>
            <th>City</th>
            <th>Temperature</th>
        </tr>'.$html.'</html>';
    echo $html;
    wp_die();
}