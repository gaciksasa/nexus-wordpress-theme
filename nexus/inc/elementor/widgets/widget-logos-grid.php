<?php
/**
 * Nexus Theme - Elementor Logos Grid Widget
 *
 * Client / partner logo showcase with 6 style presets.
 * All colors use CSS custom properties for palette + dark mode support.
 * Staggered entrance animation via IntersectionObserver.
 *
 * @package Nexus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Nexus_Widget_Logos_Grid
 */
class Nexus_Widget_Logos_Grid extends \Elementor\Widget_Base {

	public function get_name() {
		return 'nexus-logos-grid';
	}

	public function get_title() {
		return esc_html__( 'Logos Grid', 'nexus' );
	}

	public function get_icon() {
		return 'eicon-logo';
	}

	public function get_categories() {
		return array( 'nexus-elements' );
	}

	public function get_keywords() {
		return array( 'logos', 'clients', 'partners', 'brands', 'grid', 'trust', 'nexus' );
	}

	// -----------------------------------------------------------------
	// Preset defaults
	// -----------------------------------------------------------------

	private function get_preset_defaults( $preset ) {
		$map = array(
			'clean-grid'      => array(
				'tagline'     => 'Trusted By',
				'headline'    => 'Companies That Trust Us',
				'description' => 'We are proud to work with industry leaders around the world.',
				'columns'     => 5,
				'grayscale'   => true,
			),
			'bordered-cells'  => array(
				'tagline'     => 'Our Partners',
				'headline'    => 'Strategic Partnerships',
				'description' => '',
				'columns'     => 4,
				'grayscale'   => false,
			),
			'dark-showcase'   => array(
				'tagline'     => 'Clients',
				'headline'    => 'Brands We\'ve Worked With',
				'description' => '',
				'columns'     => 5,
				'grayscale'   => false,
			),
			'card-elevated'   => array(
				'tagline'     => 'Our Clients',
				'headline'    => 'Join 500+ Happy Clients',
				'description' => 'From startups to Fortune 500, we deliver results that matter.',
				'columns'     => 4,
				'grayscale'   => true,
			),
			'minimal-strip'   => array(
				'tagline'     => '',
				'headline'    => 'Trusted by leading brands worldwide',
				'description' => '',
				'columns'     => 6,
				'grayscale'   => true,
			),
			'glass-modern'    => array(
				'tagline'     => 'Portfolio',
				'headline'    => 'Our Global Partners',
				'description' => '',
				'columns'     => 4,
				'grayscale'   => false,
			),
		);

		return $map[ $preset ] ?? $map['clean-grid'];
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
					'clean-grid'      => esc_html__( '1 — Clean Grid', 'nexus' ),
					'bordered-cells'  => esc_html__( '2 — Bordered Cells', 'nexus' ),
					'dark-showcase'   => esc_html__( '3 — Dark Showcase', 'nexus' ),
					'card-elevated'   => esc_html__( '4 — Card Elevated', 'nexus' ),
					'minimal-strip'   => esc_html__( '5 — Minimal Strip', 'nexus' ),
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

		// ---- Logos Repeater ----
		$this->start_controls_section(
			'section_logos',
			array( 'label' => esc_html__( 'Logos', 'nexus' ) )
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control( 'image', array(
			'label'   => esc_html__( 'Logo Image', 'nexus' ),
			'type'    => \Elementor\Controls_Manager::MEDIA,
			'default' => array( 'url' => \Elementor\Utils::get_placeholder_image_src() ),
		) );

		$repeater->add_control( 'name', array(
			'label'   => esc_html__( 'Company Name', 'nexus' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => esc_html__( 'Company', 'nexus' ),
			'dynamic' => array( 'active' => true ),
		) );

		$repeater->add_control( 'link', array(
			'label'   => esc_html__( 'Link', 'nexus' ),
			'type'    => \Elementor\Controls_Manager::URL,
			'dynamic' => array( 'active' => true ),
		) );

		$this->add_control(
			'logos',
			array(
				'label'       => esc_html__( 'Logos', 'nexus' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array( 'name' => 'Acme Corp' ),
					array( 'name' => 'Globex' ),
					array( 'name' => 'Initech' ),
					array( 'name' => 'Umbrella' ),
					array( 'name' => 'Stark Industries' ),
					array( 'name' => 'Wayne Enterprises' ),
				),
				'title_field' => '{{{ name }}}',
			)
		);

		$this->end_controls_section();

		// ---- Layout ----
		$this->start_controls_section(
			'section_layout',
			array( 'label' => esc_html__( 'Layout', 'nexus' ) )
		);

		$this->add_responsive_control(
			'columns',
			array(
				'label'          => esc_html__( 'Columns', 'nexus' ),
				'type'           => \Elementor\Controls_Manager::SELECT,
				'default'        => 'auto',
				'tablet_default' => '3',
				'mobile_default' => '2',
				'options'        => array(
					'auto' => esc_html__( 'Auto (from preset)', 'nexus' ),
					'2'    => '2',
					'3'    => '3',
					'4'    => '4',
					'5'    => '5',
					'6'    => '6',
				),
			)
		);

		$this->add_control( 'logo_height', array(
			'label'      => esc_html__( 'Logo Max Height', 'nexus' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => array( 'px' ),
			'range'      => array( 'px' => array( 'min' => 20, 'max' => 120 ) ),
			'default'    => array( 'size' => 48, 'unit' => 'px' ),
			'selectors'  => array(
				'{{WRAPPER}} .nexus-lg-item__img' => 'max-height: {{SIZE}}{{UNIT}};',
			),
		) );

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
			'selectors' => array( '{{WRAPPER}} .nexus-lg__tagline' => 'color: {{VALUE}};' ),
		) );

		$this->add_control( 'heading_color_ctrl', array(
			'label'     => esc_html__( 'Heading Color', 'nexus' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => array( '{{WRAPPER}} .nexus-lg__title' => 'color: {{VALUE}};' ),
		) );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'heading_typography',
				'label'    => esc_html__( 'Heading Typography', 'nexus' ),
				'selector' => '{{WRAPPER}} .nexus-lg__title',
			)
		);

		$this->end_controls_section();
	}

