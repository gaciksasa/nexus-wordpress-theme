<?php
/**
 * Nexus Theme - Elementor Row with Image Widget
 *
 * Two-column layout with image + text content. 6 style presets with
 * staggered entrance animations and inline styles for editor compatibility.
 *
 * @package Nexus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Nexus_Widget_Row_With_Image
 */
class Nexus_Widget_Row_With_Image extends \Elementor\Widget_Base {

	public function get_name() {
		return 'nexus-row-with-image';
	}

	public function get_title() {
		return esc_html__( 'Row with Image', 'nexus' );
	}

	public function get_icon() {
		return 'eicon-image-box';
	}

	public function get_categories() {
		return array( 'nexus-elements' );
	}

	public function get_keywords() {
		return array( 'row', 'image', 'about', 'feature', 'two column', 'nexus' );
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
			'image-left-light'  => array(
				'bg'      => 'transparent',
				'heading' => '#1a1a2e',
				'text'    => '#495057',
				'tagline' => '#e94560',
			),
			'image-right-light' => array(
				'bg'      => 'transparent',
				'heading' => '#1a1a2e',
				'text'    => '#495057',
				'tagline' => '#e94560',
			),
			'image-left-dark'   => array(
				'bg'      => '#1a1a2e',
				'heading' => '#ffffff',
				'text'    => '#cbd5e1',
				'tagline' => '#e94560',
			),
			'image-right-stats' => array(
				'bg'      => '#f8f9fa',
				'heading' => '#1a1a2e',
				'text'    => '#495057',
				'tagline' => '#e94560',
			),
			'card-shadow'       => array(
				'bg'      => '#1a1a2e',
				'heading' => '#ffffff',
				'text'    => '#cbd5e1',
				'tagline' => '#e94560',
			),
			'accent-border'     => array(
				'bg'      => 'transparent',
				'heading' => '#1a1a2e',
				'text'    => '#495057',
				'tagline' => '#e94560',
			),
		);

