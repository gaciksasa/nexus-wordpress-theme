<?php
/**
 * Nexus Theme - Elementor Image Cards Scroller Widget
 *
 * Horizontal scrolling image card carousel with 6 style presets.
 * Uses Swiper.js for smooth, touch-friendly scrolling.
 *
 * @package Nexus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Nexus_Widget_Image_Cards_Scroller
 */
class Nexus_Widget_Image_Cards_Scroller extends \Elementor\Widget_Base {

	public function get_name() {
		return 'nexus-image-cards-scroller';
	}

	public function get_title() {
		return esc_html__( 'Image Cards Scroller', 'nexus' );
	}

	public function get_icon() {
		return 'eicon-slides';
	}

	public function get_categories() {
		return array( 'nexus-elements' );
	}

	public function get_keywords() {
		return array( 'image', 'cards', 'scroller', 'carousel', 'slider', 'gallery', 'nexus' );
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
		$presets = array(
			'minimal-slide'   => array(
				'section_bg' => '#ffffff',
				'card_bg'    => '#ffffff',
				'heading'    => nexus_palette()['primary'],
				'text'       => '#495057',
				'tagline'    => nexus_palette()['secondary'],
				'overlay'    => 'rgba(0,0,0,0.4)',
				'dot_color'  => nexus_palette()['secondary'],
			),
			'dark-cinema'     => array(
				'section_bg' => '#0f0f23',
				'card_bg'    => 'transparent',
				'heading'    => '#ffffff',
				'text'       => '#cbd5e1',
				'tagline'    => nexus_palette()['secondary'],
				'overlay'    => 'linear-gradient(to top,rgba(0,0,0,0.85) 0%,transparent 50%)',
				'dot_color'  => nexus_palette()['secondary'],
			),
			'rounded-peek'    => array(
				'section_bg' => nexus_palette()['light'],
				'card_bg'    => '#ffffff',
				'heading'    => nexus_palette()['primary'],
				'text'       => '#495057',
				'tagline'    => nexus_palette()['secondary'],
				'overlay'    => 'rgba(0,0,0,0.35)',
				'dot_color'  => nexus_palette()['primary'],
			),
			'fullwidth-hero'  => array(
				'section_bg' => nexus_palette()['primary'],
				'card_bg'    => 'transparent',
				'heading'    => '#ffffff',
				'text'       => '#e2e8f0',
				'tagline'    => nexus_palette()['secondary'],
				'overlay'    => 'linear-gradient(to top,rgba(0,0,0,0.7) 0%,transparent 60%)',
				'dot_color'  => '#ffffff',
			),
			'caption-card'    => array(
				'section_bg' => '#ffffff',
				'card_bg'    => '#ffffff',
				'heading'    => nexus_palette()['primary'],
				'text'       => '#495057',
				'tagline'    => nexus_palette()['accent'],
				'overlay'    => 'rgba(0,0,0,0.3)',
				'dot_color'  => nexus_palette()['accent'],
			),
			'gradient-hover'  => array(
				'section_bg' => '#f1f5f9',
				'card_bg'    => '#ffffff',
				'heading'    => nexus_palette()['primary'],
				'text'       => '#495057',
				'tagline'    => nexus_palette()['secondary'],
				'overlay'    => 'linear-gradient(135deg,rgba(233,69,96,0.85),rgba(102,126,234,0.85))',
				'dot_color'  => nexus_palette()['secondary'],
			),
		);

		return $presets[ $preset ] ?? $presets['minimal-slide'];
	}

