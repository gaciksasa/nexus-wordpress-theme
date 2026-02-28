<?php
/**
 * Nexus Theme - Elementor Image Cards Grid Widget
 *
 * Manual image card grid section with 6 style presets.
 * Uses a repeater for cards and section header with
 * staggered entrance animations.
 *
 * @package Nexus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Nexus_Widget_Image_Cards_Grid
 */
class Nexus_Widget_Image_Cards_Grid extends \Elementor\Widget_Base {

	public function get_name() {
		return 'nexus-image-cards-grid';
	}

	public function get_title() {
		return esc_html__( 'Image Cards Grid', 'nexus' );
	}

	public function get_icon() {
		return 'eicon-gallery-justified';
	}

	public function get_categories() {
		return array( 'nexus-elements' );
	}

	public function get_keywords() {
		return array( 'image', 'cards', 'grid', 'gallery', 'features', 'showcase', 'nexus' );
	}

	// -----------------------------------------------------------------
	// Preset data
	// -----------------------------------------------------------------

	/**
	 * Returns color map per preset.
	 *
	 * @param string $preset Preset key.
	 * @return array
	 */
	private function get_preset_colors( $preset ) {
		$presets = array(
			'clean-grid'       => array(
				'section_bg' => '#ffffff',
				'card_bg'    => '#ffffff',
				'heading'    => nexus_palette()['primary'],
				'text'       => '#495057',
				'tagline'    => nexus_palette()['secondary'],
				'overlay'    => 'rgba(0,0,0,0.45)',
			),
			'rounded-shadow'   => array(
				'section_bg' => nexus_palette()['light'],
				'card_bg'    => '#ffffff',
				'heading'    => nexus_palette()['primary'],
				'text'       => '#495057',
				'tagline'    => nexus_palette()['secondary'],
				'overlay'    => 'rgba(0,0,0,0.45)',
			),
			'dark-overlay'     => array(
				'section_bg' => nexus_palette()['primary'],
				'card_bg'    => 'transparent',
				'heading'    => '#ffffff',
				'text'       => '#cbd5e1',
				'tagline'    => nexus_palette()['secondary'],
				'overlay'    => 'rgba(0,0,0,0.6)',
			),
			'masonry-dark'     => array(
				'section_bg' => '#0f0f23',
				'card_bg'    => 'transparent',
				'heading'    => '#ffffff',
				'text'       => '#e2e8f0',
				'tagline'    => nexus_palette()['secondary'],
				'overlay'    => 'linear-gradient(to top,rgba(0,0,0,0.85) 0%,transparent 60%)',
			),
			'caption-below'    => array(
				'section_bg' => '#ffffff',
				'card_bg'    => '#ffffff',
				'heading'    => nexus_palette()['primary'],
				'text'       => '#495057',
				'tagline'    => nexus_palette()['secondary'],
				'overlay'    => 'rgba(0,0,0,0.35)',
			),
			'hover-zoom'       => array(
				'section_bg' => '#f1f5f9',
				'card_bg'    => '#ffffff',
				'heading'    => nexus_palette()['primary'],
				'text'       => '#495057',
				'tagline'    => nexus_palette()['secondary'],
				'overlay'    => 'rgba(233,69,96,0.85)',
			),
		);

		return $presets[ $preset ] ?? $presets['clean-grid'];
	}

