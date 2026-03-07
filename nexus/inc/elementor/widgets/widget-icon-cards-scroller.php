<?php
/**
 * Nexus Theme - Elementor Icon Cards Scroller Widget
 *
 * Horizontal scrolling icon card carousel with 6 style presets.
 * Uses Swiper.js for smooth, touch-friendly scrolling.
 * All colors driven by the active palette via nexus_palette().
 *
 * @package Nexus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Nexus_Widget_Icon_Cards_Scroller
 */
class Nexus_Widget_Icon_Cards_Scroller extends \Elementor\Widget_Base {

	public function get_name() {
		return 'nexus-icon-cards-scroller';
	}

	public function get_title() {
		return esc_html__( 'Icon Cards Scroller', 'nexus' );
	}

	public function get_icon() {
		return 'eicon-slider-push';
	}

	public function get_categories() {
		return array( 'nexus-elements' );
	}

	public function get_keywords() {
		return array( 'icon', 'cards', 'scroller', 'carousel', 'features', 'services', 'nexus' );
	}

	public function get_script_depends() {
		return array( 'nexus-swiper' );
	}

	public function get_style_depends() {
		return array( 'nexus-swiper' );
	}

	// -----------------------------------------------------------------
	// Preset data
	// -----------------------------------------------------------------

