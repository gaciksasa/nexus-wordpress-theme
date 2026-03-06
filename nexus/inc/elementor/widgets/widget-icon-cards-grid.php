<?php
/**
 * Nexus Theme - Elementor Icon Cards Grid Widget
 *
 * Icon card grid section with 6 style presets.
 * All colors use CSS custom properties for palette + dark mode support.
 * Staggered entrance animation via IntersectionObserver.
 *
 * @package Nexus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Nexus_Widget_Icon_Cards_Grid
 */
class Nexus_Widget_Icon_Cards_Grid extends \Elementor\Widget_Base {

	public function get_name() {
		return 'nexus-icon-cards-grid';
	}

	public function get_title() {
		return esc_html__( 'Icon Cards Grid', 'nexus' );
	}

	public function get_icon() {
		return 'eicon-icon-box';
	}

	public function get_categories() {
		return array( 'nexus-elements' );
	}

	public function get_keywords() {
		return array( 'icon', 'cards', 'grid', 'features', 'services', 'nexus' );
	}

	// -----------------------------------------------------------------
	// Preset defaults
	// -----------------------------------------------------------------

	private function get_preset_defaults( $preset ) {
		$map = array(
			'clean-flat'      => array(
				'tagline'     => 'Features',
				'headline'    => 'Why Choose Us',
				'description' => 'Everything you need to build a successful digital presence.',
				'columns'     => 3,
				'cards'       => array(
					array( 'icon' => 'ri-palette-line', 'title' => 'Creative Design', 'desc' => 'Stunning visuals that capture your brand essence and communicate effectively.' ),
					array( 'icon' => 'ri-code-s-slash-line', 'title' => 'Clean Code', 'desc' => 'Well-structured, maintainable code following industry best practices.' ),
					array( 'icon' => 'ri-rocket-2-line', 'title' => 'Fast Performance', 'desc' => 'Optimized for speed, delivering exceptional user experiences every time.' ),
					array( 'icon' => 'ri-shield-check-line', 'title' => 'Secure & Reliable', 'desc' => 'Enterprise-grade security measures protecting your data at all times.' ),
					array( 'icon' => 'ri-customer-service-2-line', 'title' => '24/7 Support', 'desc' => 'Round-the-clock assistance ensuring your business never misses a beat.' ),
					array( 'icon' => 'ri-bar-chart-2-line', 'title' => 'Analytics', 'desc' => 'Data-driven insights to help you make smarter business decisions.' ),
				),
			),
			'gradient-icon'   => array(
				'tagline'     => 'Our Services',
				'headline'    => 'What We Offer',
				'description' => 'Comprehensive solutions tailored to your unique business needs.',
				'columns'     => 3,
				'cards'       => array(
					array( 'icon' => 'ri-lightbulb-line', 'title' => 'Strategy', 'desc' => 'Research-driven strategies that align with your business goals.' ),
					array( 'icon' => 'ri-layout-masonry-line', 'title' => 'UI/UX Design', 'desc' => 'Intuitive interfaces designed for maximum user engagement.' ),
					array( 'icon' => 'ri-terminal-box-line', 'title' => 'Development', 'desc' => 'Robust applications built with cutting-edge technologies.' ),
					array( 'icon' => 'ri-line-chart-line', 'title' => 'Marketing', 'desc' => 'Growth-focused campaigns that deliver measurable results.' ),
					array( 'icon' => 'ri-cloud-line', 'title' => 'Cloud Solutions', 'desc' => 'Scalable infrastructure to support your growing business.' ),
					array( 'icon' => 'ri-team-line', 'title' => 'Consulting', 'desc' => 'Expert guidance to navigate complex digital challenges.' ),
				),
			),
			'dark-elevated'   => array(
				'tagline'     => 'Capabilities',
				'headline'    => 'Built for Scale',
				'description' => '',
				'columns'     => 3,
				'cards'       => array(
					array( 'icon' => 'ri-database-2-line', 'title' => 'Data Storage', 'desc' => 'Secure and scalable data solutions for enterprise needs.' ),
					array( 'icon' => 'ri-git-branch-line', 'title' => 'CI/CD Pipeline', 'desc' => 'Automated workflows for rapid and reliable deployments.' ),
					array( 'icon' => 'ri-shield-keyhole-line', 'title' => 'Security', 'desc' => 'Multi-layer protection keeping your systems safe.' ),
					array( 'icon' => 'ri-speed-line', 'title' => 'Performance', 'desc' => 'Optimized systems delivering sub-second response times.' ),
					array( 'icon' => 'ri-global-line', 'title' => 'Global CDN', 'desc' => 'Content delivered fast to users worldwide.' ),
					array( 'icon' => 'ri-tools-line', 'title' => 'Maintenance', 'desc' => 'Proactive monitoring and regular system updates.' ),
				),
			),
			'bordered-minimal' => array(
				'tagline'     => 'How It Works',
				'headline'    => 'Simple Process, Great Results',
				'description' => 'Our streamlined approach ensures quality delivery every time.',
				'columns'     => 3,
				'cards'       => array(
					array( 'icon' => 'ri-search-line', 'title' => 'Discovery', 'desc' => 'We learn about your business goals, audience, and competition.' ),
					array( 'icon' => 'ri-draft-line', 'title' => 'Planning', 'desc' => 'A detailed roadmap is created with milestones and deliverables.' ),
					array( 'icon' => 'ri-pencil-ruler-2-line', 'title' => 'Design', 'desc' => 'Wireframes and mockups bring your vision to life visually.' ),
					array( 'icon' => 'ri-code-line', 'title' => 'Build', 'desc' => 'Clean, efficient code transforms designs into reality.' ),
					array( 'icon' => 'ri-bug-line', 'title' => 'Testing', 'desc' => 'Rigorous QA ensures everything works flawlessly.' ),
					array( 'icon' => 'ri-rocket-line', 'title' => 'Launch', 'desc' => 'Your project goes live with full support and monitoring.' ),
				),
			),
			'accent-top'      => array(
				'tagline'     => 'Solutions',
				'headline'    => 'Tailored for Your Industry',
				'description' => 'Specialized solutions designed for specific business verticals.',
				'columns'     => 3,
				'cards'       => array(
					array( 'icon' => 'ri-store-2-line', 'title' => 'E-Commerce', 'desc' => 'Online stores that convert visitors into loyal customers.' ),
					array( 'icon' => 'ri-hospital-line', 'title' => 'Healthcare', 'desc' => 'HIPAA-compliant solutions for modern healthcare providers.' ),
					array( 'icon' => 'ri-graduation-cap-line', 'title' => 'Education', 'desc' => 'Learning platforms that engage and inspire students.' ),
					array( 'icon' => 'ri-bank-line', 'title' => 'Finance', 'desc' => 'Secure financial tools built for trust and compliance.' ),
					array( 'icon' => 'ri-restaurant-line', 'title' => 'Hospitality', 'desc' => 'Booking and management systems for the hospitality sector.' ),
					array( 'icon' => 'ri-building-line', 'title' => 'Real Estate', 'desc' => 'Property platforms with advanced search and virtual tours.' ),
				),
			),
			'glass-modern'    => array(
				'tagline'     => 'Technology',
				'headline'    => 'Powered by Innovation',
				'description' => 'Modern tech stack ensuring future-proof digital products.',
				'columns'     => 3,
				'cards'       => array(
					array( 'icon' => 'ri-brain-line', 'title' => 'AI & ML', 'desc' => 'Intelligent automation and predictive analytics at scale.' ),
					array( 'icon' => 'ri-links-line', 'title' => 'Blockchain', 'desc' => 'Decentralized solutions for transparency and security.' ),
					array( 'icon' => 'ri-cloud-line', 'title' => 'Cloud Native', 'desc' => 'Microservices architecture for maximum flexibility.' ),
					array( 'icon' => 'ri-smartphone-line', 'title' => 'Mobile First', 'desc' => 'Apps designed for the mobile generation.' ),
					array( 'icon' => 'ri-eye-line', 'title' => 'AR/VR', 'desc' => 'Immersive experiences that push the boundaries.' ),
					array( 'icon' => 'ri-link', 'title' => 'API Integration', 'desc' => 'Seamless connections between all your platforms.' ),
				),
			),
		);

		return $map[ $preset ] ?? $map['clean-flat'];
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
					'gradient-icon'    => esc_html__( '2 — Gradient Icon', 'nexus' ),
					'dark-elevated'    => esc_html__( '3 — Dark Elevated', 'nexus' ),
					'bordered-minimal' => esc_html__( '4 — Bordered Minimal', 'nexus' ),
					'accent-top'       => esc_html__( '5 — Accent Top', 'nexus' ),
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

		// ---- Cards Repeater ----
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
			'default' => esc_html__( 'Describe this feature in a few words.', 'nexus' ),
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
				'label'       => esc_html__( 'Cards', 'nexus' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(),
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
				'options'        => array( '1' => '1', '2' => '2', '3' => '3', '4' => '4' ),
				'selectors'      => array(
					'{{WRAPPER}} .nexus-icg__grid' => '--nexus-icg-cols: {{VALUE}};',
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
					'{{WRAPPER}} .nexus-icg__grid' => 'gap: {{SIZE}}{{UNIT}};',
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
			'selectors' => array( '{{WRAPPER}} .nexus-icg__tagline' => 'color: {{VALUE}};' ),
		) );

		$this->add_control( 'heading_color', array(
			'label'     => esc_html__( 'Heading Color', 'nexus' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => array( '{{WRAPPER}} .nexus-icg__title' => 'color: {{VALUE}};' ),
		) );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'heading_typography',
				'label'    => esc_html__( 'Heading Typography', 'nexus' ),
				'selector' => '{{WRAPPER}} .nexus-icg__title',
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
			'selectors' => array( '{{WRAPPER}} .nexus-icg-card__title' => 'color: {{VALUE}};' ),
		) );

