<?php
/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! $product->is_purchasable() ) {
  return;
}

echo wc_get_stock_html( $product ); // WPCS: XSS ok.

if ( $product->is_in_stock() ) : ?>

  <?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

  <form class="cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>
    <?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

     


    <?php

    function get_custom_field($ptype){

      

      $flavourDropdown = '<select class="'.$ptype.'" name="'.$ptype.'">';
      if($ptype=="flavour"){
          $flavourDropdown .= '<option value="" selected>Please Select Flavour</option>';
      }
      else if($ptype=="pizza_size"){
          $flavourDropdown .= '<option value="" selected>Please Select Size</option>';
      }

      $args = array(
        "post_type" => $ptype,
      );

      $posts_data = get_posts($args);




      foreach ($posts_data as $key => $value) {

        if($value->ID){
          $title = $value->post_title;
          $price = get_field("price",$value->ID);
          $flavourDropdown .='<option value="'.$title.'-'.$price.'" >'.$title.'</option>';


        }

        

        
      }
      $flavourDropdown .= '</select>';


      return  $flavourDropdown;
    }

?>

    
     <div class="adon cheese">

          <div class="col-md-1 optlabel">
              Cheese
          </div>

          <div class="col-md-3 opt">

              <span>-</span>
              <span><input type="text" value=""></span>
              <span>+</span>

          </div>


     </div>
    

<?php


    function get_adons($ptype){


        if(!empty($ptype)){

          $required = array(
            "post_type" => $ptype
          );


          $adons = get_posts($required);

          $html = '';

          foreach ($adons as $key => $value) {
            
            if(!empty($value)){

                $label = $value->post_title;

                $lname = strtolower(str_replace(" ","_",$label));

                

                $price = get_field("price",$value->ID);


                $html .= '<div class="adon '.$label.' ">';
                $html .= '<div class="col-md-3 optlabel">'.$label.'-  Rs.'.'<b class="lprice">'.$price.'</b></div>';
                $html .= '<div class="col-md-6 opt right"><span class="dec">-</span><span class="unit-value" ><input class="qty adon" type="text" value="0" data="'.$price.'" name="'.$lname.'" readonly >
                </span><span class="inc">+</span><input class="adon-price" type="hidden" value="'.$price.'"  name="'.$lname.'_price" readonly ></div>';
                $html .= '</div>';


            }

          }

          return $html;

        }

        return '';

    }




    // function get_adons($ptype){

    //   if(!empty($ptype)){

    //     $arguments = array(
    //       "post_type"=>$ptype
    //     );


    //     $adons = get_posts($arguments);

    //     $html = '';

    //     foreach ($adons as $key => $value) {



    //         $label = $value->post_title;
    //         $price = get_field("price",$value->ID);

    //         //wrapper div
    //         $html .= '<div class="adon '.$label.'" >';
            
    //         //child div for label
    //         $html .= '<div class="col-md-1 optlabel">'.$label;
    //         $html .= '</div>';

    //         //child div for value
    //         $html .= '<div class="col-md-3 opt">';
            
    //         $html .='<div class="controls">
    //                 <span>-<span>
    //                 <span><input type="text" name="quantity" value="'.$value.'" /></span>
    //                 <span>+</span>
    //                 </div>';

    //         $html .= '</div>';

    //         //wrapper closing
    //         $html .= '</div>'; 

    //         print_r($label);
    //         print_r($price);
    //         exit;
    //     }

    //     echo "<pre>";
    //     print_r($adons);
    //     exit;
    //   }
    // }

    

    $arg1 = "Flavours";    
    $arg2 = "label";
    $arg3 = "flavour";

      

      

      //<option value="supreme-150" >Supermem </option>
      
    
    
    $flavourLabelValue = apply_filters( 'change_flvaour_label', $arg1, $arg2 ,$arg3 );
    ?>
    <div class="pizza-form-wrapper">
        <div class="flavour">
          <div class="col-md-1 optlabel">
            <label><?php echo $flavourLabelValue; ?></label>
          </div>
      <div class="col-md-2 opt">
        <?php echo get_custom_field("flavour"); ?>
     </div>
     <div class="fprice">
        <span class="fprice" data="0"></span>
     </div>
      </div>
      <div class="sizes">

        <div class="col-md-1 optlabel">
          <label>Sizes</label>
        </div>
        
       <div class="col-md-2 opt"> 
         <?php echo get_custom_field("pizza_size"); ?>
      </div>
      <div class="sprice">
          <span class="sprice" data="0"></span>
      </div>
      </div>
      <div class="ad-ons">
          <?php echo  get_adons("pizza_addons"); ?>
      </div>
      <div class="total-wrapper">
        <label>Total - </label>
        <span class="tprice"></span>
      </div>
    </div>
    <?php
    
    do_action( 'woocommerce_before_add_to_cart_quantity' );

    woocommerce_quantity_input(
      array(
        'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
        'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
        'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
      )
    );

    do_action( 'woocommerce_after_add_to_cart_quantity' );
    ?>


    <button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" class="single_add_to_cart_button button alt" onclick="checkValidation();"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>

    <?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
  </form>

  <?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

<?php endif; ?>

<script type="text/javascript">

  jQuery(document).ready(function(){


    $('span.inc').click(function(){
       var lastValue =  $(this).prev().children().val();
       if(lastValue){
         $(this).prev().children().val(++lastValue);
          calculateTotal();
       }
    });


    $('span.dec').click(function(){
       var lastValue =  $(this).next().children().val();
       if(lastValue > 0){
         $(this).next().children().val(--lastValue);
         calculateTotal();
       }
    });


    jQuery("select.flavour").change(function(){
           var optValue = jQuery(this).val();
           splitValue = optValue.split("-");
           jQuery('span.fprice').text("$"+splitValue[1]);
           jQuery('span.fprice').attr("data",splitValue[1]);
           calculateTotal();
    });


    jQuery("select.pizza_size").change(function(){
           var optValue = jQuery(this).val();
           splitValue = optValue.split("-");
           jQuery('span.sprice').text("$"+splitValue[1]);
           jQuery('span.sprice').attr("data",splitValue[1]);
           calculateTotal();
    });

  });

  function calculateTotal(){
    var fprice = $("span.fprice").attr("data"); 
    var sprice = $("span.sprice").attr("data"); 


    var sumOfAdon = 0
    $("input.qty.adon").each(function(index,element){
        var  dataValue = $(element).attr("data");
        var  value = $(element).val();
        sumOfAdon += parseInt(dataValue) * parseInt(value); 

    });

    var total = parseInt(fprice) + parseInt(sprice) + sumOfAdon;

    $("span.tprice").text("$"+total);
  }

  function checkValidation(){
    // var fval = jQuery("select.flavour").val();
    // var sval = jQuery("select.pizza_size").val();
    // if(!(fval && sval)){
        
    //     event.preventDefault();
    //     alert("Please select flavour & size of pizza");
    // }
  }

</script>
