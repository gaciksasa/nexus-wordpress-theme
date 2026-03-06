<?php
/**
 * Nexus Theme - Elementor Pricing Table Widget
 *
 * Multi-plan pricing grid with 6 style presets.
 * All colors use CSS custom properties for palette + dark mode support.
 * Staggered entrance animation via IntersectionObserver.
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
		return array( 'pricing', 'price', 'plan', 'table', 'subscription', 'nexus' );
	}

	// -----------------------------------------------------------------
	// Preset defaults
	// -----------------------------------------------------------------

	private function get_preset_defaults( $preset ) {
		$map = array(
			'clean-flat'       => array(
				'tagline'     => 'Pricing',
				'headline'    => 'Simple, Transparent Pricing',
				'description' => 'No hidden fees. Choose a plan that works for you.',
				'columns'     => 3,
			),
			'gradient-header'  => array(
				'tagline'     => 'Plans',
				'headline'    => 'Choose Your Perfect Plan',
				'description' => '',
				'columns'     => 3,
			),
			'dark-elevated'    => array(
				'tagline'     => 'Pricing',
				'headline'    => 'Invest in Your Growth',
				'description' => '',
				'columns'     => 3,
			),
			'bordered-minimal' => array(
				'tagline'     => 'Plans & Pricing',
				'headline'    => 'Flexible Plans for Every Team',
				'description' => 'Start free, upgrade when you need to.',
				'columns'     => 3,
			),
			'ribbon-accent'    => array(
				'tagline'     => 'Pricing',
				'headline'    => 'Plans That Scale With You',
				'description' => '',
				'columns'     => 3,
			),
			'glass-modern'     => array(
				'tagline'     => 'Get Started',
				'headline'    => 'Premium Plans for Everyone',
				'description' => '',
				'columns'     => 3,
			),
		);

		return $map[ $preset ] ?? $map['clean-flat'];
	}

	private function get_default_plans() {
		return array(
			array(
				'plan_name'   => 'Starter',
				'plan_desc'   => 'For individuals',
				'plan_icon'   => array( 'value' => 'ri-user-line', 'library' => 'remix-icon' ),
				'currency'    => '$',
				'price'       => '19',
				'period'      => '/ month',
				'original_price' => '',
				'is_featured' => '',
				'badge_text'  => '',
				'btn_text'    => 'Get Started',
				'btn_link'    => array( 'url' => '#' ),
				'features'    => "5 Projects\n10 GB Storage\nEmail Support\nBasic Analytics",
				'disabled_features' => "API Access\nCustom Domain\nPriority Support",
			),
			array(
				'plan_name'   => 'Professional',
				'plan_desc'   => 'For growing businesses',
				'plan_icon'   => array( 'value' => 'ri-rocket-2-line', 'library' => 'remix-icon' ),
				'currency'    => '$',
				'price'       => '49',
				'period'      => '/ month',
				'original_price' => '',
				'is_featured' => 'yes',
				'badge_text'  => 'Most Popular',
				'btn_text'    => 'Get Started',
				'btn_link'    => array( 'url' => '#' ),
				'features'    => "25 Projects\n100 GB Storage\nPriority Support\nAdvanced Analytics\nAPI Access",
				'disabled_features' => "Custom Domain\nDedicated Manager",
			),
			array(
				'plan_name'   => 'Enterprise',
				'plan_desc'   => 'For large teams',
				'plan_icon'   => array( 'value' => 'ri-building-2-line', 'library' => 'remix-icon' ),
				'currency'    => '$',
				'price'       => '99',
				'period'      => '/ month',
				'original_price' => '',
				'is_featured' => '',
				'badge_text'  => '',
				'btn_text'    => 'Contact Sales',
				'btn_link'    => array( 'url' => '#' ),
				'features'    => "Unlimited Projects\n1 TB Storage\n24/7 Support\nAdvanced Analytics\nAPI Access\nCustom Domain\nDedicated Manager",
				'disabled_features' => "",
			),
		);
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
				'default'     => 'clean-flat',
				'options'     => array(
					'clean-flat'       => esc_html__( '1 — Clean Flat', 'nexus' ),
					'gradient-header'  => esc_html__( '2 — Gradient Header', 'nexus' ),
					'dark-elevated'    => esc_html__( '3 — Dark Elevated', 'nexus' ),
					'bordered-minimal' => esc_html__( '4 — Bordered Minimal', 'nexus' ),
					'ribbon-accent'    => esc_html__( '5 — Ribbon Accent', 'nexus' ),
					'glass-modern'     => esc_html__( '6 — Glass Modern', 'nexus' ),
				),
				'render_type' => 'template',
			)
		);

		$this->add_control(
			'entrance_animation',
			array(
				'label'       => esc_html__( 'Entrance Animation', 'nexus' ),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'default'     => 'fadeInUp',
				'options'     => array(
					'none'       => esc_html__( 'None', 'nexus' ),
					'fadeInUp'   => esc_html__( 'Fade In Up', 'nexus' ),
					'fadeInLeft' => esc_html__( 'Fade In Left', 'nexus' ),
					'zoomIn'     => esc_html__( 'Zoom In', 'nexus' ),
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

		$this->add_control( 'tagline', array(
			'label'       => esc_html__( 'Tagline', 'nexus' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => '',
			'placeholder' => esc_html__( 'Auto-filled from preset', 'nexus' ),
		) );

		$this->add_control( 'headline', array(
			'label'       => esc_html__( 'Headline', 'nexus' ),
			'type'        => \Elementor\Controls_Manager::TEXTAREA,
			'rows'        => 2,
			'default'     => '',
			'placeholder' => esc_html__( 'Auto-filled from preset', 'nexus' ),
			'dynamic'     => array( 'active' => true ),
		) );

		$this->add_control( 'description', array(
			'label'       => esc_html__( 'Description', 'nexus' ),
			'type'        => \Elementor\Controls_Manager::TEXTAREA,
			'rows'        => 3,
			'default'     => '',
			'placeholder' => esc_html__( 'Auto-filled from preset', 'nexus' ),
			'dynamic'     => array( 'active' => true ),
		) );

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

		// ---- Plans Repeater ----
		$this->start_controls_section(
			'section_plans',
			array( 'label' => esc_html__( 'Plans', 'nexus' ) )
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control( 'plan_name', array(
			'label'   => esc_html__( 'Plan Name', 'nexus' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => esc_html__( 'Professional', 'nexus' ),
			'dynamic' => array( 'active' => true ),
		) );

		$repeater->add_control( 'plan_desc', array(
			'label'   => esc_html__( 'Plan Description', 'nexus' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => esc_html__( 'For growing businesses', 'nexus' ),
		) );

		$repeater->add_control( 'plan_icon', array(
			'label'   => esc_html__( 'Plan Icon', 'nexus' ),
			'type'    => \Elementor\Controls_Manager::ICONS,
			'default' => array( 'value' => 'ri-rocket-2-line', 'library' => 'remix-icon' ),
		) );

		$repeater->add_control( 'currency', array(
			'label'   => esc_html__( 'Currency', 'nexus' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => '$',
		) );

		$repeater->add_control( 'price', array(
			'label'   => esc_html__( 'Price', 'nexus' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => '49',
			'dynamic' => array( 'active' => true ),
		) );

		$repeater->add_control( 'period', array(
			'label'   => esc_html__( 'Period', 'nexus' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => esc_html__( '/ month', 'nexus' ),
		) );

		$repeater->add_control( 'original_price', array(
			'label'   => esc_html__( 'Original Price (Strike-through)', 'nexus' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => '',
		) );

		$repeater->add_control( 'is_featured', array(
			'label'   => esc_html__( 'Featured / Most Popular', 'nexus' ),
			'type'    => \Elementor\Controls_Manager::SWITCHER,
			'default' => '',
		) );

		$repeater->add_control( 'badge_text', array(
			'label'     => esc_html__( 'Badge Text', 'nexus' ),
			'type'      => \Elementor\Controls_Manager::TEXT,
			'default'   => esc_html__( 'Most Popular', 'nexus' ),
			'condition' => array( 'is_featured' => 'yes' ),
		) );

		$repeater->add_control( 'btn_text', array(
			'label'   => esc_html__( 'Button Text', 'nexus' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => esc_html__( 'Get Started', 'nexus' ),
		) );

		$repeater->add_control( 'btn_link', array(
			'label'   => esc_html__( 'Button Link', 'nexus' ),
			'type'    => \Elementor\Controls_Manager::URL,
			'dynamic' => array( 'active' => true ),
		) );

		$repeater->add_control( 'features', array(
			'label'       => esc_html__( 'Available Features (one per line)', 'nexus' ),
			'type'        => \Elementor\Controls_Manager::TEXTAREA,
			'rows'        => 5,
			'default'     => "Feature One\nFeature Two\nFeature Three",
			'description' => esc_html__( 'Enter one feature per line.', 'nexus' ),
		) );

		$repeater->add_control( 'disabled_features', array(
			'label'       => esc_html__( 'Unavailable Features (one per line)', 'nexus' ),
			'type'        => \Elementor\Controls_Manager::TEXTAREA,
			'rows'        => 3,
			'default'     => '',
			'description' => esc_html__( 'Shown with strike-through.', 'nexus' ),
		) );

		$this->add_control(
			'plans',
			array(
				'label'       => esc_html__( 'Plans', 'nexus' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => $this->get_default_plans(),
				'title_field' => '{{{ plan_name }}} — {{{ currency }}}{{{ price }}}',
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
				'default'        => 'auto',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options'        => array(
					'auto' => esc_html__( 'Auto (from preset)', 'nexus' ),
					'2'    => '2',
					'3'    => '3',
					'4'    => '4',
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

		$this->add_control( 'tagline_color', array(
			'label'     => esc_html__( 'Tagline Color', 'nexus' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => array( '{{WRAPPER}} .nexus-pt__tagline' => 'color: {{VALUE}};' ),
		) );

		$this->add_control( 'heading_color_ctrl', array(
			'label'     => esc_html__( 'Heading Color', 'nexus' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => array( '{{WRAPPER}} .nexus-pt__title' => 'color: {{VALUE}};' ),
		) );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'heading_typography',
				'label'    => esc_html__( 'Heading Typography', 'nexus' ),
				'selector' => '{{WRAPPER}} .nexus-pt__title',
			)
		);

		$this->end_controls_section();

		// ---- Style: Cards ----
		$this->start_controls_section(
			'section_style_cards',
			array(
				'label' => esc_html__( 'Cards', 'nexus' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'price_typography',
				'label'    => esc_html__( 'Price Typography', 'nexus' ),
				'selector' => '{{WRAPPER}} .nexus-pt-card__amount',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'card_shadow',
				'selector' => '{{WRAPPER}} .nexus-pt-card',
			)
		);

		$this->end_controls_section();
	}

	// -----------------------------------------------------------------
	// Render
	// -----------------------------------------------------------------

	protected function render() {
		$settings  = $this->get_settings_for_display();
		$preset    = $settings['style_preset'] ?? 'clean-flat';
		$defaults  = $this->get_preset_defaults( $preset );
		$animation = $settings['entrance_animation'] ?? 'fadeInUp';
		$is_editor = \Elementor\Plugin::$instance->editor->is_edit_mode();
		$widget_id = 'nexus-pt-' . $this->get_id();

		$tagline     = ( '' !== $settings['tagline'] ) ? $settings['tagline'] : ( $defaults['tagline'] ?? '' );
		$headline    = ( '' !== $settings['headline'] ) ? $settings['headline'] : ( $defaults['headline'] ?? '' );
		$description = ( '' !== $settings['description'] ) ? $settings['description'] : ( $defaults['description'] ?? '' );
		$align       = $settings['header_align'] ?? 'center';

		// Columns.
		$cols_setting = $settings['columns'] ?? 'auto';
		$columns      = ( 'auto' === $cols_setting ) ? $defaults['columns'] : absint( $cols_setting );

		$plans = $settings['plans'] ?? array();
		if ( empty( $plans ) ) {
			return;
		}

		$has_anim = ( 'none' !== $animation && ! $is_editor );
		?>

		<section
			class="nexus-pt nexus-pt--<?php echo esc_attr( $preset ); ?>"
			id="<?php echo esc_attr( $widget_id ); ?>"
			style="--nexus-pt-cols:<?php echo esc_attr( $columns ); ?>;"
		>
			<div class="nexus-container">

				<?php if ( $tagline || $headline || $description ) : ?>
				<div class="nexus-pt__header nexus-pt__header--<?php echo esc_attr( $align ); ?>">
					<?php if ( $tagline ) : ?>
						<span class="nexus-pt__tagline"><?php echo esc_html( $tagline ); ?></span>
					<?php endif; ?>
					<?php if ( $headline ) : ?>
						<h2 class="nexus-pt__title"><?php echo wp_kses_post( $headline ); ?></h2>
					<?php endif; ?>
					<?php if ( $description ) : ?>
						<p class="nexus-pt__desc"><?php echo wp_kses_post( $description ); ?></p>
					<?php endif; ?>
				</div>
				<?php endif; ?>

				<div class="nexus-pt__grid">
					<?php foreach ( $plans as $idx => $plan ) :
						$delay       = $idx * 120;
						$anim_cls    = $has_anim ? 'nexus-pt-card--anim' : 'is-visible';
						$is_featured = 'yes' === ( $plan['is_featured'] ?? '' );
						$feat_cls    = $is_featured ? ' nexus-pt-card--featured' : '';

						// Parse features.
						$features_list  = array_filter( array_map( 'trim', explode( "\n", $plan['features'] ?? '' ) ) );
						$disabled_list  = array_filter( array_map( 'trim', explode( "\n", $plan['disabled_features'] ?? '' ) ) );
					?>
					<div class="nexus-pt-card <?php echo esc_attr( $anim_cls . $feat_cls ); ?>"<?php echo $has_anim ? ' data-pt-delay="' . esc_attr( $delay ) . '"' : ''; ?>>

						<?php if ( $is_featured && ! empty( $plan['badge_text'] ) ) : ?>
							<div class="nexus-pt-card__badge"><?php echo esc_html( $plan['badge_text'] ); ?></div>
						<?php endif; ?>

						<div class="nexus-pt-card__header">
							<?php if ( ! empty( $plan['plan_icon']['value'] ) ) : ?>
								<div class="nexus-pt-card__icon" aria-hidden="true">
									<?php \Elementor\Icons_Manager::render_icon( $plan['plan_icon'], array( 'aria-hidden' => 'true' ) ); ?>
								</div>
							<?php endif; ?>

							<?php if ( ! empty( $plan['plan_name'] ) ) : ?>
								<h3 class="nexus-pt-card__plan-name"><?php echo esc_html( $plan['plan_name'] ); ?></h3>
							<?php endif; ?>

							<?php if ( ! empty( $plan['plan_desc'] ) ) : ?>
								<p class="nexus-pt-card__plan-desc"><?php echo esc_html( $plan['plan_desc'] ); ?></p>
							<?php endif; ?>
						</div>

						<div class="nexus-pt-card__price-wrap">
							<div class="nexus-pt-card__price">
								<?php if ( ! empty( $plan['currency'] ) ) : ?>
									<span class="nexus-pt-card__currency"><?php echo esc_html( $plan['currency'] ); ?></span>
								<?php endif; ?>
								<span class="nexus-pt-card__amount"><?php echo esc_html( $plan['price'] ?? '0' ); ?></span>
							</div>
							<?php if ( ! empty( $plan['original_price'] ) ) : ?>
								<span class="nexus-pt-card__original"><?php echo esc_html( ( $plan['currency'] ?? '' ) . $plan['original_price'] ); ?></span>
							<?php endif; ?>
							<?php if ( ! empty( $plan['period'] ) ) : ?>
								<span class="nexus-pt-card__period"><?php echo esc_html( $plan['period'] ); ?></span>
							<?php endif; ?>
						</div>

						<?php if ( $features_list || $disabled_list ) : ?>
						<ul class="nexus-pt-card__features">
							<?php foreach ( $features_list as $feat ) : ?>
								<li class="nexus-pt-card__feature">
									<span class="nexus-pt-card__feature-icon nexus-pt-card__feature-icon--yes" aria-hidden="true">
										<i class="ri-check-line"></i>
									</span>
									<span><?php echo esc_html( $feat ); ?></span>
								</li>
							<?php endforeach; ?>
							<?php foreach ( $disabled_list as $feat ) : ?>
								<li class="nexus-pt-card__feature nexus-pt-card__feature--disabled">
									<span class="nexus-pt-card__feature-icon nexus-pt-card__feature-icon--no" aria-hidden="true">
										<i class="ri-close-line"></i>
									</span>
									<span><?php echo esc_html( $feat ); ?></span>
								</li>
							<?php endforeach; ?>
						</ul>
						<?php endif; ?>

						<?php if ( ! empty( $plan['btn_text'] ) ) : ?>
						<div class="nexus-pt-card__footer">
							<?php
							$btn_url    = ! empty( $plan['btn_link']['url'] ) ? esc_url( $plan['btn_link']['url'] ) : '#';
							$btn_target = ! empty( $plan['btn_link']['is_external'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';
							$btn_class  = 'nexus-pt-card__btn';
							if ( $is_featured ) {
								$btn_class .= ' nexus-pt-card__btn--featured';
							}
							?>
							<a href="<?php echo $btn_url; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>" class="<?php echo esc_attr( $btn_class ); ?>"<?php echo $btn_target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
								<?php echo esc_html( $plan['btn_text'] ); ?>
							</a>
						</div>
						<?php endif; ?>

					</div>
					<?php endforeach; ?>
				</div>

			</div>
		</section>

		<?php if ( $has_anim ) : ?>
		<script>
		(function(){
			var container=document.getElementById('<?php echo esc_js( $widget_id ); ?>');
			if(!container)return;
			var items=container.querySelectorAll('.nexus-pt-card--anim');
			if(!items.length)return;
			var io=new IntersectionObserver(function(entries){
				entries.forEach(function(e){
					if(e.isIntersecting){
						var d=parseInt(e.target.getAttribute('data-pt-delay'),10)||0;
						setTimeout(function(){e.target.classList.add('is-visible');},d);
						io.unobserve(e.target);
					}
				});
			},{threshold:0.1});
			items.forEach(function(c){io.observe(c);});
		})();
		</script>
		<?php endif; ?>

		<?php
	}
}
