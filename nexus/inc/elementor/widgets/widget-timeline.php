<?php
/**
 * Nexus Theme - Elementor Timeline Widget
 *
 * Vertical timeline with 6 style presets.
 * All colors use CSS custom properties for palette + dark mode support.
 * Staggered entrance animation via IntersectionObserver.
 *
 * @package Nexus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Nexus_Widget_Timeline
 */
class Nexus_Widget_Timeline extends \Elementor\Widget_Base {

	public function get_name() {
		return 'nexus-timeline';
	}

	public function get_title() {
		return esc_html__( 'Timeline', 'nexus' );
	}

	public function get_icon() {
		return 'eicon-time-line';
	}

	public function get_categories() {
		return array( 'nexus-elements' );
	}

	public function get_keywords() {
		return array( 'timeline', 'history', 'milestones', 'process', 'steps', 'nexus' );
	}

	// -----------------------------------------------------------------
	// Preset defaults
	// -----------------------------------------------------------------

	private function get_preset_defaults( $preset ) {
		$map = array(
			'clean-centered'  => array(
				'tagline'     => 'Our Journey',
				'headline'    => 'Company Milestones',
				'description' => 'A look back at the key moments that shaped who we are today.',
				'layout'      => 'centered',
			),
			'left-lined'      => array(
				'tagline'     => 'History',
				'headline'    => 'How We Got Here',
				'description' => '',
				'layout'      => 'left',
			),
			'dark-glow'       => array(
				'tagline'     => 'Timeline',
				'headline'    => 'Our Story So Far',
				'description' => '',
				'layout'      => 'centered',
			),
			'card-alternate'  => array(
				'tagline'     => 'Milestones',
				'headline'    => 'Key Moments in Our Growth',
				'description' => 'Every step brought us closer to our mission.',
				'layout'      => 'centered',
			),
			'minimal-dots'    => array(
				'tagline'     => '',
				'headline'    => 'Our Process',
				'description' => '',
				'layout'      => 'left',
			),
			'glass-modern'    => array(
				'tagline'     => 'Roadmap',
				'headline'    => 'Building the Future',
				'description' => '',
				'layout'      => 'centered',
			),
		);

		return $map[ $preset ] ?? $map['clean-centered'];
	}

