<?php
/* •••••••••••••••••••••••••••••••••••••••••••••••••••••••
 *  Author: Web-Medias - Sébastien Brémond | @web-medias
 *  URL: web-medias.com | @web-medias
 *  Custom functions, support, custom post types and more.
 */




/* ∙∙∙∙∙∙∙∙∙∙∙∙∙∙∙∙∙∙∙∙∙∙∙∙∙∙∙∙∙∙∙∙∙∙∙∙∙∙∙∙∙∙∙∙∙∙∙∙∙∙∙∙∙∙∙
 *  
 *  External Modules/Files
 *  
 */

    /**
     * Load any external files you have here
     * 
     * Displays an admin menu
     *
     * @package WordPress
     * @subpackage Fruity Ocean
     * @since Fruity Ocean 1.0
     */

    require "my-dashboard-panel.php";





/* ••••••••••••••••••••••••••••••••••••••••••••••••••••••••
 *  
 *  Theme Support
 *  
 */

    /**
     * Add Theme fonctionalities and supports built'in
     * 
     * Theme support
     *
     * @package WordPress
     * @subpackage Fruity Ocean
     * @since Fruity Ocean 1.0
     */

    if (function_exists('add_theme_support'))
    {
        /**
         * Localisation support
         * 
         * Allows theme to support localisation and translation
         * - See : https://docs.woothemes.com/document/third-party-custom-theme-compatibility/
         * 
         * @package WordPress
         * @subpackage Fruity Ocean
         * @since Fruity Ocean 1.0
         */
        load_theme_textdomain('fruity-ocean', get_template_directory() . '/languages');


        // Add Menu Support
    //    add_theme_support('menus');

        // Add Thumbnail Theme Support
        add_theme_support('post-thumbnails');
        // -See : http://wpshout.com/adding-using-custom-image-sizes-wordpress-guide-best-thing-ever/
        add_image_size('thumb-vertical', 150, 250, true); // Custom Thumbnail Size call using the_post_thumbnail('thumb-vertical');
        add_image_size('thumb-horizontal', 250, 150, true); // Custom Thumbnail Size call using the_post_thumbnail('thumb-horizontal');
        
        add_image_size('thumb-partner', 204, 191, true); // Custom Thumbnail Size call using the_post_thumbnail('thumb-partner');

        function my_custom_sizes( $sizes ) {
            return array_merge( $sizes, array(
                'thumb-vertical' => __( 'Vertical Thumbnail' , 'fruity-ocean' ),
                'thumb-horizontal' => __( 'Horizontal Thumbnail' , 'fruity-ocean' ),
                'thumb-partner' => __( 'Partner Thumbnail' , 'fruity-ocean' )
            ) );
        }
        add_filter( 'image_size_names_choose', 'my_custom_sizes' );

        // Add Support for Custom Backgrounds - Uncomment below if you're going to use
        /*add_theme_support('custom-background', array(
            'default-color' => 'FFF',
            'default-image' => get_template_directory_uri() . '/img/bg.jpg'
        ));*/

        // Add Support for Custom Header - Uncomment below if you're going to use
        /*add_theme_support('custom-header', array(
            'default-image'         => get_template_directory_uri() . '/img/headers/default.jpg',
            'header-text'           => false,
            'default-text-color'        => '000',
            'width'             => 1000,
            'height'            => 198,
            'random-default'        => false,
            'wp-head-callback'      => $wphead_cb,
            'admin-head-callback'       => $adminhead_cb,
            'admin-preview-callback'    => $adminpreview_cb
        ));*/

        // Enables post and comment RSS feed links to head
        add_theme_support('automatic-feed-links');


        remove_filter('the_excerpt', 'wpautop');


        /**
         * WooCommerce support
         * 
         * Allows theme to support WooCommerce
         * - See : https://docs.woothemes.com/document/third-party-custom-theme-compatibility/
         * 
         * @package WordPress
         * @subpackage Fruity Ocean
         * @since Fruity Ocean 1.0
         */
        function woocommerce_support() {
            add_theme_support( 'woocommerce' );
        }
        add_action( 'after_setup_theme', 'woocommerce_support' );


        /**
         * Admin Front-end support
         * 
         * Allows to hide the admin bar for all users except admins
         * 
         * @package WordPress
         * @subpackage Fruity Ocean
         * @since Fruity Ocean 1.0
         */
        function remove_admin_bar() {
            if (!current_user_can('administrator') && !is_admin()) {
              show_admin_bar(false);
            }
        }
        add_action('after_setup_theme', 'remove_admin_bar');

        function wpse29210_admin_bar_toogle(){
            add_filter( 'show_admin_bar', '__return_false' );

            $user = get_userdata( $GLOBALS['current_user'] )->data->ID;

            if ( ! is_admin() && $user->show_admin_bar_front )
                add_filter( 'show_admin_bar', '__return_false' );

            if ( is_admin() && $user->show_admin_bar_admin )
                add_filter( 'show_admin_bar', '__return_true' );

            return;
        }
    //    add_action( 'init', 'wpse29210_admin_bar_toogle' );
    };
    /* /Theme support */





/* ••••••••••••••••••••••••••••••••••••••••••••••••••••••••
 *  
 *  Site security
 *  
 */

    /**
     * Add a security level to the website
     * 
     * Security
     *
     * @package WordPress
     * @subpackage Fruity Ocean
     * @since Fruity Ocean 1.0
     */

    if (true){
        function embed_security_level_user_connect(){
            
            if ( is_user_logged_in() ) {
                // Nothing to do
            } else {
                // Visitor must be log in
                $args = array(
                    'echo'           => true,
                    'redirect' => ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
                    'form_id'        => 'loginform',
                    'label_username' => __( 'Username' , 'fruity-ocean' ),
                    'label_password' => __( 'Password' , 'fruity-ocean' ),
                    'label_remember' => __( 'Remember Me' , 'fruity-ocean' ),
                    'label_log_in'   => __( 'Log In' , 'fruity-ocean' ),
                    'id_username'    => 'user_login',
                    'id_password'    => 'user_pass',
                    'id_remember'    => 'rememberme',
                    'id_submit'      => 'wp-submit',
                    'remember'       => true,
                    'value_username' => '',
                    'value_remember' => false
                );
              wp_login_form( $args );
            }

        }
        //add_action( 'init', 'embed_security_level_user_connect' );
    };
    /* /Add security level */






/* ••••••••••••••••••••••••••••••••••••••••••••••••••••••••
 *  
 *  Theme Widgets
 *  
 */

    /**
     * Add site panels
     * 
     * Theme Widgets
     *
     * @package WordPress
     * @subpackage Fruity Ocean
     * @since Fruity Ocean 1.0
     */

    if (function_exists('register_sidebar')){


        /**
         * Site Panel : Search Form
         * 
         * Displays the search form
         *
         * @package WordPress
         * @subpackage Fruity Ocean
         * @since Fruity Ocean 1.0
         */
        register_sidebar(array(
                'id' => 'sidebar_panel_search_form',
                'name'=>'Sidebar',
                'description' => 'Panel « Search Form »',
                'before_widget' => '<div>',
                'after_widget' => '</div>',
                'before_title' => '<h3>',
                'after_title' => '</h3>',
        ));



        /**
         * Site Panel : Menu banner - [navigation]
         * 
         * Displays the navigation menu
         *
         * @package WordPress
         * @subpackage Fruity Ocean
         * @since Fruity Ocean 1.0
         */
        register_sidebar( array(
                'name' => 'bd-sous-header',
                'id' => 'bd-sous-header',
                'description' => 'Panel « Menu banner » [navigation]',
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget' => '</aside>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
        ) );



        /**
         * Site Panel : Showcase - [home slider]
         * 
         * Displays an horizontal panel showing the home slider (showcase)
         *
         * @package WordPress
         * @subpackage Fruity Ocean
         * @since Fruity Ocean 1.0
         */
        register_sidebar( array(
                'name' => 'slider-header',
                'id' => 'slider-header',
                'description' => 'Panel « Showcase » [home slider]',
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget' => '</aside>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
        ) );



        /**
         * Site Panel : Showcase - [media gallery slider]
         * 
         * Displays an horizontal panel showing the medias gallery slider (showcase)
         *
         * Each click on a thumbnail, get the slide a.href attrib and call an Ajax Request.
         * See Ajax Request handler in AJAX Section...
         *
         * @package WordPress
         * @subpackage Fruity Ocean
         * @since Fruity Ocean 1.0
         */
        register_sidebar( array(
                'name' => 'slider-medias-gallery',
                'id' => 'slider-medias-gallery',
                'description' => 'Panel « Showcase » [medias gallery slider]',
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget' => '</aside>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
        ) );



        /**
         * Site Panel : Discover Caribaea Initiative
         * 
         * Displays an horizontal panel showing three circle tags
         *
         * @package WordPress
         * @subpackage Fruity Ocean
         * @since Fruity Ocean 1.0
         */
        register_sidebar( array(
                'name' => 'panel-discover-caribaea',
                'id' => 'panel-discover-caribaea',
                'description' => 'Panel « Discover Caribaea Initiative »',
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget' => '</aside>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
        ) );



        /**
         * Site Panel : Language selector
         * 
         * Displays the lang widget selector
         *
         * @package WordPress
         * @subpackage Fruity Ocean
         * @since Fruity Ocean 1.0
         */
        register_sidebar( array(
                'name' => 'panel-language-selector',
                'id' => 'panel-language-selector',
                'description' => 'Panel «  Language selector »',
                'before_widget' => '<aside id="%1$s" class="langbar widget %2$s">',
                'after_widget' => '</aside>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
        ) );



        /**
         * Site Panel : Search Bar
         * 
         * Displays the search form widget
         *
         * @package WordPress
         * @subpackage Fruity Ocean
         * @since Fruity Ocean 1.0
         */
        register_sidebar( array(
                'name' => 'panel-search-bar',
                'id' => 'panel-search-bar',
                'description' => 'Panel «  Search Bar »',
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget' => '</aside>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
        ) );




        /**
         * Dynamic widget placeholder : Handmade menus
         * 
         * Displays a list of widgets placeholders
         *
         * @package WordPress
         * @subpackage Fruity Ocean
         * @since Fruity Ocean 1.0
         */
    /*
        $handmade_menus = array( 
            array(
                'id' => 'azerty',
                'name' => 'azerty',
                'description' => '{label}'
            ),
            array(
                'id' => 'poiuyt',
                'name' => 'poiuyt',
                'description' => '{label}'
            ),
            array(
                'id' => 'volmanox',
                'name' => 'volmanox',
                'description' => '{label}'
            )
        );

        foreach($handmade_menus as $handmade_menu)
        {

            register_sidebar( array(
                    'name' => 'handmade-menu-'.$handmade_menu['name'],
                    'id' => 'handmade-menu-'.$handmade_menu['id'],
                    'description' => 'Handmade Panel Menu « '.$handmade_menu['description'].' »',
                    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                    'after_widget' => '</aside>',
                    'before_title' => '<h3 class="widget-title">',
                    'after_title' => '</h3>',
            ) );
        }

    /**/

    };
    /* /Add site panels <register_sidebar> */






/* ••••••••••••••••••••••••••••••••••••••••••••••••••••••••
 *  
 *  Theme CMS Editing
 *  
 */

    /**
     * Internal CMS Editor
     * 
     * Manage option of WordPress editor
     *
     * @package WordPress
     * @subpackage Fruity Ocean
     * @since Fruity Ocean 1.0
     */

        /**
         * WordPress Internal : Excerpt
         * 
         * Add the excerpt support to page
         *
         * @package WordPress
         * @subpackage Fruity Ocean
         * @since Fruity Ocean 1.0
         */

        function my_add_excerpts_to_pages() {
            add_post_type_support( 'page', 'excerpt' );
        }
        add_action( 'init', 'my_add_excerpts_to_pages' );

    /* /Internal CMS Editor */





/* ••••••••••••••••••••••••••••••••••••••••••••••••••••••••
 *  
 *  Theme Shortcodes
 *  
 */

    /**
     * Add Shortcode
     * 
     * Theme Shortcode
     *
     * @package WordPress
     * @subpackage Fruity Ocean
     * @since Fruity Ocean 1.0
     */

    if (function_exists('add_shortcode')){


        /**
         * Shortcode : Content 
         * 
         * Add shortcode to respond on news content
         *
         * @package WordPress
         * @subpackage Fruity Ocean
         * @since Fruity Ocean 1.0
         */

        /**
        * « Actu/News » | Generate content 
        */
        function category_shortcode( $atts )
        {
            extract(shortcode_atts(array(
                'limit' => '5',
                'category' => '',
            ), $atts));
            //The Query
            query_posts('category=' . $id . 'posts_per_page=' . $limit);
            //The Loop
            if ( have_posts() ) : while ( have_posts() ) : the_post();
                echo    '<h3><a href="'; echo the_permalink(); echo '">'; echo the_title(); echo '</a></h3>';
                echo the_excerpt();
            endwhile; else:
            endif;

            //Reset Query
            wp_reset_query();
        }
        //add_shortcode('category', 'category_shortcode');


    };
    /* /Add Shortcode */









