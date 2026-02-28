<?php
/**
 * Nexus Theme - Elementor CTA Banner Widget
 *
 * Call-to-action banner with 6 style presets, staggered entrance animations,
 * and fully styled inline output that works in both the editor and frontend.
 *
 * @package Nexus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Nexus_Widget_CTA_Banner
 */
class Nexus_Widget_CTA_Banner extends \Elementor\Widget_Base {

	public function get_name() {
		return 'nexus-cta-banner';
	}

	public function get_title() {
		return esc_html__( 'CTA Banner', 'nexus' );
	}

	public function get_icon() {
		return 'eicon-call-to-action';
	}

	public function get_categories() {
		return array( 'nexus-elements' );
	}

	public function get_keywords() {
		return array( 'cta', 'call to action', 'banner', 'button', 'nexus' );
	}

	/**
	 * Returns inline button styles per class.
	 *
	 * @param string $style Button style key.
	 * @return string Inline CSS.
	 */
	private function get_button_inline_style( $style ) {
		$base = 'display:inline-flex;align-items:center;justify-content:center;padding:0.75em 1.75em;font-size:1rem;font-weight:600;line-height:1.5;border-radius:6px;text-decoration:none;border:2px solid transparent;cursor:pointer;transition:all 0.3s ease;';

		$styles = array(
			'primary'       => $base . 'background-color:' . nexus_palette()['secondary'] . ';color:#fff;border-color:' . nexus_palette()['secondary'] . ';',
			'secondary'     => $base . 'background-color:' . nexus_palette()['dark'] . ';color:#fff;border-color:' . nexus_palette()['dark'] . ';',
			'white'         => $base . 'background-color:#fff;color:#667eea;border-color:#fff;',
			'outline'       => $base . 'background-color:transparent;color:' . nexus_palette()['secondary'] . ';border-color:' . nexus_palette()['secondary'] . ';',
			'outline-white' => $base . 'background-color:transparent;color:#fff;border-color:rgba(255,255,255,0.5);',
			'outline-dark'  => $base . 'background-color:transparent;color:' . nexus_palette()['primary'] . ';border-color:' . nexus_palette()['primary'] . ';',
			'ghost'         => $base . 'background-color:transparent;color:inherit;border-color:transparent;',
		);

		return $styles[ $style ] ?? $styles['primary'];
	}

	/**
	 * Returns color map per preset.
	 *
	 * @param string $preset Preset key.
	 * @return array
	 */
	private function get_preset_colors( $preset ) {
		$presets = array(
			'centered-light' => array(
				'bg'      => nexus_palette()['light'],
				'heading' => nexus_palette()['primary'],
				'text'    => '#495057',
				'tagline' => nexus_palette()['secondary'],
				'note'    => '#64748b',
			),
			'centered-dark'  => array(
				'bg'      => nexus_palette()['primary'],
				'heading' => '#ffffff',
				'text'    => '#cbd5e1',
				'tagline' => nexus_palette()['secondary'],
				'note'    => '#64748b',
			),
			'side-by-side'   => array(
				'bg'      => nexus_palette()['light'],
				'heading' => nexus_palette()['primary'],
				'text'    => '#495057',
				'tagline' => nexus_palette()['secondary'],
				'note'    => '',
			),
			'gradient'       => array(
				'bg'      => '',
				'heading' => '#ffffff',
				'text'    => 'rgba(255,255,255,0.85)',
				'tagline' => 'rgba(255,255,255,0.7)',
				'note'    => '',
			),
			'image-overlay'  => array(
				'bg'      => '',
				'heading' => '#ffffff',
				'text'    => 'rgba(255,255,255,0.85)',
				'tagline' => nexus_palette()['secondary'],
				'note'    => '',
			),
			'split-accent'   => array(
				'bg'      => nexus_palette()['primary'],
				'heading' => '#ffffff',
				'text'    => '#94a3b8',
				'tagline' => nexus_palette()['secondary'],
				'note'    => '',
			),
		);

		return $presets[ $preset ] ?? $presets['centered-light'];
	}