	/**
	 * Returns content defaults per preset.
	 *
	 * @param string $preset Preset key.
	 * @return array
	 */
	private function get_preset_defaults( $preset ) {
		$placeholder = \Elementor\Utils::get_placeholder_image_src();

		$map = array(
			'clean-grid'     => array(
				'tagline'     => 'Our Work',
				'headline'    => 'Featured Projects',
				'description' => 'A showcase of our latest projects and creative endeavors.',
				'columns'     => 3,
				'btn_text'    => '',
				'btn_style'   => 'ghost-accent',
				'section_btn' => 'View All Projects',
				'section_style' => 'primary',
				'cards'       => array(
					array( 'title' => 'Brand Identity Redesign', 'subtitle' => 'Branding', 'link' => '#' ),
					array( 'title' => 'E-Commerce Platform', 'subtitle' => 'Web Development', 'link' => '#' ),
					array( 'title' => 'Mobile Banking App', 'subtitle' => 'UI/UX Design', 'link' => '#' ),
					array( 'title' => 'Marketing Dashboard', 'subtitle' => 'SaaS Product', 'link' => '#' ),
					array( 'title' => 'Restaurant Website', 'subtitle' => 'Web Design', 'link' => '#' ),
					array( 'title' => 'Fitness Tracker', 'subtitle' => 'Mobile App', 'link' => '#' ),
				),
			),
			'rounded-shadow' => array(
				'tagline'     => 'Services',
				'headline'    => 'What We Do Best',
				'description' => 'We specialize in creating digital solutions that make a real impact.',
				'columns'     => 3,
				'btn_text'    => 'Learn More',
				'btn_style'   => 'ghost-dark',
				'section_btn' => '',
				'section_style' => 'primary',
				'cards'       => array(
					array( 'title' => 'UI/UX Design', 'subtitle' => 'User-centered design that converts visitors into customers.', 'link' => '#' ),
					array( 'title' => 'Web Development', 'subtitle' => 'Fast, secure, and scalable web applications.', 'link' => '#' ),
					array( 'title' => 'Digital Marketing', 'subtitle' => 'Data-driven campaigns that maximize your ROI.', 'link' => '#' ),
				),
			),
			'dark-overlay'   => array(
				'tagline'     => 'Portfolio',
				'headline'    => 'Creative Showcase',
				'description' => '',
				'columns'     => 3,
				'btn_text'    => '',
				'btn_style'   => 'outline-white',
				'section_btn' => 'Explore Gallery',
				'section_style' => 'outline-white',
				'cards'       => array(
					array( 'title' => 'Abstract Series', 'subtitle' => 'Photography', 'link' => '#' ),
					array( 'title' => 'Urban Collection', 'subtitle' => 'Architecture', 'link' => '#' ),
					array( 'title' => 'Nature Portraits', 'subtitle' => 'Landscape', 'link' => '#' ),
					array( 'title' => 'Minimal Spaces', 'subtitle' => 'Interior Design', 'link' => '#' ),
					array( 'title' => 'Street Stories', 'subtitle' => 'Documentary', 'link' => '#' ),
					array( 'title' => 'Color Theory', 'subtitle' => 'Experimental', 'link' => '#' ),
				),
			),
			'masonry-dark'   => array(
				'tagline'     => 'Gallery',
				'headline'    => 'Visual Stories',
				'description' => 'Every image tells a story. Explore our visual narrative.',
				'columns'     => 3,
				'btn_text'    => '',
				'btn_style'   => 'ghost-white',
				'section_btn' => '',
				'section_style' => 'outline-white',
				'cards'       => array(
					array( 'title' => 'Mountain Peaks', 'subtitle' => 'Adventure', 'link' => '#' ),
					array( 'title' => 'Ocean Waves', 'subtitle' => 'Seascape', 'link' => '#' ),
					array( 'title' => 'Forest Paths', 'subtitle' => 'Nature', 'link' => '#' ),
					array( 'title' => 'City Lights', 'subtitle' => 'Urban', 'link' => '#' ),
					array( 'title' => 'Desert Dunes', 'subtitle' => 'Landscape', 'link' => '#' ),
					array( 'title' => 'Northern Lights', 'subtitle' => 'Astronomy', 'link' => '#' ),
				),
			),
			'caption-below'  => array(
				'tagline'     => 'Team',
				'headline'    => 'Meet Our Experts',
				'description' => 'The talented people behind every successful project we deliver.',
				'columns'     => 4,
				'btn_text'    => 'View Profile',
				'btn_style'   => 'ghost-accent',
				'section_btn' => 'See Full Team',
				'section_style' => 'outline',
				'cards'       => array(
					array( 'title' => 'Sarah Johnson', 'subtitle' => 'Creative Director', 'link' => '#' ),
					array( 'title' => 'Michael Chen', 'subtitle' => 'Lead Developer', 'link' => '#' ),
					array( 'title' => 'Emily Davis', 'subtitle' => 'UX Strategist', 'link' => '#' ),
					array( 'title' => 'James Wilson', 'subtitle' => 'Project Manager', 'link' => '#' ),
				),
			),
			'hover-zoom'     => array(
				'tagline'     => 'Highlights',
				'headline'    => 'Award-Winning Work',
				'description' => 'Recognized excellence in design and innovation across the industry.',
				'columns'     => 3,
				'btn_text'    => '',
				'btn_style'   => 'ghost-white',
				'section_btn' => 'View All Awards',
				'section_style' => 'secondary',
				'cards'       => array(
					array( 'title' => 'Awwwards Site of Day', 'subtitle' => '2024 Winner', 'link' => '#' ),
					array( 'title' => 'CSS Design Awards', 'subtitle' => 'Best Innovation', 'link' => '#' ),
					array( 'title' => 'Webby Awards', 'subtitle' => 'People\'s Choice', 'link' => '#' ),
				),
			),
		);

		return $map[ $preset ] ?? $map['clean-grid'];
	}

