<?php
/**
 * Nexus Theme - Elementor Team Scroller Widget
 *
 * Horizontal scrolling team member carousel with 6 style presets.
 * Uses Swiper.js for smooth, touch-friendly scrolling.
 * All colors use CSS custom properties for light/dark theme support.
 *
 * @package Nexus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Nexus_Widget_Team_Scroller
 */
class Nexus_Widget_Team_Scroller extends \Elementor\Widget_Base {

	public function get_name() {
		return 'nexus-team-scroller';
	}

	public function get_title() {
		return esc_html__( 'Team Scroller', 'nexus' );
	}

	public function get_icon() {
		return 'eicon-person';
	}

	public function get_categories() {
		return array( 'nexus-elements' );
	}

	public function get_keywords() {
		return array( 'team', 'scroller', 'carousel', 'slider', 'members', 'staff', 'nexus' );
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

	private function get_preset_defaults( $preset ) {
		$map = array(
			'clean-slide'    => array(
				'tagline'     => 'Our Team',
				'headline'    => 'Meet the People Behind Our Success',
				'description' => 'A talented team of designers, developers, and strategists.',
				'slides_view' => 4,
				'card_style'  => 'card-below',
				'show_bio'    => false,
				'photo_ratio' => '1/1',
				'members'     => array(
					array( 'name' => 'Sarah Johnson', 'position' => 'Creative Director', 'linkedin' => '#', 'twitter' => '#' ),
					array( 'name' => 'Michael Chen', 'position' => 'Lead Developer', 'linkedin' => '#' ),
					array( 'name' => 'Emily Davis', 'position' => 'UX Strategist', 'linkedin' => '#', 'instagram' => '#' ),
					array( 'name' => 'James Wilson', 'position' => 'Project Manager', 'linkedin' => '#' ),
					array( 'name' => 'Olivia Brown', 'position' => 'Marketing Lead', 'linkedin' => '#', 'twitter' => '#' ),
				),
			),
			'circle-minimal' => array(
				'tagline'     => 'Leadership',
				'headline'    => 'Our Leadership Team',
				'description' => 'Experienced professionals driving our vision forward.',
				'slides_view' => 4,
				'card_style'  => 'circle-center',
				'show_bio'    => true,
				'photo_ratio' => '1/1',
				'members'     => array(
					array( 'name' => 'Anna Martinez', 'position' => 'CEO & Founder', 'bio' => 'With 15+ years in digital strategy and business development.', 'linkedin' => '#' ),
					array( 'name' => 'David Kim', 'position' => 'CTO', 'bio' => 'Full-stack architect with a passion for scalable solutions.', 'linkedin' => '#' ),
					array( 'name' => 'Rachel Stone', 'position' => 'VP of Design', 'bio' => 'Award-winning designer focused on user-centered experiences.', 'linkedin' => '#' ),
					array( 'name' => 'Tom Fischer', 'position' => 'CFO', 'bio' => 'Financial strategist ensuring sustainable growth.', 'linkedin' => '#' ),
					array( 'name' => 'Priya Sharma', 'position' => 'VP of Marketing', 'bio' => 'Growth strategist and brand storyteller.', 'linkedin' => '#' ),
				),
			),
			'dark-overlay'   => array(
				'tagline'     => 'The Team',
				'headline'    => 'Creative Minds at Work',
				'description' => '',
				'slides_view' => 3,
				'card_style'  => 'hover-overlay',
				'show_bio'    => false,
				'photo_ratio' => '3/4',
				'members'     => array(
					array( 'name' => 'Lucas Rivera', 'position' => 'Art Director', 'instagram' => '#' ),
					array( 'name' => 'Sophie Turner', 'position' => 'UI Designer', 'instagram' => '#' ),
					array( 'name' => 'Ethan Park', 'position' => 'Motion Designer', 'instagram' => '#' ),
					array( 'name' => 'Mia Anderson', 'position' => 'Photographer', 'instagram' => '#' ),
				),
			),
			'horizontal-row' => array(
				'tagline'     => 'Who We Are',
				'headline'    => 'Our Core Team',
				'description' => 'Small team, big results. Each member brings unique expertise.',
				'slides_view' => 2,
				'card_style'  => 'horizontal',
				'show_bio'    => true,
				'photo_ratio' => '1/1',
				'members'     => array(
					array( 'name' => 'Mark Thompson', 'position' => 'Founder & CEO', 'bio' => 'Visionary leader with 20 years in tech.', 'linkedin' => '#', 'twitter' => '#' ),
					array( 'name' => 'Lisa Chang', 'position' => 'Head of Engineering', 'bio' => 'Systems architect and open-source contributor.', 'linkedin' => '#' ),
					array( 'name' => 'Alex Novak', 'position' => 'Head of Design', 'bio' => 'Design thinking evangelist and mentor.', 'linkedin' => '#', 'twitter' => '#' ),
					array( 'name' => 'Jordan Blake', 'position' => 'Head of Product', 'bio' => 'Bridging the gap between vision and execution.', 'linkedin' => '#' ),
				),
			),
			'bordered-peek'  => array(
				'tagline'     => 'Team',
				'headline'    => 'People Behind the Work',
				'description' => 'Meet the passionate individuals who make it all happen.',
				'slides_view' => 4,
				'card_style'  => 'bordered',
				'show_bio'    => false,
				'photo_ratio' => '1/1',
				'members'     => array(
					array( 'name' => 'Chris Walker', 'position' => 'Frontend Developer', 'linkedin' => '#' ),
					array( 'name' => 'Nina Patel', 'position' => 'Backend Developer', 'linkedin' => '#' ),
					array( 'name' => 'Tom Fischer', 'position' => 'DevOps Engineer', 'linkedin' => '#' ),
					array( 'name' => 'Amy Lewis', 'position' => 'QA Engineer', 'linkedin' => '#' ),
					array( 'name' => 'Ryan Cooper', 'position' => 'Data Engineer', 'linkedin' => '#' ),
				),
			),
			'accent-bar'     => array(
				'tagline'     => 'About Us',
				'headline'    => 'The Dreamers & Doers',
				'description' => 'United by passion, driven by excellence.',
				'slides_view' => 3,
				'card_style'  => 'accent-bottom',
				'show_bio'    => true,
				'photo_ratio' => '4/3',
				'members'     => array(
					array( 'name' => 'Jordan Blake', 'position' => 'Product Manager', 'bio' => 'Bridging the gap between vision and execution.', 'linkedin' => '#', 'twitter' => '#' ),
					array( 'name' => 'Mia Anderson', 'position' => 'Content Strategist', 'bio' => 'Crafting narratives that resonate and convert.', 'linkedin' => '#' ),
					array( 'name' => 'Ryan Cooper', 'position' => 'Growth Hacker', 'bio' => 'Data-driven marketer focused on rapid scaling.', 'linkedin' => '#', 'twitter' => '#' ),
					array( 'name' => 'Sarah Lee', 'position' => 'Brand Designer', 'bio' => 'Visual storyteller creating memorable identities.', 'linkedin' => '#' ),
				),
			),
		);

		return $map[ $preset ] ?? $map['clean-slide'];
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
					'clean-slide'    => esc_html__( '1 — Clean Slide', 'nexus' ),
					'circle-minimal' => esc_html__( '2 — Circle Minimal', 'nexus' ),
					'dark-overlay'   => esc_html__( '3 — Dark Overlay', 'nexus' ),
					'horizontal-row' => esc_html__( '4 — Horizontal Row', 'nexus' ),
					'bordered-peek'  => esc_html__( '5 — Bordered Peek', 'nexus' ),
					'accent-bar'     => esc_html__( '6 — Accent Bar', 'nexus' ),
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
			'label'     => esc_html__( 'Social Links', 'nexus' ),
			'type'      => \Elementor\Controls_Manager::HEADING,
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
		$preset    = $settings['style_preset'] ?? 'clean-slide';
		$defaults  = $this->get_preset_defaults( $preset );
		$is_editor = \Elementor\Plugin::$instance->editor->is_edit_mode();
		$widget_id = 'nexus-ts-' . $this->get_id();

		// Merge defaults.
		$tagline     = ( '' !== $settings['tagline'] ) ? $settings['tagline'] : ( $defaults['tagline'] ?? '' );
		$headline    = ( '' !== $settings['headline'] ) ? $settings['headline'] : ( $defaults['headline'] ?? '' );
		$description = ( '' !== $settings['description'] ) ? $settings['description'] : ( $defaults['description'] ?? '' );
		$card_style  = $defaults['card_style'];
		$show_bio    = $defaults['show_bio'];
		$photo_ratio = $defaults['photo_ratio'];
		$spv         = absint( $defaults['slides_view'] );
		$dots        = 'yes' === $settings['show_dots'];
		$arrows      = 'yes' === $settings['show_arrows'];

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
		?>

		<section
			class="nexus-ts nexus-ts--<?php echo esc_attr( $preset ); ?>"
			id="<?php echo esc_attr( $widget_id ); ?>"
		>
			<div class="nexus-container">

				<?php if ( $tagline || $headline || $description ) : ?>
				<div class="nexus-ts__header">
					<?php if ( $tagline ) : ?>
						<span class="nexus-ts__tagline">
							<?php echo esc_html( $tagline ); ?>
						</span>
					<?php endif; ?>
					<?php if ( $headline ) : ?>
						<h2 class="nexus-ts__title">
							<?php echo wp_kses_post( $headline ); ?>
						</h2>
					<?php endif; ?>
					<?php if ( $description ) : ?>
						<p class="nexus-ts__desc">
							<?php echo wp_kses_post( $description ); ?>
						</p>
					<?php endif; ?>
				</div>
				<?php endif; ?>

			</div>

			<div class="nexus-container">
				<div class="nexus-ts__slider swiper" id="<?php echo esc_attr( $widget_id ); ?>-swiper">
					<div class="swiper-wrapper">
						<?php foreach ( $members as $idx => $member ) : ?>
							<div class="swiper-slide">
								<?php
								$name      = $member['name'] ?? '';
								$position  = $member['position'] ?? '';
								$bio       = $member['bio'] ?? '';
								$photo_url = ! empty( $member['photo']['url'] ) ? $member['photo']['url'] : \Elementor\Utils::get_placeholder_image_src();
								$link_url  = ! empty( $member['link']['url'] ) ? $member['link']['url'] : '';
								$link_tgt  = ! empty( $member['link']['is_external'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';

								switch ( $card_style ) {
									case 'circle-center':
										$this->render_circle_center( $member, $name, $position, $bio, $photo_url, $link_url, $link_tgt, $show_bio );
										break;
									case 'hover-overlay':
										$this->render_hover_overlay( $member, $name, $position, $photo_url, $photo_ratio );
										break;
									case 'horizontal':
										$this->render_horizontal( $member, $name, $position, $bio, $photo_url, $link_url, $link_tgt, $show_bio );
										break;
									case 'bordered':
										$this->render_bordered( $member, $name, $position, $photo_url, $link_url, $link_tgt );
										break;
									case 'accent-bottom':
										$this->render_accent_bottom( $member, $name, $position, $bio, $photo_url, $link_url, $link_tgt, $show_bio, $photo_ratio );
										break;
									default: // card-below.
										$this->render_card_below( $member, $name, $position, $photo_url, $link_url, $link_tgt, $photo_ratio );
										break;
								}
								?>
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
			</div>

			<?php if ( $btn_text && $btn_url ) : ?>
			<div class="nexus-container">
				<div class="nexus-ts__footer">
					<a href="<?php echo esc_url( $btn_url ); ?>"<?php echo $btn_tgt; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> class="nexus-btn nexus-btn--secondary nexus-ts__btn">
						<?php echo esc_html( $btn_text ); ?>
					</a>
				</div>
			</div>
			<?php endif; ?>

		</section>

		<script>
		(function(){
			var swiperId='<?php echo esc_js( $widget_id ); ?>-swiper';
			function initTS(){
				var el=document.getElementById(swiperId);
				if(!el)return;
				if(!window.Swiper){setTimeout(initTS,100);return;}
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
					navigation:<?php echo $arrows ? '{nextEl:el.querySelector(\'.swiper-button-next\'),prevEl:el.querySelector(\'.swiper-button-prev\')}' : 'false'; ?>,
					breakpoints:{
						0:{slidesPerView:1,spaceBetween:16},
						640:{slidesPerView:Math.min(2,spv),spaceBetween:20},
						992:{slidesPerView:spv,spaceBetween:24}
					}
				});
			}
			if(document.readyState==='loading'){document.addEventListener('DOMContentLoaded',initTS);}else{initTS();}
			if(window.elementorFrontend){jQuery(window).on('elementor/frontend/init',function(){elementorFrontend.hooks.addAction('frontend/element_ready/nexus-team-scroller.default',initTS);});}
		})();
		</script>

		<?php
	}

	// -----------------------------------------------------------------
	// Social icons helper
	// -----------------------------------------------------------------

	private function render_social_icons( $member ) {
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

		echo '<div class="nexus-ts__social">';
		foreach ( $socials as $key => $svg ) {
			$url = '';
			if ( 'email' === $key ) {
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
				'<a href="%s"%s class="nexus-ts__social-link" aria-label="%s">%s</a>',
				esc_url( $url ),
				$target, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				esc_attr( ucfirst( $key ) ),
				$svg // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			);
		}
		echo '</div>';
	}

	// -----------------------------------------------------------------
	// Card renderers — all use CSS classes, no inline color styles
	// -----------------------------------------------------------------

	/**
	 * Style 1 — Clean slide: image top, info below in card.
	 */
	private function render_card_below( $member, $name, $position, $photo_url, $link_url, $link_tgt, $photo_ratio ) {
		?>
		<div class="nexus-ts__card nexus-ts__card--below">
			<div class="nexus-ts__photo-wrap" style="aspect-ratio:<?php echo esc_attr( $photo_ratio ); ?>;">
				<img src="<?php echo esc_url( $photo_url ); ?>" alt="<?php echo esc_attr( $name ); ?>" loading="lazy" />
				<div class="nexus-ts__photo-overlay">
					<?php $this->render_social_icons( $member ); ?>
				</div>
			</div>
			<div class="nexus-ts__info">
				<?php if ( $name ) : ?>
					<h3 class="nexus-ts__name">
						<?php if ( $link_url ) : ?>
							<a href="<?php echo esc_url( $link_url ); ?>"<?php echo $link_tgt; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $name ); ?></a>
						<?php else : ?>
							<?php echo esc_html( $name ); ?>
						<?php endif; ?>
					</h3>
				<?php endif; ?>
				<?php if ( $position ) : ?>
					<span class="nexus-ts__position"><?php echo esc_html( $position ); ?></span>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}

	/**
	 * Style 2 — Circle center: circular photo, centered text, bio + social.
	 */
	private function render_circle_center( $member, $name, $position, $bio, $photo_url, $link_url, $link_tgt, $show_bio ) {
		?>
		<div class="nexus-ts__card nexus-ts__card--circle">
			<div class="nexus-ts__circle-photo">
				<img src="<?php echo esc_url( $photo_url ); ?>" alt="<?php echo esc_attr( $name ); ?>" loading="lazy" />
			</div>
			<?php if ( $name ) : ?>
				<h3 class="nexus-ts__name">
					<?php if ( $link_url ) : ?>
						<a href="<?php echo esc_url( $link_url ); ?>"<?php echo $link_tgt; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $name ); ?></a>
					<?php else : ?>
						<?php echo esc_html( $name ); ?>
					<?php endif; ?>
				</h3>
			<?php endif; ?>
			<?php if ( $position ) : ?>
				<span class="nexus-ts__position"><?php echo esc_html( $position ); ?></span>
			<?php endif; ?>
			<?php if ( $show_bio && $bio ) : ?>
				<p class="nexus-ts__bio"><?php echo wp_kses_post( $bio ); ?></p>
			<?php endif; ?>
			<?php $this->render_social_icons( $member ); ?>
		</div>
		<?php
	}

