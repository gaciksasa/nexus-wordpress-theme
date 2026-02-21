<?php
/**
 * Nexus Theme - Elementor Team Members Widget
 *
 * Team grid with social links.
 *
 * @package Nexus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Nexus_Widget_Team_Members
 */
class Nexus_Widget_Team_Members extends \Elementor\Widget_Base {

	public function get_name() {
		return 'nexus-team-members';
	}

	public function get_title() {
		return esc_html__( 'Team Members', 'nexus' );
	}

	public function get_icon() {
		return 'eicon-person';
	}

	public function get_categories() {
		return array( 'nexus-elements' );
	}

	public function get_keywords() {
		return array( 'team', 'members', 'staff', 'people', 'nexus' );
	}

	protected function register_controls() {

		// ---------------------------------------------------------------
		// CONTENT: Source
		// ---------------------------------------------------------------
		$this->start_controls_section(
			'section_source',
			array( 'label' => esc_html__( 'Team Members', 'nexus' ) )
		);

		$this->add_control(
			'source',
			array(
				'label'   => esc_html__( 'Data Source', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'custom',
				'options' => array(
					'custom' => esc_html__( 'Custom (Manual)', 'nexus' ),
					'cpt'    => esc_html__( 'Team CPT', 'nexus' ),
				),
			)
		);

		// Manual repeater.
		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'photo',
			array(
				'label'   => esc_html__( 'Photo', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'default' => array( 'url' => \Elementor\Utils::get_placeholder_image_src() ),
			)
		);

		$repeater->add_control(
			'name',
			array(
				'label'   => esc_html__( 'Name', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Alex Johnson', 'nexus' ),
				'dynamic' => array( 'active' => true ),
			)
		);

		$repeater->add_control(
			'position',
			array(
				'label'   => esc_html__( 'Position', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Lead Designer', 'nexus' ),
				'dynamic' => array( 'active' => true ),
			)
		);

		$repeater->add_control(
			'bio',
			array(
				'label'   => esc_html__( 'Short Bio', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'default' => '',
				'dynamic' => array( 'active' => true ),
			)
		);

		$repeater->add_control(
			'link',
			array(
				'label'   => esc_html__( 'Profile Link', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::URL,
				'dynamic' => array( 'active' => true ),
			)
		);

		$repeater->add_control(
			'social_separator',
			array(
				'label' => esc_html__( 'Social Links', 'nexus' ),
				'type'  => \Elementor\Controls_Manager::HEADING,
			)
		);

		foreach ( array(
			'linkedin'  => array( 'LinkedIn', 'ri-linkedin-fill' ),
			'twitter'   => array( 'X / Twitter', 'ri-twitter-x-fill' ),
			'facebook'  => array( 'Facebook', 'ri-facebook-fill' ),
			'instagram' => array( 'Instagram', 'ri-instagram-fill' ),
			'email'     => array( 'Email', 'ri-mail-line' ),
		) as $key => $info ) {
			$repeater->add_control(
				'social_' . $key,
				array(
					'label'       => $info[0],
					'type'        => \Elementor\Controls_Manager::URL,
					'placeholder' => 'https://',
					'dynamic'     => array( 'active' => true ),
				)
			);
		}

		$this->add_control(
			'members',
			array(
				'label'       => esc_html__( 'Members', 'nexus' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'name'     => esc_html__( 'Alex Johnson', 'nexus' ),
						'position' => esc_html__( 'Lead Designer', 'nexus' ),
					),
					array(
						'name'     => esc_html__( 'Maria Garcia', 'nexus' ),
						'position' => esc_html__( 'Developer', 'nexus' ),
					),
					array(
						'name'     => esc_html__( 'James Wilson', 'nexus' ),
						'position' => esc_html__( 'Project Manager', 'nexus' ),
					),
				),
				'title_field' => '{{{ name }}}',
				'condition'   => array( 'source' => 'custom' ),
			)
		);

		// CPT query.
		$this->add_control(
			'posts_per_page',
			array(
				'label'     => esc_html__( 'Items to Show', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'default'   => 4,
				'min'       => 1,
				'max'       => 50,
				'condition' => array( 'source' => 'cpt' ),
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
				'default'        => '4',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options'        => array(
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
				),
				'selectors'      => array(
					'{{WRAPPER}} .nexus-team-grid' => '--nexus-team-cols: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'card_style',
			array(
				'label'   => esc_html__( 'Card Style', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'overlay',
				'options' => array(
					'overlay' => esc_html__( 'Overlay on Hover', 'nexus' ),
					'below'   => esc_html__( 'Info Below Image', 'nexus' ),
					'card'    => esc_html__( 'Card (Boxed)', 'nexus' ),
				),
			)
		);

		$this->add_control(
			'show_bio',
			array(
				'label'   => esc_html__( 'Show Bio', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => '',
			)
		);

		$this->add_control(
			'show_social',
			array(
				'label'   => esc_html__( 'Show Social Icons', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
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
					'{{WRAPPER}} .nexus-team-grid' => 'gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'card_radius',
			array(
				'label'      => esc_html__( 'Image Border Radius', 'nexus' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .nexus-team-member__img-wrap' => 'border-radius: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'name_color',
			array(
				'label'     => esc_html__( 'Name Color', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .nexus-team-member__name' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'name_typography',
				'label'    => esc_html__( 'Name Typography', 'nexus' ),
				'selector' => '{{WRAPPER}} .nexus-team-member__name',
			)
		);

		$this->add_control(
			'position_color',
			array(
				'label'     => esc_html__( 'Position Color', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .nexus-team-member__position' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'social_color',
			array(
				'label'     => esc_html__( 'Social Icon Color', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .nexus-team-member__social a' => 'color: {{VALUE}};',
				),
				'condition' => array( 'show_social' => 'yes' ),
			)
		);

		$this->add_control(
			'social_hover_color',
			array(
				'label'     => esc_html__( 'Social Icon Hover Color', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .nexus-team-member__social a:hover' => 'color: {{VALUE}};',
				),
				'condition' => array( 'show_social' => 'yes' ),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings    = $this->get_settings_for_display();
		$card_style  = $settings['card_style'] ?? 'overlay';
		$show_social = 'yes' === $settings['show_social'];
		$show_bio    = 'yes' === $settings['show_bio'];

		$members = array();

		if ( 'cpt' === $settings['source'] ) {
			$query = new WP_Query(
				array(
					'post_type'      => 'nexus_team',
					'posts_per_page' => absint( $settings['posts_per_page'] ),
					'orderby'        => 'menu_order',
					'order'          => 'ASC',
				)
			);
			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {
					$query->the_post();
					$id        = get_the_ID();
					$members[] = array(
						'photo'            => array( 'url' => get_the_post_thumbnail_url( $id, 'nexus-square' ) ? get_the_post_thumbnail_url( $id, 'nexus-square' ) : '' ),
						'name'             => get_the_title(),
						'position'         => get_post_meta( $id, '_nexus_team_position', true ),
						'bio'              => get_the_excerpt(),
						'link'             => array(
							'url'         => get_permalink(),
							'is_external' => false,
						),
						'social_linkedin'  => array( 'url' => get_post_meta( $id, '_nexus_team_linkedin', true ) ),
						'social_twitter'   => array( 'url' => get_post_meta( $id, '_nexus_team_twitter', true ) ),
						'social_facebook'  => array( 'url' => get_post_meta( $id, '_nexus_team_facebook', true ) ),
						'social_instagram' => array( 'url' => get_post_meta( $id, '_nexus_team_instagram', true ) ),
						'social_email'     => array( 'url' => get_post_meta( $id, '_nexus_team_email', true ) ),
					);
				}
				wp_reset_postdata();
			}
		} else {
			$members = $settings['members'] ?? array();
		}

		if ( empty( $members ) ) {
			return;
		}

		$social_links = array(
			'linkedin'  => array( 'LinkedIn', 'ri ri-linkedin-fill' ),
			'twitter'   => array( 'X', 'ri ri-twitter-x-fill' ),
			'facebook'  => array( 'Facebook', 'ri ri-facebook-fill' ),
			'instagram' => array( 'Instagram', 'ri ri-instagram-fill' ),
			'email'     => array( 'Email', 'ri ri-mail-line' ),
		);
		?>

		<div class="nexus-team-grid nexus-team--<?php echo esc_attr( $card_style ); ?>">
			<?php foreach ( $members as $member ) : ?>
				<div class="nexus-team-member">

					<div class="nexus-team-member__img-wrap">
						<?php if ( ! empty( $member['photo']['url'] ) ) : ?>
							<img
								src="<?php echo esc_url( $member['photo']['url'] ); ?>"
								alt="<?php echo esc_attr( $member['name'] ?? '' ); ?>"
								loading="lazy"
							>
						<?php else : ?>
							<img src="<?php echo esc_url( \Elementor\Utils::get_placeholder_image_src() ); ?>" alt="" loading="lazy">
						<?php endif; ?>

						<?php if ( 'overlay' === $card_style && $show_social ) : ?>
							<div class="nexus-team-member__overlay">
								<?php $this->render_social( $member, $social_links ); ?>
							</div>
						<?php endif; ?>
					</div>

					<div class="nexus-team-member__info">
						<?php if ( ! empty( $member['link']['url'] ) ) : ?>
							<a href="<?php echo esc_url( $member['link']['url'] ); ?>" <?php echo ! empty( $member['link']['is_external'] ) ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>>
						<?php endif; ?>

						<?php if ( $member['name'] ) : ?>
							<h3 class="nexus-team-member__name"><?php echo esc_html( $member['name'] ); ?></h3>
						<?php endif; ?>

						<?php if ( ! empty( $member['link']['url'] ) ) : ?>
							</a>
						<?php endif; ?>

						<?php if ( $member['position'] ) : ?>
							<span class="nexus-team-member__position"><?php echo esc_html( $member['position'] ); ?></span>
						<?php endif; ?>

						<?php if ( $show_bio && ! empty( $member['bio'] ) ) : ?>
							<p class="nexus-team-member__bio"><?php echo wp_kses_post( $member['bio'] ); ?></p>
						<?php endif; ?>

						<?php if ( 'below' === $card_style && $show_social ) : ?>
							<?php $this->render_social( $member, $social_links ); ?>
						<?php endif; ?>
					</div>

					<?php if ( 'card' === $card_style && $show_social ) : ?>
						<div class="nexus-team-member__card-footer">
							<?php $this->render_social( $member, $social_links ); ?>
						</div>
					<?php endif; ?>

				</div><!-- .nexus-team-member -->
			<?php endforeach; ?>
		</div>
		<?php
	}

	private function render_social( $member, $social_links ) {
		$has_any = false;
		foreach ( $social_links as $key => $info ) {
			if ( ! empty( $member[ 'social_' . $key ]['url'] ) ) {
				$has_any = true;
				break;
			}
		}
		if ( ! $has_any ) {
			return;
		}
		echo '<div class="nexus-team-member__social">';
		foreach ( $social_links as $key => $info ) {
			if ( empty( $member[ 'social_' . $key ]['url'] ) ) {
				continue;
			}
			$url    = esc_url( $member[ 'social_' . $key ]['url'] );
			$label  = esc_html( $info[0] );
			$icon   = esc_attr( $info[1] );
			$target = ( 'email' !== $key ) ? 'target="_blank" rel="noopener noreferrer"' : '';
			$href   = ( 'email' === $key && strpos( $url, 'mailto' ) === false ) ? 'mailto:' . $url : $url;
			printf(
				'<a href="%s" %s aria-label="%s"><i class="%s" aria-hidden="true"></i></a>',
				esc_url( $href ),
				$target, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- hardcoded safe string.
				$label, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- already esc_html().
				$icon // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- already esc_attr().
			);
		}
		echo '</div>';
	}
}
