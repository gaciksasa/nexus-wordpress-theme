<?php
/**
 * Nexus Theme - Elementor Counter Widget
 *
 * Multi-item animated number counter with 6 style presets.
 * Each preset renders 3–4 counters in a distinct visual layout.
 *
 * @package Nexus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Nexus_Widget_Counter
 */
class Nexus_Widget_Counter extends \Elementor\Widget_Base {

	public function get_name() {
		return 'nexus-counter';
	}

	public function get_title() {
		return esc_html__( 'Counter', 'nexus' );
	}

	public function get_icon() {
		return 'eicon-counter';
	}

	public function get_categories() {
		return array( 'nexus-elements' );
	}

	public function get_keywords() {
		return array( 'counter', 'stat', 'number', 'count', 'animate', 'nexus' );
	}

	/**
	 * Returns color tokens for each style preset.
	 *
	 * @param string $preset Preset slug.
	 * @return array
	 */
	private function get_preset_colors( $preset ) {
		$presets = array(
			'minimal-row'     => array(
				'section_bg' => 'transparent',
				'icon'       => '#e94560',
				'number'     => '#1a1a2e',
				'prefix_sfx' => '#e94560',
				'title'      => '#6c757d',
				'desc'       => '#adb5bd',
				'divider'    => 'rgba(26,26,46,0.12)',
			),
			'dark-bold'       => array(
				'section_bg' => '#1a1a2e',
				'icon'       => '#e94560',
				'number'     => '#ffffff',
				'prefix_sfx' => '#e94560',
				'title'      => 'rgba(255,255,255,0.6)',
				'desc'       => 'rgba(255,255,255,0.4)',
				'divider'    => 'rgba(255,255,255,0.12)',
			),
			'icon-cards'      => array(
				'section_bg' => '#f8f9fa',
				'icon'       => '#ffffff',
				'icon_bg'    => '#e94560',
				'number'     => '#1a1a2e',
				'prefix_sfx' => '#1a1a2e',
				'title'      => '#6c757d',
				'desc'       => '#adb5bd',
				'card_bg'    => '#ffffff',
				'divider'    => 'transparent',
			),
			'gradient-bar'    => array(
				'section_bg' => '#0f0f23',
				'icon'       => '#e94560',
				'number'     => '#ffffff',
				'prefix_sfx' => '#667eea',
				'title'      => 'rgba(255,255,255,0.7)',
				'desc'       => 'rgba(255,255,255,0.4)',
				'divider'    => 'transparent',
				'grad_from'  => '#667eea',
				'grad_to'    => '#764ba2',
			),
			'accent-top'      => array(
				'section_bg' => 'transparent',
				'icon'       => '#e94560',
				'number'     => '#1a1a2e',
				'prefix_sfx' => '#e94560',
				'title'      => '#495057',
				'desc'       => '#adb5bd',
				'divider'    => 'rgba(26,26,46,0.08)',
				'accent'     => '#e94560',
			),
			'circle-icon'     => array(
				'section_bg' => '#ffffff',
				'icon'       => '#e94560',
				'number'     => '#1a1a2e',
				'prefix_sfx' => '#e94560',
				'title'      => '#6c757d',
				'desc'       => '#adb5bd',
				'divider'    => 'transparent',
				'circle_bg'  => 'rgba(233,69,96,0.08)',
			),
		);

		return $presets[ $preset ] ?? $presets['minimal-row'];
	}