/* ••••••••••••••••••••••••••••••••••••••••••••••••••••••••
 *  
 *  WooCommerce
 *  
 */

    /**
     * Add Filtering
     * 
     * Woocommerce Redidrect and flitering
     *
     * @package WordPress
     * @subpackage Fruity Ocean
     * @since Fruity Ocean 1.0
     */

    if (function_exists('woocommerce_add_to_cart_redirect')){


        /**
         * WooCommerce Payment page tunneling
         * 
         * Short-circuiting Cart page to direct checkout
         * - See details : http://www.remicorson.com/woocommerce-skip-product-cart-pages/
         *
         * @package WordPress
         * @subpackage Fruity Ocean
         * @since Fruity Ocean 1.0
         */
        /*
        function woo_redirect_to_checkout() {
            $checkout_url = WC()->cart->get_checkout_url();
            return $checkout_url;
        }/**/

        //add_filter ('woocommerce_add_to_cart_redirect', 'woo_redirect_to_checkout');
        // (Unused ! Replaced by a WP Plugin : WooCommerce Direct Checkout by Terry Tsang)

    }
    /* /Add Filtering */



    /**
     * Add Filtering
     * 
     * Woocommerce Add to cart button changing
     * Change the add to cart text on single product pages when a product is already in cart !
     * 
     * @package WordPress
     * @subpackage Fruity Ocean
     * @since Fruity Ocean 1.0
     */
    function woo_custom_cart_button_text() {

      global $woocommerce;
        
        foreach($woocommerce->cart->get_cart() as $cart_item_key => $values ) {
            $_product = $values['data'];
        
            if( get_the_ID() == $_product->id ) {
                return __('Already in cart - Add Again?', 'woocommerce');
            }
        }
        
        return __('Add to cart', 'woocommerce');

    }
    //add_filter('single_add_to_cart_text', 'woo_custom_cart_button_text');



    /**
     * WooCommerce Checkout Fields Hook
     * 
     * Change order comments placeholder and label, and set billing phone number to not required.
     * - https://surpriseazwebservices.com/edit-woocommerce-checkout-fields/
     * 
     * @package WordPress
     * @subpackage Fruity Ocean
     * @since Fruity Ocean 1.0
     */
    function custom_wc_checkout_fields( $fields ) {

    //    $fields['order']['order_comments']['label'] = 'Enter your label here.';
        $fields['order']['order_comments']['placeholder'] = __('Ecrivez votre commentaire ici.', 'woocommerce');

        $fields['billing']['billing_company']['label'] = __('Organisation', 'woocommerce');
        $fields['shipping']['shipping_company']['label'] = __('Organisation', 'woocommerce');

        $fields['billing']['billing_phone']['required'] = false;

        return $fields;
    }
    add_filter( 'woocommerce_checkout_fields' , 'custom_wc_checkout_fields' );



    /**
     * WooCommerce Default Address Fields Hook
     * 
     * Change the WooCommerce default address fields... Used in the woocommerce account order editing. (includes/class-wc-countries.php)
     * - https://surpriseazwebservices.com/edit-woocommerce-checkout-fields/
     * 
     * @package WordPress/WooCommerce
     * @subpackage Fruity Ocean
     * @since Fruity Ocean 1.0
     * @author Sébastien Brémond | Web-Medias.com
     */
    function custom_wc_default_address_fields( $fields ) {

        // Change Company Name for Organisation
        $fields['company']['label'] = __('Organisation', 'woocommerce');

        // Force to enter an organisation
        $fields['company']['required'] = false;

        return $fields;
    }
    add_filter( 'woocommerce_default_address_fields' , 'custom_wc_default_address_fields' );






    /**
     * Adding custom checkout fields
     * 
     * Add into woocommerce somme custom checkout fields
     * - See details : http://www.portmanteaudesigns.com/blog/2015/02/04/woocommerce-custom-checkout-fields-email-backend/
     *
     * @package WordPress
     * @subpackage Fruity Ocean
     * @since Fruity Ocean 1.0
     */

    /**
     * @param [Password field section]
     */


    /**
     * @param [Membership card validity field section]
     */
    $use__wc_custom_field__validity = true;

        /**
         * WooCommerce Checkout : Add the field to the checkout
         * 
         * Add the field to the checkout
         *
         * @package WordPress
         * @subpackage Fruity Ocean
         * @since Fruity Ocean 1.0
         */
        /*
        function my_custom_checkout_field( $checkout ) {
           
           // In case if the user is not logged in, we must to write out a field where enter his desired password !
           if ( ! is_user_logged_in() ) {

               echo '<div class="my_custom_checkout_field" style="margin-top:2em;">';
               echo '<h3>' . __('Your account', 'woocommerce') .'</h3>';

               echo '<p class="form-row form-row form-row-wide" id="user_account_profile_note_field">';
               echo '<em>' . __('This password will be used to create and secure your membership account and log in the next time you visit our website.', 'woocommerce') . '</em>';
               echo '</p>';

                woocommerce_form_field( 'user_account_profile_password', array(
                    'type' => 'password',
                    'label'      => __('Password', 'woocommerce'),
                    'placeholder'   => _x('Your desired password that will be used with the email address to login', 'placeholder', 'woocommerce'),
                    'required'   => true,
                    'class'      => array('form-row-wide'),
                    'clear'     => true,
                ), $checkout->get_value( 'user_account_profile_password' ));

               echo '</div>';

            }

        }
        //add_action( 'woocommerce_after_order_notes', 'my_custom_checkout_field' );
        /**/

        function twm__wc_custom_checkout_validity_field( $checkout ) {

            if( wc_is_cart_contains_typeof('subscribing') ){

                echo '<div class="twm__wc_custom_checkout_field" style="margin-top:2em;">';

                    echo '<style type="text/css">';
                    echo '.woocommerce form .twm__wc_custom_checkout_field input[type="radio"]{ margin: 0 1em 0 0; display: inline-block; float: left; min-height: 2em; line-height: 2; }';
                    echo '.woocommerce form .twm__wc_custom_checkout_field label.radio.radio-box{ display: block; }';
                    echo '.woocommerce form .twm__wc_custom_checkout_field label.radio.radio-box:after{ clear: both; content: " "; display: table; }';
                    echo '</style>';

                    echo '<h3>' . __('Carte de membre', 'fruity-ocean') .'</h3>';

                    echo '<p class="form-row form-row form-row-wide">';

                        woocommerce_form_field( 'member_card_validity', array(
                            'type'              => 'radio',
                            'class'             => array('form-row-wide radio_member_card_validity'),
                            'label'             => __('Merci de sélectionner l’année de validité de votre adhésion :','fruity-ocean'),
                            'label_class'       => 'radio-box',
                            'options'           => array( date('Y') => sprintf( __('J’adhère pour l’année en cours : [%s]','fruity-ocean') , date('Y') ) , date('Y', strtotime('+1 years')) => sprintf( __('J’adhère pour l’année suivante : [%s]','fruity-ocean') , date('Y', strtotime('+1 years')) )  ),
                            'required'          => true,
                        ), $checkout->get_value( 'member_card_validity' ));

                    echo '</p>';
                echo '</div>';

            }

        }
        add_action( 'woocommerce_after_order_notes', 'twm__wc_custom_checkout_validity_field' );



        /**
         * WooCommerce Checkout : Process the checkout
         * 
         * Process the checkout
         *
         * @package WordPress
         * @subpackage Fruity Ocean
         * @since Fruity Ocean 1.0
         */
        /*
        function my_custom_checkout_field_process() {

            // In case if the user is not logged in, we must to write out a field where enter his desired password !
            if ( ! is_user_logged_in() ) {
            
                if ( ! $_POST['user_account_profile_password'] )
                    wc_add_notice( __( 'Please enter a valid password related to your login', 'woocommerce' ) , 'error' );

            }

        }
        //add_action('woocommerce_checkout_process', 'my_custom_checkout_field_process');
        /**/

        function twm__wc_custom_checkout_validity_field_process() {

            // TODO : check only if - wc_is_cart_contains_typeof('subscribing') - is TRUE !
            if( wc_is_cart_contains_typeof('subscribing') ){


                // In case of the validity year was not selected
                if ( empty( $_POST['member_card_validity'] ) ) {
                    
                    wc_add_notice( __( 'Merci de sélectionner l’année de validité de votre adhésion avant de finaliser la commande.', 'fruity-ocean' ) , 'error' );

                }
                // Otherwize, check oldest orders and scan them to find an existing registration !
                else{ 


                    // Check if the user have also a membership card for this year in oldest orders !
                    if ( is_user_logged_in() ) {

                        
                        // Retreive the current user logged in, and get its email account address ! 
                        $tmp_current_user = wp_get_current_user();
                        $user_roles = get_userdata( $tmp_current_user->ID )->roles;


                        /*
                        // Just to get some extra info, used to extend or debug trace
                        $is_customer = ( in_array('customer', $user_roles) )? true : false;
                        $is_powered  = ( in_array('administrator', $user_roles) || in_array('shop_manager', $user_roles))? true : false;
                        $is_validon  = ( get_the_author_meta( 'valid_customer_enabled', $tmp_current_user->ID ) == '1' )? true : false;
                        /**/


                        // Fetch all orders for this customer
                        $customer_orders = get_posts( array(
                            'meta_key'    => '_customer_user',
                            'meta_value'  => $tmp_current_user->ID,
                            'post_type'   => wc_get_order_types(),
                            'post_status' => ('wc-completed'), /* array_keys( wc_get_order_statuses() ),/**/
                            'numberposts' => -1
                        ) );



                        $order_history_membering = array(); // Store an history of the subscribe sequence (date, member card type evolution).

                        foreach($customer_orders as $k => $v)
                        {
                            $order_id = $customer_orders[ $k ]->ID;

                            $order = new WC_Order( $order_id );
                            $order_date = $order->order_date;
                            $validity = null;
                            

                            $items = $order->get_items();
                            
                            foreach ( $items as $item ) {
                                $product_name = $item['name'];
                                $product_id = $item['product_id'];
                                //$product_variation_id = $item['variation_id'];


                                // Check if a product is a {membership card} !
                                // In fact, if the user buy a membership card, this product will be payed and we can consider the user as a member.
                                // [subscribing] -> categorie of membership products
                                $product_cats = wp_get_post_terms( $product_id, 'product_cat' );
                                $categories = array();
                                foreach($product_cats as $cat => $term){
                                    $categories[] = $term->slug;
                                }
                                if( in_array('subscribing' , array_values($categories) ) ){
                                    // This order have a « Subscribing Member Card » product
                                    $order_history_membering['_'.strtotime($order_date)] = array( 
                                        'type'=>$product_name, 
                                        'validity'=>'----'
                                    );
                                    
                                    // Retreive the stored validity date or the order year
                                    if ( ! get_post_meta( $order->id, 'member_card_validity', true ) ) {
                                        $validity = date('Y', strtotime($order_date)) ; // Default value of the membership validity date.
                                    }else{
                                        $validity = get_post_meta( $order->id, 'member_card_validity', true ); // Otherwise, the stored year (from checkout process).
                                    }
                                    
                                    $order_history_membering['_'.strtotime($order_date)]['validity'] = $validity;

                                }

                            }
                            
                        }   

                        // Ordering properly the list.
                        ksort($order_history_membering);

                        $asked_validity = intval( $_POST['member_card_validity'] );

                        // Search if a membership card validity already exists for the same asked validity...
                        foreach($order_history_membering as $k => $card){
                            //$date = str_replace('_', '', $k);
                            
                            if( intval( $card['validity']) === $asked_validity ){
                                
                                wc_add_notice( sprintf( __('Oups!<br />Vous avez déjà une carte de membre adhérent pour l’année [%s].<br />Merci de vérifier l’année de validité sélectionnée avant d’ajouter votre nouvelle carte dans le panier.<br />Pour toute assistance, merci de nous contacter par email.', 'fruity-ocean') , 
                                                        '<strong style="color:#cc6600;">'. $card['validity'] .'</strong>'
                                                ) , 'error' );

                            }
                        }


                    }


                } // End process checkout validity.



            }// End if Cart contains

            /*
            // ★ Maintenance ★
            wc_add_notice( '<p>Sorry, but the order finalization system is being maintained for now.<br />Please proceed a little later ...</p>' , 'error' );
            wc_add_notice( '<p>Désolé, mais le système de finalisation des commandes est en cours de maintenace pour l\'instant.<br />Merci de procéder un peu plus tard...</p>' , 'error' );
            /**/

        }
        add_action('woocommerce_checkout_process', 'twm__wc_custom_checkout_validity_field_process');




        /**
         * WooCommerce Checkout : Update the order meta with field value
         * 
         * Update the order meta with field value
         *
         * @package WordPress
         * @subpackage Fruity Ocean
         * @since Fruity Ocean 1.0
         */
        /*
        function my_custom_checkout_field_update_order_meta( $order_id ) {

           // In case if the user is not logged in, we must to write out a field where enter his desired password !
           if ( ! is_user_logged_in() ) {
            
               if ( ! empty( $_POST['user_account_profile_password'] ) ) {
                   update_post_meta( $order_id, 'user_account_profile_password', $_POST['user_account_profile_password'] );
               }

            }

        }
        //add_action('woocommerce_checkout_update_order_meta', 'my_custom_checkout_field_update_order_meta' );
        /**/

        function twm__wc_custom_checkout_validity_field_update_order_meta( $order_id ) {

            // Memeber card validity exists only if the user have in its cart a type of product
            if( wc_is_cart_contains_typeof('subscribing') ){

                if ( ! empty( $_POST['member_card_validity'] ) ) {
                    update_post_meta( $order_id, 'member_card_validity', $_POST['member_card_validity'] );
                }

            }

        }
        add_action('woocommerce_checkout_update_order_meta', 'twm__wc_custom_checkout_validity_field_update_order_meta' );




        /**
         * WooCommerce Checkout : Display field value on the order edit page
         * 
         * Display field value on the order edit page
         *
         * @package WordPress
         * @subpackage Fruity Ocean
         * @since Fruity Ocean 1.0
         */
        /*
        function my_custom_checkout_field_display_admin_order_meta($order){
          
            // In case if the user is not logged in, we must to write out a field where enter his desired password !
            if ( ! is_user_logged_in() ) {
            
                echo '<p><strong>'.__('Your password', 'woocommerce').': </strong> ' . get_post_meta( $order->id, 'user_account_profile_password', true ) . '</p>';
            }

        }
        //add_action('woocommerce_admin_order_data_after_billing_address', 'my_custom_checkout_field_display_admin_order_meta', 10, 1 );
        /**/

        function twm__wc_custom_checkout_validity_field_display_admin_order_meta($order){
          
            // Fields into the WP Admin UI Orders
            echo '<p><strong><span class="dashicons-before dashicons-id" style="color:#0688A2;"></span> '.__('Membership card validity', 'woocommerce').': </strong> ' . get_post_meta( $order->id, 'member_card_validity', true ) . '</p>';

        }
        add_action('woocommerce_admin_order_data_after_billing_address', 'twm__wc_custom_checkout_validity_field_display_admin_order_meta', 10, 1 );




        /**
         * WooCommerce Checkout : Display field value on the order email
         * 
         * Display field value on the order email
         *
         * @package WordPress
         * @subpackage Fruity Ocean
         * @since Fruity Ocean 1.0
         */
        /*
        function my_custom_checkout_field_order_meta_keys( $keys ) {
            
            // In case if the user is not logged in, we must to write out a field where enter his desired password !
            if ( ! is_user_logged_in() ) {
            
                $keys[] = 'user_account_profile_password';
                return $keys;
            
            }
                    
        }
        //add_filter('woocommerce_email_order_meta_keys', 'my_custom_checkout_field_order_meta_keys');
        /**/

        function twm__wc_custom_checkout_validity_field_order_meta_keys( $keys ) {
                       
                $keys[] = 'member_card_validity';
                return $keys;
                    
        }
        add_filter('woocommerce_email_order_meta_keys', 'twm__wc_custom_checkout_validity_field_order_meta_keys');


    /* /Adding custom checkout fields */










    /**
     * Hook Cart validation.
     * 
     * Check and control add to cart to never have more than one element « subscribing » card !
     *
     * @package WordPress
     * @subpackage Fruity Ocean
     * @since Fruity Ocean 1.0
     */

        /**
         * WooCommerce Add to cart Validation | define the woocommerce_add_to_cart_validation callback 
         * 
         * Custom action
         *
         * @package WordPress
         * @subpackage Fruity Ocean
         * @since Fruity Ocean 1.0
         */
        function filter_woocommerce_add_to_cart_validation( $true, $product_id, $quantity, $variation_id = '', $variations= '' ) { 

            global $woocommerce;
            $items = $woocommerce->cart->get_cart();

            // Get category of this product.
            $product_cats = wp_get_post_terms( $product_id, 'product_cat' );
            $categories = array();
            foreach($product_cats as $cat => $term){
                $categories[] = $term->slug;
            }
            
            //Ensure that the product is a valid product to control (Category « Subscribing ») !
            $is_controlled_product = false;
            if( in_array('subscribing' , array_values($categories) ) ){
                $is_controlled_product = true;
            }
             

            // Check if a product with te same cat already exists in the cart...
            $have_already_product_same_category = false;
            foreach($woocommerce->cart->get_cart() as $cart_item_key => $values ) {
                $_product = $values['data'];
            
                // Check if a product is a {membership card} !
                // In fact, if the user buy a membership card, this product will be payed and we can consider the user as a member.
                // [subscribing] -> categorie of membership products
                $product_cats = wp_get_post_terms( $_product->id, 'product_cat' );
                $categories = array();
                foreach($product_cats as $cat => $term){
                    $categories[] = $term->slug;
                }
                if( in_array('subscribing' , array_values($categories) ) ){
                    $have_already_product_same_category = true;
                }

            }


            // Verify if the product to add and if the cart contains a product having the same category, otherwize let's add the product to cart !
            if( $have_already_product_same_category && $is_controlled_product ){

                // Notice
                wc_add_notice( __( 'You can not do that', 'fruity-ocean' ), 'error' );
                $true = false;

            }

            // Return yes or no !
            return $true; 
        }; 
        // WooCommerce Cart Validation hook filter
        add_filter( 'woocommerce_add_to_cart_validation', 'filter_woocommerce_add_to_cart_validation', 10, 3 ); 



