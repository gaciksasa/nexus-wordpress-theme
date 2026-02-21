<?php
/**
 * Nexus Theme - Elementor Icon Box Widget
 *
 * Versatile icon + title + text component used across all demos.
 *
 * @package Nexus
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Nexus_Widget_Icon_Box
 */
class Nexus_Widget_Icon_Box extends \Elementor\Widget_Base {

	/**
	 * Returns the widget name (unique identifier).
	 *
	 * @return string
	 */
	public function get_name() {
		return 'nexus-icon-box';
	}

	/**
	 * Returns the widget title shown in the editor.
	 *
	 * @return string
	 */
	public function get_title() {
		return esc_html__( 'Icon Box', 'nexus' );
	}

	/**
	 * Returns the widget icon (Elementor icon class).
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'eicon-icon-box';
	}

	/**
	 * Returns the category the widget belongs to.
	 *
	 * @return array
	 */
	public function get_categories() {
		return array( 'nexus-elements' );
	}

	/**
	 * Returns the widget keywords for search.
	 *
	 * @return array
	 */
	public function get_keywords() {
		return array( 'icon', 'box', 'feature', 'service', 'card', 'nexus' );
	}

	/**
	 * Registers the widget controls.
	 */
	protected function register_controls() {

		// =========================================================
		// CONTENT TAB
		// =========================================================

		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'Content', 'nexus' ),
			)
		);

		$this->add_control(
			'icon',
			array(
				'label'   => esc_html__( 'Icon', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::ICONS,
				'default' => array(
					'value'   => 'fas fa-star',
					'library' => 'fa-solid',
				),
			)
		);

		$this->add_control(
			'title',
			array(
				'label'       => esc_html__( 'Title', 'nexus' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Our Service', 'nexus' ),
				'placeholder' => esc_html__( 'Enter title', 'nexus' ),
				'dynamic'     => array( 'active' => true ),
			)
		);

		$this->add_control(
			'title_tag',
			array(
				'label'   => esc_html__( 'Title Tag', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'h3',
				'options' => array(
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'p'  => 'p',
				),
			)
		);

		$this->add_control(
			'description',
			array(
				'label'   => esc_html__( 'Description', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Describe your service or feature in a few compelling sentences.', 'nexus' ),
				'dynamic' => array( 'active' => true ),
			)
		);

		$this->add_control(
			'link',
			array(
				'label'       => esc_html__( 'Link', 'nexus' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'nexus' ),
				'dynamic'     => array( 'active' => true ),
			)
		);

		$this->add_control(
			'link_text',
			array(
				'label'     => esc_html__( 'Link Text', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => esc_html__( 'Learn More', 'nexus' ),
				'condition' => array( 'link[url]!' => '' ),
			)
		);

		$this->end_controls_section();

		// Layout section.
		$this->start_controls_section(
			'section_layout',
			array(
				'label' => esc_html__( 'Layout', 'nexus' ),
			)
		);

		$this->add_control(
			'layout',
			array(
				'label'   => esc_html__( 'Layout', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'stacked',
				'options' => array(
					'stacked' => esc_html__( 'Stacked (icon above)', 'nexus' ),
					'inline'  => esc_html__( 'Inline (icon left)', 'nexus' ),
				),
			)
		);

		$this->add_control(
			'text_align',
			array(
				'label'     => esc_html__( 'Alignment', 'nexus' ),
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
				'toggle'    => true,
				'selectors' => array(
					'{{WRAPPER}} .nexus-icon-box' => 'text-align: {{VALUE}};',
				),
				'condition' => array( 'layout' => 'stacked' ),
			)
		);

		$this->end_controls_section();

		// =========================================================
		// STYLE TAB
		// =========================================================

		// Icon style.
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
				'label'     => esc_html__( 'Color', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#1a1a2e',
				'selectors' => array(
					'{{WRAPPER}} .nexus-icon-box__icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .nexus-icon-box__icon svg' => 'fill: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'icon_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .nexus-icon-box__icon-wrap' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'icon_size',
			array(
				'label'     => esc_html__( 'Icon Size', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min'  => 16,
						'max'  => 120,
						'step' => 2,
					),
				),
				'default'   => array(
					'size' => 40,
					'unit' => 'px',
				),
				'selectors' => array(
					'{{WRAPPER}} .nexus-icon-box__icon' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .nexus-icon-box__icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'icon_padding',
			array(
				'label'      => esc_html__( 'Icon Padding', 'nexus' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .nexus-icon-box__icon-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'icon_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'nexus' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .nexus-icon-box__icon-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		// Title style.
		$this->start_controls_section(
			'section_style_title',
			array(
				'label' => esc_html__( 'Title', 'nexus' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Color', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .nexus-icon-box__title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .nexus-icon-box__title',
			)
		);

		$this->add_responsive_control(
			'title_spacing',
			array(
				'label'     => esc_html__( 'Bottom Spacing', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 50,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .nexus-icon-box__title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		// Description style.
		$this->start_controls_section(
			'section_style_description',
			array(
				'label' => esc_html__( 'Description', 'nexus' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'desc_color',
			array(
				'label'     => esc_html__( 'Color', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .nexus-icon-box__desc' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'desc_typography',
				'selector' => '{{WRAPPER}} .nexus-icon-box__desc',
			)
		);

		$this->end_controls_section();

		// Box style.
		$this->start_controls_section(
			'section_style_box',
			array(
				'label' => esc_html__( 'Box', 'nexus' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			array(
				'name'     => 'box_background',
				'label'    => esc_html__( 'Background', 'nexus' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .nexus-icon-box',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'box_border',
				'selector' => '{{WRAPPER}} .nexus-icon-box',
			)
		);

		$this->add_responsive_control(
			'box_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'nexus' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .nexus-icon-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'box_padding',
			array(
				'label'      => esc_html__( 'Padding', 'nexus' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .nexus-icon-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'box_shadow',
				'selector' => '{{WRAPPER}} .nexus-icon-box',
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Renders the widget output.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$layout    = $settings['layout'] ?? 'stacked';
		$has_link  = ! empty( $settings['link']['url'] );
		$title_tag = $settings['title_tag'] ?? 'h3';

		$this->add_render_attribute(
			'wrapper',
			'class',
			array(
				'nexus-icon-box',
				'nexus-icon-box--' . $layout,
			)
		);

		if ( $has_link ) {
			$this->add_link_attributes( 'icon_link', $settings['link'] );
			$this->add_link_attributes( 'read_more_link', $settings['link'] );
		}
		?>

		<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>

			<div class="nexus-icon-box__icon-wrap">
				<?php if ( $has_link ) : ?>
					<a <?php $this->print_render_attribute_string( 'icon_link' ); ?> class="nexus-icon-box__icon-link" tabindex="-1" aria-hidden="true">
				<?php endif; ?>

					<span class="nexus-icon-box__icon">
						<?php \Elementor\Icons_Manager::render_icon( $settings['icon'], array( 'aria-hidden' => 'true' ) ); ?>
					</span>

				<?php if ( $has_link ) : ?>
					</a>
				<?php endif; ?>
			</div>

			<div class="nexus-icon-box__content">
				<?php if ( $settings['title'] ) : ?>
					<<?php echo esc_attr( $title_tag ); ?> class="nexus-icon-box__title">
						<?php if ( $has_link ) : ?>
							<a <?php $this->print_render_attribute_string( 'icon_link' ); ?>>
								<?php echo esc_html( $settings['title'] ); ?>
							</a>
						<?php else : ?>
							<?php echo esc_html( $settings['title'] ); ?>
						<?php endif; ?>
					</<?php echo esc_attr( $title_tag ); ?>>
				<?php endif; ?>

				<?php if ( $settings['description'] ) : ?>
					<p class="nexus-icon-box__desc">
						<?php echo wp_kses_post( $settings['description'] ); ?>
					</p>
				<?php endif; ?>

				<?php if ( $has_link && $settings['link_text'] ) : ?>
					<a <?php $this->print_render_attribute_string( 'read_more_link' ); ?> class="nexus-icon-box__link">
						<?php echo esc_html( $settings['link_text'] ); ?>
					</a>
				<?php endif; ?>
			</div>

		</div>

		<?php
	}
}
