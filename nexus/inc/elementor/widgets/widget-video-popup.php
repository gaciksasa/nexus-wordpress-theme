<?php
/**
 * Nexus Theme - Elementor Video Popup Widget
 *
 * Image/background with play button that opens video in lightbox modal.
 *
 * @package Nexus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Nexus_Widget_Video_Popup
 */
class Nexus_Widget_Video_Popup extends \Elementor\Widget_Base {

	public function get_name() {
		return 'nexus-video-popup';
	}

	public function get_title() {
		return esc_html__( 'Video Popup', 'nexus' );
	}

	public function get_icon() {
		return 'eicon-youtube';
	}

	public function get_categories() {
		return array( 'nexus-elements' );
	}

	public function get_keywords() {
		return array( 'video', 'popup', 'modal', 'youtube', 'vimeo', 'lightbox', 'play', 'nexus' );
	}

	protected function register_controls() {

		// ---------------------------------------------------------------
		// CONTENT: Video
		// ---------------------------------------------------------------
		$this->start_controls_section(
			'section_video',
			array( 'label' => esc_html__( 'Video', 'nexus' ) )
		);

		$this->add_control(
			'video_source',
			array(
				'label'   => esc_html__( 'Video Source', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'youtube',
				'options' => array(
					'youtube' => esc_html__( 'YouTube', 'nexus' ),
					'vimeo'   => esc_html__( 'Vimeo', 'nexus' ),
					'custom'  => esc_html__( 'Custom URL', 'nexus' ),
				),
			)
		);

		$this->add_control(
			'youtube_url',
			array(
				'label'       => esc_html__( 'YouTube URL', 'nexus' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
				'placeholder' => 'https://www.youtube.com/watch?v=...',
				'condition'   => array( 'video_source' => 'youtube' ),
				'dynamic'     => array( 'active' => true ),
			)
		);

		$this->add_control(
			'vimeo_url',
			array(
				'label'       => esc_html__( 'Vimeo URL', 'nexus' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'placeholder' => 'https://vimeo.com/...',
				'condition'   => array( 'video_source' => 'vimeo' ),
				'dynamic'     => array( 'active' => true ),
			)
		);

		$this->add_control(
			'custom_url',
			array(
				'label'     => esc_html__( 'Custom Video URL (.mp4)', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'condition' => array( 'video_source' => 'custom' ),
				'dynamic'   => array( 'active' => true ),
			)
		);

		$this->add_control(
			'autoplay',
			array(
				'label'   => esc_html__( 'Autoplay when opened', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$this->end_controls_section();

		// ---------------------------------------------------------------
		// CONTENT: Thumbnail
		// ---------------------------------------------------------------
		$this->start_controls_section(
			'section_thumbnail',
			array( 'label' => esc_html__( 'Thumbnail', 'nexus' ) )
		);

		$this->add_control(
			'thumbnail_type',
			array(
				'label'   => esc_html__( 'Thumbnail Type', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'custom',
				'options' => array(
					'custom' => esc_html__( 'Custom Image', 'nexus' ),
					'none'   => esc_html__( 'No Image (Button Only)', 'nexus' ),
				),
			)
		);

		$this->add_control(
			'thumbnail',
			array(
				'label'     => esc_html__( 'Thumbnail Image', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::MEDIA,
				'default'   => array( 'url' => \Elementor\Utils::get_placeholder_image_src() ),
				'condition' => array( 'thumbnail_type' => 'custom' ),
			)
		);

		$this->add_responsive_control(
			'height',
			array(
				'label'      => esc_html__( 'Height', 'nexus' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'vh' ),
				'range'      => array(
					'px' => array(
						'min' => 200,
						'max' => 900,
					),
					'vh' => array(
						'min' => 20,
						'max' => 100,
					),
				),
				'default'    => array(
					'size' => 500,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .nexus-video-popup' => 'height: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array( 'thumbnail_type' => 'custom' ),
			)
		);

		$this->add_control(
			'overlay_color',
			array(
				'label'     => esc_html__( 'Overlay Color', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(0,0,0,0.35)',
				'selectors' => array(
					'{{WRAPPER}} .nexus-video-popup__overlay' => 'background-color: {{VALUE}};',
				),
				'condition' => array( 'thumbnail_type' => 'custom' ),
			)
		);

		$this->end_controls_section();

		// ---------------------------------------------------------------
		// CONTENT: Button
		// ---------------------------------------------------------------
		$this->start_controls_section(
			'section_play_btn',
			array( 'label' => esc_html__( 'Play Button', 'nexus' ) )
		);

		$this->add_control(
			'btn_style',
			array(
				'label'   => esc_html__( 'Style', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'circle',
				'options' => array(
					'circle' => esc_html__( 'Circle', 'nexus' ),
					'pulse'  => esc_html__( 'Circle + Pulse Ring', 'nexus' ),
					'flat'   => esc_html__( 'Flat Square', 'nexus' ),
				),
			)
		);

		$this->add_control(
			'btn_size',
			array(
				'label'      => esc_html__( 'Button Size', 'nexus' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 50,
						'max' => 150,
					),
				),
				'default'    => array(
					'size' => 80,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .nexus-video-popup__play' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'btn_color',
			array(
				'label'     => esc_html__( 'Button Color', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .nexus-video-popup__play' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'icon_color',
			array(
				'label'     => esc_html__( 'Icon Color', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .nexus-video-popup__play-icon' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		// ---------------------------------------------------------------
		// CONTENT: Caption
		// ---------------------------------------------------------------
		$this->start_controls_section(
			'section_caption',
			array( 'label' => esc_html__( 'Caption', 'nexus' ) )
		);

		$this->add_control(
			'caption',
			array(
				'label'   => esc_html__( 'Caption', 'nexus' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => '',
				'dynamic' => array( 'active' => true ),
			)
		);

		$this->add_control(
			'caption_color',
			array(
				'label'     => esc_html__( 'Caption Color', 'nexus' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .nexus-video-popup__caption' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings  = $this->get_settings_for_display();
		$widget_id = 'nexus-video-' . $this->get_id();
		$btn_style = $settings['btn_style'] ?? 'circle';
		$autoplay  = 'yes' === $settings['autoplay'] ? 1 : 0;

		// Build embed URL.
		$embed_url = '';
		switch ( $settings['video_source'] ) {
			case 'youtube':
				$yt_url = $settings['youtube_url'] ?? '';
				preg_match( '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i', $yt_url, $m );
				if ( ! empty( $m[1] ) ) {
					$embed_url = 'https://www.youtube.com/embed/' . $m[1] . '?autoplay=' . $autoplay . '&rel=0';
				}
				break;
			case 'vimeo':
				$vm_url = $settings['vimeo_url'] ?? '';
				preg_match( '/vimeo\.com\/(\d+)/', $vm_url, $m );
				if ( ! empty( $m[1] ) ) {
					$embed_url = 'https://player.vimeo.com/video/' . $m[1] . '?autoplay=' . $autoplay;
				}
				break;
			case 'custom':
				$embed_url = esc_url( $settings['custom_url'] ?? '' );
				break;
		}

		$has_thumb = 'custom' === $settings['thumbnail_type'] && ! empty( $settings['thumbnail']['url'] );
		$thumb_url = $has_thumb ? $settings['thumbnail']['url'] : '';

		$wrapper_style = '';
		if ( $thumb_url ) {
			$wrapper_style = 'background-image: url(' . esc_url( $thumb_url ) . ');';
		}
		?>

		<div
			class="nexus-video-popup nexus-video-popup--btn-<?php echo esc_attr( $btn_style ); ?><?php echo $has_thumb ? ' nexus-video-popup--has-thumb' : ''; ?>"
			id="<?php echo esc_attr( $widget_id ); ?>"
			style="<?php echo esc_attr( $wrapper_style ); ?>"
			data-video="<?php echo esc_attr( $embed_url ); ?>"
			data-source="<?php echo esc_attr( $settings['video_source'] ); ?>"
		>
			<?php if ( $has_thumb ) : ?>
				<div class="nexus-video-popup__overlay" aria-hidden="true"></div>
			<?php endif; ?>

			<button
				class="nexus-video-popup__play"
				aria-label="<?php esc_attr_e( 'Play video', 'nexus' ); ?>"
				data-trigger-video="<?php echo esc_attr( $widget_id ); ?>"
			>
				<span class="nexus-video-popup__play-icon" aria-hidden="true">&#9654;</span>
				<?php if ( 'pulse' === $btn_style ) : ?>
					<span class="nexus-video-popup__pulse" aria-hidden="true"></span>
				<?php endif; ?>
			</button>

			<?php if ( $settings['caption'] ) : ?>
				<p class="nexus-video-popup__caption"><?php echo esc_html( $settings['caption'] ); ?></p>
			<?php endif; ?>

		</div>

		<!-- Video Modal -->
		<div class="nexus-video-modal" id="modal-<?php echo esc_attr( $widget_id ); ?>" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Video', 'nexus' ); ?>" hidden>
			<div class="nexus-video-modal__backdrop" data-close-modal></div>
			<div class="nexus-video-modal__inner">
				<button class="nexus-video-modal__close" data-close-modal aria-label="<?php esc_attr_e( 'Close video', 'nexus' ); ?>">
					<span aria-hidden="true">&times;</span>
				</button>
				<div class="nexus-video-modal__embed">
					<?php if ( 'custom' === $settings['video_source'] && $embed_url ) : ?>
						<video controls <?php echo $autoplay ? 'autoplay' : ''; ?> playsinline>
							<source src="<?php echo esc_url( $embed_url ); ?>" type="video/mp4">
						</video>
					<?php else : ?>
						<!-- iframe inserted by JS -->
					<?php endif; ?>
				</div>
			</div>
		</div>

		<script>
		( function () {
			var trigger = document.querySelector( '[data-trigger-video="<?php echo esc_js( $widget_id ); ?>"]' );
			var modal   = document.getElementById( 'modal-<?php echo esc_js( $widget_id ); ?>' );
			if ( ! trigger || ! modal ) return;

			var embedUrl   = '<?php echo esc_js( $embed_url ); ?>';
			var source     = '<?php echo esc_js( $settings['video_source'] ); ?>';
			var embedWrap  = modal.querySelector( '.nexus-video-modal__embed' );
			var closeItems = modal.querySelectorAll( '[data-close-modal]' );

			function openModal() {
				if ( source !== 'custom' && embedUrl ) {
					embedWrap.innerHTML = '<iframe src="' + embedUrl + '" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>';
				}
				modal.hidden = false;
				requestAnimationFrame( function () { modal.classList.add( 'is-open' ); } );
				document.body.style.overflow = 'hidden';
				modal.querySelector( '.nexus-video-modal__close' ).focus();
			}

			function closeModal() {
				modal.classList.remove( 'is-open' );
				document.body.style.overflow = '';
				if ( source !== 'custom' ) {
					embedWrap.innerHTML = '';
				}
				modal.addEventListener( 'transitionend', function h() {
					modal.hidden = true;
					modal.removeEventListener( 'transitionend', h );
				} );
				trigger.focus();
			}

			trigger.addEventListener( 'click', openModal );

			closeItems.forEach( function ( item ) {
				item.addEventListener( 'click', closeModal );
			} );

			document.addEventListener( 'keydown', function ( e ) {
				if ( e.key === 'Escape' && modal.classList.contains( 'is-open' ) ) {
					closeModal();
				}
			} );
		} )();
		</script>
		<?php
	}
}