/*
    // define the woocommerce_update_cart_action_cart_updated callback 
    function filter_woocommerce_update_cart_action_cart_updated( $cart_updated ) { 


        global $woocommerce;
        $items = $woocommerce->cart->get_cart();

        // Ensure for each product in the cart that its quantity is only one item for product having a specific term (category)
        foreach($items as $item => $values) { 

            $_product = $values['data']->post; 
            $_product_id = $values['product_id'];
            $_product_qty = $values['quantity'];


            $product_cats = wp_get_post_terms( $_product->id, 'product_cat' );
            $categories = array();
            foreach($product_cats as $cat => $term){
                $categories[] = $term->slug;
            }
            if( in_array('subscribing' , array_values($categories) ) ){
                // nothing now !
            }
        }
     

        if( ! $cart_updated ){
        //    wc_add_notice( __( 'You can not have more than one « Subscribing Card » !'. '#'.$_product_id.' &times; '.$_product_qty, 'textdomain' ), 'error' );
        }



        return $cart_updated; 
    }; 
    // add the filter 
    //add_filter( 'woocommerce_update_cart_action_cart_updated', 'filter_woocommerce_update_cart_action_cart_updated', 10, 1 ); 
/**/



    // define the woocommerce_check_cart_items callback 
    function action_woocommerce_check_cart_items(  ) { 

        global $woocommerce;

        foreach ( WC()->cart->get_cart() as $cart_item_key => $values ) {
            $_product = get_product( $values['product_id'] );
            $_product_qty = $values['quantity'];


            $product_cats = wp_get_post_terms( $_product->id, 'product_cat' );
            $categories = array();
            foreach($product_cats as $cat => $term){
                $categories[] = $term->slug;
            }

            if( in_array('subscribing' , array_values($categories) ) ){

                $prod_unique_id = $woocommerce->cart->generate_cart_id( $_product->id );
                $woocommerce->cart->set_quantity( $prod_unique_id, 1, true );
                if( $_product_qty > 1 ){
                    wc_add_notice( __( 'Vous ne pouvez pas ajouter plus d’une carte membre par commande. Votre panier a été automatiquement mis à jour en conséquence.', 'fruity-ocean' ), 'notice' );
                }

            }

        }

    };
    // add the action 
    add_action( 'woocommerce_check_cart_items', 'action_woocommerce_check_cart_items', 10, 0 ); 





    /**
     * System Material | Is Cart contains a type of
     * 
     * Checks if the current cart contains a type of product, like « subscribing »
     *
     * @package WordPress
     * @subpackage Fruity Ocean
     * @since Fruity Ocean 1.0
     */
    function wc_is_cart_contains_typeof( $type ) {

        global $woocommerce;
        $found = false;

        foreach ( WC()->cart->get_cart() as $cart_item_key => $values ) {

            $_product = get_product( $values['product_id'] );

            $product_cats = wp_get_post_terms( $_product->id, 'product_cat' );
            $categories = array();
            foreach($product_cats as $cat => $term){
                $categories[] = $term->slug;
            }

            if( in_array( $type , array_values($categories) ) ){
                $found = true;
            }

        }

        return $found;

    }
    /* /wc_is_cart_contains_typeof */





    /**
     * System Material | Is user orders contains a memebership card
     * 
     * Checks in the all oders of the user we can find a subscription
     *
     * @package WordPress
     * @subpackage Fruity Ocean
     * @since Fruity Ocean 1.0
     */
    function wc_member_has_valid_membership_card_in_orders( $user ) {

        global $woocommerce;
        $found = false;

        //See @line 770
        //OR code a cards subscribing getter ! ( list with date | Return an array of membership card found ...)

        return $found;

    }
    /* /wc_member_has_valid_membership_card_in_orders */





    /**
     * Hook Order review and inject custom elements (button to modify the order).
     * 
     * Injects before the order review a custom area, and add a modify cart button/link
     *
     * @package WordPress
     * @subpackage Fruity Ocean
     * @since Fruity Ocean 1.0
     */

        /**
         * WooCommerce Order Review : Add something before checkout order review paymeny choice
         * 
         * Custom action bar
         *
         * @package WordPress
         * @subpackage Fruity Ocean
         * @since Fruity Ocean 1.0
         */
        function custom_wc_cart_add_cart_button( $cart ) {
            global $woocommerce;
            //$cart = WC()->cart->get_cart();
            $cart_url = $woocommerce->cart->get_cart_url();

            echo '<div class="woocommerce-checkout-review-order-modify-cart">';
            echo '<a href="'. $cart_url .'" class="btn_action alignright">' . __('MODIFIER VOTRE COMMANDE', 'fruity-ocean') . '</a>';
            echo '<div class="clear"></div>';
            echo '</div>';

        }
        // WooCommerce Checkout custom Hook
        add_action( 'woocommerce_checkout_order_review', 'custom_wc_cart_add_cart_button', 10, 1 );



        /**
         * WooCommerce Checkout : Show a custom section after customer detail to show related products who could interested in !
         * 
         * Custom related product interest.
         *
         * @package WordPress
         * @subpackage Fruity Ocean
         * @since Fruity Ocean 1.0
         */
        function custom_wc_cart_custom_related_products( $cart ) {
            global $woocommerce;
            //$cart = WC()->cart->get_cart();
            $cart_url = $woocommerce->cart->get_cart_url();

            echo '<div class="post post_medium head_margin" style="margin-bottom:43px;">';
            echo    '<h3 id="order_review_related_heading">'. __( 'Envie de participer ?', 'fruity-ocean' ) . '</h3>';
            echo    '<div class="order_review_related">';
            // Votre commande contient des produits auxquels vous pouvez appliquez des réductions ou bénéficier d'une remise. 
            // Your order contains products which you can apply reductions or receive a discount.
            echo        '<p>' . __('Vous avez la possibilité de devenir membre adhérent et de bénéficier d\'une remise sur l\'inscription au prochain workshop', 'fruity-ocean') .'.' . __('Vous pouvez également choisir de faire don à l’association', 'fruity-ocean') .'.</p>';
            echo        '<a href="/devenir-membre/" class="btn_action alignleft">' . __( 'ADHESION', 'fruity-ocean' ) . '</a>';
            echo        '<a href="/workshop/" class="btn_action alignleft">' . __( 'WORKSHOP', 'fruity-ocean' ) . '</a>';
            echo        '<a href="/nous-soutenir/" class="btn_action btn_action_green alignleft">' . __( 'FAIRE UN DON', 'fruity-ocean' ) . '</a>';
            echo        '<div class="clear"></div>';
            echo    '</div>';
            echo '</div>';

        }
        // WooCommerce Checkout Related Product Hook
        add_action( 'woocommerce_checkout_before_customer_details', 'custom_wc_cart_custom_related_products', 10, 1 );




        /**
         * WooCommerce Checkout : Insert a vertical space after customer details
         * 
         * Custom related product interest.
         *
         * @package WordPress
         * @subpackage Fruity Ocean
         * @since Fruity Ocean 1.0
         */
        function custom_wc_cart_add_space_after_customer_details( $cart ) {
            global $woocommerce;
            //$cart = WC()->cart->get_cart();
            $cart_url = $woocommerce->cart->get_cart_url();

            echo '<div class="post post_light" style="margin-bottom:0px;">';
            echo '<!-- '.$cart_url.' -->';
            echo '</div>';

        }
        // WooCommerce Checkout Related Product Hook
        add_action( 'woocommerce_checkout_after_customer_details', 'custom_wc_cart_add_space_after_customer_details', 10, 1 );










    /**
     * Hook User Download link.
     * 
     * Inject before the order review a custom area, and add a modify cart button/link
     *
     * @package WordPress
     * @subpackage Fruity Ocean
     * @since Fruity Ocean 1.0
     */

        /**
         * WooCommerce User area : Add downloadable links
         * 
         * Custom action bar
         *
         * @package WordPress
         * @subpackage Fruity Ocean
         * @since Fruity Ocean 1.0
         */
        function wctoolbox_available_download_link( $link, $download ) {
            $order = new WC_Order( $download['order_id'] );
            $download_file_urls = $order->get_downloadable_file_urls(
                $download['product_id'],
                null,
                $download['download_id']
            );

            // Check each download URL and compare with the current URL
            // $key contains the real file URL and $value is the encoded URL
            foreach( $download_file_urls as $key => $value ) {
                preg_match_all('/key=([\w\d]+)/',$value,$value_file_id);
                preg_match_all('/key=([\w\d]+)/',$download['download_url'],$durl_file_id);
                if ($value_file_id==$durl_file_id) {
                    $url_parts = explode( '/', parse_url( $key, PHP_URL_PATH ) );
                    $file_name = end( $url_parts );
                    $link = '<a href="'
                        . esc_url( $download['download_url'] )
                        . '">'
                        . $download['download_name']
                        . '</a> <small>( '
                        . $file_name
                        . ' )</small>';
                }
            }
            return $link;
        }
        //add_filter( 'woocommerce_available_download_link', 'wctoolbox_available_download_link', 10, 2);




        function wc_custom_real_order_available_download_link() {
            global $downloads;

            $downloads = WC()->customer->get_downloadable_products();

            echo '<pre>';
            print_r( $downloads );
            echo '</pre>';

        echo '<h3>'. apply_filters( 'woocommerce_my_account_my_downloads_title', __( 'Available Downloads', 'woocommerce' ) ) .'</h3>';

            $customer_orders = get_posts( array(
                'numberposts' => -1,
                'meta_key'    => '_customer_user',
                'meta_value'  => get_current_user_id(),
                'post_type'   => wc_get_order_types(),
                'post_status' => array_keys( wc_get_order_statuses() ),
            ) );

            echo '<pre>';
            print_r( $customer_orders );
            echo '</pre>';


        echo '<h3>Products</h3>';
            // Get all products having <workshop> term in product_cat
            $args = array( 'post_type' => 'product', 'posts_per_page' => -1, 'product_cat' => 'workshop' );
            $loop = new WP_Query( $args );
            $items_id_can_be_download = array();

            while ( $loop->have_posts() ) : $loop->the_post(); 
                global $product; 
                array_push($items, $product->id);
            endwhile;
            wp_reset_query(); 

            echo '<pre>';
            print_r( $items );
            echo '</pre>';


        echo '<h3>Orders</h3>';
            foreach($customer_orders as $key => $customer_order ) {

                $order_id = $customer_order->ID;
                $order = new WC_Order( $order_id );

//get_item_downloads( $item )

                echo '<pre>';
                print_r( $order );
                echo '</pre>';
            }/**/


        }
        //add_action( 'woocommerce_before_available_downloads', 'wc_custom_real_order_available_download_link' );









