<?php
/**
 * Nexus Theme - Elementor Hero Slider Widget
 *
 * Full-width hero slider with 6 visually distinct style presets.
 * Uses Swiper.js 11.x.
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

	// -----------------------------------------------------------------
	// Preset data
	// -----------------------------------------------------------------

	private function get_preset_colors( $preset ) {
		$p       = nexus_palette();
		$presets = array(
			'classic-corporate' => array(
				'tagline'   => $p['secondary'],
				'title'     => '#ffffff',
				'text'      => 'rgba(255,255,255,0.85)',
				'accent'    => $p['secondary'],
				'btn_pri'   => $p['secondary'],
				'btn_sec'   => 'rgba(255,255,255,0.7)',
			),
			'creative-split'    => array(
				'panel_bg'  => $p['primary'],
				'tagline'   => $p['secondary'],
				'title'     => '#ffffff',
				'text'      => 'rgba(255,255,255,0.75)',
				'btn_pri'   => $p['secondary'],
				'btn_sec'   => '#ffffff',
				'counter'   => 'rgba(255,255,255,0.5)',
				'progress'  => $p['secondary'],
			),
			'minimal-center'    => array(
				'tagline'   => 'rgba(255,255,255,0.6)',
				'title'     => '#ffffff',
				'text'      => 'rgba(255,255,255,0.75)',
				'btn_pri'   => '#ffffff',
				'btn_sec'   => 'rgba(255,255,255,0.6)',
				'dot_color' => '#ffffff',
			),
			'editorial-bottom'  => array(
				'tagline_bg'   => $p['secondary'],
				'tagline_text' => '#ffffff',
				'title'        => '#ffffff',
				'text'         => 'rgba(255,255,255,0.8)',
				'divider'      => 'rgba(255,255,255,0.25)',
				'btn_pri'      => '#ffffff',
				'nav_color'    => 'rgba(255,255,255,0.5)',
				'nav_active'   => $p['secondary'],
			),
			'cinematic-dark'    => array(
				'tagline'      => $p['secondary'],
				'title'        => '#ffffff',
				'text'         => 'rgba(255,255,255,0.7)',
				'frame'        => 'rgba(255,255,255,0.2)',
				'btn_pri'      => '#ffffff',
				'btn_sec'      => 'rgba(255,255,255,0.8)',
				'line_color'   => 'rgba(255,255,255,0.3)',
				'line_active'  => $p['secondary'],
			),
			'bold-startup'      => array(
				'tagline_bg'   => $p['secondary'],
				'tagline_text' => '#ffffff',
				'title'        => '#ffffff',
				'title_accent' => $p['secondary'],
				'text'         => 'rgba(255,255,255,0.85)',
				'btn_grad'     => $p['secondary'],
				'btn_sec'      => 'rgba(255,255,255,0.6)',
				'arrow_bg'     => '#ffffff',
				'arrow_icon'   => $p['primary'],
				'shape_color'  => $p['secondary'],
			),
		);

		return $presets[ $preset ] ?? $presets['classic-corporate'];
	}

	private function get_preset_defaults( $preset ) {
		$img_base = get_template_directory_uri() . '/assets/images/hero/';
		$presets   = array(
			'classic-corporate' => array(
				'effect'  => 'fade',
				'speed'   => 800,
				'slides'  => array(
					array(
						'tagline' => 'Welcome to Nexus',
						'title'   => 'Building Trust Through Excellence',
						'text'    => 'A premium WordPress theme for corporate and business websites.',
						'btn'     => 'Get Started',
						'btn2'    => 'Learn More',
						'image'   => $img_base . 'corporate-01.jpg',
					),
					array(
						'tagline' => 'Professional Solutions',
						'title'   => 'Grow Your Business Online',
						'text'    => 'Designed for performance, built for conversion.',
						'btn'     => 'Our Services',
						'btn2'    => 'Contact Us',
						'image'   => $img_base . 'corporate-02.jpg',
					),
				),
			),
			'creative-split'    => array(
				'effect'  => 'slide',
				'speed'   => 600,
				'slides'  => array(
					array(
						'tagline' => 'Creative Studio',
						'title'   => 'We Design Digital Experiences',
						'text'    => 'Branding, web design, and digital strategy for ambitious brands.',
						'btn'     => 'View Work',
						'btn2'    => '',
						'image'   => $img_base . 'creative-01.jpg',
					),
					array(
						'tagline' => 'Our Approach',
						'title'   => 'Where Vision Meets Craft',
						'text'    => 'Every project starts with understanding your story.',
						'btn'     => 'Start a Project',
						'btn2'    => '',
						'image'   => $img_base . 'creative-02.jpg',
					),
				),
			),
			'minimal-center'    => array(
				'effect'  => 'fade',
				'speed'   => 1000,
				'slides'  => array(
					array(
						'tagline' => 'Introducing Nexus',
						'title'   => 'Less Noise, More Impact',
						'text'    => 'Clean design meets powerful functionality.',
						'btn'     => 'Explore',
						'btn2'    => 'Learn More',
						'image'   => $img_base . 'minimal-01.jpg',
					),
					array(
						'tagline' => 'Built for Speed',
						'title'   => 'Performance First Design',
						'text'    => 'Lightweight, fast, and beautifully minimal.',
						'btn'     => 'Get Started',
						'btn2'    => '',
						'image'   => $img_base . 'minimal-02.jpg',
					),
				),
			),
			'editorial-bottom'  => array(
				'effect'  => 'slide',
				'speed'   => 700,
				'slides'  => array(
					array(
						'tagline' => 'Featured',
						'title'   => 'The Future of Digital Design',
						'text'    => 'An editorial take on modern web experiences.',
						'btn'     => 'Read More →',
						'btn2'    => '',
						'image'   => $img_base . 'editorial-01.jpg',
					),
					array(
						'tagline' => 'Trending',
						'title'   => 'Bold Ideas That Move',
						'text'    => 'Explore the intersection of creativity and technology.',
						'btn'     => 'Discover →',
						'btn2'    => '',
						'image'   => $img_base . 'editorial-02.jpg',
					),
				),
			),
			'cinematic-dark'    => array(
				'effect'  => 'fade',
				'speed'   => 1200,
				'slides'  => array(
					array(
						'tagline' => 'Visual Storytelling',
						'title'   => 'Crafted With Precision',
						'text'    => 'Where elegance meets visual narrative.',
						'btn'     => 'Explore',
						'btn2'    => '',
						'image'   => $img_base . 'cinematic-01.jpg',
					),
					array(
						'tagline' => 'Portfolio',
						'title'   => 'Capturing Moments',
						'text'    => 'A cinematic approach to digital presence.',
						'btn'     => 'View Gallery',
						'btn2'    => '',
						'image'   => $img_base . 'cinematic-02.jpg',
					),
				),
			),
			'bold-startup'      => array(
				'effect'  => 'slide',
				'speed'   => 600,
				'slides'  => array(
					array(
						'tagline' => 'New Release',
						'title'   => 'Launch Your Next Big Idea',
						'text'    => 'The all-in-one platform for modern startups and SaaS.',
						'btn'     => 'Start Free Trial',
						'btn2'    => 'Watch Demo',
						'image'   => $img_base . 'startup-01.jpg',
					),
					array(
						'tagline' => 'Scale Fast',
						'title'   => 'Built to Grow With You',
						'text'    => 'From MVP to market leader — we have you covered.',
						'btn'     => 'Get Started',
						'btn2'    => 'See Pricing',
						'image'   => $img_base . 'startup-02.jpg',
					),
				),
			),
		);

		return $presets[ $preset ] ?? $presets['classic-corporate'];
	}

	// -----------------------------------------------------------------
	// Controls
	// -----------------------------------------------------------------

	protected function register_controls() {

		// ---------------------------------------------------------------
		// CONTENT: Style Preset
		// ---------------------------------------------------------------
		$this->start_controls_section(
			'section_preset',
			array( 'label' => esc_html__( 'Style', 'nexus' ) )
		);

		$this->add_control(
			'style_preset',
			array(
				'label'       => esc_html__( 'Style', 'nexus' ),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'default'     => 'classic-corporate',
				'options'     => array(
					'classic-corporate' => esc_html__( '1 — Classic Corporate', 'nexus' ),
					'creative-split'    => esc_html__( '2 — Creative Split', 'nexus' ),
					'minimal-center'    => esc_html__( '3 — Minimal Center', 'nexus' ),
					'editorial-bottom'  => esc_html__( '4 — Editorial Bottom', 'nexus' ),
					'cinematic-dark'    => esc_html__( '5 — Cinematic Dark', 'nexus' ),
					'bold-startup'      => esc_html__( '6 — Bold Startup', 'nexus' ),
				),
				'render_type' => 'template',
			)
		);

		$this->end_controls_section();

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
					'px' => array( 'min' => 300, 'max' => 1200, 'step' => 10 ),
					'vh' => array( 'min' => 30, 'max' => 100 ),
				),
				'default'    => array( 'size' => 700, 'unit' => 'px' ),
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
				'label'   => esc_html__( 'Show Pagination', 'nexus' ),
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

	// -----------------------------------------------------------------
	// Render
	// -----------------------------------------------------------------

	protected function render() {
		$settings  = $this->get_settings_for_display();
		$preset    = $settings['style_preset'] ?? 'classic-corporate';
		$colors    = $this->get_preset_colors( $preset );
		$defaults  = $this->get_preset_defaults( $preset );
		$slides    = $settings['slides'] ?? array();
		$widget_id = 'nexus-hero-' . $this->get_id();

		if ( empty( $slides ) ) {
			return;
		}

		$arrows      = 'yes' === ( $settings['show_arrows'] ?? '' );
		$dots        = 'yes' === ( $settings['show_dots'] ?? '' );
		$loop        = 'yes' === ( $settings['loop'] ?? '' );
		$align       = $settings['content_align'] ?? 'left';
		$effect      = $defaults['effect'];
		$speed       = $defaults['speed'];
		$autoplay    = 'yes' === ( $settings['autoplay'] ?? '' );
		$delay       = absint( $settings['autoplay_speed'] ?? 5000 );
		$total       = count( $slides );

		// Build autoplay config.
		$autoplay_opt = $autoplay
			? '{delay:' . $delay . ',disableOnInteraction:false}'
			: 'false';
		?>

		<div
			id="<?php echo esc_attr( $widget_id ); ?>"
			class="nexus-hero-slider nexus-hero-slider--<?php echo esc_attr( $preset ); ?> swiper content-<?php echo esc_attr( $align ); ?>"
			data-effect="<?php echo esc_attr( $effect ); ?>"
			data-speed="<?php echo esc_attr( $speed ); ?>"
		>
			<div class="swiper-wrapper">
				<?php
				$default_slides = $defaults['slides'] ?? array();
				foreach ( $slides as $idx => $slide ) {
					// Use preset default image when the user hasn't set a custom one.
					$slide_bg = $slide['slide_bg']['url'] ?? '';
					if ( empty( $slide_bg ) || false !== strpos( $slide_bg, 'placeholder' ) ) {
						$fallback_img = $default_slides[ $idx ]['image'] ?? ( $default_slides[0]['image'] ?? '' );
						if ( $fallback_img ) {
							$slide['slide_bg']['url'] = $fallback_img;
						}
					}

					switch ( $preset ) {
						case 'creative-split':
							$this->render_creative_split( $slide, $colors, $align, $idx );
							break;
						case 'minimal-center':
							$this->render_minimal_center( $slide, $colors );
							break;
						case 'editorial-bottom':
							$this->render_editorial_bottom( $slide, $colors );
							break;
						case 'cinematic-dark':
							$this->render_cinematic_dark( $slide, $colors );
							break;
						case 'bold-startup':
							$this->render_bold_startup( $slide, $colors, $align );
							break;
						default: // classic-corporate.
							$this->render_classic_corporate( $slide, $colors, $align );
							break;
					}
				}
				?>
			</div>

			<?php if ( $dots ) : ?>
				<?php if ( 'editorial-bottom' === $preset ) : ?>
					<div class="nexus-hero-slider__nav-numbers" data-total="<?php echo esc_attr( $total ); ?>"></div>
				<?php elseif ( 'cinematic-dark' === $preset ) : ?>
					<div class="swiper-pagination nexus-hero-slider__lines"></div>
				<?php elseif ( 'minimal-center' === $preset ) : ?>
					<div class="swiper-pagination nexus-hero-slider__side-dots"></div>
				<?php else : ?>
					<div class="swiper-pagination nexus-hero-slider__dots"></div>
				<?php endif; ?>
			<?php endif; ?>

			<?php
			// Arrows: not shown for minimal-center, cinematic-dark, editorial-bottom.
			$hide_arrows = in_array( $preset, array( 'minimal-center', 'cinematic-dark', 'editorial-bottom' ), true );
			if ( $arrows && ! $hide_arrows ) :
				?>
				<button class="swiper-button-prev nexus-hero-slider__prev" aria-label="<?php esc_attr_e( 'Previous slide', 'nexus' ); ?>"></button>
				<button class="swiper-button-next nexus-hero-slider__next" aria-label="<?php esc_attr_e( 'Next slide', 'nexus' ); ?>"></button>
			<?php endif; ?>

			<?php if ( 'creative-split' === $preset && $dots ) : ?>
				<div class="nexus-hero-slider__progress">
					<span class="nexus-hero-slider__progress-current">01</span>
					<span class="nexus-hero-slider__progress-bar"><span></span></span>
					<span class="nexus-hero-slider__progress-total"><?php echo esc_html( str_pad( $total, 2, '0', STR_PAD_LEFT ) ); ?></span>
				</div>
			<?php endif; ?>
		</div>

		<?php $this->render_swiper_script( $widget_id, $preset, $settings, $dots, $arrows && ! $hide_arrows, $total, $effect, $speed, $autoplay_opt, $loop ); ?>
		<?php
	}

	// -----------------------------------------------------------------
	// 1. Classic Corporate
	// -----------------------------------------------------------------
	private function render_classic_corporate( $slide, $colors, $align ) {
		$bg_url  = $slide['slide_bg']['url'] ?? '';
		$overlay = $slide['slide_overlay_color'] ?? 'rgba(0,0,0,0.5)';
		?>
		<div class="swiper-slide nexus-hero-slide" style="background-image:url(<?php echo esc_url( $bg_url ); ?>);background-size:cover;background-position:center;">
			<div class="nexus-hero-slide__overlay" style="background:linear-gradient(to right,rgba(0,0,0,0.75) 0%,rgba(0,0,0,0.4) 50%,transparent 85%);"></div>
			<div class="nexus-container nexus-hero-slide__container">
				<div class="nexus-hero-slide__content" style="align-items:flex-start;text-align:left;max-width:640px;">
					<div class="nexus-hero-slide__accent-bar" style="position:absolute;left:0;top:50%;transform:translateY(-50%);width:4px;height:60px;background:<?php echo esc_attr( $colors['accent'] ); ?>;border-radius:2px;"></div>
					<?php $this->render_tagline_line( $slide, $colors ); ?>
					<?php $this->render_title( $slide, $colors ); ?>
					<?php $this->render_text( $slide, $colors ); ?>
					<?php $this->render_buttons( $slide, $colors, 'solid', 'outline-white' ); ?>
				</div>
			</div>
		</div>
		<?php
	}

	// -----------------------------------------------------------------
	// 2. Creative Split
	// -----------------------------------------------------------------
	private function render_creative_split( $slide, $colors, $align, $idx ) {
		$bg_url  = $slide['slide_bg']['url'] ?? '';
		?>
		<div class="swiper-slide nexus-hero-slide nexus-hero-slide--split">
			<div class="nexus-hero-slide__split-panel" style="background:<?php echo esc_attr( $colors['panel_bg'] ); ?>;">
				<div class="nexus-hero-slide__content" style="align-items:flex-start;text-align:left;max-width:480px;padding:4rem 3.5rem 4rem 4rem;">
					<?php $this->render_tagline_line( $slide, $colors ); ?>
					<h2 class="nexus-hero-slide__title" style="font-size:clamp(2.5rem,6vw,5rem);font-weight:800;line-height:1.02;letter-spacing:-0.03em;color:<?php echo esc_attr( $colors['title'] ); ?>;margin:0 0 1.25rem;">
						<?php echo wp_kses_post( $slide['slide_title'] ?? '' ); ?>
					</h2>
					<?php $this->render_text( $slide, $colors ); ?>
					<?php $this->render_buttons( $slide, $colors, 'pill', 'ghost' ); ?>
				</div>
			</div>
			<div class="nexus-hero-slide__split-image" style="background-image:url(<?php echo esc_url( $bg_url ); ?>);background-size:cover;background-position:center;">
				<div class="nexus-hero-slide__overlay" style="background:rgba(0,0,0,0.2);"></div>
			</div>
		</div>
		<?php
	}

	// -----------------------------------------------------------------
	// 3. Minimal Center
	// -----------------------------------------------------------------
	private function render_minimal_center( $slide, $colors ) {
		$bg_url  = $slide['slide_bg']['url'] ?? '';
		$overlay = $slide['slide_overlay_color'] ?? 'rgba(0,0,0,0.55)';
		?>
		<div class="swiper-slide nexus-hero-slide nexus-hero-slide--minimal" style="background-image:url(<?php echo esc_url( $bg_url ); ?>);background-size:cover;background-position:center;">
			<div class="nexus-hero-slide__overlay" style="background:<?php echo esc_attr( $overlay ); ?>;backdrop-filter:blur(3px);-webkit-backdrop-filter:blur(3px);"></div>
			<div class="nexus-container nexus-hero-slide__container">
				<div class="nexus-hero-slide__content" style="align-items:center;text-align:center;max-width:700px;margin:0 auto;">
					<?php if ( ! empty( $slide['slide_tagline'] ) ) : ?>
						<p class="nexus-hero-slide__tagline" style="font-size:0.8125rem;font-weight:600;text-transform:uppercase;letter-spacing:0.15em;color:<?php echo esc_attr( $colors['tagline'] ); ?>;margin:0 0 1rem;">
							<?php echo esc_html( $slide['slide_tagline'] ); ?>
						</p>
					<?php endif; ?>
					<h2 class="nexus-hero-slide__title" style="font-size:clamp(2rem,4vw,3rem);font-weight:600;line-height:1.2;color:<?php echo esc_attr( $colors['title'] ); ?>;margin:0 0 1rem;">
						<?php echo wp_kses_post( $slide['slide_title'] ?? '' ); ?>
					</h2>
					<?php $this->render_text( $slide, $colors ); ?>
					<?php $this->render_buttons( $slide, $colors, 'outline-white', 'outline-white-sm' ); ?>
				</div>
			</div>
		</div>
		<?php
	}

	// -----------------------------------------------------------------
	// 4. Editorial Bottom
	// -----------------------------------------------------------------
	private function render_editorial_bottom( $slide, $colors ) {
		$bg_url = $slide['slide_bg']['url'] ?? '';
		?>
		<div class="swiper-slide nexus-hero-slide nexus-hero-slide--editorial" style="background-image:url(<?php echo esc_url( $bg_url ); ?>);background-size:cover;background-position:center;">
			<div class="nexus-hero-slide__overlay" style="background:linear-gradient(to top,rgba(0,0,0,0.85) 0%,rgba(0,0,0,0.4) 40%,transparent 70%);"></div>
			<div class="nexus-container nexus-hero-slide__container" style="align-items:flex-end;">
				<div class="nexus-hero-slide__content" style="align-items:flex-start;text-align:left;padding-bottom:5rem;width:100%;">
					<?php if ( ! empty( $slide['slide_tagline'] ) ) : ?>
						<span class="nexus-hero-slide__badge" style="display:inline-block;font-size:0.75rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;background:<?php echo esc_attr( $colors['tagline_bg'] ); ?>;color:<?php echo esc_attr( $colors['tagline_text'] ); ?>;padding:0.35em 1em;border-radius:4px;margin-bottom:1.25rem;">
							<?php echo esc_html( $slide['slide_tagline'] ); ?>
						</span>
					<?php endif; ?>
					<h2 class="nexus-hero-slide__title" style="font-size:clamp(3rem,8vw,6rem);font-weight:800;line-height:0.95;text-transform:uppercase;letter-spacing:-0.02em;color:<?php echo esc_attr( $colors['title'] ); ?>;margin:0 0 1.5rem;max-width:900px;">
						<?php echo wp_kses_post( $slide['slide_title'] ?? '' ); ?>
					</h2>
					<div class="nexus-hero-slide__divider" style="width:80px;height:1px;background:<?php echo esc_attr( $colors['divider'] ); ?>;margin-bottom:1.25rem;"></div>
					<div class="nexus-hero-slide__bottom-row" style="display:flex;align-items:center;gap:2rem;flex-wrap:wrap;">
						<?php if ( ! empty( $slide['slide_text'] ) ) : ?>
							<p class="nexus-hero-slide__text" style="font-size:0.9375rem;line-height:1.6;color:<?php echo esc_attr( $colors['text'] ); ?>;margin:0;max-width:400px;">
								<?php echo wp_kses_post( $slide['slide_text'] ); ?>
							</p>
						<?php endif; ?>
						<?php $this->render_buttons( $slide, $colors, 'text-link', '' ); ?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	// -----------------------------------------------------------------
	// 5. Cinematic Dark
	// -----------------------------------------------------------------
	private function render_cinematic_dark( $slide, $colors ) {
		$bg_url = $slide['slide_bg']['url'] ?? '';
		?>
		<div class="swiper-slide nexus-hero-slide nexus-hero-slide--cinematic" style="background-image:url(<?php echo esc_url( $bg_url ); ?>);background-size:cover;background-position:center;">
			<div class="nexus-hero-slide__overlay" style="background:rgba(0,0,0,0.65);"></div>
			<div class="nexus-hero-slide__frame" style="position:absolute;inset:20px;border:1px solid <?php echo esc_attr( $colors['frame'] ); ?>;z-index:2;pointer-events:none;"></div>
			<div class="nexus-container nexus-hero-slide__container">
				<div class="nexus-hero-slide__content" style="align-items:center;text-align:center;max-width:700px;margin:0 auto;">
					<?php if ( ! empty( $slide['slide_tagline'] ) ) : ?>
						<p class="nexus-hero-slide__tagline" style="font-size:0.75rem;font-weight:400;text-transform:uppercase;letter-spacing:0.25em;color:<?php echo esc_attr( $colors['tagline'] ); ?>;margin:0 0 1.5rem;">
							<?php echo esc_html( $slide['slide_tagline'] ); ?>
						</p>
					<?php endif; ?>
					<h2 class="nexus-hero-slide__title" style="font-size:clamp(2.5rem,5vw,4rem);font-weight:300;line-height:1.15;letter-spacing:0.05em;text-transform:uppercase;color:<?php echo esc_attr( $colors['title'] ); ?>;margin:0 0 1.25rem;">
						<?php echo wp_kses_post( $slide['slide_title'] ?? '' ); ?>
					</h2>
					<?php if ( ! empty( $slide['slide_text'] ) ) : ?>
						<p class="nexus-hero-slide__text" style="font-size:1rem;font-style:italic;font-weight:300;line-height:1.7;color:<?php echo esc_attr( $colors['text'] ); ?>;margin:0 0 2rem;max-width:520px;">
							<?php echo wp_kses_post( $slide['slide_text'] ); ?>
						</p>
					<?php endif; ?>
					<?php $this->render_buttons( $slide, $colors, 'thin-outline', 'ghost-underline' ); ?>
				</div>
			</div>
		</div>
		<?php
	}

	// -----------------------------------------------------------------
	// 6. Bold Startup
	// -----------------------------------------------------------------
	private function render_bold_startup( $slide, $colors, $align ) {
		$bg_url = $slide['slide_bg']['url'] ?? '';
		$p      = nexus_palette();
		?>
		<div class="swiper-slide nexus-hero-slide nexus-hero-slide--bold" style="background-image:url(<?php echo esc_url( $bg_url ); ?>);background-size:cover;background-position:center;">
			<div class="nexus-hero-slide__overlay" style="background:linear-gradient(135deg,rgba(15,15,35,0.9) 0%,rgba(15,52,96,0.7) 50%,rgba(0,0,0,0.3) 100%);"></div>
			<div class="nexus-hero-slide__shape" style="position:absolute;right:-5%;top:10%;width:45vw;height:45vw;border-radius:50%;background:<?php echo esc_attr( $colors['shape_color'] ); ?>;opacity:0.08;filter:blur(60px);pointer-events:none;z-index:1;"></div>
			<div class="nexus-container nexus-hero-slide__container" style="z-index:2;">
				<div class="nexus-hero-slide__content" style="align-items:flex-start;text-align:left;max-width:600px;">
					<?php if ( ! empty( $slide['slide_tagline'] ) ) : ?>
						<span class="nexus-hero-slide__badge" style="display:inline-block;font-size:0.75rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;background:<?php echo esc_attr( $colors['tagline_bg'] ); ?>;color:<?php echo esc_attr( $colors['tagline_text'] ); ?>;padding:0.4em 1.2em;border-radius:50rem;margin-bottom:1.25rem;">
							<?php echo esc_html( $slide['slide_tagline'] ); ?>
						</span>
					<?php endif; ?>
					<h2 class="nexus-hero-slide__title" style="font-size:clamp(2.5rem,6vw,4.5rem);font-weight:900;line-height:1.05;letter-spacing:-0.03em;color:<?php echo esc_attr( $colors['title'] ); ?>;margin:0 0 1.25rem;">
						<?php echo wp_kses_post( $slide['slide_title'] ?? '' ); ?>
					</h2>
					<?php $this->render_text( $slide, $colors ); ?>
					<?php $this->render_buttons( $slide, $colors, 'gradient-pill', 'outline-white' ); ?>
				</div>
			</div>
		</div>
		<?php
	}

	// -----------------------------------------------------------------
	// Shared helpers
	// -----------------------------------------------------------------

	private function render_tagline_line( $slide, $colors ) {
		if ( empty( $slide['slide_tagline'] ) ) {
			return;
		}
		?>
		<p class="nexus-hero-slide__tagline" style="font-size:0.75rem;font-weight:700;text-transform:uppercase;letter-spacing:0.22em;color:<?php echo esc_attr( $colors['tagline'] ); ?>;margin:0 0 1rem;display:inline-flex;align-items:center;gap:0.75rem;">
			<span style="display:inline-block;width:28px;height:2px;background:<?php echo esc_attr( $colors['tagline'] ); ?>;"></span>
			<?php echo esc_html( $slide['slide_tagline'] ); ?>
		</p>
		<?php
	}

	private function render_title( $slide, $colors ) {
		if ( empty( $slide['slide_title'] ) ) {
			return;
		}
		?>
		<h2 class="nexus-hero-slide__title" style="font-size:clamp(2rem,4.5vw,3.5rem);font-weight:700;line-height:1.08;letter-spacing:-0.01em;color:<?php echo esc_attr( $colors['title'] ); ?>;margin:0 0 1rem;max-width:860px;">
			<?php echo wp_kses_post( $slide['slide_title'] ); ?>
		</h2>
		<?php
	}

	private function render_text( $slide, $colors ) {
		if ( empty( $slide['slide_text'] ) ) {
			return;
		}
		?>
		<p class="nexus-hero-slide__text" style="font-size:clamp(1rem,1.8vw,1.175rem);font-weight:400;line-height:1.75;color:<?php echo esc_attr( $colors['text'] ); ?>;margin:0 0 2rem;max-width:560px;">
			<?php echo wp_kses_post( $slide['slide_text'] ); ?>
		</p>
		<?php
	}

	private function render_buttons( $slide, $colors, $pri_style, $sec_style ) {
		$btn1 = $slide['btn_text'] ?? '';
		$btn2 = $slide['btn2_text'] ?? '';
		$url1 = $slide['btn_link']['url'] ?? '#';
		$url2 = $slide['btn2_link']['url'] ?? '#';
		$ext1 = ! empty( $slide['btn_link']['is_external'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';
		$ext2 = ! empty( $slide['btn2_link']['is_external'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';

		// Fallback to # when no URL is set.
		if ( empty( $url1 ) ) {
			$url1 = '#';
		}
		if ( empty( $url2 ) ) {
			$url2 = '#';
		}

		if ( ! $btn1 && ! $btn2 ) {
			return;
		}
		?>
		<div class="nexus-hero-slide__actions" style="display:flex;flex-wrap:wrap;gap:1rem;margin-top:0.5rem;">
			<?php if ( $btn1 ) : ?>
				<a href="<?php echo esc_url( $url1 ); ?>" class="nexus-btn nexus-btn--hero-pri" style="<?php echo esc_attr( $this->get_btn_style( $pri_style, $colors ) ); ?>"<?php echo $ext1; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
					<?php echo esc_html( $btn1 ); ?>
				</a>
			<?php endif; ?>
			<?php if ( $btn2 && $sec_style ) : ?>
				<a href="<?php echo esc_url( $url2 ); ?>" class="nexus-btn nexus-btn--hero-sec" style="<?php echo esc_attr( $this->get_btn_style( $sec_style, $colors ) ); ?>"<?php echo $ext2; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
					<?php echo esc_html( $btn2 ); ?>
				</a>
			<?php endif; ?>
		</div>
		<?php
	}

	private function get_btn_style( $style, $colors ) {
		$base = 'display:inline-flex;align-items:center;justify-content:center;font-size:0.9375rem;font-weight:600;letter-spacing:0.01em;text-decoration:none;transition:all 0.3s ease;cursor:pointer;';

		switch ( $style ) {
			case 'solid':
				return $base . 'padding:0.85em 2.25em;border-radius:6px;background:' . ( $colors['btn_pri'] ?? '#e94560' ) . ';color:#fff;border:2px solid ' . ( $colors['btn_pri'] ?? '#e94560' ) . ';';

			case 'pill':
				return $base . 'padding:0.85em 2.25em;border-radius:50rem;background:' . ( $colors['btn_pri'] ?? '#e94560' ) . ';color:#fff;border:2px solid ' . ( $colors['btn_pri'] ?? '#e94560' ) . ';';

			case 'gradient-pill':
				return $base . 'padding:0.95em 2.5em;border-radius:50rem;background:' . ( $colors['btn_grad'] ?? '#e94560' ) . ';color:#fff;border:none;box-shadow:0 4px 24px rgba(0,0,0,0.25);';

			case 'outline-white':
				return $base . 'padding:0.85em 2.25em;border-radius:50rem;background:rgba(255,255,255,0.08);color:#fff;border:1px solid rgba(255,255,255,0.5);backdrop-filter:blur(4px);';

			case 'outline-white-sm':
				return $base . 'padding:0.7em 1.75em;border-radius:50rem;background:transparent;color:rgba(255,255,255,0.8);border:1px solid rgba(255,255,255,0.4);font-size:0.875rem;';

			case 'ghost':
				return $base . 'padding:0.85em 1.5em;border-radius:0;background:transparent;color:#fff;border:none;text-decoration:none;';

			case 'ghost-underline':
				return $base . 'padding:0.5em 0;border-radius:0;background:transparent;color:' . ( $colors['btn_sec'] ?? 'rgba(255,255,255,0.8)' ) . ';border:none;border-bottom:1px solid ' . ( $colors['btn_sec'] ?? 'rgba(255,255,255,0.4)' ) . ';';

			case 'thin-outline':
				return $base . 'padding:0.85em 2.5em;border-radius:0;background:transparent;color:#fff;border:1px solid #fff;letter-spacing:0.1em;text-transform:uppercase;font-size:0.8125rem;';

			case 'text-link':
				return $base . 'padding:0;border-radius:0;background:transparent;color:' . ( $colors['btn_pri'] ?? '#ffffff' ) . ';border:none;font-weight:600;letter-spacing:0.02em;';

			default:
				return $base . 'padding:0.85em 2.25em;border-radius:50rem;background:' . ( $colors['btn_pri'] ?? '#e94560' ) . ';color:#fff;border:none;';
		}
	}

	// -----------------------------------------------------------------
	// Swiper init
	// -----------------------------------------------------------------

	private function render_swiper_script( $widget_id, $preset, $settings, $dots, $arrows, $total, $effect, $speed, $autoplay_opt, $loop ) {
		$loop_js = $loop && $total > 1 ? 'true' : 'false';

		// Pagination config per preset.
		if ( ! $dots ) {
			$pagination_js = 'false';
		} elseif ( 'editorial-bottom' === $preset ) {
			// Custom numbered nav handled separately.
			$pagination_js = 'false';
		} elseif ( 'cinematic-dark' === $preset ) {
			$pagination_js = '{el:"#' . esc_js( $widget_id ) . ' .nexus-hero-slider__lines",clickable:true,renderBullet:function(i,c){return \'<span class="\'+c+\'"></span>\';}}';
		} elseif ( 'minimal-center' === $preset ) {
			$pagination_js = '{el:"#' . esc_js( $widget_id ) . ' .nexus-hero-slider__side-dots",clickable:true,direction:"vertical"}';
		} else {
			$pagination_js = '{el:"#' . esc_js( $widget_id ) . ' .swiper-pagination",clickable:true}';
		}

		// Navigation config.
		$nav_js = $arrows
			? '{prevEl:"#' . esc_js( $widget_id ) . ' .swiper-button-prev",nextEl:"#' . esc_js( $widget_id ) . ' .swiper-button-next"}'
			: 'false';

		// Effect config.
		$effect_opts = '';
		if ( 'fade' === $effect ) {
			$effect_opts = 'fadeEffect:{crossFade:true},';
		}
		?>
		<script>
		(function(){
			var id='<?php echo esc_js( $widget_id ); ?>';
			function initHS(){
				var el=document.getElementById(id);
				if(!el)return;
				if(!window.Swiper){setTimeout(initHS,100);return;}
				if(el.swiper)el.swiper.destroy(true,true);

				var sw=new Swiper(el,{
					effect:'<?php echo esc_js( $effect ); ?>',
					<?php echo $effect_opts; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					speed:<?php echo absint( $speed ); ?>,
					loop:<?php echo $loop_js; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>,
					autoplay:<?php echo $autoplay_opt; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>,
					pagination:<?php echo $pagination_js; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>,
					navigation:<?php echo $nav_js; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>,
					a11y:{prevSlideMessage:'<?php echo esc_js( __( 'Previous slide', 'nexus' ) ); ?>',nextSlideMessage:'<?php echo esc_js( __( 'Next slide', 'nexus' ) ); ?>'}
				});

				<?php if ( 'editorial-bottom' === $preset && $dots ) : ?>
				// Numbered nav for editorial.
				var navEl=el.querySelector('.nexus-hero-slider__nav-numbers');
				if(navEl){
					var total=<?php echo absint( $total ); ?>;
					var html='';
					for(var i=0;i<total;i++){
						html+='<span class="nexus-hero-slider__nav-num'+(i===0?' is-active':'')+'" data-index="'+i+'">'+(i<9?'0':'')+(i+1)+'</span>';
						if(i<total-1)html+='<span class="nexus-hero-slider__nav-line"></span>';
					}
					navEl.innerHTML=html;
					navEl.querySelectorAll('.nexus-hero-slider__nav-num').forEach(function(n){
						n.addEventListener('click',function(){sw.slideTo(parseInt(this.dataset.index,10));});
					});
					sw.on('slideChange',function(){
						var idx=sw.realIndex;
						navEl.querySelectorAll('.nexus-hero-slider__nav-num').forEach(function(n,j){
							n.classList.toggle('is-active',j===idx);
						});
					});
				}
				<?php endif; ?>

				<?php if ( 'creative-split' === $preset && $dots ) : ?>
				// Progress counter for creative-split.
				var progEl=el.querySelector('.nexus-hero-slider__progress');
				if(progEl){
					var curEl=progEl.querySelector('.nexus-hero-slider__progress-current');
					sw.on('slideChange',function(){
						var idx=sw.realIndex+1;
						if(curEl)curEl.textContent=(idx<10?'0':'')+idx;
					});
				}
				<?php endif; ?>
			}
			if(document.readyState==='loading'){document.addEventListener('DOMContentLoaded',initHS);}else{initHS();}
			if(window.elementorFrontend){jQuery(window).on('elementor/frontend/init',function(){elementorFrontend.hooks.addAction('frontend/element_ready/nexus-hero-slider.default',initHS);});}
		})();
		</script>
		<?php
	}
}
