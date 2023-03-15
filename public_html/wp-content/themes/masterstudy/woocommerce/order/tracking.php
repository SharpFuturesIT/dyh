<?php
/**
 * Order tracking
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/tracking.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; /* Exit if accessed directly */
}

$order_status_text = sprintf( __( 'Order #%1$s which was made %2$s has the status &ldquo;%3$s&rdquo;', 'masterstudy' ), $order->get_order_number(), human_time_diff( strtotime( $order->order_date ), current_time( 'timestamp' ) ) . ' ' . __( 'ago', 'masterstudy' ), wc_get_order_status_name( $order->get_status() ) );

if ( $order->has_status( 'completed' ) ) {
	$order_status_text .= ' ' . __( 'and was completed', 'masterstudy' ) . ' ' . human_time_diff( strtotime( $order->completed_date ), current_time( 'timestamp' ) ) . __( ' ago', 'masterstudy' );
}

$order_status_text .= '.';

echo wp_kses_post( wpautop( esc_attr( apply_filters( 'woocommerce_order_tracking_status', $order_status_text, $order ) ) ) );

$notes = $order->get_customer_order_notes();

if ( $notes ) : ?>
	<h2><?php esc_html_e( 'Order updates', 'masterstudy' ); ?></h2>
	<ol class="commentlist notes">
		<?php foreach ( $notes as $note ) : ?>
		<li class="comment note">
			<div class="comment_container">
				<div class="comment-text">
					<p class="meta"><?php echo esc_html( date_i18n( 'l jS \o\f F Y, h:ia', strtotime( $note->comment_date ) ) ); ?></p>
					<div class="description">
						<?php echo wp_kses_post( wpautop( wptexturize( $note->comment_content ) ) ); ?>
					</div>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
			</div>
		</li>
		<?php endforeach; ?>
	</ol>
<?php endif; ?>

<?php do_action( 'woocommerce_view_order', $order->get_id() ); ?>