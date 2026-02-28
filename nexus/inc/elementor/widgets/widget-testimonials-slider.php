<?php
/**
 * Nexus Theme - Elementor Testimonials Slider Widget
 *
 * Testimonials slider section with 6 style presets.
 * Uses Swiper.js carousel with per-preset content defaults
 * and staggered entrance animations.
 *
 * @package Nexus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Nexus_Widget_Testimonials_Slider
 */
class Nexus_Widget_Testimonials_Slider extends \Elementor\Widget_Base {

	public function get_name() {
		return 'nexus-testimonials-slider';
	}

	public function get_title() {
		return esc_html__( 'Testimonials Slider', 'nexus' );
	}

	public function get_icon() {
		return 'eicon-testimonial-carousel';
	}

	public function get_categories() {
		return array( 'nexus-elements' );
	}

	public function get_keywords() {
		return array( 'testimonial', 'slider', 'carousel', 'review', 'quote', 'nexus' );
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

	/**
	 * Returns color map per preset.
	 *
	 * @param string $preset Preset key.
	 * @return array
	 */
	private function get_preset_colors( $preset ) {
		$presets = array(
			'classic-light'  => array(
				'section_bg' => '#ffffff',
				'card_bg'    => '#ffffff',
				'heading'    => '#1a1a2e',
				'text'       => '#495057',
				'name'       => '#1a1a2e',
				'position'   => '#6c757d',
				'tagline'    => '#e94560',
				'quote'      => 'rgba(233,69,96,0.15)',
				'star'       => '#f5a623',
				'border'     => '#e9ecef',
			),
			'minimal-clean'  => array(
				'section_bg' => '#f8f9fa',
				'card_bg'    => '#ffffff',
				'heading'    => '#1a1a2e',
				'text'       => '#495057',
				'name'       => '#1a1a2e',
				'position'   => '#6c757d',
				'tagline'    => '#e94560',
				'quote'      => 'transparent',
				'star'       => '#f5a623',
				'border'     => '#dee2e6',
			),
			'dark-elegant'   => array(
				'section_bg' => '#1a1a2e',
				'card_bg'    => '#16213e',
				'heading'    => '#ffffff',
				'text'       => '#cbd5e1',
				'name'       => '#ffffff',
				'position'   => '#94a3b8',
				'tagline'    => '#e94560',
				'quote'      => 'rgba(233,69,96,0.25)',
				'star'       => '#f5a623',
				'border'     => 'rgba(255,255,255,0.08)',
			),
			'bubble-speech'  => array(
				'section_bg' => '#ffffff',
				'card_bg'    => '#f0f4f8',
				'heading'    => '#1a1a2e',
				'text'       => '#334155',
				'name'       => '#1a1a2e',
				'position'   => '#64748b',
				'tagline'    => '#0f3460',
				'quote'      => 'transparent',
				'star'       => '#f5a623',
				'border'     => 'transparent',
			),
			'large-quote'    => array(
				'section_bg' => '#f1f5f9',
				'card_bg'    => 'transparent',
				'heading'    => '#1a1a2e',
				'text'       => '#334155',
				'name'       => '#1a1a2e',
				'position'   => '#64748b',
				'tagline'    => '#e94560',
				'quote'      => 'rgba(233,69,96,0.12)',
				'star'       => '#f5a623',
				'border'     => 'transparent',
			),
			'cards-accented' => array(
				'section_bg' => '#0f0f23',
				'card_bg'    => '#161630',
				'heading'    => '#ffffff',
				'text'       => '#e2e8f0',
				'name'       => '#ffffff',
				'position'   => '#94a3b8',
				'tagline'    => '#e94560',
				'quote'      => 'transparent',
				'star'       => '#e94560',
				'border'     => '#e94560',
			),
		);

		return $presets[ $preset ] ?? $presets['classic-light'];
	}

	/**
	 * Returns content defaults per preset.
	 *
	 * @param string $preset Preset key.
	 * @return array
	 */
	private function get_preset_defaults( $preset ) {
		$map = array(
			'classic-light'  => array(
				'tagline'      => 'Testimonials',
				'headline'     => 'What Our Clients Say',
				'description'  => 'Real feedback from real people who have experienced our services.',
				'slides_view'  => 2,
				'show_rating'  => true,
				'show_image'   => true,
				'show_quote'   => true,
				'card_style'   => 'shadow',
			),
			'minimal-clean'  => array(
				'tagline'      => 'Reviews',
				'headline'     => 'Client Feedback',
				'description'  => 'We take pride in delivering results that speak for themselves.',
				'slides_view'  => 3,
				'show_rating'  => true,
				'show_image'   => true,
				'show_quote'   => false,
				'card_style'   => 'bordered',
			),
			'dark-elegant'   => array(
				'tagline'      => 'Testimonials',
				'headline'     => 'Trusted by Industry Leaders',
				'description'  => 'See why top companies choose us for their most important projects.',
				'slides_view'  => 2,
				'show_rating'  => true,
				'show_image'   => true,
				'show_quote'   => true,
				'card_style'   => 'shadow',
			),
			'bubble-speech'  => array(
				'tagline'      => 'Happy Clients',
				'headline'     => 'Words From Our Partners',
				'description'  => '',
				'slides_view'  => 2,
				'show_rating'  => false,
				'show_image'   => true,
				'show_quote'   => false,
				'card_style'   => 'bubble',
			),
			'large-quote'    => array(
				'tagline'      => 'Testimonials',
				'headline'     => 'What People Are Saying',
				'description'  => '',
				'slides_view'  => 1,
				'show_rating'  => true,
				'show_image'   => true,
				'show_quote'   => true,
				'card_style'   => 'large',
			),
			'cards-accented' => array(
				'tagline'      => 'Reviews',
				'headline'     => 'Client Success Stories',
				'description'  => 'From startups to enterprises, hear how we helped them grow.',
				'slides_view'  => 3,
				'show_rating'  => true,
				'show_image'   => false,
				'show_quote'   => false,
				'card_style'   => 'accented',
			),
		);

		return $map[ $preset ] ?? $map['classic-light'];
	}

	/**
	 * Returns inline button styles.
	 *
	 * @param string $style Button style key.
	 * @return string Inline CSS.
	 */
	private function get_button_inline_style( $style ) {
		$btn = 'display:inline-flex;align-items:center;justify-content:center;padding:0.75em 1.75em;font-size:1rem;font-weight:600;line-height:1.5;border-radius:6px;text-decoration:none;border:2px solid transparent;cursor:pointer;transition:all 0.3s ease;';

		$styles = array(
			'primary'       => $btn . 'background-color:#e94560;color:#fff;border-color:#e94560;',
			'secondary'     => $btn . 'background-color:#16213e;color:#fff;border-color:#16213e;',
			'outline'       => $btn . 'background-color:transparent;color:#e94560;border-color:#e94560;',
			'outline-white' => $btn . 'background-color:transparent;color:#fff;border-color:rgba(255,255,255,0.5);',
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
				'default'     => 'classic-light',
				'options'     => array(
					'classic-light'  => esc_html__( '1 — Classic Light', 'nexus' ),
					'minimal-clean'  => esc_html__( '2 — Minimal Clean', 'nexus' ),
					'dark-elegant'   => esc_html__( '3 — Dark Elegant', 'nexus' ),
					'bubble-speech'  => esc_html__( '4 — Bubble Speech', 'nexus' ),
					'large-quote'    => esc_html__( '5 — Large Quote', 'nexus' ),
					'cards-accented' => esc_html__( '6 — Cards Accented', 'nexus' ),
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

		// ---- Testimonials ----
		$this->start_controls_section(
			'section_items',
			array( 'label' => esc_html__( 'Testimonials', 'nexus' ) )
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control( 'author_image', array(
			'label'   => esc_html__( 'Author Image', 'nexus' ),
			'type'    => \Elementor\Controls_Manager::MEDIA,
			'default' => array( 'url' => \Elementor\Utils::get_placeholder_image_src() ),
		) );

		$repeater->add_control( 'author_name', array(
			'label'   => esc_html__( 'Name', 'nexus' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => esc_html__( 'John Smith', 'nexus' ),
			'dynamic' => array( 'active' => true ),
		) );

		$repeater->add_control( 'author_position', array(
			'label'   => esc_html__( 'Position / Company', 'nexus' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => esc_html__( 'CEO at Company', 'nexus' ),
			'dynamic' => array( 'active' => true ),
		) );

		$repeater->add_control( 'rating', array(
			'label'   => esc_html__( 'Rating (1–5)', 'nexus' ),
			'type'    => \Elementor\Controls_Manager::NUMBER,
			'default' => 5,
			'min'     => 1,
			'max'     => 5,
		) );

		$repeater->add_control( 'content', array(
			'label'   => esc_html__( 'Testimonial', 'nexus' ),
			'type'    => \Elementor\Controls_Manager::TEXTAREA,
			'rows'    => 4,
			'default' => esc_html__( 'Working with this team was an absolute pleasure. The results exceeded our expectations and delivered real business value.', 'nexus' ),
			'dynamic' => array( 'active' => true ),
		) );

		$this->add_control( 'testimonials', array(
			'label'       => esc_html__( 'Items', 'nexus' ),
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'default'     => array(
				array(
					'author_name'     => esc_html__( 'Sarah Johnson', 'nexus' ),
					'author_position' => esc_html__( 'Marketing Director, TechCorp', 'nexus' ),
					'rating'          => 5,
					'content'         => esc_html__( 'Exceptional work from start to finish. The attention to detail and commitment to quality made all the difference for our project.', 'nexus' ),
				),
				array(
					'author_name'     => esc_html__( 'Michael Chen', 'nexus' ),
					'author_position' => esc_html__( 'Product Manager, StartupXYZ', 'nexus' ),
					'rating'          => 5,
					'content'         => esc_html__( 'Professional, responsive, and incredibly talented. They turned our vision into reality and exceeded every expectation we had.', 'nexus' ),
				),
				array(
					'author_name'     => esc_html__( 'Emma Williams', 'nexus' ),
					'author_position' => esc_html__( 'Founder & CEO, DesignLab', 'nexus' ),
					'rating'          => 5,
					'content'         => esc_html__( 'Outstanding results and excellent communication throughout. Would highly recommend to anyone looking for quality and professionalism.', 'nexus' ),
				),
				array(
					'author_name'     => esc_html__( 'David Park', 'nexus' ),
					'author_position' => esc_html__( 'CTO, InnovateCo', 'nexus' ),
					'rating'          => 5,
					'content'         => esc_html__( 'They delivered a world-class solution on time and within budget. The team truly understood our needs and delivered beyond expectations.', 'nexus' ),
				),
			),
			'title_field' => '{{{ author_name }}}',
		) );

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
			'default' => '',
		) );

		$this->end_controls_section();

		// ---- Section Button ----
		$this->start_controls_section(
			'section_cta',
			array( 'label' => esc_html__( 'Section Button', 'nexus' ) )
		);

		$this->add_control( 'section_btn_text', array(
			'label'   => esc_html__( 'Button Text', 'nexus' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => '',
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
		$settings = $this->get_settings_for_display();
		$preset   = $settings['style_preset'] ?? 'classic-light';
		$colors   = $this->get_preset_colors( $preset );
		$defaults = $this->get_preset_defaults( $preset );
		$items    = $settings['testimonials'];

		if ( empty( $items ) ) {
			return;
		}

		// Merge defaults.
		$tagline     = ( '' !== $settings['tagline'] ) ? $settings['tagline'] : ( $defaults['tagline'] ?? '' );
		$headline    = ( '' !== $settings['headline'] ) ? $settings['headline'] : ( $defaults['headline'] ?? '' );
		$description = ( '' !== $settings['description'] ) ? $settings['description'] : ( $defaults['description'] ?? '' );
		$show_rating = $defaults['show_rating'];
		$show_image  = $defaults['show_image'];
		$show_quote  = $defaults['show_quote'];
		$card_style  = $defaults['card_style'];
		$spv         = absint( $defaults['slides_view'] );
		$dots        = 'yes' === $settings['show_dots'];
		$arrows      = 'yes' === $settings['show_arrows'];
		$animation   = $settings['entrance_animation'] ?? 'fadeInUp';
		$is_editor   = \Elementor\Plugin::$instance->editor->is_edit_mode();
		$widget_id   = 'nexus-ts-' . $this->get_id();

		// Section button.
		$btn_text = $settings['section_btn_text'] ?? '';
		$btn_url  = $settings['section_btn_url']['url'] ?? '';
		$btn_tgt  = ! empty( $settings['section_btn_url']['is_external'] ) ? ' target="_blank"' : '';
		$btn_rel  = ! empty( $settings['section_btn_url']['nofollow'] ) ? ' rel="nofollow"' : '';
		?>

		<section
			class="nexus-ts nexus-ts--<?php echo esc_attr( $preset ); ?>"
			style="background-color:<?php echo esc_attr( $colors['section_bg'] ); ?>;padding:5rem 0;"
		>
			<div class="nexus-container">

				<?php // Section header. ?>
				<?php if ( $tagline || $headline || $description ) : ?>
				<div class="nexus-ts__header" style="text-align:center;margin-bottom:3rem;max-width:680px;margin-left:auto;margin-right:auto;">
					<?php if ( $tagline ) : ?>
						<span class="nexus-ts__tagline" style="display:inline-block;font-size:0.875rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:<?php echo esc_attr( $colors['tagline'] ); ?>;margin-bottom:0.75rem;">
							<?php echo esc_html( $tagline ); ?>
						</span>
					<?php endif; ?>
					<?php if ( $headline ) : ?>
						<h2 class="nexus-ts__title" style="font-size:clamp(1.5rem,3vw,2.25rem);font-weight:700;color:<?php echo esc_attr( $colors['heading'] ); ?>;margin:0 0 1rem;">
							<?php echo wp_kses_post( $headline ); ?>
						</h2>
					<?php endif; ?>
					<?php if ( $description ) : ?>
						<p class="nexus-ts__desc" style="font-size:1.0625rem;line-height:1.7;color:<?php echo esc_attr( $colors['text'] ); ?>;margin:0;">
							<?php echo wp_kses_post( $description ); ?>
						</p>
					<?php endif; ?>
				</div>
				<?php endif; ?>

				<?php // Slider. ?>
				<div class="nexus-ts__slider swiper" id="<?php echo esc_attr( $widget_id ); ?>" style="overflow:hidden;">
					<div class="swiper-wrapper">
						<?php
						foreach ( $items as $idx => $item ) :
							$delay = $idx * 120;
							?>
							<div class="swiper-slide">
								<?php $this->render_card( $item, $colors, $card_style, $show_rating, $show_image, $show_quote, $animation, $delay, $is_editor ); ?>
							</div>
						<?php endforeach; ?>
					</div>

					<?php if ( $dots ) : ?>
						<div class="swiper-pagination nexus-ts__dots"></div>
					<?php endif; ?>

					<?php if ( $arrows ) : ?>
						<button class="swiper-button-prev nexus-ts__arrow nexus-ts__arrow--prev" aria-label="<?php esc_attr_e( 'Previous', 'nexus' ); ?>"></button>
						<button class="swiper-button-next nexus-ts__arrow nexus-ts__arrow--next" aria-label="<?php esc_attr_e( 'Next', 'nexus' ); ?>"></button>
					<?php endif; ?>
				</div>

				<?php // Section button. ?>
				<?php if ( $btn_text && $btn_url ) : ?>
				<div class="nexus-ts__footer" style="text-align:center;margin-top:2.5rem;">
					<a href="<?php echo esc_url( $btn_url ); ?>"<?php echo $btn_tgt . $btn_rel; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> class="nexus-ts__section-btn" style="<?php echo esc_attr( $this->get_button_inline_style( $settings['section_btn_style'] ?? 'primary' ) ); ?>">
						<?php echo esc_html( $btn_text ); ?>
					</a>
				</div>
				<?php endif; ?>

			</div>
		</section>

		<script>
		(function(){
			var wid='<?php echo esc_js( $widget_id ); ?>';
			function initTS(){
				var el=document.getElementById(wid);
				if(!el)return;
				if(!window.Swiper){setTimeout(initTS,100);return;}
				if(el.swiper)el.swiper.destroy(true,true);
				var autoplayOpt=<?php echo 'yes' === $settings['autoplay'] ? '{delay:' . absint( $settings['autoplay_speed'] ) . ',disableOnInteraction:false}' : 'false'; ?>;
				var totalSlides=el.querySelectorAll('.swiper-slide').length;
				var spv=<?php echo esc_js( $spv ); ?>;
				new Swiper(el,{
					slidesPerView:spv,
					spaceBetween:24,
					loop:totalSlides>spv,
					autoplay:autoplayOpt,
					pagination:<?php echo $dots ? '{el:el.querySelector(\'.swiper-pagination\'),clickable:true}' : 'false'; ?>,
					navigation:<?php echo $arrows ? '{nextEl:el.querySelector(\'.swiper-button-next\'),prevEl:el.querySelector(\'.swiper-button-prev\')}' : 'false'; ?>,
					breakpoints:{
						0:{slidesPerView:1,spaceBetween:16},
						768:{slidesPerView:Math.min(2,spv),spaceBetween:20},
						992:{slidesPerView:spv,spaceBetween:24}
					}
				});
			}
			if(document.readyState==='loading'){document.addEventListener('DOMContentLoaded',initTS);}else{initTS();}
			if(window.elementorFrontend){jQuery(window).on('elementor/frontend/init',function(){elementorFrontend.hooks.addAction('frontend/element_ready/nexus-testimonials-slider.default',initTS);});}
		})();
		</script>

		<?php if ( 'none' !== $animation && ! $is_editor ) : ?>
		<script>
		(function(){
			var container=document.getElementById('<?php echo esc_js( $widget_id ); ?>');
			if(!container)return;
			var cards=container.querySelectorAll('.nexus-ts__card[data-ts-delay]');
			if(!cards.length)return;
			var io=new IntersectionObserver(function(entries){
				entries.forEach(function(e){
					if(e.isIntersecting){
						var d=parseInt(e.target.getAttribute('data-ts-delay'),10)||0;
						setTimeout(function(){e.target.classList.add('is-visible');},d);
						io.unobserve(e.target);
					}
				});
			},{threshold:0.15});
			cards.forEach(function(c){io.observe(c);});
		})();
		</script>
		<?php endif; ?>

		<?php
	}

	/**
	 * Renders a single testimonial card.
	 *
	 * @param array  $item        Repeater item data.
	 * @param array  $colors      Preset color map.
	 * @param string $card_style  Card style: shadow|bordered|bubble|large|accented.
	 * @param bool   $show_rating Show star rating.
	 * @param bool   $show_image  Show author avatar.
	 * @param bool   $show_quote  Show quote icon.
	 * @param string $animation   Animation class.
	 * @param int    $delay       Stagger delay ms.
	 * @param bool   $is_editor   Whether in Elementor editor.
	 */
	private function render_card( $item, $colors, $card_style, $show_rating, $show_image, $show_quote, $animation, $delay, $is_editor ) {
		$anim_class = ( 'none' !== $animation && ! $is_editor ) ? ' nexus-ts__card--anim' : '';
		$vis_class  = $is_editor ? ' is-visible' : '';

		// Card inline styles.
		$card_css = 'background:' . $colors['card_bg'] . ';';
		if ( 'bordered' === $card_style ) {
			$card_css .= 'border:1px solid ' . $colors['border'] . ';border-radius:12px;padding:2rem;';
		} elseif ( 'shadow' === $card_style ) {
			$card_css .= 'border-radius:12px;padding:2rem;box-shadow:0 4px 20px rgba(0,0,0,0.06);';
		} elseif ( 'bubble' === $card_style ) {
			$card_css .= 'border-radius:16px;padding:2rem;position:relative;';
		} elseif ( 'large' === $card_style ) {
			$card_css .= 'padding:3rem 2rem;text-align:center;max-width:800px;margin:0 auto;';
		} elseif ( 'accented' === $card_style ) {
			$card_css .= 'border-left:3px solid ' . $colors['border'] . ';border-radius:8px;padding:1.75rem 2rem;';
		}
		?>

		<div
			class="nexus-ts__card nexus-ts__card--<?php echo esc_attr( $card_style ); ?><?php echo esc_attr( $anim_class . $vis_class ); ?>"
			style="<?php echo esc_attr( $card_css ); ?>"
			<?php if ( 'none' !== $animation && ! $is_editor ) : ?>
				data-ts-delay="<?php echo esc_attr( $delay ); ?>"
			<?php endif; ?>
		>

			<?php if ( $show_quote ) : ?>
				<div class="nexus-ts__quote" style="font-size:3.5rem;line-height:0.75;color:<?php echo esc_attr( $colors['quote'] ); ?>;font-family:Georgia,serif;margin-bottom:0.75rem;" aria-hidden="true">&#8220;</div>
			<?php endif; ?>

			<?php if ( $show_rating && ! empty( $item['rating'] ) ) : ?>
				<div class="nexus-ts__stars" style="display:flex;gap:0.15rem;margin-bottom:0.75rem;" aria-label="<?php /* translators: %d: rating. */ echo esc_attr( sprintf( __( '%d out of 5 stars', 'nexus' ), absint( $item['rating'] ) ) ); ?>">
					<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
						<span style="color:<?php echo $i <= absint( $item['rating'] ) ? esc_attr( $colors['star'] ) : 'rgba(0,0,0,0.15)'; ?>;font-size:0.9375rem;" aria-hidden="true">&#9733;</span>
					<?php endfor; ?>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $item['content'] ) ) : ?>
				<p class="nexus-ts__text" style="font-size:<?php echo 'large' === $card_style ? '1.25rem' : '0.9375rem'; ?>;line-height:1.75;color:<?php echo esc_attr( $colors['text'] ); ?>;margin:0 0 1.5rem;<?php echo 'large' === $card_style ? 'font-style:italic;' : ''; ?>">
					<?php echo wp_kses_post( $item['content'] ); ?>
				</p>
			<?php endif; ?>

			<div class="nexus-ts__author" style="display:flex;align-items:center;gap:0.875rem;<?php echo 'large' === $card_style ? 'justify-content:center;' : ''; ?>">
				<?php if ( $show_image && ! empty( $item['author_image']['url'] ) ) : ?>
					<div class="nexus-ts__avatar">
						<img
							src="<?php echo esc_url( $item['author_image']['url'] ); ?>"
							alt="<?php echo esc_attr( $item['author_name'] ?? '' ); ?>"
							style="width:<?php echo 'large' === $card_style ? '64px' : '48px'; ?>;height:<?php echo 'large' === $card_style ? '64px' : '48px'; ?>;border-radius:50%;object-fit:cover;"
							loading="lazy"
						>
					</div>
				<?php endif; ?>
				<div class="nexus-ts__info">
					<?php if ( ! empty( $item['author_name'] ) ) : ?>
						<span class="nexus-ts__name" style="display:block;font-weight:700;font-size:0.9375rem;color:<?php echo esc_attr( $colors['name'] ); ?>;"><?php echo esc_html( $item['author_name'] ); ?></span>
					<?php endif; ?>
					<?php if ( ! empty( $item['author_position'] ) ) : ?>
						<span class="nexus-ts__position" style="display:block;font-size:0.8125rem;color:<?php echo esc_attr( $colors['position'] ); ?>;"><?php echo esc_html( $item['author_position'] ); ?></span>
					<?php endif; ?>
				</div>
			</div>

		</div>

		<?php
	}
}