	/**
	 * Returns inline button styles.
	 *
	 * @param string $style Button style key.
	 * @return string Inline CSS.
	 */
	private function get_button_inline_style( $style ) {
		$ghost = 'display:inline-flex;align-items:center;gap:0.4em;font-size:0.875rem;font-weight:600;line-height:1.5;text-decoration:none;cursor:pointer;transition:all 0.3s ease;padding:0;border:none;background:transparent;';
		$btn   = 'display:inline-flex;align-items:center;justify-content:center;padding:0.75em 1.75em;font-size:1rem;font-weight:600;line-height:1.5;border-radius:6px;text-decoration:none;border:2px solid transparent;cursor:pointer;transition:all 0.3s ease;';

		$styles = array(
			'ghost-accent'  => $ghost . 'color:' . nexus_palette()['secondary'] . ';',
			'ghost-white'   => $ghost . 'color:#ffffff;',
			'ghost-dark'    => $ghost . 'color:' . nexus_palette()['primary'] . ';',
			'outline'       => $btn . 'background-color:transparent;color:' . nexus_palette()['secondary'] . ';border-color:' . nexus_palette()['secondary'] . ';',
			'outline-dark'  => $btn . 'background-color:transparent;color:' . nexus_palette()['primary'] . ';border-color:' . nexus_palette()['primary'] . ';',
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
				'default'     => 'clean-grid',
				'options'     => array(
					'clean-grid'       => esc_html__( '1 — Clean Grid', 'nexus' ),
					'rounded-shadow'   => esc_html__( '2 — Rounded Shadow', 'nexus' ),
					'dark-overlay'     => esc_html__( '3 — Dark Overlay', 'nexus' ),
					'masonry-dark'     => esc_html__( '4 — Masonry Dark', 'nexus' ),
					'caption-below'    => esc_html__( '5 — Caption Below', 'nexus' ),
					'hover-zoom'       => esc_html__( '6 — Hover Zoom', 'nexus' ),
				),
				'render_type' => 'template',
			)
		);

