<?php 

/**
 * The template for displaying full width pages.
 *
 * Template Name: Thank You Page
 *
 * @package storefront
 */

 

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
            
			<?php
			while ( have_posts() ) :
				the_post();

				do_action( 'storefront_page_before' );

				get_template_part( 'content', 'page' );

				/**
				 * Functions hooked in to storefront_page_after action
				 *
				 * @hooked storefront_display_comments - 10
				 */
				do_action( 'storefront_page_after' );

			endwhile; // End of the loop.
			?>


            <?php

                if(!empty($_GET["order_id"])){

                    $order_id = $_GET["order_id"];

                    $order = wc_get_order($order_id);

                    $order_data = $order->get_data();



                    echo "<pre>";
                    print_r($order_data);
                    exit;

                }

            
            
            ?>


		</main><!-- #main -->
	</div><!-- #primary -->

<?php
do_action( 'storefront_sidebar' );
get_footer();

?>