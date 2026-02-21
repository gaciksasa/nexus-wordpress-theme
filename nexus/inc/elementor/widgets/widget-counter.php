<?php
/**
 * Nexus Theme - Elementor Counter Widget
 *
 * Animated number counter with icon and label.
 *
 * @package Nexus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Nexus_Widget_Counter
 */
class Nexus_Widget_Counter extends \Elementor\Widget_Base {

	public function get_name() {
		return 'nexus-counter';
	}

	public function get_title() {
		return esc_html__( 'Counter', 'nexus' );
	}

	public function get_icon() {
		return 'eicon-counter';
	}

	public function get_categories() {
		return array( 'nexus-elements' );
	}

	public function get_keywords() {
		return array( 'counter', 'stat', 'number', 'count', 'animate', 'nexus' );
	}

	protected function register_controls() {

		// ---------------------------------------------------------------
		// CONTENT
		// ---------------------------------------------------------------
		$this->start_controls_section(
			'section_content',
			array( 'label' => esc_html__( 'Counter', 'nexus' ) )
		);

		$this->add_control(
			'icon',
			array(
				'label'   => esc_html__( 'Icon', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::ICONS,
				'default' => array(
					'value'   => 'ri-award-line',
					'library' => 'remix-icon',
				),
			)
		);

		$this->add_control(
			'starting_number',
			array(
				'label'   => esc_html__( 'Starting Number', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 0,
				'min'     => 0,
			)
		);

		$this->add_control(
			'ending_number',
			array(
				'label'   => esc_html__( 'Ending Number', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 250,
				'min'     => 0,
			)
		);

		$this->add_control(
			'prefix',
			array(
				'label'   => esc_html__( 'Number Prefix', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => '',
			)
		);

		$this->add_control(
			'suffix',
			array(
				'label'   => esc_html__( 'Number Suffix', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => '+',
			)
		);

		$this->add_control(
			'title',
			array(
				'label'   => esc_html__( 'Title', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Happy Clients', 'nexus' ),
				'dynamic' => array( 'active' => true ),
			)
		);

		$this->add_control(
			'description',
			array(
				'label'   => esc_html__( 'Description', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => '',
				'dynamic' => array( 'active' => true ),
			)
		);

		$this->add_control(
			'duration',
			array(
				'label'   => esc_html__( 'Animation Duration (ms)', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 2000,
				'min'     => 500,
				'max'     => 10000,
				'step'    => 100,
			)
		);

		$this->add_control(
			'separator',
			array(
				'label'   => esc_html__( 'Thousands Separator', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => '',
			)
		);

		$this->end_controls_section();

		// ---------------------------------------------------------------
		// STYLE: Layout
		// ---------------------------------------------------------------
		$this->start_controls_section(
			'section_style_layout',
			array(
				'label' => esc_html__( 'Layout', 'nexus' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'text_align',
			array(
				'label'     => esc_html__( 'Alignment', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'nexus' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'nexus' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'nexus' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => 'center',
				'selectors' => array(
					'{{WRAPPER}} .nexus-counter' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		// ---------------------------------------------------------------
		// STYLE: Icon
		// ---------------------------------------------------------------
		$this->start_controls_section(
			'section_style_icon',
			array(
				'label' => esc_html__( 'Icon', 'nexus' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'icon_color',
			array(
				'label'     => esc_html__( 'Icon Color', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .nexus-counter__icon' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'icon_size',
			array(
				'label'      => esc_html__( 'Icon Size', 'nexus' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 20,
						'max' => 80,
					),
				),
				'default'    => array(
					'size' => 40,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .nexus-counter__icon' => 'font-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		// ---------------------------------------------------------------
		// STYLE: Number
		// ---------------------------------------------------------------
		$this->start_controls_section(
			'section_style_number',
			array(
				'label' => esc_html__( 'Number', 'nexus' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'number_color',
			array(
				'label'     => esc_html__( 'Number Color', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .nexus-counter__number' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'number_typography',
				'selector' => '{{WRAPPER}} .nexus-counter__number',
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Title Color', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .nexus-counter__title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Title Typography', 'nexus' ),
				'selector' => '{{WRAPPER}} .nexus-counter__title',
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings  = $this->get_settings_for_display();
		$widget_id = 'nexus-counter-' . $this->get_id();

		$ending    = absint( $settings['ending_number'] );
		$starting  = absint( $settings['starting_number'] );
		$duration  = absint( $settings['duration'] );
		$separator = 'yes' === $settings['separator'];
		?>

		<div class="nexus-counter" id="<?php echo esc_attr( $widget_id ); ?>">

			<?php if ( ! empty( $settings['icon']['value'] ) ) : ?>
				<div class="nexus-counter__icon" aria-hidden="true">
					<?php \Elementor\Icons_Manager::render_icon( $settings['icon'], array( 'aria-hidden' => 'true' ) ); ?>
				</div>
			<?php endif; ?>

			<div class="nexus-counter__number-wrap" aria-label="<?php echo esc_attr( $settings['prefix'] . $ending . $settings['suffix'] ); ?>">
				<?php if ( $settings['prefix'] ) : ?>
					<span class="nexus-counter__prefix" aria-hidden="true"><?php echo esc_html( $settings['prefix'] ); ?></span>
				<?php endif; ?>

				<span
					class="nexus-counter__number"
					data-start="<?php echo esc_attr( $starting ); ?>"
					data-end="<?php echo esc_attr( $ending ); ?>"
					data-duration="<?php echo esc_attr( $duration ); ?>"
					data-separator="<?php echo $separator ? '1' : '0'; ?>"
					aria-hidden="true"
				>
					<?php echo esc_html( $separator ? number_format( $ending ) : $ending ); ?>
				</span>

				<?php if ( $settings['suffix'] ) : ?>
					<span class="nexus-counter__suffix" aria-hidden="true"><?php echo esc_html( $settings['suffix'] ); ?></span>
				<?php endif; ?>
			</div>

			<?php if ( $settings['title'] ) : ?>
				<h3 class="nexus-counter__title"><?php echo esc_html( $settings['title'] ); ?></h3>
			<?php endif; ?>

			<?php if ( $settings['description'] ) : ?>
				<p class="nexus-counter__desc"><?php echo esc_html( $settings['description'] ); ?></p>
			<?php endif; ?>

		</div>

		<script>
		( function () {
			var el    = document.getElementById( '<?php echo esc_js( $widget_id ); ?>' );
			var numEl = el && el.querySelector( '.nexus-counter__number' );
			if ( ! el || ! numEl ) return;

			var start     = parseInt( numEl.dataset.start, 10 );
			var end       = parseInt( numEl.dataset.end, 10 );
			var duration  = parseInt( numEl.dataset.duration, 10 );
			var separator = '1' === numEl.dataset.separator;
			var observed  = false;

			function formatNum( n ) {
				return separator ? n.toLocaleString() : String( n );
			}

			function animateCount() {
				if ( observed ) return;
				observed = true;
				var startTime = null;
				function step( ts ) {
					if ( ! startTime ) startTime = ts;
					var progress = Math.min( ( ts - startTime ) / duration, 1 );
					var current  = Math.floor( progress * ( end - start ) + start );
					numEl.textContent = formatNum( current );
					if ( progress < 1 ) {
						requestAnimationFrame( step );
					} else {
						numEl.textContent = formatNum( end );
					}
				}
				requestAnimationFrame( step );
			}

			if ( 'IntersectionObserver' in window ) {
				var observer = new IntersectionObserver( function ( entries ) {
					entries.forEach( function ( entry ) {
						if ( entry.isIntersecting ) {
							animateCount();
							observer.unobserve( entry.target );
						}
					} );
				}, { threshold: 0.3 } );
				observer.observe( el );
			} else {
				animateCount();
			}
		} )();
		</script>
		<?php
	}
}
