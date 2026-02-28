<?php
/**
 * Nexus Theme - Elementor Team Grid Widget
 *
 * Team member grid section with 6 style presets.
 * Uses repeater for manual members with social links
 * and staggered entrance animations.
 *
 * @package Nexus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Nexus_Widget_Team_Grid
 */
class Nexus_Widget_Team_Grid extends \Elementor\Widget_Base {

	public function get_name() {
		return 'nexus-team-grid';
	}

	public function get_title() {
		return esc_html__( 'Team Grid', 'nexus' );
	}

	public function get_icon() {
		return 'eicon-person';
	}

	public function get_categories() {
		return array( 'nexus-elements' );
	}

	public function get_keywords() {
		return array( 'team', 'grid', 'members', 'staff', 'people', 'about', 'nexus' );
	}

	// -----------------------------------------------------------------
	// Preset data
	// -----------------------------------------------------------------

	private function get_preset_colors( $preset ) {
		$presets = array(
			'clean-cards'    => array(
				'section_bg' => '#ffffff',
				'card_bg'    => '#ffffff',
				'heading'    => '#1a1a2e',
				'text'       => '#495057',
				'name'       => '#1a1a2e',
				'position'   => '#6c757d',
				'tagline'    => '#e94560',
				'social'     => '#6c757d',
				'social_hov' => '#e94560',
				'overlay'    => 'rgba(233,69,96,0.9)',
			),
			'rounded-photo'  => array(
				'section_bg' => '#f8f9fa',
				'card_bg'    => '#ffffff',
				'heading'    => '#1a1a2e',
				'text'       => '#495057',
				'name'       => '#1a1a2e',
				'position'   => '#6c757d',
				'tagline'    => '#e94560',
				'social'     => '#6c757d',
				'social_hov' => '#e94560',
				'overlay'    => 'transparent',
			),
			'dark-overlay'   => array(
				'section_bg' => '#0f0f23',
				'card_bg'    => 'transparent',
				'heading'    => '#ffffff',
				'text'       => '#cbd5e1',
				'name'       => '#ffffff',
				'position'   => '#94a3b8',
				'tagline'    => '#e94560',
				'social'     => 'rgba(255,255,255,0.6)',
				'social_hov' => '#e94560',
				'overlay'    => 'rgba(0,0,0,0.7)',
			),
			'minimal-row'    => array(
				'section_bg' => '#ffffff',
				'card_bg'    => 'transparent',
				'heading'    => '#1a1a2e',
				'text'       => '#495057',
				'name'       => '#1a1a2e',
				'position'   => '#6c757d',
				'tagline'    => '#0f3460',
				'social'     => '#6c757d',
				'social_hov' => '#0f3460',
				'overlay'    => 'transparent',
			),
			'bordered-hover' => array(
				'section_bg' => '#f1f5f9',
				'card_bg'    => '#ffffff',
				'heading'    => '#1a1a2e',
				'text'       => '#495057',
				'name'       => '#1a1a2e',
				'position'   => '#6c757d',
				'tagline'    => '#e94560',
				'social'     => '#6c757d',
				'social_hov' => '#e94560',
				'overlay'    => 'transparent',
			),
			'accent-bottom'  => array(
				'section_bg' => '#1a1a2e',
				'card_bg'    => '#16213e',
				'heading'    => '#ffffff',
				'text'       => '#cbd5e1',
				'name'       => '#ffffff',
				'position'   => '#94a3b8',
				'tagline'    => '#e94560',
				'social'     => 'rgba(255,255,255,0.5)',
				'social_hov' => '#e94560',
				'overlay'    => 'transparent',
			),
		);

		return $presets[ $preset ] ?? $presets['clean-cards'];
	}

