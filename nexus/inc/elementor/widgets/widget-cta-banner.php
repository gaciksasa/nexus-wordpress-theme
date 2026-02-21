<?php
/**
 * Nexus Theme - Elementor CTA Banner Widget
 *
 * Call-to-action banner with headline, subtext, and buttons.
 *
 * @package Nexus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Nexus_Widget_CTA_Banner
 */
class Nexus_Widget_CTA_Banner extends \Elementor\Widget_Base {

	public function get_name() {
		return 'nexus-cta-banner';
	}

	public function get_title() {
		return esc_html__( 'CTA Banner', 'nexus' );
	}

	public function get_icon() {
		return 'eicon-call-to-action';
	}

	public function get_categories() {
		return array( 'nexus-elements' );
	}

	public function get_keywords() {
		return array( 'cta', 'call to action', 'banner', 'button', 'nexus' );
	}

	protected function register_controls() {

		// ---------------------------------------------------------------
		// CONTENT
		// ---------------------------------------------------------------
		$this->start_controls_section(
			'section_content',
			array( 'label' => esc_html__( 'Content', 'nexus' ) )
		);

		$this->add_control(
			'tagline',
			array(
				'label'   => esc_html__( 'Tagline', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => '',
				'dynamic' => array( 'active' => true ),
			)
		);

		$this->add_control(
			'headline',
			array(
				'label'   => esc_html__( 'Headline', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'rows'    => 3,
				'default' => esc_html__( 'Ready to Get Started?', 'nexus' ),
				'dynamic' => array( 'active' => true ),
			)
		);

		$this->add_control(
			'headline_tag',
			array(
				'label'   => esc_html__( 'Headline Tag', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'h2',
				'options' => array(
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'p'  => 'P',
				),
			)
		);

		$this->add_control(
			'description',
			array(
				'label'   => esc_html__( 'Description', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'rows'    => 3,
				'default' => esc_html__( 'Join thousands of satisfied customers and take your business to the next level today.', 'nexus' ),
				'dynamic' => array( 'active' => true ),
			)
		);

		$this->end_controls_section();

		// ---------------------------------------------------------------
		// CONTENT: Buttons
		// ---------------------------------------------------------------
		$this->start_controls_section(
			'section_buttons',
			array( 'label' => esc_html__( 'Buttons', 'nexus' ) )
		);

		$this->add_control(
			'btn1_text',
			array(
				'label'   => esc_html__( 'Primary Button', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Get Started', 'nexus' ),
			)
		);

		$this->add_control(
			'btn1_link',
			array(
				'label'   => esc_html__( 'Primary Button Link', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::URL,
				'dynamic' => array( 'active' => true ),
			)
		);

		$this->add_control(
			'btn1_style',
			array(
				'label'   => esc_html__( 'Primary Button Style', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'primary',
				'options' => array(
					'primary'       => esc_html__( 'Primary', 'nexus' ),
					'white'         => esc_html__( 'White', 'nexus' ),
					'outline-white' => esc_html__( 'Outline White', 'nexus' ),
					'outline'       => esc_html__( 'Outline', 'nexus' ),
				),
			)
		);

		$this->add_control(
			'btn2_text',
			array(
				'label'     => esc_html__( 'Secondary Button', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => '',
				'separator' => 'before',
			)
		);

		$this->add_control(
			'btn2_link',
			array(
				'label'   => esc_html__( 'Secondary Button Link', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::URL,
				'dynamic' => array( 'active' => true ),
			)
		);

		$this->add_control(
			'btn2_style',
			array(
				'label'   => esc_html__( 'Secondary Button Style', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'outline-white',
				'options' => array(
					'outline-white' => esc_html__( 'Outline White', 'nexus' ),
					'outline'       => esc_html__( 'Outline', 'nexus' ),
					'text'          => esc_html__( 'Text Link', 'nexus' ),
				),
			)
		);

		$this->end_controls_section();

		// ---------------------------------------------------------------
		// STYLE: Layout
		// ---------------------------------------------------------------
		$this->start_controls_section(
			'section_style_layout',
			array(
				'label' => esc_html__( 'Layout', 'nexus' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'layout',
			array(
				'label'   => esc_html__( 'Layout', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'centered',
				'options' => array(
					'centered'   => esc_html__( 'Centered', 'nexus' ),
					'left-right' => esc_html__( 'Text Left / Buttons Right', 'nexus' ),
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			array(
				'name'     => 'banner_bg',
				'selector' => '{{WRAPPER}} .nexus-cta-banner',
			)
		);

		$this->add_responsive_control(
			'banner_padding',
			array(
				'label'      => esc_html__( 'Padding', 'nexus' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', 'vw' ),
				'selectors'  => array(
					'{{WRAPPER}} .nexus-cta-banner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'banner_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'nexus' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .nexus-cta-banner' => 'border-radius: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		// ---------------------------------------------------------------
		// STYLE: Typography
		// ---------------------------------------------------------------
		$this->start_controls_section(
			'section_style_type',
			array(
				'label' => esc_html__( 'Typography', 'nexus' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'tagline_color',
			array(
				'label'     => esc_html__( 'Tagline Color', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .nexus-cta-banner__tagline' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'headline_color',
			array(
				'label'     => esc_html__( 'Headline Color', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .nexus-cta-banner__headline' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'headline_typography',
				'selector' => '{{WRAPPER}} .nexus-cta-banner__headline',
			)
		);

		$this->add_control(
			'desc_color',
			array(
				'label'     => esc_html__( 'Description Color', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(255,255,255,0.85)',
				'selectors' => array(
					'{{WRAPPER}} .nexus-cta-banner__desc' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$layout   = $settings['layout'] ?? 'centered';
		$htag     = in_array( $settings['headline_tag'] ?? 'h2', array( 'h1', 'h2', 'h3', 'h4', 'p' ), true ) ? $settings['headline_tag'] : 'h2';
		?>

		<div class="nexus-cta-banner nexus-cta-banner--<?php echo esc_attr( $layout ); ?>">
			<div class="nexus-cta-banner__inner nexus-container">

				<div class="nexus-cta-banner__text">
					<?php if ( $settings['tagline'] ) : ?>
						<p class="nexus-cta-banner__tagline"><?php echo esc_html( $settings['tagline'] ); ?></p>
					<?php endif; ?>

					<?php if ( $settings['headline'] ) : ?>
						<<?php echo esc_attr( $htag ); ?> class="nexus-cta-banner__headline">
							<?php echo wp_kses_post( $settings['headline'] ); ?>
						</<?php echo esc_attr( $htag ); ?>>
					<?php endif; ?>

					<?php if ( $settings['description'] ) : ?>
						<p class="nexus-cta-banner__desc"><?php echo wp_kses_post( $settings['description'] ); ?></p>
					<?php endif; ?>
				</div>

				<?php if ( $settings['btn1_text'] || $settings['btn2_text'] ) : ?>
					<div class="nexus-cta-banner__actions">

						<?php if ( $settings['btn1_text'] ) : ?>
							<?php
							$b1_url    = ! empty( $settings['btn1_link']['url'] ) ? esc_url( $settings['btn1_link']['url'] ) : '#';
							$b1_target = ! empty( $settings['btn1_link']['is_external'] ) ? 'target="_blank" rel="noopener noreferrer"' : '';
							$b1_class  = 'nexus-btn nexus-btn--' . esc_attr( $settings['btn1_style'] );
							?>
							<a href="<?php echo $b1_url; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>" class="<?php echo esc_attr( $b1_class ); ?>" <?php echo $b1_target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
								<?php echo esc_html( $settings['btn1_text'] ); ?>
							</a>
						<?php endif; ?>

						<?php if ( $settings['btn2_text'] ) : ?>
							<?php
							$b2_url    = ! empty( $settings['btn2_link']['url'] ) ? esc_url( $settings['btn2_link']['url'] ) : '#';
							$b2_target = ! empty( $settings['btn2_link']['is_external'] ) ? 'target="_blank" rel="noopener noreferrer"' : '';
							$b2_class  = 'nexus-btn nexus-btn--' . esc_attr( $settings['btn2_style'] );
							?>
							<a href="<?php echo $b2_url; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>" class="<?php echo esc_attr( $b2_class ); ?>" <?php echo $b2_target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
								<?php echo esc_html( $settings['btn2_text'] ); ?>
							</a>
						<?php endif; ?>

					</div>
				<?php endif; ?>

			</div>
		</div>
		<?php
	}
}