/**
 * To display additional field at My Account page 
 * Once member login: edit account
 */
add_action( 'woocommerce_edit_account_form', 'my_woocommerce_edit_account_form' );

function my_woocommerce_edit_account_form() {
    if ( ! is_admin() ) {
        $user_id = get_current_user_id();
        $user = get_userdata( $user_id );

        if ( !$user )
            return;

        $user_wc_prefered_language = get_user_meta( $user_id, 'user_wc_prefered_language', true );

    ?>
        <fieldset>
            <legend>★ Only admins can see this section at this time !</legend>
        
            <p class="form-row form-row-first">
                <label for="user_wc_prefered_language"><?php echo __('Langue utilisée par défaut dans mes échanges par mail :', 'fruity-ocean') ?></label>
                <select name="user_wc_prefered_language" class="input-select" style="color: white; background-color: #cc6600; height: 2em;">
                <?php
                    require_once( ABSPATH . 'wp-admin/includes/translation-install.php' );
                    $translations = wp_get_available_translations();

                    $current_lang = get_site_option( 'WPLANG' ); // Use by default the system lang of the site.
                    $current_lang = ( $user_wc_prefered_language=='' || empty($user_wc_prefered_language) )? $current_lang : $user_wc_prefered_language;
                    $languages = get_available_languages();

                    $default_selection = '<em>('. __('non défini', 'fruity-ocean') .')</em>'; // This is a security, but should not be used because default was overrided !

                    $langs = array();
                    foreach ( $languages as $locale ) {
                        if ( isset( $translations[ $locale ] ) ) {
                            $translation = $translations[ $locale ];
                            $langs[$translation['language']] = array(
                                'language'    => $translation['language'],
                                'native_name' => $translation['native_name'],
                                'lang'        => current( $translation['iso'] ),
                            );
                            ?>
                                <option value="<?php echo $translation['language']; ?>" <?php echo (($translation['language']==$current_lang)? ' selected="selected" style="color: white; background-color: #cc6600;" ':' style="color: #cc6600; background-color: white;" '); ?> class="select-item">
                                <?php echo (($translation['language']==$current_lang)? '★':''); ?> <?php echo $langs[$translation['language']]['native_name']; ?> - [ <?php echo $langs[$translation['language']]['lang']; ?> ]
                                </option>
                            <?php

                            if( $translation['language']==$current_lang ){
                                $default_selection = '<strong style="color:#cc6600;">'. $langs[$translation['language']]['native_name'] .'</strong>';
                            }
                        }
                    }
                ?>
                </select>
                <br />
                <label for="user_wc_prefered_language"><?php echo sprintf( __('Actuellement, vos échanges sont en ★ %s', 'fruity-ocean') , $default_selection ); ?></label>

            </p>

        </fieldset>

    <?php
    } 
} // end func


/**
 * This is to save user input into the database
 * hook: woocommerce_save_account_details
 */
add_action( 'woocommerce_save_account_details', 'my_woocommerce_save_account_details' );

function my_woocommerce_save_account_details( $user_id ) {
    if ( ! is_admin() ) {
        require_once( ABSPATH . 'wp-admin/includes/translation-install.php' );
        $translations = wp_get_available_translations();

        $user_wc_prefered_language = htmlentities( $_POST[ 'user_wc_prefered_language' ] );

        $current_lang = get_site_option( 'WPLANG' ); // Use by default the system lang of the site.
        $current_lang = ( $user_wc_prefered_language=='' || empty($user_wc_prefered_language) )? $current_lang : $user_wc_prefered_language;

        update_user_meta( $user_id, 'user_wc_prefered_language', $user_wc_prefered_language ); 
    }
} // end func


/**
 * To display additional field at My Account page 
 * Once member login: edit account
 */
       function add_customer_preferd_language( $user )
        {
            ?>
                <h3><span class="dashicons-before dashicons-translation" style="color: #cc6600;"></span> Langue utilisée par défaut dans les échanges par mail</h3>

                <table class="form-table" style="border-left:solid 3px #cc6600; background: #fff;">
                    <tr>
                        <th style="padding: 20px 10px 20px 12px;"><label for="user_wc_prefered_language">Caribaea Member<br />Langue par défaut</label></th>
                        <td>

                            <select name="user_wc_prefered_language" class="input-select" style="color: white; background-color: #cc6600; height: 2em;">
                            <?php
                                $user_id = get_current_user_id();

                                $user_wc_prefered_language = get_user_meta( $user_id, 'user_wc_prefered_language', true );

                                require_once( ABSPATH . 'wp-admin/includes/translation-install.php' );
                                $translations = wp_get_available_translations();

                                $current_lang = get_site_option( 'WPLANG' ); // Use by default the system lang of the site.
                                $current_lang = ( $user_wc_prefered_language=='' || empty($user_wc_prefered_language) )? $current_lang : $user_wc_prefered_language;
                                $languages = get_available_languages();

                                $default_selection = '<em>('. __('non défini', 'fruity-ocean') .')</em>'; // This is a security, but should not be used because default was overrided !

                                $langs = array();
                                foreach ( $languages as $locale ) {
                                    if ( isset( $translations[ $locale ] ) ) {
                                        $translation = $translations[ $locale ];
                                        $langs[$translation['language']] = array(
                                            'language'    => $translation['language'],
                                            'native_name' => $translation['native_name'],
                                            'lang'        => current( $translation['iso'] ),
                                        );
                                        ?>
                                            <option value="<?php echo $translation['language']; ?>" <?php echo (($translation['language']==$current_lang)? ' selected="selected" style="color: white; background-color: #cc6600;" ':' style="color: #cc6600; background-color: white;" '); ?> class="select-item">
                                            <?php echo (($translation['language']==$current_lang)? '★':''); ?> <?php echo $langs[$translation['language']]['native_name']; ?> - [ <?php echo $langs[$translation['language']]['lang']; ?> ]
                                            </option>
                                        <?php

                                        if( $translation['language']==$current_lang ){
                                            $default_selection = '<strong style="color:#cc6600;">'. $langs[$translation['language']]['native_name'] .'</strong>';
                                        }
                                    }
                                }
                            ?>
                            </select>
                            <br />
                            <label for="user_wc_prefered_language"><?php echo sprintf( __('Actuellement, vos échanges sont en ★ %s', 'fruity-ocean') , $default_selection ); ?></label>

                        </td>
                    </tr>
                </table>

            <?php
        }
        add_action( 'show_user_profile', 'add_customer_preferd_language' );
        add_action( 'edit_user_profile', 'add_customer_preferd_language' );



/**
 * This is to save user input into database
 * hook: woocommerce_save_account_details
 */
function save_extra_customer_preferd_language( $user_id )
{

    update_user_meta( $user_id, 'user_wc_prefered_language', filter_var($_POST['user_wc_prefered_language'], FILTER_SANITIZE_STRING) );

}
//add_action( 'personal_options_update', 'save_extra_social_links' );
add_action( 'personal_options_update', 'save_extra_customer_preferd_language' );
add_action( 'edit_user_profile_update', 'save_extra_customer_preferd_language' );

