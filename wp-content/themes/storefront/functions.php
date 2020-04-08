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

	if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '3.0.0', '>=' ) ) {
		require 'inc/nux/class-storefront-nux-starter-content.php';
	}
}

/**
 * Note: Do not add any custom code here. Please use a custom plugin so that your customizations aren't lost during updates.
 * https://github.com/woocommerce/theme-customisations
 */



function please_change_flavour_label($data1,$data2,$data3){
   if($data2=="label" && $data3=="flavour"){
     $newlabel = '<span>New Flavours</span>'; 
     print_r('something');
     return $newlabel;
   }
}

add_filter('change_flvaour_label','please_change_flavour_label',9,3);


function change_my_img_html($html,$post_thumbnail_id){

  $url = get_the_post_thumbnail_url();

  $explodedUrl = explode('.', $url);
  $explodedUrl = $explodedUrl[0].'-100x100.'.$explodedUrl[1];
  


  $html = '<div class="lightbox_image">
    <div data-thumb="'.$explodedUrl.'" data-thumb-alt="" class="woocommerce-product-gallery__image">
        <a href="'.$url.'" data-lightbox="pizza" data-title="My caption" >
           <img width="259" height="194" src="'.$url.'" class="wp-post-image" alt="" title="pizza" data-caption="" data-src="'.$url.'" data-large_image="'.$url.'" data-large_image_width="259" data-large_image_height="194">
        </a>
  </div>
  </div>
  ';
  return $html;
 
}
add_filter('woocommerce_single_product_image_thumbnail_html','change_my_img_html',10,2);




//new code
//
//
//
function calculate_price_from_api($cart_object) {
  // print_r($cart_object);
  // exit;

  // print_r('A');
  // exit;


}
// add_action('woocommerce_before_calculate_totals', 'calculate_price_from_api', 10, 2);

function add_children_adult_to_cart($cart_item_data, $product_id) {
  echo "<pre>";
  print_r($cart_item_data);
  print_r("inside fn B");
  print_r($_POST);
  // exit;
  
  print_r('B');
  // exit;

  if(empty($cart_item_data)){
    return array("flavour" => "fagita");
  }
  return $cart;
}
 //add_filter('woocommerce_add_cart_item_data', 'add_children_adult_to_cart', 1, 10);

function wdm_get_cart_items_from_session($item, $values, $key) {
  print_r('C');
  exit;
}
// add_action('woocommerce_add_order_item_meta', 'wdm_add_values_to_order_item_meta', 1, 2);

function wdm_add_values_to_order_item_meta($item_id, $values) {
  print_r('D');
  exit;
 }

// add_action('woocommerce_add_order_item_meta', 'wdm_add_values_to_order_item_meta', 1, 2);


function validate_price($post_type,$name,$user_selected_price){
  $price = 0;


  $query = new WP_Query( 
            array( 
            'post_type' => $post_type,
            'post_status' => array('publish')
             )
        );

  foreach($query->posts as $key=> $val){

      if($val->post_title == $name){
         $id = $val->ID;
         $price = get_field("price", $id);
         break;
      }
  }

  if($price != $user_selected_price)
  {

    

    return false;
  }

  

  return true;






}

function validation_of_add_to_cart($passed, $product_id, $quantity) {
  // $passed = true;
  // print_r('waqas');
  // echo "<pre>";
  // print_r($_POST);
  // exit;

  $flavour = explode("-",$_POST["flavour"]) ;
  $pizza_size = explode("-",$_POST["pizza_size"]);
  $olives = explode("-",$_POST["olives_10g"]);
  $mushrooms = explode("-",$_POST["mushrooms_10g"]);
  
  $passed = validate_price("flavour",$flavour[0],$flavour[1]);
  // if($passed == false ) return $passed;
  // $passed = validate_price("pizza_size",$pizza_size[0],$pizza_size[1]);
  // if($passed == false ) return $passed;
  // $passed = validate_price("flavour",$flavour[0],$flavour[1]);
  // if($passed == false ) return $passed;
  // $passed = validate_price("flavour",$flavour[0],$flavour[1]);
  // if($passed == false ) return $passed;
  

return $passed;
}

 add_filter('woocommerce_add_to_cart_validation', 'validation_of_add_to_cart', 10, 3);



