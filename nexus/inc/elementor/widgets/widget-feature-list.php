<?php
/**
 * Nexus Theme - Elementor Feature List Widget
 *
 * Feature/benefit list section with 6 style presets.
 * Uses repeater for manual items with staggered entrance animations.
 *
 * @package Nexus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Nexus_Widget_Feature_List
 */
class Nexus_Widget_Feature_List extends \Elementor\Widget_Base {

	public function get_name() {
		return 'nexus-feature-list';
	}

	public function get_title() {
		return esc_html__( 'Feature List', 'nexus' );
	}

	public function get_icon() {
		return 'eicon-bullet-list';
	}

	public function get_categories() {
		return array( 'nexus-elements' );
	}

	public function get_keywords() {
		return array( 'list', 'features', 'checklist', 'benefits', 'timeline', 'nexus' );
	}

	// -----------------------------------------------------------------
	// Preset data
	// -----------------------------------------------------------------

	private function get_preset_colors( $preset ) {
		$presets = array(
			'check-list'     => array(
				'section_bg' => '#ffffff',
				'heading'    => nexus_palette()['primary'],
				'text'       => '#495057',
				'tagline'    => nexus_palette()['secondary'],
				'icon_color' => '#28a745',
				'icon_bg'    => 'rgba(40,167,69,0.1)',
				'item_bg'    => 'transparent',
				'border'     => '#e9ecef',
			),
			'icon-bordered'  => array(
				'section_bg' => nexus_palette()['light'],
				'heading'    => nexus_palette()['primary'],
				'text'       => '#495057',
				'tagline'    => nexus_palette()['secondary'],
				'icon_color' => nexus_palette()['secondary'],
				'icon_bg'    => '#ffffff',
				'item_bg'    => '#ffffff',
				'border'     => '#dee2e6',
			),
			'dark-numbered'  => array(
				'section_bg' => nexus_palette()['primary'],
				'heading'    => '#ffffff',
				'text'       => '#cbd5e1',
				'tagline'    => nexus_palette()['secondary'],
				'icon_color' => nexus_palette()['secondary'],
				'icon_bg'    => 'rgba(233,69,96,0.12)',
				'item_bg'    => 'transparent',
				'border'     => 'rgba(255,255,255,0.08)',
			),
			'timeline'       => array(
				'section_bg' => '#ffffff',
				'heading'    => nexus_palette()['primary'],
				'text'       => '#495057',
				'tagline'    => nexus_palette()['accent'],
				'icon_color' => '#ffffff',
				'icon_bg'    => nexus_palette()['secondary'],
				'item_bg'    => 'transparent',
				'border'     => '#dee2e6',
			),
			'card-grid'      => array(
				'section_bg' => '#f1f5f9',
				'heading'    => nexus_palette()['primary'],
				'text'       => '#495057',
				'tagline'    => nexus_palette()['secondary'],
				'icon_color' => nexus_palette()['secondary'],
				'icon_bg'    => 'rgba(233,69,96,0.08)',
				'item_bg'    => '#ffffff',
				'border'     => 'transparent',
			),
			'minimal-accent' => array(
				'section_bg' => '#0f0f23',
				'heading'    => '#ffffff',
				'text'       => '#e2e8f0',
				'tagline'    => nexus_palette()['secondary'],
				'icon_color' => nexus_palette()['secondary'],
				'icon_bg'    => 'transparent',
				'item_bg'    => 'rgba(255,255,255,0.03)',
				'border'     => nexus_palette()['secondary'],
			),
		);

		return $presets[ $preset ] ?? $presets['check-list'];
	}

