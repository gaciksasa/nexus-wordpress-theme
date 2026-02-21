<?php
/**
 * Title: Services Grid
 * Slug: nexus/services-grid
 * Categories: nexus-sections
 * Keywords: services, features, cards, grid, icons
 * Description: A three-column services/features section with icons.
 * Viewport Width: 1280
 *
 * @package Nexus
 */

?>
<!-- wp:group {"className":"nexus-section nexus-services","layout":{"type":"constrained"}} -->
<div class="wp-block-group nexus-section nexus-services">

	<!-- wp:group {"className":"nexus-section__header nexus-container","layout":{"type":"constrained","contentSize":"600px"},"style":{"spacing":{"margin":{"bottom":"3rem"}}}} -->
	<div class="wp-block-group nexus-section__header nexus-container">

		<!-- wp:paragraph {"className":"nexus-section__subtitle","textAlign":"center","style":{"color":{"text":"#e94560"},"typography":{"fontWeight":"600","textTransform":"uppercase","letterSpacing":"2px","fontSize":"0.875rem"}}} -->
		<p class="wp-block-paragraph nexus-section__subtitle has-text-align-center has-text-color" style="color:#e94560;font-weight:600;text-transform:uppercase;letter-spacing:2px;font-size:0.875rem"><?php esc_html_e( 'What We Offer', 'nexus' ); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:heading {"level":2,"textAlign":"center","className":"nexus-section__title"} -->
		<h2 class="wp-block-heading nexus-section__title has-text-align-center"><?php esc_html_e( 'Our Services', 'nexus' ); ?></h2>
		<!-- /wp:heading -->

		<!-- wp:paragraph {"textAlign":"center","className":"nexus-section__desc"} -->
		<p class="wp-block-paragraph nexus-section__desc has-text-align-center"><?php esc_html_e( 'We offer a comprehensive range of services designed to help your business grow and thrive in the digital landscape.', 'nexus' ); ?></p>
		<!-- /wp:paragraph -->

	</div>
	<!-- /wp:group -->

	<!-- wp:columns {"className":"nexus-container nexus-services__grid","style":{"spacing":{"blockGap":{"top":"2rem","left":"2rem"}}}} -->
	<div class="wp-block-columns nexus-container nexus-services__grid">

		<!-- wp:column {"className":"nexus-service-card"} -->
		<div class="wp-block-column nexus-service-card">
			<!-- wp:group {"className":"nexus-service-card__inner","layout":{"type":"default"}} -->
			<div class="wp-block-group nexus-service-card__inner">
				<!-- wp:paragraph {"className":"nexus-service-card__icon","style":{"typography":{"fontSize":"2.5rem"}}} -->
				<p class="wp-block-paragraph nexus-service-card__icon" style="font-size:2.5rem">🎨</p>
				<!-- /wp:paragraph -->
				<!-- wp:heading {"level":3,"className":"nexus-service-card__title","style":{"typography":{"fontSize":"1.25rem","fontWeight":"600"}}} -->
				<h3 class="wp-block-heading nexus-service-card__title"><?php esc_html_e( 'Web Design', 'nexus' ); ?></h3>
				<!-- /wp:heading -->
				<!-- wp:paragraph {"className":"nexus-service-card__desc"} -->
				<p class="wp-block-paragraph nexus-service-card__desc"><?php esc_html_e( 'Beautiful, conversion-focused designs that make your brand stand out from the competition.', 'nexus' ); ?></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"className":"nexus-service-card"} -->
		<div class="wp-block-column nexus-service-card">
			<!-- wp:group {"className":"nexus-service-card__inner","layout":{"type":"default"}} -->
			<div class="wp-block-group nexus-service-card__inner">
				<!-- wp:paragraph {"className":"nexus-service-card__icon","style":{"typography":{"fontSize":"2.5rem"}}} -->
				<p class="wp-block-paragraph nexus-service-card__icon" style="font-size:2.5rem">💻</p>
				<!-- /wp:paragraph -->
				<!-- wp:heading {"level":3,"className":"nexus-service-card__title","style":{"typography":{"fontSize":"1.25rem","fontWeight":"600"}}} -->
				<h3 class="wp-block-heading nexus-service-card__title"><?php esc_html_e( 'Development', 'nexus' ); ?></h3>
				<!-- /wp:heading -->
				<!-- wp:paragraph {"className":"nexus-service-card__desc"} -->
				<p class="wp-block-paragraph nexus-service-card__desc"><?php esc_html_e( 'Custom WordPress development tailored to your specific business needs and objectives.', 'nexus' ); ?></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"className":"nexus-service-card"} -->
		<div class="wp-block-column nexus-service-card">
			<!-- wp:group {"className":"nexus-service-card__inner","layout":{"type":"default"}} -->
			<div class="wp-block-group nexus-service-card__inner">
				<!-- wp:paragraph {"className":"nexus-service-card__icon","style":{"typography":{"fontSize":"2.5rem"}}} -->
				<p class="wp-block-paragraph nexus-service-card__icon" style="font-size:2.5rem">📈</p>
				<!-- /wp:paragraph -->
				<!-- wp:heading {"level":3,"className":"nexus-service-card__title","style":{"typography":{"fontSize":"1.25rem","fontWeight":"600"}}} -->
				<h3 class="wp-block-heading nexus-service-card__title"><?php esc_html_e( 'Marketing', 'nexus' ); ?></h3>
				<!-- /wp:heading -->
				<!-- wp:paragraph {"className":"nexus-service-card__desc"} -->
				<p class="wp-block-paragraph nexus-service-card__desc"><?php esc_html_e( 'Data-driven marketing strategies that drive traffic, increase conversions, and grow revenue.', 'nexus' ); ?></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->

	</div>
	<!-- /wp:columns -->

</div>
<!-- /wp:group -->