function adding_custom_data_to_cart_item( $cart_item_data, $product_id, $variation_id, $quantity){

  // echo "<pre>";
  // print_r($_POST);
  $cart_item_data["pizza_info"] = array();

  if($product_id == 30){

    foreach ($_POST as $key => $value) {

      $cart_item_data["pizza_info"][$key] = $value;
    }

  }
  
  
  return $cart_item_data;
  // exit;

}

 add_filter('woocommerce_add_cart_item_data','adding_custom_data_to_cart_item',10,4);



function get_data_from_cart_item($item_data, $cart_item){


  // echo "<pre>";
  // print_r($cart_item);
  // exit;

  if(!empty($cart_item['pizza_info'])){

    foreach ($cart_item['pizza_info'] as $key => $value) {
      $item = array(
                'key'   => $key,
                'value' => $value
            );
      array_push($item_data,$item);
      
    }
     
       

     return $item_data;

    // return 
  }

  return $item_data;
  // echo "<pre>";
  // var_dump($item_data);
  // print_r($cart_item);
  // exit;
}

 add_filter('woocommerce_get_item_data','get_data_from_cart_item',10,2);



function add_custom_data_to_line_item($item, $cart_item_key, $values, $order ){


  if($values["pizza_info"]){

    foreach ($values["pizza_info"] as $key => $value) {
      $item->add_meta_data($key,$value);
    }
  }
  return ;




}


 add_action("woocommerce_checkout_create_order_line_item","add_custom_data_to_line_item",10,4);

 // function validation_of_add_to_cart_2(){


 // }
 // add_filter('woocommerce_add_to_cart_validation', 'validation_of_add_to_cart_2', 11, 3);




// function get_custom_prices($post_type,$post_title){

//   $query = new WP_Query( array( 'post_type' => $post_type ) );

//   foreach ($query->posts as $key => $value) {

//     if($value->post_title==$flavour[0]){

//         $id = $value->ID;
//         $prices["flavour"] =  get_field("price",$id);  
//         break;

//       }
     
    
//   }

  
// }












//add_action('woocommerce_before_main_content','mera_kaam_krwa_do1',10);
//add_action('woocommerce_before_main_content','mera_kaam_krwa_do2');
//add_action('woocommerce_before_main_content','mera_kaam_krwa_do3',9);

//add_filter('woocommerce_before_main_content','mera_kaam_krwa_do')

function change_my_date_format($arg2,$arg3,$arg4){
  if($arg4 == "today"){
    return ' from filter '.date("d-M-Y");
  }
  
}

add_filter('change_date_format','change_my_date_format',10,3);   


    

// //mera_kaam_krwa_do();
// function mera_kaam_krwa_do(){
//   print_r("i have created this function and i can call it from anywhere");
//   exit;
// }


// function my_callback(){
//   echo "this is my action which was already defined by someone else, i just hooked it";
// }
// add_action('woocommerce_after_main_content','my_callback');


// function page_thankyou( $order_received, $obj ){

//   print($obj);
//   exit;
//   $order_received = "https://google.com";
//   return $order_received;

// }


// add_filter("woocommerce_get_checkout_order_received_url","page-thankyou",10,2);



add_action( 'woocommerce_thankyou', 'bbloomer_redirectcustom');
  
function bbloomer_redirectcustom( $order_id ){
    // $order = wc_get_order( $order_id );

    

    // print_r($order);
    // exit;
    $url = 'http://localhost/custom-pizza/thank-you/?order_id='.$order_id;
    if ( ! $order->has_status( 'failed' ) ) {
        wp_safe_redirect( $url );
        exit;
    }
}

function custom_total_calculation($obj){

  if(!empty($obj->cart_contents)){

    $cart_contents = $obj->cart_contents;

    foreach($cart_contents as $key => $value){
      

      if($value["pizza_info"]){
        $flavour_price = explode("-",$value["pizza_info"]["flavour"])[1];
        $size_price = explode("-",$value["pizza_info"]["pizza_size"])[1];

        $addon_array = array(
            "olives_10g",
            "mushrooms_10g",
            "regular_drink",
            "cheese"
        );

        $sum = 0;

        foreach($addon_array as $addonkey => $addonVal){
           $qty = $value["pizza_info"][$addonVal];
           $price = $value["pizza_info"][$addonVal."_price"];
           $sum = $sum + (int)($qty * $price);
        }

        $sub_total = $flavour_price + $size_price + $sum;

        $total = $value["quantity"] * $sub_total;

        $value["data"]->set_price($total);  

      }


      
    }

    // echo "<pre>";
    // print_r($car_contents);
    // exit;
  }


}

add_action('woocommerce_before_calculate_totals','custom_total_calculation',10,1);



















































