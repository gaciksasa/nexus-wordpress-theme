<?php
/**
 * Nexus Theme - Elementor Hero Slider Widget
 *
 * Full-width hero slider with Swiper.js integration.
 *
 * @package Nexus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Nexus_Widget_Hero_Slider
 */
class Nexus_Widget_Hero_Slider extends \Elementor\Widget_Base {

	public function get_name() {
		return 'nexus-hero-slider';
	}

	public function get_title() {
		return esc_html__( 'Hero Slider', 'nexus' );
	}

	public function get_icon() {
		return 'eicon-slides';
	}

	public function get_categories() {
		return array( 'nexus-elements' );
	}

	public function get_keywords() {
		return array( 'hero', 'slider', 'carousel', 'banner', 'nexus' );
	}

	public function get_script_depends() {
		return array( 'nexus-swiper' );
	}

	public function get_style_depends() {
		return array( 'nexus-swiper' );
	}

	protected function register_controls() {

		// ---------------------------------------------------------------
		// CONTENT: Slides Repeater
		// ---------------------------------------------------------------
		$this->start_controls_section(
			'section_slides',
			array( 'label' => esc_html__( 'Slides', 'nexus' ) )
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'slide_bg',
			array(
				'label'   => esc_html__( 'Background Image', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'default' => array( 'url' => \Elementor\Utils::get_placeholder_image_src() ),
			)
		);

		$repeater->add_control(
			'slide_overlay_color',
			array(
				'label'   => esc_html__( 'Overlay Color', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::COLOR,
				'default' => 'rgba(0,0,0,0.5)',
			)
		);

		$repeater->add_control(
			'slide_tagline',
			array(
				'label'   => esc_html__( 'Tagline', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Welcome to Nexus', 'nexus' ),
				'dynamic' => array( 'active' => true ),
			)
		);

		$repeater->add_control(
			'slide_title',
			array(
				'label'   => esc_html__( 'Title', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Build Beautiful Websites', 'nexus' ),
				'dynamic' => array( 'active' => true ),
			)
		);

		$repeater->add_control(
			'slide_text',
			array(
				'label'   => esc_html__( 'Description', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'A premium WordPress theme designed for performance and elegance.', 'nexus' ),
				'dynamic' => array( 'active' => true ),
			)
		);

		$repeater->add_control(
			'btn_text',
			array(
				'label'   => esc_html__( 'Primary Button Text', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Get Started', 'nexus' ),
			)
		);

		$repeater->add_control(
			'btn_link',
			array(
				'label'       => esc_html__( 'Primary Button Link', 'nexus' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( '#', 'nexus' ),
				'dynamic'     => array( 'active' => true ),
			)
		);

		$repeater->add_control(
			'btn2_text',
			array(
				'label'   => esc_html__( 'Secondary Button Text', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => '',
			)
		);

		$repeater->add_control(
			'btn2_link',
			array(
				'label'   => esc_html__( 'Secondary Button Link', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::URL,
				'dynamic' => array( 'active' => true ),
			)
		);

		$this->add_control(
			'slides',
			array(
				'label'       => esc_html__( 'Slides', 'nexus' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'slide_title'   => esc_html__( 'Build Beautiful Websites', 'nexus' ),
						'slide_tagline' => esc_html__( 'Welcome to Nexus', 'nexus' ),
						'slide_text'    => esc_html__( 'A premium WordPress theme for modern businesses.', 'nexus' ),
						'btn_text'      => esc_html__( 'Get Started', 'nexus' ),
					),
					array(
						'slide_title'   => esc_html__( 'Grow Your Business Online', 'nexus' ),
						'slide_tagline' => esc_html__( 'Powerful & Flexible', 'nexus' ),
						'slide_text'    => esc_html__( 'Elementor, Gutenberg, WooCommerce — all in one theme.', 'nexus' ),
						'btn_text'      => esc_html__( 'View Demos', 'nexus' ),
					),
				),
				'title_field' => '{{{ slide_title }}}',
			)
		);

		$this->end_controls_section();

		// ---------------------------------------------------------------
		// CONTENT: Slider Settings
		// ---------------------------------------------------------------
		$this->start_controls_section(
			'section_settings',
			array( 'label' => esc_html__( 'Slider Settings', 'nexus' ) )
		);

		$this->add_responsive_control(
			'slide_height',
			array(
				'label'      => esc_html__( 'Slide Height', 'nexus' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'vh' ),
				'range'      => array(
					'px' => array(
						'min'  => 300,
						'max'  => 1200,
						'step' => 10,
					),
					'vh' => array(
						'min' => 30,
						'max' => 100,
					),
				),
				'default'    => array(
					'size' => 700,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .nexus-hero-slider' => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'autoplay',
			array(
				'label'   => esc_html__( 'Autoplay', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$this->add_control(
			'autoplay_speed',
			array(
				'label'     => esc_html__( 'Autoplay Delay (ms)', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'default'   => 5000,
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
			'show_arrows',
			array(
				'label'   => esc_html__( 'Show Navigation Arrows', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$this->add_control(
			'show_dots',
			array(
				'label'   => esc_html__( 'Show Pagination Dots', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$this->add_control(
			'content_align',
			array(
				'label'   => esc_html__( 'Content Alignment', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'left',
				'options' => array(
					'left'   => esc_html__( 'Left', 'nexus' ),
					'center' => esc_html__( 'Center', 'nexus' ),
					'right'  => esc_html__( 'Right', 'nexus' ),
				),
			)
		);

		$this->end_controls_section();

		// ---------------------------------------------------------------
		// STYLE: Title
		// ---------------------------------------------------------------
		$this->start_controls_section(
			'section_style_title',
			array(
				'label' => esc_html__( 'Title', 'nexus' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .nexus-hero-slide__title',
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Color', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .nexus-hero-slide__title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings  = $this->get_settings_for_display();
		$slides    = $settings['slides'];
		$widget_id = 'nexus-hero-' . $this->get_id();

		if ( empty( $slides ) ) {
			return;
		}

		$autoplay = ( 'yes' === $settings['autoplay'] )
			? 'data-autoplay="' . absint( $settings['autoplay_speed'] ) . '"'
			: 'data-autoplay="false"';

		$loop   = 'yes' === $settings['loop'] ? 'true' : 'false';
		$arrows = 'yes' === $settings['show_arrows'];
		$dots   = 'yes' === $settings['show_dots'];
		$align  = $settings['content_align'] ?? 'left';
		?>

		<div
			id="<?php echo esc_attr( $widget_id ); ?>"
			class="nexus-hero-slider swiper content-<?php echo esc_attr( $align ); ?>"
			data-loop="<?php echo esc_attr( $loop ); ?>"
			<?php echo $autoplay; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		>
			<div class="swiper-wrapper">
				<?php foreach ( $slides as $slide ) : ?>
					<?php
					$bg_url   = $slide['slide_bg']['url'] ?? '';
					$overlay  = $slide['slide_overlay_color'] ?? 'rgba(0,0,0,0.5)';
					$bg_style = $bg_url ? 'background-image: url(' . esc_url( $bg_url ) . ');' : '';
					?>
					<div
						class="swiper-slide nexus-hero-slide nexus-hero-slide--align-<?php echo esc_attr( $align ); ?>"
						style="<?php echo esc_attr( $bg_style ); ?>"
					>
						<div class="nexus-hero-slide__overlay" style="background-color: <?php echo esc_attr( $overlay ); ?>;"></div>

						<div class="nexus-container nexus-hero-slide__container">
							<div class="nexus-hero-slide__content">

								<?php if ( $slide['slide_tagline'] ) : ?>
									<p class="nexus-hero-slide__tagline">
										<?php echo esc_html( $slide['slide_tagline'] ); ?>
									</p>
								<?php endif; ?>

								<?php if ( $slide['slide_title'] ) : ?>
									<h2 class="nexus-hero-slide__title">
										<?php echo wp_kses_post( $slide['slide_title'] ); ?>
									</h2>
								<?php endif; ?>

								<?php if ( $slide['slide_text'] ) : ?>
									<p class="nexus-hero-slide__text">
										<?php echo wp_kses_post( $slide['slide_text'] ); ?>
									</p>
								<?php endif; ?>

								<?php if ( $slide['btn_text'] || $slide['btn2_text'] ) : ?>
									<div class="nexus-hero-slide__actions">
										<?php if ( $slide['btn_text'] && ! empty( $slide['btn_link']['url'] ) ) : ?>
											<a
												href="<?php echo esc_url( $slide['btn_link']['url'] ); ?>"
												class="nexus-btn nexus-btn--primary"
												<?php echo $slide['btn_link']['is_external'] ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>
											>
												<?php echo esc_html( $slide['btn_text'] ); ?>
											</a>
										<?php endif; ?>

										<?php if ( $slide['btn2_text'] && ! empty( $slide['btn2_link']['url'] ) ) : ?>
											<a
												href="<?php echo esc_url( $slide['btn2_link']['url'] ); ?>"
												class="nexus-btn nexus-btn--outline-white"
												<?php echo $slide['btn2_link']['is_external'] ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>
											>
												<?php echo esc_html( $slide['btn2_text'] ); ?>
											</a>
										<?php endif; ?>
									</div>
								<?php endif; ?>

							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>

			<?php if ( $dots ) : ?>
				<div class="swiper-pagination nexus-hero-slider__dots"></div>
			<?php endif; ?>

			<?php if ( $arrows ) : ?>
				<button class="swiper-button-prev nexus-hero-slider__prev" aria-label="<?php esc_attr_e( 'Previous slide', 'nexus' ); ?>"></button>
				<button class="swiper-button-next nexus-hero-slider__next" aria-label="<?php esc_attr_e( 'Next slide', 'nexus' ); ?>"></button>
			<?php endif; ?>
		</div>

		<script>
		document.addEventListener( 'DOMContentLoaded', function () {
			var el = document.getElementById( '<?php echo esc_js( $widget_id ); ?>' );
			if ( ! el || ! window.Swiper ) return;

			var autoplay = el.dataset.autoplay;
			var loop     = el.dataset.loop === 'true';

			new Swiper( '#<?php echo esc_js( $widget_id ); ?>', {
				loop:       loop,
				speed:      800,
				autoplay:   autoplay !== 'false' ? { delay: parseInt( autoplay, 10 ), disableOnInteraction: false } : false,
				pagination: <?php echo $dots ? '{ el: ".swiper-pagination", clickable: true }' : 'false'; ?>,
				navigation: <?php echo $arrows ? '{ nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" }' : 'false'; ?>,
				a11y: {
					prevSlideMessage: '<?php echo esc_js( __( 'Previous slide', 'nexus' ) ); ?>',
					nextSlideMessage: '<?php echo esc_js( __( 'Next slide', 'nexus' ) ); ?>',
				},
			} );
		} );
		</script>
		<?php
	}
}
