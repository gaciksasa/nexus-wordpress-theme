<?php
/**
 * Nexus Theme - Elementor Pricing Table Widget
 *
 * Pricing table with features list and CTA button.
 *
 * @package Nexus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Nexus_Widget_Pricing_Table
 */
class Nexus_Widget_Pricing_Table extends \Elementor\Widget_Base {

	public function get_name() {
		return 'nexus-pricing-table';
	}

	public function get_title() {
		return esc_html__( 'Pricing Table', 'nexus' );
	}

	public function get_icon() {
		return 'eicon-price-table';
	}

	public function get_categories() {
		return array( 'nexus-elements' );
	}

	public function get_keywords() {
		return array( 'pricing', 'price', 'plan', 'table', 'nexus' );
	}

	protected function register_controls() {

		// ---------------------------------------------------------------
		// CONTENT: Header
		// ---------------------------------------------------------------
		$this->start_controls_section(
			'section_header',
			array( 'label' => esc_html__( 'Header', 'nexus' ) )
		);

		$this->add_control(
			'plan_name',
			array(
				'label'   => esc_html__( 'Plan Name', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Professional', 'nexus' ),
				'dynamic' => array( 'active' => true ),
			)
		);

		$this->add_control(
			'plan_icon',
			array(
				'label'   => esc_html__( 'Plan Icon', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::ICONS,
				'default' => array(
					'value'   => 'ri-rocket-2-line',
					'library' => 'remix-icon',
				),
			)
		);

		$this->add_control(
			'plan_description',
			array(
				'label'   => esc_html__( 'Description', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'For growing businesses', 'nexus' ),
				'dynamic' => array( 'active' => true ),
			)
		);

		$this->end_controls_section();

		// ---------------------------------------------------------------
		// CONTENT: Price
		// ---------------------------------------------------------------
		$this->start_controls_section(
			'section_price',
			array( 'label' => esc_html__( 'Price', 'nexus' ) )
		);

		$this->add_control(
			'currency',
			array(
				'label'   => esc_html__( 'Currency', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => '$',
			)
		);

		$this->add_control(
			'price',
			array(
				'label'   => esc_html__( 'Price', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => '49',
				'dynamic' => array( 'active' => true ),
			)
		);

		$this->add_control(
			'period',
			array(
				'label'   => esc_html__( 'Period', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( '/ month', 'nexus' ),
			)
		);

		$this->add_control(
			'original_price',
			array(
				'label'   => esc_html__( 'Original Price (Strike-through)', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => '',
				'dynamic' => array( 'active' => true ),
			)
		);

		$this->end_controls_section();

		// ---------------------------------------------------------------
		// CONTENT: Features
		// ---------------------------------------------------------------
		$this->start_controls_section(
			'section_features',
			array( 'label' => esc_html__( 'Features', 'nexus' ) )
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'text',
			array(
				'label'   => esc_html__( 'Feature Text', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Feature item', 'nexus' ),
				'dynamic' => array( 'active' => true ),
			)
		);

		$repeater->add_control(
			'available',
			array(
				'label'   => esc_html__( 'Available', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$this->add_control(
			'features',
			array(
				'label'       => esc_html__( 'Features', 'nexus' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'text'      => esc_html__( '10 Projects', 'nexus' ),
						'available' => 'yes',
					),
					array(
						'text'      => esc_html__( '50 GB Storage', 'nexus' ),
						'available' => 'yes',
					),
					array(
						'text'      => esc_html__( 'Email Support', 'nexus' ),
						'available' => 'yes',
					),
					array(
						'text'      => esc_html__( 'API Access', 'nexus' ),
						'available' => 'yes',
					),
					array(
						'text'      => esc_html__( 'Custom Domain', 'nexus' ),
						'available' => '',
					),
					array(
						'text'      => esc_html__( 'Priority Support', 'nexus' ),
						'available' => '',
					),
				),
				'title_field' => '{{{ text }}}',
			)
		);

		$this->end_controls_section();

		// ---------------------------------------------------------------
		// CONTENT: Button
		// ---------------------------------------------------------------
		$this->start_controls_section(
			'section_button',
			array( 'label' => esc_html__( 'Button', 'nexus' ) )
		);

		$this->add_control(
			'btn_text',
			array(
				'label'   => esc_html__( 'Button Text', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Get Started', 'nexus' ),
			)
		);

		$this->add_control(
			'btn_link',
			array(
				'label'   => esc_html__( 'Button Link', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::URL,
				'dynamic' => array( 'active' => true ),
			)
		);

		$this->add_control(
			'btn_style',
			array(
				'label'   => esc_html__( 'Button Style', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'primary',
				'options' => array(
					'primary'       => esc_html__( 'Primary', 'nexus' ),
					'outline'       => esc_html__( 'Outline', 'nexus' ),
					'outline-white' => esc_html__( 'Outline White', 'nexus' ),
				),
			)
		);

		$this->end_controls_section();

		// ---------------------------------------------------------------
		// CONTENT: Badge
		// ---------------------------------------------------------------
		$this->start_controls_section(
			'section_badge',
			array( 'label' => esc_html__( 'Badge', 'nexus' ) )
		);

		$this->add_control(
			'is_featured',
			array(
				'label'   => esc_html__( 'Featured / Most Popular', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => '',
			)
		);

		$this->add_control(
			'badge_text',
			array(
				'label'     => esc_html__( 'Badge Text', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => esc_html__( 'Most Popular', 'nexus' ),
				'condition' => array( 'is_featured' => 'yes' ),
			)
		);

		$this->end_controls_section();

		// ---------------------------------------------------------------
		// STYLE: Table
		// ---------------------------------------------------------------
		$this->start_controls_section(
			'section_style_table',
			array(
				'label' => esc_html__( 'Table', 'nexus' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			array(
				'name'     => 'table_bg',
				'selector' => '{{WRAPPER}} .nexus-pricing-table',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'table_border',
				'selector' => '{{WRAPPER}} .nexus-pricing-table',
			)
		);

		$this->add_control(
			'table_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'nexus' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .nexus-pricing-table' => 'border-radius: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'table_shadow',
				'selector' => '{{WRAPPER}} .nexus-pricing-table',
			)
		);

		$this->end_controls_section();

		// ---------------------------------------------------------------
		// STYLE: Header
		// ---------------------------------------------------------------
		$this->start_controls_section(
			'section_style_header',
			array(
				'label' => esc_html__( 'Header', 'nexus' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			array(
				'name'     => 'header_bg',
				'selector' => '{{WRAPPER}} .nexus-pricing-table__header',
			)
		);

		$this->add_control(
			'plan_name_color',
			array(
				'label'     => esc_html__( 'Plan Name Color', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .nexus-pricing-table__plan-name' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'price_color',
			array(
				'label'     => esc_html__( 'Price Color', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .nexus-pricing-table__amount' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'price_typography',
				'label'    => esc_html__( 'Price Typography', 'nexus' ),
				'selector' => '{{WRAPPER}} .nexus-pricing-table__amount',
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings    = $this->get_settings_for_display();
		$is_featured = 'yes' === $settings['is_featured'];

		$wrapper_class = 'nexus-pricing-table';
		if ( $is_featured ) {
			$wrapper_class .= ' nexus-pricing-table--featured';
		}
		?>

		<div class="<?php echo esc_attr( $wrapper_class ); ?>">

			<?php if ( $is_featured && $settings['badge_text'] ) : ?>
				<div class="nexus-pricing-table__badge"><?php echo esc_html( $settings['badge_text'] ); ?></div>
			<?php endif; ?>

			<div class="nexus-pricing-table__header">
				<?php if ( ! empty( $settings['plan_icon']['value'] ) ) : ?>
					<div class="nexus-pricing-table__icon" aria-hidden="true">
						<?php \Elementor\Icons_Manager::render_icon( $settings['plan_icon'], array( 'aria-hidden' => 'true' ) ); ?>
					</div>
				<?php endif; ?>

				<?php if ( $settings['plan_name'] ) : ?>
					<h3 class="nexus-pricing-table__plan-name"><?php echo esc_html( $settings['plan_name'] ); ?></h3>
				<?php endif; ?>

				<?php if ( $settings['plan_description'] ) : ?>
					<p class="nexus-pricing-table__plan-desc"><?php echo esc_html( $settings['plan_description'] ); ?></p>
				<?php endif; ?>

				<div class="nexus-pricing-table__price-wrap">
					<div class="nexus-pricing-table__price">
						<?php if ( $settings['currency'] ) : ?>
							<span class="nexus-pricing-table__currency"><?php echo esc_html( $settings['currency'] ); ?></span>
						<?php endif; ?>
						<span class="nexus-pricing-table__amount"><?php echo esc_html( $settings['price'] ); ?></span>
					</div>
					<?php if ( $settings['original_price'] ) : ?>
						<span class="nexus-pricing-table__original"><?php echo esc_html( $settings['currency'] . $settings['original_price'] ); ?></span>
					<?php endif; ?>
					<?php if ( $settings['period'] ) : ?>
						<span class="nexus-pricing-table__period"><?php echo esc_html( $settings['period'] ); ?></span>
					<?php endif; ?>
				</div>
			</div>

			<div class="nexus-pricing-table__features">
				<ul>
					<?php foreach ( $settings['features'] as $feature ) : ?>
						<li class="nexus-pricing-table__feature<?php echo 'yes' !== $feature['available'] ? ' is-unavailable' : ''; ?>">
							<span class="nexus-pricing-table__feature-icon" aria-hidden="true">
								<?php echo 'yes' === $feature['available'] ? '&#10003;' : '&#10007;'; ?>
							</span>
							<span><?php echo esc_html( $feature['text'] ); ?></span>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>

			<?php if ( $settings['btn_text'] ) : ?>
				<div class="nexus-pricing-table__footer">
					<?php
					$btn_url    = ! empty( $settings['btn_link']['url'] ) ? esc_url( $settings['btn_link']['url'] ) : '#';
					$btn_target = ! empty( $settings['btn_link']['is_external'] ) ? 'target="_blank" rel="noopener noreferrer"' : '';
					$btn_class  = 'nexus-btn nexus-btn--' . esc_attr( $settings['btn_style'] ) . ' nexus-btn--full';
					?>
					<a href="<?php echo $btn_url; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>" class="<?php echo esc_attr( $btn_class ); ?>" <?php echo $btn_target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
						<?php echo esc_html( $settings['btn_text'] ); ?>
					</a>
				</div>
			<?php endif; ?>

		</div><!-- .nexus-pricing-table -->
		<?php
	}
}
