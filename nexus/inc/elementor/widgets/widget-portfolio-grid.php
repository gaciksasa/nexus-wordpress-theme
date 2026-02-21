<?php
/**
 * Nexus Theme - Elementor Portfolio Grid Widget
 *
 * Filterable portfolio grid with Isotope.js.
 *
 * @package Nexus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Nexus_Widget_Portfolio_Grid
 */
class Nexus_Widget_Portfolio_Grid extends \Elementor\Widget_Base {

	public function get_name() {
		return 'nexus-portfolio-grid';
	}

	public function get_title() {
		return esc_html__( 'Portfolio Grid', 'nexus' );
	}

	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	public function get_categories() {
		return array( 'nexus-elements' );
	}

	public function get_keywords() {
		return array( 'portfolio', 'gallery', 'grid', 'filter', 'isotope', 'nexus' );
	}

	public function get_script_depends() {
		return array( 'nexus-isotope' );
	}

	protected function register_controls() {

		// ---------------------------------------------------------------
		// CONTENT: Query
		// ---------------------------------------------------------------
		$this->start_controls_section(
			'section_query',
			array( 'label' => esc_html__( 'Query', 'nexus' ) )
		);

		$this->add_control(
			'posts_per_page',
			array(
				'label'   => esc_html__( 'Items to Show', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 9,
				'min'     => 1,
				'max'     => 50,
			)
		);

		$this->add_control(
			'category_filter',
			array(
				'label'       => esc_html__( 'Filter by Category', 'nexus' ),
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'multiple'    => true,
				'options'     => $this->get_portfolio_categories(),
				'label_block' => true,
			)
		);

		$this->add_control(
			'orderby',
			array(
				'label'   => esc_html__( 'Order By', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'date',
				'options' => array(
					'date'       => esc_html__( 'Date', 'nexus' ),
					'title'      => esc_html__( 'Title', 'nexus' ),
					'menu_order' => esc_html__( 'Menu Order', 'nexus' ),
					'rand'       => esc_html__( 'Random', 'nexus' ),
				),
			)
		);

		$this->add_control(
			'order',
			array(
				'label'   => esc_html__( 'Order', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => array(
					'DESC' => esc_html__( 'Descending', 'nexus' ),
					'ASC'  => esc_html__( 'Ascending', 'nexus' ),
				),
			)
		);

		$this->end_controls_section();

		// ---------------------------------------------------------------
		// CONTENT: Layout
		// ---------------------------------------------------------------
		$this->start_controls_section(
			'section_layout',
			array( 'label' => esc_html__( 'Layout', 'nexus' ) )
		);

		$this->add_responsive_control(
			'columns',
			array(
				'label'          => esc_html__( 'Columns', 'nexus' ),
				'type'           => \Elementor\Controls_Manager::SELECT,
				'default'        => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options'        => array(
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
				),
				'selectors'      => array(
					'{{WRAPPER}} .nexus-portfolio-grid' => '--nexus-portfolio-cols: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'show_filter',
			array(
				'label'   => esc_html__( 'Show Category Filter', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$this->add_control(
			'show_overlay',
			array(
				'label'   => esc_html__( 'Show Hover Overlay', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$this->add_control(
			'overlay_icon',
			array(
				'label'     => esc_html__( 'Overlay Icon', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::ICONS,
				'default'   => array(
					'value'   => 'ri-eye-line',
					'library' => 'remix-icon',
				),
				'condition' => array( 'show_overlay' => 'yes' ),
			)
		);

		$this->add_control(
			'image_ratio',
			array(
				'label'   => esc_html__( 'Image Ratio', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'landscape',
				'options' => array(
					'landscape' => esc_html__( 'Landscape (4:3)', 'nexus' ),
					'square'    => esc_html__( 'Square (1:1)', 'nexus' ),
					'portrait'  => esc_html__( 'Portrait (3:4)', 'nexus' ),
					'wide'      => esc_html__( 'Wide (16:9)', 'nexus' ),
				),
			)
		);

		$this->add_control(
			'load_more',
			array(
				'label'   => esc_html__( 'Load More Button', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => '',
			)
		);

		$this->add_control(
			'load_more_text',
			array(
				'label'     => esc_html__( 'Button Text', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => esc_html__( 'Load More', 'nexus' ),
				'condition' => array( 'load_more' => 'yes' ),
			)
		);

		$this->end_controls_section();

		// ---------------------------------------------------------------
		// STYLE: Filter
		// ---------------------------------------------------------------
		$this->start_controls_section(
			'section_style_filter',
			array(
				'label'     => esc_html__( 'Filter Bar', 'nexus' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => array( 'show_filter' => 'yes' ),
			)
		);

		$this->add_control(
			'filter_align',
			array(
				'label'     => esc_html__( 'Alignment', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => array(
					'flex-start' => array(
						'title' => esc_html__( 'Left', 'nexus' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center'     => array(
						'title' => esc_html__( 'Center', 'nexus' ),
						'icon'  => 'eicon-text-align-center',
					),
					'flex-end'   => array(
						'title' => esc_html__( 'Right', 'nexus' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => 'center',
				'selectors' => array(
					'{{WRAPPER}} .nexus-portfolio-filter' => 'justify-content: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'filter_typography',
				'selector' => '{{WRAPPER}} .nexus-portfolio-filter__btn',
			)
		);

		$this->add_control(
			'filter_color',
			array(
				'label'     => esc_html__( 'Color', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .nexus-portfolio-filter__btn' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'filter_active_color',
			array(
				'label'     => esc_html__( 'Active Color', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .nexus-portfolio-filter__btn.is-active' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'filter_spacing',
			array(
				'label'      => esc_html__( 'Spacing Below Filter', 'nexus' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'    => array(
					'size' => 40,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .nexus-portfolio-filter' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		// ---------------------------------------------------------------
		// STYLE: Items
		// ---------------------------------------------------------------
		$this->start_controls_section(
			'section_style_items',
			array(
				'label' => esc_html__( 'Items', 'nexus' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'item_gap',
			array(
				'label'      => esc_html__( 'Gap', 'nexus' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 60,
					),
				),
				'default'    => array(
					'size' => 24,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .nexus-portfolio-grid' => 'gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'item_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'nexus' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 40,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .nexus-portfolio-item' => 'border-radius: {{SIZE}}{{UNIT}}; overflow: hidden;',
				),
			)
		);

		$this->add_control(
			'overlay_color',
			array(
				'label'     => esc_html__( 'Overlay Color', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(10,10,10,0.7)',
				'selectors' => array(
					'{{WRAPPER}} .nexus-portfolio-item__overlay' => 'background-color: {{VALUE}};',
				),
				'condition' => array( 'show_overlay' => 'yes' ),
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Title Color', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .nexus-portfolio-item__title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'category_color',
			array(
				'label'     => esc_html__( 'Category Color', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(255,255,255,0.75)',
				'selectors' => array(
					'{{WRAPPER}} .nexus-portfolio-item__cat' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings     = $this->get_settings_for_display();
		$widget_id    = 'nexus-portfolio-' . $this->get_id();
		$show_filter  = 'yes' === $settings['show_filter'];
		$show_overlay = 'yes' === $settings['show_overlay'];
		$image_ratio  = $settings['image_ratio'] ?? 'landscape';

		$ratio_map = array(
			'landscape' => '75%',
			'square'    => '100%',
			'portrait'  => '133%',
			'wide'      => '56.25%',
		);
		$pt        = $ratio_map[ $image_ratio ] ?? '75%';

		// Query.
		$args = array(
			'post_type'      => 'nexus_portfolio',
			'posts_per_page' => absint( $settings['posts_per_page'] ),
			'orderby'        => sanitize_key( $settings['orderby'] ),
			'order'          => 'ASC' === $settings['order'] ? 'ASC' : 'DESC',
		);

		if ( ! empty( $settings['category_filter'] ) ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'portfolio_category',
					'field'    => 'term_id',
					'terms'    => array_map( 'absint', $settings['category_filter'] ),
				),
			);
		}

		$query = new WP_Query( $args );

		// Gather all categories for filter.
		$all_cats = array();
		if ( $show_filter && $query->have_posts() ) {
			foreach ( $query->posts as $post ) {
				$terms = get_the_terms( $post->ID, 'portfolio_category' );
				if ( $terms && ! is_wp_error( $terms ) ) {
					foreach ( $terms as $term ) {
						$all_cats[ $term->term_id ] = $term;
					}
				}
			}
		}
		?>

		<div class="nexus-portfolio-wrap" id="<?php echo esc_attr( $widget_id ); ?>">

			<?php if ( $show_filter && ! empty( $all_cats ) ) : ?>
				<div class="nexus-portfolio-filter" role="tablist" aria-label="<?php esc_attr_e( 'Portfolio categories', 'nexus' ); ?>">
					<button
						class="nexus-portfolio-filter__btn is-active"
						data-filter="*"
						role="tab"
						aria-selected="true"
					>
						<?php esc_html_e( 'All', 'nexus' ); ?>
					</button>
					<?php foreach ( $all_cats as $cat ) : ?>
						<button
							class="nexus-portfolio-filter__btn"
							data-filter=".cat-<?php echo esc_attr( $cat->slug ); ?>"
							role="tab"
							aria-selected="false"
						>
							<?php echo esc_html( $cat->name ); ?>
						</button>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<div class="nexus-portfolio-grid" data-isotope-grid="<?php echo esc_attr( $widget_id ); ?>">

				<?php
				if ( $query->have_posts() ) :
					while ( $query->have_posts() ) :
						$query->the_post();
						?>

						<?php
						$terms    = get_the_terms( get_the_ID(), 'portfolio_category' );
						$cat_slug = '';
						$cat_name = '';
						if ( $terms && ! is_wp_error( $terms ) ) {
							foreach ( $terms as $t ) {
								$cat_slug .= ' cat-' . esc_attr( $t->slug );
								$cat_name  = esc_html( $t->name );
							}
						}
						?>

					<div class="nexus-portfolio-item<?php echo esc_attr( $cat_slug ); ?>">
						<a href="<?php the_permalink(); ?>" class="nexus-portfolio-item__link" aria-label="<?php the_title_attribute(); ?>">
							<div class="nexus-portfolio-item__img-wrap" style="padding-top: <?php echo esc_attr( $pt ); ?>;">
								<?php if ( has_post_thumbnail() ) : ?>
									<?php the_post_thumbnail( 'nexus-square', array( 'loading' => 'lazy' ) ); ?>
								<?php else : ?>
									<img src="<?php echo esc_url( \Elementor\Utils::get_placeholder_image_src() ); ?>" alt="" loading="lazy">
								<?php endif; ?>

								<?php if ( $show_overlay ) : ?>
									<div class="nexus-portfolio-item__overlay">
										<?php
										if ( ! empty( $settings['overlay_icon']['value'] ) ) {
											\Elementor\Icons_Manager::render_icon( $settings['overlay_icon'], array( 'aria-hidden' => 'true' ) );
										}
										?>
									</div>
								<?php endif; ?>
							</div>

							<div class="nexus-portfolio-item__info">
													<?php if ( $cat_name ) : ?>
									<span class="nexus-portfolio-item__cat"><?php echo esc_html( $cat_name ); ?></span>
								<?php endif; ?>
								<h3 class="nexus-portfolio-item__title"><?php the_title(); ?></h3>
							</div>
						</a>
					</div>

									<?php
				endwhile;
					wp_reset_postdata();
endif;
				?>

			</div><!-- .nexus-portfolio-grid -->

			<?php if ( 'yes' === $settings['load_more'] && $query->max_num_pages > 1 ) : ?>
				<div class="nexus-portfolio-load-more">
					<button
						class="nexus-btn nexus-btn--outline nexus-portfolio-load-more__btn"
						data-page="1"
						data-max="<?php echo esc_attr( $query->max_num_pages ); ?>"
						data-widget="<?php echo esc_attr( $this->get_id() ); ?>"
					>
						<?php echo esc_html( $settings['load_more_text'] ); ?>
					</button>
				</div>
			<?php endif; ?>

		</div><!-- .nexus-portfolio-wrap -->

		<script>
		( function () {
			var wrap = document.getElementById( '<?php echo esc_js( $widget_id ); ?>' );
			if ( ! wrap || ! window.Isotope ) return;

			var grid = wrap.querySelector( '.nexus-portfolio-grid' );
			var iso  = new Isotope( grid, {
				itemSelector: '.nexus-portfolio-item',
				layoutMode:   'fitRows',
				percentPosition: true,
			} );

			var filterBtns = wrap.querySelectorAll( '.nexus-portfolio-filter__btn' );
			filterBtns.forEach( function ( btn ) {
				btn.addEventListener( 'click', function () {
					filterBtns.forEach( function ( b ) {
						b.classList.remove( 'is-active' );
						b.setAttribute( 'aria-selected', 'false' );
					} );
					this.classList.add( 'is-active' );
					this.setAttribute( 'aria-selected', 'true' );
					iso.arrange( { filter: this.dataset.filter } );
				} );
			} );
		} )();
		</script>
		<?php
	}

	private function get_portfolio_categories() {
		$options = array();
		$terms   = get_terms(
			array(
				'taxonomy'   => 'portfolio_category',
				'hide_empty' => true,
			)
		);
		if ( $terms && ! is_wp_error( $terms ) ) {
			foreach ( $terms as $term ) {
				$options[ $term->term_id ] = $term->name;
			}
		}
		return $options;
	}
}