	// -----------------------------------------------------------------
	// Render
	// -----------------------------------------------------------------

	protected function render() {
		$settings  = $this->get_settings_for_display();
		$preset    = $settings['style_preset'] ?? 'clean-grid';
		$defaults  = $this->get_preset_defaults( $preset );
		$animation = $settings['entrance_animation'] ?? 'fadeInUp';
		$is_editor = \Elementor\Plugin::$instance->editor->is_edit_mode();
		$widget_id = 'nexus-lg-' . $this->get_id();

		$tagline     = ( '' !== $settings['tagline'] ) ? $settings['tagline'] : ( $defaults['tagline'] ?? '' );
		$headline    = ( '' !== $settings['headline'] ) ? $settings['headline'] : ( $defaults['headline'] ?? '' );
		$description = ( '' !== $settings['description'] ) ? $settings['description'] : ( $defaults['description'] ?? '' );
		$align       = $settings['header_align'] ?? 'center';
		$grayscale   = $defaults['grayscale'];

		// Columns.
		$cols_setting = $settings['columns'] ?? 'auto';
		$columns      = ( 'auto' === $cols_setting ) ? $defaults['columns'] : absint( $cols_setting );

		$logos = $settings['logos'] ?? array();
		if ( empty( $logos ) ) {
			return;
		}

		$has_anim = ( 'none' !== $animation && ! $is_editor );
		$gs_class = $grayscale ? ' nexus-lg--grayscale' : '';
		?>

		<section
			class="nexus-lg nexus-lg--<?php echo esc_attr( $preset ); ?><?php echo esc_attr( $gs_class ); ?>"
			id="<?php echo esc_attr( $widget_id ); ?>"
			style="--nexus-lg-cols:<?php echo esc_attr( $columns ); ?>;"
		>
			<div class="nexus-container">

				<?php if ( $tagline || $headline || $description ) : ?>
				<div class="nexus-lg__header nexus-lg__header--<?php echo esc_attr( $align ); ?>">
					<?php if ( $tagline ) : ?>
						<span class="nexus-lg__tagline"><?php echo esc_html( $tagline ); ?></span>
					<?php endif; ?>
					<?php if ( $headline ) : ?>
						<h2 class="nexus-lg__title"><?php echo wp_kses_post( $headline ); ?></h2>
					<?php endif; ?>
					<?php if ( $description ) : ?>
						<p class="nexus-lg__desc"><?php echo wp_kses_post( $description ); ?></p>
					<?php endif; ?>
				</div>
				<?php endif; ?>

				<div class="nexus-lg__grid">
					<?php foreach ( $logos as $idx => $logo ) :
						$delay    = $idx * 80;
						$anim_cls = $has_anim ? 'nexus-lg-item--anim' : 'is-visible';
						$img_url  = ! empty( $logo['image']['url'] ) ? $logo['image']['url'] : \Elementor\Utils::get_placeholder_image_src();
						$name     = $logo['name'] ?? '';
						$has_link = ! empty( $logo['link']['url'] );
						$tag      = $has_link ? 'a' : 'div';
						$link_attr = '';
						if ( $has_link ) {
							$link_attr = ' href="' . esc_url( $logo['link']['url'] ) . '"';
							if ( ! empty( $logo['link']['is_external'] ) ) {
								$link_attr .= ' target="_blank" rel="noopener noreferrer"';
							}
						}
						?>
						<<?php echo $tag . $link_attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> class="nexus-lg-item <?php echo esc_attr( $anim_cls ); ?>"<?php echo $has_anim ? ' data-lg-delay="' . esc_attr( $delay ) . '"' : ''; ?> title="<?php echo esc_attr( $name ); ?>">
							<img
								src="<?php echo esc_url( $img_url ); ?>"
								alt="<?php echo esc_attr( $name ); ?>"
								class="nexus-lg-item__img"
								loading="lazy"
							/>
						</<?php echo esc_attr( $tag ); ?>>
					<?php endforeach; ?>
				</div>

			</div>
		</section>

		<?php if ( $has_anim ) : ?>
		<script>
		(function(){
			var container=document.getElementById('<?php echo esc_js( $widget_id ); ?>');
			if(!container)return;
			var items=container.querySelectorAll('.nexus-lg-item--anim');
			if(!items.length)return;
			var io=new IntersectionObserver(function(entries){
				entries.forEach(function(e){
					if(e.isIntersecting){
						var d=parseInt(e.target.getAttribute('data-lg-delay'),10)||0;
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
}