	/**
	 * Returns default content values for each style preset.
	 *
	 * @param string $preset Preset slug.
	 * @return array
	 */
	private function get_preset_defaults( $preset ) {
		$map = array(
			'minimal-row'  => array(
				'tagline'  => '',
				'headline' => '',
				'columns'  => 4,
				'counters' => array(
					array( 'icon' => 'ri-user-smile-line', 'number' => 250, 'suffix' => '+', 'prefix' => '', 'title' => esc_html__( 'Happy Clients', 'nexus' ) ),
					array( 'icon' => 'ri-code-s-slash-line', 'number' => 480, 'suffix' => '+', 'prefix' => '', 'title' => esc_html__( 'Projects Done', 'nexus' ) ),
					array( 'icon' => 'ri-award-line', 'number' => 38, 'suffix' => '', 'prefix' => '', 'title' => esc_html__( 'Awards Won', 'nexus' ) ),
					array( 'icon' => 'ri-time-line', 'number' => 12, 'suffix' => '+', 'prefix' => '', 'title' => esc_html__( 'Years Experience', 'nexus' ) ),
				),
			),
			'dark-bold'    => array(
				'tagline'  => esc_html__( 'Our Impact', 'nexus' ),
				'headline' => esc_html__( 'Numbers That Speak', 'nexus' ),
				'columns'  => 4,
				'counters' => array(
					array( 'icon' => 'ri-team-line', 'number' => 1200, 'suffix' => '+', 'prefix' => '', 'title' => esc_html__( 'Clients Worldwide', 'nexus' ) ),
					array( 'icon' => 'ri-briefcase-4-line', 'number' => 850, 'suffix' => '+', 'prefix' => '', 'title' => esc_html__( 'Projects Completed', 'nexus' ) ),
					array( 'icon' => 'ri-medal-line', 'number' => 99, 'suffix' => '%', 'prefix' => '', 'title' => esc_html__( 'Client Satisfaction', 'nexus' ) ),
					array( 'icon' => 'ri-global-line', 'number' => 25, 'suffix' => '+', 'prefix' => '', 'title' => esc_html__( 'Countries Served', 'nexus' ) ),
				),
			),
			'icon-cards'   => array(
				'tagline'  => esc_html__( 'By the Numbers', 'nexus' ),
				'headline' => esc_html__( 'Our Achievements', 'nexus' ),
				'columns'  => 4,
				'counters' => array(
					array( 'icon' => 'ri-rocket-2-line', 'number' => 350, 'suffix' => '+', 'prefix' => '', 'title' => esc_html__( 'Products Launched', 'nexus' ) ),
					array( 'icon' => 'ri-star-line', 'number' => 98, 'suffix' => '%', 'prefix' => '', 'title' => esc_html__( 'Success Rate', 'nexus' ) ),
					array( 'icon' => 'ri-customer-service-2-line', 'number' => 24, 'suffix' => '/7', 'prefix' => '', 'title' => esc_html__( 'Support', 'nexus' ) ),
					array( 'icon' => 'ri-trophy-line', 'number' => 52, 'suffix' => '', 'prefix' => '', 'title' => esc_html__( 'Awards', 'nexus' ) ),
				),
			),
			'gradient-bar' => array(
				'tagline'  => esc_html__( 'Results That Matter', 'nexus' ),
				'headline' => esc_html__( 'Proven Track Record', 'nexus' ),
				'columns'  => 3,
				'counters' => array(
					array( 'icon' => 'ri-line-chart-line', 'number' => 500, 'suffix' => 'M+', 'prefix' => '$', 'title' => esc_html__( 'Revenue Generated', 'nexus' ) ),
					array( 'icon' => 'ri-speed-line', 'number' => 99, 'suffix' => '.9%', 'prefix' => '', 'title' => esc_html__( 'Uptime', 'nexus' ) ),
					array( 'icon' => 'ri-user-heart-line', 'number' => 10, 'suffix' => 'K+', 'prefix' => '', 'title' => esc_html__( 'Active Users', 'nexus' ) ),
				),
			),
			'accent-top'   => array(
				'tagline'  => '',
				'headline' => '',
				'columns'  => 4,
				'counters' => array(
					array( 'icon' => 'ri-bar-chart-2-line', 'number' => 180, 'suffix' => '+', 'prefix' => '', 'title' => esc_html__( 'Campaigns Run', 'nexus' ) ),
					array( 'icon' => 'ri-thumb-up-line', 'number' => 95, 'suffix' => '%', 'prefix' => '', 'title' => esc_html__( 'Retention Rate', 'nexus' ) ),
					array( 'icon' => 'ri-calendar-check-line', 'number' => 15, 'suffix' => '+', 'prefix' => '', 'title' => esc_html__( 'Years Active', 'nexus' ) ),
					array( 'icon' => 'ri-map-pin-line', 'number' => 30, 'suffix' => '+', 'prefix' => '', 'title' => esc_html__( 'Office Locations', 'nexus' ) ),
				),
			),
			'circle-icon'  => array(
				'tagline'  => esc_html__( 'Statistics', 'nexus' ),
				'headline' => esc_html__( 'What Sets Us Apart', 'nexus' ),
				'columns'  => 4,
				'counters' => array(
					array( 'icon' => 'ri-heart-pulse-line', 'number' => 100, 'suffix' => '%', 'prefix' => '', 'title' => esc_html__( 'Passion', 'nexus' ) ),
					array( 'icon' => 'ri-lightbulb-line', 'number' => 620, 'suffix' => '+', 'prefix' => '', 'title' => esc_html__( 'Ideas Delivered', 'nexus' ) ),
					array( 'icon' => 'ri-shield-check-line', 'number' => 99, 'suffix' => '%', 'prefix' => '', 'title' => esc_html__( 'Security Score', 'nexus' ) ),
					array( 'icon' => 'ri-hand-heart-line', 'number' => 4, 'suffix' => '.9', 'prefix' => '', 'title' => esc_html__( 'Customer Rating', 'nexus' ) ),
				),
			),
		);

		return $map[ $preset ] ?? $map['minimal-row'];
	}