		$this->add_control(
			'columns',
			array(
				'label'   => esc_html__( 'Columns', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => '0',
				'options' => array(
					'0' => esc_html__( 'Auto (from preset)', 'nexus' ),
					'2' => '2',
					'3' => '3',
					'4' => '4',
				),
			)
		);

		$this->add_control(
			'entrance_animation',
			array(
				'label'       => esc_html__( 'Entrance Animation', 'nexus' ),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'default'     => 'fadeInUp',
				'options'     => array(
					'none'        => esc_html__( 'None', 'nexus' ),
					'fadeInUp'    => esc_html__( 'Fade In Up', 'nexus' ),
					'fadeInDown'  => esc_html__( 'Fade In Down', 'nexus' ),
					'fadeInLeft'  => esc_html__( 'Fade In Left', 'nexus' ),
					'fadeInRight' => esc_html__( 'Fade In Right', 'nexus' ),
					'zoomIn'      => esc_html__( 'Zoom In', 'nexus' ),
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
			'default' => esc_html__( 'Card Title', 'nexus' ),
			'dynamic' => array( 'active' => true ),
		) );

		$repeater->add_control( 'subtitle', array(
			'label'   => esc_html__( 'Subtitle / Category', 'nexus' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => esc_html__( 'Category', 'nexus' ),
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
				'label'       => esc_html__( 'Image Cards', 'nexus' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(),
				'title_field' => '{{{ title }}}',
			)
		);

		$this->end_controls_section();

		// ---- Buttons ----
		$this->start_controls_section(
			'section_buttons',
			array( 'label' => esc_html__( 'Buttons', 'nexus' ) )
		);

		$btn_styles = array(
			'auto'          => esc_html__( 'Auto (from preset)', 'nexus' ),
			'ghost-accent'  => esc_html__( 'Ghost Accent', 'nexus' ),
			'ghost-white'   => esc_html__( 'Ghost White', 'nexus' ),
			'ghost-dark'    => esc_html__( 'Ghost Dark', 'nexus' ),
			'outline'       => esc_html__( 'Outline Accent', 'nexus' ),
			'outline-dark'  => esc_html__( 'Outline Dark', 'nexus' ),
			'outline-white' => esc_html__( 'Outline White', 'nexus' ),
			'primary'       => esc_html__( 'Primary', 'nexus' ),
			'secondary'     => esc_html__( 'Secondary', 'nexus' ),
		);

		$this->add_control( 'btn_text', array(
			'label'       => esc_html__( 'Card Button Text', 'nexus' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => '',
			'placeholder' => esc_html__( 'Auto-filled from preset', 'nexus' ),
		) );

		$this->add_control( 'btn_style', array(
			'label'   => esc_html__( 'Card Button Style', 'nexus' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'auto',
			'options' => $btn_styles,
		) );

		$this->add_control( 'section_btn_sep', array(
			'label'     => esc_html__( 'Section Button', 'nexus' ),
			'type'      => \Elementor\Controls_Manager::HEADING,
			'separator' => 'before',
		) );

		$this->add_control( 'section_btn', array(
			'label'       => esc_html__( 'Section Button Text', 'nexus' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => '',
			'placeholder' => esc_html__( 'Auto-filled from preset', 'nexus' ),
		) );

		$this->add_control( 'section_btn_link', array(
			'label'   => esc_html__( 'Section Button Link', 'nexus' ),
			'type'    => \Elementor\Controls_Manager::URL,
			'dynamic' => array( 'active' => true ),
		) );

		$this->add_control( 'section_btn_style', array(
			'label'   => esc_html__( 'Section Button Style', 'nexus' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'auto',
			'options' => $btn_styles,
		) );

		$this->end_controls_section();

		// ---- Style overrides ----
		$this->start_controls_section(
			'section_style_overrides',
			array(
				'label' => esc_html__( 'Style Overrides', 'nexus' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control( 'headline_color', array(
			'label'     => esc_html__( 'Headline Color', 'nexus' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => array( '{{WRAPPER}} .nexus-icg__headline' => 'color: {{VALUE}} !important;' ),
		) );

		$this->add_control( 'card_title_color', array(
			'label'     => esc_html__( 'Card Title Color', 'nexus' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => array( '{{WRAPPER}} .nexus-icg__card-title' => 'color: {{VALUE}} !important;' ),
		) );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'headline_typography',
				'selector' => '{{WRAPPER}} .nexus-icg__headline',
			)
		);

		$this->add_responsive_control( 'section_padding', array(
			'label'      => esc_html__( 'Padding', 'nexus' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => array( 'px', 'em' ),
			'selectors'  => array(
				'{{WRAPPER}} .nexus-icg' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
			),
		) );

		$this->end_controls_section();
	}

	// -----------------------------------------------------------------
	// Render
	// -----------------------------------------------------------------

	protected function render() {
		$settings  = $this->get_settings_for_display();
		$preset    = $settings['style_preset'] ?? 'clean-grid';
		$defaults  = $this->get_preset_defaults( $preset );
		$colors    = $this->get_preset_colors( $preset );
		$anim      = $settings['entrance_animation'] ?? 'fadeInUp';
		$is_editor = \Elementor\Plugin::$instance->editor->is_edit_mode();

		// Merge defaults.
		$tagline     = ! empty( $settings['tagline'] ) ? $settings['tagline'] : $defaults['tagline'];
		$headline    = ! empty( $settings['headline'] ) ? $settings['headline'] : $defaults['headline'];
		$description = ! empty( $settings['description'] ) ? $settings['description'] : $defaults['description'];
		$btn_text    = ! empty( $settings['btn_text'] ) ? $settings['btn_text'] : $defaults['btn_text'];
		$section_btn = ! empty( $settings['section_btn'] ) ? $settings['section_btn'] : $defaults['section_btn'];

		$btn_raw     = $settings['btn_style'] ?? 'auto';
		$btn_key     = ( 'auto' === $btn_raw ) ? $defaults['btn_style'] : $btn_raw;
		$sec_btn_raw = $settings['section_btn_style'] ?? 'auto';
		$sec_btn_key = ( 'auto' === $sec_btn_raw ) ? $defaults['section_style'] : $sec_btn_raw;

		$cols_raw = $settings['columns'] ?? '0';
		$cols     = ( '0' === $cols_raw ) ? $defaults['columns'] : absint( $cols_raw );

		// Cards: use repeater or fallback to preset defaults.
		$cards = $settings['cards'] ?? array();
		if ( empty( $cards ) ) {
			$placeholder = \Elementor\Utils::get_placeholder_image_src();
			foreach ( $defaults['cards'] as $dc ) {
				$cards[] = array(
					'image'    => array( 'url' => $placeholder ),
					'title'    => $dc['title'],
					'subtitle' => $dc['subtitle'],
					'link'     => array( 'url' => $dc['link'] ),
				);
			}
		}

		$has_anim = ( 'none' !== $anim && ! $is_editor );
		$uid      = 'nexus-icg-' . $this->get_id();
		$hidden   = $has_anim ? 'opacity:0;' : '';

		$is_masonry     = ( 'masonry-dark' === $preset );
		$is_overlay     = in_array( $preset, array( 'dark-overlay', 'masonry-dark', 'hover-zoom' ), true );
		$is_caption     = ( 'caption-below' === $preset );

		// Section styles.
		$section_css = 'padding:5rem 2rem;position:relative;overflow:hidden;box-sizing:border-box;';
		if ( 'transparent' !== $colors['section_bg'] ) {
			$section_css .= 'background-color:' . $colors['section_bg'] . ';';
		}
		?>

		<?php if ( $has_anim ) : ?>
			<style>
				@keyframes nexusFadeInUp{from{opacity:0;transform:translateY(30px)}to{opacity:1;transform:translateY(0)}}
				@keyframes nexusFadeInDown{from{opacity:0;transform:translateY(-30px)}to{opacity:1;transform:translateY(0)}}
				@keyframes nexusFadeInLeft{from{opacity:0;transform:translateX(-30px)}to{opacity:1;transform:translateX(0)}}
				@keyframes nexusFadeInRight{from{opacity:0;transform:translateX(30px)}to{opacity:1;transform:translateX(0)}}
				@keyframes nexusZoomIn{from{opacity:0;transform:scale(0.9)}to{opacity:1;transform:scale(1)}}
				.nexus-icg-anim--visible{animation-duration:0.6s;animation-fill-mode:both;animation-timing-function:cubic-bezier(0.25,0.46,0.45,0.94)}
				.nexus-icg-anim--fadeInUp.nexus-icg-anim--visible{animation-name:nexusFadeInUp}
				.nexus-icg-anim--fadeInDown.nexus-icg-anim--visible{animation-name:nexusFadeInDown}
				.nexus-icg-anim--fadeInLeft.nexus-icg-anim--visible{animation-name:nexusFadeInLeft}
				.nexus-icg-anim--fadeInRight.nexus-icg-anim--visible{animation-name:nexusFadeInRight}
				.nexus-icg-anim--zoomIn.nexus-icg-anim--visible{animation-name:nexusZoomIn}
			</style>
		<?php endif; ?>

		<div id="<?php echo esc_attr( $uid ); ?>" class="nexus-icg nexus-icg--<?php echo esc_attr( $preset ); ?>" style="<?php echo esc_attr( $section_css ); ?>">
			<div class="nexus-icg__inner" style="max-width:1200px;margin:0 auto;">

				<?php // Section header. ?>
				<?php if ( $tagline || $headline || $description ) : ?>
					<div class="nexus-icg__header" style="margin-bottom:3rem;">
						<?php if ( $tagline ) : ?>
							<p class="nexus-icg__tagline nexus-icg-anim--<?php echo esc_attr( $anim ); ?>" data-icg-delay="0" style="<?php echo esc_attr( $hidden ); ?>color:<?php echo esc_attr( $colors['tagline'] ); ?>;font-size:0.875rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;margin:0 0 0.5rem;">
								<?php echo esc_html( $tagline ); ?>
							</p>
						<?php endif; ?>

						<?php if ( $headline ) : ?>
							<h2 class="nexus-icg__headline nexus-icg-anim--<?php echo esc_attr( $anim ); ?>" data-icg-delay="100" style="<?php echo esc_attr( $hidden ); ?>color:<?php echo esc_attr( $colors['heading'] ); ?>;font-size:clamp(1.5rem,3vw,2.25rem);font-weight:700;line-height:1.25;margin:0 0 0.75rem;">
								<?php echo wp_kses_post( $headline ); ?>
							</h2>
						<?php endif; ?>

						<?php if ( $description ) : ?>
							<p class="nexus-icg__desc nexus-icg-anim--<?php echo esc_attr( $anim ); ?>" data-icg-delay="200" style="<?php echo esc_attr( $hidden ); ?>color:<?php echo esc_attr( $colors['text'] ); ?>;font-size:1rem;line-height:1.7;margin:0;max-width:600px;">
								<?php echo wp_kses_post( $description ); ?>
							</p>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<?php // Grid. ?>
				<div class="nexus-icg__grid" style="display:grid;grid-template-columns:repeat(<?php echo esc_attr( $cols ); ?>,1fr);gap:<?php echo $is_masonry ? '1rem' : '2rem'; ?>;">
					<?php
					$card_idx = 0;
					foreach ( $cards as $card ) :
						$delay    = 300 + ( $card_idx * 100 );
						$img_url  = ! empty( $card['image']['url'] ) ? $card['image']['url'] : '';
						$title    = $card['title'] ?? '';
						$subtitle = $card['subtitle'] ?? '';
						$link_url = ! empty( $card['link']['url'] ) ? esc_url( $card['link']['url'] ) : '';
						$target   = ! empty( $card['link']['is_external'] ) ? 'target="_blank" rel="noopener noreferrer"' : '';

						// Masonry: alternate aspect ratios.
						$masonry_ratio = '';
						if ( $is_masonry ) {
							$masonry_ratio = ( 0 === $card_idx % 3 ) ? 'aspect-ratio:3/4;' : ( ( 1 === $card_idx % 3 ) ? 'aspect-ratio:1/1;' : 'aspect-ratio:4/3;' );
						}

						if ( $is_overlay && ! $is_caption ) {
							$this->render_card_overlay( $card_idx, $preset, $colors, $img_url, $title, $subtitle, $link_url, $target, $btn_text, $btn_key, $anim, $hidden, $delay, $masonry_ratio );
						} elseif ( $is_caption ) {
							$this->render_card_caption( $colors, $img_url, $title, $subtitle, $link_url, $target, $btn_text, $btn_key, $anim, $hidden, $delay );
						} else {
							$this->render_card_standard( $preset, $colors, $img_url, $title, $subtitle, $link_url, $target, $btn_text, $btn_key, $anim, $hidden, $delay );
						}

						++$card_idx;
					endforeach;
					?>
				</div>

				<?php // Section button. ?>
				<?php if ( $section_btn ) : ?>
					<?php
					$sec_url    = ! empty( $settings['section_btn_link']['url'] ) ? esc_url( $settings['section_btn_link']['url'] ) : '#';
					$sec_target = ! empty( $settings['section_btn_link']['is_external'] ) ? 'target="_blank" rel="noopener noreferrer"' : '';
					?>
					<div class="nexus-icg__footer nexus-icg-anim--<?php echo esc_attr( $anim ); ?>" data-icg-delay="<?php echo esc_attr( 300 + count( $cards ) * 100 ); ?>" style="<?php echo esc_attr( $hidden ); ?>margin-top:2.5rem;text-align:center;">
						<a href="<?php echo $sec_url; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>" class="nexus-btn nexus-btn--<?php echo esc_attr( $sec_btn_key ); ?>" style="<?php echo esc_attr( $this->get_button_inline_style( $sec_btn_key ) ); ?>" <?php echo $sec_target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
							<?php echo esc_html( $section_btn ); ?>
						</a>
					</div>
				<?php endif; ?>

			</div>
		</div>

		<?php if ( $has_anim ) : ?>
			<script>
			(function(){
				var root=document.getElementById('<?php echo esc_js( $uid ); ?>');
				if(!root)return;
				var items=root.querySelectorAll('[data-icg-delay]');
				var obs=new IntersectionObserver(function(entries){
					entries.forEach(function(e){
						if(e.isIntersecting){
							items.forEach(function(el){
								var d=parseInt(el.getAttribute('data-icg-delay'),10)||0;
								setTimeout(function(){
									el.style.opacity='';
									el.classList.add('nexus-icg-anim--visible');
								},d);
							});
							obs.disconnect();
						}
					});
				},{threshold:0.15});
				obs.observe(root);
			})();
			</script>
		<?php endif; ?>

		<?php
	}

	/**
	 * Standard card (styles 1, 2) — image top, text below.
	 */
	private function render_card_standard( $preset, $colors, $img_url, $title, $subtitle, $link_url, $target, $btn_text, $btn_key, $anim, $hidden, $delay ) {
		$card_css = 'overflow:hidden;transition:transform 0.3s ease,box-shadow 0.3s ease;background-color:' . $colors['card_bg'] . ';';

		if ( 'rounded-shadow' === $preset ) {
			$card_css .= 'border-radius:16px;box-shadow:0 4px 20px rgba(0,0,0,0.08);';
		} else {
			$card_css .= 'border-radius:8px;';
		}
		?>
		<div class="nexus-icg__card nexus-icg-anim--<?php echo esc_attr( $anim ); ?>" data-icg-delay="<?php echo esc_attr( $delay ); ?>" style="<?php echo esc_attr( $hidden . $card_css ); ?>">

			<?php if ( $img_url ) : ?>
				<div class="nexus-icg__card-thumb" style="overflow:hidden;aspect-ratio:4/3;">
					<?php if ( $link_url ) : ?>
						<a href="<?php echo esc_url( $link_url ); ?>" <?php echo $target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> style="display:block;">
					<?php endif; ?>
						<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $title ); ?>" style="width:100%;height:100%;object-fit:cover;display:block;transition:transform 0.4s ease;" loading="lazy" />
					<?php if ( $link_url ) : ?>
						</a>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<div class="nexus-icg__card-body" style="padding:1.25rem 1.5rem 1.5rem;">
				<?php if ( $subtitle ) : ?>
					<span class="nexus-icg__card-subtitle" style="display:inline-block;font-size:0.75rem;font-weight:600;color:<?php echo esc_attr( $colors['tagline'] ); ?>;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.35rem;">
						<?php echo esc_html( $subtitle ); ?>
					</span>
				<?php endif; ?>

				<?php if ( $title ) : ?>
					<h3 class="nexus-icg__card-title" style="font-size:1.125rem;font-weight:700;line-height:1.35;margin:0;color:<?php echo esc_attr( $colors['heading'] ); ?>;">
						<?php if ( $link_url ) : ?>
							<a href="<?php echo esc_url( $link_url ); ?>" style="color:inherit;text-decoration:none;" <?php echo $target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $title ); ?></a>
						<?php else : ?>
							<?php echo esc_html( $title ); ?>
						<?php endif; ?>
					</h3>
				<?php endif; ?>

				<?php // For rounded-shadow, subtitle is used as description text. ?>
				<?php if ( 'rounded-shadow' === $preset && $subtitle && strlen( $subtitle ) > 30 ) : ?>
					<p style="font-size:0.875rem;line-height:1.6;color:<?php echo esc_attr( $colors['text'] ); ?>;margin:0.5rem 0 0;">
						<?php echo esc_html( $subtitle ); ?>
					</p>
				<?php endif; ?>

				<?php if ( $btn_text && $link_url ) : ?>
					<a href="<?php echo esc_url( $link_url ); ?>" class="nexus-btn nexus-btn--<?php echo esc_attr( $btn_key ); ?>" style="margin-top:0.75rem;<?php echo esc_attr( $this->get_button_inline_style( $btn_key ) ); ?>" <?php echo $target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
						<?php echo esc_html( $btn_text ); ?>
						<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
					</a>
				<?php endif; ?>
			</div>

		</div>
		<?php
	}

	/**
	 * Overlay card (styles 3, 4, 6) — image with text overlay on hover.
	 */
	private function render_card_overlay( $card_idx, $preset, $colors, $img_url, $title, $subtitle, $link_url, $target, $btn_text, $btn_key, $anim, $hidden, $delay, $masonry_ratio ) {
		$is_gradient = ( 'masonry-dark' === $preset );
		$is_zoom     = ( 'hover-zoom' === $preset );

		$card_css = 'position:relative;overflow:hidden;border-radius:12px;transition:transform 0.3s ease,box-shadow 0.3s ease;';
		if ( ! $masonry_ratio ) {
			$card_css .= 'aspect-ratio:4/3;';
		} else {
			$card_css .= $masonry_ratio;
		}
		?>
		<div class="nexus-icg__card nexus-icg__card--overlay<?php echo $is_zoom ? ' nexus-icg__card--zoom' : ''; ?> nexus-icg-anim--<?php echo esc_attr( $anim ); ?>" data-icg-delay="<?php echo esc_attr( $delay ); ?>" style="<?php echo esc_attr( $hidden . $card_css ); ?>">

			<?php if ( $img_url ) : ?>
				<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $title ); ?>" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;transition:transform 0.5s ease;" loading="lazy" />
			<?php endif; ?>

			<?php // Overlay. ?>
			<div class="nexus-icg__card-overlay" style="position:absolute;inset:0;<?php echo $is_gradient ? 'background:' . esc_attr( $colors['overlay'] ) . ';' : 'background-color:' . esc_attr( $colors['overlay'] ) . ';'; ?>opacity:0;transition:opacity 0.3s ease;"></div>

			<?php // Content shown on hover. ?>
			<div class="nexus-icg__card-content" style="position:absolute;inset:0;display:flex;flex-direction:column;justify-content:<?php echo $is_gradient ? 'flex-end' : 'center'; ?>;align-items:<?php echo $is_gradient ? 'flex-start' : 'center'; ?>;padding:1.5rem;text-align:<?php echo $is_gradient ? 'left' : 'center'; ?>;opacity:0;transition:opacity 0.3s ease;transform:translateY(10px);transition:opacity 0.3s ease,transform 0.3s ease;">

				<?php if ( $subtitle ) : ?>
					<span style="font-size:0.75rem;font-weight:600;color:<?php echo esc_attr( $colors['tagline'] ); ?>;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.35rem;">
						<?php echo esc_html( $subtitle ); ?>
					</span>
				<?php endif; ?>

				<?php if ( $title ) : ?>
					<h3 class="nexus-icg__card-title" style="font-size:1.25rem;font-weight:700;line-height:1.3;margin:0;color:#fff;">
						<?php echo esc_html( $title ); ?>
					</h3>
				<?php endif; ?>

				<?php if ( $btn_text && $link_url ) : ?>
					<a href="<?php echo esc_url( $link_url ); ?>" class="nexus-btn nexus-btn--<?php echo esc_attr( $btn_key ); ?>" style="margin-top:0.75rem;<?php echo esc_attr( $this->get_button_inline_style( $btn_key ) ); ?>" <?php echo $target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
						<?php echo esc_html( $btn_text ); ?>
					</a>
				<?php endif; ?>
			</div>

			<?php // Wrap entire card in a link if no btn. ?>
			<?php if ( $link_url && ! $btn_text ) : ?>
				<a href="<?php echo esc_url( $link_url ); ?>" class="nexus-icg__card-link" style="position:absolute;inset:0;z-index:2;" <?php echo $target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> aria-label="<?php echo esc_attr( $title ); ?>"></a>
			<?php endif; ?>

		</div>
		<?php
	}

	/**
	 * Caption-below card (style 5) — image top, caption below, no overlay.
	 */
	private function render_card_caption( $colors, $img_url, $title, $subtitle, $link_url, $target, $btn_text, $btn_key, $anim, $hidden, $delay ) {
		?>
		<div class="nexus-icg__card nexus-icg__card--caption nexus-icg-anim--<?php echo esc_attr( $anim ); ?>" data-icg-delay="<?php echo esc_attr( $delay ); ?>" style="<?php echo esc_attr( $hidden ); ?>text-align:center;">

			<?php if ( $img_url ) : ?>
				<div class="nexus-icg__card-thumb" style="overflow:hidden;border-radius:50%;width:180px;height:180px;margin:0 auto 1.25rem;">
					<?php if ( $link_url ) : ?>
						<a href="<?php echo esc_url( $link_url ); ?>" <?php echo $target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> style="display:block;">
					<?php endif; ?>
						<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $title ); ?>" style="width:100%;height:100%;object-fit:cover;display:block;transition:transform 0.4s ease;" loading="lazy" />
					<?php if ( $link_url ) : ?>
						</a>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<?php if ( $title ) : ?>
				<h3 class="nexus-icg__card-title" style="font-size:1.125rem;font-weight:700;line-height:1.35;margin:0 0 0.25rem;color:<?php echo esc_attr( $colors['heading'] ); ?>;">
					<?php if ( $link_url ) : ?>
						<a href="<?php echo esc_url( $link_url ); ?>" style="color:inherit;text-decoration:none;" <?php echo $target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $title ); ?></a>
					<?php else : ?>
						<?php echo esc_html( $title ); ?>
					<?php endif; ?>
				</h3>
			<?php endif; ?>

			<?php if ( $subtitle ) : ?>
				<p class="nexus-icg__card-subtitle" style="font-size:0.875rem;color:<?php echo esc_attr( $colors['text'] ); ?>;margin:0;">
					<?php echo esc_html( $subtitle ); ?>
				</p>
			<?php endif; ?>

			<?php if ( $btn_text && $link_url ) : ?>
				<a href="<?php echo esc_url( $link_url ); ?>" class="nexus-btn nexus-btn--<?php echo esc_attr( $btn_key ); ?>" style="margin-top:0.75rem;<?php echo esc_attr( $this->get_button_inline_style( $btn_key ) ); ?>" <?php echo $target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
					<?php echo esc_html( $btn_text ); ?>
					<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
				</a>
			<?php endif; ?>

		</div>
		<?php
	}
}