//Admin Profile panel











    /**
     * Hook Cart calculation
     * 
     * Fees for member already connected or customer shopping a membership card
     *
     * @package WordPress
     * @subpackage Fruity Ocean
     * @since Fruity Ocean 1.0
     */

        /**
         * WooCommerce Cart Fees : 
         * 
         * //
         *
         * @package WordPress
         * @subpackage Fruity Ocean
         * @since Fruity Ocean 1.0
         */
        function woocommerce_custom_surcharge() {
          global $woocommerce;

            /*if ( is_admin() && ! defined( 'DOING_AJAX' ) )
                return;/**/

                // By default, no member lgged in / no member car subscribing.
                $workshop_fee_type_applied = __('Pas de « Carte de Membre » détectée, aucune remise appliquée !', 'fruity-ocean');
                $is_workshop_fee_must_applied = false;



                // If user logged in, it's a member. So special fee for valid member ! (Admin and user with WP roles are member too)
                if ( is_user_logged_in() ) {

                    // Retreive the current user logged in, and get its email account address ! 
                    $tmp_current_user = wp_get_current_user();
                    $user_roles = get_userdata( $tmp_current_user->ID )->roles;


                    // If customer and only if and only if is a valid (enabled) customer...
                    if( in_array('customer', $user_roles) ) {
                        if( get_the_author_meta( 'valid_customer_enabled', $tmp_current_user->ID ) == '1' ){
                            
                            // TODO : Check if the membership card has a correct date validity !
                            // See into the fee process ...


                            $is_workshop_fee_must_applied = true;
                            $workshop_fee_type_applied = __('Remise « Carte de Membre » Caribaea Initiative (membre inscrit connecté)', 'fruity-ocean') .' - '.$tmp_current_user->user_email.'';
                        }
                        else{
                            $workshop_fee_type_applied = __('Utilisateur identifié, mais « Carte de Membre » pas encore validée !', 'fruity-ocean') .' ('.$tmp_current_user->user_email.')';
                        }
                    }

                    if( in_array('administrator', $user_roles) || in_array('shop_manager', $user_roles)) {
                        $is_workshop_fee_must_applied = true;
                        $workshop_fee_type_applied = __('Remise « Carte de Membre » Caribaea Initiative (Special Admin ou Manager)', 'fruity-ocean') .' - '.$tmp_current_user->user_email.'';
                    }


                    unset($user_roles);
                    unset($tmp_current_user);
                }
                


                // Scan the cart to found a membership card...
                foreach($woocommerce->cart->get_cart() as $cart_item_key => $values ) {
                    $_product = $values['data'];
                
                    // Check if a product is a {membership card} !
                    // In fact, if the user buy a membership card, this product will be payed and we can consider the user as a member.
                    // [subscribing] -> categorie of membership products
                    $product_cats = wp_get_post_terms( $_product->id, 'product_cat' );
                    $categories = array();
                    foreach($product_cats as $cat => $term){
                        $categories[] = $term->slug;
                    }
                    if( in_array('subscribing' , array_values($categories) ) ){
                        $is_workshop_fee_must_applied = true;
                        $workshop_fee_type_applied = __('Remise nouvel abonnement « Carte de Membre » Caribaea Initiative', 'fruity-ocean');
                    }

                }



                // Scan the cart to find all product having fee, like the workshops...
                foreach($woocommerce->cart->get_cart() as $cart_item_key => $values ) {
                    $_product = $values['data'];

                    
                    // Retreive the fee of this product if it has one !
                    // [remise-membre] -> For workshop | release 2015-2016
                    // [remise-membre-student] -> For workshop | release Jan. 2017 (Special students)
                    //
                    if( isset( $_product->get_attributes()['remise-membre'] ) || isset( $_product->get_attributes()['remise-membre-student'] ) ){
                        
                        // Get the fee of this product...
                        //
                        // Process here step by step to ensure a well fee assignation.
                        // - 1st : Normal fee for members
                        // - 2nd : Special students members
                        //
                        // >> 1st case...
                        $workshop_fee = (-1)*intval($_product->get_attributes()['remise-membre']['value']);
                        
                        // Special student members !
                        $special_workshop_fee = (-1)*intval($_product->get_attributes()['remise-membre-student']['value']);
                        $special_workshop_fee_type_applied = __('Remise abonnement « Carte de Membre Etudiant » Caribaea Initiative', 'fruity-ocean');


                        // If a discount must be applied... registered member or membership card in the cart !
                        if ( $is_workshop_fee_must_applied ) {

                        // @Special process to check valid date !

                            // Verify if the fee to be apply, has a related validity date.
                            // We can not use the « Workshop Event date », but the product 'date' attribute, like 'remise-membre'.
                            // That date contains the validity date of the event product where the Membership card must be applied !


                            // Fetch all orders for this customer
                            $customer_orders = get_posts( array(
                                'meta_key'    => '_customer_user',
                                'meta_value'  => ( is_user_logged_in() )? wp_get_current_user()->ID : 0,
                                'post_type'   => wc_get_order_types(),
                                'post_status' => ('wc-completed'), /* array_keys( wc_get_order_statuses() ),/**/
                                'numberposts' => -1
                            ) );


                            $order_history_membering = array(); // Store an history of the subscribe sequence (date, member card type evolution).

                            foreach($customer_orders as $k => $v)
                            {
                                $order_id = $customer_orders[ $k ]->ID;

                                $order = new WC_Order( $order_id );
                                $order_date = $order->order_date;
                                $validity = null;
                                

                                $items = $order->get_items();
                                
                                foreach ( $items as $item ) {
                                    $product_name = $item['name'];
                                    $product_id = $item['product_id'];
                                    $product = new WC_Product( $product_id );
                                    $product_sku = $product->get_sku();
                                    //$product_variation_id = $item['variation_id'];


                                    // Check if a product is a {membership card} !
                                    // In fact, if the user buy a membership card, this product will be payed and we can consider the user as a member.
                                    // [subscribing] -> categorie of membership products
                                    $product_cats = wp_get_post_terms( $product_id, 'product_cat' );
                                    $categories = array();
                                    foreach($product_cats as $cat => $term){
                                        $categories[] = $term->slug;
                                    }
                                    if( in_array('subscribing' , array_values($categories) ) ){
                                        // This order have a « Subscribing Member Card » product
                                        $order_history_membering['_'.strtotime($order_date)] = array( 
                                            'id'=>$product_id,
                                            'type'=>$product_name,
                                            'sku'=>$product_sku,
                                            'validity'=>'----'
                                        );
                                        
                                        // Retreive the stored validity date or the order year
                                        if ( ! get_post_meta( $order->id, 'member_card_validity', true ) ) {
                                            $validity = date('Y', strtotime($order_date)) ; // Default value of the membership validity date.
                                        }else{
                                            $validity = get_post_meta( $order->id, 'member_card_validity', true ); // Otherwise, the stored year (from checkout process).
                                        }
                                        
                                        $order_history_membering['_'.strtotime($order_date)]['validity'] = $validity;

                                    }

                                }
                                
                            }   

                            // Ordering properly the list.
                            ksort($order_history_membering);

                            $asked_validity = null;
                            if( isset( $_product->get_attributes()['date'] ) ){
                                // Get the date of this product...
                                $asked_validity = intval($_product->get_attributes()['date']['value']);
                            }


                            $has_a_validity_membership_card_for_year = false;


                            // Search if a membership card validity already exists into the « History Orders » for the same asked validity...
                            foreach($order_history_membering as $k => $card){
                                //$date = str_replace('_', '', $k);

                                if( intval( $card['validity']) === $asked_validity ){
                                    
                                    $has_a_validity_membership_card_for_year = true;

                                    // >> 2nd case... ACI-INSC.MBR-A00
                                    if( $card['sku'] == 'ACI-INSC.MBR-A00' ){
                                        $workshop_fee = $special_workshop_fee;
                                        $workshop_fee_type_applied = $special_workshop_fee_type_applied;
                                    }
                                    

                                }
                            }



                            
                            // Search if a membership card exists into the products « User Cart » 
                            foreach($woocommerce->cart->get_cart() as $__cart_item_key => $__values ) {
                                $_p = $__values['data'];
                            
                                // Check if a product is a {membership card} !
                                // In fact, if the user buy a membership card, this product will be payed and we can consider the user as a member.
                                // [subscribing] -> categorie of membership products
                                $p_cats = wp_get_post_terms( $_p->id, 'product_cat' );
                                $p_categories = array();
                                foreach($p_cats as $_cat => $_term){
                                    $p_categories[] = $_term->slug;
                                }
                                if( in_array('subscribing' , array_values($p_categories) ) ){
                                    
                                    if( $_p->get_sku() == 'ACI-INSC.MBR-A00' ){

                                        $is_workshop_fee_must_applied = true;
                                        $workshop_fee = $special_workshop_fee;
                                        $workshop_fee_type_applied = $special_workshop_fee_type_applied;
                                    }

                                }

                            }
                            /**/


                            /*
                            if( in_array('subscribing' , array_values($categories) ) ){
                                $is_workshop_fee_must_applied = true;
                                $workshop_fee_type_applied = __('Remise nouvel abonnement « Carte de Membre » Caribaea Initiative', 'fruity-ocean');


                                //$workshop_fee_type_applied .= print_r( $woocommerce->cart->get_cart() , true );
                            }
                            /**/


                            // Override the fee attributes if not membership card found for the valid event date !
                            if( !$is_workshop_fee_must_applied && !$has_a_validity_membership_card_for_year ){
        
                                $workshop_fee_type_applied = __('Abonnement « Carte de Membre » Caribaea Initiative arrivé à expiration !', 'fruity-ocean');
                                $workshop_fee = 0;
                                $is_workshop_fee_must_applied = false; // ReSet to false, to not process the fee after...
                                //This is a bypass, and run a no/0 fee discount ...

                            }

                        // @End Special process to check valid date !

                            // Otherwize, lets add the fee to the cart...
                            else {

                                $woocommerce->cart->add_fee( $workshop_fee_type_applied , $workshop_fee, true, '' );

                            }

                        }

                    }
                
                }

                // If no fee/discount? notice it.
                if ( ! $is_workshop_fee_must_applied ) {
                    $woocommerce->cart->add_fee( $workshop_fee_type_applied, 0, true, '' );
                }

                
            
            // Special Christmass discount :)
            /*
            $percentage = 0.05;
            $surcharge = ( $woocommerce->cart->cart_contents_total + $woocommerce->cart->shipping_total ) * $percentage;    
            $woocommerce->cart->add_fee( 'Surcharge', $surcharge, true, '' );
            /**/

        }
        // WooCommerce Cart Fees
        add_action( 'woocommerce_cart_calculate_fees','woocommerce_custom_surcharge' );







    /**
     * Hook User profile in the admin panel
     * 
     * Add a custom user profile field.
     * This field allows to define a customer as a valid shop customer to prevent fee surounding in cart calculation!
     *
     * @package WordPress
     * @subpackage Fruity Ocean
     * @since Fruity Ocean 1.0
     */

        /**
         * Admin Profile panel : Add a « Member pokemon~itor »
         * 
         * //
         *
         * @package WordPress
         * @subpackage Fruity Ocean
         * @since Fruity Ocean 1.0
         */
        function add_extra_valid_customer_enabled( $user )
        {
            ?>
                <div class="updated notice">
                    <p><strong>Remind it ! By default, the option « Security on valid customer » is not checked. Enable it manually for each new member as customer...</strong></p>
                </div>


                <h3><span class="dashicons-before dashicons-id" style="color: #7ad03a;"></span> Security on valid customer (Caribaea Member)</h3>

                <table class="form-table" style="border-left:solid 3px #7ad03a; background: #fff;">
                    <tr>
                        <th style="padding: 20px 10px 20px 12px;"><label for="valid_customer_enabled">Caribaea Member<br />Valid Customer Enabled</label></th>
                        <td>
                            <input type="checkbox" value="1" name="valid_customer_enabled" id="valid_customer_enabled" <?php if( get_the_author_meta( 'valid_customer_enabled', $user->ID ) == '1' ){ echo 'checked="checked"'; } ?>>
                            <span class="description">Enable this option when you are sure that this user is a valid and registered customer (He baught a <strong>membership card</strong> !).</span>
                        </td>
                    </tr>
                </table>

            <?php
        }
        add_action( 'show_user_profile', 'add_extra_valid_customer_enabled' );
        add_action( 'edit_user_profile', 'add_extra_valid_customer_enabled' );



        function save_extra_valid_customer_enabled( $user_id )
        {

            update_user_meta( $user_id, 'valid_customer_enabled', filter_var($_POST['valid_customer_enabled'], FILTER_SANITIZE_NUMBER_INT) );

        }
        //add_action( 'personal_options_update', 'save_extra_social_links' );
        add_action( 'personal_options_update', 'save_extra_valid_customer_enabled' );
        add_action( 'edit_user_profile_update', 'save_extra_valid_customer_enabled' );

        //Admin Profile panel


        /**
         * Adds a custom column header to the posttype table list.
         * Adds (and fill) a custom column cell to the posttype table list.
         * 
         * //
         *
         * @package WordPress
         * @subpackage Fruity Ocean
         * @since Fruity Ocean 1.0
         */
        function fruityocean_wp_users_plugin_columns_head($defaults) {
            $defaults['valid_customer_member'] = '<span class="dashicons-before dashicons-id" style="color:#0688A2;"></span> Confirmé';
            $defaults['registerd_member_card_validity'] = '<span class="dashicons-before dashicons-calendar-alt" style="color:#0688A2;"></span> Validité';
            return $defaults;
        }


        function fruityocean_wp_users_plugin_columns_content($value, $column_name, $user_id) {
            if ($column_name == 'valid_customer_member') {
                
                $user = get_userdata( $user_id );
               
                if( get_the_author_meta( 'valid_customer_enabled', $user_id ) == '1' ){
                    return '<span class="dashicons-before dashicons-yes" style="color:#0688A2;"></span>';
                }else{
                    return '<span class="dashicons-before dashicons-no-alt" style="color:#A23D06;"></span>';
                }

            }

            if ($column_name == 'registerd_member_card_validity') {

                $user = get_userdata( $user_id );
                
                // Fetch all orders for this customer
                $customer_orders = get_posts( array(
                    'meta_key'    => '_customer_user',
                    'meta_value'  => $user_id,
                    'post_type'   => wc_get_order_types(),
                    'post_status' => ('wc-completed'), /* array_keys( wc_get_order_statuses() ),/**/
                    'numberposts' => -1
                ) );


                // Prepare ann html output : delivering a list of subscribing cards (all orders).
                $html = '';
                $order_history_membering = array(); // Store an history of the subscribe sequence (date, member card type evolution).

                foreach($customer_orders as $k => $v)
                {
                    $order_id = $customer_orders[ $k ]->ID;

                    $order = new WC_Order( $order_id );
                    $order_date = $order->order_date;
                    $validity = null;
                    

                    $items = $order->get_items();
                    
                    foreach ( $items as $item ) {
                        $product_name = $item['name'];
                        $product_id = $item['product_id'];
                        //$product_variation_id = $item['variation_id'];


                        // Check if a product is a {membership card} !
                        // In fact, if the user buy a membership card, this product will be payed and we can consider the user as a member.
                        // [subscribing] -> categorie of membership products
                        $product_cats = wp_get_post_terms( $product_id, 'product_cat' );
                        $categories = array();
                        foreach($product_cats as $cat => $term){
                            $categories[] = $term->slug;
                        }
                        if( in_array('subscribing' , array_values($categories) ) ){
                            // This order have a « Subscribing Member Card » product
                            $order_history_membering['_'.strtotime($order_date)] = array( 
                                'type'=>$product_name, 
                                'validity'=>'----'
                            );
                            
                            // Retreive the stored validity date or the order year
                            if ( ! get_post_meta( $order->id, 'member_card_validity', true ) ) {
                                $validity = date('Y', strtotime($order_date)) ; // Default value of the membership validity date.
                            }else{
                                $validity = get_post_meta( $order->id, 'member_card_validity', true ); // Otherwise, the stored year (from checkout process).
                            }
                            
                            $order_history_membering['_'.strtotime($order_date)]['validity'] = $validity;

                        }

                    }
                    
                }   

                // Ordering properly the list.
                ksort($order_history_membering);
                foreach($order_history_membering as $k => $card){
                    $date = str_replace('_', '', $k);
                
                    $html.= '<span class="dashicons-before dashicons-id" style="cursor:help;" title="'.date("d/m/Y h:i:s",$date).'"></span> <small>'. $card['type'] .'</small> [<strong style="color:#0688A2;">'. $card['validity'] .'</strong>]' .'<br />';
                }

                // Write out something to notice that this user have no membership card !
                if (empty($order_history_membering)) {
                    if( get_the_author_meta( 'valid_customer_enabled', $user_id ) == '1' ){
                        $html.= '<small class="dashicons-before dashicons-warning" style="color:#A23D06; cursor:help;" title="Attention, cet utilisateur est marqué cependant comme membre confirmé !"> '. 'Aucune cotisation' .'</small>';
                    }else{
                        $html.= '<small style="color:#999;">'. 'Pas de cotisation' .'</small>';
                    }
                }

                // Return the cell content.
                return $html;


            }
        }


        // Custom table column of users Post type to add some informations
        add_filter('manage_'. 'users' .'_columns', 'fruityocean_wp_users_plugin_columns_head' );
        add_filter('manage_'. 'users' .'_custom_column', 'fruityocean_wp_users_plugin_columns_content', 10, 3 ); 








    /**
     * System Cron | 
     * 
     * 
     *
     * @package WordPress
     * @subpackage Fruity Ocean
     * @since Fruity Ocean 1.0
     */
    // Register the hook to membershipcard_subscribing_process_remind_before_expiration() function.
    // This Hook « action_subscribing_process_remind_before_expiration » could be used into cron system, or Crontrol plugin...
    add_action( 'action_subscribing_process_remind_before_expiration', 'membershipcard_subscribing_process_remind_before_expiration' );
    
    // Define function callback
    function membershipcard_subscribing_process_remind_before_expiration() {

        // Ok, first check if we are the good month to process.
        $trigger_on_month = array(11,12); // Nov, Dec

        $label_contact = 'Sébastien Brémond';
        $mail_contact = 'contact@web-medias.com';
        $card_validity = date('Y');

        // Trigger this only on certain months.
        if( ! in_array( date('m') , array_values($trigger_on_month) ) ){
            return;
        }

        $reporting = array();

        // Get all registered blog users.
        $blogusers = get_users( array(
            'blog_id'      => $GLOBALS['blog_id'],
            'orderby'      => 'login',
            'order'        => 'ASC'
        ) );


        // Array of WP_User objects.
        foreach ( $blogusers as $user ) {
            
            $user_id = $user->ID;
            $user_email = $user->user_email;

            $user_info = get_userdata( $user->ID );
            
            $first_name = $user_info->first_name;
            $last_name = $user_info->last_name;

            // Fetch all orders for this customer
            $customer_orders = get_posts( array(
                'meta_key'    => '_customer_user',
                'meta_value'  => $user_id,
                'post_type'   => wc_get_order_types(),
                'post_status' => ('wc-completed'), /* array_keys( wc_get_order_statuses() ),/**/
                'numberposts' => -1
            ) );



            $order_history_membering = array(); // Store an history of the subscribe sequence (date, member card type evolution).

            // Iterate on each order...
            foreach($customer_orders as $k => $v)
            {
                $order_id = $customer_orders[ $k ]->ID;

                $order = new WC_Order( $order_id );
                $order_date = $order->order_date;
                $validity = null;
                

                $items = $order->get_items();
                // Iterate on each product in this order...
                foreach ( $items as $item ) {
                    $product_name = $item['name'];
                    $product_id = $item['product_id'];
                    //$product_variation_id = $item['variation_id'];


                    // Check if a product is a {membership card} !
                    // In fact, if the user buy a membership card, this product will be payed and we can consider the user as a member.
                    // [subscribing] -> categorie of membership products
                    $product_cats = wp_get_post_terms( $product_id, 'product_cat' );
                    $categories = array();
                    foreach($product_cats as $cat => $term){
                        $categories[] = $term->slug;
                    }
                    if( in_array('subscribing' , array_values($categories) ) ){
                        // This order have a « Subscribing Member Card » product

                        $order_history_membering['_'.strtotime($order_date)] = array( 
                            'id' =>$product_id,
                            'type'=>$product_name,
                            'validity'=>'0000'
                        );
                        
                        // Retreive the stored validity date or the order year
                        if ( ! get_post_meta( $order->id, 'member_card_validity', true ) ) {

                            // Default value of the membership validity date.
                            // And oldest orders having a membership card but not the « member_card_validity » date code stored into the order ! (Before the 19, December 2016).
                            $validity = date('Y', strtotime($order_date)) ; 

                        }else{
                            
                            // Otherwise, the stored year (from checkout process).
                            $validity = get_post_meta( $order->id, 'member_card_validity', true );

                        }
                        
                        $order_history_membering['_'.strtotime($order_date)]['validity'] = $validity; // Fix it

                    }

                }
                
            }


            // All oders for this user are scanned and membership cards collecting is done.
            // 
            if (empty($order_history_membering)) {

                // No membership card(s) found in the user orders !
                //Do nothhing, no mail.

            }else{

                // Do only if the user is Valid Customer Enabled | flagged ✓
                if( get_the_author_meta( 'valid_customer_enabled', $user_id ) == '1' ){

                    
                    // Ordering properly the list.
                    ksort($order_history_membering);


                    // Note : To renew a memberhip card, the user must have a subscription for the current year.
                    //        The logic want we remind all users having a valid card, AND not having a card for the next year.
                    //        
                    //        If an oldest card exists for a year in past, and no valid card at this time, it is not a renew !
                    //
                    //        Logic bloc definition :
                    //
                    //        |  oldest  |  oldest  |  current |   next   |  future  | process  |
                    //        |  year-2  |  year-1  |   year   |  year+1  |  year++  |  mail ?  |
                    //  ------|----------+----------+----------+----------+----------+----------+
                    //   card |    --    |    --    |    no    |  no|yes  |    --    |    NO    |
                    //        |----------+----------+----------+----------+----------+----------+
                    //   card |    --    |    --    |    yes   |    no    |    --    |    ✓    |
                    //        |----------+----------+----------+----------+----------+----------+
                    //   card |    --    |    --    |    yes   |    yes   |    --    |    NO    |
                    //        |----------+----------+----------+----------+----------+----------+
                    //
                    // 2 conditions to renew :
                    // - has_current_year = true
                    // - has_newt_year = false

                    $has_current_year = false;
                    $next_year_validity = false;


                    // Search if a membership card validity...
                    foreach($order_history_membering as $k => $card){

                        
                        if( intval( $card['validity']) === intval( date('Y') ) ){

                            $has_current_year = true; // A membership card was found for the current year.

                        }


                        if( intval( $card['validity']) === intval( date('Y') )+1 ){

                            $next_year_validity = true; // A membership card was found for the next year.

                        }


                    }


                    $label_contact = ucwords(strtolower($first_name.' '.$last_name));


                    // Check conditions.

                    if( !$has_current_year && !$next_year_validity ){
                        
                        $reporting[] = '<strong>'.$label_contact.'</strong> ('.$user_email.') -- Carte Membre non suivie';

                    }
                    if( !$has_current_year && $next_year_validity ){

                        $reporting[] = '<strong>'.$label_contact.'</strong> ('.$user_email.') -- Carte Membre déjà souscrite';

                    }
                    if( $has_current_year && !$next_year_validity ){
                        
                        // So process to send a mail notification to renew !
                        $validity_date = date('Y');
                        membershipcard_subscribing_process_send_before_expiration( $label_contact, $mail_contact, $validity_date ); // DEBUG
                       // membershipcard_subscribing_process_send_before_expiration( $label_contact, $user_email, $validity_date ); // PRODUCTION
                        $reporting[] = '<strong>'.$label_contact.'</strong> ('.$user_email.') -- Renouvellement | Renewal';

                    }
                    if( $has_current_year && $next_year_validity ){
                        
                        $reporting[] = '<strong>'.$label_contact.'</strong> ('.$user_email.') -- Carte Membre déjà reconduite';

                    }


                } // EndIf valid_customer_enabled = 1
                else{

                        $label_contact = ucwords(strtolower($first_name.' '.$last_name));
                        $reporting[] = '<strong>'.$label_contact.'</strong> ('.$user_email.') -- Membre non confirmé !';

                }


            } // /$order_history_membering not empty


        } /* /foreach */
        /**/


        // Send an Admin report
        $mail_admin = get_site_option( 'admin_email' );
        $mail_admin = 'contact@web-medias.com';
        $site_name = get_bloginfo( 'name', 'display' );
        $report_subject = $site_name.' ★ REPORTING ★ '.'Renouvellement adhésion | Membership Renewal';
        $report_message = join('<br />', $reporting);

        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= 'To: <'.$mail_admin.'>' . "\r\n";
        $headers .= 'From: Site '.$site_name.' <'. 'contact@caribaea.org' .'>' . "\r\n";

        mail( $mail_admin, $report_subject, htmlentities_corrected($report_message), $headers );


    }
    
    function membershipcard_subscribing_process_send_before_expiration($label_contact, $mail_contact, $card_validity) {

        //$logger = new WC_Logger();

        //$logger->add( 'subscribing_expiration', 'Run' );

        if( $label_contact == '' || $mail_contact == '' || $card_validity == '' ){return;}

        $site_name = get_bloginfo( 'name', 'display' );
        $site_description = get_bloginfo( 'description', 'display' );
        $site_template = get_bloginfo( 'template_url', 'display' );
        $site_url = home_url('../');
        $mail_subject = $site_name.' ★ '.'Renouvellement adhésion | Membership Renewal' .' ('.$label_contact.')';

        $template_mail = '
<div id="wrapper" dir="ltr" style="background-color: #eff0ee; margin: 0; padding: 70px 0 70px 0; -webkit-text-size-adjust: none !important; width: 100%">
  <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
    <tbody>
      <tr>
        <td align="center" valign="top">
          <div id="template_header_image"></div>
          <table border="0" cellpadding="0" cellspacing="0" width="600" id="template_container" style="box-shadow: 0 1px 4px rgba(0,0,0,0.1) !important; background-color: #fafcfa; border: 1px solid #d7d8d6; border-radius: 3px !important">
            <tbody>
              <tr>
                <td align="center" valign="top">
                  <table border="0" cellpadding="0" cellspacing="0" width="600" id="template_header" style="background-color: #fafcfa; border-radius: 3px 3px 0 0 !important; color: #ffffff; border-bottom: 0; font-weight: bold; line-height: 100%; vertical-align: middle; font-family: &quot;Helvetica Neue&quot;, Helvetica, Roboto, Arial, sans-serif">
                    <tbody>
                      <tr>
                        <td id="header_wrapper" style="text-align:center; padding: 36px 48px; display: block">
                          <p>
                            <img width="150" src="'.$site_template.'/images/logo_mail.png" />
                          </p>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>

              <tr>
                <td align="center" valign="top">
                  <table border="0" cellpadding="0" cellspacing="0" width="600" id="template_header" style="background-color: #cc6600; border-radius: 3px 3px 0 0 !important; color: #ffffff; border-bottom: 0; font-weight: bold; line-height: 100%; vertical-align: middle; font-family: &quot;Helvetica Neue&quot;, Helvetica, Roboto, Arial, sans-serif">
                    <tbody>
                      <tr>
                        <td id="header_wrapper" style="padding: 36px 48px; display: block">
                          <h1 style="color: #ffffff; font-family: &quot;Helvetica Neue&quot;, Helvetica, Roboto, Arial, sans-serif; font-size: 30px; font-weight: 300; line-height: 150%; margin: 0; text-align: center; text-shadow: 0 1px 0 #d68533; -webkit-font-smoothing: antialiased">
                            RENOUVELLEMENT D\'ADHÉSION<br /><em>RENEW YOUR MEMBERSHIP</em>
                          </h1>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
              <tr>
                <td align="center" valign="top">

                  <table border="0" cellpadding="0" cellspacing="0" width="600" id="template_body">
                    <tbody>
                      <tr>
                        <td valign="top" id="body_content" style="background-color: #fafcfa">

                          <table border="0" cellpadding="20" cellspacing="0" width="100%">
                            <tbody>
                              <tr>
                                <td valign="top" style="padding: 48px 48px 0 48px">
                                  <div id="body_content_inner" style="color: #868986; font-family: &quot;Helvetica Neue&quot;, Helvetica, Roboto, Arial, sans-serif; font-size: 14px; line-height: 150%; text-align: center">

                                    <p style="margin: 16px 0 53px; color: #cc6600; text-align: left"><strong>'.$label_contact.'</strong>,</p>

                                    
                                    <p style="margin: 0 0 16px;">Ce courriel vous a été envoyé par un système automatique d\'émission de messages, vous signalant que votre adhésion arrive bientôt à expiration.</p>
                                    <p style="margin: 0 0 16px;"><em>This email is an automatic response email from our system signaling that your membership expires within a month.</em></p>


                                    <p style="margin: 16px 0 53px; color: #cc6600;"><strong>member_card_validity: ['.$card_validity.']</strong></p>


                                    <p style="margin: 0 0 16px">
                                        <h2 style="display: block; font-family: &quot;Helvetica Neue&quot;, Helvetica, Roboto, Arial, sans-serif; font-size: 18px; font-weight: bold; line-height: 130%; margin: 16px 0 8px;">
                                        Vous êtes adhérent et souhaitez renouveler votre cotisation pour l\'année prochaine ?
                                        </h2>
                                        <a href="'.$site_url.'fr/devenir-membre" style="margin: 5px 0 15px 0;text-decoration: none;height: 43px;line-height: 43px;text-align: center;display: inline-block;color: #fafcfa!important;background-color: #cc6600;padding: 0 1.5em;border: 0 none;cursor: pointer;text-transform: uppercase;font-style: normal;font-weight: normal;-webkit-border-radius: 21px;-moz-border-radius: 21px;border-radius: 21px;">JE VEUX RENOUVELER MON ADHESION</a>
                                    </p>

                                    <p style="margin: 0 0 16px">
                                        <h2 style="display: block; font-family: &quot;Helvetica Neue&quot;, Helvetica, Roboto, Arial, sans-serif; font-size: 18px; font-weight: bold; line-height: 130%; margin: 16px 0 8px;">
                                        <em>Would you like to extend your membership for next year ?</em>
                                        </h2>
                                        <a href="'.$site_url.'en/devenir-membre" style="margin: 5px 0 15px 0;text-decoration: none;height: 43px;line-height: 43px;text-align: center;display: inline-block;color: #fafcfa!important;background-color: #cc6600;padding: 0 1.5em;border: 0 none;cursor: pointer;text-transform: uppercase;font-style: normal;font-weight: normal;-webkit-border-radius: 21px;-moz-border-radius: 21px;border-radius: 21px;">I WISH TO EXTEND MY MEMBERSHIP</a>
                                    </p>


                                    <p style="margin: 0 0 16px;"><span style="text-decoration: underline;">À noter :</span> <em>Les adhérents et les donateurs, recevront, leur(s) reçu(s) fiscaux*, courant de l\'année d\'adhésion : * 66 % du montant de votre don peut être déduit de votre impôt sur le revenu. Le plafond de la déduction s\'élève à 20% de votre revenu imposable.</em></p>

                                    <p style="margin: 0 0 16px; border-bottom:solid 1px #cc6600;"></p>


                                    <p style="margin: 0 0 16px;">
                                        <strong>Un grand merci</strong> à celles et ceux qui, chaque année, soutiennent notre association.
                                        Cette année encore, <strong>Caribaea Initiative</strong> a de nombreux projets dans le but de « <em><strong>développer la recherche et la formation supérieure sur la biodiversité et la gestion des populations animales dans les Caraïbes</strong></em> » !
                                    </p>
                                    <p style="margin: 0 0 16px">
                                        <a href="'.$site_url.'fr/activites/" style="margin: 5px 0 15px 0;text-decoration: none;height: 43px;line-height: 43px;text-align: center;display: inline-block;color: #fafcfa!important;background-color: #78b829;padding: 0 1.5em;border: 0 none;cursor: pointer;text-transform: uppercase;font-style: normal;font-weight: normal;-webkit-border-radius: 21px;-moz-border-radius: 21px;border-radius: 21px;">EN SAVOIR PLUS</a>
                                    </p>

                                    <p style="margin: 0 0 16px;">
                                        <strong>Many thanks</strong> to those who support our association every year. This year again, <strong>Caribaea Initiative</strong> has many projects in order to « <em><strong>develop research and higher education on animal biodiversity and wildlife conservation in the Caribbean</strong></em>»!
                                    </p>
                                    <p style="margin: 0 0 16px">
                                        <a href="'.$site_url.'en/activites/" style="margin: 5px 0 15px 0;text-decoration: none;height: 43px;line-height: 43px;text-align: center;display: inline-block;color: #fafcfa!important;background-color: #78b829;padding: 0 1.5em;border: 0 none;cursor: pointer;text-transform: uppercase;font-style: normal;font-weight: normal;-webkit-border-radius: 21px;-moz-border-radius: 21px;border-radius: 21px;">LEARN MORE</a>
                                    </p>

                                    <p style="margin: 0 0 16px">
                                        Nous contacter | To contact us:<br />
                                        contact@caribaea.org<br />
                                        www.caribaea.org
                                    </p>


                                    <p style="margin: 0 0 16px">
                                        <a href="https://www.facebook.com/caribaeainitiative/" title="Facebook" style="margin: 5px 0 15px 0;text-align: center;display: inline-block;padding: 0 0.5em;border: 0 none;cursor: pointer;">
                                        <img src="'.$site_template.'/images/picto_mail_fb.png" />
                                        </a>
                                        <a href="http://www.caribaea.org" title="Caribaea Iinitiative" style="margin: 5px 0 15px 0;text-align: center;display: inline-block;padding: 0 0.5em;border: 0 none;cursor: pointer;">
                                        <img src="'.$site_template.'/images/picto_mail_ci.png" />
                                        </a>
                                        <a href="https://vimeo.com/user48799675" title="Vimeo" style="margin: 5px 0 15px 0;text-align: center;display: inline-block;padding: 0 0.5em;border: 0 none;cursor: pointer;">
                                        <img src="'.$site_template.'/images/picto_mail_vi.png" />
                                        </a>
                                    </p>


                                  </div>
                                </td>
                              </tr>
                            </tbody>
                          </table>

                        </td>
                      </tr>
                    </tbody>
                  </table>

                </td>
              </tr>
              <tr>
                <td align="center" valign="top">

                  <table border="0" cellpadding="10" cellspacing="0" width="600" id="template_footer">
                    <tbody>
                      <tr>
                        <td valign="top" style="padding: 0; -webkit-border-radius: 6px">
                          <table border="0" cellpadding="10" cellspacing="0" width="100%">
                            <tbody>
                              <tr>
                                <td colspan="2" valign="middle" id="credit" style="padding: 0 48px 48px 48px; -webkit-border-radius: 6px; border: 0; color: #e0a366; font-family: Arial; font-size: 12px; line-height: 125%; text-align: center">
                                  <p>
                                    <img width="150" src="'.$site_template.'/images/logo_mail.png" />
                                  </p>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                    </tbody>
                  </table>

                </td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
    </tbody>
  </table>
</div>
        ';
        

            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
            $headers .= 'To: <'.$mail_contact.'>' . "\r\n";
            $headers .= 'From: Site '.$site_name.' <' . get_site_option( 'admin_email' ) . '>' . "\r\n";
            /**/        

            mail( $mail_contact, $mail_subject, htmlentities_corrected($template_mail), $headers );

        /*
        $headers = array('From: '.$site_name.' <' . get_site_option( 'admin_email' ) . '>');

        add_filter( 'wp_mail_content_type', 'set_html_content_type' );
        wp_mail( 'contact@web-medias.com', 'Subject', htmlentities_corrected($template_mail), $headers );
        remove_filter( 'wp_mail_content_type', 'set_html_content_type' );
        /**/
    }

