<?php
/**
 * Nexus Theme - Elementor Testimonials Widget
 *
 * Testimonials carousel/grid with Swiper.js.
 *
 * @package Nexus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Nexus_Widget_Testimonials
 */
class Nexus_Widget_Testimonials extends \Elementor\Widget_Base {

	public function get_name() {
		return 'nexus-testimonials';
	}

	public function get_title() {
		return esc_html__( 'Testimonials', 'nexus' );
	}

	public function get_icon() {
		return 'eicon-testimonial-carousel';
	}

	public function get_categories() {
		return array( 'nexus-elements' );
	}

	public function get_keywords() {
		return array( 'testimonial', 'review', 'quote', 'carousel', 'slider', 'nexus' );
	}

	public function get_script_depends() {
		return array( 'nexus-swiper' );
	}

	public function get_style_depends() {
		return array( 'nexus-swiper' );
	}

	protected function register_controls() {

		// ---------------------------------------------------------------
		// CONTENT: Items
		// ---------------------------------------------------------------
		$this->start_controls_section(
			'section_items',
			array( 'label' => esc_html__( 'Testimonials', 'nexus' ) )
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'author_image',
			array(
				'label'   => esc_html__( 'Author Image', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'default' => array( 'url' => \Elementor\Utils::get_placeholder_image_src() ),
			)
		);

		$repeater->add_control(
			'author_name',
			array(
				'label'   => esc_html__( 'Name', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'John Smith', 'nexus' ),
				'dynamic' => array( 'active' => true ),
			)
		);

		$repeater->add_control(
			'author_position',
			array(
				'label'   => esc_html__( 'Position / Company', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'CEO at Company', 'nexus' ),
				'dynamic' => array( 'active' => true ),
			)
		);

		$repeater->add_control(
			'rating',
			array(
				'label'   => esc_html__( 'Rating (1–5)', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 5,
				'min'     => 1,
				'max'     => 5,
			)
		);

		$repeater->add_control(
			'content',
			array(
				'label'   => esc_html__( 'Testimonial', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'rows'    => 5,
				'default' => esc_html__( 'Working with this team was an absolute pleasure. The results exceeded our expectations and delivered real business value.', 'nexus' ),
				'dynamic' => array( 'active' => true ),
			)
		);

		$this->add_control(
			'testimonials',
			array(
				'label'       => esc_html__( 'Testimonials', 'nexus' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'author_name'     => esc_html__( 'Sarah Johnson', 'nexus' ),
						'author_position' => esc_html__( 'Marketing Director', 'nexus' ),
						'rating'          => 5,
						'content'         => esc_html__( 'Exceptional work from start to finish. Highly recommend to anyone looking for quality and professionalism.', 'nexus' ),
					),
					array(
						'author_name'     => esc_html__( 'Michael Chen', 'nexus' ),
						'author_position' => esc_html__( 'Product Manager', 'nexus' ),
						'rating'          => 5,
						'content'         => esc_html__( 'The attention to detail and commitment to excellence is evident in every aspect of the deliverables.', 'nexus' ),
					),
					array(
						'author_name'     => esc_html__( 'Emma Williams', 'nexus' ),
						'author_position' => esc_html__( 'Founder & CEO', 'nexus' ),
						'rating'          => 5,
						'content'         => esc_html__( 'Outstanding results and excellent communication throughout the whole project. Would definitely work again.', 'nexus' ),
					),
				),
				'title_field' => '{{{ author_name }}}',
			)
		);

		$this->end_controls_section();

		// ---------------------------------------------------------------
		// CONTENT: Settings
		// ---------------------------------------------------------------
		$this->start_controls_section(
			'section_settings',
			array( 'label' => esc_html__( 'Settings', 'nexus' ) )
		);

		$this->add_control(
			'layout',
			array(
				'label'   => esc_html__( 'Layout', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'slider',
				'options' => array(
					'slider' => esc_html__( 'Slider', 'nexus' ),
					'grid'   => esc_html__( 'Grid', 'nexus' ),
				),
			)
		);

		$this->add_responsive_control(
			'slides_per_view',
			array(
				'label'          => esc_html__( 'Items per View', 'nexus' ),
				'type'           => \Elementor\Controls_Manager::NUMBER,
				'default'        => 2,
				'tablet_default' => 1,
				'mobile_default' => 1,
				'min'            => 1,
				'max'            => 4,
				'condition'      => array( 'layout' => 'slider' ),
			)
		);

		$this->add_control(
			'autoplay',
			array(
				'label'     => esc_html__( 'Autoplay', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => array( 'layout' => 'slider' ),
			)
		);

		$this->add_control(
			'autoplay_speed',
			array(
				'label'     => esc_html__( 'Autoplay Delay (ms)', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'default'   => 4000,
				'condition' => array(
					'layout'   => 'slider',
					'autoplay' => 'yes',
				),
			)
		);

		$this->add_control(
			'show_dots',
			array(
				'label'     => esc_html__( 'Show Dots', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => array( 'layout' => 'slider' ),
			)
		);

		$this->add_control(
			'show_arrows',
			array(
				'label'     => esc_html__( 'Show Arrows', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'default'   => '',
				'condition' => array( 'layout' => 'slider' ),
			)
		);

		$this->add_responsive_control(
			'grid_columns',
			array(
				'label'          => esc_html__( 'Columns', 'nexus' ),
				'type'           => \Elementor\Controls_Manager::SELECT,
				'default'        => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options'        => array(
					'2' => '2',
					'3' => '3',
					'4' => '4',
				),
				'condition'      => array( 'layout' => 'grid' ),
				'selectors'      => array(
					'{{WRAPPER}} .nexus-testimonials-grid' => '--nexus-testimonials-cols: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'show_rating',
			array(
				'label'   => esc_html__( 'Show Rating Stars', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$this->add_control(
			'show_image',
			array(
				'label'   => esc_html__( 'Show Author Image', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$this->add_control(
			'quote_icon',
			array(
				'label'   => esc_html__( 'Show Quote Icon', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$this->end_controls_section();

		// ---------------------------------------------------------------
		// STYLE: Card
		// ---------------------------------------------------------------
		$this->start_controls_section(
			'section_style_card',
			array(
				'label' => esc_html__( 'Card', 'nexus' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			array(
				'name'     => 'card_bg',
				'selector' => '{{WRAPPER}} .nexus-testimonial-card',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'card_border',
				'selector' => '{{WRAPPER}} .nexus-testimonial-card',
			)
		);

		$this->add_control(
			'card_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'nexus' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .nexus-testimonial-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'card_shadow',
				'selector' => '{{WRAPPER}} .nexus-testimonial-card',
			)
		);

		$this->add_responsive_control(
			'card_padding',
			array(
				'label'      => esc_html__( 'Padding', 'nexus' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .nexus-testimonial-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		// ---------------------------------------------------------------
		// STYLE: Text
		// ---------------------------------------------------------------
		$this->start_controls_section(
			'section_style_text',
			array(
				'label' => esc_html__( 'Text', 'nexus' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'content_typography',
				'label'    => esc_html__( 'Content Typography', 'nexus' ),
				'selector' => '{{WRAPPER}} .nexus-testimonial-card__text',
			)
		);

		$this->add_control(
			'content_color',
			array(
				'label'     => esc_html__( 'Content Color', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .nexus-testimonial-card__text' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'name_color',
			array(
				'label'     => esc_html__( 'Author Name Color', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .nexus-testimonial-card__name' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'position_color',
			array(
				'label'     => esc_html__( 'Position Color', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .nexus-testimonial-card__position' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'star_color',
			array(
				'label'     => esc_html__( 'Star Color', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#f5a623',
				'selectors' => array(
					'{{WRAPPER}} .nexus-testimonial-card__star' => 'color: {{VALUE}};',
				),
				'condition' => array( 'show_rating' => 'yes' ),
			)
		);

		$this->add_control(
			'quote_color',
			array(
				'label'     => esc_html__( 'Quote Icon Color', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .nexus-testimonial-card__quote' => 'color: {{VALUE}};',
				),
				'condition' => array( 'quote_icon' => 'yes' ),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings    = $this->get_settings_for_display();
		$items       = $settings['testimonials'];
		$widget_id   = 'nexus-testimonials-' . $this->get_id();
		$layout      = $settings['layout'] ?? 'slider';
		$show_rating = 'yes' === $settings['show_rating'];
		$show_image  = 'yes' === $settings['show_image'];
		$show_quote  = 'yes' === $settings['quote_icon'];
		$dots        = 'yes' === $settings['show_dots'];
		$arrows      = 'yes' === $settings['show_arrows'];
		$spv         = absint( $settings['slides_per_view'] ?? 2 );

		if ( empty( $items ) ) {
			return;
		}

		$wrapper_class = 'nexus-testimonials';
		if ( 'slider' === $layout ) {
			$wrapper_class .= ' nexus-testimonials--slider swiper';
		} else {
			$wrapper_class .= ' nexus-testimonials-grid';
		}

		$inner_class = 'slider' === $layout ? 'swiper-wrapper' : 'nexus-testimonials-grid__inner';
		$item_class  = 'slider' === $layout ? 'swiper-slide' : '';
		?>

		<div class="<?php echo esc_attr( $wrapper_class ); ?>" id="<?php echo esc_attr( $widget_id ); ?>">
			<div class="<?php echo esc_attr( $inner_class ); ?>">

				<?php foreach ( $items as $item ) : ?>
					<div class="nexus-testimonial-card <?php echo esc_attr( $item_class ); ?>">

						<?php if ( $show_quote ) : ?>
							<div class="nexus-testimonial-card__quote" aria-hidden="true">&#8220;</div>
						<?php endif; ?>

						<?php if ( $show_rating && ! empty( $item['rating'] ) ) : ?>
							<div class="nexus-testimonial-card__stars" aria-label="<?php /* translators: %d: rating number 1 to 5. */ echo esc_attr( sprintf( __( '%d out of 5 stars', 'nexus' ), absint( $item['rating'] ) ) ); ?>">
								<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
									<span class="nexus-testimonial-card__star<?php echo $i <= absint( $item['rating'] ) ? '' : ' is-empty'; ?>" aria-hidden="true">&#9733;</span>
								<?php endfor; ?>
							</div>
						<?php endif; ?>

						<?php if ( $item['content'] ) : ?>
							<p class="nexus-testimonial-card__text"><?php echo wp_kses_post( $item['content'] ); ?></p>
						<?php endif; ?>

						<div class="nexus-testimonial-card__author">
							<?php if ( $show_image && ! empty( $item['author_image']['url'] ) ) : ?>
								<div class="nexus-testimonial-card__avatar">
									<img
										src="<?php echo esc_url( $item['author_image']['url'] ); ?>"
										alt="<?php echo esc_attr( $item['author_name'] ); ?>"
										loading="lazy"
									>
								</div>
							<?php endif; ?>

							<div class="nexus-testimonial-card__info">
								<?php if ( $item['author_name'] ) : ?>
									<span class="nexus-testimonial-card__name"><?php echo esc_html( $item['author_name'] ); ?></span>
								<?php endif; ?>
								<?php if ( $item['author_position'] ) : ?>
									<span class="nexus-testimonial-card__position"><?php echo esc_html( $item['author_position'] ); ?></span>
								<?php endif; ?>
							</div>
						</div>

					</div><!-- .nexus-testimonial-card -->
				<?php endforeach; ?>

			</div><!-- inner -->

			<?php if ( 'slider' === $layout ) : ?>
				<?php if ( $dots ) : ?>
					<div class="swiper-pagination nexus-testimonials__dots"></div>
				<?php endif; ?>
				<?php if ( $arrows ) : ?>
					<button class="swiper-button-prev nexus-testimonials__prev" aria-label="<?php esc_attr_e( 'Previous', 'nexus' ); ?>"></button>
					<button class="swiper-button-next nexus-testimonials__next" aria-label="<?php esc_attr_e( 'Next', 'nexus' ); ?>"></button>
				<?php endif; ?>
			<?php endif; ?>

		</div>

		<?php if ( 'slider' === $layout ) : ?>
		<script>
		document.addEventListener( 'DOMContentLoaded', function () {
			if ( ! window.Swiper ) return;
			var autoplayOpt = <?php echo 'yes' === $settings['autoplay'] ? '{ delay: ' . absint( $settings['autoplay_speed'] ) . ', disableOnInteraction: false }' : 'false'; ?>;
			new Swiper( '#<?php echo esc_js( $widget_id ); ?>', {
				slidesPerView: <?php echo esc_js( $spv ); ?>,
				spaceBetween:  24,
				loop:          true,
				autoplay:      autoplayOpt,
				pagination:    <?php echo $dots ? '{ el: \'.swiper-pagination\', clickable: true }' : 'false'; ?>,
				navigation:    <?php echo $arrows ? '{ nextEl: \'.swiper-button-next\', prevEl: \'.swiper-button-prev\' }' : 'false'; ?>,
				breakpoints: {
					0:   { slidesPerView: 1 },
					768: { slidesPerView: <?php echo esc_js( min( 2, $spv ) ); ?> },
					992: { slidesPerView: <?php echo esc_js( $spv ); ?> },
				},
			} );
		} );
		</script>
		<?php endif; ?>
		<?php
	}
}
