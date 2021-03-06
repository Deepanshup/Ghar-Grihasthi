<div class="js-card-connect-errors"></div>
<fieldset id="card_connect-cc-form">
    <p class="form-row form-row-wide"><?php echo $description; ?></p>
    <p class="form-row form-row-wide">
    <p style="margin: 0 0 5px;">Accepting:</p>
    <ul class="card-connect-allowed-cards"><?php echo $card_icons; ?></ul>
	<?php if ( $profiles_enabled ) {
		wc_get_template( 'saved-cards.php', array(
				'saved_cards' => $saved_cards,
			), WC_CARDCONNECT_PLUGIN_PATH, WC_CARDCONNECT_TEMPLATE_PATH );
	} ?>
    <p data-saved_hidden="true" class="form-row form-row-wide">
        <label for="card_connect-card-name">
			<?php echo __( 'Cardholder Name (If Different)', 'woocommerce' ); ?>
        </label>
        <input
                id="card_connect-card-name"
                class="input-text"
                type="text"
                maxlength="25"
                name="card_connect-card-name"
        />
    </p>
    <p data-saved_hidden="true" class="form-row form-row-wide validate-required">
        <label for="card_connect-card-number">
			<?php echo __( 'Card Number', 'woocommerce' ); ?>
            <span class="required">*</span>
        </label>
		<?php if ( $is_iframe ): ?>
            <iframe
                    width="100%"
                    style="margin-bottom: 0;"
                    id="card_connect-iframe"
                    src="<?php echo $is_autostyle ? $iframe_src : sprintf( '%s&css=%s', $iframe_src, urlencode($iframe_style )); ?>"
                    frameborder="0"
                    scrolling="no"
            ></iframe>
		<?php else: ?>
            <input
                    id="card_connect-card-number"
                    class="input-text wc-credit-card-form-card-number validate-required"
                    type="text"
                    maxlength="20"
                    autocomplete="off"
                    placeholder="•••• •••• •••• ••••"
            />
		<?php endif; ?>
    </p>
    <p data-saved_hidden="true" class="form-row form-row-first validate-required">
        <label for="card_connect-card-expiry">
			<?php echo __( 'Expiry (MM/YY)', 'woocommerce' ); ?>
            <span class="required">*</span>
        </label>
        <input
                id="card_connect-card-expiry"
                class="input-text wc-credit-card-form-card-expiry"
                type="text"
                autocomplete="off"
                placeholder="<?php echo __( 'MM / YY', 'woocommerce' ); ?>"
                name="card_connect-card-expiry"
        />
    </p>
    <p data-saved_hidden="true" class="form-row form-row-last validate-required">
        <label for="card_connect-card-cvc">
			<?php echo __( 'Card Code', 'woocommerce' ); ?>
            <span class="required">*</span>
        </label>
        <input
                id="card_connect-card-cvc"
                class="input-text wc-credit-card-form-card-cvc"
                type="text"
                autocomplete="off"
                placeholder="<?php echo __( 'CVC', 'woocommerce' ); ?>"
                name="card_connect-card-cvc"
        />
        <em><?php echo __( 'Your CVV number will not be stored on our server.', 'woocommerce' ); ?></em>
    </p>
</fieldset>
<p style="display:none;" class="saved_card_message"></p>