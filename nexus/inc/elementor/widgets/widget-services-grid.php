<?php
/**
 * Nexus Theme - Elementor Services Grid Widget
 *
 * Services/features grid with 6 visually distinct style presets.
 * Each preset has a unique HTML structure and visual identity.
 *
 * @package Nexus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Nexus_Widget_Services_Grid
 */
class Nexus_Widget_Services_Grid extends \Elementor\Widget_Base {

	public function get_name() {
		return 'nexus-services-grid';
	}

	public function get_title() {
		return esc_html__( 'Services Grid', 'nexus' );
	}

	public function get_icon() {
		return 'eicon-apps';
	}

	public function get_categories() {
		return array( 'nexus-elements' );
	}

	public function get_keywords() {
		return array( 'services', 'features', 'grid', 'icons', 'nexus' );
	}

	// -----------------------------------------------------------------
	// Preset data
	// -----------------------------------------------------------------

	/**
	 * Only palette-dependent colors go here — they become inline CSS vars.
	 * Static colors (#ffffff, #6c757d, etc.) are SCSS defaults so dark mode can override them.
	 * Heading/text are NOT set here — they use var(--nexus-heading-color) etc. in SCSS,
	 * which the dark mode theme already handles.
	 */
	private function get_preset_colors( $preset ) {
		$p       = nexus_palette();
		$presets = array(
			'clean-minimal'       => array(
				'icon_color'    => $p['secondary'],
				'link'          => $p['secondary'],
			),
			'corporate-numbered'  => array(
				'accent'        => $p['secondary'],
				'icon_color'    => $p['secondary'],
				'link'          => $p['secondary'],
			),
			'flip-hover'          => array(
				'card_bg_hover' => $p['secondary'],
				'icon_color'    => $p['secondary'],
				'link'          => $p['secondary'],
			),
			'horizontal-list'     => array(
				'icon_bg'       => $p['secondary'],
				'link'          => $p['secondary'],
			),
			'overlapping-icon'    => array(
				'icon_bg'       => 'linear-gradient(135deg, ' . $p['secondary'] . ', ' . $p['accent'] . ')',
				'link'          => $p['secondary'],
			),
			'dark-glass'          => array(
				'section_bg'    => $p['dark'],
				'icon_color'    => $p['secondary'],
				'link'          => $p['secondary'],
				'glow'          => $p['secondary'],
			),
		);

		return $presets[ $preset ] ?? $presets['clean-minimal'];
	}

	// -----------------------------------------------------------------
	// Controls
	// -----------------------------------------------------------------

