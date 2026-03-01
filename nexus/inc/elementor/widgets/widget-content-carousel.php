<?php
/**
 * Nexus Theme - Elementor Content Carousel Widget
 *
 * General-purpose content carousel with 6 visually distinct style presets.
 * Each slide: image, title, category, description, optional button.
 * Uses Swiper.js 11.x.
 *
 * @package Nexus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Nexus_Widget_Content_Carousel
 */
class Nexus_Widget_Content_Carousel extends \Elementor\Widget_Base {

	public function get_name() {
		return 'nexus-content-carousel';
	}

	public function get_title() {
		return esc_html__( 'Content Carousel', 'nexus' );
	}

	public function get_icon() {
		return 'eicon-post-slider';
	}

	public function get_categories() {
		return array( 'nexus-blocks' );
	}

	public function get_keywords() {
		return array( 'content', 'carousel', 'slider', 'slides', 'nexus' );
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
			'clean-cards'      => array(
				'section_bg'  => '#ffffff',
				'card_bg'     => '#ffffff',
				'heading'     => $p['primary'],
				'text'        => '#495057',
				'desc'        => '#6c757d',
				'tagline'     => $p['secondary'],
				'badge_bg'    => $p['secondary'],
				'badge_text'  => $p['secondary'],
				'dot_color'   => $p['secondary'],
			),
			'cinema-overlay'   => array(
				'section_bg'  => '#080818',
				'card_bg'     => 'transparent',
				'heading'     => '#ffffff',
				'text'        => 'rgba(255,255,255,0.75)',
				'desc'        => 'rgba(255,255,255,0.55)',
				'tagline'     => $p['secondary'],
				'badge_bg'    => $p['secondary'],
				'badge_text'  => '#ffffff',
				'overlay'     => 'linear-gradient(to top,rgba(8,8,24,0.92) 0%,rgba(8,8,24,0.45) 45%,transparent 100%)',
				'dot_color'   => $p['secondary'],
			),
			'soft-rounded'     => array(
				'section_bg'  => '#faf7f4',
				'card_bg'     => '#ffffff',
				'heading'     => $p['primary'],
				'text'        => '#64748b',
				'desc'        => '#94a3b8',
				'tagline'     => $p['accent'],
				'badge_bg'    => $p['accent'],
				'badge_text'  => $p['accent'],
				'dot_color'   => $p['accent'],
			),
			'fullwidth-focus'  => array(
				'section_bg'  => $p['primary'],
				'card_bg'     => $p['dark'],
				'heading'     => '#ffffff',
				'text'        => '#94a3b8',
				'desc'        => '#94a3b8',
				'tagline'     => $p['secondary'],
				'badge_bg'    => $p['secondary'],
				'badge_text'  => '#ffffff',
				'border'      => 'rgba(255,255,255,0.06)',
				'dot_color'   => $p['secondary'],
			),
			'bordered-minimal' => array(
				'section_bg'  => $p['light'],
				'card_bg'     => 'transparent',
				'heading'     => $p['primary'],
				'text'        => '#495057',
				'desc'        => '#6c757d',
				'tagline'     => $p['accent'],
				'badge_bg'    => 'transparent',
				'badge_text'  => $p['accent'],
				'accent_bar'  => $p['secondary'],
				'dot_color'   => $p['primary'],
			),
			'neon-dark'        => array(
				'section_bg'  => '#080818',
				'card_bg'     => 'transparent',
				'heading'     => '#ffffff',
				'text'        => 'rgba(255,255,255,0.55)',
				'desc'        => 'rgba(255,255,255,0.45)',
				'tagline'     => $p['secondary'],
				'badge_bg'    => $p['secondary'],
				'badge_text'  => '#ffffff',
				'neon_border' => $p['secondary'],
				'dot_color'   => $p['secondary'],
			),
		);

