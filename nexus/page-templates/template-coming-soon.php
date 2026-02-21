<?php
/**
 * Template Name: Coming Soon
 * Template Post Type: page
 *
 * Full-screen coming-soon page with countdown timer.
 * Header/footer hidden. Uses page content for headline and description.
 *
 * @package Nexus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Launch date from page meta or Customizer.
$nexus_launch_date = get_post_meta( get_the_ID(), '_nexus_launch_date', true );
if ( empty( $nexus_launch_date ) ) {
	$nexus_launch_date = nexus_option( 'coming_soon_date', gmdate( 'Y-m-d', strtotime( '+30 days' ) ) );
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php wp_title( '|', true, 'right' ); ?><?php bloginfo( 'name' ); ?></title>
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'nexus-template-coming-soon' ); ?>>
<?php wp_body_open(); ?>

<div class="nexus-coming-soon" id="nexus-coming-soon" style="background-image: url(<?php echo esc_url( nexus_option( 'coming_soon_bg', get_template_directory_uri() . '/assets/img/coming-soon-bg.jpg' ) ); ?>);">

	<div class="nexus-coming-soon__overlay"></div>

	<div class="nexus-coming-soon__inner">

		<!-- Logo -->
		<div class="nexus-coming-soon__logo">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<span class="nexus-coming-soon__site-name"><?php bloginfo( 'name' ); ?></span>
			<?php endif; ?>
		</div>

		<!-- Content -->
		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<h1 class="nexus-coming-soon__headline">
				<?php the_title(); ?>
			</h1>
			<?php if ( get_the_content() ) : ?>
				<div class="nexus-coming-soon__desc">
					<?php the_content(); ?>
				</div>
			<?php endif; ?>
		<?php endwhile; ?>

		<!-- Countdown -->
		<div class="nexus-coming-soon__countdown" id="nexus-countdown" aria-label="<?php esc_attr_e( 'Countdown to launch', 'nexus' ); ?>" data-launch="<?php echo esc_attr( $nexus_launch_date ); ?>">
			<div class="nexus-coming-soon__unit">
				<span class="nexus-coming-soon__number" id="countdown-days">00</span>
				<span class="nexus-coming-soon__label"><?php esc_html_e( 'Days', 'nexus' ); ?></span>
			</div>
			<div class="nexus-coming-soon__separator" aria-hidden="true">:</div>
			<div class="nexus-coming-soon__unit">
				<span class="nexus-coming-soon__number" id="countdown-hours">00</span>
				<span class="nexus-coming-soon__label"><?php esc_html_e( 'Hours', 'nexus' ); ?></span>
			</div>
			<div class="nexus-coming-soon__separator" aria-hidden="true">:</div>
			<div class="nexus-coming-soon__unit">
				<span class="nexus-coming-soon__number" id="countdown-mins">00</span>
				<span class="nexus-coming-soon__label"><?php esc_html_e( 'Minutes', 'nexus' ); ?></span>
			</div>
			<div class="nexus-coming-soon__separator" aria-hidden="true">:</div>
			<div class="nexus-coming-soon__unit">
				<span class="nexus-coming-soon__number" id="countdown-secs">00</span>
				<span class="nexus-coming-soon__label"><?php esc_html_e( 'Seconds', 'nexus' ); ?></span>
			</div>
		</div>

		<!-- Notify form -->
		<?php
		$nexus_show_form = nexus_option( 'coming_soon_show_form', 'yes' );
		if ( 'yes' === $nexus_show_form ) :
			?>
		<div class="nexus-coming-soon__notify">
			<p class="nexus-coming-soon__notify-text"><?php esc_html_e( 'Get notified when we launch.', 'nexus' ); ?></p>
			<form class="nexus-coming-soon__form" method="post" novalidate>
				<div class="nexus-coming-soon__form-row">
					<label for="notify-email" class="screen-reader-text"><?php esc_html_e( 'Email address', 'nexus' ); ?></label>
					<input
						type="email"
						id="notify-email"
						name="notify_email"
						placeholder="<?php esc_attr_e( 'Enter your email…', 'nexus' ); ?>"
						required
						autocomplete="email"
					>
					<button type="submit" class="nexus-btn nexus-btn--primary">
						<?php esc_html_e( 'Notify Me', 'nexus' ); ?>
					</button>
				</div>
				<?php wp_nonce_field( 'nexus_notify', 'nexus_notify_nonce' ); ?>
			</form>
		</div>
		<?php endif; ?>

		<!-- Social links -->
		<?php
		$nexus_socials     = array(
			'facebook'  => nexus_option( 'social_facebook', '' ),
			'twitter'   => nexus_option( 'social_twitter', '' ),
			'instagram' => nexus_option( 'social_instagram', '' ),
			'linkedin'  => nexus_option( 'social_linkedin', '' ),
		);
		$nexus_has_socials = array_filter( $nexus_socials );
		if ( $nexus_has_socials ) :
			?>
		<div class="nexus-coming-soon__social">
			<?php foreach ( $nexus_socials as $nexus_network => $nexus_url ) : ?>
				<?php if ( $nexus_url ) : ?>
					<a href="<?php echo esc_url( $nexus_url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( ucfirst( $nexus_network ) ); ?>">
						<i class="ri ri-<?php echo esc_attr( $network ); ?>-fill" aria-hidden="true"></i>
					</a>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
		<?php endif; ?>

	</div><!-- .nexus-coming-soon__inner -->

</div><!-- .nexus-coming-soon -->

<script>
( function () {
	var el     = document.getElementById( 'nexus-countdown' );
	if ( ! el ) return;

	var launch = new Date( el.dataset.launch ).getTime();
	var dEl    = document.getElementById( 'countdown-days' );
	var hEl    = document.getElementById( 'countdown-hours' );
	var mEl    = document.getElementById( 'countdown-mins' );
	var sEl    = document.getElementById( 'countdown-secs' );

	function pad( n ) { return n < 10 ? '0' + n : String( n ); }

	function tick() {
		var diff = launch - Date.now();
		if ( diff <= 0 ) {
			dEl.textContent = hEl.textContent = mEl.textContent = sEl.textContent = '00';
			return;
		}
		var secs   = Math.floor( diff / 1000 );
		var days   = Math.floor( secs / 86400 );
		var hours  = Math.floor( ( secs % 86400 ) / 3600 );
		var mins   = Math.floor( ( secs % 3600 ) / 60 );
		var sec    = secs % 60;

		dEl.textContent = pad( days );
		hEl.textContent = pad( hours );
		mEl.textContent = pad( mins );
		sEl.textContent = pad( sec );
	}

	tick();
	setInterval( tick, 1000 );
} )();
</script>

<?php wp_footer(); ?>
</body>
</html>