		$this->add_control( 'card_desc_color', array(
			'label'     => esc_html__( 'Description Color', 'nexus' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => array( '{{WRAPPER}} .nexus-icg-card__desc' => 'color: {{VALUE}};' ),
		) );

		$this->add_control( 'icon_color_override', array(
			'label'     => esc_html__( 'Icon Color', 'nexus' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => array( '{{WRAPPER}} .nexus-icg-card__icon' => 'color: {{VALUE}};' ),
		) );

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
		$widget_id = 'nexus-icg-' . $this->get_id();

		$tagline     = ( '' !== $settings['tagline'] ) ? $settings['tagline'] : ( $defaults['tagline'] ?? '' );
		$headline    = ( '' !== $settings['headline'] ) ? $settings['headline'] : ( $defaults['headline'] ?? '' );
		$description = ( '' !== $settings['description'] ) ? $settings['description'] : ( $defaults['description'] ?? '' );
		$align       = $settings['header_align'] ?? 'center';

		// Cards: use repeater or fallback to preset defaults.
		$cards = $settings['cards'] ?? array();
		if ( empty( $cards ) ) {
			foreach ( $defaults['cards'] as $dc ) {
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

		$has_anim = ( 'none' !== $animation && ! $is_editor );
		?>

		<section
			class="nexus-icg nexus-icg--<?php echo esc_attr( $preset ); ?>"
			id="<?php echo esc_attr( $widget_id ); ?>"
		>
			<div class="nexus-container">

				<?php if ( $tagline || $headline || $description ) : ?>
				<div class="nexus-icg__header nexus-icg__header--<?php echo esc_attr( $align ); ?>">
					<?php if ( $tagline ) : ?>
						<span class="nexus-icg__tagline"><?php echo esc_html( $tagline ); ?></span>
					<?php endif; ?>
					<?php if ( $headline ) : ?>
						<h2 class="nexus-icg__title"><?php echo wp_kses_post( $headline ); ?></h2>
					<?php endif; ?>
					<?php if ( $description ) : ?>
						<p class="nexus-icg__desc"><?php echo wp_kses_post( $description ); ?></p>
					<?php endif; ?>
				</div>
				<?php endif; ?>

				<div class="nexus-icg__grid">
					<?php foreach ( $cards as $idx => $card ) :
						$delay    = $idx * 100;
						$anim_cls = $has_anim ? 'nexus-icg-card--anim' : 'is-visible';
						$has_link = ! empty( $card['link']['url'] );
						$tag      = $has_link ? 'a' : 'div';
						$link_attr = '';
						if ( $has_link ) {
							$link_attr = ' href="' . esc_url( $card['link']['url'] ) . '"';
							if ( ! empty( $card['link']['is_external'] ) ) {
								$link_attr .= ' target="_blank" rel="noopener noreferrer"';
							}
						}
						?>
						<<?php echo $tag . $link_attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> class="nexus-icg-card <?php echo esc_attr( $anim_cls ); ?>"<?php echo $has_anim ? ' data-icg-delay="' . esc_attr( $delay ) . '"' : ''; ?>>

							<?php if ( 'accent-top' === $preset ) : ?>
								<div class="nexus-icg-card__accent-bar"></div>
							<?php endif; ?>

							<div class="nexus-icg-card__icon-wrap">
								<span class="nexus-icg-card__icon">
									<?php
									if ( ! empty( $card['icon']['value'] ) ) {
										\Elementor\Icons_Manager::render_icon( $card['icon'], array( 'aria-hidden' => 'true' ) );
									}
									?>
								</span>
							</div>

							<?php if ( ! empty( $card['title'] ) ) : ?>
								<h3 class="nexus-icg-card__title"><?php echo esc_html( $card['title'] ); ?></h3>
							<?php endif; ?>

							<?php if ( ! empty( $card['description'] ) ) : ?>
								<p class="nexus-icg-card__desc"><?php echo wp_kses_post( $card['description'] ); ?></p>
							<?php endif; ?>

							<?php if ( $has_link ) : ?>
								<span class="nexus-icg-card__arrow">
									<i class="ri-arrow-right-line" aria-hidden="true"></i>
								</span>
							<?php endif; ?>

						</<?php echo esc_attr( $tag ); ?>>
					<?php endforeach; ?>
				</div>

			</div>
		</section>

		<?php if ( $has_anim ) : ?>
		<script>
		(function(){
			var container=document.getElementById('<?php echo esc_js( $widget_id ); ?>');
			if(!container)return;
			var items=container.querySelectorAll('.nexus-icg-card--anim');
			if(!items.length)return;
			var io=new IntersectionObserver(function(entries){
				entries.forEach(function(e){
					if(e.isIntersecting){
						var d=parseInt(e.target.getAttribute('data-icg-delay'),10)||0;
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