		return $presets[ $preset ] ?? $presets['image-left-light'];
	}

	/**
	 * Returns content defaults per preset.
	 *
	 * @param string $preset Preset key.
	 * @return array
	 */
	private function get_preset_defaults( $preset ) {
		$map = array(
			'image-left-light'  => array(
				'tagline'     => 'About Us',
				'headline'    => 'We Build Digital Products That Drive Growth',
				'description' => 'We are a team of passionate designers and developers dedicated to creating exceptional digital experiences. With over a decade of expertise, we turn ideas into impactful solutions.',
				'btn1_text'   => 'Learn More',
				'btn2_text'   => '',
				'btn1_style'  => 'primary',
				'btn2_style'  => 'outline',
				'stat1_num'   => '',
				'stat1_label' => '',
				'stat2_num'   => '',
				'stat2_label' => '',
				'stat3_num'   => '',
				'stat3_label' => '',
				'list_items'  => '',
			),
			'image-right-light' => array(
				'tagline'     => 'Our Mission',
				'headline'    => 'Empowering Businesses Through Innovation',
				'description' => 'Our mission is to bridge the gap between technology and business goals. We craft solutions that not only look beautiful but deliver measurable results.',
				'btn1_text'   => '',
				'btn2_text'   => '',
				'btn1_style'  => 'primary',
				'btn2_style'  => 'outline',
				'stat1_num'   => '',
				'stat1_label' => '',
				'stat2_num'   => '',
				'stat2_label' => '',
				'stat3_num'   => '',
				'stat3_label' => '',
				'list_items'  => "Strategic UX/UI Design\nFull-Stack Development\nSEO & Performance Optimization\nOngoing Support & Maintenance",
			),
			'image-left-dark'   => array(
				'tagline'     => 'Why Choose Us',
				'headline'    => 'Award-Winning Team With Proven Track Record',
				'description' => 'With 300+ successful projects delivered worldwide, our team combines creative excellence with technical precision to deliver results that exceed expectations.',
				'btn1_text'   => 'Get Started',
				'btn2_text'   => '',
				'btn1_style'  => 'primary',
				'btn2_style'  => 'outline-white',
				'stat1_num'   => '',
				'stat1_label' => '',
				'stat2_num'   => '',
				'stat2_label' => '',
				'stat3_num'   => '',
				'stat3_label' => '',
				'list_items'  => '',
			),
			'image-right-stats' => array(
				'tagline'     => 'Our Impact',
				'headline'    => 'Numbers That Speak For Themselves',
				'description' => 'Over the years, we have helped hundreds of companies reach their full potential through strategic design and development.',
				'btn1_text'   => '',
				'btn2_text'   => '',
				'btn1_style'  => 'primary',
				'btn2_style'  => 'outline',
				'stat1_num'   => '300+',
				'stat1_label' => 'Projects Delivered',
				'stat2_num'   => '98%',
				'stat2_label' => 'Client Satisfaction',
				'stat3_num'   => '40+',
				'stat3_label' => 'Countries Served',
				'list_items'  => '',
			),
			'card-shadow'       => array(
				'tagline'     => 'Case Study',
				'headline'    => 'How We Increased Revenue by 240% for TechCorp',
				'description' => 'Through a complete digital transformation strategy including website redesign, SEO optimization, and conversion rate optimization, we delivered outstanding results.',
				'btn1_text'   => 'Read Case Study',
				'btn2_text'   => '',
				'btn1_style'  => 'primary',
				'btn2_style'  => 'outline-white',
				'stat1_num'   => '',
				'stat1_label' => '',
				'stat2_num'   => '',
				'stat2_label' => '',
				'stat3_num'   => '',
				'stat3_label' => '',
				'list_items'  => '',
			),
			'accent-border'     => array(
				'tagline'     => '',
				'headline'    => 'Ready to Transform Your Digital Presence?',
				'description' => "Let's discuss how we can help your business grow with a tailored strategy. Book a free consultation with our team and discover what's possible.",
				'btn1_text'   => 'Book a Call',
				'btn2_text'   => 'View Portfolio',
				'btn1_style'  => 'primary',
				'btn2_style'  => 'outline',
				'stat1_num'   => '',
				'stat1_label' => '',
				'stat2_num'   => '',
				'stat2_label' => '',
				'stat3_num'   => '',
				'stat3_label' => '',
				'list_items'  => '',
			),
		);

		return $map[ $preset ] ?? $map['image-left-light'];
	}

	/**
	 * Returns inline button styles.
	 *
	 * @param string $style Button style key.
	 * @return string Inline CSS.
	 */
	private function get_button_inline_style( $style ) {
		$base = 'display:inline-flex;align-items:center;justify-content:center;padding:0.75em 1.75em;font-size:1rem;font-weight:600;line-height:1.5;border-radius:6px;text-decoration:none;border:2px solid transparent;cursor:pointer;transition:all 0.3s ease;';

		$styles = array(
			'primary'       => $base . 'background-color:#e94560;color:#fff;border-color:#e94560;',
			'secondary'     => $base . 'background-color:#16213e;color:#fff;border-color:#16213e;',
			'white'         => $base . 'background-color:#fff;color:#667eea;border-color:#fff;',
			'outline'       => $base . 'background-color:transparent;color:#e94560;border-color:#e94560;',
			'outline-white' => $base . 'background-color:transparent;color:#fff;border-color:rgba(255,255,255,0.5);',
			'outline-dark'  => $base . 'background-color:transparent;color:#1a1a2e;border-color:#1a1a2e;',
			'ghost'         => $base . 'background-color:transparent;color:inherit;border-color:transparent;',
		);

		return $styles[ $style ] ?? $styles['primary'];
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
				'default'     => 'image-left-light',
				'options'     => array(
					'image-left-light'  => esc_html__( '1 — Image Left, Text Right', 'nexus' ),
					'image-right-light' => esc_html__( '2 — Text Left, Image Right', 'nexus' ),
					'image-left-dark'   => esc_html__( '3 — Dark Background', 'nexus' ),
					'image-right-stats' => esc_html__( '4 — Light Background + Stats', 'nexus' ),
					'card-shadow'       => esc_html__( '5 — Card with Shadow', 'nexus' ),
					'accent-border'     => esc_html__( '6 — Accent Border', 'nexus' ),
				),
				'render_type' => 'template',
			)
		);

		$this->add_control(
			'image',
			array(
				'label'   => esc_html__( 'Image', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'default' => array(
					'url' => \Elementor\Utils::get_placeholder_image_src(),
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

		// ---- Content ----
		$this->start_controls_section(
			'section_content',
			array( 'label' => esc_html__( 'Content', 'nexus' ) )
		);

		$this->add_control(
			'tagline',
			array(
				'label'       => esc_html__( 'Tagline', 'nexus' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'Auto-filled from preset', 'nexus' ),
				'dynamic'     => array( 'active' => true ),
			)
		);

		$this->add_control(
			'headline',
			array(
				'label'       => esc_html__( 'Headline', 'nexus' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'rows'        => 3,
				'default'     => '',
				'placeholder' => esc_html__( 'Auto-filled from preset', 'nexus' ),
				'dynamic'     => array( 'active' => true ),
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
				),
			)
		);

		$this->add_control(
			'description',
			array(
				'label'       => esc_html__( 'Description', 'nexus' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'rows'        => 4,
				'default'     => '',
				'placeholder' => esc_html__( 'Auto-filled from preset', 'nexus' ),
				'dynamic'     => array( 'active' => true ),
			)
		);

		$this->add_control(
			'list_items',
			array(
				'label'       => esc_html__( 'List Items (one per line)', 'nexus' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'rows'        => 4,
				'default'     => '',
				'placeholder' => "Item one\nItem two\nItem three",
				'description' => esc_html__( 'Shows as a checkmark list below the description.', 'nexus' ),
			)
		);

		$this->end_controls_section();

		// ---- Stats (style 4) ----
		$this->start_controls_section(
			'section_stats',
			array(
				'label'     => esc_html__( 'Counter Stats', 'nexus' ),
				'condition' => array( 'style_preset' => 'image-right-stats' ),
			)
		);

		for ( $i = 1; $i <= 3; $i++ ) {
			$this->add_control(
				"stat{$i}_heading",
				array(
					'label'     => sprintf( esc_html__( 'Stat %d', 'nexus' ), $i ),
					'type'      => \Elementor\Controls_Manager::HEADING,
					'separator' => $i > 1 ? 'before' : 'default',
				)
			);

			$this->add_control(
				"stat{$i}_num",
				array(
					'label'       => esc_html__( 'Number', 'nexus' ),
					'type'        => \Elementor\Controls_Manager::TEXT,
					'default'     => '',
					'placeholder' => esc_html__( 'Auto-filled from preset', 'nexus' ),
				)
			);

			$this->add_control(
				"stat{$i}_label",
				array(
					'label'       => esc_html__( 'Label', 'nexus' ),
					'type'        => \Elementor\Controls_Manager::TEXT,
					'default'     => '',
					'placeholder' => esc_html__( 'Auto-filled from preset', 'nexus' ),
				)
			);
		}

		$this->end_controls_section();

		// ---- Buttons ----
		$this->start_controls_section(
			'section_buttons',
			array( 'label' => esc_html__( 'Buttons', 'nexus' ) )
		);

		$btn_styles = array(
			'auto'          => esc_html__( 'Auto (from preset)', 'nexus' ),
			'primary'       => esc_html__( 'Primary (Accent)', 'nexus' ),
			'secondary'     => esc_html__( 'Secondary (Dark)', 'nexus' ),
			'white'         => esc_html__( 'White', 'nexus' ),
			'outline'       => esc_html__( 'Outline (Accent)', 'nexus' ),
			'outline-white' => esc_html__( 'Outline (White)', 'nexus' ),
			'outline-dark'  => esc_html__( 'Outline (Dark)', 'nexus' ),
			'ghost'         => esc_html__( 'Ghost (Transparent)', 'nexus' ),
		);

		$this->add_control( 'btn1_text', array(
			'label'       => esc_html__( 'Primary Button Text', 'nexus' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => '',
			'placeholder' => esc_html__( 'Auto-filled from preset', 'nexus' ),
		) );

		$this->add_control( 'btn1_link', array(
			'label'   => esc_html__( 'Primary Button Link', 'nexus' ),
			'type'    => \Elementor\Controls_Manager::URL,
			'dynamic' => array( 'active' => true ),
		) );

		$this->add_control( 'btn1_style', array(
			'label'   => esc_html__( 'Primary Button Style', 'nexus' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'auto',
			'options' => $btn_styles,
		) );

		$this->add_control( 'btn2_sep', array(
			'label'     => esc_html__( 'Secondary Button', 'nexus' ),
			'type'      => \Elementor\Controls_Manager::HEADING,
			'separator' => 'before',
		) );

		$this->add_control( 'btn2_text', array(
			'label'       => esc_html__( 'Secondary Button Text', 'nexus' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => '',
			'placeholder' => esc_html__( 'Auto-filled from preset', 'nexus' ),
		) );

		$this->add_control( 'btn2_link', array(
			'label'   => esc_html__( 'Secondary Button Link', 'nexus' ),
			'type'    => \Elementor\Controls_Manager::URL,
			'dynamic' => array( 'active' => true ),
		) );

		$this->add_control( 'btn2_style', array(
			'label'   => esc_html__( 'Secondary Button Style', 'nexus' ),
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
			'selectors' => array( '{{WRAPPER}} .nexus-rwi__headline' => 'color: {{VALUE}} !important;' ),
		) );

		$this->add_control( 'desc_color', array(
			'label'     => esc_html__( 'Description Color', 'nexus' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => array( '{{WRAPPER}} .nexus-rwi__desc' => 'color: {{VALUE}} !important;' ),
		) );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'headline_typography',
				'selector' => '{{WRAPPER}} .nexus-rwi__headline',
			)
		);

		$this->add_responsive_control( 'section_padding', array(
			'label'      => esc_html__( 'Padding', 'nexus' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => array( 'px', 'em' ),
			'selectors'  => array(
				'{{WRAPPER}} .nexus-rwi' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
			),
		) );

		$this->end_controls_section();
	}

	// -----------------------------------------------------------------
	// Render
	// -----------------------------------------------------------------

	protected function render() {
		$settings  = $this->get_settings_for_display();
		$preset    = $settings['style_preset'] ?? 'image-left-light';
		$defaults  = $this->get_preset_defaults( $preset );
		$colors    = $this->get_preset_colors( $preset );
		$htag      = in_array( $settings['headline_tag'] ?? 'h2', array( 'h1', 'h2', 'h3', 'h4' ), true ) ? $settings['headline_tag'] : 'h2';
		$anim      = $settings['entrance_animation'] ?? 'fadeInUp';
		$is_editor = \Elementor\Plugin::$instance->editor->is_edit_mode();

		// Merge defaults.
		$tagline     = ! empty( $settings['tagline'] ) ? $settings['tagline'] : $defaults['tagline'];
		$headline    = ! empty( $settings['headline'] ) ? $settings['headline'] : $defaults['headline'];
		$description = ! empty( $settings['description'] ) ? $settings['description'] : $defaults['description'];
		$btn1_text   = ! empty( $settings['btn1_text'] ) ? $settings['btn1_text'] : $defaults['btn1_text'];
		$btn2_text   = ! empty( $settings['btn2_text'] ) ? $settings['btn2_text'] : $defaults['btn2_text'];
		$list_items  = ! empty( $settings['list_items'] ) ? $settings['list_items'] : $defaults['list_items'];

		$btn1_raw = $settings['btn1_style'] ?? 'auto';
		$btn2_raw = $settings['btn2_style'] ?? 'auto';
		$btn1_key = ( 'auto' === $btn1_raw ) ? $defaults['btn1_style'] : $btn1_raw;
		$btn2_key = ( 'auto' === $btn2_raw ) ? $defaults['btn2_style'] : $btn2_raw;

		// Stats (style 4).
		$stats = array();
		for ( $i = 1; $i <= 3; $i++ ) {
			$num   = ! empty( $settings["stat{$i}_num"] ) ? $settings["stat{$i}_num"] : $defaults["stat{$i}_num"];
			$label = ! empty( $settings["stat{$i}_label"] ) ? $settings["stat{$i}_label"] : $defaults["stat{$i}_label"];
			if ( $num ) {
				$stats[] = array( 'num' => $num, 'label' => $label );
			}
		}

		// Image position: left or right.
		$image_left = in_array( $preset, array( 'image-left-light', 'image-left-dark' ), true );
		$image_url  = ! empty( $settings['image']['url'] ) ? $settings['image']['url'] : '';

		$has_anim = ( 'none' !== $anim && ! $is_editor );
		$uid      = 'nexus-rwi-' . $this->get_id();
		$hidden   = $has_anim ? 'opacity:0;' : '';

		// Image animation direction.
		$img_anim = $anim;
		if ( 'fadeInUp' === $anim ) {
			$img_anim = $image_left ? 'fadeInLeft' : 'fadeInRight';
		}

		// --- Wrapper styles ---
		$wrap_css = 'padding:5rem 2rem;position:relative;overflow:hidden;';
		if ( 'transparent' !== $colors['bg'] ) {
			$wrap_css .= 'background-color:' . $colors['bg'] . ';';
		}

		// Card shadow style.
		if ( 'card-shadow' === $preset ) {
			$wrap_css .= 'box-shadow:0 8px 30px rgba(0,0,0,0.1);border-radius:12px;';
		}

		// --- Row styles ---
		$row_css = 'display:flex;align-items:center;gap:3rem;max-width:1200px;margin:0 auto;flex-wrap:wrap;';
		if ( ! $image_left ) {
			$row_css .= 'flex-direction:row;';
		}

		// Accent border (style 6).
		$text_extra = '';
		if ( 'accent-border' === $preset ) {
			$text_extra = 'border-left:4px solid #e94560;padding-left:2rem;';
		}
		?>

		<?php if ( $has_anim ) : ?>
			<style>
				@keyframes nexusFadeInUp{from{opacity:0;transform:translateY(30px)}to{opacity:1;transform:translateY(0)}}
				@keyframes nexusFadeInDown{from{opacity:0;transform:translateY(-30px)}to{opacity:1;transform:translateY(0)}}
				@keyframes nexusFadeInLeft{from{opacity:0;transform:translateX(-30px)}to{opacity:1;transform:translateX(0)}}
				@keyframes nexusFadeInRight{from{opacity:0;transform:translateX(30px)}to{opacity:1;transform:translateX(0)}}
				@keyframes nexusZoomIn{from{opacity:0;transform:scale(0.9)}to{opacity:1;transform:scale(1)}}
				.nexus-rwi-anim--visible{animation-duration:0.6s;animation-fill-mode:both;animation-timing-function:cubic-bezier(0.25,0.46,0.45,0.94)}
				.nexus-rwi-anim--fadeInUp.nexus-rwi-anim--visible{animation-name:nexusFadeInUp}
				.nexus-rwi-anim--fadeInDown.nexus-rwi-anim--visible{animation-name:nexusFadeInDown}
				.nexus-rwi-anim--fadeInLeft.nexus-rwi-anim--visible{animation-name:nexusFadeInLeft}
				.nexus-rwi-anim--fadeInRight.nexus-rwi-anim--visible{animation-name:nexusFadeInRight}
				.nexus-rwi-anim--zoomIn.nexus-rwi-anim--visible{animation-name:nexusZoomIn}
			</style>
		<?php endif; ?>

		<div id="<?php echo esc_attr( $uid ); ?>" class="nexus-rwi nexus-rwi--<?php echo esc_attr( $preset ); ?>" style="<?php echo esc_attr( $wrap_css ); ?>">
			<div class="nexus-rwi__row" style="<?php echo esc_attr( $row_css ); ?>">

				<?php if ( $image_left ) : ?>
					<?php $this->render_image_col( $image_url, $img_anim, $hidden ); ?>
					<?php $this->render_text_col( $settings, $preset, $colors, $defaults, $htag, $tagline, $headline, $description, $list_items, $stats, $btn1_text, $btn2_text, $btn1_key, $btn2_key, $anim, $hidden, $text_extra ); ?>
				<?php else : ?>
					<?php $this->render_text_col( $settings, $preset, $colors, $defaults, $htag, $tagline, $headline, $description, $list_items, $stats, $btn1_text, $btn2_text, $btn1_key, $btn2_key, $anim, $hidden, $text_extra ); ?>
					<?php $this->render_image_col( $image_url, $img_anim, $hidden ); ?>
				<?php endif; ?>

			</div>
		</div>

		<?php if ( $has_anim ) : ?>
			<script>
			(function(){
				var root=document.getElementById('<?php echo esc_js( $uid ); ?>');
				if(!root)return;
				var items=root.querySelectorAll('[data-rwi-delay]');
				var obs=new IntersectionObserver(function(entries){
					entries.forEach(function(e){
						if(e.isIntersecting){
							items.forEach(function(el){
								var d=parseInt(el.getAttribute('data-rwi-delay'),10)||0;
								setTimeout(function(){
									el.style.opacity='';
									el.classList.add('nexus-rwi-anim--visible');
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
	 * Render image column.
	 *
	 * @param string $url    Image URL.
	 * @param string $anim   Animation name.
	 * @param string $hidden Hidden inline style.
	 */
	private function render_image_col( $url, $anim, $hidden ) {
		?>
		<div class="nexus-rwi__img-col nexus-rwi-anim--<?php echo esc_attr( $anim ); ?>" data-rwi-delay="0" style="<?php echo esc_attr( $hidden ); ?>flex:1;min-width:280px;">
			<?php if ( $url ) : ?>
				<img src="<?php echo esc_url( $url ); ?>" alt="" style="width:100%;height:auto;display:block;border-radius:12px;object-fit:cover;" loading="lazy" />
			<?php endif; ?>
		</div>
		<?php
	}

	/**
	 * Render text column.
	 *
	 * @param array  $settings    Widget settings.
	 * @param string $preset      Preset key.
	 * @param array  $colors      Colors map.
	 * @param array  $defaults    Defaults map.
	 * @param string $htag        Heading tag.
	 * @param string $tagline     Tagline text.
	 * @param string $headline    Headline text.
	 * @param string $description Description text.
	 * @param string $list_items  Newline-separated list.
	 * @param array  $stats       Stats array.
	 * @param string $btn1_text   Button 1 text.
	 * @param string $btn2_text   Button 2 text.
	 * @param string $btn1_key    Button 1 style.
	 * @param string $btn2_key    Button 2 style.
	 * @param string $anim        Animation name.
	 * @param string $hidden      Hidden style.
	 * @param string $text_extra  Extra inline CSS for text col.
	 */
	private function render_text_col( $settings, $preset, $colors, $defaults, $htag, $tagline, $headline, $description, $list_items, $stats, $btn1_text, $btn2_text, $btn1_key, $btn2_key, $anim, $hidden, $text_extra ) {
		?>
		<div class="nexus-rwi__text-col" style="flex:1;min-width:280px;<?php echo esc_attr( $text_extra ); ?>">

			<?php if ( $tagline ) : ?>
				<p class="nexus-rwi__tagline nexus-rwi-anim--<?php echo esc_attr( $anim ); ?>" data-rwi-delay="0" style="<?php echo esc_attr( $hidden ); ?>color:<?php echo esc_attr( $colors['tagline'] ); ?>;font-size:0.875rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;margin:0 0 0.5rem;">
					<?php echo esc_html( $tagline ); ?>
				</p>
			<?php endif; ?>

			<?php if ( $headline ) : ?>
				<<?php echo esc_attr( $htag ); ?> class="nexus-rwi__headline nexus-rwi-anim--<?php echo esc_attr( $anim ); ?>" data-rwi-delay="100" style="<?php echo esc_attr( $hidden ); ?>color:<?php echo esc_attr( $colors['heading'] ); ?>;font-size:clamp(1.5rem,3vw,2.25rem);font-weight:700;line-height:1.25;margin:0 0 0.75rem;">
					<?php echo wp_kses_post( $headline ); ?>
				</<?php echo esc_attr( $htag ); ?>>
			<?php endif; ?>

			<?php if ( $description ) : ?>
				<p class="nexus-rwi__desc nexus-rwi-anim--<?php echo esc_attr( $anim ); ?>" data-rwi-delay="200" style="<?php echo esc_attr( $hidden ); ?>color:<?php echo esc_attr( $colors['text'] ); ?>;font-size:1rem;line-height:1.7;margin:0 0 1rem;">
					<?php echo wp_kses_post( $description ); ?>
				</p>
			<?php endif; ?>

			<?php
			// List items.
			if ( $list_items ) :
				$items = array_filter( array_map( 'trim', explode( "\n", $list_items ) ) );
				if ( $items ) :
					?>
					<ul class="nexus-rwi__list nexus-rwi-anim--<?php echo esc_attr( $anim ); ?>" data-rwi-delay="250" style="<?php echo esc_attr( $hidden ); ?>list-style:none;padding:0;margin:0 0 1.5rem;display:flex;flex-direction:column;gap:0.5rem;">
						<?php foreach ( $items as $item ) : ?>
							<li style="display:flex;align-items:center;gap:0.5rem;color:<?php echo esc_attr( $colors['text'] ); ?>;font-size:0.95rem;">
								<svg width="16" height="16" viewBox="0 0 16 16" fill="none" style="flex-shrink:0;"><circle cx="8" cy="8" r="8" fill="#e94560" opacity="0.15"/><path d="M5 8l2 2 4-4" stroke="#e94560" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
								<?php echo esc_html( $item ); ?>
							</li>
						<?php endforeach; ?>
					</ul>
					<?php
				endif;
			endif;

			// Stats (style 4).
			if ( $stats ) :
				?>
				<div class="nexus-rwi__stats nexus-rwi-anim--<?php echo esc_attr( $anim ); ?>" data-rwi-delay="250" style="<?php echo esc_attr( $hidden ); ?>display:flex;gap:2rem;flex-wrap:wrap;margin:0 0 1.5rem;">
					<?php foreach ( $stats as $stat ) : ?>
						<div style="text-align:left;">
							<div style="font-size:1.75rem;font-weight:700;color:#e94560;line-height:1.2;"><?php echo esc_html( $stat['num'] ); ?></div>
							<div style="font-size:0.8125rem;color:#6c757d;margin-top:0.25rem;"><?php echo esc_html( $stat['label'] ); ?></div>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<?php
			// Buttons.
			$has_btns = $btn1_text || $btn2_text;
			if ( $has_btns ) :
				?>
				<div class="nexus-rwi__actions nexus-rwi-anim--<?php echo esc_attr( $anim ); ?>" data-rwi-delay="300" style="<?php echo esc_attr( $hidden ); ?>display:flex;gap:1rem;flex-wrap:wrap;">
					<?php if ( $btn1_text ) : ?>
						<?php
						$url    = ! empty( $settings['btn1_link']['url'] ) ? esc_url( $settings['btn1_link']['url'] ) : '#';
						$target = ! empty( $settings['btn1_link']['is_external'] ) ? 'target="_blank" rel="noopener noreferrer"' : '';
						?>
						<a href="<?php echo $url; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>" class="nexus-btn nexus-btn--<?php echo esc_attr( $btn1_key ); ?>" style="<?php echo esc_attr( $this->get_button_inline_style( $btn1_key ) ); ?>" <?php echo $target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
							<?php echo esc_html( $btn1_text ); ?>
						</a>
					<?php endif; ?>
					<?php if ( $btn2_text ) : ?>
						<?php
						$url    = ! empty( $settings['btn2_link']['url'] ) ? esc_url( $settings['btn2_link']['url'] ) : '#';
						$target = ! empty( $settings['btn2_link']['is_external'] ) ? 'target="_blank" rel="noopener noreferrer"' : '';
						?>
						<a href="<?php echo $url; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>" class="nexus-btn nexus-btn--<?php echo esc_attr( $btn2_key ); ?>" style="<?php echo esc_attr( $this->get_button_inline_style( $btn2_key ) ); ?>" <?php echo $target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
							<?php echo esc_html( $btn2_text ); ?>
						</a>
					<?php endif; ?>
				</div>
			<?php endif; ?>

		</div>
		<?php
	}
}