	protected function register_controls() {

		// ---- Style Preset ----
		$this->start_controls_section(
			'section_preset',
			array( 'label' => esc_html__( 'Style Preset', 'nexus' ) )
		);

		$this->add_control(
			'style_preset',
			array(
				'label'       => esc_html__( 'Style', 'nexus' ),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'default'     => 'clean-minimal',
				'options'     => array(
					'clean-minimal'      => esc_html__( '1 — Clean Minimal', 'nexus' ),
					'corporate-numbered' => esc_html__( '2 — Corporate Numbered', 'nexus' ),
					'flip-hover'         => esc_html__( '3 — Flip Hover', 'nexus' ),
					'horizontal-list'    => esc_html__( '4 — Horizontal List', 'nexus' ),
					'overlapping-icon'   => esc_html__( '5 — Overlapping Icon', 'nexus' ),
					'dark-glass'         => esc_html__( '6 — Dark Glassmorphism', 'nexus' ),
				),
				'render_type' => 'template',
			)
		);

		$this->end_controls_section();

		// ---- Section Header ----
		$this->start_controls_section(
			'section_header',
			array( 'label' => esc_html__( 'Section Header', 'nexus' ) )
		);

		$this->add_control(
			'tagline',
			array(
				'label'       => esc_html__( 'Tagline', 'nexus' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'What We Do', 'nexus' ),
				'placeholder' => esc_html__( 'e.g. Our Services', 'nexus' ),
				'dynamic'     => array( 'active' => true ),
			)
		);

		$this->add_control(
			'heading',
			array(
				'label'       => esc_html__( 'Heading', 'nexus' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Services We Provide', 'nexus' ),
				'placeholder' => esc_html__( 'Enter heading', 'nexus' ),
				'dynamic'     => array( 'active' => true ),
			)
		);

		$this->add_control(
			'subheading',
			array(
				'label'       => esc_html__( 'Subheading', 'nexus' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'rows'        => 3,
				'default'     => esc_html__( 'Comprehensive solutions designed to help your business grow and succeed in a competitive landscape.', 'nexus' ),
				'placeholder' => esc_html__( 'Enter subheading', 'nexus' ),
				'dynamic'     => array( 'active' => true ),
			)
		);

		$this->add_control(
			'header_align',
			array(
				'label'   => esc_html__( 'Alignment', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::CHOOSE,
				'options' => array(
					'left'   => array( 'title' => esc_html__( 'Left', 'nexus' ), 'icon' => 'eicon-text-align-left' ),
					'center' => array( 'title' => esc_html__( 'Center', 'nexus' ), 'icon' => 'eicon-text-align-center' ),
				),
				'default' => 'center',
			)
		);

		$this->end_controls_section();

		// ---- Services Repeater ----
		$this->start_controls_section(
			'section_items',
			array( 'label' => esc_html__( 'Services', 'nexus' ) )
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'icon',
			array(
				'label'   => esc_html__( 'Icon', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::ICONS,
				'default' => array(
					'value'   => 'ri-star-line',
					'library' => 'remix-icon',
				),
			)
		);

		$repeater->add_control(
			'title',
			array(
				'label'   => esc_html__( 'Title', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Our Service', 'nexus' ),
				'dynamic' => array( 'active' => true ),
			)
		);

		$repeater->add_control(
			'description',
			array(
				'label'   => esc_html__( 'Description', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'rows'    => 4,
				'default' => esc_html__( 'We provide exceptional service tailored to your specific needs and goals.', 'nexus' ),
				'dynamic' => array( 'active' => true ),
			)
		);

		$repeater->add_control(
			'link_text',
			array(
				'label'   => esc_html__( 'Link Text', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => '',
			)
		);

		$repeater->add_control(
			'link',
			array(
				'label'   => esc_html__( 'Link', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::URL,
				'dynamic' => array( 'active' => true ),
			)
		);

		$this->add_control(
			'services',
			array(
				'label'       => esc_html__( 'Services', 'nexus' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'icon'        => array( 'value' => 'ri-palette-line', 'library' => 'remix-icon' ),
						'title'       => esc_html__( 'Creative Design', 'nexus' ),
						'description' => esc_html__( 'Stunning visuals that capture your brand essence and communicate your message effectively.', 'nexus' ),
						'link_text'   => esc_html__( 'Learn More', 'nexus' ),
					),
					array(
						'icon'        => array( 'value' => 'ri-code-s-slash-line', 'library' => 'remix-icon' ),
						'title'       => esc_html__( 'Web Development', 'nexus' ),
						'description' => esc_html__( 'Fast, secure, and scalable web solutions built with modern technologies.', 'nexus' ),
						'link_text'   => esc_html__( 'Learn More', 'nexus' ),
					),
					array(
						'icon'        => array( 'value' => 'ri-bar-chart-2-line', 'library' => 'remix-icon' ),
						'title'       => esc_html__( 'Digital Marketing', 'nexus' ),
						'description' => esc_html__( 'Data-driven strategies to grow your online presence and drive conversions.', 'nexus' ),
						'link_text'   => esc_html__( 'Learn More', 'nexus' ),
					),
					array(
						'icon'        => array( 'value' => 'ri-customer-service-2-line', 'library' => 'remix-icon' ),
						'title'       => esc_html__( '24/7 Support', 'nexus' ),
						'description' => esc_html__( 'Round-the-clock assistance to ensure your business never misses a beat.', 'nexus' ),
						'link_text'   => esc_html__( 'Learn More', 'nexus' ),
					),
					array(
						'icon'        => array( 'value' => 'ri-shield-check-line', 'library' => 'remix-icon' ),
						'title'       => esc_html__( 'Security', 'nexus' ),
						'description' => esc_html__( 'Enterprise-grade security measures protecting your data and users at all times.', 'nexus' ),
						'link_text'   => esc_html__( 'Learn More', 'nexus' ),
					),
					array(
						'icon'        => array( 'value' => 'ri-rocket-2-line', 'library' => 'remix-icon' ),
						'title'       => esc_html__( 'Fast Performance', 'nexus' ),
						'description' => esc_html__( 'Optimized for speed and performance delivering exceptional user experiences.', 'nexus' ),
						'link_text'   => esc_html__( 'Learn More', 'nexus' ),
					),
				),
				'title_field' => '{{{ title }}}',
			)
		);

		$this->end_controls_section();

		// ---- Layout ----
		$this->start_controls_section(
			'section_layout',
			array( 'label' => esc_html__( 'Layout', 'nexus' ) )
		);

		$this->add_responsive_control(
			'columns',
			array(
				'label'          => esc_html__( 'Columns', 'nexus' ),
				'type'           => \Elementor\Controls_Manager::SELECT,
				'default'        => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options'        => array(
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
				),
				'selectors'      => array(
					'{{WRAPPER}} .nexus-sg__grid' => '--nexus-sg-cols: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'card_gap',
			array(
				'label'      => esc_html__( 'Gap', 'nexus' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array( 'px' => array( 'min' => 0, 'max' => 60 ) ),
				'default'    => array( 'size' => 30, 'unit' => 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .nexus-sg__grid' => 'gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		// ---- Style: Header ----
		$this->start_controls_section(
			'section_style_header',
			array(
				'label' => esc_html__( 'Section Header', 'nexus' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'tagline_color',
			array(
				'label'     => esc_html__( 'Tagline Color', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array( '{{WRAPPER}} .nexus-sg__tagline' => 'color: {{VALUE}};' ),
			)
		);

		$this->add_control(
			'heading_color',
			array(
				'label'     => esc_html__( 'Heading Color', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array( '{{WRAPPER}} .nexus-sg__heading' => 'color: {{VALUE}};' ),
			)
		);

		$this->add_control(
			'subheading_color',
			array(
				'label'     => esc_html__( 'Subheading Color', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array( '{{WRAPPER}} .nexus-sg__subheading' => 'color: {{VALUE}};' ),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'heading_typography',
				'label'    => esc_html__( 'Heading Typography', 'nexus' ),
				'selector' => '{{WRAPPER}} .nexus-sg__heading',
			)
		);

		$this->end_controls_section();

		// ---- Style: Icon ----
		$this->start_controls_section(
			'section_style_icon',
			array(
				'label' => esc_html__( 'Icon', 'nexus' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'icon_color',
			array(
				'label'     => esc_html__( 'Icon Color', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array( '{{WRAPPER}} .nexus-sg-card__icon' => 'color: {{VALUE}};' ),
			)
		);

		$this->add_control(
			'icon_bg_color',
			array(
				'label'     => esc_html__( 'Icon Background', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array( '{{WRAPPER}} .nexus-sg-card__icon-wrap' => 'background-color: {{VALUE}};' ),
			)
		);

		$this->add_control(
			'icon_size',
			array(
				'label'      => esc_html__( 'Icon Size', 'nexus' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array( 'px' => array( 'min' => 16, 'max' => 80 ) ),
				'selectors'  => array( '{{WRAPPER}} .nexus-sg-card__icon' => 'font-size: {{SIZE}}{{UNIT}};' ),
			)
		);

		$this->end_controls_section();

		// ---- Style: Card ----
		$this->start_controls_section(
			'section_style_card',
			array(
				'label' => esc_html__( 'Card', 'nexus' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Title Color', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array( '{{WRAPPER}} .nexus-sg-card__title' => 'color: {{VALUE}};' ),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Title Typography', 'nexus' ),
				'selector' => '{{WRAPPER}} .nexus-sg-card__title',
			)
		);

		$this->add_control(
			'desc_color',
			array(
				'label'     => esc_html__( 'Description Color', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array( '{{WRAPPER}} .nexus-sg-card__desc' => 'color: {{VALUE}};' ),
			)
		);

		$this->end_controls_section();
	}

	// -----------------------------------------------------------------
	// Render dispatcher
	// -----------------------------------------------------------------

	protected function render() {
		$settings = $this->get_settings_for_display();
		$preset   = $settings['style_preset'] ?? 'clean-minimal';
		$services = $settings['services'] ?? array();

		if ( empty( $services ) ) {
			return;
		}

		switch ( $preset ) {
			case 'corporate-numbered':
				$this->render_corporate_numbered( $settings, $services );
				break;
			case 'flip-hover':
				$this->render_flip_hover( $settings, $services );
				break;
			case 'horizontal-list':
				$this->render_horizontal_list( $settings, $services );
				break;
			case 'overlapping-icon':
				$this->render_overlapping_icon( $settings, $services );
				break;
			case 'dark-glass':
				$this->render_dark_glass( $settings, $services );
				break;
			default:
				$this->render_clean_minimal( $settings, $services );
				break;
		}
	}

	// -----------------------------------------------------------------
	// Shared helpers
	// -----------------------------------------------------------------

	private function render_icon( $service ) {
		if ( ! empty( $service['icon']['value'] ) ) {
			\Elementor\Icons_Manager::render_icon( $service['icon'], array( 'aria-hidden' => 'true' ) );
		}
	}

	private function get_link_attrs( $service ) {
		$has_link = ! empty( $service['link']['url'] );
		if ( ! $has_link ) {
			return '';
		}
		$attrs = ' href="' . esc_url( $service['link']['url'] ) . '"';
		if ( ! empty( $service['link']['is_external'] ) ) {
			$attrs .= ' target="_blank" rel="noopener noreferrer"';
		}
		return $attrs;
	}

	/**
	 * Build a CSS custom-properties string from a preset color array.
	 * Set on the wrapper .nexus-sg so all children can use var(--sg-*).
	 */
	private function get_css_vars( $colors ) {
		$map = array(
			'card_bg'      => '--sg-card-bg',
			'icon_color'   => '--sg-icon-color',
			'icon_bg'      => '--sg-icon-bg',
			'heading'      => '--sg-heading',
			'text'         => '--sg-text',
			'link'         => '--sg-link',
			'border'       => '--sg-border',
			'accent'       => '--sg-accent',
			'number_color' => '--sg-number',
			'card_bg_hover' => '--sg-card-bg-hover',
			'card_border'  => '--sg-card-border',
			'glow'         => '--sg-glow',
			'shadow'       => '--sg-shadow',
			'section_bg'   => '--sg-section-bg',
		);

		$vars = array();
		foreach ( $map as $key => $prop ) {
			if ( ! empty( $colors[ $key ] ) ) {
				$vars[] = $prop . ':' . $colors[ $key ];
			}
		}
		return implode( ';', $vars );
	}

	private function render_section_header( $settings ) {
		$tagline    = $settings['tagline'] ?? '';
		$heading    = $settings['heading'] ?? '';
		$subheading = $settings['subheading'] ?? '';
		$align      = $settings['header_align'] ?? 'center';

		if ( ! $tagline && ! $heading && ! $subheading ) {
			return;
		}
		?>
		<div class="nexus-sg__header nexus-sg__header--<?php echo esc_attr( $align ); ?>">
			<?php if ( $tagline ) : ?>
				<span class="nexus-sg__tagline"><?php echo esc_html( $tagline ); ?></span>
			<?php endif; ?>

			<?php if ( $heading ) : ?>
				<h2 class="nexus-sg__heading"><?php echo esc_html( $heading ); ?></h2>
			<?php endif; ?>

			<?php if ( $subheading ) : ?>
				<p class="nexus-sg__subheading"><?php echo wp_kses_post( $subheading ); ?></p>
			<?php endif; ?>
		</div>
		<?php
	}

	// -----------------------------------------------------------------
	// 1. Clean Minimal — Standard vertical cards, round icon, clean
	// -----------------------------------------------------------------

	private function render_clean_minimal( $settings, $services ) {
		$c = $this->get_preset_colors( 'clean-minimal' );
		?>
		<div class="nexus-sg nexus-sg--clean-minimal" style="<?php echo esc_attr( $this->get_css_vars( $c ) ); ?>">
			<?php $this->render_section_header( $settings ); ?>

			<div class="nexus-sg__grid">
				<?php foreach ( $services as $service ) :
					$has_link  = ! empty( $service['link']['url'] );
					$tag       = $has_link ? 'a' : 'div';
					$link_attr = $this->get_link_attrs( $service );
					?>
					<<?php echo $tag . $link_attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> class="nexus-sg-card nexus-sg-card--clean">

						<div class="nexus-sg-card__icon-wrap">
							<span class="nexus-sg-card__icon">
								<?php $this->render_icon( $service ); ?>
							</span>
						</div>

						<?php if ( $service['title'] ) : ?>
							<h3 class="nexus-sg-card__title"><?php echo esc_html( $service['title'] ); ?></h3>
						<?php endif; ?>

						<?php if ( $service['description'] ) : ?>
							<p class="nexus-sg-card__desc"><?php echo wp_kses_post( $service['description'] ); ?></p>
						<?php endif; ?>

						<?php if ( ! empty( $service['link_text'] ) ) : ?>
							<span class="nexus-sg-card__link">
								<?php echo esc_html( $service['link_text'] ); ?> <i class="ri-arrow-right-line" aria-hidden="true"></i>
							</span>
						<?php endif; ?>

					</<?php echo esc_attr( $tag ); ?>>
				<?php endforeach; ?>
			</div>
		</div>
		<?php
	}

	// -----------------------------------------------------------------
	// 2. Corporate Numbered — Big step numbers, left accent bar
	// -----------------------------------------------------------------

	private function render_corporate_numbered( $settings, $services ) {
		$c = $this->get_preset_colors( 'corporate-numbered' );
		?>
		<div class="nexus-sg nexus-sg--corporate-numbered" style="<?php echo esc_attr( $this->get_css_vars( $c ) ); ?>">
			<?php $this->render_section_header( $settings ); ?>

			<div class="nexus-sg__grid">
				<?php foreach ( $services as $idx => $service ) :
					$has_link  = ! empty( $service['link']['url'] );
					$tag       = $has_link ? 'a' : 'div';
					$link_attr = $this->get_link_attrs( $service );
					$num       = str_pad( $idx + 1, 2, '0', STR_PAD_LEFT );
					?>
					<<?php echo $tag . $link_attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> class="nexus-sg-card nexus-sg-card--numbered">

						<div class="nexus-sg-card__accent-bar"></div>

						<span class="nexus-sg-card__number"><?php echo esc_html( $num ); ?></span>

						<div class="nexus-sg-card__top">
							<span class="nexus-sg-card__icon nexus-sg-card__icon--small">
								<?php $this->render_icon( $service ); ?>
							</span>
							<?php if ( $service['title'] ) : ?>
								<h3 class="nexus-sg-card__title"><?php echo esc_html( $service['title'] ); ?></h3>
							<?php endif; ?>
						</div>

						<?php if ( $service['description'] ) : ?>
							<p class="nexus-sg-card__desc"><?php echo wp_kses_post( $service['description'] ); ?></p>
						<?php endif; ?>

						<?php if ( ! empty( $service['link_text'] ) ) : ?>
							<span class="nexus-sg-card__link">
								<?php echo esc_html( $service['link_text'] ); ?> <i class="ri-arrow-right-s-line" aria-hidden="true"></i>
							</span>
						<?php endif; ?>

					</<?php echo esc_attr( $tag ); ?>>
				<?php endforeach; ?>
			</div>
		</div>
		<?php
	}

	// -----------------------------------------------------------------
	// 3. Flip Hover — White cards, full color transform on hover
	// -----------------------------------------------------------------

	private function render_flip_hover( $settings, $services ) {
		$c = $this->get_preset_colors( 'flip-hover' );
		?>
		<div class="nexus-sg nexus-sg--flip-hover" style="<?php echo esc_attr( $this->get_css_vars( $c ) ); ?>">
			<?php $this->render_section_header( $settings ); ?>

			<div class="nexus-sg__grid">
				<?php foreach ( $services as $service ) :
					$has_link  = ! empty( $service['link']['url'] );
					$tag       = $has_link ? 'a' : 'div';
					$link_attr = $this->get_link_attrs( $service );
					?>
					<<?php echo $tag . $link_attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> class="nexus-sg-card nexus-sg-card--flip">

						<div class="nexus-sg-card__icon-wrap nexus-sg-card__icon-wrap--flip">
							<span class="nexus-sg-card__icon nexus-sg-card__icon--large">
								<?php $this->render_icon( $service ); ?>
							</span>
						</div>

						<?php if ( $service['title'] ) : ?>
							<h3 class="nexus-sg-card__title"><?php echo esc_html( $service['title'] ); ?></h3>
						<?php endif; ?>

						<?php if ( $service['description'] ) : ?>
							<p class="nexus-sg-card__desc"><?php echo wp_kses_post( $service['description'] ); ?></p>
						<?php endif; ?>

						<span class="nexus-sg-card__flip-arrow">
							<i class="ri-arrow-right-up-line" aria-hidden="true"></i>
						</span>

					</<?php echo esc_attr( $tag ); ?>>
				<?php endforeach; ?>
			</div>
		</div>
		<?php
	}

	// -----------------------------------------------------------------
	// 4. Horizontal List — Full-width rows, icon left, arrow right
	// -----------------------------------------------------------------

	private function render_horizontal_list( $settings, $services ) {
		$c = $this->get_preset_colors( 'horizontal-list' );
		?>
		<div class="nexus-sg nexus-sg--horizontal-list" style="<?php echo esc_attr( $this->get_css_vars( $c ) ); ?>">
			<?php $this->render_section_header( $settings ); ?>

			<div class="nexus-sg__list">
				<?php foreach ( $services as $idx => $service ) :
					$has_link  = ! empty( $service['link']['url'] );
					$tag       = $has_link ? 'a' : 'div';
					$link_attr = $this->get_link_attrs( $service );
					$num       = str_pad( $idx + 1, 2, '0', STR_PAD_LEFT );
					?>
					<<?php echo $tag . $link_attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> class="nexus-sg-row">

						<span class="nexus-sg-row__number"><?php echo esc_html( $num ); ?></span>

						<div class="nexus-sg-row__icon-wrap">
							<span class="nexus-sg-row__icon">
								<?php $this->render_icon( $service ); ?>
							</span>
						</div>

						<div class="nexus-sg-row__body">
							<?php if ( $service['title'] ) : ?>
								<h3 class="nexus-sg-row__title"><?php echo esc_html( $service['title'] ); ?></h3>
							<?php endif; ?>
							<?php if ( $service['description'] ) : ?>
								<p class="nexus-sg-row__desc"><?php echo wp_kses_post( $service['description'] ); ?></p>
							<?php endif; ?>
						</div>

						<span class="nexus-sg-row__arrow">
							<i class="ri-arrow-right-line" aria-hidden="true"></i>
						</span>

					</<?php echo esc_attr( $tag ); ?>>
				<?php endforeach; ?>
			</div>
		</div>
		<?php
	}

	// -----------------------------------------------------------------
	// 5. Overlapping Icon — Icon overlaps card top edge
	// -----------------------------------------------------------------

	private function render_overlapping_icon( $settings, $services ) {
		$c = $this->get_preset_colors( 'overlapping-icon' );
		?>
		<div class="nexus-sg nexus-sg--overlapping-icon" style="<?php echo esc_attr( $this->get_css_vars( $c ) ); ?>">
			<?php $this->render_section_header( $settings ); ?>

			<div class="nexus-sg__grid nexus-sg__grid--overlap">
				<?php foreach ( $services as $service ) :
					$has_link  = ! empty( $service['link']['url'] );
					$tag       = $has_link ? 'a' : 'div';
					$link_attr = $this->get_link_attrs( $service );
					?>
					<<?php echo $tag . $link_attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> class="nexus-sg-card nexus-sg-card--overlap">

						<div class="nexus-sg-card__icon-wrap nexus-sg-card__icon-wrap--overlap">
							<span class="nexus-sg-card__icon">
								<?php $this->render_icon( $service ); ?>
							</span>
						</div>

						<div class="nexus-sg-card__content">
							<?php if ( $service['title'] ) : ?>
								<h3 class="nexus-sg-card__title"><?php echo esc_html( $service['title'] ); ?></h3>
							<?php endif; ?>

							<?php if ( $service['description'] ) : ?>
								<p class="nexus-sg-card__desc"><?php echo wp_kses_post( $service['description'] ); ?></p>
							<?php endif; ?>

							<?php if ( ! empty( $service['link_text'] ) ) : ?>
								<span class="nexus-sg-card__link">
									<?php echo esc_html( $service['link_text'] ); ?> <i class="ri-arrow-right-line" aria-hidden="true"></i>
								</span>
							<?php endif; ?>
						</div>

					</<?php echo esc_attr( $tag ); ?>>
				<?php endforeach; ?>
			</div>
		</div>
		<?php
	}

	// -----------------------------------------------------------------
	// 6. Dark Glassmorphism — Dark bg, glass cards, glowing icons
	// -----------------------------------------------------------------

	private function render_dark_glass( $settings, $services ) {
		$c = $this->get_preset_colors( 'dark-glass' );
		?>
		<div class="nexus-sg nexus-sg--dark-glass" style="<?php echo esc_attr( $this->get_css_vars( $c ) ); ?>">
			<?php $this->render_section_header( $settings ); ?>

			<div class="nexus-sg__grid">
				<?php foreach ( $services as $service ) :
					$has_link  = ! empty( $service['link']['url'] );
					$tag       = $has_link ? 'a' : 'div';
					$link_attr = $this->get_link_attrs( $service );
					?>
					<<?php echo $tag . $link_attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> class="nexus-sg-card nexus-sg-card--glass">

						<span class="nexus-sg-card__icon nexus-sg-card__icon--glow">
							<?php $this->render_icon( $service ); ?>
						</span>

						<?php if ( $service['title'] ) : ?>
							<h3 class="nexus-sg-card__title"><?php echo esc_html( $service['title'] ); ?></h3>
						<?php endif; ?>

						<?php if ( $service['description'] ) : ?>
							<p class="nexus-sg-card__desc"><?php echo wp_kses_post( $service['description'] ); ?></p>
						<?php endif; ?>

						<div class="nexus-sg-card__glass-line"></div>

						<?php if ( ! empty( $service['link_text'] ) ) : ?>
							<span class="nexus-sg-card__link">
								<?php echo esc_html( $service['link_text'] ); ?> <i class="ri-arrow-right-line" aria-hidden="true"></i>
							</span>
						<?php endif; ?>

					</<?php echo esc_attr( $tag ); ?>>
				<?php endforeach; ?>
			</div>
		</div>
		<?php
	}
}