	protected function register_controls() {

		// ---------------------------------------------------------------
		// STYLE PRESET
		// ---------------------------------------------------------------
		$this->start_controls_section(
			'section_preset',
			array( 'label' => esc_html__( 'Style Preset', 'nexus' ) )
		);

		$this->add_control(
			'style_preset',
			array(
				'label'       => esc_html__( 'Style', 'nexus' ),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'default'     => 'minimal-row',
				'options'     => array(
					'minimal-row'  => esc_html__( '1 — Minimal Row', 'nexus' ),
					'dark-bold'    => esc_html__( '2 — Dark Bold', 'nexus' ),
					'icon-cards'   => esc_html__( '3 — Icon Cards', 'nexus' ),
					'gradient-bar' => esc_html__( '4 — Gradient Bar', 'nexus' ),
					'accent-top'   => esc_html__( '5 — Accent Top', 'nexus' ),
					'circle-icon'  => esc_html__( '6 — Circle Icon', 'nexus' ),
				),
				'render_type' => 'template',
			)
		);

		$this->end_controls_section();

		// ---------------------------------------------------------------
		// CONTENT: Header
		// ---------------------------------------------------------------
		$this->start_controls_section(
			'section_header',
			array( 'label' => esc_html__( 'Section Header', 'nexus' ) )
		);

		$this->add_control(
			'tagline',
			array(
				'label'       => esc_html__( 'Tagline', 'nexus' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'Auto-filled from preset', 'nexus' ),
			)
		);

		$this->add_control(
			'headline',
			array(
				'label'       => esc_html__( 'Headline', 'nexus' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'Auto-filled from preset', 'nexus' ),
				'dynamic'     => array( 'active' => true ),
			)
		);

		$this->end_controls_section();

		// ---------------------------------------------------------------
		// CONTENT: Counter Items (repeater)
		// ---------------------------------------------------------------
		$this->start_controls_section(
			'section_counters',
			array( 'label' => esc_html__( 'Counter Items', 'nexus' ) )
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'icon',
			array(
				'label'   => esc_html__( 'Icon', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::ICONS,
				'default' => array(
					'value'   => 'ri-award-line',
					'library' => 'remix-icon',
				),
			)
		);

		$repeater->add_control(
			'ending_number',
			array(
				'label'   => esc_html__( 'Number', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 250,
				'min'     => 0,
			)
		);

		$repeater->add_control(
			'prefix',
			array(
				'label'   => esc_html__( 'Prefix', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => '',
			)
		);

		$repeater->add_control(
			'suffix',
			array(
				'label'   => esc_html__( 'Suffix', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => '+',
			)
		);

		$repeater->add_control(
			'title',
			array(
				'label'   => esc_html__( 'Label', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Happy Clients', 'nexus' ),
				'dynamic' => array( 'active' => true ),
			)
		);

		$this->add_control(
			'counters',
			array(
				'label'       => esc_html__( 'Counters', 'nexus' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(),
				'title_field' => '{{{ title }}}',
			)
		);

		$this->end_controls_section();

		// ---------------------------------------------------------------
		// CONTENT: Animation
		// ---------------------------------------------------------------
		$this->start_controls_section(
			'section_animation',
			array( 'label' => esc_html__( 'Animation', 'nexus' ) )
		);

		$this->add_control(
			'duration',
			array(
				'label'   => esc_html__( 'Count Duration (ms)', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 2000,
				'min'     => 500,
				'max'     => 10000,
				'step'    => 100,
			)
		);

		$this->add_control(
			'separator',
			array(
				'label'   => esc_html__( 'Thousands Separator', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => '',
			)
		);

		$this->end_controls_section();

		// ---------------------------------------------------------------
		// STYLE: Colors (overrides)
		// ---------------------------------------------------------------
		$this->start_controls_section(
			'section_style_colors',
			array(
				'label' => esc_html__( 'Colors', 'nexus' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'icon_color',
			array(
				'label'     => esc_html__( 'Icon Color', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .nexus-cnt__icon' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'number_color',
			array(
				'label'     => esc_html__( 'Number Color', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .nexus-cnt__number' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Label Color', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .nexus-cnt__label' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		// ---------------------------------------------------------------
		// STYLE: Typography
		// ---------------------------------------------------------------
		$this->start_controls_section(
			'section_style_typo',
			array(
				'label' => esc_html__( 'Typography', 'nexus' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'number_typography',
				'label'    => esc_html__( 'Number', 'nexus' ),
				'selector' => '{{WRAPPER}} .nexus-cnt__number',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Label', 'nexus' ),
				'selector' => '{{WRAPPER}} .nexus-cnt__label',
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings  = $this->get_settings_for_display();
		$preset    = $settings['style_preset'] ?? 'minimal-row';
		$colors    = $this->get_preset_colors( $preset );
		$defaults  = $this->get_preset_defaults( $preset );
		$widget_id = 'nexus-cnt-' . $this->get_id();
		$is_editor = \Elementor\Plugin::$instance->editor->is_edit_mode();

		// Text fields.
		$tagline  = ( '' !== $settings['tagline'] )  ? $settings['tagline']  : ( $defaults['tagline'] ?? '' );
		$headline = ( '' !== $settings['headline'] ) ? $settings['headline'] : ( $defaults['headline'] ?? '' );

		// Counters: repeater fallback.
		$counters = $settings['counters'] ?? array();
		if ( empty( $counters ) ) {
			foreach ( $defaults['counters'] as $dc ) {
				$counters[] = array(
					'icon'          => array( 'value' => $dc['icon'], 'library' => 'remix-icon' ),
					'ending_number' => $dc['number'],
					'prefix'        => $dc['prefix'],
					'suffix'        => $dc['suffix'],
					'title'         => $dc['title'],
				);
			}
		}

		if ( empty( $counters ) ) {
			return;
		}

		$columns   = $defaults['columns'];
		$duration  = absint( $settings['duration'] );
		$separator = 'yes' === $settings['separator'];

		// Dispatch to preset render method.
		switch ( $preset ) {
			case 'dark-bold':
				$this->render_dark_bold( $widget_id, $counters, $colors, $tagline, $headline, $columns, $duration, $separator, $is_editor );
				break;
			case 'icon-cards':
				$this->render_icon_cards( $widget_id, $counters, $colors, $tagline, $headline, $columns, $duration, $separator, $is_editor );
				break;
			case 'gradient-bar':
				$this->render_gradient_bar( $widget_id, $counters, $colors, $tagline, $headline, $columns, $duration, $separator, $is_editor );
				break;
			case 'accent-top':
				$this->render_accent_top( $widget_id, $counters, $colors, $columns, $duration, $separator, $is_editor );
				break;
			case 'circle-icon':
				$this->render_circle_icon( $widget_id, $counters, $colors, $tagline, $headline, $columns, $duration, $separator, $is_editor );
				break;
			default:
				$this->render_minimal_row( $widget_id, $counters, $colors, $columns, $duration, $separator, $is_editor );
				break;
		}
	}

	// =====================================================================
	// PRESET 1: Minimal Row — clean dividers, no background
	// =====================================================================
	private function render_minimal_row( $id, $counters, $c, $cols, $dur, $sep, $editor ) {
		?>
		<div class="nexus-cnt nexus-cnt--minimal-row" id="<?php echo esc_attr( $id ); ?>">
			<div class="nexus-cnt__grid" style="display:flex;flex-wrap:wrap;justify-content:center;">
				<?php foreach ( $counters as $idx => $item ) : ?>
					<div class="nexus-cnt__item" style="flex:1;min-width:160px;text-align:center;padding:1.5rem 2rem;<?php echo $idx < count( $counters ) - 1 ? 'border-inline-end:1px solid ' . esc_attr( $c['divider'] ) . ';' : ''; ?>">
						<?php $this->render_icon_el( $item, $c ); ?>
						<?php $this->render_number( $item, $c, $dur, $sep ); ?>
						<?php $this->render_label( $item, $c ); ?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<?php $this->render_counter_script( $id ); ?>
		<?php
	}

	// =====================================================================
	// PRESET 2: Dark Bold — dark section bg, large white numbers, dividers
	// =====================================================================
	private function render_dark_bold( $id, $counters, $c, $tagline, $headline, $cols, $dur, $sep, $editor ) {
		?>
		<div class="nexus-cnt nexus-cnt--dark-bold" id="<?php echo esc_attr( $id ); ?>" style="background-color:<?php echo esc_attr( $c['section_bg'] ); ?>;padding:5rem 0;">
			<div style="max-width:1200px;margin:0 auto;padding:0 1.5rem;">
				<?php $this->render_section_header( $tagline, $headline, $c ); ?>
				<div class="nexus-cnt__grid" style="display:flex;flex-wrap:wrap;justify-content:center;">
					<?php foreach ( $counters as $idx => $item ) : ?>
						<div class="nexus-cnt__item" style="flex:1;min-width:180px;text-align:center;padding:2rem;<?php echo $idx < count( $counters ) - 1 ? 'border-inline-end:1px solid ' . esc_attr( $c['divider'] ) . ';' : ''; ?>">
							<?php $this->render_icon_el( $item, $c ); ?>
							<?php $this->render_number( $item, $c, $dur, $sep, 'clamp(2.5rem,5vw,4rem)' ); ?>
							<?php $this->render_label( $item, $c ); ?>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
		<?php $this->render_counter_script( $id ); ?>
		<?php
	}

	// =====================================================================
	// PRESET 3: Icon Cards — elevated white cards with colored icon circle
	// =====================================================================
	private function render_icon_cards( $id, $counters, $c, $tagline, $headline, $cols, $dur, $sep, $editor ) {
		?>
		<div class="nexus-cnt nexus-cnt--icon-cards" id="<?php echo esc_attr( $id ); ?>" style="background-color:<?php echo esc_attr( $c['section_bg'] ); ?>;padding:5rem 0;">
			<div style="max-width:1200px;margin:0 auto;padding:0 1.5rem;">
				<?php $this->render_section_header( $tagline, $headline, $c ); ?>
				<div class="nexus-cnt__grid" style="display:grid;grid-template-columns:repeat(<?php echo esc_attr( $cols ); ?>,1fr);gap:1.5rem;">
					<?php foreach ( $counters as $item ) : ?>
						<div class="nexus-cnt__card" style="background:<?php echo esc_attr( $c['card_bg'] ); ?>;border-radius:12px;padding:2rem 1.5rem;text-align:center;box-shadow:0 2px 16px rgba(0,0,0,0.06);">
							<?php if ( ! empty( $item['icon']['value'] ) ) : ?>
								<div class="nexus-cnt__icon-wrap" style="display:inline-flex;align-items:center;justify-content:center;width:56px;height:56px;border-radius:12px;background:<?php echo esc_attr( $c['icon_bg'] ); ?>;margin-bottom:1.25rem;">
									<span class="nexus-cnt__icon" style="color:<?php echo esc_attr( $c['icon'] ); ?>;font-size:1.5rem;line-height:1;" aria-hidden="true">
										<?php \Elementor\Icons_Manager::render_icon( $item['icon'], array( 'aria-hidden' => 'true' ) ); ?>
									</span>
								</div>
							<?php endif; ?>
							<?php $this->render_number( $item, $c, $dur, $sep ); ?>
							<?php $this->render_label( $item, $c ); ?>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
		<?php $this->render_counter_script( $id ); ?>
		<?php
	}

	// =====================================================================
	// PRESET 4: Gradient Bar — dark bg, gradient underline on numbers
	// =====================================================================
	private function render_gradient_bar( $id, $counters, $c, $tagline, $headline, $cols, $dur, $sep, $editor ) {
		$grad = 'linear-gradient(135deg,' . esc_attr( $c['grad_from'] ) . ',' . esc_attr( $c['grad_to'] ) . ')';
		?>
		<div class="nexus-cnt nexus-cnt--gradient-bar" id="<?php echo esc_attr( $id ); ?>" style="background-color:<?php echo esc_attr( $c['section_bg'] ); ?>;padding:5rem 0;">
			<div style="max-width:1200px;margin:0 auto;padding:0 1.5rem;">
				<?php $this->render_section_header( $tagline, $headline, $c ); ?>
				<div class="nexus-cnt__grid" style="display:grid;grid-template-columns:repeat(<?php echo esc_attr( $cols ); ?>,1fr);gap:2.5rem;">
					<?php foreach ( $counters as $item ) : ?>
						<div class="nexus-cnt__item" style="text-align:center;position:relative;padding-bottom:1.5rem;">
							<?php $this->render_icon_el( $item, $c ); ?>
							<?php $this->render_number( $item, $c, $dur, $sep, 'clamp(2.5rem,5vw,3.5rem)' ); ?>
							<?php $this->render_label( $item, $c ); ?>
							<div style="position:absolute;bottom:0;left:50%;transform:translateX(-50%);width:60px;height:3px;border-radius:3px;background:<?php echo esc_attr( $grad ); ?>;"></div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
		<?php $this->render_counter_script( $id ); ?>
		<?php
	}

	// =====================================================================
	// PRESET 5: Accent Top — top border accent, no section bg
	// =====================================================================
	private function render_accent_top( $id, $counters, $c, $cols, $dur, $sep, $editor ) {
		?>
		<div class="nexus-cnt nexus-cnt--accent-top" id="<?php echo esc_attr( $id ); ?>">
			<div class="nexus-cnt__grid" style="display:grid;grid-template-columns:repeat(<?php echo esc_attr( $cols ); ?>,1fr);gap:2rem;">
				<?php foreach ( $counters as $item ) : ?>
					<div class="nexus-cnt__item" style="border-top:3px solid <?php echo esc_attr( $c['accent'] ); ?>;padding:1.75rem 1rem 1rem;text-align:center;">
						<?php $this->render_icon_el( $item, $c ); ?>
						<?php $this->render_number( $item, $c, $dur, $sep ); ?>
						<?php $this->render_label( $item, $c ); ?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<?php $this->render_counter_script( $id ); ?>
		<?php
	}

	// =====================================================================
	// PRESET 6: Circle Icon — icon in tinted circle, centered card
	// =====================================================================
	private function render_circle_icon( $id, $counters, $c, $tagline, $headline, $cols, $dur, $sep, $editor ) {
		?>
		<div class="nexus-cnt nexus-cnt--circle-icon" id="<?php echo esc_attr( $id ); ?>" style="background-color:<?php echo esc_attr( $c['section_bg'] ); ?>;padding:5rem 0;">
			<div style="max-width:1200px;margin:0 auto;padding:0 1.5rem;">
				<?php $this->render_section_header( $tagline, $headline, $c ); ?>
				<div class="nexus-cnt__grid" style="display:grid;grid-template-columns:repeat(<?php echo esc_attr( $cols ); ?>,1fr);gap:2rem;">
					<?php foreach ( $counters as $item ) : ?>
						<div class="nexus-cnt__item" style="text-align:center;padding:1.5rem;">
							<?php if ( ! empty( $item['icon']['value'] ) ) : ?>
								<div class="nexus-cnt__icon-wrap" style="display:inline-flex;align-items:center;justify-content:center;width:72px;height:72px;border-radius:50%;background:<?php echo esc_attr( $c['circle_bg'] ); ?>;margin-bottom:1.25rem;">
									<span class="nexus-cnt__icon" style="color:<?php echo esc_attr( $c['icon'] ); ?>;font-size:1.75rem;line-height:1;" aria-hidden="true">
										<?php \Elementor\Icons_Manager::render_icon( $item['icon'], array( 'aria-hidden' => 'true' ) ); ?>
									</span>
								</div>
							<?php endif; ?>
							<?php $this->render_number( $item, $c, $dur, $sep ); ?>
							<?php $this->render_label( $item, $c ); ?>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
		<?php $this->render_counter_script( $id ); ?>
		<?php
	}

	// =====================================================================
	// Shared helpers
	// =====================================================================

	/**
	 * Renders section header (tagline + headline).
	 */
	private function render_section_header( $tagline, $headline, $c ) {
		if ( ! $tagline && ! $headline ) {
			return;
		}
		?>
		<div class="nexus-cnt__header" style="text-align:center;margin-bottom:3rem;max-width:680px;margin-left:auto;margin-right:auto;">
			<?php if ( $tagline ) : ?>
				<span class="nexus-cnt__tagline" style="display:inline-block;font-size:0.875rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:<?php echo esc_attr( $c['icon'] ); ?>;margin-bottom:0.75rem;">
					<?php echo esc_html( $tagline ); ?>
				</span>
			<?php endif; ?>
			<?php if ( $headline ) : ?>
				<h2 class="nexus-cnt__headline" style="font-size:clamp(1.5rem,3vw,2.25rem);font-weight:700;color:<?php echo esc_attr( $c['number'] ); ?>;margin:0;">
					<?php echo wp_kses_post( $headline ); ?>
				</h2>
			<?php endif; ?>
		</div>
		<?php
	}

	/**
	 * Renders the icon element (simple, for presets without special icon wrappers).
	 */
	private function render_icon_el( $item, $c ) {
		if ( empty( $item['icon']['value'] ) ) {
			return;
		}
		?>
		<div class="nexus-cnt__icon" style="display:block;margin-bottom:0.75rem;font-size:2rem;line-height:1;color:<?php echo esc_attr( $c['icon'] ); ?>;" aria-hidden="true">
			<?php \Elementor\Icons_Manager::render_icon( $item['icon'], array( 'aria-hidden' => 'true' ) ); ?>
		</div>
		<?php
	}

	/**
	 * Renders number with prefix/suffix.
	 *
	 * @param array  $item     Counter item.
	 * @param array  $c        Color tokens.
	 * @param int    $dur      Animation duration.
	 * @param bool   $sep      Thousands separator.
	 * @param string $font_size Custom font-size.
	 */
	private function render_number( $item, $c, $dur, $sep, $font_size = 'clamp(2.25rem,4vw,3rem)' ) {
		$ending  = absint( $item['ending_number'] ?? 0 );
		$prefix  = $item['prefix'] ?? '';
		$suffix  = $item['suffix'] ?? '';
		?>
		<div class="nexus-cnt__number-wrap" style="display:flex;align-items:baseline;justify-content:center;gap:0.05em;line-height:1;margin-bottom:0.5rem;" aria-label="<?php echo esc_attr( $prefix . $ending . $suffix ); ?>">
			<?php if ( $prefix ) : ?>
				<span class="nexus-cnt__prefix" style="font-size:1.5rem;font-weight:800;color:<?php echo esc_attr( $c['prefix_sfx'] ); ?>;" aria-hidden="true"><?php echo esc_html( $prefix ); ?></span>
			<?php endif; ?>
			<span
				class="nexus-cnt__number"
				style="font-size:<?php echo esc_attr( $font_size ); ?>;font-weight:800;line-height:1;color:<?php echo esc_attr( $c['number'] ); ?>;"
				data-start="0"
				data-end="<?php echo esc_attr( $ending ); ?>"
				data-duration="<?php echo esc_attr( $dur ); ?>"
				data-separator="<?php echo $sep ? '1' : '0'; ?>"
				aria-hidden="true"
			><?php echo esc_html( $sep ? number_format( $ending ) : $ending ); ?></span>
			<?php if ( $suffix ) : ?>
				<span class="nexus-cnt__suffix" style="font-size:1.5rem;font-weight:800;color:<?php echo esc_attr( $c['prefix_sfx'] ); ?>;" aria-hidden="true"><?php echo esc_html( $suffix ); ?></span>
			<?php endif; ?>
		</div>
		<?php
	}

	/**
	 * Renders the counter label/title.
	 */
	private function render_label( $item, $c ) {
		$title = $item['title'] ?? '';
		if ( ! $title ) {
			return;
		}
		?>
		<p class="nexus-cnt__label" style="font-size:0.8125rem;font-weight:500;letter-spacing:0.08em;text-transform:uppercase;color:<?php echo esc_attr( $c['title'] ); ?>;margin:0;">
			<?php echo esc_html( $title ); ?>
		</p>
		<?php
	}

	/**
	 * Renders the IntersectionObserver count-up animation script.
	 *
	 * @param string $id Widget container ID.
	 */
	private function render_counter_script( $id ) {
		?>
		<script>
		( function () {
			var el = document.getElementById( '<?php echo esc_js( $id ); ?>' );
			if ( ! el ) return;
			var nums = el.querySelectorAll( '.nexus-cnt__number' );
			if ( ! nums.length ) return;

			function formatNum( n, sep ) {
				return sep ? n.toLocaleString() : String( n );
			}

			function animateAll() {
				nums.forEach( function ( numEl ) {
					if ( numEl.dataset.animated ) return;
					numEl.dataset.animated = '1';
					var start     = parseInt( numEl.dataset.start, 10 );
					var end       = parseInt( numEl.dataset.end, 10 );
					var duration  = parseInt( numEl.dataset.duration, 10 );
					var separator = '1' === numEl.dataset.separator;
					var startTime = null;
					function step( ts ) {
						if ( ! startTime ) startTime = ts;
						var progress = Math.min( ( ts - startTime ) / duration, 1 );
						var current  = Math.floor( progress * ( end - start ) + start );
						numEl.textContent = formatNum( current, separator );
						if ( progress < 1 ) {
							requestAnimationFrame( step );
						} else {
							numEl.textContent = formatNum( end, separator );
						}
					}
					requestAnimationFrame( step );
				} );
			}

			if ( 'IntersectionObserver' in window ) {
				var observer = new IntersectionObserver( function ( entries ) {
					entries.forEach( function ( entry ) {
						if ( entry.isIntersecting ) {
							animateAll();
							observer.unobserve( entry.target );
						}
					} );
				}, { threshold: 0.2 } );
				observer.observe( el );
			} else {
				animateAll();
			}
		} )();
		</script>
		<?php
	}
}
