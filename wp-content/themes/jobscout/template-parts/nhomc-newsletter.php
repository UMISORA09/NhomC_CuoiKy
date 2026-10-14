<?php defined( 'ABSPATH' ) || exit; ?>
<section class="nc-newsletter" aria-labelledby="newsletter-title">
    <div class="nc-newsletter-inner">
        <h2 id="newsletter-title">Subscribe To<br>Our Newsletter</h2>
        <form class="nc-newsletter-fields" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
            <input type="hidden" name="action" value="nhomc_newsletter">
            <input type="hidden" name="newsletter_return" value="<?php echo esc_url( remove_query_arg( 'newsletter', home_url( wp_unslash( $_SERVER['REQUEST_URI'] ) ) ) ); ?>">
            <?php wp_nonce_field( 'nhomc_newsletter', 'newsletter_nonce', false ); ?>
            <label class="nc-sr-only" aria-hidden="true">Leave this field empty<input type="text" name="newsletter_website" tabindex="-1" autocomplete="off"></label>
            <label class="nc-email"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="3" y="5" width="18" height="14"/><path d="m3 5 9 7 9-7"/></svg><span class="nc-sr-only">Email address</span><input type="email" name="email" autocomplete="email" placeholder="Input your email address" maxlength="254" required></label>
            <button type="submit">SUBSCRIBE</button>
            <?php
            $messages = array(
                'success' => 'Thank you! Your email is on our newsletter list.',
                'invalid' => 'Please enter a valid email address.',
                'expired' => 'Please refresh the page and try again.',
                'error' => 'We could not save your email. Please try again later.',
            );
            $status = isset( $_GET['newsletter'] ) && is_string( $_GET['newsletter'] ) ? $_GET['newsletter'] : '';
            if ( isset( $messages[ $status ] ) ) : ?>
                <p class="nc-newsletter-message" role="status"><?php echo esc_html( $messages[ $status ] ); ?></p>
            <?php endif; ?>
        </form>
    </div>
</section>