	private function get_preset_defaults( $preset ) {
		$map = array(
			'minimal-slide'  => array(
				'tagline'     => 'Portfolio',
				'headline'    => 'Our Latest Work',
				'description' => 'Scroll through our most recent projects and creative endeavors.',
				'slides_view' => 3,
				'card_style'  => 'standard',
				'aspect'      => '4/3',
				'show_btn'    => true,
				'btn_style'   => 'ghost-accent',
				'cards'       => array(
					array( 'title' => 'Brand Identity', 'subtitle' => 'Branding' ),
					array( 'title' => 'Mobile App Design', 'subtitle' => 'UI/UX' ),
					array( 'title' => 'E-Commerce Platform', 'subtitle' => 'Web Dev' ),
					array( 'title' => 'Marketing Campaign', 'subtitle' => 'Digital' ),
					array( 'title' => 'Dashboard Analytics', 'subtitle' => 'SaaS' ),
				),
			),
			'dark-cinema'    => array(
				'tagline'     => 'Showcase',
				'headline'    => 'Visual Stories',
				'description' => '',
				'slides_view' => 2,
				'card_style'  => 'overlay-gradient',
				'aspect'      => '16/9',
				'show_btn'    => false,
				'btn_style'   => 'ghost-white',
				'cards'       => array(
					array( 'title' => 'Mountain Expedition', 'subtitle' => 'Adventure' ),
					array( 'title' => 'Urban Architecture', 'subtitle' => 'City Life' ),
					array( 'title' => 'Ocean Depths', 'subtitle' => 'Nature' ),
					array( 'title' => 'Desert Horizons', 'subtitle' => 'Landscape' ),
				),
			),
			'rounded-peek'   => array(
				'tagline'     => 'Featured',
				'headline'    => 'Handpicked Projects',
				'description' => 'A curated selection of our finest creative work.',
				'slides_view' => 3,
				'card_style'  => 'rounded',
				'aspect'      => '3/4',
				'show_btn'    => true,
				'btn_style'   => 'ghost-dark',
				'cards'       => array(
					array( 'title' => 'Fashion Lookbook', 'subtitle' => 'Photography' ),
					array( 'title' => 'Minimal Interiors', 'subtitle' => 'Interior Design' ),
					array( 'title' => 'Product Shots', 'subtitle' => 'Commercial' ),
					array( 'title' => 'Portrait Series', 'subtitle' => 'Editorial' ),
					array( 'title' => 'Event Coverage', 'subtitle' => 'Events' ),
					array( 'title' => 'Food Styling', 'subtitle' => 'Culinary' ),
				),
			),
			'fullwidth-hero' => array(
				'tagline'     => 'Gallery',
				'headline'    => 'Explore Our World',
				'description' => '',
				'slides_view' => 1,
				'card_style'  => 'overlay-gradient',
				'aspect'      => '21/9',
				'show_btn'    => false,
				'btn_style'   => 'outline-white',
				'cards'       => array(
					array( 'title' => 'Creative Studio', 'subtitle' => 'Behind the Scenes' ),
					array( 'title' => 'Global Campaign', 'subtitle' => 'International' ),
					array( 'title' => 'Innovation Lab', 'subtitle' => 'R&D Projects' ),
				),
			),
			'caption-card'   => array(
				'tagline'     => 'Services',
				'headline'    => 'What We Offer',
				'description' => 'Comprehensive solutions tailored to your unique business needs.',
				'slides_view' => 4,
				'card_style'  => 'caption-below',
				'aspect'      => '1/1',
				'show_btn'    => true,
				'btn_style'   => 'ghost-dark',
				'cards'       => array(
					array( 'title' => 'Web Design', 'subtitle' => 'Beautiful responsive websites that convert.' ),
					array( 'title' => 'App Development', 'subtitle' => 'Native and cross-platform mobile apps.' ),
					array( 'title' => 'SEO Strategy', 'subtitle' => 'Data-driven search optimization.' ),
					array( 'title' => 'Brand Identity', 'subtitle' => 'Memorable logos and brand guidelines.' ),
					array( 'title' => 'Social Media', 'subtitle' => 'Engaging campaigns that grow your audience.' ),
				),
			),
			'gradient-hover' => array(
				'tagline'     => 'Projects',
				'headline'    => 'Award-Winning Work',
				'description' => 'Recognized by industry leaders for excellence in design.',
				'slides_view' => 3,
				'card_style'  => 'overlay-solid',
				'aspect'      => '4/3',
				'show_btn'    => false,
				'btn_style'   => 'ghost-white',
				'cards'       => array(
					array( 'title' => 'Awwwards Winner', 'subtitle' => '2024 Site of the Day' ),
					array( 'title' => 'CSS Design Awards', 'subtitle' => 'Best Innovation' ),
					array( 'title' => 'Webby Awards', 'subtitle' => 'People\'s Choice' ),
					array( 'title' => 'FWA of the Month', 'subtitle' => 'Interactive Design' ),
				),
			),
		);

		return $map[ $preset ] ?? $map['minimal-slide'];
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
				'default'     => 'minimal-slide',
				'options'     => array(
					'minimal-slide'  => esc_html__( '1 — Minimal Slide', 'nexus' ),
					'dark-cinema'    => esc_html__( '2 — Dark Cinema', 'nexus' ),
					'rounded-peek'   => esc_html__( '3 — Rounded Peek', 'nexus' ),
					'fullwidth-hero' => esc_html__( '4 — Fullwidth Hero', 'nexus' ),
					'caption-card'   => esc_html__( '5 — Caption Card', 'nexus' ),
					'gradient-hover' => esc_html__( '6 — Gradient Hover', 'nexus' ),
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
			'placeholder' => esc_html__( 'e.g. View All Projects', 'nexus' ),
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
		$preset    = $settings['style_preset'] ?? 'minimal-slide';
		$colors    = $this->get_preset_colors( $preset );
		$defaults  = $this->get_preset_defaults( $preset );
		$animation = $settings['entrance_animation'] ?? 'fadeInUp';
		$is_editor = \Elementor\Plugin::$instance->editor->is_edit_mode();
		$widget_id = 'nexus-ics-' . $this->get_id();

		// Merge defaults.
		$tagline     = ( '' !== $settings['tagline'] ) ? $settings['tagline'] : ( $defaults['tagline'] ?? '' );
		$headline    = ( '' !== $settings['headline'] ) ? $settings['headline'] : ( $defaults['headline'] ?? '' );
		$description = ( '' !== $settings['description'] ) ? $settings['description'] : ( $defaults['description'] ?? '' );
		$card_style  = $defaults['card_style'];
		$aspect      = $defaults['aspect'];
		$spv         = absint( $defaults['slides_view'] );
		$show_btn    = $defaults['show_btn'];
		$btn_style   = $defaults['btn_style'];
		$dots        = 'yes' === $settings['show_dots'];
		$arrows      = 'yes' === $settings['show_arrows'];

		// Cards: use repeater or fallback to preset defaults.
		$cards = $settings['cards'] ?? array();
		if ( empty( $cards ) ) {
			$placeholder = \Elementor\Utils::get_placeholder_image_src();
			foreach ( $defaults['cards'] as $dc ) {
				$cards[] = array(
					'image'    => array( 'url' => $placeholder ),
					'title'    => $dc['title'],
					'subtitle' => $dc['subtitle'],
					'link'     => array( 'url' => '#' ),
				);
			}
		}

		$total_slides = count( $cards );

		// Section button.
		$sec_btn_text = $settings['section_btn_text'] ?? '';
		$sec_btn_url  = $settings['section_btn_url']['url'] ?? '';
		$sec_btn_tgt  = ! empty( $settings['section_btn_url']['is_external'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';
		?>

		<section
			class="nexus-ics nexus-ics--<?php echo esc_attr( $preset ); ?>"
			style="background-color:<?php echo esc_attr( $colors['section_bg'] ); ?>;padding:5rem 0;overflow:hidden;"
			id="<?php echo esc_attr( $widget_id ); ?>"
		>
			<div class="nexus-container">

				<?php if ( $tagline || $headline || $description ) : ?>
				<div class="nexus-ics__header" style="margin-bottom:2.5rem;max-width:680px;">
					<?php if ( $tagline ) : ?>
						<span class="nexus-ics__tagline" style="display:inline-block;font-size:0.875rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:<?php echo esc_attr( $colors['tagline'] ); ?>;margin-bottom:0.75rem;">
							<?php echo esc_html( $tagline ); ?>
						</span>
					<?php endif; ?>
					<?php if ( $headline ) : ?>
						<h2 class="nexus-ics__title" style="font-size:clamp(1.5rem,3vw,2.25rem);font-weight:700;color:<?php echo esc_attr( $colors['heading'] ); ?>;margin:0 0 0.75rem;">
							<?php echo wp_kses_post( $headline ); ?>
						</h2>
					<?php endif; ?>
					<?php if ( $description ) : ?>
						<p class="nexus-ics__desc" style="font-size:1.0625rem;line-height:1.7;color:<?php echo esc_attr( $colors['text'] ); ?>;margin:0;">
							<?php echo wp_kses_post( $description ); ?>
						</p>
					<?php endif; ?>
				</div>
				<?php endif; ?>

			</div>

			<?php // Slider — full bleed for fullwidth-hero, contained for others. ?>
			<div class="<?php echo 'fullwidth-hero' === $preset ? '' : 'nexus-container'; ?>">
				<div class="nexus-ics__slider swiper" id="<?php echo esc_attr( $widget_id ); ?>-swiper" style="overflow:hidden;position:relative;">
					<div class="swiper-wrapper">
						<?php
						foreach ( $cards as $idx => $card ) :
							$img_url  = ! empty( $card['image']['url'] ) ? $card['image']['url'] : '';
							$title    = $card['title'] ?? '';
							$subtitle = $card['subtitle'] ?? '';
							$link_url = ! empty( $card['link']['url'] ) ? esc_url( $card['link']['url'] ) : '';
							$target   = ! empty( $card['link']['is_external'] ) ? 'target="_blank" rel="noopener noreferrer"' : '';
							?>
							<div class="swiper-slide">
								<?php
								if ( 'caption-below' === $card_style ) {
									$this->render_card_caption( $colors, $aspect, $img_url, $title, $subtitle, $link_url, $target, $show_btn, $btn_style );
								} elseif ( 'standard' === $card_style ) {
									$this->render_card_standard( $colors, $aspect, $img_url, $title, $subtitle, $link_url, $target, $show_btn, $btn_style );
								} else {
									$this->render_card_overlay( $preset, $colors, $aspect, $img_url, $title, $subtitle, $link_url, $target );
								}
								?>
							</div>
						<?php endforeach; ?>
					</div>

					<?php if ( $dots ) : ?>
						<div class="swiper-pagination nexus-ics__dots"></div>
					<?php endif; ?>

					<?php if ( $arrows ) : ?>
						<button class="swiper-button-prev nexus-ics__arrow nexus-ics__arrow--prev" aria-label="<?php esc_attr_e( 'Previous', 'nexus' ); ?>"></button>
						<button class="swiper-button-next nexus-ics__arrow nexus-ics__arrow--next" aria-label="<?php esc_attr_e( 'Next', 'nexus' ); ?>"></button>
					<?php endif; ?>
				</div>
			</div>

			<?php // Section button. ?>
			<?php if ( $sec_btn_text && $sec_btn_url ) : ?>
			<div class="nexus-container">
				<div class="nexus-ics__footer" style="text-align:center;margin-top:2.5rem;">
					<a href="<?php echo esc_url( $sec_btn_url ); ?>"<?php echo $sec_btn_tgt; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> class="nexus-ics__section-btn" style="<?php echo esc_attr( $this->get_button_inline_style( $settings['section_btn_style'] ?? 'primary' ) ); ?>">
						<?php echo esc_html( $sec_btn_text ); ?>
					</a>
				</div>
			</div>
			<?php endif; ?>

		</section>

		<script>
		(function(){
			var swiperId='<?php echo esc_js( $widget_id ); ?>-swiper';
			function initICS(){
				var el=document.getElementById(swiperId);
				if(!el)return;
				if(!window.Swiper){setTimeout(initICS,100);return;}
				if(el.swiper)el.swiper.destroy(true,true);
				var totalSlides=el.querySelectorAll('.swiper-slide').length;
				var spv=<?php echo esc_js( $spv ); ?>;
				var autoplayOpt=<?php echo 'yes' === $settings['autoplay'] ? '{delay:' . absint( $settings['autoplay_speed'] ) . ',disableOnInteraction:false}' : 'false'; ?>;
				new Swiper(el,{
					slidesPerView:spv,
					spaceBetween:<?php echo 1 === $spv ? '0' : '24'; ?>,
					loop:totalSlides>spv,
					autoplay:autoplayOpt,
					pagination:<?php echo $dots ? '{el:el.querySelector(\'.swiper-pagination\'),clickable:true}' : 'false'; ?>,
					navigation:<?php echo $arrows ? '{nextEl:el.querySelector(\'.swiper-button-next\'),prevEl:el.querySelector(\'.swiper-button-prev\')}' : 'false'; ?>,
					breakpoints:{
						0:{slidesPerView:1,spaceBetween:16},
						640:{slidesPerView:Math.min(2,spv),spaceBetween:20},
						992:{slidesPerView:spv,spaceBetween:<?php echo 1 === $spv ? '0' : '24'; ?>}
					}
				});
			}
			if(document.readyState==='loading'){document.addEventListener('DOMContentLoaded',initICS);}else{initICS();}
			if(window.elementorFrontend){jQuery(window).on('elementor/frontend/init',function(){elementorFrontend.hooks.addAction('frontend/element_ready/nexus-image-cards-scroller.default',initICS);});}
		})();
		</script>

		<?php
	}

	/**
	 * Standard card — image top, text below in card body.
	 */
	private function render_card_standard( $colors, $aspect, $img_url, $title, $subtitle, $link_url, $target, $show_btn, $btn_style ) {
		?>
		<div class="nexus-ics__card nexus-ics__card--standard" style="overflow:hidden;border-radius:12px;background:<?php echo esc_attr( $colors['card_bg'] ); ?>;box-shadow:0 2px 12px rgba(0,0,0,0.06);transition:transform 0.3s ease,box-shadow 0.3s ease;">
			<?php if ( $img_url ) : ?>
				<div class="nexus-ics__card-thumb" style="overflow:hidden;aspect-ratio:<?php echo esc_attr( $aspect ); ?>;">
					<?php if ( $link_url ) : ?>
						<a href="<?php echo esc_url( $link_url ); ?>" <?php echo $target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> style="display:block;height:100%;">
					<?php endif; ?>
						<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $title ); ?>" style="width:100%;height:100%;object-fit:cover;display:block;transition:transform 0.4s ease;" loading="lazy" />
					<?php if ( $link_url ) : ?>
						</a>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<div class="nexus-ics__card-body" style="padding:1.25rem 1.5rem 1.5rem;">
				<?php if ( $subtitle ) : ?>
					<span style="display:inline-block;font-size:0.75rem;font-weight:600;color:<?php echo esc_attr( $colors['tagline'] ); ?>;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.25rem;">
						<?php echo esc_html( $subtitle ); ?>
					</span>
				<?php endif; ?>

				<?php if ( $title ) : ?>
					<h3 class="nexus-ics__card-title" style="font-size:1.0625rem;font-weight:700;line-height:1.35;margin:0;color:<?php echo esc_attr( $colors['heading'] ); ?>;">
						<?php if ( $link_url ) : ?>
							<a href="<?php echo esc_url( $link_url ); ?>" style="color:inherit;text-decoration:none;" <?php echo $target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $title ); ?></a>
						<?php else : ?>
							<?php echo esc_html( $title ); ?>
						<?php endif; ?>
					</h3>
				<?php endif; ?>

				<?php if ( $show_btn && $link_url ) : ?>
					<a href="<?php echo esc_url( $link_url ); ?>" style="margin-top:0.75rem;<?php echo esc_attr( $this->get_button_inline_style( $btn_style ) ); ?>" <?php echo $target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
						<?php esc_html_e( 'View Project', 'nexus' ); ?>
						<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
					</a>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}

	/**
	 * Overlay card — full image with hover overlay text.
	 */
	private function render_card_overlay( $preset, $colors, $aspect, $img_url, $title, $subtitle, $link_url, $target ) {
		$is_gradient = in_array( $preset, array( 'dark-cinema', 'fullwidth-hero', 'gradient-hover' ), true );
		$radius      = 'rounded-peek' === $preset ? '16px' : ( 'fullwidth-hero' === $preset ? '0' : '12px' );
		?>
		<div class="nexus-ics__card nexus-ics__card--overlay" style="position:relative;overflow:hidden;border-radius:<?php echo esc_attr( $radius ); ?>;aspect-ratio:<?php echo esc_attr( $aspect ); ?>;transition:transform 0.3s ease,box-shadow 0.3s ease;">
			<?php if ( $img_url ) : ?>
				<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $title ); ?>" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;transition:transform 0.5s ease;" loading="lazy" />
			<?php endif; ?>

			<div class="nexus-ics__card-overlay" style="position:absolute;inset:0;<?php echo $is_gradient ? 'background:' . esc_attr( $colors['overlay'] ) . ';' : 'background-color:' . esc_attr( $colors['overlay'] ) . ';'; ?>transition:opacity 0.3s ease;<?php echo 'gradient-hover' !== $preset ? '' : 'opacity:0;'; ?>"></div>

			<div class="nexus-ics__card-content" style="position:absolute;inset:0;display:flex;flex-direction:column;justify-content:flex-end;align-items:flex-start;padding:1.5rem;<?php echo 'gradient-hover' === $preset ? 'opacity:0;transition:opacity 0.3s ease;' : ''; ?>">
				<?php if ( $subtitle ) : ?>
					<span style="font-size:0.75rem;font-weight:600;color:<?php echo esc_attr( $colors['tagline'] ); ?>;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.25rem;">
						<?php echo esc_html( $subtitle ); ?>
					</span>
				<?php endif; ?>

				<?php if ( $title ) : ?>
					<h3 class="nexus-ics__card-title" style="font-size:1.25rem;font-weight:700;line-height:1.3;margin:0;color:#fff;">
						<?php echo esc_html( $title ); ?>
					</h3>
				<?php endif; ?>
			</div>

			<?php if ( $link_url ) : ?>
				<a href="<?php echo esc_url( $link_url ); ?>" class="nexus-ics__card-link" style="position:absolute;inset:0;z-index:2;" <?php echo $target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> aria-label="<?php echo esc_attr( $title ); ?>"></a>
			<?php endif; ?>
		</div>
		<?php
	}