	/**
	 * Style 3 — Dark overlay: full-bleed image with hover overlay.
	 */
	private function render_hover_overlay( $member, $name, $position, $photo_url, $photo_ratio ) {
		?>
		<div class="nexus-ts__card nexus-ts__card--overlay" style="aspect-ratio:<?php echo esc_attr( $photo_ratio ); ?>;">
			<img src="<?php echo esc_url( $photo_url ); ?>" alt="<?php echo esc_attr( $name ); ?>" loading="lazy" />
			<div class="nexus-ts__overlay-content">
				<?php if ( $name ) : ?>
					<h3 class="nexus-ts__name"><?php echo esc_html( $name ); ?></h3>
				<?php endif; ?>
				<?php if ( $position ) : ?>
					<span class="nexus-ts__position"><?php echo esc_html( $position ); ?></span>
				<?php endif; ?>
				<?php $this->render_social_icons( $member ); ?>
			</div>
		</div>
		<?php
	}

	/**
	 * Style 4 — Horizontal: photo left, info right.
	 */
	private function render_horizontal( $member, $name, $position, $bio, $photo_url, $link_url, $link_tgt, $show_bio ) {
		?>
		<div class="nexus-ts__card nexus-ts__card--horizontal">
			<div class="nexus-ts__horiz-photo">
				<img src="<?php echo esc_url( $photo_url ); ?>" alt="<?php echo esc_attr( $name ); ?>" loading="lazy" />
			</div>
			<div class="nexus-ts__horiz-info">
				<?php if ( $name ) : ?>
					<h3 class="nexus-ts__name">
						<?php if ( $link_url ) : ?>
							<a href="<?php echo esc_url( $link_url ); ?>"<?php echo $link_tgt; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $name ); ?></a>
						<?php else : ?>
							<?php echo esc_html( $name ); ?>
						<?php endif; ?>
					</h3>
				<?php endif; ?>
				<?php if ( $position ) : ?>
					<span class="nexus-ts__position"><?php echo esc_html( $position ); ?></span>
				<?php endif; ?>
				<?php if ( $show_bio && $bio ) : ?>
					<p class="nexus-ts__bio"><?php echo wp_kses_post( $bio ); ?></p>
				<?php endif; ?>
				<?php $this->render_social_icons( $member ); ?>
			</div>
		</div>
		<?php
	}

	/**
	 * Style 5 — Bordered: bordered card with rounded image, hover lift.
	 */
	private function render_bordered( $member, $name, $position, $photo_url, $link_url, $link_tgt ) {
		?>
		<div class="nexus-ts__card nexus-ts__card--bordered">
			<div class="nexus-ts__bordered-photo">
				<img src="<?php echo esc_url( $photo_url ); ?>" alt="<?php echo esc_attr( $name ); ?>" loading="lazy" />
			</div>
			<?php if ( $name ) : ?>
				<h3 class="nexus-ts__name">
					<?php if ( $link_url ) : ?>
						<a href="<?php echo esc_url( $link_url ); ?>"<?php echo $link_tgt; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $name ); ?></a>
					<?php else : ?>
						<?php echo esc_html( $name ); ?>
					<?php endif; ?>
				</h3>
			<?php endif; ?>
			<?php if ( $position ) : ?>
				<span class="nexus-ts__position"><?php echo esc_html( $position ); ?></span>
			<?php endif; ?>
			<?php $this->render_social_icons( $member ); ?>
		</div>
		<?php
	}

	/**
	 * Style 6 — Accent bottom: card with accent bottom border.
	 */
	private function render_accent_bottom( $member, $name, $position, $bio, $photo_url, $link_url, $link_tgt, $show_bio, $photo_ratio ) {
		?>
		<div class="nexus-ts__card nexus-ts__card--accent">
			<div class="nexus-ts__accent-photo" style="aspect-ratio:<?php echo esc_attr( $photo_ratio ); ?>;">
				<img src="<?php echo esc_url( $photo_url ); ?>" alt="<?php echo esc_attr( $name ); ?>" loading="lazy" />
			</div>
			<div class="nexus-ts__accent-info">
				<?php if ( $name ) : ?>
					<h3 class="nexus-ts__name">
						<?php if ( $link_url ) : ?>
							<a href="<?php echo esc_url( $link_url ); ?>"<?php echo $link_tgt; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $name ); ?></a>
						<?php else : ?>
							<?php echo esc_html( $name ); ?>
						<?php endif; ?>
					</h3>
				<?php endif; ?>
				<?php if ( $position ) : ?>
					<span class="nexus-ts__position"><?php echo esc_html( $position ); ?></span>
				<?php endif; ?>
				<?php if ( $show_bio && $bio ) : ?>
					<p class="nexus-ts__bio"><?php echo wp_kses_post( $bio ); ?></p>
				<?php endif; ?>
				<?php $this->render_social_icons( $member ); ?>
			</div>
		</div>
		<?php
	}
}
