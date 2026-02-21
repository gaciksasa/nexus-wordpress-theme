<?php
/**
 * Nexus Theme - Elementor Product Carousel Widget
 *
 * WooCommerce product carousel with Swiper.js.
 * Only loaded when WooCommerce is active.
 *
 * @package Nexus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

/**
 * Class Nexus_Widget_Product_Carousel
 */
class Nexus_Widget_Product_Carousel extends \Elementor\Widget_Base {

	public function get_name() {
		return 'nexus-product-carousel';
	}

	public function get_title() {
		return esc_html__( 'Product Carousel', 'nexus' );
	}

	public function get_icon() {
		return 'eicon-woocommerce';
	}

	public function get_categories() {
		return array( 'nexus-woocommerce' );
	}

	public function get_keywords() {
		return array( 'product', 'carousel', 'woocommerce', 'shop', 'slider', 'nexus' );
	}

	public function get_script_depends() {
		return array( 'nexus-swiper' );
	}

	public function get_style_depends() {
		return array( 'nexus-swiper' );
	}

	protected function register_controls() {

		// ---------------------------------------------------------------
		// CONTENT: Query
		// ---------------------------------------------------------------
		$this->start_controls_section(
			'section_query',
			array( 'label' => esc_html__( 'Products', 'nexus' ) )
		);

		$this->add_control(
			'query_type',
			array(
				'label'   => esc_html__( 'Show', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'recent',
				'options' => array(
					'recent'     => esc_html__( 'Recent Products', 'nexus' ),
					'featured'   => esc_html__( 'Featured Products', 'nexus' ),
					'sale'       => esc_html__( 'On Sale', 'nexus' ),
					'bestseller' => esc_html__( 'Best Sellers', 'nexus' ),
					'category'   => esc_html__( 'By Category', 'nexus' ),
					'ids'        => esc_html__( 'Manual IDs', 'nexus' ),
				),
			)
		);

		$this->add_control(
			'category_ids',
			array(
				'label'       => esc_html__( 'Categories', 'nexus' ),
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'multiple'    => true,
				'options'     => $this->get_product_categories(),
				'label_block' => true,
				'condition'   => array( 'query_type' => 'category' ),
			)
		);

		$this->add_control(
			'product_ids',
			array(
				'label'       => esc_html__( 'Product IDs', 'nexus' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'placeholder' => '1, 2, 3',
				'condition'   => array( 'query_type' => 'ids' ),
			)
		);

		$this->add_control(
			'posts_per_page',
			array(
				'label'   => esc_html__( 'Products to Show', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 8,
				'min'     => 2,
				'max'     => 40,
			)
		);

		$this->add_control(
			'orderby',
			array(
				'label'   => esc_html__( 'Order By', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'date',
				'options' => array(
					'date'       => esc_html__( 'Date', 'nexus' ),
					'title'      => esc_html__( 'Title', 'nexus' ),
					'price'      => esc_html__( 'Price', 'nexus' ),
					'popularity' => esc_html__( 'Popularity', 'nexus' ),
					'rating'     => esc_html__( 'Rating', 'nexus' ),
					'rand'       => esc_html__( 'Random', 'nexus' ),
				),
			)
		);

		$this->end_controls_section();

		// ---------------------------------------------------------------
		// CONTENT: Carousel
		// ---------------------------------------------------------------
		$this->start_controls_section(
			'section_carousel',
			array( 'label' => esc_html__( 'Carousel', 'nexus' ) )
		);

		$this->add_responsive_control(
			'slides_per_view',
			array(
				'label'          => esc_html__( 'Products per Row', 'nexus' ),
				'type'           => \Elementor\Controls_Manager::NUMBER,
				'default'        => 4,
				'tablet_default' => 2,
				'mobile_default' => 2,
				'min'            => 1,
				'max'            => 6,
			)
		);

		$this->add_control(
			'space_between',
			array(
				'label'   => esc_html__( 'Space Between (px)', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 24,
				'min'     => 0,
				'max'     => 60,
			)
		);

		$this->add_control(
			'autoplay',
			array(
				'label'   => esc_html__( 'Autoplay', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => '',
			)
		);

		$this->add_control(
			'autoplay_speed',
			array(
				'label'     => esc_html__( 'Autoplay Delay (ms)', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'default'   => 3500,
				'condition' => array( 'autoplay' => 'yes' ),
			)
		);

		$this->add_control(
			'loop',
			array(
				'label'   => esc_html__( 'Loop', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$this->add_control(
			'show_dots',
			array(
				'label'   => esc_html__( 'Show Dots', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => '',
			)
		);

		$this->add_control(
			'show_arrows',
			array(
				'label'   => esc_html__( 'Show Arrows', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$this->end_controls_section();

		// ---------------------------------------------------------------
		// CONTENT: Card
		// ---------------------------------------------------------------
		$this->start_controls_section(
			'section_card',
			array( 'label' => esc_html__( 'Product Card', 'nexus' ) )
		);

		$this->add_control(
			'show_badge',
			array(
				'label'   => esc_html__( 'Show Sale/New Badge', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$this->add_control(
			'show_rating',
			array(
				'label'   => esc_html__( 'Show Rating', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$this->add_control(
			'show_cart_btn',
			array(
				'label'   => esc_html__( 'Show Add to Cart', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$this->add_control(
			'show_wishlist',
			array(
				'label'   => esc_html__( 'Show Wishlist Button', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => '',
			)
		);

		$this->end_controls_section();

		// ---------------------------------------------------------------
		// STYLE
		// ---------------------------------------------------------------
		$this->start_controls_section(
			'section_style',
			array(
				'label' => esc_html__( 'Card Style', 'nexus' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			array(
				'name'     => 'card_bg',
				'selector' => '{{WRAPPER}} .nexus-product-card',
			)
		);

		$this->add_control(
			'card_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'nexus' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .nexus-product-card' => 'border-radius: {{SIZE}}{{UNIT}}; overflow: hidden;',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'card_shadow',
				'selector' => '{{WRAPPER}} .nexus-product-card',
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Product Title Color', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .nexus-product-card__title a' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'price_color',
			array(
				'label'     => esc_html__( 'Price Color', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .nexus-product-card__price .price' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings  = $this->get_settings_for_display();
		$widget_id = 'nexus-products-' . $this->get_id();
		$arrows    = 'yes' === $settings['show_arrows'];
		$dots      = 'yes' === $settings['show_dots'];
		$loop      = 'yes' === $settings['loop'] ? 'true' : 'false';
		$spv       = absint( $settings['slides_per_view'] ?? 4 );
		$gap       = absint( $settings['space_between'] ?? 24 );

		// Build query.
		$args = array(
			'post_type'      => 'product',
			'posts_per_page' => absint( $settings['posts_per_page'] ),
			'orderby'        => sanitize_key( $settings['orderby'] ),
			'order'          => 'ASC' === ( $settings['order'] ?? 'DESC' ) ? 'ASC' : 'DESC',
			'post_status'    => 'publish',
		);

		switch ( $settings['query_type'] ) {
			case 'featured':
				$args['tax_query'] = array(
					array(
						'taxonomy' => 'product_visibility',
						'field'    => 'name',
						'terms'    => 'featured',
					),
				);
				break;
			case 'sale':
				$args['post__in'] = wc_get_product_ids_on_sale();
				break;
			case 'bestseller':
				$args['orderby']  = 'meta_value_num';
				$args['meta_key'] = 'total_sales'; // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
				break;
			case 'category':
				if ( ! empty( $settings['category_ids'] ) ) {
					$args['tax_query'] = array(
						array(
							'taxonomy' => 'product_cat',
							'field'    => 'term_id',
							'terms'    => array_map( 'absint', $settings['category_ids'] ),
						),
					);
				}
				break;
			case 'ids':
				if ( ! empty( $settings['product_ids'] ) ) {
					$args['post__in'] = array_map( 'absint', explode( ',', $settings['product_ids'] ) );
					$args['orderby']  = 'post__in';
				}
				break;
		}

		$query = new WP_Query( $args );

		if ( ! $query->have_posts() ) {
			return;
		}
		?>

		<div class="nexus-product-carousel swiper" id="<?php echo esc_attr( $widget_id ); ?>">
			<div class="swiper-wrapper">

				<?php
				while ( $query->have_posts() ) :
					$query->the_post();
					?>
					<?php
					global $product; // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound -- WooCommerce global.
					$product = wc_get_product( get_the_ID() ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
					if ( ! $product ) {
						continue;
					}
					$show_badge  = 'yes' === $settings['show_badge'];
					$show_rating = 'yes' === $settings['show_rating'];
					$show_cart   = 'yes' === $settings['show_cart_btn'];
					?>

					<div class="swiper-slide">
						<div class="nexus-product-card">

							<div class="nexus-product-card__thumb">
								<a href="<?php the_permalink(); ?>">
									<?php if ( has_post_thumbnail() ) : ?>
										<?php the_post_thumbnail( 'woocommerce_thumbnail', array( 'loading' => 'lazy' ) ); ?>
									<?php else : ?>
										<img src="<?php echo esc_url( wc_placeholder_img_src() ); ?>" alt="<?php esc_attr_e( 'Product placeholder', 'nexus' ); ?>" loading="lazy">
									<?php endif; ?>
								</a>

								<?php if ( $show_badge ) : ?>
									<?php if ( $product->is_on_sale() ) : ?>
										<span class="nexus-product-card__badge nexus-product-card__badge--sale"><?php esc_html_e( 'Sale', 'nexus' ); ?></span>
									<?php elseif ( $product->is_featured() ) : ?>
										<span class="nexus-product-card__badge nexus-product-card__badge--featured"><?php esc_html_e( 'Hot', 'nexus' ); ?></span>
									<?php endif; ?>
								<?php endif; ?>

								<?php if ( $show_cart ) : ?>
									<div class="nexus-product-card__actions">
										<?php woocommerce_template_loop_add_to_cart(); ?>
									</div>
								<?php endif; ?>
							</div><!-- .nexus-product-card__thumb -->

							<div class="nexus-product-card__body">
								<h3 class="nexus-product-card__title">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</h3>

								<?php if ( $show_rating ) : ?>
									<div class="nexus-product-card__rating">
										<?php woocommerce_template_loop_rating(); ?>
									</div>
								<?php endif; ?>

								<div class="nexus-product-card__price">
									<?php echo $product->get_price_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								</div>
							</div>

						</div><!-- .nexus-product-card -->
					</div><!-- .swiper-slide -->

					<?php
				endwhile;
				wp_reset_postdata();
				?>

			</div><!-- .swiper-wrapper -->

			<?php if ( $dots ) : ?>
				<div class="swiper-pagination nexus-product-carousel__dots"></div>
			<?php endif; ?>

			<?php if ( $arrows ) : ?>
				<button class="swiper-button-prev nexus-product-carousel__prev" aria-label="<?php esc_attr_e( 'Previous products', 'nexus' ); ?>"></button>
				<button class="swiper-button-next nexus-product-carousel__next" aria-label="<?php esc_attr_e( 'Next products', 'nexus' ); ?>"></button>
			<?php endif; ?>

		</div><!-- .nexus-product-carousel -->

		<script>
		document.addEventListener( 'DOMContentLoaded', function () {
			if ( ! window.Swiper ) return;
			var autoplayOpt = <?php echo 'yes' === $settings['autoplay'] ? '{ delay: ' . absint( $settings['autoplay_speed'] ) . ', disableOnInteraction: false }' : 'false'; ?>;
			new Swiper( '#<?php echo esc_js( $widget_id ); ?>', {
				slidesPerView: <?php echo esc_js( $spv ); ?>,
				spaceBetween:  <?php echo esc_js( $gap ); ?>,
				loop:          <?php echo esc_js( $loop ); ?> === 'true',
				autoplay:      autoplayOpt,
				pagination:    <?php echo $dots ? '{ el: \'.swiper-pagination\', clickable: true }' : 'false'; ?>,
				navigation:    <?php echo $arrows ? '{ nextEl: \'.swiper-button-next\', prevEl: \'.swiper-button-prev\' }' : 'false'; ?>,
				breakpoints: {
					0:   { slidesPerView: 2, spaceBetween: 16 },
					576: { slidesPerView: 2, spaceBetween: <?php echo esc_js( $gap ); ?> },
					768: { slidesPerView: 3, spaceBetween: <?php echo esc_js( $gap ); ?> },
					992: { slidesPerView: <?php echo esc_js( $spv ); ?>, spaceBetween: <?php echo esc_js( $gap ); ?> },
				},
			} );
		} );
		</script>
		<?php
	}

	private function get_product_categories() {
		$opts  = array();
		$terms = get_terms(
			array(
				'taxonomy'   => 'product_cat',
				'hide_empty' => true,
			)
		);
		if ( $terms && ! is_wp_error( $terms ) ) {
			foreach ( $terms as $term ) {
				$opts[ $term->term_id ] = $term->name;
			}
		}
		return $opts;
	}
}
