<?php
/**
 * Nexus Theme - Elementor Blog Cards Widget
 *
 * Static blog-style card section with 6 style presets.
 * Uses section heading + WP_Query for real posts, styled
 * per preset with staggered entrance animations.
 *
 * @package Nexus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Nexus_Widget_Blog_Cards
 */
class Nexus_Widget_Blog_Cards extends \Elementor\Widget_Base {

	public function get_name() {
		return 'nexus-blog-cards';
	}

	public function get_title() {
		return esc_html__( 'Blog Cards', 'nexus' );
	}

	public function get_icon() {
		return 'eicon-posts-carousel';
	}

	public function get_categories() {
		return array( 'nexus-elements' );
	}

	public function get_keywords() {
		return array( 'blog', 'cards', 'news', 'articles', 'section', 'nexus' );
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
			'classic-light'     => array(
				'section_bg' => '#ffffff',
				'card_bg'    => '#ffffff',
				'heading'    => nexus_palette()['primary'],
				'text'       => '#495057',
				'meta'       => '#6c757d',
				'tagline'    => nexus_palette()['secondary'],
				'btn_text'   => nexus_palette()['secondary'],
			),
			'minimal-bordered'  => array(
				'section_bg' => nexus_palette()['light'],
				'card_bg'    => '#ffffff',
				'heading'    => nexus_palette()['primary'],
				'text'       => '#495057',
				'meta'       => '#6c757d',
				'tagline'    => nexus_palette()['secondary'],
				'btn_text'   => nexus_palette()['primary'],
			),
			'dark-elegant'      => array(
				'section_bg' => nexus_palette()['primary'],
				'card_bg'    => nexus_palette()['dark'],
				'heading'    => '#ffffff',
				'text'       => '#cbd5e1',
				'meta'       => '#94a3b8',
				'tagline'    => nexus_palette()['secondary'],
				'btn_text'   => nexus_palette()['secondary'],
			),
			'overlay-gradient'  => array(
				'section_bg' => '#0f0f23',
				'card_bg'    => 'transparent',
				'heading'    => '#ffffff',
				'text'       => '#e2e8f0',
				'meta'       => 'rgba(255,255,255,0.6)',
				'tagline'    => nexus_palette()['secondary'],
				'btn_text'   => '#ffffff',
			),
			'side-image'        => array(
				'section_bg' => '#ffffff',
				'card_bg'    => '#ffffff',
				'heading'    => nexus_palette()['primary'],
				'text'       => '#495057',
				'meta'       => '#6c757d',
				'tagline'    => nexus_palette()['secondary'],
				'btn_text'   => nexus_palette()['secondary'],
			),
			'magazine-featured' => array(
				'section_bg' => '#f1f5f9',
				'card_bg'    => '#ffffff',
				'heading'    => nexus_palette()['primary'],
				'text'       => '#495057',
				'meta'       => '#6c757d',
				'tagline'    => nexus_palette()['secondary'],
				'btn_text'   => '#ffffff',
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
			'classic-light'     => array(
				'tagline'       => 'Our Blog',
				'headline'      => 'Latest Insights & Articles',
				'description'   => 'Stay updated with the latest trends, tips, and industry insights from our expert team.',
				'posts_count'   => 3,
				'btn_text'      => 'Read More',
				'btn_style'     => 'ghost-accent',
				'section_btn'   => 'View All Posts',
				'section_style' => 'primary',
			),
			'minimal-bordered'  => array(
				'tagline'       => 'Blog',
				'headline'      => 'Recent Publications',
				'description'   => 'Explore our collection of articles covering design, development, and digital strategy.',
				'posts_count'   => 3,
				'btn_text'      => 'Continue Reading',
				'btn_style'     => 'outline-dark',
				'section_btn'   => 'Browse All',
				'section_style' => 'secondary',
			),
			'dark-elegant'      => array(
				'tagline'       => 'Resources',
				'headline'      => 'Knowledge Hub',
				'description'   => 'Deep dives into technology, business growth, and creative innovation.',
				'posts_count'   => 3,
				'btn_text'      => 'Explore',
				'btn_style'     => 'ghost-accent',
				'section_btn'   => 'See All Resources',
				'section_style' => 'primary',
			),
			'overlay-gradient'  => array(
				'tagline'       => 'Stories',
				'headline'      => 'Featured Stories',
				'description'   => '',
				'posts_count'   => 3,
				'btn_text'      => 'Read Story',
				'btn_style'     => 'outline-white',
				'section_btn'   => '',
				'section_style' => 'primary',
			),
			'side-image'        => array(
				'tagline'       => 'News & Updates',
				'headline'      => "What's New",
				'description'   => 'The latest announcements, case studies, and thought leadership from our team.',
				'posts_count'   => 4,
				'btn_text'      => 'Read Article',
				'btn_style'     => 'ghost-accent',
				'section_btn'   => 'All Articles',
				'section_style' => 'outline',
			),
			'magazine-featured' => array(
				'tagline'       => 'Featured',
				'headline'      => 'Editor\'s Picks',
				'description'   => 'Hand-picked articles by our editorial team — the best reads this month.',
				'posts_count'   => 4,
				'btn_text'      => 'Read More',
				'btn_style'     => 'primary',
				'section_btn'   => 'View All',
				'section_style' => 'secondary',
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
		$base = 'display:inline-flex;align-items:center;gap:0.4em;font-size:0.875rem;font-weight:600;line-height:1.5;text-decoration:none;cursor:pointer;transition:all 0.3s ease;';
		$btn  = 'display:inline-flex;align-items:center;justify-content:center;padding:0.75em 1.75em;font-size:1rem;font-weight:600;line-height:1.5;border-radius:6px;text-decoration:none;border:2px solid transparent;cursor:pointer;transition:all 0.3s ease;';

		$styles = array(
			'ghost-accent'  => $base . 'color:' . nexus_palette()['secondary'] . ';padding:0;border:none;background:transparent;',
			'ghost-white'   => $base . 'color:#ffffff;padding:0;border:none;background:transparent;',
			'ghost-dark'    => $base . 'color:' . nexus_palette()['primary'] . ';padding:0;border:none;background:transparent;',
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
				'default'     => 'classic-light',
				'options'     => array(
					'classic-light'     => esc_html__( '1 — Classic Light', 'nexus' ),
					'minimal-bordered'  => esc_html__( '2 — Minimal Bordered', 'nexus' ),
					'dark-elegant'      => esc_html__( '3 — Dark Elegant', 'nexus' ),
					'overlay-gradient'  => esc_html__( '4 — Overlay Gradient', 'nexus' ),
					'side-image'        => esc_html__( '5 — Side Image', 'nexus' ),
					'magazine-featured' => esc_html__( '6 — Magazine Featured', 'nexus' ),
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

		// ---- Query ----
		$this->start_controls_section(
			'section_query',
			array( 'label' => esc_html__( 'Query', 'nexus' ) )
		);

		$this->add_control( 'posts_count', array(
			'label'   => esc_html__( 'Posts to Show', 'nexus' ),
			'type'    => \Elementor\Controls_Manager::NUMBER,
			'default' => 0,
			'min'     => 0,
			'max'     => 12,
			'description' => esc_html__( '0 = use preset default.', 'nexus' ),
		) );

		$this->add_control( 'category_ids', array(
			'label'       => esc_html__( 'Categories', 'nexus' ),
			'type'        => \Elementor\Controls_Manager::SELECT2,
			'multiple'    => true,
			'options'     => $this->get_post_categories(),
			'label_block' => true,
		) );

		$this->add_control( 'orderby', array(
			'label'   => esc_html__( 'Order By', 'nexus' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'date',
			'options' => array(
				'date'          => esc_html__( 'Date', 'nexus' ),
				'title'         => esc_html__( 'Title', 'nexus' ),
				'comment_count' => esc_html__( 'Comments', 'nexus' ),
				'rand'          => esc_html__( 'Random', 'nexus' ),
			),
		) );

		$this->add_control( 'show_excerpt', array(
			'label'   => esc_html__( 'Show Excerpt', 'nexus' ),
			'type'    => \Elementor\Controls_Manager::SWITCHER,
			'default' => 'yes',
		) );

		$this->add_control( 'excerpt_length', array(
			'label'     => esc_html__( 'Excerpt Length (words)', 'nexus' ),
			'type'      => \Elementor\Controls_Manager::NUMBER,
			'default'   => 16,
			'min'       => 5,
			'max'       => 60,
			'condition' => array( 'show_excerpt' => 'yes' ),
		) );

		$this->end_controls_section();

		// ---- Buttons ----
		$this->start_controls_section(
			'section_buttons',
			array( 'label' => esc_html__( 'Buttons', 'nexus' ) )
		);

		$card_btn_styles = array(
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
			'options' => $card_btn_styles,
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
			'options' => $card_btn_styles,
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
			'selectors' => array( '{{WRAPPER}} .nexus-bc__headline' => 'color: {{VALUE}} !important;' ),
		) );

		$this->add_control( 'card_title_color', array(
			'label'     => esc_html__( 'Card Title Color', 'nexus' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => array( '{{WRAPPER}} .nexus-bc__card-title' => 'color: {{VALUE}} !important;' ),
		) );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'headline_typography',
				'selector' => '{{WRAPPER}} .nexus-bc__headline',
			)
		);

		$this->add_responsive_control( 'section_padding', array(
			'label'      => esc_html__( 'Padding', 'nexus' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => array( 'px', 'em' ),
			'selectors'  => array(
				'{{WRAPPER}} .nexus-bc' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
			),
		) );

		$this->end_controls_section();
	}

	// -----------------------------------------------------------------
	// Render
	// -----------------------------------------------------------------

	protected function render() {
		$settings  = $this->get_settings_for_display();
		$preset    = $settings['style_preset'] ?? 'classic-light';
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

		$show_excerpt = 'yes' === ( $settings['show_excerpt'] ?? 'yes' );
		$excerpt_len  = absint( $settings['excerpt_length'] ?? 16 );
		$posts_count  = absint( $settings['posts_count'] ?? 0 );
		if ( 0 === $posts_count ) {
			$posts_count = $defaults['posts_count'];
		}

		$has_anim = ( 'none' !== $anim && ! $is_editor );
		$uid      = 'nexus-bc-' . $this->get_id();
		$hidden   = $has_anim ? 'opacity:0;' : '';

		// Query.
		$args = array(
			'post_type'      => 'post',
			'posts_per_page' => $posts_count,
			'orderby'        => sanitize_key( $settings['orderby'] ?? 'date' ),
			'order'          => 'DESC',
			'no_found_rows'  => true,
		);

		if ( ! empty( $settings['category_ids'] ) ) {
			$args['cat'] = implode( ',', array_map( 'absint', $settings['category_ids'] ) );
		}

		$query = new \WP_Query( $args );

		// Section styles.
		$section_css = 'padding:5rem 2rem;position:relative;overflow:hidden;box-sizing:border-box;';
		if ( ! empty( $colors['section_bg'] ) && 'transparent' !== $colors['section_bg'] ) {
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
				.nexus-bc-anim--visible{animation-duration:0.6s;animation-fill-mode:both;animation-timing-function:cubic-bezier(0.25,0.46,0.45,0.94)}
				.nexus-bc-anim--fadeInUp.nexus-bc-anim--visible{animation-name:nexusFadeInUp}
				.nexus-bc-anim--fadeInDown.nexus-bc-anim--visible{animation-name:nexusFadeInDown}
				.nexus-bc-anim--fadeInLeft.nexus-bc-anim--visible{animation-name:nexusFadeInLeft}
				.nexus-bc-anim--fadeInRight.nexus-bc-anim--visible{animation-name:nexusFadeInRight}
				.nexus-bc-anim--zoomIn.nexus-bc-anim--visible{animation-name:nexusZoomIn}
			</style>
		<?php endif; ?>

		<div id="<?php echo esc_attr( $uid ); ?>" class="nexus-bc nexus-bc--<?php echo esc_attr( $preset ); ?>" style="<?php echo esc_attr( $section_css ); ?>">
			<div class="nexus-bc__inner" style="max-width:1200px;margin:0 auto;">

				<?php // Section header. ?>
				<?php if ( $tagline || $headline || $description ) : ?>
					<div class="nexus-bc__header" style="margin-bottom:3rem;<?php echo 'overlay-gradient' === $preset ? 'text-align:center;' : ''; ?>">
						<?php if ( $tagline ) : ?>
							<p class="nexus-bc__tagline nexus-bc-anim--<?php echo esc_attr( $anim ); ?>" data-bc-delay="0" style="<?php echo esc_attr( $hidden ); ?>color:<?php echo esc_attr( $colors['tagline'] ); ?>;font-size:0.875rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;margin:0 0 0.5rem;">
								<?php echo esc_html( $tagline ); ?>
							</p>
						<?php endif; ?>

						<?php if ( $headline ) : ?>
							<h2 class="nexus-bc__headline nexus-bc-anim--<?php echo esc_attr( $anim ); ?>" data-bc-delay="100" style="<?php echo esc_attr( $hidden ); ?>color:<?php echo esc_attr( $colors['heading'] ); ?>;font-size:clamp(1.5rem,3vw,2.25rem);font-weight:700;line-height:1.25;margin:0 0 0.75rem;">
								<?php echo wp_kses_post( $headline ); ?>
							</h2>
						<?php endif; ?>

						<?php if ( $description ) : ?>
							<p class="nexus-bc__desc nexus-bc-anim--<?php echo esc_attr( $anim ); ?>" data-bc-delay="200" style="<?php echo esc_attr( $hidden ); ?>color:<?php echo esc_attr( $colors['text'] ); ?>;font-size:1rem;line-height:1.7;margin:0;max-width:600px;">
								<?php echo wp_kses_post( $description ); ?>
							</p>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<?php // Cards grid. ?>
				<?php if ( $query->have_posts() ) : ?>
					<?php $this->render_cards( $query, $preset, $colors, $btn_text, $btn_key, $anim, $hidden, $show_excerpt, $excerpt_len ); ?>
				<?php else : ?>
					<p style="color:<?php echo esc_attr( $colors['text'] ); ?>;"><?php esc_html_e( 'No posts found.', 'nexus' ); ?></p>
				<?php endif; ?>

				<?php // Section button. ?>
				<?php if ( $section_btn ) : ?>
					<?php
					$sec_url    = ! empty( $settings['section_btn_link']['url'] ) ? esc_url( $settings['section_btn_link']['url'] ) : '#';
					$sec_target = ! empty( $settings['section_btn_link']['is_external'] ) ? 'target="_blank" rel="noopener noreferrer"' : '';
					?>
					<div class="nexus-bc__footer nexus-bc-anim--<?php echo esc_attr( $anim ); ?>" data-bc-delay="500" style="<?php echo esc_attr( $hidden ); ?>margin-top:2.5rem;<?php echo 'overlay-gradient' === $preset ? 'text-align:center;' : ''; ?>">
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
				var items=root.querySelectorAll('[data-bc-delay]');
				var obs=new IntersectionObserver(function(entries){
					entries.forEach(function(e){
						if(e.isIntersecting){
							items.forEach(function(el){
								var d=parseInt(el.getAttribute('data-bc-delay'),10)||0;
								setTimeout(function(){
									el.style.opacity='';
									el.classList.add('nexus-bc-anim--visible');
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
		wp_reset_postdata();
	}

	/**
	 * Render the post cards.
	 *
	 * @param \WP_Query $query        WP Query.
	 * @param string    $preset       Preset key.
	 * @param array     $colors       Colors map.
	 * @param string    $btn_text     Card button text.
	 * @param string    $btn_key      Card button style key.
	 * @param string    $anim         Animation name.
	 * @param string    $hidden       Hidden inline style.
	 * @param bool      $show_excerpt Whether to show excerpt.
	 * @param int       $excerpt_len  Excerpt word length.
	 */
	private function render_cards( $query, $preset, $colors, $btn_text, $btn_key, $anim, $hidden, $show_excerpt, $excerpt_len ) {

		$is_side   = ( 'side-image' === $preset );
		$is_overlay = ( 'overlay-gradient' === $preset );
		$is_mag    = ( 'magazine-featured' === $preset );
		$card_idx  = 0;

		// Grid wrapper.
		$grid_style = 'display:grid;gap:2rem;';
		if ( $is_side ) {
			$grid_style .= 'grid-template-columns:1fr;';
		} elseif ( $is_mag ) {
			$grid_style .= 'grid-template-columns:repeat(2,1fr);';
		} else {
			$grid_style .= 'grid-template-columns:repeat(3,1fr);';
		}
		?>
		<div class="nexus-bc__grid" style="<?php echo esc_attr( $grid_style ); ?>">
			<?php
			while ( $query->have_posts() ) :
				$query->the_post();
				$delay = 300 + ( $card_idx * 100 );

				$cats    = get_the_category();
				$cat     = ! empty( $cats ) ? $cats[0] : null;
				$excerpt = $show_excerpt ? wp_trim_words( get_the_excerpt(), $excerpt_len, '&hellip;' ) : '';

				if ( $is_overlay ) {
					$this->render_card_overlay( $colors, $btn_text, $btn_key, $anim, $hidden, $delay, $cat, $excerpt );
				} elseif ( $is_side ) {
					$this->render_card_side( $colors, $btn_text, $btn_key, $anim, $hidden, $delay, $cat, $excerpt );
				} elseif ( $is_mag && 0 === $card_idx ) {
					$this->render_card_magazine_featured( $colors, $btn_text, $btn_key, $anim, $hidden, $delay, $cat, $excerpt );
				} else {
					$this->render_card_standard( $preset, $colors, $btn_text, $btn_key, $anim, $hidden, $delay, $cat, $excerpt );
				}

				++$card_idx;
			endwhile;
			?>
		</div>
		<?php
	}

	/**
	 * Standard card (styles 1, 2, 3, 6 non-featured).
	 */
	private function render_card_standard( $preset, $colors, $btn_text, $btn_key, $anim, $hidden, $delay, $cat, $excerpt ) {
		$card_css = 'overflow:hidden;border-radius:12px;transition:transform 0.3s ease,box-shadow 0.3s ease;';
		$card_css .= 'background-color:' . $colors['card_bg'] . ';';

		if ( 'minimal-bordered' === $preset ) {
			$card_css .= 'border:1px solid #e2e8f0;';
		} elseif ( 'classic-light' === $preset || 'magazine-featured' === $preset ) {
			$card_css .= 'box-shadow:0 4px 20px rgba(0,0,0,0.08);';
		} elseif ( 'dark-elegant' === $preset ) {
			$card_css .= 'border:1px solid rgba(255,255,255,0.08);';
		}
		?>
		<article class="nexus-bc__card nexus-bc-anim--<?php echo esc_attr( $anim ); ?>" data-bc-delay="<?php echo esc_attr( $delay ); ?>" style="<?php echo esc_attr( $hidden . $card_css ); ?>">

			<?php if ( has_post_thumbnail() ) : ?>
				<a href="<?php the_permalink(); ?>" class="nexus-bc__card-thumb" style="display:block;overflow:hidden;aspect-ratio:16/10;">
					<?php the_post_thumbnail( 'nexus-medium', array(
						'style'   => 'width:100%;height:100%;object-fit:cover;display:block;transition:transform 0.4s ease;',
						'loading' => 'lazy',
					) ); ?>
				</a>
			<?php endif; ?>

			<div class="nexus-bc__card-body" style="padding:1.25rem 1.5rem 1.5rem;">
				<?php if ( $cat ) : ?>
					<span class="nexus-bc__card-cat" style="display:inline-block;font-size:0.75rem;font-weight:600;color:<?php echo esc_attr( $colors['tagline'] ); ?>;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.5rem;">
						<?php echo esc_html( $cat->name ); ?>
					</span>
				<?php endif; ?>

				<h3 class="nexus-bc__card-title" style="font-size:1.125rem;font-weight:700;line-height:1.35;margin:0 0 0.5rem;">
					<a href="<?php the_permalink(); ?>" style="color:<?php echo esc_attr( $colors['heading'] ); ?>;text-decoration:none;">
						<?php the_title(); ?>
					</a>
				</h3>

				<?php if ( $excerpt ) : ?>
					<p class="nexus-bc__card-excerpt" style="font-size:0.875rem;line-height:1.6;color:<?php echo esc_attr( $colors['text'] ); ?>;margin:0 0 1rem;">
						<?php echo esc_html( $excerpt ); ?>
					</p>
				<?php endif; ?>

				<div class="nexus-bc__card-footer" style="display:flex;align-items:center;justify-content:space-between;">
					<time style="font-size:0.8125rem;color:<?php echo esc_attr( $colors['meta'] ); ?>;" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
						<?php echo esc_html( get_the_date( 'M j, Y' ) ); ?>
					</time>

					<?php if ( $btn_text ) : ?>
						<a href="<?php the_permalink(); ?>" class="nexus-btn nexus-btn--<?php echo esc_attr( $btn_key ); ?>" style="<?php echo esc_attr( $this->get_button_inline_style( $btn_key ) ); ?>">
							<?php echo esc_html( $btn_text ); ?>
							<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
						</a>
					<?php endif; ?>
				</div>
			</div>

		</article>
		<?php
	}

	/**
	 * Overlay gradient card (style 4).
	 */
	private function render_card_overlay( $colors, $btn_text, $btn_key, $anim, $hidden, $delay, $cat, $excerpt ) {
		$thumb_url = get_the_post_thumbnail_url( get_the_ID(), 'nexus-medium' );
		$bg_img    = $thumb_url ? "background-image:url('" . esc_url( $thumb_url ) . "');" : '';
		?>
		<article class="nexus-bc__card nexus-bc__card--overlay nexus-bc-anim--<?php echo esc_attr( $anim ); ?>" data-bc-delay="<?php echo esc_attr( $delay ); ?>" style="<?php echo esc_attr( $hidden ); ?>position:relative;border-radius:16px;overflow:hidden;min-height:340px;display:flex;flex-direction:column;justify-content:flex-end;<?php echo esc_attr( $bg_img ); ?>background-size:cover;background-position:center;">

			<div style="position:absolute;inset:0;background:linear-gradient(to top,rgba(0,0,0,0.85) 0%,rgba(0,0,0,0.2) 60%,transparent 100%);"></div>

			<div class="nexus-bc__card-body" style="position:relative;z-index:1;padding:1.5rem;">
				<?php if ( $cat ) : ?>
					<span style="display:inline-block;font-size:0.75rem;font-weight:600;color:<?php echo esc_attr( $colors['tagline'] ); ?>;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.5rem;">
						<?php echo esc_html( $cat->name ); ?>
					</span>
				<?php endif; ?>

				<h3 class="nexus-bc__card-title" style="font-size:1.25rem;font-weight:700;line-height:1.3;margin:0 0 0.5rem;">
					<a href="<?php the_permalink(); ?>" style="color:#fff;text-decoration:none;"><?php the_title(); ?></a>
				</h3>

				<?php if ( $excerpt ) : ?>
					<p style="font-size:0.85rem;line-height:1.6;color:<?php echo esc_attr( $colors['text'] ); ?>;margin:0 0 0.75rem;">
						<?php echo esc_html( $excerpt ); ?>
					</p>
				<?php endif; ?>

				<?php if ( $btn_text ) : ?>
					<a href="<?php the_permalink(); ?>" class="nexus-btn nexus-btn--<?php echo esc_attr( $btn_key ); ?>" style="<?php echo esc_attr( $this->get_button_inline_style( $btn_key ) ); ?>">
						<?php echo esc_html( $btn_text ); ?>
						<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
					</a>
				<?php endif; ?>
			</div>

		</article>
		<?php
	}

	/**
	 * Side image card (style 5) — horizontal layout.
	 */
	private function render_card_side( $colors, $btn_text, $btn_key, $anim, $hidden, $delay, $cat, $excerpt ) {
		?>
		<article class="nexus-bc__card nexus-bc__card--side nexus-bc-anim--<?php echo esc_attr( $anim ); ?>" data-bc-delay="<?php echo esc_attr( $delay ); ?>" style="<?php echo esc_attr( $hidden ); ?>display:flex;gap:1.5rem;align-items:center;background-color:<?php echo esc_attr( $colors['card_bg'] ); ?>;border-radius:12px;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,0.06);transition:transform 0.3s ease,box-shadow 0.3s ease;">

			<?php if ( has_post_thumbnail() ) : ?>
				<a href="<?php the_permalink(); ?>" class="nexus-bc__card-side-thumb" style="display:block;flex:0 0 280px;max-width:280px;overflow:hidden;">
					<?php the_post_thumbnail( 'nexus-medium', array(
						'style'   => 'width:100%;height:200px;object-fit:cover;display:block;transition:transform 0.4s ease;',
						'loading' => 'lazy',
					) ); ?>
				</a>
			<?php endif; ?>

			<div class="nexus-bc__card-body" style="flex:1;min-width:0;padding:1.25rem 1.5rem 1.25rem 0;">
				<div style="display:flex;align-items:center;gap:1rem;margin-bottom:0.5rem;">
					<?php if ( $cat ) : ?>
						<span style="font-size:0.75rem;font-weight:600;color:<?php echo esc_attr( $colors['tagline'] ); ?>;text-transform:uppercase;letter-spacing:0.05em;">
							<?php echo esc_html( $cat->name ); ?>
						</span>
					<?php endif; ?>
					<time style="font-size:0.8125rem;color:<?php echo esc_attr( $colors['meta'] ); ?>;" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
						<?php echo esc_html( get_the_date( 'M j, Y' ) ); ?>
					</time>
				</div>

				<h3 class="nexus-bc__card-title" style="font-size:1.125rem;font-weight:700;line-height:1.35;margin:0 0 0.5rem;">
					<a href="<?php the_permalink(); ?>" style="color:<?php echo esc_attr( $colors['heading'] ); ?>;text-decoration:none;"><?php the_title(); ?></a>
				</h3>

				<?php if ( $excerpt ) : ?>
					<p style="font-size:0.875rem;line-height:1.6;color:<?php echo esc_attr( $colors['text'] ); ?>;margin:0 0 0.75rem;">
						<?php echo esc_html( $excerpt ); ?>
					</p>
				<?php endif; ?>

				<?php if ( $btn_text ) : ?>
					<a href="<?php the_permalink(); ?>" class="nexus-btn nexus-btn--<?php echo esc_attr( $btn_key ); ?>" style="<?php echo esc_attr( $this->get_button_inline_style( $btn_key ) ); ?>">
						<?php echo esc_html( $btn_text ); ?>
						<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
					</a>
				<?php endif; ?>
			</div>

		</article>
		<?php
	}

	/**
	 * Magazine featured card (style 6, first card only) — spans full width.
	 */
	private function render_card_magazine_featured( $colors, $btn_text, $btn_key, $anim, $hidden, $delay, $cat, $excerpt ) {
		?>
		<article class="nexus-bc__card nexus-bc__card--mag-featured nexus-bc-anim--<?php echo esc_attr( $anim ); ?>" data-bc-delay="<?php echo esc_attr( $delay ); ?>" style="<?php echo esc_attr( $hidden ); ?>grid-column:1/-1;display:flex;gap:2rem;align-items:center;background-color:<?php echo esc_attr( $colors['card_bg'] ); ?>;border-radius:12px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,0.08);transition:transform 0.3s ease,box-shadow 0.3s ease;">

			<?php if ( has_post_thumbnail() ) : ?>
				<a href="<?php the_permalink(); ?>" class="nexus-bc__card-mag-thumb" style="display:block;flex:0 0 50%;overflow:hidden;">
					<?php the_post_thumbnail( 'large', array(
						'style'   => 'width:100%;height:320px;object-fit:cover;display:block;transition:transform 0.4s ease;',
						'loading' => 'lazy',
					) ); ?>
				</a>
			<?php endif; ?>

			<div class="nexus-bc__card-body" style="flex:1;min-width:0;padding:2rem;">
				<?php if ( $cat ) : ?>
					<span style="display:inline-block;font-size:0.75rem;font-weight:600;color:<?php echo esc_attr( $colors['tagline'] ); ?>;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.75rem;">
						<?php echo esc_html( $cat->name ); ?>
					</span>
				<?php endif; ?>

				<h3 class="nexus-bc__card-title" style="font-size:1.5rem;font-weight:700;line-height:1.3;margin:0 0 0.75rem;">
					<a href="<?php the_permalink(); ?>" style="color:<?php echo esc_attr( $colors['heading'] ); ?>;text-decoration:none;"><?php the_title(); ?></a>
				</h3>

				<?php if ( $excerpt ) : ?>
					<p style="font-size:0.9375rem;line-height:1.7;color:<?php echo esc_attr( $colors['text'] ); ?>;margin:0 0 1.25rem;">
						<?php echo esc_html( $excerpt ); ?>
					</p>
				<?php endif; ?>

				<div style="display:flex;align-items:center;gap:1.5rem;">
					<?php if ( $btn_text ) : ?>
						<a href="<?php the_permalink(); ?>" class="nexus-btn nexus-btn--<?php echo esc_attr( $btn_key ); ?>" style="<?php echo esc_attr( $this->get_button_inline_style( $btn_key ) ); ?>">
							<?php echo esc_html( $btn_text ); ?>
						</a>
					<?php endif; ?>
					<time style="font-size:0.8125rem;color:<?php echo esc_attr( $colors['meta'] ); ?>;" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
						<?php echo esc_html( get_the_date( 'M j, Y' ) ); ?>
					</time>
				</div>
			</div>

		</article>
		<?php
	}

	/**
	 * Get post categories for control options.
	 *
	 * @return array
	 */
	private function get_post_categories() {
		$opts = array();
		$cats = get_categories( array( 'hide_empty' => false ) );
		foreach ( $cats as $cat ) {
			$opts[ $cat->term_id ] = $cat->name;
		}
		return $opts;
	}
}
