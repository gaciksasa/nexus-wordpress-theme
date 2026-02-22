<?php
/**
 * Nexus Theme - Elementor Blog Posts Widget
 *
 * Latest posts grid/list with various card layouts.
 *
 * @package Nexus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Nexus_Widget_Blog_Posts
 */
class Nexus_Widget_Blog_Posts extends \Elementor\Widget_Base {

	public function get_name() {
		return 'nexus-blog-posts';
	}

	public function get_title() {
		return esc_html__( 'Blog Posts', 'nexus' );
	}

	public function get_icon() {
		return 'eicon-posts-grid';
	}

	public function get_categories() {
		return array( 'nexus-elements' );
	}

	public function get_keywords() {
		return array( 'blog', 'posts', 'news', 'articles', 'grid', 'nexus' );
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
				'label'   => esc_html__( 'Posts to Show', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 3,
				'min'     => 1,
				'max'     => 20,
			)
		);

		$this->add_control(
			'post_type',
			array(
				'label'   => esc_html__( 'Post Type', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'post',
				'options' => $this->get_post_types(),
			)
		);

		$this->add_control(
			'category_ids',
			array(
				'label'       => esc_html__( 'Categories', 'nexus' ),
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'multiple'    => true,
				'options'     => $this->get_post_categories(),
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
					'date'          => esc_html__( 'Date', 'nexus' ),
					'title'         => esc_html__( 'Title', 'nexus' ),
					'comment_count' => esc_html__( 'Comments', 'nexus' ),
					'rand'          => esc_html__( 'Random', 'nexus' ),
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
					'DESC' => esc_html__( 'Newest First', 'nexus' ),
					'ASC'  => esc_html__( 'Oldest First', 'nexus' ),
				),
			)
		);