	private function get_preset_defaults( $preset ) {
		$map = array(
			'check-list'     => array(
				'tagline'   => 'Why Choose Us',
				'headline'  => 'Benefits That Make a Difference',
				'description' => 'We deliver exceptional value through our commitment to quality and innovation.',
				'layout'    => 'list',
				'columns'   => 1,
				'icon_type' => 'check',
				'items'     => array(
					array( 'title' => 'Lightning Fast Performance', 'text' => 'Optimized for speed with lazy loading, minified assets, and efficient code structure.' ),
					array( 'title' => 'Fully Responsive Design', 'text' => 'Looks perfect on every screen size from mobile phones to ultra-wide monitors.' ),
					array( 'title' => 'SEO Optimized Structure', 'text' => 'Built with semantic HTML, proper heading hierarchy, and schema markup support.' ),
					array( 'title' => 'One-Click Demo Import', 'text' => 'Get started in minutes with our Merlin WP demo import wizard.' ),
					array( 'title' => '24/7 Premium Support', 'text' => 'Our dedicated team is always ready to help you with any questions.' ),
				),
			),
			'icon-bordered'  => array(
				'tagline'   => 'Our Services',
				'headline'  => 'What We Offer',
				'description' => 'Comprehensive solutions tailored to your business needs.',
				'layout'    => 'list',
				'columns'   => 2,
				'icon_type' => 'custom',
				'items'     => array(
					array( 'title' => 'Web Development', 'text' => 'Custom websites built with the latest technologies and best practices.' ),
					array( 'title' => 'UI/UX Design', 'text' => 'Intuitive interfaces that delight users and drive conversions.' ),
					array( 'title' => 'Digital Marketing', 'text' => 'Strategic campaigns that grow your brand and reach your audience.' ),
					array( 'title' => 'Brand Identity', 'text' => 'Memorable branding that sets you apart from the competition.' ),
				),
			),
			'dark-numbered'  => array(
				'tagline'   => 'How It Works',
				'headline'  => 'Simple Steps to Get Started',
				'description' => 'Our streamlined process makes it easy to bring your project to life.',
				'layout'    => 'list',
				'columns'   => 1,
				'icon_type' => 'number',
				'items'     => array(
					array( 'title' => 'Schedule a Consultation', 'text' => 'Book a free call with our team to discuss your project goals and requirements.' ),
					array( 'title' => 'Review the Proposal', 'text' => 'We create a detailed project plan with timeline, deliverables, and pricing.' ),
					array( 'title' => 'Development & Iteration', 'text' => 'Our team builds your solution with regular check-ins and feedback rounds.' ),
					array( 'title' => 'Launch & Support', 'text' => 'We deploy your project and provide ongoing maintenance and support.' ),
				),
			),
			'timeline'       => array(
				'tagline'   => 'Our Process',
				'headline'  => 'From Idea to Launch',
				'description' => '',
				'layout'    => 'timeline',
				'columns'   => 1,
				'icon_type' => 'number',
				'items'     => array(
					array( 'title' => 'Discovery & Research', 'text' => 'We dive deep into your industry, competitors, and target audience.' ),
					array( 'title' => 'Strategy & Planning', 'text' => 'Creating a roadmap with clear milestones and measurable goals.' ),
					array( 'title' => 'Design & Prototyping', 'text' => 'Crafting pixel-perfect designs and interactive prototypes for review.' ),
					array( 'title' => 'Development & Testing', 'text' => 'Building robust solutions with thorough quality assurance.' ),
					array( 'title' => 'Launch & Optimization', 'text' => 'Deploying your project and continuously improving based on data.' ),
				),
			),
			'card-grid'      => array(
				'tagline'   => 'Features',
				'headline'  => 'Everything You Need',
				'description' => 'A complete toolkit to build, launch, and grow your online presence.',
				'layout'    => 'grid',
				'columns'   => 3,
				'icon_type' => 'custom',
				'items'     => array(
					array( 'title' => 'Drag & Drop Builder', 'text' => 'Visual page building with Elementor — no coding required.' ),
					array( 'title' => 'WooCommerce Ready', 'text' => 'Full e-commerce support with custom shop layouts.' ),
					array( 'title' => 'Dark Mode Support', 'text' => 'Built-in dark mode with automatic system preference detection.' ),
					array( 'title' => 'RTL Compatible', 'text' => 'Full right-to-left language support out of the box.' ),
					array( 'title' => 'Translation Ready', 'text' => 'Compatible with WPML, Polylang, and standard .pot files.' ),
					array( 'title' => 'Regular Updates', 'text' => 'Continuous improvements with WordPress compatibility updates.' ),
				),
			),
			'minimal-accent' => array(
				'tagline'   => 'Advantages',
				'headline'  => 'Why We Stand Out',
				'description' => 'Key differentiators that set us apart from the rest.',
				'layout'    => 'list',
				'columns'   => 1,
				'icon_type' => 'none',
				'items'     => array(
					array( 'title' => 'Industry-Leading Expertise', 'text' => 'Over a decade of experience delivering solutions for Fortune 500 companies.' ),
					array( 'title' => 'Results-Driven Approach', 'text' => 'Every decision is backed by data and focused on measurable outcomes.' ),
					array( 'title' => 'Scalable Architecture', 'text' => 'Solutions built to grow with your business from day one.' ),
					array( 'title' => 'Transparent Communication', 'text' => 'Regular updates, honest timelines, and no hidden costs.' ),
				),
			),
		);

		return $map[ $preset ] ?? $map['check-list'];
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
				'default'     => 'check-list',
				'options'     => array(
					'check-list'     => esc_html__( '1 — Check List', 'nexus' ),
					'icon-bordered'  => esc_html__( '2 — Icon Bordered', 'nexus' ),
					'dark-numbered'  => esc_html__( '3 — Dark Numbered', 'nexus' ),
					'timeline'       => esc_html__( '4 — Timeline', 'nexus' ),
					'card-grid'      => esc_html__( '5 — Card Grid', 'nexus' ),
					'minimal-accent' => esc_html__( '6 — Minimal Accent', 'nexus' ),
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
					'fadeInLeft'  => esc_html__( 'Fade In Left', 'nexus' ),
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

		// ---- List Items ----
		$this->start_controls_section(
			'section_items',
			array( 'label' => esc_html__( 'List Items', 'nexus' ) )
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control( 'title', array(
			'label'   => esc_html__( 'Title', 'nexus' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => esc_html__( 'Feature Title', 'nexus' ),
			'dynamic' => array( 'active' => true ),
		) );

		$repeater->add_control( 'text', array(
			'label'   => esc_html__( 'Description', 'nexus' ),
			'type'    => \Elementor\Controls_Manager::TEXTAREA,
			'rows'    => 3,
			'default' => esc_html__( 'Brief description of this feature or benefit.', 'nexus' ),
			'dynamic' => array( 'active' => true ),
		) );

		$repeater->add_control( 'icon', array(
			'label'   => esc_html__( 'Icon', 'nexus' ),
			'type'    => \Elementor\Controls_Manager::ICONS,
			'default' => array(
				'value'   => 'fas fa-check',
				'library' => 'fa-solid',
			),
		) );

		$this->add_control( 'items', array(
			'label'       => esc_html__( 'Items', 'nexus' ),
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'default'     => array(
				array(
					'title' => esc_html__( 'Feature One', 'nexus' ),
					'text'  => esc_html__( 'Brief description of this feature or benefit.', 'nexus' ),
				),
				array(
					'title' => esc_html__( 'Feature Two', 'nexus' ),
					'text'  => esc_html__( 'Brief description of this feature or benefit.', 'nexus' ),
				),
				array(
					'title' => esc_html__( 'Feature Three', 'nexus' ),
					'text'  => esc_html__( 'Brief description of this feature or benefit.', 'nexus' ),
				),
			),
			'title_field' => '{{{ title }}}',
		) );

		$this->end_controls_section();
	}

	// -----------------------------------------------------------------
	// Render
	// -----------------------------------------------------------------

	protected function render() {
		$settings = $this->get_settings_for_display();
		$preset   = $settings['style_preset'] ?? 'check-list';
		$colors   = $this->get_preset_colors( $preset );
		$defaults = $this->get_preset_defaults( $preset );
		$items    = $settings['items'];

		if ( empty( $items ) ) {
			return;
		}

		// Merge defaults.
		$tagline     = ( '' !== $settings['tagline'] ) ? $settings['tagline'] : ( $defaults['tagline'] ?? '' );
		$headline    = ( '' !== $settings['headline'] ) ? $settings['headline'] : ( $defaults['headline'] ?? '' );
		$description = ( '' !== $settings['description'] ) ? $settings['description'] : ( $defaults['description'] ?? '' );
		$layout      = $defaults['layout'];
		$columns     = $defaults['columns'];
		$icon_type   = $defaults['icon_type'];
		$animation   = $settings['entrance_animation'] ?? 'fadeInUp';
		$is_editor   = \Elementor\Plugin::$instance->editor->is_edit_mode();
		$widget_id   = 'nexus-fl-' . $this->get_id();
		?>

		<section
			class="nexus-fl nexus-fl--<?php echo esc_attr( $preset ); ?>"
			style="background-color:<?php echo esc_attr( $colors['section_bg'] ); ?>;padding:5rem 0;"
			id="<?php echo esc_attr( $widget_id ); ?>"
		>
			<div class="nexus-container">

				<?php if ( $tagline || $headline || $description ) : ?>
				<div class="nexus-fl__header" style="text-align:center;margin-bottom:3rem;max-width:680px;margin-left:auto;margin-right:auto;">
					<?php if ( $tagline ) : ?>
						<span class="nexus-fl__tagline" style="display:inline-block;font-size:0.875rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:<?php echo esc_attr( $colors['tagline'] ); ?>;margin-bottom:0.75rem;">
							<?php echo esc_html( $tagline ); ?>
						</span>
					<?php endif; ?>
					<?php if ( $headline ) : ?>
						<h2 class="nexus-fl__title" style="font-size:clamp(1.5rem,3vw,2.25rem);font-weight:700;color:<?php echo esc_attr( $colors['heading'] ); ?>;margin:0 0 1rem;">
							<?php echo wp_kses_post( $headline ); ?>
						</h2>
					<?php endif; ?>
					<?php if ( $description ) : ?>
						<p class="nexus-fl__desc" style="font-size:1.0625rem;line-height:1.7;color:<?php echo esc_attr( $colors['text'] ); ?>;margin:0;">
							<?php echo wp_kses_post( $description ); ?>
						</p>
					<?php endif; ?>
				</div>
				<?php endif; ?>

				<?php if ( 'timeline' === $layout ) : ?>
					<?php $this->render_timeline( $items, $colors, $icon_type, $animation, $is_editor ); ?>
				<?php elseif ( 'grid' === $layout ) : ?>
					<?php $this->render_grid( $items, $colors, $columns, $icon_type, $animation, $is_editor ); ?>
				<?php else : ?>
					<?php $this->render_list( $items, $colors, $columns, $icon_type, $preset, $animation, $is_editor ); ?>
				<?php endif; ?>

			</div>
		</section>

		<?php if ( 'none' !== $animation && ! $is_editor ) : ?>
		<script>
		(function(){
			var container=document.getElementById('<?php echo esc_js( $widget_id ); ?>');
			if(!container)return;
			var items=container.querySelectorAll('.nexus-fl__item[data-fl-delay]');
			if(!items.length)return;
			var io=new IntersectionObserver(function(entries){
				entries.forEach(function(e){
					if(e.isIntersecting){
						var d=parseInt(e.target.getAttribute('data-fl-delay'),10)||0;
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

	/**
	 * Renders the icon/number marker for a list item.
	 *
	 * @param string $icon_type  Icon type: check|number|custom|none.
	 * @param array  $item       Repeater item.
	 * @param int    $index      Item index (0-based).
	 * @param array  $colors     Preset colors.
	 */
	private function render_icon( $icon_type, $item, $index, $colors ) {
		if ( 'none' === $icon_type ) {
			return;
		}

		$icon_style = 'display:flex;align-items:center;justify-content:center;flex-shrink:0;width:40px;height:40px;border-radius:50%;';
		$icon_style .= 'background:' . $colors['icon_bg'] . ';color:' . $colors['icon_color'] . ';';

		echo '<div class="nexus-fl__icon" style="' . esc_attr( $icon_style ) . '">';

		if ( 'number' === $icon_type ) {
			echo '<span style="font-size:1rem;font-weight:700;">' . esc_html( $index + 1 ) . '</span>';
		} elseif ( 'check' === $icon_type ) {
			echo '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>';
		} elseif ( 'custom' === $icon_type && ! empty( $item['icon']['value'] ) ) {
			\Elementor\Icons_Manager::render_icon( $item['icon'], array( 'aria-hidden' => 'true' ) );
		} else {
			echo '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>';
		}

		echo '</div>';
	}

	/**
	 * Returns animation attributes for an item.
	 *
	 * @param string $animation Animation type.
	 * @param int    $index     Item index.
	 * @param bool   $is_editor Whether in editor.
	 * @return string HTML attributes.
	 */
	private function get_anim_attrs( $animation, $index, $is_editor ) {
		if ( 'none' === $animation || $is_editor ) {
			return ' class="nexus-fl__item is-visible"';
		}

		$delay = $index * 100;
		return ' class="nexus-fl__item nexus-fl__item--anim" data-fl-delay="' . esc_attr( $delay ) . '"';
	}

	/**
	 * Renders list layout.
	 */
	private function render_list( $items, $colors, $columns, $icon_type, $preset, $animation, $is_editor ) {
		$grid_css = $columns > 1
			? 'display:grid;grid-template-columns:repeat(' . $columns . ',1fr);gap:1.5rem;'
			: 'display:flex;flex-direction:column;gap:0;';

		$item_css = 'display:flex;align-items:flex-start;gap:1rem;padding:1.25rem 0;';
		if ( $columns > 1 ) {
			$item_css = 'display:flex;align-items:flex-start;gap:1rem;padding:1.25rem;background:' . $colors['item_bg'] . ';border-radius:8px;';
			if ( 'icon-bordered' === $preset ) {
				$item_css .= 'border:1px solid ' . $colors['border'] . ';';
			}
		}

		// Minimal accent uses left border.
		if ( 'minimal-accent' === $preset ) {
			$item_css = 'display:flex;align-items:flex-start;gap:1rem;padding:1.25rem 1.5rem;background:' . $colors['item_bg'] . ';border-left:3px solid ' . $colors['border'] . ';border-radius:0 6px 6px 0;margin-bottom:0.75rem;';
		}

		// Single column list items get a bottom border (except minimal-accent).
		$show_divider = 1 === $columns && 'minimal-accent' !== $preset;
		?>

		<div class="nexus-fl__list" style="<?php echo esc_attr( $grid_css ); ?>max-width:<?php echo $columns > 1 ? '100%' : '800px'; ?>;margin:0 auto;">
			<?php foreach ( $items as $idx => $item ) : ?>
				<div<?php echo $this->get_anim_attrs( $animation, $idx, $is_editor ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> style="<?php echo esc_attr( $item_css ); ?><?php echo $show_divider ? 'border-bottom:1px solid ' . esc_attr( $colors['border'] ) . ';' : ''; ?>">
					<?php $this->render_icon( $icon_type, $item, $idx, $colors ); ?>
					<div class="nexus-fl__content" style="min-width:0;">
						<?php if ( ! empty( $item['title'] ) ) : ?>
							<h3 class="nexus-fl__item-title" style="font-size:1.0625rem;font-weight:600;color:<?php echo esc_attr( $colors['heading'] ); ?>;margin:0 0 0.375rem;">
								<?php echo esc_html( $item['title'] ); ?>
							</h3>
						<?php endif; ?>
						<?php if ( ! empty( $item['text'] ) ) : ?>
							<p class="nexus-fl__item-text" style="font-size:0.9375rem;line-height:1.65;color:<?php echo esc_attr( $colors['text'] ); ?>;margin:0;">
								<?php echo wp_kses_post( $item['text'] ); ?>
							</p>
						<?php endif; ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>

		<?php
	}

	/**
	 * Renders grid layout.
	 */
	private function render_grid( $items, $colors, $columns, $icon_type, $animation, $is_editor ) {
		?>

		<div class="nexus-fl__grid" style="display:grid;grid-template-columns:repeat(<?php echo esc_attr( $columns ); ?>,1fr);gap:1.5rem;">
			<?php foreach ( $items as $idx => $item ) : ?>
				<div<?php echo $this->get_anim_attrs( $animation, $idx, $is_editor ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> style="background:<?php echo esc_attr( $colors['item_bg'] ); ?>;border-radius:12px;padding:2rem;box-shadow:0 2px 12px rgba(0,0,0,0.06);text-align:center;">
					<div style="margin:0 auto 1rem;">
						<?php $this->render_icon( $icon_type, $item, $idx, $colors ); ?>
					</div>
					<?php if ( ! empty( $item['title'] ) ) : ?>
						<h3 class="nexus-fl__item-title" style="font-size:1.0625rem;font-weight:600;color:<?php echo esc_attr( $colors['heading'] ); ?>;margin:0 0 0.5rem;">
							<?php echo esc_html( $item['title'] ); ?>
						</h3>
					<?php endif; ?>
					<?php if ( ! empty( $item['text'] ) ) : ?>
						<p class="nexus-fl__item-text" style="font-size:0.875rem;line-height:1.65;color:<?php echo esc_attr( $colors['text'] ); ?>;margin:0;">
							<?php echo wp_kses_post( $item['text'] ); ?>
						</p>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>

		<?php
	}

	/**
	 * Renders timeline layout.
	 */
	private function render_timeline( $items, $colors, $icon_type, $animation, $is_editor ) {
		$line_color = $colors['border'];
		?>

		<div class="nexus-fl__timeline" style="position:relative;max-width:700px;margin:0 auto;padding-left:40px;">
			<?php // Vertical line. ?>
			<div class="nexus-fl__timeline-line" style="position:absolute;left:19px;top:0;bottom:0;width:2px;background:<?php echo esc_attr( $line_color ); ?>;"></div>

			<?php foreach ( $items as $idx => $item ) : ?>
				<div<?php echo $this->get_anim_attrs( $animation, $idx, $is_editor ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> style="position:relative;padding:0 0 2.5rem 2rem;">
					<?php // Timeline dot/number. ?>
					<div class="nexus-fl__timeline-dot" style="position:absolute;left:-21px;top:2px;z-index:1;">
						<?php $this->render_icon( $icon_type, $item, $idx, $colors ); ?>
					</div>

					<?php if ( ! empty( $item['title'] ) ) : ?>
						<h3 class="nexus-fl__item-title" style="font-size:1.125rem;font-weight:600;color:<?php echo esc_attr( $colors['heading'] ); ?>;margin:0 0 0.5rem;">
							<?php echo esc_html( $item['title'] ); ?>
						</h3>
					<?php endif; ?>
					<?php if ( ! empty( $item['text'] ) ) : ?>
						<p class="nexus-fl__item-text" style="font-size:0.9375rem;line-height:1.7;color:<?php echo esc_attr( $colors['text'] ); ?>;margin:0;">
							<?php echo wp_kses_post( $item['text'] ); ?>
						</p>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>

		<?php
	}
}
