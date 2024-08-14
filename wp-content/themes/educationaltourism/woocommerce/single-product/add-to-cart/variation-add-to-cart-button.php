<?php
/**
 * Single variation cart button
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

global $product;
?>
<div class="woocommerce-variation-add-to-cart variations_button" id="course">
	<?php  do_action( 'woocommerce_before_add_to_cart_button' ); ?>

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
    <?php if (isset($_GET['cart']) && $_GET['cart'] == 1 && !isset($_GET['acco'])) { ?>
        <button type="button" class="single_add_to_cart_button button alt next-step-button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" style="margin-right: 15px;"> Next </button>
    <?php } ?>

    <?php if (isset($_GET['cart']) && $_GET['cart'] == 1 && isset($_GET['acco']) && $_GET['acco'] == 1) { ?>
	    <button type="submit" class="single_add_to_cart_button button alt<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>
    <?php } ?>

	<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

	<input type="hidden" name="add-to-cart" value="<?php echo absint( $product->get_id() ); ?>" />
	<input type="hidden" name="product_id" value="<?php echo absint( $product->get_id() ); ?>" />
	<input type="hidden" name="variation_id" class="variation_id" value="0" />
</div>
<br><br>


<div class="woocommerce-variation-add-to-cart variations_button" id="accomodations" >
    

</div>

<script type="text/javascript">
    jQuery(document).ready(function($){
        $('.next-step-button').on('click', function(e) {
            e.preventDefault();
            $thisbutton = $(this);
            var form = $('form.cart');
            var productID = form.find('input[name="add-to-cart"]').val();
            var variationID = form.find('input[name="variation_id"]').val() || 0;
            var quantity = form.find('input[name="quantity"]').val() || 1;
            var cart_data = {
                action: 'ql_woocommerce_ajax_add_to_cart',
                product_id: productID,
                variation_id: variationID,
                quantity: quantity,
            };
            $.ajax({
                type: 'POST',
                url: wc_add_to_cart_params.ajax_url,
                data: cart_data,
                success: function(response) {
                    if (response.error) {
                        // Handle error
                        alert('Error adding product to cart.');
                    } else {
                        $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $thisbutton]);
                        // ajax call - accomodation
                        // Add a new variable to the current URL without reloading the page
                        var newParam = 'acco=1';
                        var currentUrl = window.location.href;
                        var newUrl = currentUrl.includes('?') ? currentUrl + '&' + newParam : currentUrl + '?' + newParam;
                        window.history.replaceState(null, null, newUrl);
                        window.location.reload();
                        console.log('Parameter added to URL:', newUrl);

                    }
                }
            });
        });
    });
</script>