	private function get_preset_config( $preset ) {
		$p = nexus_palette();

		$presets = array(
			'clean-slide'     => array(
				'section_bg' => '#ffffff',
				'card_bg'    => '#ffffff',
				'icon_color' => $p['secondary'],
				'icon_bg'    => 'rgba(0,0,0,0.04)',
				'heading'    => $p['primary'],
				'text'       => '#495057',
				'tagline'    => $p['secondary'],
				'dot_color'  => $p['secondary'],
				'spv'        => 4,
				'tagline_t'  => 'Features',
				'headline_t' => 'Why Choose Us',
				'desc_t'     => 'Explore our key features designed to help your business grow.',
				'cards'      => array(
					array( 'icon' => 'ri-palette-line', 'title' => 'Creative Design', 'desc' => 'Stunning visuals that capture your brand essence.' ),
					array( 'icon' => 'ri-code-s-slash-line', 'title' => 'Clean Code', 'desc' => 'Well-structured, maintainable code following best practices.' ),
					array( 'icon' => 'ri-rocket-2-line', 'title' => 'Fast Performance', 'desc' => 'Optimized for speed, delivering exceptional experiences.' ),
					array( 'icon' => 'ri-shield-check-line', 'title' => 'Secure & Reliable', 'desc' => 'Enterprise-grade security protecting your data.' ),
					array( 'icon' => 'ri-customer-service-2-line', 'title' => '24/7 Support', 'desc' => 'Round-the-clock assistance for your business.' ),
					array( 'icon' => 'ri-bar-chart-2-line', 'title' => 'Analytics', 'desc' => 'Data-driven insights for smarter decisions.' ),
				),
			),
			'gradient-cards'  => array(
				'section_bg' => $p['light'],
				'card_bg'    => '#ffffff',
				'icon_color' => '#ffffff',
				'icon_bg'    => 'linear-gradient(135deg,' . $p['secondary'] . ',' . $p['accent'] . ')',
				'heading'    => $p['primary'],
				'text'       => '#495057',
				'tagline'    => $p['accent'],
				'dot_color'  => $p['accent'],
				'spv'        => 3,
				'tagline_t'  => 'Our Services',
				'headline_t' => 'What We Offer',
				'desc_t'     => 'Comprehensive solutions tailored to your unique business needs.',
				'cards'      => array(
					array( 'icon' => 'ri-lightbulb-line', 'title' => 'Strategy', 'desc' => 'Research-driven strategies aligned with your goals.' ),
					array( 'icon' => 'ri-layout-masonry-line', 'title' => 'UI/UX Design', 'desc' => 'Intuitive interfaces for maximum engagement.' ),
					array( 'icon' => 'ri-terminal-box-line', 'title' => 'Development', 'desc' => 'Robust apps with cutting-edge technologies.' ),
					array( 'icon' => 'ri-line-chart-line', 'title' => 'Marketing', 'desc' => 'Growth-focused campaigns with measurable results.' ),
					array( 'icon' => 'ri-cloud-line', 'title' => 'Cloud Solutions', 'desc' => 'Scalable infrastructure for growing businesses.' ),
				),
			),
			'dark-neon'       => array(
				'section_bg' => $p['primary'],
				'card_bg'    => $p['dark'],
				'icon_color' => $p['secondary'],
				'icon_bg'    => 'rgba(255,255,255,0.06)',
				'heading'    => '#ffffff',
				'text'       => '#cbd5e1',
				'tagline'    => $p['secondary'],
				'dot_color'  => $p['secondary'],
				'spv'        => 3,
				'tagline_t'  => 'Capabilities',
				'headline_t' => 'Built for Scale',
				'desc_t'     => '',
				'cards'      => array(
					array( 'icon' => 'ri-database-2-line', 'title' => 'Data Storage', 'desc' => 'Secure and scalable data solutions.' ),
					array( 'icon' => 'ri-git-branch-line', 'title' => 'CI/CD Pipeline', 'desc' => 'Automated workflows for rapid deployments.' ),
					array( 'icon' => 'ri-shield-keyhole-line', 'title' => 'Security', 'desc' => 'Multi-layer protection for your systems.' ),
					array( 'icon' => 'ri-speed-line', 'title' => 'Performance', 'desc' => 'Sub-second response times at scale.' ),
					array( 'icon' => 'ri-global-line', 'title' => 'Global CDN', 'desc' => 'Content delivered fast worldwide.' ),
					array( 'icon' => 'ri-tools-line', 'title' => 'Maintenance', 'desc' => 'Proactive monitoring and updates.' ),
				),
			),
			'bordered-slim'   => array(
				'section_bg' => '#ffffff',
				'card_bg'    => '#ffffff',
				'icon_color' => $p['accent'],
				'icon_bg'    => 'transparent',
				'heading'    => $p['primary'],
				'text'       => '#495057',
				'tagline'    => $p['secondary'],
				'dot_color'  => $p['secondary'],
				'spv'        => 4,
				'tagline_t'  => 'How It Works',
				'headline_t' => 'Simple Process, Great Results',
				'desc_t'     => 'Our streamlined approach ensures quality delivery every time.',
				'cards'      => array(
					array( 'icon' => 'ri-search-line', 'title' => 'Discovery', 'desc' => 'We learn about your goals and audience.' ),
					array( 'icon' => 'ri-draft-line', 'title' => 'Planning', 'desc' => 'A detailed roadmap with milestones.' ),
					array( 'icon' => 'ri-pencil-ruler-2-line', 'title' => 'Design', 'desc' => 'Wireframes that bring your vision to life.' ),
					array( 'icon' => 'ri-code-line', 'title' => 'Build', 'desc' => 'Clean code transforms designs into reality.' ),
					array( 'icon' => 'ri-bug-line', 'title' => 'Testing', 'desc' => 'Rigorous QA for flawless results.' ),
					array( 'icon' => 'ri-rocket-line', 'title' => 'Launch', 'desc' => 'Go live with full support.' ),
				),
			),
			'accent-glow'     => array(
				'section_bg' => $p['light'],
				'card_bg'    => '#ffffff',
				'icon_color' => $p['secondary'],
				'icon_bg'    => 'rgba(0,0,0,0.03)',
				'heading'    => $p['primary'],
				'text'       => '#495057',
				'tagline'    => $p['secondary'],
				'dot_color'  => $p['primary'],
				'spv'        => 3,
				'tagline_t'  => 'Solutions',
				'headline_t' => 'Industry Expertise',
				'desc_t'     => 'Specialized solutions for specific business verticals.',
				'cards'      => array(
					array( 'icon' => 'ri-store-2-line', 'title' => 'E-Commerce', 'desc' => 'Online stores that convert visitors into customers.' ),
					array( 'icon' => 'ri-hospital-line', 'title' => 'Healthcare', 'desc' => 'HIPAA-compliant digital solutions.' ),
					array( 'icon' => 'ri-graduation-cap-line', 'title' => 'Education', 'desc' => 'Learning platforms that engage students.' ),
					array( 'icon' => 'ri-bank-line', 'title' => 'Finance', 'desc' => 'Secure financial tools built for trust.' ),
					array( 'icon' => 'ri-building-line', 'title' => 'Real Estate', 'desc' => 'Property platforms with virtual tours.' ),
				),
			),
			'glass-futuristic' => array(
				'section_bg' => 'linear-gradient(135deg,' . $p['primary'] . ',' . $p['dark'] . ')',
				'card_bg'    => 'rgba(255,255,255,0.06)',
				'icon_color' => $p['secondary'],
				'icon_bg'    => 'rgba(255,255,255,0.08)',
				'heading'    => '#ffffff',
				'text'       => '#e2e8f0',
				'tagline'    => $p['secondary'],
				'dot_color'  => '#ffffff',
				'spv'        => 3,
				'tagline_t'  => 'Technology',
				'headline_t' => 'Powered by Innovation',
				'desc_t'     => 'Modern tech stack for future-proof digital products.',
				'cards'      => array(
					array( 'icon' => 'ri-brain-line', 'title' => 'AI & Machine Learning', 'desc' => 'Intelligent automation and predictive analytics.' ),
					array( 'icon' => 'ri-links-line', 'title' => 'Blockchain', 'desc' => 'Decentralized solutions for transparency.' ),
					array( 'icon' => 'ri-cloud-line', 'title' => 'Cloud Native', 'desc' => 'Microservices for maximum flexibility.' ),
					array( 'icon' => 'ri-smartphone-line', 'title' => 'Mobile First', 'desc' => 'Apps designed for the mobile generation.' ),
					array( 'icon' => 'ri-eye-line', 'title' => 'AR/VR', 'desc' => 'Immersive experiences that push boundaries.' ),
				),
			),
		);

		return $presets[ $preset ] ?? $presets['clean-slide'];
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
				'default'     => 'clean-slide',
				'options'     => array(
					'clean-slide'      => esc_html__( '1 — Clean Slide', 'nexus' ),
					'gradient-cards'   => esc_html__( '2 — Gradient Cards', 'nexus' ),
					'dark-neon'        => esc_html__( '3 — Dark Neon', 'nexus' ),
					'bordered-slim'    => esc_html__( '4 — Bordered Slim', 'nexus' ),
					'accent-glow'      => esc_html__( '5 — Accent Glow', 'nexus' ),
					'glass-futuristic' => esc_html__( '6 — Glass Futuristic', 'nexus' ),
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

		$this->end_controls_section();

		// ---- Cards (Repeater) ----
		$this->start_controls_section(
			'section_cards',
			array( 'label' => esc_html__( 'Cards', 'nexus' ) )
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control( 'icon', array(
			'label'   => esc_html__( 'Icon', 'nexus' ),
			'type'    => \Elementor\Controls_Manager::ICONS,
			'default' => array( 'value' => 'ri-star-line', 'library' => 'remix-icon' ),
		) );

		$repeater->add_control( 'title', array(
			'label'   => esc_html__( 'Title', 'nexus' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => esc_html__( 'Feature Title', 'nexus' ),
			'dynamic' => array( 'active' => true ),
		) );

		$repeater->add_control( 'description', array(
			'label'   => esc_html__( 'Description', 'nexus' ),
			'type'    => \Elementor\Controls_Manager::TEXTAREA,
			'rows'    => 3,
			'default' => esc_html__( 'Describe this feature briefly.', 'nexus' ),
			'dynamic' => array( 'active' => true ),
		) );

		$repeater->add_control( 'link', array(
			'label'   => esc_html__( 'Link', 'nexus' ),
			'type'    => \Elementor\Controls_Manager::URL,
			'dynamic' => array( 'active' => true ),
		) );

		$this->add_control(
			'cards',
			array(
				'label'       => esc_html__( 'Icon Cards', 'nexus' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(),
				'title_field' => '{{{ title }}}',
			)
		);

		$this->end_controls_section();

		// ---- Slider Settings ----
		$this->start_controls_section(
			'section_slider',
			array( 'label' => esc_html__( 'Slider Settings', 'nexus' ) )
		);

		$this->add_control( 'autoplay', array(
			'label'   => esc_html__( 'Autoplay', 'nexus' ),
			'type'    => \Elementor\Controls_Manager::SWITCHER,
			'default' => 'yes',
		) );

		$this->add_control( 'autoplay_speed', array(
			'label'     => esc_html__( 'Autoplay Delay (ms)', 'nexus' ),
			'type'      => \Elementor\Controls_Manager::NUMBER,
			'default'   => 5000,
			'condition' => array( 'autoplay' => 'yes' ),
		) );

		$this->add_control( 'show_dots', array(
			'label'   => esc_html__( 'Show Dots', 'nexus' ),
			'type'    => \Elementor\Controls_Manager::SWITCHER,
			'default' => 'yes',
		) );

		$this->add_control( 'show_arrows', array(
			'label'   => esc_html__( 'Show Arrows', 'nexus' ),
			'type'    => \Elementor\Controls_Manager::SWITCHER,
			'default' => 'yes',
		) );

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
			'selectors' => array( '{{WRAPPER}} .nexus-icsc__tagline' => 'color: {{VALUE}};' ),
		) );

		$this->add_control( 'heading_color', array(
			'label'     => esc_html__( 'Heading Color', 'nexus' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => array( '{{WRAPPER}} .nexus-icsc__title' => 'color: {{VALUE}};' ),
		) );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'heading_typography',
				'label'    => esc_html__( 'Heading Typography', 'nexus' ),
				'selector' => '{{WRAPPER}} .nexus-icsc__title',
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

		$this->add_control( 'card_title_color', array(
			'label'     => esc_html__( 'Title Color', 'nexus' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => array( '{{WRAPPER}} .nexus-icsc-card__title' => 'color: {{VALUE}};' ),
		) );

		$this->add_control( 'card_desc_color', array(
			'label'     => esc_html__( 'Description Color', 'nexus' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => array( '{{WRAPPER}} .nexus-icsc-card__desc' => 'color: {{VALUE}};' ),
		) );

		$this->add_control( 'icon_color_override', array(
			'label'     => esc_html__( 'Icon Color', 'nexus' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => array( '{{WRAPPER}} .nexus-icsc-card__icon' => 'color: {{VALUE}};' ),
		) );

		$this->end_controls_section();
	}

	// -----------------------------------------------------------------
	// Render
	// -----------------------------------------------------------------

	protected function render() {
		$settings  = $this->get_settings_for_display();
		$preset    = $settings['style_preset'] ?? 'clean-slide';
		$cfg       = $this->get_preset_config( $preset );
		$animation = $settings['entrance_animation'] ?? 'fadeInUp';
		$is_editor = \Elementor\Plugin::$instance->editor->is_edit_mode();
		$widget_id = 'nexus-icsc-' . $this->get_id();

		$tagline     = ( '' !== $settings['tagline'] ) ? $settings['tagline'] : $cfg['tagline_t'];
		$headline    = ( '' !== $settings['headline'] ) ? $settings['headline'] : $cfg['headline_t'];
		$description = ( '' !== $settings['description'] ) ? $settings['description'] : $cfg['desc_t'];
		$spv         = absint( $cfg['spv'] );
		$dots        = 'yes' === $settings['show_dots'];
		$arrows      = 'yes' === $settings['show_arrows'];

		// Cards: use repeater or fallback to preset defaults.
		$cards = $settings['cards'] ?? array();
		if ( empty( $cards ) ) {
			foreach ( $cfg['cards'] as $dc ) {
				$cards[] = array(
					'icon'        => array( 'value' => $dc['icon'], 'library' => 'remix-icon' ),
					'title'       => $dc['title'],
					'description' => $dc['desc'],
					'link'        => array( 'url' => '' ),
				);
			}
		}

		if ( empty( $cards ) ) {
			return;
		}

		$has_anim   = ( 'none' !== $animation && ! $is_editor );
		$is_glass   = 'glass-futuristic' === $preset;
		$section_bg = $is_glass
			? 'background:' . $cfg['section_bg'] . ';'
			: 'background-color:' . $cfg['section_bg'] . ';';
		?>

		<section
			class="nexus-icsc nexus-icsc--<?php echo esc_attr( $preset ); ?>"
			style="<?php echo esc_attr( $section_bg ); ?>padding:5rem 0;overflow:hidden;"
			id="<?php echo esc_attr( $widget_id ); ?>"
		>
			<div class="nexus-container">

				<?php if ( $tagline || $headline || $description ) : ?>
				<div class="nexus-icsc__header" style="margin-bottom:2.5rem;max-width:680px;">
					<?php if ( $tagline ) : ?>
						<span class="nexus-icsc__tagline" style="display:inline-block;font-size:0.875rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:<?php echo esc_attr( $cfg['tagline'] ); ?>;margin-bottom:0.75rem;">
							<?php echo esc_html( $tagline ); ?>
						</span>
					<?php endif; ?>
					<?php if ( $headline ) : ?>
						<h2 class="nexus-icsc__title" style="font-size:clamp(1.5rem,3vw,2.25rem);font-weight:700;color:<?php echo esc_attr( $cfg['heading'] ); ?>;margin:0 0 0.75rem;">
							<?php echo wp_kses_post( $headline ); ?>
						</h2>
					<?php endif; ?>
					<?php if ( $description ) : ?>
						<p class="nexus-icsc__desc" style="font-size:1.0625rem;line-height:1.7;color:<?php echo esc_attr( $cfg['text'] ); ?>;margin:0;">
							<?php echo wp_kses_post( $description ); ?>
						</p>
					<?php endif; ?>
				</div>
				<?php endif; ?>

			</div>

			<div class="nexus-container">
				<div class="nexus-icsc__wrap" id="<?php echo esc_attr( $widget_id ); ?>-wrap">
				<div class="nexus-icsc__slider swiper" id="<?php echo esc_attr( $widget_id ); ?>-swiper" style="overflow:hidden;">
					<div class="swiper-wrapper">
						<?php foreach ( $cards as $idx => $card ) :
							$title    = $card['title'] ?? '';
							$desc     = $card['description'] ?? '';
							$link_url = ! empty( $card['link']['url'] ) ? esc_url( $card['link']['url'] ) : '';
							$target   = ! empty( $card['link']['is_external'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';
							$delay    = $idx * 100;
							$anim_cls = $has_anim ? ' nexus-icsc-card--anim' : '';

							// Card inline styles.
							$card_bg_style = $is_glass
								? 'background:' . $cfg['card_bg'] . ';backdrop-filter:blur(12px);-webkit-backdrop-filter:blur(12px);border:1px solid rgba(255,255,255,0.1);'
								: 'background-color:' . $cfg['card_bg'] . ';';

							if ( 'bordered-slim' === $preset ) {
								$card_bg_style .= 'border:1px solid rgba(0,0,0,0.08);border-left:3px solid ' . $cfg['tagline'] . ';';
							}

							if ( 'dark-neon' === $preset ) {
								$card_bg_style .= 'border:1px solid rgba(255,255,255,0.08);';
							}

							// Icon bg inline.
							$icon_bg_is_gradient = str_starts_with( $cfg['icon_bg'], 'linear-gradient' );
							$icon_bg_style       = $icon_bg_is_gradient
								? 'background:' . $cfg['icon_bg'] . ';'
								: 'background-color:' . $cfg['icon_bg'] . ';';
							?>
							<div class="swiper-slide">
								<?php if ( $link_url ) : ?>
								<a href="<?php echo esc_url( $link_url ); ?>"<?php echo $target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> class="nexus-icsc-card<?php echo esc_attr( $anim_cls ); ?>" style="<?php echo esc_attr( $card_bg_style ); ?>border-radius:12px;padding:2rem;display:flex;flex-direction:column;text-decoration:none;color:inherit;transition:transform 0.3s ease,box-shadow 0.3s ease;height:100%;"<?php echo $has_anim ? ' data-icsc-delay="' . esc_attr( $delay ) . '"' : ''; ?>>
								<?php else : ?>
								<div class="nexus-icsc-card<?php echo esc_attr( $anim_cls ); ?>" style="<?php echo esc_attr( $card_bg_style ); ?>border-radius:12px;padding:2rem;display:flex;flex-direction:column;transition:transform 0.3s ease,box-shadow 0.3s ease;height:100%;"<?php echo $has_anim ? ' data-icsc-delay="' . esc_attr( $delay ) . '"' : ''; ?>>
								<?php endif; ?>

									<div class="nexus-icsc-card__icon-wrap" style="margin-bottom:1.25rem;">
										<span class="nexus-icsc-card__icon" style="display:flex;align-items:center;justify-content:center;width:56px;height:56px;border-radius:12px;font-size:1.5rem;color:<?php echo esc_attr( $cfg['icon_color'] ); ?>;<?php echo esc_attr( $icon_bg_style ); ?>transition:transform 0.3s ease,box-shadow 0.3s ease;">
											<?php
											if ( ! empty( $card['icon']['value'] ) ) {
												\Elementor\Icons_Manager::render_icon( $card['icon'], array( 'aria-hidden' => 'true' ) );
											}
											?>
										</span>
									</div>

									<?php if ( $title ) : ?>
										<h3 class="nexus-icsc-card__title" style="font-size:1.125rem;font-weight:700;color:<?php echo esc_attr( $cfg['heading'] ); ?>;margin:0 0 0.5rem;line-height:1.35;">
											<?php echo esc_html( $title ); ?>
										</h3>
									<?php endif; ?>

									<?php if ( $desc ) : ?>
										<p class="nexus-icsc-card__desc" style="font-size:0.9375rem;line-height:1.65;color:<?php echo esc_attr( $cfg['text'] ); ?>;margin:0;flex:1;">
											<?php echo wp_kses_post( $desc ); ?>
										</p>
									<?php endif; ?>

									<?php if ( $link_url ) : ?>
										<span class="nexus-icsc-card__arrow" style="display:inline-flex;align-items:center;margin-top:1rem;color:<?php echo esc_attr( $cfg['tagline'] ); ?>;font-size:1.125rem;transition:transform 0.3s ease;">
											<i class="ri-arrow-right-line" aria-hidden="true"></i>
										</span>
									<?php endif; ?>

								<?php echo $link_url ? '</a>' : '</div>'; ?>
							</div>
						<?php endforeach; ?>
					</div>

					<?php if ( $dots ) : ?>
						<div class="swiper-pagination nexus-icsc__dots" style="margin-top:2rem;position:relative;"></div>
					<?php endif; ?>

				</div>

				<?php if ( $arrows ) : ?>
					<button class="swiper-button-prev nexus-icsc__arrow nexus-icsc__arrow--prev" aria-label="<?php esc_attr_e( 'Previous', 'nexus' ); ?>"></button>
					<button class="swiper-button-next nexus-icsc__arrow nexus-icsc__arrow--next" aria-label="<?php esc_attr_e( 'Next', 'nexus' ); ?>"></button>
				<?php endif; ?>
			</div>
			</div>

		</section>

		<script>
		(function(){
			var swiperId='<?php echo esc_js( $widget_id ); ?>-swiper';
			var wrapId='<?php echo esc_js( $widget_id ); ?>-wrap';
			function initICSC(){
				var el=document.getElementById(swiperId);
				var wrap=document.getElementById(wrapId);
				if(!el)return;
				if(!window.Swiper){setTimeout(initICSC,100);return;}
				if(el.swiper)el.swiper.destroy(true,true);
				var totalSlides=el.querySelectorAll('.swiper-slide').length;
				var spv=<?php echo esc_js( $spv ); ?>;
				var autoplayOpt=<?php echo 'yes' === $settings['autoplay'] ? '{delay:' . absint( $settings['autoplay_speed'] ) . ',disableOnInteraction:false}' : 'false'; ?>;
				new Swiper(el,{
					slidesPerView:spv,
					spaceBetween:24,
					loop:totalSlides>spv,
					autoplay:autoplayOpt,
					pagination:<?php echo $dots ? '{el:el.querySelector(\'.swiper-pagination\'),clickable:true}' : 'false'; ?>,
					navigation:<?php echo $arrows ? '{nextEl:wrap.querySelector(\'.swiper-button-next\'),prevEl:wrap.querySelector(\'.swiper-button-prev\')}' : 'false'; ?>,
					breakpoints:{
						0:{slidesPerView:1,spaceBetween:16},
						640:{slidesPerView:Math.min(2,spv),spaceBetween:20},
						992:{slidesPerView:Math.min(3,spv),spaceBetween:24},
						1200:{slidesPerView:spv,spaceBetween:24}
					}
				});
			}
			if(document.readyState==='loading'){document.addEventListener('DOMContentLoaded',initICSC);}else{initICSC();}
			if(window.elementorFrontend){jQuery(window).on('elementor/frontend/init',function(){elementorFrontend.hooks.addAction('frontend/element_ready/nexus-icon-cards-scroller.default',initICSC);});}
		})();
		</script>

		<?php if ( $has_anim ) : ?>
		<script>
		(function(){
			var container=document.getElementById('<?php echo esc_js( $widget_id ); ?>');
			if(!container)return;
			var items=container.querySelectorAll('.nexus-icsc-card--anim');
			if(!items.length)return;
			var io=new IntersectionObserver(function(entries){
				entries.forEach(function(e){
					if(e.isIntersecting){
						var d=parseInt(e.target.getAttribute('data-icsc-delay'),10)||0;
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
