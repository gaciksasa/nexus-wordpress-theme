<?php
/**
 * Title: Hero - Business
 * Slug: nexus/hero-business
 * Categories: nexus-heroes
 * Keywords: hero, business, corporate, header, banner
 * Description: A bold hero section for business/corporate websites.
 * Viewport Width: 1280
 *
 * @package Nexus
 */

?>
<!-- wp:cover {"url":"<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/placeholder.png","dimRatio":60,"minHeight":700,"minHeightUnit":"px","isDark":true,"align":"full","className":"nexus-hero nexus-hero--business"} -->
<div class="wp-block-cover alignfull is-light nexus-hero nexus-hero--business" style="min-height:700px">
	<span aria-hidden="true" class="wp-block-cover__background has-background-dim-60 has-background-dim"></span>
	<div class="wp-block-cover__inner-container">

		<!-- wp:group {"className":"nexus-container","layout":{"type":"constrained","contentSize":"760px"}} -->
		<div class="wp-block-group nexus-container">

			<!-- wp:paragraph {"className":"nexus-hero__tagline","style":{"color":{"text":"#e94560"},"typography":{"fontWeight":"600","textTransform":"uppercase","letterSpacing":"3px"}}} -->
			<p class="wp-block-paragraph nexus-hero__tagline has-text-color" style="color:#e94560;font-weight:600;text-transform:uppercase;letter-spacing:3px"><?php esc_html_e( 'Welcome to Nexus', 'nexus' ); ?></p>
			<!-- /wp:paragraph -->

			<!-- wp:heading {"level":1,"className":"nexus-hero__title","textColor":"white","style":{"typography":{"fontSize":"clamp(2.5rem, 6vw, 4rem)","lineHeight":"1.1","fontWeight":"800"}}} -->
			<h1 class="wp-block-heading nexus-hero__title has-white-color has-text-color" style="font-size:clamp(2.5rem, 6vw, 4rem);line-height:1.1;font-weight:800"><?php esc_html_e( 'We Build Digital Experiences That Matter', 'nexus' ); ?></h1>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"className":"nexus-hero__subtitle","textColor":"white","style":{"typography":{"fontSize":"1.2rem"},"color":{"text":"rgba(255,255,255,0.85)"}}} -->
			<p class="wp-block-paragraph nexus-hero__subtitle has-white-color has-text-color" style="font-size:1.2rem"><?php esc_html_e( 'A premium multi-purpose WordPress theme crafted for businesses that want to stand out. Fast, flexible, and fully customizable.', 'nexus' ); ?></p>
			<!-- /wp:paragraph -->

			<!-- wp:buttons {"className":"nexus-hero__actions","layout":{"type":"flex","flexWrap":"nowrap"}} -->
			<div class="wp-block-buttons nexus-hero__actions">
				<!-- wp:button {"className":"nexus-btn nexus-btn--primary"} -->
				<div class="wp-block-button nexus-btn nexus-btn--primary">
					<a class="wp-block-button__link wp-element-button" href="#"><?php esc_html_e( 'Get Started', 'nexus' ); ?></a>
				</div>
				<!-- /wp:button -->

				<!-- wp:button {"className":"nexus-btn nexus-btn--outline-white"} -->
				<div class="wp-block-button nexus-btn nexus-btn--outline-white">
					<a class="wp-block-button__link wp-element-button" href="#"><?php esc_html_e( 'Learn More', 'nexus' ); ?></a>
				</div>
				<!-- /wp:button -->
			</div>
			<!-- /wp:buttons -->

		</div>
		<!-- /wp:group -->

	</div>
</div>
<!-- /wp:cover -->