		$this->add_control(
			'exclude_ids',
			array(
				'label'       => esc_html__( 'Exclude Post IDs', 'nexus' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'placeholder' => '1, 2, 3',
				'description' => esc_html__( 'Comma-separated post IDs to exclude.', 'nexus' ),
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

		$this->add_control(
			'layout',
			array(
				'label'   => esc_html__( 'Layout', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'grid',
				'options' => array(
					'grid'     => esc_html__( 'Grid', 'nexus' ),
					'list'     => esc_html__( 'List', 'nexus' ),
					'featured' => esc_html__( 'Featured + Grid', 'nexus' ),
				),
			)
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
				),
				'condition'      => array( 'layout' => 'grid' ),
				'selectors'      => array(
					'{{WRAPPER}} .nexus-blog-grid' => '--nexus-blog-cols: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'card_style',
			array(
				'label'   => esc_html__( 'Card Style', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'standard',
				'options' => array(
					'standard' => esc_html__( 'Standard', 'nexus' ),
					'minimal'  => esc_html__( 'Minimal', 'nexus' ),
					'overlay'  => esc_html__( 'Overlay', 'nexus' ),
				),
			)
		);

		$this->end_controls_section();

		// ---------------------------------------------------------------
		// CONTENT: Metadata
		// ---------------------------------------------------------------
		$this->start_controls_section(
			'section_meta',
			array( 'label' => esc_html__( 'Post Details', 'nexus' ) )
		);

		$this->add_control(
			'show_image',
			array(
				'label'   => esc_html__( 'Show Featured Image', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$this->add_control(
			'show_category',
			array(
				'label'   => esc_html__( 'Show Category', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$this->add_control(
			'show_date',
			array(
				'label'   => esc_html__( 'Show Date', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$this->add_control(
			'show_author',
			array(
				'label'   => esc_html__( 'Show Author', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => '',
			)
		);

		$this->add_control(
			'show_excerpt',
			array(
				'label'   => esc_html__( 'Show Excerpt', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$this->add_control(
			'excerpt_length',
			array(
				'label'     => esc_html__( 'Excerpt Length (words)', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'default'   => 18,
				'min'       => 5,
				'max'       => 100,
				'condition' => array( 'show_excerpt' => 'yes' ),
			)
		);

		$this->add_control(
			'show_read_more',
			array(
				'label'   => esc_html__( 'Show Read More', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$this->add_control(
			'read_more_text',
			array(
				'label'     => esc_html__( 'Read More Text', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => esc_html__( 'Read More', 'nexus' ),
				'condition' => array( 'show_read_more' => 'yes' ),
			)
		);

		$this->end_controls_section();

		// ---------------------------------------------------------------
		// STYLE: Card
		// ---------------------------------------------------------------
		$this->start_controls_section(
			'section_style_card',
			array(
				'label' => esc_html__( 'Card', 'nexus' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'card_gap',
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
					'size' => 30,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .nexus-blog-grid' => 'gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			array(
				'name'     => 'card_bg',
				'selector' => '{{WRAPPER}} .nexus-post-card',
			)
		);

		$this->add_control(
			'card_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'nexus' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .nexus-post-card' => 'border-radius: {{SIZE}}{{UNIT}}; overflow: hidden;',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'card_shadow',
				'selector' => '{{WRAPPER}} .nexus-post-card',
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Title Color', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .nexus-post-card__title a' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'excerpt_color',
			array(
				'label'     => esc_html__( 'Excerpt Color', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .nexus-post-card__excerpt' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings     = $this->get_settings_for_display();
		$layout       = $settings['layout'] ?? 'grid';
		$card_style   = $settings['card_style'] ?? 'standard';
		$show_image   = 'yes' === $settings['show_image'];
		$show_cat     = 'yes' === $settings['show_category'];
		$show_date    = 'yes' === $settings['show_date'];
		$show_author  = 'yes' === $settings['show_author'];
		$show_excerpt = 'yes' === $settings['show_excerpt'];
		$show_rm      = 'yes' === $settings['show_read_more'];

		$args = array(
			'post_type'      => sanitize_key( $settings['post_type'] ),
			'posts_per_page' => absint( $settings['posts_per_page'] ),
			'orderby'        => sanitize_key( $settings['orderby'] ),
			'order'          => 'ASC' === $settings['order'] ? 'ASC' : 'DESC',
			'no_found_rows'  => true,
		);

		if ( ! empty( $settings['category_ids'] ) ) {
			$args['cat'] = implode( ',', array_map( 'absint', $settings['category_ids'] ) );
		}

		if ( ! empty( $settings['exclude_ids'] ) ) {
			$args['post__not_in'] = array_map( 'absint', explode( ',', $settings['exclude_ids'] ) );
		}

		$query = new WP_Query( $args );

		if ( ! $query->have_posts() ) {
			return;
		}

		$grid_class = 'nexus-blog-grid nexus-blog--' . esc_attr( $layout );
		?>

		<div class="<?php echo esc_attr( $grid_class ); ?>">
			<?php
			$nexus_post_index = 0;
			while ( $query->have_posts() ) :
				$query->the_post();

				$excerpt = '';
				if ( $show_excerpt ) {
					$excerpt = wp_trim_words( get_the_excerpt(), absint( $settings['excerpt_length'] ), '&hellip;' );
				}

				// Reading time (avg 200 wpm).
				$nexus_word_count   = str_word_count( wp_strip_all_tags( get_post_field( 'post_content', get_the_ID() ) ) );
				$nexus_reading_time = max( 1, (int) ceil( $nexus_word_count / 200 ) );

				// Featured variant: first card gets a wider span class.
				$card_class = 'nexus-post-card';
				if ( 'featured' === $layout && 0 === $nexus_post_index ) {
					$card_class .= ' nexus-post-card--featured';
				}
				?>

				<article class="<?php echo esc_attr( $card_class ); ?>" itemscope itemtype="https://schema.org/BlogPosting">

					<?php
					$cats = get_the_category();
					$cat  = ! empty( $cats ) ? $cats[0] : null;

					if ( $show_image ) :
						// Placeholder colours cycle through brand palette when no thumbnail.
						$nexus_ph_colors = array( '#e94560', '#0f3460', '#1a1a2e', '#16213e', '#533483' );
						$nexus_ph_color  = $nexus_ph_colors[ get_the_ID() % count( $nexus_ph_colors ) ];
						?>
						<div class="nexus-post-card__thumb">

							<?php if ( has_post_thumbnail() ) : ?>
								<a href="<?php the_permalink(); ?>" class="nexus-post-card__thumb-link" tabindex="-1" aria-hidden="true">
									<?php the_post_thumbnail( 'nexus-medium', array( 'loading' => 'lazy' ) ); ?>
								</a>
							<?php else : ?>
								<a
									href="<?php the_permalink(); ?>"
									class="nexus-post-card__thumb-link nexus-post-card__thumb-placeholder"
									style="--ph-color: <?php echo esc_attr( $nexus_ph_color ); ?>;"
									tabindex="-1"
									aria-hidden="true"
								>
									<span class="nexus-post-card__thumb-initial" aria-hidden="true">
										<?php echo esc_html( mb_substr( get_the_title(), 0, 1 ) ); ?>
									</span>
								</a>
							<?php endif; ?>

							<?php if ( $show_cat && $cat ) : ?>
								<a
									href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>"
									class="nexus-post-card__cat-badge"
								>
									<?php echo esc_html( $cat->name ); ?>
								</a>
							<?php endif; ?>

							<span class="nexus-post-card__time">
								<?php
								echo esc_html(
									/* translators: %d = number of minutes */
									sprintf( __( '%d min', 'nexus' ), $nexus_reading_time )
								);
								?>
							</span>

							<span class="nexus-post-card__img-overlay" aria-hidden="true"></span>

						</div><!-- .nexus-post-card__thumb -->
					<?php endif; ?>

					<div class="nexus-post-card__body">

						<?php if ( $show_date || $show_author ) : ?>
							<div class="nexus-post-card__meta">
								<?php if ( $show_date ) : ?>
									<time class="nexus-post-card__date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" itemprop="datePublished">
										<?php echo esc_html( get_the_date( 'M j, Y' ) ); ?>
									</time>
								<?php endif; ?>

								<?php if ( $show_date && $show_author ) : ?>
									<span class="nexus-post-card__sep" aria-hidden="true">&middot;</span>
								<?php endif; ?>

								<?php if ( $show_author ) : ?>
									<span class="nexus-post-card__author" itemprop="author" itemscope itemtype="https://schema.org/Person">
										<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" itemprop="url">
											<span itemprop="name"><?php the_author(); ?></span>
										</a>
									</span>
								<?php endif; ?>
							</div>
						<?php endif; ?>

						<h3 class="nexus-post-card__title" itemprop="headline">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</h3>

						<?php if ( $show_excerpt && $excerpt ) : ?>
							<p class="nexus-post-card__excerpt" itemprop="description"><?php echo esc_html( $excerpt ); ?></p>
						<?php endif; ?>

						<?php if ( $show_rm ) : ?>
							<a href="<?php the_permalink(); ?>" class="nexus-post-card__more">
								<?php echo esc_html( $settings['read_more_text'] ); ?>
								<i class="ri ri-arrow-right-line" aria-hidden="true"></i>
							</a>
						<?php endif; ?>

					</div><!-- .nexus-post-card__body -->

				</article>

				<?php
				++$nexus_post_index;
			endwhile;
			wp_reset_postdata();
			?>
		</div>
		<?php
	}

	private function get_post_types() {
		$types = get_post_types( array( 'public' => true ), 'objects' );
		$opts  = array();
		foreach ( $types as $type ) {
			if ( 'attachment' === $type->name ) {
				continue;
			}
			$opts[ $type->name ] = $type->label;
		}
		return $opts;
	}

	private function get_post_categories() {
		$opts = array();
		$cats = get_categories( array( 'hide_empty' => false ) );
		foreach ( $cats as $cat ) {
			$opts[ $cat->term_id ] = $cat->name;
		}
		return $opts;
	}
}