	/**
	 * Returns full content + button defaults per preset.
	 *
	 * @param string $preset Preset key.
	 * @return array
	 */
	private function get_preset_defaults( $preset ) {
		$map = array(
			'centered-light' => array(
				'tagline'    => 'Simple & Effective',
				'headline'   => 'Ready to Get Started?',
				'description' => 'Join thousands of satisfied customers and take your business to the next level today.',
				'btn1_text'  => 'Get Started',
				'btn2_text'  => 'Learn More',
				'btn1_style' => 'primary',
				'btn2_style' => 'outline',
				'note_text'  => '',
			),
			'centered-dark'  => array(
				'tagline'    => 'Talk to an Expert',
				'headline'   => 'Let Us Help You Grow Your Business',
				'description' => 'Schedule a free consultation with one of our specialists and discover how we can help you succeed.',
				'btn1_text'  => 'Book a Call',
				'btn2_text'  => 'Send a Message',
				'btn1_style' => 'primary',
				'btn2_style' => 'outline-white',
				'note_text'  => 'No bots — just a real expert ready to talk.',
			),
			'side-by-side'   => array(
				'tagline'    => '',
				'headline'   => 'Ready to Transform Your Business?',
				'description' => 'Get started today and see results within the first week.',
				'btn1_text'  => 'Start Free Trial',
				'btn2_text'  => '',
				'btn1_style' => 'primary',
				'btn2_style' => 'outline',
				'note_text'  => '',
			),
			'gradient'       => array(
				'tagline'    => 'Limited Time Offer',
				'headline'   => 'Get 30% Off Your First Year',
				'description' => 'Sign up now and unlock premium features at an exclusive introductory price.',
				'btn1_text'  => 'Claim Offer',
				'btn2_text'  => 'View Pricing',
				'btn1_style' => 'white',
				'btn2_style' => 'outline-white',
				'note_text'  => '',
			),
			'image-overlay'  => array(
				'tagline'    => 'Join Our Community',
				'headline'   => 'Build Something Amazing Together',
				'description' => 'Connect with thousands of developers, designers, and entrepreneurs building the future.',
				'btn1_text'  => 'Join Now',
				'btn2_text'  => 'Learn More',
				'btn1_style' => 'primary',
				'btn2_style' => 'outline-white',
				'note_text'  => '',
			),
			'split-accent'   => array(
				'tagline'    => 'Need Help?',
				'headline'   => 'Our Team Is Ready to Assist You',
				'description' => 'Reach out to our award-winning support team available 24/7.',
				'btn1_text'  => 'Contact Us',
				'btn2_text'  => 'View FAQ',
				'btn1_style' => 'primary',
				'btn2_style' => 'outline-white',
				'note_text'  => '',
			),
		);

		return $map[ $preset ] ?? $map['centered-light'];
	}