		return $presets[ $preset ] ?? $presets['clean-cards'];
	}

	private function get_preset_defaults( $preset ) {
		$map = array(
			'clean-cards'      => array(
				'tagline'     => 'Featured Content',
				'headline'    => 'Explore Our Latest',
				'description' => 'Handpicked stories, guides, and case studies curated just for you.',
				'slides_view' => 3,
				'card_style'  => 'standard',
				'aspect'      => '16/10',
				'show_btn'    => true,
				'btn_style'   => 'ghost-accent',
				'btn_label'   => 'Read More',
				'slides'      => array(
					array( 'title' => 'Startup Branding', 'category' => 'Case Study', 'description' => 'How a 5-person studio built a global brand identity from scratch.' ),
					array( 'title' => 'UX Research Guide', 'category' => 'Design', 'description' => 'A step-by-step framework for user interviews that actually work.' ),
					array( 'title' => 'Remote Culture', 'category' => 'Leadership', 'description' => 'How to build trust and performance in a fully distributed team.' ),
					array( 'title' => 'Growth Marketing', 'category' => 'Strategy', 'description' => 'Data-driven tactics that grew organic traffic 3x in 6 months.' ),
					array( 'title' => 'Design Systems', 'category' => 'Engineering', 'description' => 'A component library that scales with your product roadmap.' ),
				),
			),
			'cinema-overlay'   => array(
				'tagline'     => 'Showcase',
				'headline'    => 'Visual Stories',
				'description' => '',
				'slides_view' => 2,
				'card_style'  => 'overlay',
				'aspect'      => '9/14',
				'show_btn'    => true,
				'btn_style'   => 'outline-white',
				'btn_label'   => 'Watch Now',
				'slides'      => array(
					array( 'title' => 'Urban Architecture', 'category' => 'Photography', 'description' => 'Towers of steel and glass that define a generation.' ),
					array( 'title' => 'Ocean Deep', 'category' => 'Nature', 'description' => 'Where light barely reaches and life finds a way.' ),
					array( 'title' => 'Desert at Dawn', 'category' => 'Landscape', 'description' => 'Silence before the heat — the last cool hour.' ),
					array( 'title' => 'Night Market', 'category' => 'Culture', 'description' => 'A thousand flavours, a hundred languages, one street.' ),
				),
			),
			'soft-rounded'     => array(
				'tagline'     => 'Discover',
				'headline'    => 'Stories Worth Reading',
				'description' => 'Thoughtful content for curious minds — explore at your pace.',
				'slides_view' => 3,
				'card_style'  => 'pill',
				'aspect'      => '4/3',
				'show_btn'    => true,
				'btn_style'   => 'primary',
				'btn_label'   => 'Explore',
				'slides'      => array(
					array( 'title' => 'Mindful Productivity', 'category' => 'Wellness', 'description' => 'Small habits that compound into extraordinary results over time.' ),
					array( 'title' => 'Creative Block', 'category' => 'Creativity', 'description' => 'Why your best ideas hide just beyond the edge of discomfort.' ),
					array( 'title' => 'Future of Work', 'category' => 'Career', 'description' => 'What hybrid really means for the next decade of professional life.' ),
					array( 'title' => 'Digital Detox', 'category' => 'Lifestyle', 'description' => 'What happened when I left my phone at home for a full week.' ),
					array( 'title' => 'Second Brain', 'category' => 'Productivity', 'description' => 'Building a personal knowledge system that actually sticks.' ),
				),
			),
			'fullwidth-focus'  => array(
				'tagline'     => 'In Depth',
				'headline'    => 'Long Reads & Investigations',
				'description' => 'Take your time with the stories that matter most.',
				'slides_view' => 1,
				'card_style'  => 'split',
				'aspect'      => '16/9',
				'show_btn'    => true,
				'btn_style'   => 'primary',
				'btn_label'   => 'Read the Full Story',
				'slides'      => array(
					array( 'title' => 'The Algorithm That Changed Advertising', 'category' => 'Technology', 'description' => 'A deep dive into how machine learning reshaped a trillion-dollar industry almost overnight.' ),
					array( 'title' => 'Inside the Fastest-Growing City', 'category' => 'Cities & Culture', 'description' => 'The megacities expanding so fast that infrastructure cannot keep up.' ),
					array( 'title' => 'The Battery Race', 'category' => 'Climate & Energy', 'description' => 'Which battery technology will actually power the next decade of electric vehicles.' ),
				),
			),
			'bordered-minimal' => array(
				'tagline'     => 'Services',
				'headline'    => 'What We Do Best',
				'description' => 'Simple ideas executed with exceptional craft and attention to detail.',
				'slides_view' => 4,
				'card_style'  => 'caption',
				'aspect'      => '1/1',
				'show_btn'    => true,
				'btn_style'   => 'ghost-dark',
				'btn_label'   => 'Learn More',
				'slides'      => array(
					array( 'title' => 'Brand Strategy', 'category' => 'Consulting', 'description' => 'We define the story behind your business — then build everything around it.' ),
					array( 'title' => 'Web Design', 'category' => 'Digital', 'description' => 'Pixel-perfect interfaces that balance beauty with measurable performance.' ),
					array( 'title' => 'Motion & Video', 'category' => 'Creative', 'description' => 'Visual storytelling that moves audiences and communicates faster than words.' ),
					array( 'title' => 'Growth Marketing', 'category' => 'Marketing', 'description' => 'Full-funnel campaigns grounded in data, tested continuously to scale.' ),
					array( 'title' => 'Product Strategy', 'category' => 'Strategy', 'description' => 'From napkin sketch to validated roadmap — we help you build the right thing.' ),
				),
			),
			'neon-dark'        => array(
				'tagline'     => 'Portfolio',
				'headline'    => 'Award-Winning Work',
				'description' => 'Projects that push the boundary between design and technology.',
				'slides_view' => 3,
				'card_style'  => 'neon',
				'aspect'      => '4/3',
				'show_btn'    => false,
				'btn_style'   => 'ghost-white',
				'btn_label'   => 'View Project',
				'slides'      => array(
					array( 'title' => 'Kinetic Typography', 'category' => '2024 — Motion', 'description' => 'An experimental film title sequence built entirely in CSS.' ),
					array( 'title' => 'Generative Patterns', 'category' => '2024 — Digital Art', 'description' => 'Algorithmic art generated from live heartbeat data.' ),
					array( 'title' => 'AR Product Viewer', 'category' => '2023 — XR', 'description' => 'A WebXR experience letting users try furniture in their room.' ),
					array( 'title' => 'Brand Film', 'category' => '2023 — Video', 'description' => 'A 90-second launch film that generated 2M views in 72 hours.' ),
					array( 'title' => 'Dashboard Redesign', 'category' => '2023 — Product', 'description' => 'Turning 40 legacy screens into one coherent design system.' ),
				),
			),
		);

		return $map[ $preset ] ?? $map['clean-cards'];
	}

	private function get_button_inline_style( $style ) {
		$ghost = 'display:inline-flex;align-items:center;gap:0.4em;font-size:0.875rem;font-weight:600;line-height:1.5;text-decoration:none;cursor:pointer;transition:all 0.3s ease;padding:0;border:none;background:transparent;';
		$btn   = 'display:inline-flex;align-items:center;justify-content:center;padding:0.75em 1.75em;font-size:1rem;font-weight:600;line-height:1.5;border-radius:6px;text-decoration:none;border:2px solid transparent;cursor:pointer;transition:all 0.3s ease;';

		$styles = array(
			'ghost-accent'  => $ghost . 'color:' . nexus_palette()['secondary'] . ';',
			'ghost-white'   => $ghost . 'color:#ffffff;',
			'ghost-dark'    => $ghost . 'color:' . nexus_palette()['primary'] . ';',
			'outline'       => $btn . 'background-color:transparent;color:' . nexus_palette()['secondary'] . ';border-color:' . nexus_palette()['secondary'] . ';',
			'outline-white' => $btn . 'background-color:transparent;color:#fff;border-color:rgba(255,255,255,0.5);',
			'primary'       => $btn . 'background-color:' . nexus_palette()['secondary'] . ';color:#fff;border-color:' . nexus_palette()['secondary'] . ';',
			'secondary'     => $btn . 'background-color:' . nexus_palette()['dark'] . ';color:#fff;border-color:' . nexus_palette()['dark'] . ';',
		);

		return $styles[ $style ] ?? $styles['ghost-accent'];
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
				'default'     => 'clean-cards',
				'options'     => array(
					'clean-cards'      => esc_html__( '1 — Clean Cards', 'nexus' ),
					'cinema-overlay'   => esc_html__( '2 — Cinema Overlay', 'nexus' ),
					'soft-rounded'     => esc_html__( '3 — Soft Rounded', 'nexus' ),
					'fullwidth-focus'  => esc_html__( '4 — Fullwidth Focus', 'nexus' ),
					'bordered-minimal' => esc_html__( '5 — Bordered Minimal', 'nexus' ),
					'neon-dark'        => esc_html__( '6 — Neon Dark', 'nexus' ),
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

		// ---- Slides (Repeater) ----
		$this->start_controls_section(
			'section_slides',
			array( 'label' => esc_html__( 'Slides', 'nexus' ) )
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control( 'image', array(
			'label'   => esc_html__( 'Image', 'nexus' ),
			'type'    => \Elementor\Controls_Manager::MEDIA,
			'default' => array(
				'url' => \Elementor\Utils::get_placeholder_image_src(),
			),
		) );

		$repeater->add_control( 'title', array(
			'label'   => esc_html__( 'Title', 'nexus' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => esc_html__( 'Slide Title', 'nexus' ),
			'dynamic' => array( 'active' => true ),
		) );

		$repeater->add_control( 'category', array(
			'label'   => esc_html__( 'Category / Label', 'nexus' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => esc_html__( 'Category', 'nexus' ),
			'dynamic' => array( 'active' => true ),
		) );

		$repeater->add_control( 'slide_description', array(
			'label'   => esc_html__( 'Description', 'nexus' ),
			'type'    => \Elementor\Controls_Manager::TEXTAREA,
			'rows'    => 2,
			'default' => '',
			'dynamic' => array( 'active' => true ),
		) );

		$repeater->add_control( 'link', array(
			'label'   => esc_html__( 'Link', 'nexus' ),
			'type'    => \Elementor\Controls_Manager::URL,
			'dynamic' => array( 'active' => true ),
		) );

		$this->add_control(
			'slides',
			array(
				'label'       => esc_html__( 'Content Slides', 'nexus' ),
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

		// ---- Section Button ----
		$this->start_controls_section(
			'section_cta',
			array( 'label' => esc_html__( 'Section Button', 'nexus' ) )
		);

		$this->add_control( 'section_btn_text', array(
			'label'       => esc_html__( 'Button Text', 'nexus' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => '',
			'placeholder' => esc_html__( 'e.g. View All', 'nexus' ),
		) );

		$this->add_control( 'section_btn_url', array(
			'label'       => esc_html__( 'Button URL', 'nexus' ),
			'type'        => \Elementor\Controls_Manager::URL,
			'placeholder' => 'https://example.com',
		) );

		$this->add_control( 'section_btn_style', array(
			'label'   => esc_html__( 'Button Style', 'nexus' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'primary',
			'options' => array(
				'primary'       => esc_html__( 'Primary', 'nexus' ),
				'secondary'     => esc_html__( 'Secondary', 'nexus' ),
				'outline'       => esc_html__( 'Outline', 'nexus' ),
				'outline-white' => esc_html__( 'Outline White', 'nexus' ),
			),
		) );

		$this->end_controls_section();
	}

	// -----------------------------------------------------------------
	// Render
	// -----------------------------------------------------------------

	protected function render() {
		$settings  = $this->get_settings_for_display();
		$preset    = $settings['style_preset'] ?? 'clean-cards';
		$colors    = $this->get_preset_colors( $preset );
		$defaults  = $this->get_preset_defaults( $preset );
		$widget_id = 'nexus-cc-' . $this->get_id();

		// Merge defaults.
		$tagline     = ( '' !== $settings['tagline'] ) ? $settings['tagline'] : ( $defaults['tagline'] ?? '' );
		$headline    = ( '' !== $settings['headline'] ) ? $settings['headline'] : ( $defaults['headline'] ?? '' );
		$description = ( '' !== $settings['description'] ) ? $settings['description'] : ( $defaults['description'] ?? '' );
		$card_style  = $defaults['card_style'];
		$aspect      = $defaults['aspect'];
		$spv         = absint( $defaults['slides_view'] );
		$show_btn    = $defaults['show_btn'];
		$btn_style   = $defaults['btn_style'];
		$btn_label   = $defaults['btn_label'];
		$dots        = 'yes' === $settings['show_dots'];
		$arrows      = 'yes' === $settings['show_arrows'];

		// Header alignment: centered for neon-dark and soft-rounded.
		$header_align = in_array( $preset, array( 'neon-dark', 'soft-rounded', 'cinema-overlay' ), true ) ? 'center' : 'left';

		// Slides: use repeater or fallback to preset defaults.
		$slides = $settings['slides'] ?? array();
		if ( empty( $slides ) ) {
			$placeholder = \Elementor\Utils::get_placeholder_image_src();
			foreach ( $defaults['slides'] as $ds ) {
				$slides[] = array(
					'image'             => array( 'url' => $placeholder ),
					'title'             => $ds['title'],
					'category'          => $ds['category'],
					'slide_description' => $ds['description'],
					'link'              => array( 'url' => '#' ),
				);
			}
		}

		$total_slides = count( $slides );

		// Section button.
		$sec_btn_text = $settings['section_btn_text'] ?? '';
		$sec_btn_url  = $settings['section_btn_url']['url'] ?? '';
		$sec_btn_tgt  = ! empty( $settings['section_btn_url']['is_external'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';
		?>

		<section
			class="nexus-cc nexus-cc--<?php echo esc_attr( $preset ); ?>"
			style="background-color:<?php echo esc_attr( $colors['section_bg'] ); ?>;padding:5rem 0;overflow:hidden;"
			id="<?php echo esc_attr( $widget_id ); ?>"
		>
			<div class="nexus-container">

				<?php if ( $tagline || $headline || $description ) : ?>
				<div class="nexus-cc__header" style="margin-bottom:2.5rem;max-width:680px;text-align:<?php echo esc_attr( $header_align ); ?>;<?php echo 'center' === $header_align ? 'margin-inline:auto;' : ''; ?>">
					<?php if ( $tagline ) : ?>
						<span class="nexus-cc__tagline" style="display:inline-block;font-size:0.875rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:<?php echo esc_attr( $colors['tagline'] ); ?>;margin-bottom:0.75rem;">
							<?php echo esc_html( $tagline ); ?>
						</span>
					<?php endif; ?>
					<?php if ( $headline ) : ?>
						<h2 class="nexus-cc__title" style="font-size:clamp(1.5rem,3vw,2.25rem);font-weight:700;color:<?php echo esc_attr( $colors['heading'] ); ?>;margin:0 0 0.75rem;">
							<?php echo wp_kses_post( $headline ); ?>
						</h2>
					<?php endif; ?>
					<?php if ( $description ) : ?>
						<p class="nexus-cc__desc" style="font-size:1.0625rem;line-height:1.7;color:<?php echo esc_attr( $colors['text'] ); ?>;margin:0;">
							<?php echo wp_kses_post( $description ); ?>
						</p>
					<?php endif; ?>
				</div>
				<?php endif; ?>

			</div>

			<div class="nexus-container">
				<div class="nexus-cc__slider swiper" id="<?php echo esc_attr( $widget_id ); ?>-swiper" style="overflow:hidden;position:relative;">
					<div class="swiper-wrapper">
						<?php
						foreach ( $slides as $idx => $slide ) :
							$img_url  = ! empty( $slide['image']['url'] ) ? $slide['image']['url'] : '';
							$title    = $slide['title'] ?? '';
							$category = $slide['category'] ?? '';
							$desc     = $slide['slide_description'] ?? '';
							$link_url = ! empty( $slide['link']['url'] ) ? esc_url( $slide['link']['url'] ) : '';
							$target   = ! empty( $slide['link']['is_external'] ) ? 'target="_blank" rel="noopener noreferrer"' : '';
							?>
							<div class="swiper-slide">
								<?php
								switch ( $card_style ) {
									case 'standard':
										$this->render_card_standard( $colors, $aspect, $img_url, $title, $category, $desc, $link_url, $target, $show_btn, $btn_style, $btn_label );
										break;
									case 'overlay':
										$this->render_card_overlay( $colors, $aspect, $img_url, $title, $category, $desc, $link_url, $target, $show_btn, $btn_style, $btn_label );
										break;
									case 'pill':
										$this->render_card_pill( $colors, $aspect, $img_url, $title, $category, $desc, $link_url, $target, $show_btn, $btn_style, $btn_label );
										break;
									case 'split':
										$this->render_card_split( $colors, $aspect, $img_url, $title, $category, $desc, $link_url, $target, $show_btn, $btn_style, $btn_label );
										break;
									case 'caption':
										$this->render_card_caption( $colors, $aspect, $img_url, $title, $category, $desc, $link_url, $target, $show_btn, $btn_style, $btn_label );
										break;
									case 'neon':
										$this->render_card_neon( $colors, $aspect, $img_url, $title, $category, $desc, $link_url, $target );
										break;
								}
								?>
							</div>
						<?php endforeach; ?>
					</div>

					<?php if ( $dots ) : ?>
						<div class="swiper-pagination nexus-cc__dots"></div>
					<?php endif; ?>

					<?php if ( $arrows ) : ?>
						<button class="swiper-button-prev nexus-cc__arrow nexus-cc__arrow--prev" aria-label="<?php esc_attr_e( 'Previous', 'nexus' ); ?>"></button>
						<button class="swiper-button-next nexus-cc__arrow nexus-cc__arrow--next" aria-label="<?php esc_attr_e( 'Next', 'nexus' ); ?>"></button>
					<?php endif; ?>
				</div>
			</div>

			<?php if ( $sec_btn_text && $sec_btn_url ) : ?>
			<div class="nexus-container">
				<div class="nexus-cc__footer" style="text-align:center;margin-top:2.5rem;">
					<a href="<?php echo esc_url( $sec_btn_url ); ?>"<?php echo $sec_btn_tgt; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> class="nexus-btn nexus-btn--<?php echo esc_attr( $settings['section_btn_style'] ?? 'primary' ); ?>" style="<?php echo esc_attr( $this->get_button_inline_style( $settings['section_btn_style'] ?? 'primary' ) ); ?>">
						<?php echo esc_html( $sec_btn_text ); ?>
					</a>
				</div>
			</div>
			<?php endif; ?>

		</section>

		<?php $this->render_swiper_script( $widget_id, $preset, $spv, $settings, $dots, $arrows, $total_slides ); ?>

		<?php
	}

	// -----------------------------------------------------------------
	// Swiper init script
	// -----------------------------------------------------------------

	private function render_swiper_script( $widget_id, $preset, $spv, $settings, $dots, $arrows, $total_slides ) {
		// Per-preset breakpoints.
		$space = 1 === $spv ? 0 : 28;
		if ( 'fullwidth-focus' === $preset ) {
			$bp = '0:{slidesPerView:1,spaceBetween:0},640:{slidesPerView:1,spaceBetween:0},992:{slidesPerView:1,spaceBetween:0}';
		} elseif ( 'cinema-overlay' === $preset ) {
			$bp = '0:{slidesPerView:1,spaceBetween:16},640:{slidesPerView:1.5,spaceBetween:20},992:{slidesPerView:2,spaceBetween:28}';
		} elseif ( 'neon-dark' === $preset ) {
			$bp = '0:{slidesPerView:1,spaceBetween:16},640:{slidesPerView:2,spaceBetween:20},992:{slidesPerView:3.15,spaceBetween:24}';
		} elseif ( 'bordered-minimal' === $preset ) {
			$bp = '0:{slidesPerView:2,spaceBetween:16},640:{slidesPerView:3,spaceBetween:20},992:{slidesPerView:' . $spv . ',spaceBetween:24}';
		} else {
			$bp = '0:{slidesPerView:1,spaceBetween:16},640:{slidesPerView:Math.min(2,' . $spv . '),spaceBetween:20},992:{slidesPerView:' . $spv . ',spaceBetween:' . $space . '}';
		}

		$autoplay_opt = 'yes' === $settings['autoplay']
			? '{delay:' . absint( $settings['autoplay_speed'] ) . ',disableOnInteraction:false}'
			: 'false';
		?>
		<script>
		(function(){
			var swiperId='<?php echo esc_js( $widget_id ); ?>-swiper';
			function initCC(){
				var el=document.getElementById(swiperId);
				if(!el)return;
				if(!window.Swiper){setTimeout(initCC,100);return;}
				if(el.swiper)el.swiper.destroy(true,true);
				var totalSlides=el.querySelectorAll('.swiper-slide').length;
				var spv=<?php echo esc_js( $spv ); ?>;
				new Swiper(el,{
					slidesPerView:spv,
					spaceBetween:<?php echo $space; ?>,
					loop:totalSlides>spv,
					autoplay:<?php echo $autoplay_opt; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>,
					pagination:<?php echo $dots ? '{el:el.querySelector(\'.swiper-pagination\'),clickable:true}' : 'false'; ?>,
					navigation:<?php echo $arrows ? '{nextEl:el.querySelector(\'.swiper-button-next\'),prevEl:el.querySelector(\'.swiper-button-prev\')}' : 'false'; ?>,
					breakpoints:{<?php echo $bp; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>}
				});
			}
			if(document.readyState==='loading'){document.addEventListener('DOMContentLoaded',initCC);}else{initCC();}
			if(window.elementorFrontend){jQuery(window).on('elementor/frontend/init',function(){elementorFrontend.hooks.addAction('frontend/element_ready/nexus-content-carousel.default',initCC);});}
		})();
		</script>
		<?php
	}

	// -----------------------------------------------------------------
	// Arrow SVG helper
	// -----------------------------------------------------------------

	private function arrow_svg() {
		return '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>';
	}

	// -----------------------------------------------------------------
	// Card renderers
	// -----------------------------------------------------------------

	/**
	 * Style 1 — Clean Cards: image top, card body with badge.
	 */
	private function render_card_standard( $colors, $aspect, $img_url, $title, $category, $desc, $link_url, $target, $show_btn, $btn_style, $btn_label ) {
		?>
		<div class="nexus-cc__card nexus-cc__card--standard" style="overflow:hidden;border-radius:12px;background:<?php echo esc_attr( $colors['card_bg'] ); ?>;box-shadow:0 2px 16px rgba(0,0,0,0.06);transition:transform 0.3s ease,box-shadow 0.3s ease;">
			<?php if ( $img_url ) : ?>
				<div class="nexus-cc__card-thumb" style="overflow:hidden;aspect-ratio:<?php echo esc_attr( $aspect ); ?>;position:relative;">
					<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $title ); ?>" style="width:100%;height:100%;object-fit:cover;display:block;transition:transform 0.4s ease;" loading="lazy" />
					<?php if ( $category ) : ?>
						<span style="position:absolute;top:0.75rem;left:0.75rem;display:inline-block;font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;padding:0.25em 0.75em;border-radius:50rem;background:rgba(255,255,255,0.92);color:<?php echo esc_attr( $colors['badge_text'] ); ?>;">
							<?php echo esc_html( $category ); ?>
						</span>
					<?php endif; ?>
				</div>
			<?php endif; ?>
			<div style="padding:1.25rem 1.5rem 1.5rem;">
				<?php if ( $title ) : ?>
					<h3 class="nexus-cc__card-title" style="font-size:1.0625rem;font-weight:700;line-height:1.35;margin:0 0 0.375rem;color:<?php echo esc_attr( $colors['heading'] ); ?>;">
						<?php if ( $link_url ) : ?>
							<a href="<?php echo esc_url( $link_url ); ?>" style="color:inherit;text-decoration:none;" <?php echo $target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $title ); ?></a>
						<?php else : ?>
							<?php echo esc_html( $title ); ?>
						<?php endif; ?>
					</h3>
				<?php endif; ?>
				<?php if ( $desc ) : ?>
					<p class="nexus-cc__card-desc" style="font-size:0.875rem;line-height:1.6;color:<?php echo esc_attr( $colors['desc'] ?? $colors['text'] ); ?>;margin:0 0 0.75rem;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
						<?php echo esc_html( $desc ); ?>
					</p>
				<?php endif; ?>
				<?php if ( $show_btn && $link_url ) : ?>
					<a href="<?php echo esc_url( $link_url ); ?>" style="<?php echo esc_attr( $this->get_button_inline_style( $btn_style ) ); ?>" <?php echo $target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
						<?php echo esc_html( $btn_label ); ?> <?php echo $this->arrow_svg(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</a>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}

	/**
	 * Style 2 — Cinema Overlay: full-bleed image, always-visible bottom text with gradient.
	 */
	private function render_card_overlay( $colors, $aspect, $img_url, $title, $category, $desc, $link_url, $target, $show_btn, $btn_style, $btn_label ) {
		$overlay = $colors['overlay'] ?? 'linear-gradient(to top,rgba(0,0,0,0.85) 0%,transparent 60%)';
		?>
		<div class="nexus-cc__card nexus-cc__card--overlay" style="position:relative;overflow:hidden;border-radius:0;aspect-ratio:<?php echo esc_attr( $aspect ); ?>;transition:transform 0.3s ease;">
			<?php if ( $img_url ) : ?>
				<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $title ); ?>" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;transition:transform 0.5s ease;" loading="lazy" />
			<?php endif; ?>
			<div style="position:absolute;inset:0;background:<?php echo esc_attr( $overlay ); ?>;"></div>
			<div style="position:absolute;bottom:0;left:0;right:0;padding:2rem;">
				<?php if ( $category ) : ?>
					<span style="display:inline-block;font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;padding:0.25em 0.75em;border-radius:4px;background:<?php echo esc_attr( $colors['badge_bg'] ); ?>;color:<?php echo esc_attr( $colors['badge_text'] ); ?>;margin-bottom:0.5rem;">
						<?php echo esc_html( $category ); ?>
					</span>
				<?php endif; ?>
				<?php if ( $title ) : ?>
					<h3 style="font-size:1.375rem;font-weight:700;line-height:1.25;margin:0 0 0.375rem;color:<?php echo esc_attr( $colors['heading'] ); ?>;">
						<?php echo esc_html( $title ); ?>
					</h3>
				<?php endif; ?>
				<?php if ( $desc ) : ?>
					<p style="font-size:0.875rem;line-height:1.5;color:<?php echo esc_attr( $colors['text'] ); ?>;margin:0 0 0.75rem;">
						<?php echo esc_html( $desc ); ?>
					</p>
				<?php endif; ?>
				<?php if ( $show_btn && $link_url ) : ?>
					<a href="<?php echo esc_url( $link_url ); ?>" style="<?php echo esc_attr( $this->get_button_inline_style( $btn_style ) ); ?>" <?php echo $target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
						<?php echo esc_html( $btn_label ); ?>
					</a>
				<?php endif; ?>
			</div>
			<?php if ( $link_url ) : ?>
				<a href="<?php echo esc_url( $link_url ); ?>" style="position:absolute;inset:0;z-index:2;" <?php echo $target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> aria-label="<?php echo esc_attr( $title ); ?>"></a>
			<?php endif; ?>
		</div>
		<?php
	}

	/**
	 * Style 3 — Soft Rounded: image top, centered body, pill button.
	 */
	private function render_card_pill( $colors, $aspect, $img_url, $title, $category, $desc, $link_url, $target, $show_btn, $btn_style, $btn_label ) {
		?>
		<div class="nexus-cc__card nexus-cc__card--pill" style="overflow:hidden;border-radius:24px;background:<?php echo esc_attr( $colors['card_bg'] ); ?>;box-shadow:0 4px 24px rgba(15,52,96,0.07);transition:transform 0.3s ease,box-shadow 0.3s ease;">
			<?php if ( $img_url ) : ?>
				<div class="nexus-cc__card-thumb" style="overflow:hidden;aspect-ratio:<?php echo esc_attr( $aspect ); ?>;">
					<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $title ); ?>" style="width:100%;height:100%;object-fit:cover;display:block;transition:transform 0.4s ease;" loading="lazy" />
				</div>
			<?php endif; ?>
			<div style="padding:1.5rem 1.75rem 2rem;text-align:center;">
				<?php if ( $category ) : ?>
					<span style="display:inline-block;font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;padding:0.25em 0.75em;border-radius:50rem;background:<?php echo esc_attr( $colors['badge_bg'] ); ?>18;color:<?php echo esc_attr( $colors['badge_text'] ); ?>;margin-bottom:0.5rem;">
						<?php echo esc_html( $category ); ?>
					</span>
				<?php endif; ?>
				<?php if ( $title ) : ?>
					<h3 class="nexus-cc__card-title" style="font-size:1.125rem;font-weight:700;line-height:1.3;margin:0 0 0.375rem;color:<?php echo esc_attr( $colors['heading'] ); ?>;">
						<?php echo esc_html( $title ); ?>
					</h3>
				<?php endif; ?>
				<?php if ( $desc ) : ?>
					<p class="nexus-cc__card-desc" style="font-size:0.875rem;line-height:1.6;color:<?php echo esc_attr( $colors['desc'] ?? $colors['text'] ); ?>;margin:0 0 1rem;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
						<?php echo esc_html( $desc ); ?>
					</p>
				<?php endif; ?>
				<?php if ( $show_btn && $link_url ) : ?>
					<a href="<?php echo esc_url( $link_url ); ?>" style="border-radius:50rem;<?php echo esc_attr( $this->get_button_inline_style( $btn_style ) ); ?>" <?php echo $target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
						<?php echo esc_html( $btn_label ); ?>
					</a>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}

	/**
	 * Style 4 — Fullwidth Focus: image left 50%, text right 50%.
	 */
	private function render_card_split( $colors, $aspect, $img_url, $title, $category, $desc, $link_url, $target, $show_btn, $btn_style, $btn_label ) {
		$border = $colors['border'] ?? 'rgba(255,255,255,0.06)';
		?>
		<div class="nexus-cc__card nexus-cc__card--split" style="display:flex;align-items:stretch;border-radius:16px;overflow:hidden;border:1px solid <?php echo esc_attr( $border ); ?>;transition:box-shadow 0.3s ease;">
			<?php if ( $img_url ) : ?>
				<div class="nexus-cc__card-img-col" style="flex:0 0 50%;position:relative;min-height:320px;">
					<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $title ); ?>" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;" loading="lazy" />
				</div>
			<?php endif; ?>
			<div class="nexus-cc__card-text-col" style="flex:1;padding:3rem 3.5rem;display:flex;flex-direction:column;justify-content:center;background:<?php echo esc_attr( $colors['card_bg'] ); ?>;">
				<?php if ( $category ) : ?>
					<span style="display:inline-block;font-size:0.75rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;padding:0.25em 0.75em;border-radius:4px;background:<?php echo esc_attr( $colors['badge_bg'] ); ?>;color:<?php echo esc_attr( $colors['badge_text'] ); ?>;margin-bottom:0.75rem;width:fit-content;">
						<?php echo esc_html( $category ); ?>
					</span>
				<?php endif; ?>
				<?php if ( $title ) : ?>
					<h3 class="nexus-cc__card-title" style="font-size:clamp(1.5rem,3vw,2.25rem);font-weight:700;line-height:1.2;margin:0 0 1rem;color:<?php echo esc_attr( $colors['heading'] ); ?>;">
						<?php echo esc_html( $title ); ?>
					</h3>
				<?php endif; ?>
				<?php if ( $desc ) : ?>
					<p style="font-size:1rem;line-height:1.75;color:<?php echo esc_attr( $colors['desc'] ?? $colors['text'] ); ?>;margin:0 0 1.5rem;">
						<?php echo esc_html( $desc ); ?>
					</p>
				<?php endif; ?>
				<?php if ( $show_btn && $link_url ) : ?>
					<div>
						<a href="<?php echo esc_url( $link_url ); ?>" style="<?php echo esc_attr( $this->get_button_inline_style( $btn_style ) ); ?>" <?php echo $target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
							<?php echo esc_html( $btn_label ); ?> <?php echo $this->arrow_svg(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</a>
					</div>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}

	/**
	 * Style 5 — Bordered Minimal: bare image + text below, hover accent top-border.
	 */
	private function render_card_caption( $colors, $aspect, $img_url, $title, $category, $desc, $link_url, $target, $show_btn, $btn_style, $btn_label ) {
		$accent_bar = $colors['accent_bar'] ?? nexus_palette()['secondary'];
		?>
		<div class="nexus-cc__card nexus-cc__card--caption" style="transition:transform 0.3s ease;">
			<?php if ( $img_url ) : ?>
				<div class="nexus-cc__card-thumb" style="overflow:hidden;aspect-ratio:<?php echo esc_attr( $aspect ); ?>;margin-bottom:1rem;border-top:3px solid transparent;transition:border-color 0.25s ease;">
					<?php if ( $link_url ) : ?>
						<a href="<?php echo esc_url( $link_url ); ?>" <?php echo $target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> style="display:block;height:100%;">
					<?php endif; ?>
						<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $title ); ?>" style="width:100%;height:100%;object-fit:cover;display:block;transition:transform 0.4s ease;" loading="lazy" />
					<?php if ( $link_url ) : ?>
						</a>
					<?php endif; ?>
				</div>
			<?php endif; ?>
			<?php if ( $category ) : ?>
				<span style="display:inline-block;font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.08em;color:<?php echo esc_attr( $colors['badge_text'] ); ?>;margin-bottom:0.25rem;">
					<?php echo esc_html( $category ); ?>
				</span>
			<?php endif; ?>
			<?php if ( $title ) : ?>
				<h3 class="nexus-cc__card-title" style="font-size:1rem;font-weight:700;line-height:1.35;margin:0 0 0.375rem;color:<?php echo esc_attr( $colors['heading'] ); ?>;">
					<?php if ( $link_url ) : ?>
						<a href="<?php echo esc_url( $link_url ); ?>" style="color:inherit;text-decoration:none;" <?php echo $target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $title ); ?></a>
					<?php else : ?>
						<?php echo esc_html( $title ); ?>
					<?php endif; ?>
				</h3>
			<?php endif; ?>
			<?php if ( $desc ) : ?>
				<p style="font-size:0.8125rem;line-height:1.65;color:<?php echo esc_attr( $colors['desc'] ?? $colors['text'] ); ?>;margin:0 0 0.5rem;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
					<?php echo esc_html( $desc ); ?>
				</p>
			<?php endif; ?>
			<?php if ( $show_btn && $link_url ) : ?>
				<a href="<?php echo esc_url( $link_url ); ?>" style="<?php echo esc_attr( $this->get_button_inline_style( $btn_style ) ); ?>" <?php echo $target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
					<?php echo esc_html( $btn_label ); ?> <?php echo $this->arrow_svg(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</a>
			<?php endif; ?>
		</div>
		<?php
	}

	/**
	 * Style 6 — Neon Dark: full image, hover reveals gradient + text, neon glow border.
	 */
	private function render_card_neon( $colors, $aspect, $img_url, $title, $category, $desc, $link_url, $target ) {
		$neon = $colors['neon_border'] ?? nexus_palette()['secondary'];
		?>
		<div class="nexus-cc__card nexus-cc__card--neon" style="position:relative;overflow:hidden;border-radius:12px;aspect-ratio:<?php echo esc_attr( $aspect ); ?>;border:1px solid rgba(255,255,255,0.06);transition:border-color 0.35s ease,box-shadow 0.35s ease,transform 0.35s ease;">
			<?php if ( $img_url ) : ?>
				<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $title ); ?>" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;transition:transform 0.5s ease;" loading="lazy" />
			<?php endif; ?>
			<div class="nexus-cc__neon-overlay" style="position:absolute;inset:0;background:linear-gradient(135deg,<?php echo esc_attr( $neon ); ?>cc,<?php echo esc_attr( nexus_palette()['accent'] ); ?>dd);opacity:0;transition:opacity 0.35s ease;"></div>
			<div class="nexus-cc__neon-content" style="position:absolute;bottom:0;left:0;right:0;padding:1.5rem;opacity:0;transform:translateY(12px);transition:opacity 0.35s ease,transform 0.35s ease;">
				<?php if ( $category ) : ?>
					<span style="display:inline-block;font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:<?php echo esc_attr( $colors['badge_text'] ); ?>;margin-bottom:0.25rem;">
						<?php echo esc_html( $category ); ?>
					</span>
				<?php endif; ?>
				<?php if ( $title ) : ?>
					<h3 style="font-size:1.125rem;font-weight:700;line-height:1.3;margin:0 0 0.25rem;color:#fff;">
						<?php echo esc_html( $title ); ?>
					</h3>
				<?php endif; ?>
				<?php if ( $desc ) : ?>
					<p style="font-size:0.8125rem;line-height:1.5;color:rgba(255,255,255,0.8);margin:0;">
						<?php echo esc_html( $desc ); ?>
					</p>
				<?php endif; ?>
			</div>
			<?php if ( $link_url ) : ?>
				<a href="<?php echo esc_url( $link_url ); ?>" style="position:absolute;inset:0;z-index:2;" <?php echo $target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> aria-label="<?php echo esc_attr( $title ); ?>"></a>
			<?php endif; ?>
		</div>
		<?php
	}
}
