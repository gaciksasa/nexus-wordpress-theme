<?php
/**
 * Nexus Theme - Elementor Services Grid Widget
 *
 * Services/features grid with icon, title, text, optional link.
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

	protected function register_controls() {

		// ---------------------------------------------------------------
		// CONTENT: Items
		// ---------------------------------------------------------------
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

		$repeater->add_control(
			'icon_color',
			array(
				'label' => esc_html__( 'Icon Color Override', 'nexus' ),
				'type'  => \Elementor\Controls_Manager::COLOR,
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
						'icon'        => array(
							'value'   => 'ri-palette-line',
							'library' => 'remix-icon',
						),
						'title'       => esc_html__( 'Creative Design', 'nexus' ),
						'description' => esc_html__( 'Stunning visuals that capture your brand essence and communicate your message effectively.', 'nexus' ),
					),
					array(
						'icon'        => array(
							'value'   => 'ri-code-s-slash-line',
							'library' => 'remix-icon',
						),
						'title'       => esc_html__( 'Web Development', 'nexus' ),
						'description' => esc_html__( 'Fast, secure, and scalable web solutions built with modern technologies.', 'nexus' ),
					),
					array(
						'icon'        => array(
							'value'   => 'ri-bar-chart-2-line',
							'library' => 'remix-icon',
						),
						'title'       => esc_html__( 'Digital Marketing', 'nexus' ),
						'description' => esc_html__( 'Data-driven strategies to grow your online presence and drive conversions.', 'nexus' ),
					),
					array(
						'icon'        => array(
							'value'   => 'ri-customer-service-2-line',
							'library' => 'remix-icon',
						),
						'title'       => esc_html__( '24/7 Support', 'nexus' ),
						'description' => esc_html__( 'Round-the-clock assistance to ensure your business never misses a beat.', 'nexus' ),
					),
					array(
						'icon'        => array(
							'value'   => 'ri-shield-check-line',
							'library' => 'remix-icon',
						),
						'title'       => esc_html__( 'Security', 'nexus' ),
						'description' => esc_html__( 'Enterprise-grade security measures protecting your data and users at all times.', 'nexus' ),
					),
					array(
						'icon'        => array(
							'value'   => 'ri-rocket-2-line',
							'library' => 'remix-icon',
						),
						'title'       => esc_html__( 'Fast Performance', 'nexus' ),
						'description' => esc_html__( 'Optimized for speed and performance delivering exceptional user experiences.', 'nexus' ),
					),
				),
				'title_field' => '{{{ title }}}',
			)
		);

		$this->end_controls_section();

		// ---------------------------------------------------------------
		// CONTENT: Layout
		// ---------------------------------------------------------------
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
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
				),
				'selectors'      => array(
					'{{WRAPPER}} .nexus-services-grid' => '--nexus-services-cols: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'card_style',
			array(
				'label'   => esc_html__( 'Card Style', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'boxed',
				'options' => array(
					'boxed'  => esc_html__( 'Boxed', 'nexus' ),
					'flat'   => esc_html__( 'Flat (No Border)', 'nexus' ),
					'border' => esc_html__( 'Border Left Accent', 'nexus' ),
				),
			)
		);

		$this->add_control(
			'icon_position',
			array(
				'label'   => esc_html__( 'Icon Position', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'top',
				'options' => array(
					'top'  => esc_html__( 'Top', 'nexus' ),
					'left' => esc_html__( 'Left (Inline)', 'nexus' ),
				),
			)
		);

		$this->add_control(
			'text_align',
			array(
				'label'     => esc_html__( 'Text Alignment', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'nexus' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'nexus' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'nexus' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => 'left',
				'selectors' => array(
					'{{WRAPPER}} .nexus-service-card' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'hover_effect',
			array(
				'label'   => esc_html__( 'Hover Effect', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'lift',
				'options' => array(
					'none'   => esc_html__( 'None', 'nexus' ),
					'lift'   => esc_html__( 'Lift Up', 'nexus' ),
					'glow'   => esc_html__( 'Glow Shadow', 'nexus' ),
					'border' => esc_html__( 'Accent Border', 'nexus' ),
				),
			)
		);

		$this->end_controls_section();

		// ---------------------------------------------------------------
		// STYLE: Icon
		// ---------------------------------------------------------------
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
				'selectors' => array(
					'{{WRAPPER}} .nexus-service-card__icon' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'icon_bg_color',
			array(
				'label'     => esc_html__( 'Icon Background', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .nexus-service-card__icon-wrap' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'icon_size',
			array(
				'label'      => esc_html__( 'Icon Size', 'nexus' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 16,
						'max' => 80,
					),
				),
				'default'    => array(
					'size' => 32,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .nexus-service-card__icon' => 'font-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'icon_padding',
			array(
				'label'      => esc_html__( 'Icon Wrapper Size', 'nexus' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 40,
						'max' => 120,
					),
				),
				'default'    => array(
					'size' => 70,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .nexus-service-card__icon-wrap' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'icon_radius',
			array(
				'label'      => esc_html__( 'Icon Border Radius', 'nexus' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 50,
					'unit' => '%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .nexus-service-card__icon-wrap' => 'border-radius: {{SIZE}}{{UNIT}};',
				),
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

		$this->add_responsive_control(
			'card_gap',
			array(
				'label'      => esc_html__( 'Gap', 'nexus' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 60,
					),
				),
				'default'    => array(
					'size' => 30,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .nexus-services-grid' => 'gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			array(
				'name'     => 'card_bg',
				'selector' => '{{WRAPPER}} .nexus-service-card',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'card_border',
				'selector' => '{{WRAPPER}} .nexus-service-card',
			)
		);

		$this->add_control(
			'card_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'nexus' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .nexus-service-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'card_padding',
			array(
				'label'      => esc_html__( 'Padding', 'nexus' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .nexus-service-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Title Color', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .nexus-service-card__title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Title Typography', 'nexus' ),
				'selector' => '{{WRAPPER}} .nexus-service-card__title',
			)
		);

		$this->add_control(
			'desc_color',
			array(
				'label'     => esc_html__( 'Description Color', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .nexus-service-card__desc' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings   = $this->get_settings_for_display();
		$services   = $settings['services'];
		$card_style = $settings['card_style'] ?? 'boxed';
		$icon_pos   = $settings['icon_position'] ?? 'top';
		$hover      = $settings['hover_effect'] ?? 'lift';

		if ( empty( $services ) ) {
			return;
		}
		?>

		<div class="nexus-services-grid nexus-services--<?php echo esc_attr( $card_style ); ?> nexus-services--icon-<?php echo esc_attr( $icon_pos ); ?>">
			<?php foreach ( $services as $service ) : ?>
				<?php
				$has_link = ! empty( $service['link']['url'] );
				$tag      = $has_link ? 'a' : 'div';
				$attrs    = '';
				if ( $has_link ) {
					$attrs = ' href="' . esc_url( $service['link']['url'] ) . '"';
					if ( ! empty( $service['link']['is_external'] ) ) {
						$attrs .= ' target="_blank" rel="noopener noreferrer"';
					}
				}
				$inline_icon_color = $service['icon_color'] ? ' style="color:' . esc_attr( $service['icon_color'] ) . ';"' : '';
				?>

				<<?php echo esc_attr( $tag . $attrs ); ?> class="nexus-service-card nexus-service-card--hover-<?php echo esc_attr( $hover ); ?>">

					<div class="nexus-service-card__icon-wrap">
						<span class="nexus-service-card__icon"<?php echo $inline_icon_color; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
							<?php \Elementor\Icons_Manager::render_icon( $service['icon'], array( 'aria-hidden' => 'true' ) ); ?>
						</span>
					</div>

					<div class="nexus-service-card__body">
						<?php if ( $service['title'] ) : ?>
							<h3 class="nexus-service-card__title"><?php echo esc_html( $service['title'] ); ?></h3>
						<?php endif; ?>

						<?php if ( $service['description'] ) : ?>
							<p class="nexus-service-card__desc"><?php echo wp_kses_post( $service['description'] ); ?></p>
						<?php endif; ?>

						<?php if ( $service['link_text'] && $has_link ) : ?>
							<span class="nexus-service-card__link">
								<?php echo esc_html( $service['link_text'] ); ?>
								<i class="ri ri-arrow-right-line" aria-hidden="true"></i>
							</span>
						<?php endif; ?>
					</div>

				</<?php echo esc_attr( $tag ); ?>>

			<?php endforeach; ?>
		</div>
		<?php
	}
}