	private function get_default_items() {
		return array(
			array(
				'year'    => '2018',
				'title'   => 'Founded',
				'content' => 'Our company was founded with a vision to transform the digital landscape.',
				'icon'    => array( 'value' => 'ri-flag-line', 'library' => 'remix-icon' ),
			),
			array(
				'year'    => '2019',
				'title'   => 'First Product Launch',
				'content' => 'We launched our flagship product, gaining 10,000 users in the first month.',
				'icon'    => array( 'value' => 'ri-rocket-2-line', 'library' => 'remix-icon' ),
			),
			array(
				'year'    => '2020',
				'title'   => 'Series A Funding',
				'content' => 'Secured $5M in Series A funding to scale operations globally.',
				'icon'    => array( 'value' => 'ri-funds-line', 'library' => 'remix-icon' ),
			),
			array(
				'year'    => '2022',
				'title'   => 'Global Expansion',
				'content' => 'Opened offices in London, Tokyo, and Sydney to serve clients worldwide.',
				'icon'    => array( 'value' => 'ri-global-line', 'library' => 'remix-icon' ),
			),
			array(
				'year'    => '2024',
				'title'   => '1 Million Users',
				'content' => 'Reached the milestone of one million active users across all platforms.',
				'icon'    => array( 'value' => 'ri-group-line', 'library' => 'remix-icon' ),
			),
		);
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
				'default'     => 'clean-centered',
				'options'     => array(
					'clean-centered'  => esc_html__( '1 — Clean Centered', 'nexus' ),
					'left-lined'      => esc_html__( '2 — Left Lined', 'nexus' ),
					'dark-glow'       => esc_html__( '3 — Dark Glow', 'nexus' ),
					'card-alternate'  => esc_html__( '4 — Card Alternate', 'nexus' ),
					'minimal-dots'    => esc_html__( '5 — Minimal Dots', 'nexus' ),
					'glass-modern'    => esc_html__( '6 — Glass Modern', 'nexus' ),
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

		// ---- Timeline Items Repeater ----
		$this->start_controls_section(
			'section_items',
			array( 'label' => esc_html__( 'Timeline Items', 'nexus' ) )
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control( 'year', array(
			'label'   => esc_html__( 'Year / Label', 'nexus' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => '2024',
		) );

		$repeater->add_control( 'title', array(
			'label'   => esc_html__( 'Title', 'nexus' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => esc_html__( 'Milestone Title', 'nexus' ),
			'dynamic' => array( 'active' => true ),
		) );

		$repeater->add_control( 'content', array(
			'label'   => esc_html__( 'Content', 'nexus' ),
			'type'    => \Elementor\Controls_Manager::TEXTAREA,
			'rows'    => 3,
			'default' => esc_html__( 'Describe this milestone or event.', 'nexus' ),
			'dynamic' => array( 'active' => true ),
		) );

		$repeater->add_control( 'icon', array(
			'label'   => esc_html__( 'Icon', 'nexus' ),
			'type'    => \Elementor\Controls_Manager::ICONS,
			'default' => array( 'value' => 'ri-flag-line', 'library' => 'remix-icon' ),
		) );

		$this->add_control(
			'items',
			array(
				'label'       => esc_html__( 'Items', 'nexus' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => $this->get_default_items(),
				'title_field' => '{{{ year }}} — {{{ title }}}',
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
			'selectors' => array( '{{WRAPPER}} .nexus-tl__tagline' => 'color: {{VALUE}};' ),
		) );

		$this->add_control( 'heading_color_ctrl', array(
			'label'     => esc_html__( 'Heading Color', 'nexus' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => array( '{{WRAPPER}} .nexus-tl__title' => 'color: {{VALUE}};' ),
		) );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'heading_typography',
				'label'    => esc_html__( 'Heading Typography', 'nexus' ),
				'selector' => '{{WRAPPER}} .nexus-tl__title',
			)
		);

		$this->end_controls_section();

		// ---- Style: Items ----
		$this->start_controls_section(
			'section_style_items',
			array(
				'label' => esc_html__( 'Items', 'nexus' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'item_title_typography',
				'label'    => esc_html__( 'Item Title Typography', 'nexus' ),
				'selector' => '{{WRAPPER}} .nexus-tl-item__title',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'item_shadow',
				'selector' => '{{WRAPPER}} .nexus-tl-item__card',
			)
		);

		$this->end_controls_section();
	}

	// -----------------------------------------------------------------
	// Render
	// -----------------------------------------------------------------

	protected function render() {
		$settings  = $this->get_settings_for_display();
		$preset    = $settings['style_preset'] ?? 'clean-centered';
		$defaults  = $this->get_preset_defaults( $preset );
		$animation = $settings['entrance_animation'] ?? 'fadeInUp';
		$is_editor = \Elementor\Plugin::$instance->editor->is_edit_mode();
		$widget_id = 'nexus-tl-' . $this->get_id();
		$layout    = $defaults['layout'];

		$tagline     = ( '' !== $settings['tagline'] ) ? $settings['tagline'] : ( $defaults['tagline'] ?? '' );
		$headline    = ( '' !== $settings['headline'] ) ? $settings['headline'] : ( $defaults['headline'] ?? '' );
		$description = ( '' !== $settings['description'] ) ? $settings['description'] : ( $defaults['description'] ?? '' );
		$align       = $settings['header_align'] ?? 'center';

		$items = $settings['items'] ?? array();
		if ( empty( $items ) ) {
			return;
		}

		$has_anim = ( 'none' !== $animation && ! $is_editor );
		?>

		<section
			class="nexus-tl nexus-tl--<?php echo esc_attr( $preset ); ?> nexus-tl--<?php echo esc_attr( $layout ); ?>"
			id="<?php echo esc_attr( $widget_id ); ?>"
		>
			<div class="nexus-container">

				<?php if ( $tagline || $headline || $description ) : ?>
				<div class="nexus-tl__header nexus-tl__header--<?php echo esc_attr( $align ); ?>">
					<?php if ( $tagline ) : ?>
						<span class="nexus-tl__tagline"><?php echo esc_html( $tagline ); ?></span>
					<?php endif; ?>
					<?php if ( $headline ) : ?>
						<h2 class="nexus-tl__title"><?php echo wp_kses_post( $headline ); ?></h2>
					<?php endif; ?>
					<?php if ( $description ) : ?>
						<p class="nexus-tl__desc"><?php echo wp_kses_post( $description ); ?></p>
					<?php endif; ?>
				</div>
				<?php endif; ?>

				<div class="nexus-tl__track">
					<div class="nexus-tl__line"></div>

					<?php foreach ( $items as $idx => $item ) :
						$delay    = $idx * 150;
						$anim_cls = $has_anim ? 'nexus-tl-item--anim' : 'is-visible';
						$side     = ( 'centered' === $layout ) ? ( 0 === $idx % 2 ? 'left' : 'right' ) : 'right';
					?>
					<div class="nexus-tl-item nexus-tl-item--<?php echo esc_attr( $side ); ?> <?php echo esc_attr( $anim_cls ); ?>"<?php echo $has_anim ? ' data-tl-delay="' . esc_attr( $delay ) . '"' : ''; ?>>

						<div class="nexus-tl-item__marker">
							<?php if ( ! empty( $item['icon']['value'] ) ) : ?>
								<span class="nexus-tl-item__icon">
									<?php \Elementor\Icons_Manager::render_icon( $item['icon'], array( 'aria-hidden' => 'true' ) ); ?>
								</span>
							<?php else : ?>
								<span class="nexus-tl-item__dot"></span>
							<?php endif; ?>
						</div>

						<div class="nexus-tl-item__card">
							<?php if ( ! empty( $item['year'] ) ) : ?>
								<span class="nexus-tl-item__year"><?php echo esc_html( $item['year'] ); ?></span>
							<?php endif; ?>
							<?php if ( ! empty( $item['title'] ) ) : ?>
								<h3 class="nexus-tl-item__title"><?php echo esc_html( $item['title'] ); ?></h3>
							<?php endif; ?>
							<?php if ( ! empty( $item['content'] ) ) : ?>
								<p class="nexus-tl-item__text"><?php echo wp_kses_post( $item['content'] ); ?></p>
							<?php endif; ?>
						</div>

					</div>
					<?php endforeach; ?>
				</div>

			</div>
		</section>

		<?php if ( $has_anim ) : ?>
		<script>
		(function(){
			var container=document.getElementById('<?php echo esc_js( $widget_id ); ?>');
			if(!container)return;
			var items=container.querySelectorAll('.nexus-tl-item--anim');
			if(!items.length)return;
			var io=new IntersectionObserver(function(entries){
				entries.forEach(function(e){
					if(e.isIntersecting){
						var d=parseInt(e.target.getAttribute('data-tl-delay'),10)||0;
						setTimeout(function(){e.target.classList.add('is-visible');},d);
						io.unobserve(e.target);
					}
				});
			},{threshold:0.15});
			items.forEach(function(c){io.observe(c);});
		})();
		</script>
		<?php endif; ?>

		<?php
	}
}