	private function get_preset_defaults( $preset ) {
		$map = array(
			'clean-cards'    => array(
				'tagline'     => 'Our Team',
				'headline'    => 'Meet the Experts',
				'description' => 'The talented people behind every successful project.',
				'columns'     => 4,
				'card_style'  => 'card-overlay',
				'show_bio'    => false,
				'photo_shape' => 'square',
				'members'     => array(
					array( 'name' => 'Sarah Johnson', 'position' => 'Creative Director', 'linkedin' => '#', 'twitter' => '#' ),
					array( 'name' => 'Michael Chen', 'position' => 'Lead Developer', 'linkedin' => '#', 'twitter' => '#' ),
					array( 'name' => 'Emily Davis', 'position' => 'UX Strategist', 'linkedin' => '#', 'instagram' => '#' ),
					array( 'name' => 'James Wilson', 'position' => 'Project Manager', 'linkedin' => '#', 'twitter' => '#' ),
				),
			),
			'rounded-photo'  => array(
				'tagline'     => 'Leadership',
				'headline'    => 'Our Leadership Team',
				'description' => 'Experienced professionals driving our vision forward.',
				'columns'     => 3,
				'card_style'  => 'circle-center',
				'show_bio'    => true,
				'photo_shape' => 'circle',
				'members'     => array(
					array( 'name' => 'Anna Martinez', 'position' => 'CEO & Founder', 'bio' => 'With 15+ years of experience in digital strategy and business development.', 'linkedin' => '#' ),
					array( 'name' => 'David Kim', 'position' => 'CTO', 'bio' => 'Full-stack architect with a passion for scalable cloud solutions.', 'linkedin' => '#' ),
					array( 'name' => 'Rachel Stone', 'position' => 'VP of Design', 'bio' => 'Award-winning designer focused on user-centered experiences.', 'linkedin' => '#' ),
				),
			),
			'dark-overlay'   => array(
				'tagline'     => 'The Team',
				'headline'    => 'Creative Minds',
				'description' => '',
				'columns'     => 4,
				'card_style'  => 'hover-overlay',
				'show_bio'    => false,
				'photo_shape' => 'square',
				'members'     => array(
					array( 'name' => 'Lucas Rivera', 'position' => 'Art Director', 'instagram' => '#' ),
					array( 'name' => 'Sophie Turner', 'position' => 'UI Designer', 'instagram' => '#' ),
					array( 'name' => 'Ethan Park', 'position' => 'Motion Designer', 'instagram' => '#' ),
					array( 'name' => 'Olivia Brown', 'position' => 'Illustrator', 'instagram' => '#' ),
				),
			),
			'minimal-row'    => array(
				'tagline'     => 'Who We Are',
				'headline'    => 'Our Core Team',
				'description' => 'Small team, big results. Each member brings unique expertise.',
				'columns'     => 2,
				'card_style'  => 'horizontal',
				'show_bio'    => true,
				'photo_shape' => 'circle',
				'members'     => array(
					array( 'name' => 'Mark Thompson', 'position' => 'Founder & CEO', 'bio' => 'Visionary leader with 20 years in tech.', 'linkedin' => '#', 'twitter' => '#' ),
					array( 'name' => 'Lisa Chang', 'position' => 'Head of Engineering', 'bio' => 'Systems architect and open-source contributor.', 'linkedin' => '#' ),
					array( 'name' => 'Alex Novak', 'position' => 'Head of Design', 'bio' => 'Design thinking evangelist and mentor.', 'linkedin' => '#', 'twitter' => '#' ),
					array( 'name' => 'Priya Sharma', 'position' => 'Head of Marketing', 'bio' => 'Growth strategist and brand storyteller.', 'linkedin' => '#' ),
				),
			),
			'bordered-hover' => array(
				'tagline'     => 'Team',
				'headline'    => 'People Behind the Work',
				'description' => 'Meet the passionate individuals who make it all happen.',
				'columns'     => 4,
				'card_style'  => 'bordered',
				'show_bio'    => false,
				'photo_shape' => 'rounded',
				'members'     => array(
					array( 'name' => 'Chris Walker', 'position' => 'Frontend Developer', 'linkedin' => '#' ),
					array( 'name' => 'Nina Patel', 'position' => 'Backend Developer', 'linkedin' => '#' ),
					array( 'name' => 'Tom Fischer', 'position' => 'DevOps Engineer', 'linkedin' => '#' ),
					array( 'name' => 'Amy Lewis', 'position' => 'QA Engineer', 'linkedin' => '#' ),
				),
			),
			'accent-bottom'  => array(
				'tagline'     => 'About Us',
				'headline'    => 'The Dreamers & Doers',
				'description' => 'United by passion, driven by excellence.',
				'columns'     => 3,
				'card_style'  => 'accent-bar',
				'show_bio'    => true,
				'photo_shape' => 'square',
				'members'     => array(
					array( 'name' => 'Jordan Blake', 'position' => 'Product Manager', 'bio' => 'Bridging the gap between vision and execution.', 'linkedin' => '#', 'twitter' => '#' ),
					array( 'name' => 'Mia Anderson', 'position' => 'Content Strategist', 'bio' => 'Crafting narratives that resonate and convert.', 'linkedin' => '#' ),
					array( 'name' => 'Ryan Cooper', 'position' => 'Growth Hacker', 'bio' => 'Data-driven marketer focused on rapid scaling.', 'linkedin' => '#', 'twitter' => '#' ),
				),
			),
		);

		return $map[ $preset ] ?? $map['clean-cards'];
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
					'clean-cards'    => esc_html__( '1 — Clean Cards', 'nexus' ),
					'rounded-photo'  => esc_html__( '2 — Rounded Photo', 'nexus' ),
					'dark-overlay'   => esc_html__( '3 — Dark Overlay', 'nexus' ),
					'minimal-row'    => esc_html__( '4 — Minimal Row', 'nexus' ),
					'bordered-hover' => esc_html__( '5 — Bordered Hover', 'nexus' ),
					'accent-bottom'  => esc_html__( '6 — Accent Bottom', 'nexus' ),
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

		// ---- Team Members (Repeater) ----
		$this->start_controls_section(
			'section_members',
			array( 'label' => esc_html__( 'Team Members', 'nexus' ) )
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control( 'photo', array(
			'label'   => esc_html__( 'Photo', 'nexus' ),
			'type'    => \Elementor\Controls_Manager::MEDIA,
			'default' => array( 'url' => \Elementor\Utils::get_placeholder_image_src() ),
		) );

		$repeater->add_control( 'name', array(
			'label'   => esc_html__( 'Name', 'nexus' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => esc_html__( 'Team Member', 'nexus' ),
			'dynamic' => array( 'active' => true ),
		) );

		$repeater->add_control( 'position', array(
			'label'   => esc_html__( 'Position / Role', 'nexus' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => esc_html__( 'Designer', 'nexus' ),
			'dynamic' => array( 'active' => true ),
		) );

		$repeater->add_control( 'bio', array(
			'label'   => esc_html__( 'Short Bio', 'nexus' ),
			'type'    => \Elementor\Controls_Manager::TEXTAREA,
			'rows'    => 2,
			'default' => '',
			'dynamic' => array( 'active' => true ),
		) );

		$repeater->add_control( 'link', array(
			'label'   => esc_html__( 'Profile Link', 'nexus' ),
			'type'    => \Elementor\Controls_Manager::URL,
			'dynamic' => array( 'active' => true ),
		) );

		$repeater->add_control( 'social_sep', array(
			'label' => esc_html__( 'Social Links', 'nexus' ),
			'type'  => \Elementor\Controls_Manager::HEADING,
			'separator' => 'before',
		) );

		$repeater->add_control( 'social_linkedin', array(
			'label'       => esc_html__( 'LinkedIn URL', 'nexus' ),
			'type'        => \Elementor\Controls_Manager::URL,
			'placeholder' => 'https://linkedin.com/in/...',
		) );

		$repeater->add_control( 'social_twitter', array(
			'label'       => esc_html__( 'X / Twitter URL', 'nexus' ),
			'type'        => \Elementor\Controls_Manager::URL,
			'placeholder' => 'https://x.com/...',
		) );

		$repeater->add_control( 'social_instagram', array(
			'label'       => esc_html__( 'Instagram URL', 'nexus' ),
			'type'        => \Elementor\Controls_Manager::URL,
			'placeholder' => 'https://instagram.com/...',
		) );

		$repeater->add_control( 'social_email', array(
			'label'       => esc_html__( 'Email', 'nexus' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'placeholder' => 'name@example.com',
		) );

		$this->add_control(
			'members',
			array(
				'label'       => esc_html__( 'Members', 'nexus' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(),
				'title_field' => '{{{ name }}}',
			)
		);

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
			'placeholder' => esc_html__( 'e.g. View Full Team', 'nexus' ),
		) );

		$this->add_control( 'section_btn_url', array(
			'label'       => esc_html__( 'Button URL', 'nexus' ),
			'type'        => \Elementor\Controls_Manager::URL,
			'placeholder' => 'https://example.com',
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
		$animation = $settings['entrance_animation'] ?? 'fadeInUp';
		$is_editor = \Elementor\Plugin::$instance->editor->is_edit_mode();
		$widget_id = 'nexus-tg-' . $this->get_id();

		// Merge defaults.
		$tagline     = ( '' !== $settings['tagline'] ) ? $settings['tagline'] : ( $defaults['tagline'] ?? '' );
		$headline    = ( '' !== $settings['headline'] ) ? $settings['headline'] : ( $defaults['headline'] ?? '' );
		$description = ( '' !== $settings['description'] ) ? $settings['description'] : ( $defaults['description'] ?? '' );
		$card_style  = $defaults['card_style'];
		$columns     = $defaults['columns'];
		$show_bio    = $defaults['show_bio'];
		$photo_shape = $defaults['photo_shape'];

		// Members: use repeater or fallback to preset defaults.
		$members = $settings['members'] ?? array();
		if ( empty( $members ) ) {
			$placeholder = \Elementor\Utils::get_placeholder_image_src();
			foreach ( $defaults['members'] as $dm ) {
				$member = array(
					'photo'    => array( 'url' => $placeholder ),
					'name'     => $dm['name'],
					'position' => $dm['position'],
					'bio'      => $dm['bio'] ?? '',
					'link'     => array( 'url' => '' ),
				);
				// Map social from preset defaults.
				foreach ( array( 'linkedin', 'twitter', 'instagram', 'email' ) as $social ) {
					if ( ! empty( $dm[ $social ] ) ) {
						$member[ 'social_' . $social ] = array( 'url' => $dm[ $social ] );
					}
				}
				$members[] = $member;
			}
		}

		if ( empty( $members ) ) {
			return;
		}

		$btn_text = $settings['section_btn_text'] ?? '';
		$btn_url  = $settings['section_btn_url']['url'] ?? '';
		$btn_tgt  = ! empty( $settings['section_btn_url']['is_external'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';

		$is_horizontal = ( 'horizontal' === $card_style );
		$grid_css      = $is_horizontal
			? 'display:grid;grid-template-columns:repeat(' . $columns . ',1fr);gap:2rem;'
			: 'display:grid;grid-template-columns:repeat(' . $columns . ',1fr);gap:2rem;';
		?>

		<section
			class="nexus-tg nexus-tg--<?php echo esc_attr( $preset ); ?>"
			style="background-color:<?php echo esc_attr( $colors['section_bg'] ); ?>;padding:5rem 0;"
			id="<?php echo esc_attr( $widget_id ); ?>"
		>
			<div class="nexus-container">

				<?php if ( $tagline || $headline || $description ) : ?>
				<div class="nexus-tg__header" style="text-align:center;margin-bottom:3rem;max-width:680px;margin-left:auto;margin-right:auto;">
					<?php if ( $tagline ) : ?>
						<span class="nexus-tg__tagline" style="display:inline-block;font-size:0.875rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:<?php echo esc_attr( $colors['tagline'] ); ?>;margin-bottom:0.75rem;">
							<?php echo esc_html( $tagline ); ?>
						</span>
					<?php endif; ?>
					<?php if ( $headline ) : ?>
						<h2 class="nexus-tg__title" style="font-size:clamp(1.5rem,3vw,2.25rem);font-weight:700;color:<?php echo esc_attr( $colors['heading'] ); ?>;margin:0 0 1rem;">
							<?php echo wp_kses_post( $headline ); ?>
						</h2>
					<?php endif; ?>
					<?php if ( $description ) : ?>
						<p class="nexus-tg__desc" style="font-size:1.0625rem;line-height:1.7;color:<?php echo esc_attr( $colors['text'] ); ?>;margin:0;">
							<?php echo wp_kses_post( $description ); ?>
						</p>
					<?php endif; ?>
				</div>
				<?php endif; ?>

				<div class="nexus-tg__grid" style="<?php echo esc_attr( $grid_css ); ?>">
					<?php foreach ( $members as $idx => $member ) : ?>
						<?php
						$delay     = $idx * 100;
						$anim_cls  = ( 'none' !== $animation && ! $is_editor ) ? 'nexus-tg__card--anim' : 'is-visible';
						$anim_attr = ( 'none' !== $animation && ! $is_editor ) ? ' data-tg-delay="' . esc_attr( $delay ) . '"' : '';
						$name      = $member['name'] ?? '';
						$position  = $member['position'] ?? '';
						$bio       = $member['bio'] ?? '';
						$photo_url = ! empty( $member['photo']['url'] ) ? $member['photo']['url'] : \Elementor\Utils::get_placeholder_image_src();
						$link_url  = ! empty( $member['link']['url'] ) ? $member['link']['url'] : '';
						$link_tgt  = ! empty( $member['link']['is_external'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';
						?>

						<?php if ( 'horizontal' === $card_style ) : ?>
							<?php $this->render_horizontal( $member, $colors, $name, $position, $bio, $photo_url, $link_url, $link_tgt, $show_bio, $anim_cls, $anim_attr ); ?>
						<?php elseif ( 'hover-overlay' === $card_style ) : ?>
							<?php $this->render_hover_overlay( $member, $colors, $name, $position, $photo_url, $anim_cls, $anim_attr ); ?>
						<?php elseif ( 'card-overlay' === $card_style ) : ?>
							<?php $this->render_card_overlay( $member, $colors, $name, $position, $photo_url, $link_url, $link_tgt, $anim_cls, $anim_attr ); ?>
						<?php elseif ( 'circle-center' === $card_style ) : ?>
							<?php $this->render_circle_center( $member, $colors, $name, $position, $bio, $photo_url, $link_url, $link_tgt, $show_bio, $anim_cls, $anim_attr ); ?>
						<?php elseif ( 'bordered' === $card_style ) : ?>
							<?php $this->render_bordered( $member, $colors, $name, $position, $photo_url, $photo_shape, $link_url, $link_tgt, $anim_cls, $anim_attr ); ?>
						<?php elseif ( 'accent-bar' === $card_style ) : ?>
							<?php $this->render_accent_bar( $member, $colors, $name, $position, $bio, $photo_url, $link_url, $link_tgt, $show_bio, $anim_cls, $anim_attr ); ?>
						<?php endif; ?>

					<?php endforeach; ?>
				</div>

				<?php if ( $btn_text && $btn_url ) : ?>
				<div class="nexus-tg__footer" style="text-align:center;margin-top:2.5rem;">
					<a href="<?php echo esc_url( $btn_url ); ?>"<?php echo $btn_tgt; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> class="nexus-tg__btn" style="display:inline-flex;align-items:center;justify-content:center;padding:0.75em 2em;font-size:1rem;font-weight:600;border-radius:6px;text-decoration:none;background-color:<?php echo esc_attr( $colors['tagline'] ); ?>;color:#fff;transition:all 0.3s ease;">
						<?php echo esc_html( $btn_text ); ?>
					</a>
				</div>
				<?php endif; ?>

			</div>
		</section>

		<?php if ( 'none' !== $animation && ! $is_editor ) : ?>
		<script>
		(function(){
			var container=document.getElementById('<?php echo esc_js( $widget_id ); ?>');
			if(!container)return;
			var items=container.querySelectorAll('.nexus-tg__card--anim');
			if(!items.length)return;
			var io=new IntersectionObserver(function(entries){
				entries.forEach(function(e){
					if(e.isIntersecting){
						var d=parseInt(e.target.getAttribute('data-tg-delay'),10)||0;
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

	// -----------------------------------------------------------------
	// Social icons helper
	// -----------------------------------------------------------------

	private function render_social_icons( $member, $colors ) {
		$socials = array(
			'linkedin'  => '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>',
			'twitter'   => '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>',
			'instagram' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>',
			'email'     => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>',
		);

		$has_any = false;
		foreach ( array( 'linkedin', 'twitter', 'instagram', 'email' ) as $key ) {
			if ( ! empty( $member[ 'social_' . $key ]['url'] ) || ( 'email' === $key && ! empty( $member['social_email'] ) && is_string( $member['social_email'] ) ) ) {
				$has_any = true;
				break;
			}
		}
		if ( ! $has_any ) {
			return;
		}

		echo '<div class="nexus-tg__social" style="display:flex;gap:0.5rem;align-items:center;">';
		foreach ( $socials as $key => $svg ) {
			$url = '';
			if ( 'email' === $key ) {
				// Email can be stored as string or URL array.
				if ( ! empty( $member['social_email'] ) && is_string( $member['social_email'] ) ) {
					$url = $member['social_email'];
				} elseif ( ! empty( $member['social_email']['url'] ) ) {
					$url = $member['social_email']['url'];
				}
				if ( $url && strpos( $url, 'mailto' ) === false ) {
					$url = 'mailto:' . $url;
				}
			} else {
				$url = $member[ 'social_' . $key ]['url'] ?? '';
			}

			if ( empty( $url ) ) {
				continue;
			}

			$target = ( 'email' !== $key ) ? ' target="_blank" rel="noopener noreferrer"' : '';
			printf(
				'<a href="%s"%s class="nexus-tg__social-link" style="display:flex;align-items:center;justify-content:center;width:32px;height:32px;border-radius:50%%;color:%s;transition:color 0.3s ease,background 0.3s ease;" aria-label="%s">%s</a>',
				esc_url( $url ),
				$target, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				esc_attr( $colors['social'] ),
				esc_attr( ucfirst( $key ) ),
				$svg // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			);
		}
		echo '</div>';
	}

	// -----------------------------------------------------------------
	// Card renderers
	// -----------------------------------------------------------------

	/**
	 * Style 1 — Clean cards: image top, info below, social overlay on image hover.
	 */
	private function render_card_overlay( $member, $colors, $name, $position, $photo_url, $link_url, $link_tgt, $anim_cls, $anim_attr ) {
		?>
		<div class="nexus-tg__card <?php echo esc_attr( $anim_cls ); ?>"<?php echo $anim_attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> style="background:<?php echo esc_attr( $colors['card_bg'] ); ?>;border-radius:12px;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,0.06);transition:transform 0.3s ease,box-shadow 0.3s ease;">
			<div class="nexus-tg__photo-wrap" style="position:relative;overflow:hidden;aspect-ratio:1/1;">
				<img src="<?php echo esc_url( $photo_url ); ?>" alt="<?php echo esc_attr( $name ); ?>" style="width:100%;height:100%;object-fit:cover;display:block;transition:transform 0.4s ease;" loading="lazy" />
				<div class="nexus-tg__overlay" style="position:absolute;inset:0;background:<?php echo esc_attr( $colors['overlay'] ); ?>;display:flex;align-items:center;justify-content:center;opacity:0;transition:opacity 0.3s ease;">
					<?php $this->render_social_icons( $member, array_merge( $colors, array( 'social' => '#ffffff' ) ) ); ?>
				</div>
			</div>
			<div class="nexus-tg__info" style="padding:1.25rem;text-align:center;">
				<?php if ( $name ) : ?>
					<h3 class="nexus-tg__name" style="font-size:1.0625rem;font-weight:700;margin:0 0 0.25rem;color:<?php echo esc_attr( $colors['name'] ); ?>;">
						<?php if ( $link_url ) : ?>
							<a href="<?php echo esc_url( $link_url ); ?>"<?php echo $link_tgt; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> style="color:inherit;text-decoration:none;"><?php echo esc_html( $name ); ?></a>
						<?php else : ?>
							<?php echo esc_html( $name ); ?>
						<?php endif; ?>
					</h3>
				<?php endif; ?>
				<?php if ( $position ) : ?>
					<span class="nexus-tg__position" style="font-size:0.875rem;color:<?php echo esc_attr( $colors['position'] ); ?>;">
						<?php echo esc_html( $position ); ?>
					</span>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}

	/**
	 * Style 2 — Circle centered: circular photo, centered text, bio optional.
	 */
	private function render_circle_center( $member, $colors, $name, $position, $bio, $photo_url, $link_url, $link_tgt, $show_bio, $anim_cls, $anim_attr ) {
		?>
		<div class="nexus-tg__card <?php echo esc_attr( $anim_cls ); ?>"<?php echo $anim_attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> style="background:<?php echo esc_attr( $colors['card_bg'] ); ?>;border-radius:16px;padding:2.5rem 1.5rem;text-align:center;box-shadow:0 2px 12px rgba(0,0,0,0.06);transition:transform 0.3s ease,box-shadow 0.3s ease;">
			<div style="width:140px;height:140px;margin:0 auto 1.25rem;border-radius:50%;overflow:hidden;">
				<img src="<?php echo esc_url( $photo_url ); ?>" alt="<?php echo esc_attr( $name ); ?>" style="width:100%;height:100%;object-fit:cover;display:block;" loading="lazy" />
			</div>
			<?php if ( $name ) : ?>
				<h3 class="nexus-tg__name" style="font-size:1.125rem;font-weight:700;margin:0 0 0.25rem;color:<?php echo esc_attr( $colors['name'] ); ?>;">
					<?php if ( $link_url ) : ?>
						<a href="<?php echo esc_url( $link_url ); ?>"<?php echo $link_tgt; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> style="color:inherit;text-decoration:none;"><?php echo esc_html( $name ); ?></a>
					<?php else : ?>
						<?php echo esc_html( $name ); ?>
					<?php endif; ?>
				</h3>
			<?php endif; ?>
			<?php if ( $position ) : ?>
				<span class="nexus-tg__position" style="display:block;font-size:0.875rem;color:<?php echo esc_attr( $colors['position'] ); ?>;margin-bottom:0.75rem;">
					<?php echo esc_html( $position ); ?>
				</span>
			<?php endif; ?>
			<?php if ( $show_bio && $bio ) : ?>
				<p class="nexus-tg__bio" style="font-size:0.875rem;line-height:1.6;color:<?php echo esc_attr( $colors['text'] ); ?>;margin:0 0 1rem;">
					<?php echo wp_kses_post( $bio ); ?>
				</p>
			<?php endif; ?>
			<div style="display:flex;justify-content:center;">
				<?php $this->render_social_icons( $member, $colors ); ?>
			</div>
		</div>
		<?php
	}

	/**
	 * Style 3 — Dark overlay: full image with name/position on hover.
	 */
	private function render_hover_overlay( $member, $colors, $name, $position, $photo_url, $anim_cls, $anim_attr ) {
		?>
		<div class="nexus-tg__card <?php echo esc_attr( $anim_cls ); ?>"<?php echo $anim_attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> style="position:relative;overflow:hidden;border-radius:12px;aspect-ratio:3/4;transition:transform 0.3s ease;">
			<img src="<?php echo esc_url( $photo_url ); ?>" alt="<?php echo esc_attr( $name ); ?>" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;transition:transform 0.5s ease;" loading="lazy" />
			<div class="nexus-tg__overlay" style="position:absolute;inset:0;background:<?php echo esc_attr( $colors['overlay'] ); ?>;display:flex;flex-direction:column;justify-content:flex-end;padding:1.5rem;opacity:0;transition:opacity 0.3s ease;">
				<?php if ( $name ) : ?>
					<h3 class="nexus-tg__name" style="font-size:1.125rem;font-weight:700;margin:0 0 0.25rem;color:#fff;">
						<?php echo esc_html( $name ); ?>
					</h3>
				<?php endif; ?>
				<?php if ( $position ) : ?>
					<span class="nexus-tg__position" style="font-size:0.875rem;color:rgba(255,255,255,0.8);margin-bottom:0.75rem;">
						<?php echo esc_html( $position ); ?>
					</span>
				<?php endif; ?>
				<?php $this->render_social_icons( $member, array_merge( $colors, array( 'social' => 'rgba(255,255,255,0.8)' ) ) ); ?>
			</div>
		</div>
		<?php
	}

	/**
	 * Style 4 — Horizontal row: photo left, info right.
	 */
	private function render_horizontal( $member, $colors, $name, $position, $bio, $photo_url, $link_url, $link_tgt, $show_bio, $anim_cls, $anim_attr ) {
		?>
		<div class="nexus-tg__card <?php echo esc_attr( $anim_cls ); ?>"<?php echo $anim_attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> style="display:flex;align-items:center;gap:1.25rem;padding:1.5rem;border-bottom:1px solid <?php echo esc_attr( $colors['text'] === '#495057' ? '#e9ecef' : 'rgba(255,255,255,0.08)' ); ?>;transition:background-color 0.3s ease;">
			<div style="flex-shrink:0;width:80px;height:80px;border-radius:50%;overflow:hidden;">
				<img src="<?php echo esc_url( $photo_url ); ?>" alt="<?php echo esc_attr( $name ); ?>" style="width:100%;height:100%;object-fit:cover;display:block;" loading="lazy" />
			</div>
			<div style="min-width:0;flex:1;">
				<?php if ( $name ) : ?>
					<h3 class="nexus-tg__name" style="font-size:1.0625rem;font-weight:700;margin:0 0 0.125rem;color:<?php echo esc_attr( $colors['name'] ); ?>;">
						<?php if ( $link_url ) : ?>
							<a href="<?php echo esc_url( $link_url ); ?>"<?php echo $link_tgt; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> style="color:inherit;text-decoration:none;"><?php echo esc_html( $name ); ?></a>
						<?php else : ?>
							<?php echo esc_html( $name ); ?>
						<?php endif; ?>
					</h3>
				<?php endif; ?>
				<?php if ( $position ) : ?>
					<span class="nexus-tg__position" style="display:block;font-size:0.8125rem;color:<?php echo esc_attr( $colors['position'] ); ?>;margin-bottom:0.5rem;">
						<?php echo esc_html( $position ); ?>
					</span>
				<?php endif; ?>
				<?php if ( $show_bio && $bio ) : ?>
					<p class="nexus-tg__bio" style="font-size:0.8125rem;line-height:1.5;color:<?php echo esc_attr( $colors['text'] ); ?>;margin:0 0 0.5rem;">
						<?php echo wp_kses_post( $bio ); ?>
					</p>
				<?php endif; ?>
				<?php $this->render_social_icons( $member, $colors ); ?>
			</div>
		</div>
		<?php
	}

	/**
	 * Style 5 — Bordered hover: rounded image, border card, hover lift.
	 */
	private function render_bordered( $member, $colors, $name, $position, $photo_url, $photo_shape, $link_url, $link_tgt, $anim_cls, $anim_attr ) {
		$radius_map = array( 'square' => '0', 'rounded' => '12px', 'circle' => '50%' );
		$img_radius = $radius_map[ $photo_shape ] ?? '12px';
		?>
		<div class="nexus-tg__card <?php echo esc_attr( $anim_cls ); ?>"<?php echo $anim_attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> style="background:<?php echo esc_attr( $colors['card_bg'] ); ?>;border:1px solid #dee2e6;border-radius:12px;padding:1.5rem;text-align:center;transition:transform 0.3s ease,box-shadow 0.3s ease,border-color 0.3s ease;">
			<div style="width:120px;height:120px;margin:0 auto 1rem;border-radius:<?php echo esc_attr( $img_radius ); ?>;overflow:hidden;">
				<img src="<?php echo esc_url( $photo_url ); ?>" alt="<?php echo esc_attr( $name ); ?>" style="width:100%;height:100%;object-fit:cover;display:block;" loading="lazy" />
			</div>
			<?php if ( $name ) : ?>
				<h3 class="nexus-tg__name" style="font-size:1rem;font-weight:700;margin:0 0 0.25rem;color:<?php echo esc_attr( $colors['name'] ); ?>;">
					<?php if ( $link_url ) : ?>
						<a href="<?php echo esc_url( $link_url ); ?>"<?php echo $link_tgt; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> style="color:inherit;text-decoration:none;"><?php echo esc_html( $name ); ?></a>
					<?php else : ?>
						<?php echo esc_html( $name ); ?>
					<?php endif; ?>
				</h3>
			<?php endif; ?>
			<?php if ( $position ) : ?>
				<span class="nexus-tg__position" style="display:block;font-size:0.8125rem;color:<?php echo esc_attr( $colors['position'] ); ?>;margin-bottom:0.75rem;">
					<?php echo esc_html( $position ); ?>
				</span>
			<?php endif; ?>
			<div style="display:flex;justify-content:center;">
				<?php $this->render_social_icons( $member, $colors ); ?>
			</div>
		</div>
		<?php
	}

	/**
	 * Style 6 — Accent bar: dark card with accent bottom border.
	 */
	private function render_accent_bar( $member, $colors, $name, $position, $bio, $photo_url, $link_url, $link_tgt, $show_bio, $anim_cls, $anim_attr ) {
		?>
		<div class="nexus-tg__card <?php echo esc_attr( $anim_cls ); ?>"<?php echo $anim_attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> style="background:<?php echo esc_attr( $colors['card_bg'] ); ?>;border-radius:12px;overflow:hidden;border-bottom:3px solid <?php echo esc_attr( $colors['tagline'] ); ?>;transition:transform 0.3s ease,box-shadow 0.3s ease;">
			<div style="aspect-ratio:4/3;overflow:hidden;">
				<img src="<?php echo esc_url( $photo_url ); ?>" alt="<?php echo esc_attr( $name ); ?>" style="width:100%;height:100%;object-fit:cover;display:block;transition:transform 0.4s ease;" loading="lazy" />
			</div>
			<div style="padding:1.25rem;">
				<?php if ( $name ) : ?>
					<h3 class="nexus-tg__name" style="font-size:1.0625rem;font-weight:700;margin:0 0 0.25rem;color:<?php echo esc_attr( $colors['name'] ); ?>;">
						<?php if ( $link_url ) : ?>
							<a href="<?php echo esc_url( $link_url ); ?>"<?php echo $link_tgt; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> style="color:inherit;text-decoration:none;"><?php echo esc_html( $name ); ?></a>
						<?php else : ?>
							<?php echo esc_html( $name ); ?>
						<?php endif; ?>
					</h3>
				<?php endif; ?>
				<?php if ( $position ) : ?>
					<span class="nexus-tg__position" style="display:block;font-size:0.8125rem;color:<?php echo esc_attr( $colors['position'] ); ?>;margin-bottom:0.5rem;">
						<?php echo esc_html( $position ); ?>
					</span>
				<?php endif; ?>
				<?php if ( $show_bio && $bio ) : ?>
					<p class="nexus-tg__bio" style="font-size:0.8125rem;line-height:1.5;color:<?php echo esc_attr( $colors['text'] ); ?>;margin:0 0 0.75rem;">
						<?php echo wp_kses_post( $bio ); ?>
					</p>
				<?php endif; ?>
				<?php $this->render_social_icons( $member, $colors ); ?>
			</div>
		</div>
		<?php
	}
}