function set_html_content_type() {
    return 'text/html';
}

        function htmlentities_corrected($str_in) {
            $list = get_html_translation_table(HTML_ENTITIES);
            unset($list['"']);
            unset($list['<']);
            unset($list['>']);
            unset($list['&']);
        
            $search = array_keys($list);
            $values = array_values($list);
        
            $search = array_map('utf8_encode', $search);

            //Add hungarian chars support
            $search[] = chr(0xc5).chr(0x91); $values[] = '&#337;';
            $search[] = chr(0xc5).chr(0xb1); $values[] = '&#369;';
            $search[] = chr(0xc5).chr(0x90); $values[] = '&#336;';
            $search[] = chr(0xc5).chr(0xb0); $values[] = '&#368;';

            $str_in = str_replace($search, $values, $str_in);
            
            return $str_in;
        }





    /**
     * Workshop Flyer managing
     * 
     * Allows to manipulate the image flyer to restitute a real saling flyer as a identity badge (barcode)
     * - TODO : Check if in active plugin list the barcode plugin is installed !
     *
     * @package WordPress
     * @subpackage Fruity Ocean
     * @since Fruity Ocean 1.0
     */

    /**
         * Redirect to a file to start the download
         * @package Woocommerce
         * @subpackage Fruity Ocean
         * @since Fruity Ocean 1.0
         *
         * @param  string $file_path
         * @param  string $filename
         */
        function woocommerce_download_file_redirect( $file_path, $filename = '' ) {
        /* Override begin here --- */
        #   $query_param = '?download_file='.$download_data->product_id.'&order='.$download_data->order_key.'&email='.$download_data->user_email.'&key='.$download_data->download_id.'&id='.$download_data->order_id;
            $product_id    = absint( $_GET['download_file'] );
            $_product      = wc_get_product( $product_id );
            $download_data = self::get_download_data( array(
                'product_id'  => $product_id,
                'order_key'   => wc_clean( $_GET['order'] ),
                'email'       => sanitize_email( str_replace( ' ', '+', $_GET['email'] ) ),
                'download_id' => wc_clean( isset( $_GET['key'] ) ? preg_replace( '/\s+/', ' ', $_GET['key'] ) : '' )
            ) );
        
            // dlf  -> download_file (product_id)
            // m    -> email (user_email) // mail
            // o    -> order (order_key)
            // k    -> key (download_id)
            // i    -> id (order_id)
            // x    -> secret // md5(i|k|o|dlf)
            $secret = md5( $download_data->order_id .'|'. $download_data->download_id .'|'. $download_data->order_key .'|'. $download_data->product_id );
            $query_param = '?dlf='.$download_data->product_id.'&m='.$download_data->user_email.'&o='.$download_data->order_key.'&k='.$download_data->download_id.'&i='.$download_data->order_id.'&x='.$secret;
            unset($secret);

            header( 'Location: ' . $file_path . $query_param );
            // FROM     http://caribaea.org/fr/?download_file=297&order=wc_order_562d6c7828354&email=contact@web-medias.com&key=0a5fbf0b4aacd16aa448cde1292ac71d
            // TO       http://caribaea.org/fr/?dlf=297&o=wc_order_562d6c7828354&m=contactweb-medias.com&k=0a5fbf0b4aacd16aa448cde1292ac71d&x=[md5(i|k|o|dlf)]
            // Note : email is sanitized (@ was removed). ? to check!
        /* Override end here --- */
        #   header( 'Location: ' . $file_path );
            exit;
        }

        /**
         *  
         * 
         * @package WordPress
         * @subpackage Fruity Ocean
         * @since Fruity Ocean 1.0
         */
        function get_flyr( $billing_cmd_number, $order_date, $flyer_img_url, $increment=null ){ 

            $barcode_security_hey_phrase = 'Web-Medias.com'; // Key
            $barcode_content_stamp = dechex('CMD_').$billing_cmd_number; // Billing Number

            $dst_w = 960;
            $dst_h = 290;
            $src_w = 407;
            $src_h = 30;
            $dst_x = $dst_w-$src_w;
            $dst_y = $dst_h-$src_h;
            $pct = 100;




            // Barcode image

            list($cd['Y'], $cd['m'], $cd['d'], $cd['H'], $cd['i'], $cd['s']) =  explode('*', str_replace(' ','*', str_replace(':','*', str_replace('-','*', $order_date) ) ) );
            $order_product_date = $cd['d'] . $cd['m'] . $cd['Y'] . $cd['H'] . $cd['i'] . $cd['s'];

            $barcode_imgurl_file = 'S-TWM-'.$order_product_date.'-'.str_pad($billing_cmd_number, 5, "0", STR_PAD_LEFT).'S'.str_pad($increment, 3, "0", STR_PAD_LEFT).'0S';
            $barcode_linear_text = '* TWM '.$order_product_date.'#'.str_pad($billing_cmd_number, 5, "0", STR_PAD_LEFT).'*'.str_pad($increment, 3, "0", STR_PAD_LEFT).' *';

            //echo do_shortcode( '[barcode text='.$barcode_linear_text.' type=code128 height='.$src_h.' width=1 transparency=1 output=image]' );
            $barcode_img_url = do_shortcode( '[barcode text="'.$barcode_linear_text.'" type=code128 height='.$src_h.' width=1 transparency=1 output=file]' );
            $src_im = esc_attr($barcode_img_url);

            $dst_im = esc_attr($flyer_img_url);

            //echo $dst_im;
            //echo $src_im;
            
            $dest = imagecreatefrompng($dst_im); // flyer image resource object
            $src = imagecreatefrompng($src_im); // barcode resource object

            $uploads = wp_upload_dir();
            $filename = $barcode_imgurl_file.'.png';

            imagealphablending($dest, false);
            imagesavealpha($dest, true);
            imagealphablending($src, true);


            $cut = imagecreatetruecolor($src_w, $src_h); // creating a cut resource 

            imagecopy($cut, $dest, 0, 0, $dst_x, $dst_y, $src_w, $src_h); // copying relevant section from background to the cut resource 
            imagecopy($cut, $src, 0, 0, $src_x, $src_y, $src_w, $src_h); // copying relevant section from watermark to the cut resource 
            
            imagecopymerge($dest, $cut, $dst_x, $dst_y, 0, 0, $src_w, $src_h, $pct); // insert cut resource to destination image 

            //header('Content-Type: image/png');
            // Save image to WP Upload directory
            imagepng($dest, $uploads['basedir'].'/'.$filename);

            imagedestroy($dest);
            imagedestroy($src);
            imagedestroy($cut);

            return array( 'filename' => $filename, 'image_url' => $uploads['baseurl'].'/'.$filename , 'gencode'=>$barcode_linear_text);

        }







    /**
     * Ajax Section
     * 
     * Manage ajax transaction between server side and client requests.
     *
     * @package WordPress
     * @subpackage Fruity Ocean
     * @since Fruity Ocean 1.0
     */

        /**
         * Media Gallery Section
         * 
         * @package WordPress
         * @subpackage Fruity Ocean
         * @since Fruity Ocean 1.0
         */

        add_action("wp_ajax_show_medias_gallery_section", "show_medias_gallery_section");
        add_action("wp_ajax_nopriv_show_medias_gallery_section", "show_medias_gallery_section");

        function show_medias_gallery_section() {

            if( $_POST['gallery_id'] != ''){
                if( function_exists('cyclone_slider') ){
                    

                    // Ensure this slider exists...
                    // Be careful ! The following code is issued of Cyclone Plugin (from Data.php for the custom type naming...)
                    $defaults = array(
                        'post_type' => 'cycloneslider',
                        'name' => trim($_POST['gallery_id']),
                        'numberposts' => 1 // Get all
                    );
                    $args = wp_parse_args(array(), $defaults);
                    
                    $slider_posts = get_posts( $args ); // Use get_posts to avoid filters


                    if( !empty($slider_posts) and is_array($slider_posts) ){

                        echo '<div class="post-content" id="recipient-medias-gallery">';
                        cyclone_slider( ''.$_POST['gallery_id'].'' );
                        echo '</div>';

                    }else{

                        echo '<div class="post-content" id="recipient-medias-gallery">';
                        echo '<p class="no-medias-gallery empty"></p>';
                        echo '</div>';

                    }


                }
            }

        }







    /**
     * Event ICS microformat generating
     * 
     * This Class allows to generate an ics miroformat.
     *
     * @package WordPress
     * @subpackage Fruity Ocean
     * @since Fruity Ocean 1.0
     *
     *
     *  Description
     *
     * This program is free software: you can redistribute it and/or modify it under the terms 
     * of the GNU General Public License as published by the Free Software Foundation, either 
     * version 3 of the License, or (at your option) any later version.
     * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; 
     * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
     * See the GNU General Public License for more details.
     * You should have received a copy of the GNU General Public License along with this program.
     * If not, see <http://www.gnu.org/licenses/>.
     * Furkan Mustafa, 2015.04.06
     * - Updated 2015.04.09: Limit lines to 70 chars (spec is 75)
     * - Updated 2015.04.26: duplicate letter fixed by @PGallagher69 (Peter Gallagher)
     * - Updated 2015.04.26: Outtlook Invite fixed by @PGallagher69 (Peter Gallagher)
     * - Updated 2015.05.02: Line-limit bug fixed by @waddyvic (Victor Huang)
     * Adapted from: https://gist.github.com/jakebellacera/635416
     * Also see: https://www.ietf.org/rfc/rfc5545.txt
     * Development Sponsored by 77hz KK, Tokyo, http://77hz.jp
     *
     *  Usage
     * $cal = new SimpleICS();
     * // $cal->productString = '-//77hz/iFLYER API//';
     *
     * $cal->addEvent(function($e) use ($data) {
     *     $e->startDate = new DateTime( $data['the_start_date'] );
     *     $e->endDate = new DateTime( "2015-04-06T18:30:00+09:00" );
     *     $e->uri = 'http://url.to/my/event';
     *     $e->location = 'Tokyo, Event Location';
     *     $e->description = 'ICS Entertainment';
     *     $e->summary = $data['event_title'];
     * });
     * $cal->addEvent(function($e) {
     *     $e->startDate = new DateTime("2015-04-06T10:00:00+09:00");
     *     $e->endDate = new DateTime("2015-04-06T18:30:00+09:00");
     *     $e->uri = 'http://url.to/my/event';
     *     $e->location = 'Tokyo, Event Location';
     *     $e->description = 'ICS Entertainment';
     *     $e->summary = 'Lorem ipsum dolor ics amet, lorem ipsum dolor ics amet, lorem ipsum dolor ics amet, lorem ipsum dolor ics amet';
     * });
     * header('Content-Type: '.SimpleICS::MIME_TYPE);
     * if (isset($_GET['download'])) {
     *     header('Content-Disposition: attachment; filename=event.ics');
     * }
     * echo $cal->serialize();
     *
     */

        /**
         * Class SimpleICS (master constructor)
         * Class SimpleICS_Event (event logic code)
         * Trait SimpleICS_Util (fontions package in use)
         * Templates
         * 
         * @package WordPress
         * @subpackage Fruity Ocean
         * @since Fruity Ocean 1.0
         */
        class SimpleICS {
            use SimpleICS_Util;
            const MIME_TYPE = 'text/calendar; charset=utf-8';
            
            var $events = [];
            var $productString = '-//hacksw/handcal//NONSGML v1.0//EN';
            static $Template = null;
            function addEvent($eventOrClosure) {
                if (is_object($eventOrClosure) && ($eventOrClosure instanceof Closure)) {
                    $event = new SimpleICS_Event();
                    $eventOrClosure($event);
                }
                $this->events[] = $event;
                return $event;
            }
            function serialize() {
                return $this->filter_linelimit($this->render(self::$Template, $this));
            }
        }

        class SimpleICS_Event {
            use SimpleICS_Util;
            var $uniqueId;
            var $startDate;
            var $endDate;
            var $dateStamp;
            var $location;
            var $description;
            var $uri;
            var $summary;
            static $Template;
            function __construct() {
                $this->uniqueId = uniqid();
            }
            function serialize() {
                return $this->render(self::$Template, $this);
            }
        }

        trait SimpleICS_Util {
            function filter_linelimit($input, $lineLimit = 70) {
                // go through each line and make them shorter.
                $output = '';
                $line = '';
                $pos = 0;
                while ($pos < strlen($input)) {
                    // find the newline
                    $newLinepos = strpos($input, "\n", $pos + 1);
                    if (!$newLinepos)
                        $newLinepos = strlen($input);
                    $line = substr($input, $pos, $newLinepos - $pos);
                    if (strlen($line) <= $lineLimit) {
                        $output .= $line;
                    } else {
                        // First line cut-off limit is $lineLimit
                        $output .= substr($line, 0, $lineLimit);
                        $line = substr($line, $lineLimit);
                        
                        // Subsequent line cut-off limit is $lineLimit - 1 due to the leading white space
                        $output .= "\n " . substr($line, 0, $lineLimit - 1);
                        
                        while (strlen($line) > $lineLimit - 1){
                            $line = substr($line, $lineLimit - 1);
                            $output .= "\n " . substr($line, 0, $lineLimit - 1);
                        }
                    }
                    $pos = $newLinepos;
                }
                return $output;
            }
            function filter_calDate($input) {
                if (!is_a($input, 'DateTime'))
                    $input = new DateTime($input);
                else
                    $input = clone $input;
                $input->setTimezone(new DateTimeZone('UTC'));
                return $input->format('Ymd\THis\Z');
            }
            function filter_serialize($input) {
                if (is_object($input)) {
                    return $input->serialize();
                }
                if (is_array($input)) {
                    $output = '';
                    array_walk($input, function($item) use (&$output) {
                        $output .= $this->filter_serialize($item);
                    });
                    return trim($output, "\r\n");
                }
                return $input;
            }
            function filter_quote($input) {
                return quoted_printable_encode($input);
            }
            function filter_escape($input) {
                $input = preg_replace('/([\,;])/','\\\$1', $input);
                $input = str_replace("\n", "\\n", $input);
                $input = str_replace("\r", "\\r", $input);
                return $input;
            }
            function render($tpl, $scope) {
                while (preg_match("/\{\{([^\|\}]+)((?:\|([^\|\}]+))+)?\}\}/", $tpl, $m)) {
                    $replace = $m[0];
                    $varname = $m[1];
                    $filters = isset($m[2]) ? explode('|', trim($m[2], '|')) : [];
                    $value = $this->fetch_var($scope, $varname);
                    $self = &$this;
                    array_walk($filters, function(&$item) use (&$value, $self) {
                        $item = trim($item, "\t\r\n ");
                        if (!is_callable([ $self, 'filter_' . $item ]))
                            throw new Exception('No such filter: ' . $item);
                        $value = call_user_func_array([ $self, 'filter_' . $item ], [ $value ]);
                    });
                    $tpl = str_replace($m[0], $value, $tpl);
                }
                return $tpl;
            }
            function fetch_var($scope, $var) {
                if (strpos($var, '.')!==false) {
                    $split = explode('.', $var);
                    $var = array_shift($split);
                    $rest = implode('.', $split);
                    $val = $this->fetch_var($scope, $var);
                    return $this->fetch_var($val, $rest);
                }
                if (is_object($scope)) {
                    $getterMethod = 'get' . ucfirst($var);
                    if (method_exists($scope, $getterMethod)) {
                        return $scope->{$getterMethod}();
                    }
                    return $scope->{$var};
                }
                if (is_array($scope))
                    return $scope[$var];
                throw new Exception('A strange scope');
            }
        }
        SimpleICS::$Template = <<<EOT
BEGIN:VCALENDAR
VERSION:2.0
PRODID:{{productString}}
METHOD:PUBLISH
CALSCALE:GREGORIAN
{{events|serialize}}
END:VCALENDAR
EOT;
        
        SimpleICS_Event::$Template = <<<EOT
BEGIN:VEVENT
UID:{{uniqueId}}
DTSTART:{{startDate|calDate}}
DTSTAMP:{{dateStamp|calDate}}
DTEND:{{endDate|calDate}}
LOCATION:{{location|escape}}
DESCRIPTION:{{description|escape}}
URL;VALUE=URI:{{uri|escape}}
SUMMARY:{{summary|escape}}
END:VEVENT
EOT;
        // Event ICS microformat generating


?>