<?php
// Ensure cart contents update when products are added to the cart via AJAX
add_filter( 'woocommerce_add_to_cart_fragments', 'avant_wc_header_add_to_cart_fragment' );
 
function avant_wc_header_add_to_cart_fragment( $fragments ) {
    global $woocommerce;
    
    ob_start(); ?>
        <a class="header-cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'avant' ); ?>">
            <span class="header-cart-amount">
                <?php echo sprintf( _n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'avant' ), WC()->cart->get_cart_contents_count() ); ?><span> - <?php echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?></span>
            </span>
            <span class="header-cart-checkout <?php echo ( WC()->cart->get_cart_contents_count() > 0 ) ? sanitize_html_class( 'cart-has-items' ) : ''; ?>">
                <i class="fa <?php echo ( get_theme_mod( 'avant-cart-icon' ) ) ? sanitize_html_class( get_theme_mod( 'avant-cart-icon' ) ) : sanitize_html_class( 'fa-shopping-cart' ); ?>"></i>
            </span>
        </a>
    <?php
    $fragments['a.header-cart-contents'] = ob_get_clean();
    
    return $fragments;
}