	/**
	 * Caption-below card — image with text underneath (no overlay).
	 */
	private function render_card_caption( $colors, $aspect, $img_url, $title, $subtitle, $link_url, $target, $show_btn, $btn_style ) {
		?>
		<div class="nexus-ics__card nexus-ics__card--caption" style="transition:transform 0.3s ease;">
			<?php if ( $img_url ) : ?>
				<div class="nexus-ics__card-thumb" style="overflow:hidden;border-radius:12px;aspect-ratio:<?php echo esc_attr( $aspect ); ?>;margin-bottom:1rem;">
					<?php if ( $link_url ) : ?>
						<a href="<?php echo esc_url( $link_url ); ?>" <?php echo $target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> style="display:block;height:100%;">
					<?php endif; ?>
						<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $title ); ?>" style="width:100%;height:100%;object-fit:cover;display:block;transition:transform 0.4s ease;" loading="lazy" />
					<?php if ( $link_url ) : ?>
						</a>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<?php if ( $title ) : ?>
				<h3 class="nexus-ics__card-title" style="font-size:1.0625rem;font-weight:700;line-height:1.35;margin:0 0 0.25rem;color:<?php echo esc_attr( $colors['heading'] ); ?>;">
					<?php if ( $link_url ) : ?>
						<a href="<?php echo esc_url( $link_url ); ?>" style="color:inherit;text-decoration:none;" <?php echo $target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $title ); ?></a>
					<?php else : ?>
						<?php echo esc_html( $title ); ?>
					<?php endif; ?>
				</h3>
			<?php endif; ?>

			<?php if ( $subtitle ) : ?>
				<p style="font-size:0.875rem;line-height:1.6;color:<?php echo esc_attr( $colors['text'] ); ?>;margin:0;">
					<?php echo esc_html( $subtitle ); ?>
				</p>
			<?php endif; ?>

			<?php if ( $show_btn && $link_url ) : ?>
				<a href="<?php echo esc_url( $link_url ); ?>" style="margin-top:0.5rem;<?php echo esc_attr( $this->get_button_inline_style( $btn_style ) ); ?>" <?php echo $target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
					<?php esc_html_e( 'Learn More', 'nexus' ); ?>
					<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
				</a>
			<?php endif; ?>
		</div>
		<?php
	}
}