	protected function register_controls() {

		// ---------------------------------------------------------------
		// Style Preset
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
				'default'     => 'centered-light',
				'options'     => array(
					'centered-light' => esc_html__( '1 — Centered Minimal (Light)', 'nexus' ),
					'centered-dark'  => esc_html__( '2 — Centered (Dark)', 'nexus' ),
					'side-by-side'   => esc_html__( '3 — Side by Side', 'nexus' ),
					'gradient'       => esc_html__( '4 — Gradient Background', 'nexus' ),
					'image-overlay'  => esc_html__( '5 — Image + Overlay', 'nexus' ),
					'split-accent'   => esc_html__( '6 — Split with Accent Bar', 'nexus' ),
				),
				'render_type' => 'template',
			)
		);

		$this->add_control(
			'bg_image',
			array(
				'label'     => esc_html__( 'Background Image', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::MEDIA,
				'default'   => array( 'url' => '' ),
				'condition' => array( 'style_preset' => 'image-overlay' ),
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

		// ---------------------------------------------------------------
		// Content
		// ---------------------------------------------------------------
		$this->start_controls_section(
			'section_content',
			array( 'label' => esc_html__( 'Content', 'nexus' ) )
		);

		$this->add_control(
			'tagline',
			array(
				'label'   => esc_html__( 'Tagline', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => '',
				'dynamic' => array( 'active' => true ),
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
				'rows'        => 3,
				'default'     => '',
				'placeholder' => esc_html__( 'Auto-filled from preset', 'nexus' ),
				'dynamic'     => array( 'active' => true ),
			)
		);

		$this->add_control(
			'note_text',
			array(
				'label'       => esc_html__( 'Note Text', 'nexus' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'Auto-filled from preset', 'nexus' ),
				'condition'   => array( 'style_preset' => 'centered-dark' ),
			)
		);

		$this->end_controls_section();

		// ---------------------------------------------------------------
		// Buttons
		// ---------------------------------------------------------------
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

		$this->add_control(
			'btn1_text',
			array(
				'label'       => esc_html__( 'Primary Button Text', 'nexus' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'Auto-filled from preset', 'nexus' ),
			)
		);

		$this->add_control(
			'btn1_link',
			array(
				'label'   => esc_html__( 'Primary Button Link', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::URL,
				'dynamic' => array( 'active' => true ),
			)
		);

		$this->add_control(
			'btn1_style',
			array(
				'label'   => esc_html__( 'Primary Button Style', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'auto',
				'options' => $btn_styles,
			)
		);

		$this->add_control(
			'btn2_heading',
			array(
				'label'     => esc_html__( 'Secondary Button', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'btn2_text',
			array(
				'label'       => esc_html__( 'Secondary Button Text', 'nexus' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'Auto-filled from preset', 'nexus' ),
			)
		);

		$this->add_control(
			'btn2_link',
			array(
				'label'   => esc_html__( 'Secondary Button Link', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::URL,
				'dynamic' => array( 'active' => true ),
			)
		);

		$this->add_control(
			'btn2_style',
			array(
				'label'   => esc_html__( 'Secondary Button Style', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'auto',
				'options' => $btn_styles,
			)
		);

		$this->end_controls_section();

		// ---------------------------------------------------------------
		// STYLE: Overrides
		// ---------------------------------------------------------------
		$this->start_controls_section(
			'section_style_overrides',
			array(
				'label' => esc_html__( 'Style Overrides', 'nexus' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'headline_color',
			array(
				'label'     => esc_html__( 'Headline Color', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .nexus-cta-banner__headline' => 'color: {{VALUE}} !important;',
				),
			)
		);

		$this->add_control(
			'desc_color',
			array(
				'label'     => esc_html__( 'Description Color', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .nexus-cta-banner__desc' => 'color: {{VALUE}} !important;',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'headline_typography',
				'selector' => '{{WRAPPER}} .nexus-cta-banner__headline',
			)
		);

		$this->add_responsive_control(
			'banner_padding',
			array(
				'label'      => esc_html__( 'Padding', 'nexus' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .nexus-cta-banner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$preset   = $settings['style_preset'] ?? 'centered-light';
		$defaults = $this->get_preset_defaults( $preset );
		$colors   = $this->get_preset_colors( $preset );
		$htag     = in_array( $settings['headline_tag'] ?? 'h2', array( 'h1', 'h2', 'h3', 'h4' ), true ) ? $settings['headline_tag'] : 'h2';
		$anim     = $settings['entrance_animation'] ?? 'fadeInUp';
		$is_editor = \Elementor\Plugin::$instance->editor->is_edit_mode();

		// Merge preset defaults: use user value if set, otherwise preset default.
		$tagline     = ! empty( $settings['tagline'] ) ? $settings['tagline'] : $defaults['tagline'];
		$headline    = ! empty( $settings['headline'] ) ? $settings['headline'] : $defaults['headline'];
		$description = ! empty( $settings['description'] ) ? $settings['description'] : $defaults['description'];
		$btn1_text   = ! empty( $settings['btn1_text'] ) ? $settings['btn1_text'] : $defaults['btn1_text'];
		$btn2_text   = ! empty( $settings['btn2_text'] ) ? $settings['btn2_text'] : $defaults['btn2_text'];
		$note_text   = ! empty( $settings['note_text'] ) ? $settings['note_text'] : $defaults['note_text'];

		// Button styles: 'auto' means use preset default.
		$btn1_style_raw = $settings['btn1_style'] ?? 'auto';
		$btn2_style_raw = $settings['btn2_style'] ?? 'auto';
		$btn1_style_key = ( 'auto' === $btn1_style_raw ) ? $defaults['btn1_style'] : $btn1_style_raw;
		$btn2_style_key = ( 'auto' === $btn2_style_raw ) ? $defaults['btn2_style'] : $btn2_style_raw;

		$is_centered   = in_array( $preset, array( 'centered-light', 'centered-dark', 'gradient', 'image-overlay' ), true );
		$is_horizontal = in_array( $preset, array( 'side-by-side', 'split-accent' ), true );

		// In editor, show everything instantly (no animation).
		$has_anim = ( 'none' !== $anim && ! $is_editor );

		// Unique ID for this widget instance.
		$uid = 'nexus-cta-' . $this->get_id();

		// --- Wrapper styles ---
		$wrap_css = 'padding:5rem 2rem;position:relative;overflow:hidden;';
		if ( $colors['bg'] ) {
			$wrap_css .= 'background-color:' . $colors['bg'] . ';';
		}
		if ( 'gradient' === $preset ) {
			$wrap_css .= 'background:linear-gradient(135deg,#667eea,#764ba2);';
		}
		if ( 'image-overlay' === $preset && ! empty( $settings['bg_image']['url'] ) ) {
			$wrap_css .= 'background-image:url(' . esc_url( $settings['bg_image']['url'] ) . ');background-size:cover;background-position:center;';
		}

		// --- Inner styles ---
		$inner_css = 'max-width:1200px;margin:0 auto;position:relative;z-index:1;';
		if ( $is_horizontal ) {
			$inner_css .= 'display:flex;align-items:center;justify-content:space-between;gap:2.5rem;flex-wrap:wrap;';
		}
		if ( 'split-accent' === $preset ) {
			$inner_css .= 'border-left:4px solid ' . nexus_palette()['secondary'] . ';padding-left:2rem;';
		}

		// --- Text container ---
		$text_css = '';
		if ( $is_centered ) {
			$text_css .= 'text-align:center;';
		}
		if ( $is_horizontal ) {
			$text_css .= 'flex:1;';
		}

		// Hidden style for animated elements before they appear.
		$hidden = $has_anim ? 'opacity:0;' : '';
		?>

		<?php if ( $has_anim ) : ?>
			<style>
				@keyframes nexusFadeInUp{from{opacity:0;transform:translateY(30px)}to{opacity:1;transform:translateY(0)}}
				@keyframes nexusFadeInDown{from{opacity:0;transform:translateY(-30px)}to{opacity:1;transform:translateY(0)}}
				@keyframes nexusFadeInLeft{from{opacity:0;transform:translateX(-30px)}to{opacity:1;transform:translateX(0)}}
				@keyframes nexusFadeInRight{from{opacity:0;transform:translateX(30px)}to{opacity:1;transform:translateX(0)}}
				@keyframes nexusZoomIn{from{opacity:0;transform:scale(0.9)}to{opacity:1;transform:scale(1)}}
				.nexus-cta-anim--visible{animation-duration:0.6s;animation-fill-mode:both;animation-timing-function:cubic-bezier(0.25,0.46,0.45,0.94)}
				.nexus-cta-anim--fadeInUp.nexus-cta-anim--visible{animation-name:nexusFadeInUp}
				.nexus-cta-anim--fadeInDown.nexus-cta-anim--visible{animation-name:nexusFadeInDown}
				.nexus-cta-anim--fadeInLeft.nexus-cta-anim--visible{animation-name:nexusFadeInLeft}
				.nexus-cta-anim--fadeInRight.nexus-cta-anim--visible{animation-name:nexusFadeInRight}
				.nexus-cta-anim--zoomIn.nexus-cta-anim--visible{animation-name:nexusZoomIn}
			</style>
		<?php endif; ?>

		<div id="<?php echo esc_attr( $uid ); ?>" class="nexus-cta-banner nexus-cta-banner--<?php echo esc_attr( $preset ); ?>" style="<?php echo esc_attr( $wrap_css ); ?>">

			<?php if ( 'image-overlay' === $preset ) : ?>
				<div style="position:absolute;inset:0;background-color:rgba(26,26,46,0.8);z-index:0;"></div>
			<?php endif; ?>

			<div class="nexus-cta-banner__inner" style="<?php echo esc_attr( $inner_css ); ?>">

				<div class="nexus-cta-banner__text" style="<?php echo esc_attr( $text_css ); ?>">

					<?php if ( $tagline ) : ?>
						<p class="nexus-cta-banner__tagline nexus-cta-anim--<?php echo esc_attr( $anim ); ?>" data-cta-delay="0" style="<?php echo esc_attr( $hidden ); ?>color:<?php echo esc_attr( $colors['tagline'] ); ?>;font-size:0.875rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;margin:0 0 0.5rem;">
							<?php echo esc_html( $tagline ); ?>
						</p>
					<?php endif; ?>

					<?php if ( $headline ) : ?>
						<<?php echo esc_attr( $htag ); ?> class="nexus-cta-banner__headline nexus-cta-anim--<?php echo esc_attr( $anim ); ?>" data-cta-delay="100" style="<?php echo esc_attr( $hidden ); ?>color:<?php echo esc_attr( $colors['heading'] ); ?>;font-size:clamp(1.5rem,3vw,2.5rem);font-weight:700;line-height:1.25;margin:0 0 0.75rem;">
							<?php echo wp_kses_post( $headline ); ?>
						</<?php echo esc_attr( $htag ); ?>>
					<?php endif; ?>

					<?php if ( $description ) : ?>
						<p class="nexus-cta-banner__desc nexus-cta-anim--<?php echo esc_attr( $anim ); ?>" data-cta-delay="200" style="<?php echo esc_attr( $hidden ); ?>color:<?php echo esc_attr( $colors['text'] ); ?>;font-size:1rem;line-height:1.7;margin:0;max-width:560px;<?php echo $is_centered ? 'margin-left:auto;margin-right:auto;' : ''; ?>">
							<?php echo wp_kses_post( $description ); ?>
						</p>
					<?php endif; ?>

					<?php if ( ! $is_horizontal ) : ?>
						<?php $this->render_buttons_with_defaults( $settings, $btn1_text, $btn2_text, $btn1_style_key, $btn2_style_key, $is_centered, $anim, $hidden ); ?>
					<?php endif; ?>

					<?php if ( 'centered-dark' === $preset && $note_text ) : ?>
						<p class="nexus-cta-banner__note nexus-cta-anim--<?php echo esc_attr( $anim ); ?>" data-cta-delay="400" style="<?php echo esc_attr( $hidden ); ?>color:<?php echo esc_attr( $colors['note'] ); ?>;font-size:0.8125rem;margin:1rem 0 0;<?php echo $is_centered ? 'text-align:center;' : ''; ?>">
							<?php echo esc_html( $note_text ); ?>
						</p>
					<?php endif; ?>

				</div>

				<?php if ( $is_horizontal ) : ?>
					<div class="nexus-cta-banner__actions-wrap nexus-cta-anim--<?php echo esc_attr( $anim ); ?>" data-cta-delay="200" style="<?php echo esc_attr( $hidden ); ?>flex-shrink:0;">
						<?php $this->render_buttons_with_defaults( $settings, $btn1_text, $btn2_text, $btn1_style_key, $btn2_style_key, false, 'none', '' ); ?>
					</div>
				<?php endif; ?>

			</div>
		</div>

		<?php if ( $has_anim ) : ?>
			<script>
			(function(){
				var root=document.getElementById('<?php echo esc_js( $uid ); ?>');
				if(!root)return;
				var items=root.querySelectorAll('[data-cta-delay]');
				var obs=new IntersectionObserver(function(entries){
					entries.forEach(function(e){
						if(e.isIntersecting){
							items.forEach(function(el){
								var d=parseInt(el.getAttribute('data-cta-delay'),10)||0;
								setTimeout(function(){
									el.style.opacity='';
									el.classList.add('nexus-cta-anim--visible');
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
	 * Render buttons using resolved text values.
	 *
	 * @param array  $settings       Widget settings (for link data).
	 * @param string $btn1_text      Primary button text.
	 * @param string $btn2_text      Secondary button text.
	 * @param string $btn1_style_key Primary button style key.
	 * @param string $btn2_style_key Secondary button style key.
	 * @param bool   $centered       Whether to center.
	 * @param string $anim           Animation class name.
	 * @param string $hidden         Hidden inline style.
	 */
	private function render_buttons_with_defaults( $settings, $btn1_text, $btn2_text, $btn1_style_key, $btn2_style_key, $centered, $anim = 'none', $hidden = '' ) {
		if ( empty( $btn1_text ) && empty( $btn2_text ) ) {
			return;
		}
		?>
		<div class="nexus-cta-banner__actions nexus-cta-anim--<?php echo esc_attr( $anim ); ?>" data-cta-delay="300" style="<?php echo esc_attr( $hidden ); ?>display:flex;gap:1rem;flex-wrap:wrap;margin-top:1.5rem;<?php echo $centered ? 'justify-content:center;' : ''; ?>">
			<?php if ( $btn1_text ) : ?>
				<?php
				$url    = ! empty( $settings['btn1_link']['url'] ) ? esc_url( $settings['btn1_link']['url'] ) : '#';
				$target = ! empty( $settings['btn1_link']['is_external'] ) ? 'target="_blank" rel="noopener noreferrer"' : '';
				?>
				<a href="<?php echo $url; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>" class="nexus-btn nexus-btn--<?php echo esc_attr( $btn1_style_key ); ?>" style="<?php echo esc_attr( $this->get_button_inline_style( $btn1_style_key ) ); ?>" <?php echo $target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
					<?php echo esc_html( $btn1_text ); ?>
				</a>
			<?php endif; ?>

			<?php if ( $btn2_text ) : ?>
				<?php
				$url    = ! empty( $settings['btn2_link']['url'] ) ? esc_url( $settings['btn2_link']['url'] ) : '#';
				$target = ! empty( $settings['btn2_link']['is_external'] ) ? 'target="_blank" rel="noopener noreferrer"' : '';
				?>
				<a href="<?php echo $url; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>" class="nexus-btn nexus-btn--<?php echo esc_attr( $btn2_style_key ); ?>" style="<?php echo esc_attr( $this->get_button_inline_style( $btn2_style_key ) ); ?>" <?php echo $target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
					<?php echo esc_html( $btn2_text ); ?>
				</a>
			<?php endif; ?>
		</div>
		<?php
	}
}
