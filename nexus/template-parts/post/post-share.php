<?php
/**
 * Template part: Social share buttons.
 *
 * @package Nexus
 */

if ( ! nexus_option( 'nexus_post_share', true ) ) {
	return;
}

$nexus_post_url   = rawurlencode( get_permalink() );
$nexus_post_title = rawurlencode( wp_strip_all_tags( get_the_title() ) );
?>

<div class="nexus-post-share">

	<span class="nexus-post-share__label">
		<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
		<?php esc_html_e( 'Share this article', 'nexus' ); ?>
	</span>

	<div class="nexus-post-share__buttons">

		<a href="<?php echo esc_url( 'https://twitter.com/intent/tweet?url=' . $nexus_post_url . '&text=' . $nexus_post_title ); ?>"
		   class="nexus-post-share__btn nexus-post-share__btn--twitter"
		   target="_blank"
		   rel="noopener noreferrer"
		   aria-label="<?php esc_attr_e( 'Share on X (Twitter)', 'nexus' ); ?>">
			<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.743l7.73-8.835L1.254 2.25H8.08l4.259 5.631 5.905-5.631Zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
			<span>Twitter</span>
		</a>

		<a href="<?php echo esc_url( 'https://www.facebook.com/sharer/sharer.php?u=' . $nexus_post_url ); ?>"
		   class="nexus-post-share__btn nexus-post-share__btn--facebook"
		   target="_blank"
		   rel="noopener noreferrer"
		   aria-label="<?php esc_attr_e( 'Share on Facebook', 'nexus' ); ?>">
			<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
			<span>Facebook</span>
		</a>

		<a href="<?php echo esc_url( 'https://www.linkedin.com/shareArticle?mini=true&url=' . $nexus_post_url . '&title=' . $nexus_post_title ); ?>"
		   class="nexus-post-share__btn nexus-post-share__btn--linkedin"
		   target="_blank"
		   rel="noopener noreferrer"
		   aria-label="<?php esc_attr_e( 'Share on LinkedIn', 'nexus' ); ?>">
			<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>
			<span>LinkedIn</span>
		</a>

		<a href="<?php echo esc_url( 'https://api.whatsapp.com/send?text=' . $nexus_post_title . '%20' . $nexus_post_url ); ?>"
		   class="nexus-post-share__btn nexus-post-share__btn--whatsapp"
		   target="_blank"
		   rel="noopener noreferrer"
		   aria-label="<?php esc_attr_e( 'Share on WhatsApp', 'nexus' ); ?>">
			<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M11.99 2C6.476 2 2 6.477 2 11.99c0 1.87.49 3.622 1.344 5.15L2 22l5.01-1.313A9.946 9.946 0 0 0 11.99 22C17.523 22 22 17.523 22 11.99 22 6.477 17.523 2 11.99 2zm0 17.98c-1.604 0-3.1-.443-4.38-1.213l-.313-.186-3.25.853.871-3.168-.205-.327C3.617 14.914 3.02 13.49 3.02 11.99c0-4.955 4.03-8.97 8.97-8.97 4.955 0 8.97 4.015 8.97 8.97 0 4.955-4.015 8.97-8.97 8.97z"/></svg>
			<span>WhatsApp</span>
		</a>

	</div><!-- .nexus-post-share__buttons -->

</div><!-- .nexus-post-share -->
