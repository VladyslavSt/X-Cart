/* X-Payments Cloud widget wrapper */

function XPaymentsWidgetWrapper()
{
    this.widget = new XPaymentsWidget();
    this.initialized = false;

    this.load = function() {
        this.getWidget().load();
    }
    this.getWidget = function() {
        return this.widget;
    }
    this.isValid = function() {
        return this.initialized && this.getWidget().isValid();
    }

    this.onFlcSubmit = (function(event, state) {
        if (this.isValid()) {
            // FLC - redefine default form action
            state.state = false;
            setTimeout(Checkout.instance.startLoadAnimation, 0);
            core.trigger('checkout.common.block');
            this.getWidget().submit();
        }
    }).bind(this);

    this.onFlcSectionSwitch = (function(event, data) {
        if (
            this.isValid()
            && 'undefined' !== typeof data.newSection
            && 'payment' === data.newSection.name
        ) {
            this.getWidget().refresh();
        }
    }).bind(this);

    this.updateTotal = (function(event, data) {
        this.isValid() && this.getWidget().setOrder(data.total, data.currency);
    }).bind(this);

    this.updateSaveCard = (function(event, data) {
        this.isValid() && this.getWidget().showSaveCard(data.value);
    }).bind(this);

    this.updatePlaceOrderButton = (function(event, data) {
        this.isValid() && this.toggleApplePayButton('apple_pay' === this.getWidget().getPaymentMethod());
    }).bind(this);

    this.toggleApplePayButton = function(state) {
        jQuery('.place-order').toggleClass('apple-pay-button-place-order', state);
    }

    this.setSavedCardIdForDelayedPayment = function (params) {
        var $input = jQuery('#savedCardId');
        if (
          xpaymentsWidgetWrapperConfig.delayedPayment
          && 'card' === params.newId
          && 'undefined' !== typeof params.savedCardId
        ) {
            var $form = jQuery(xpaymentsWidgetConfig.form);
            if ($form.length) {
                if (!$input.length) {
                    $input = jQuery('<input type="hidden" id="savedCardId" name="savedCardId">');
                    $input.appendTo($form);
                }
                if ('' !== params.savedCardId) {
                    $input.val(params.savedCardId);
                } else {
                    $input.remove();
                }
            }
        } else if ($input.length) {
            $input.remove();
        }
    }

    this.toggleDelayedPaymentInfo = function (useSavedCard) {
        if (xpaymentsWidgetWrapperConfig.delayedPayment) {
            var saveNewCardBlock = document.getElementById('xpayments-delayed-payment-info-save-new');
            var useSavedCardBlock = document.getElementById('xpayments-delayed-payment-info-use-saved');
            if (useSavedCard) {
                saveNewCardBlock.style.display = 'none';
                useSavedCardBlock.style.display = 'block';
            } else {
                saveNewCardBlock.style.display = 'block';
                useSavedCardBlock.style.display = 'none';
            }
        }
    }

    this.showDefaultDelayedPaymentInfo = function () {
        if (xpaymentsWidgetWrapperConfig.delayedPayment) {
            var saveNewCardBlock = document.getElementById('xpayments-delayed-payment-info-save-new');
            var useSavedCardBlock = document.getElementById('xpayments-delayed-payment-info-use-saved');
            if ('none' === saveNewCardBlock.style.display && 'none' === useSavedCardBlock.style.display) {
                saveNewCardBlock.style.display = 'block';
            }
        }
    }

}

XPaymentsWidgetWrapper.prototype.initialize = function(settings, wrapperSettings) {
    this.getWidget().init(settings);

    // Assign handlers
    this.getWidget().on('fail', function() {
        if (wrapperSettings.fastLaneCheckout) {
            Checkout.instance.finishLoadAnimation();
        } else {
            jQuery('.steps').get(0).loadable.unshade();
            jQuery('.cart-items').get(0).loadable.unshade();
            jQuery('.place-order').removeClass('submitted');
        }
        core.trigger('checkout.common.anyChange');
        core.trigger('checkout.common.unblock');
    }).on('alert', function(params) {
        setTimeout(function () {
            if ('popup' === params.type) {
                core.trigger('message', {type: 'info', message: params.message});
            } else {
                core.showError(params.message);
            }
        }, 500)
    }).on('loaded', function(params) {
        if (this.getWidget().config.applePay.checkoutMode) {
            this.toggleApplePayButton(true);
        }
        this.showDefaultDelayedPaymentInfo();
    }, this).on('paymentmethod.change', function(params) {
        this.toggleApplePayButton('apple_pay' === params.newId);
        this.setSavedCardIdForDelayedPayment(params);
        this.toggleDelayedPaymentInfo(
          'card' === params.newId
          && 'undefined' !== typeof params.savedCardId
          && '' !== params.savedCardId
        );
    }, this);

    core.bind('xpaymentsAnonymousRegister', this.updateSaveCard);
    core.bind('xpaymentsTotalUpdate', this.updateTotal);
    core.bind('checkout.placeOrderButton.loaded', this.updatePlaceOrderButton);
    if (wrapperSettings.fastLaneCheckout) {
        core.bind('checkout.common.ready', this.onFlcSubmit);
        core.bind('fastlane_section_switched', this.onFlcSectionSwitch);
    }

    this.initialized = true;

    return this;
}

window.xpaymentsWidgetInstance = new XPaymentsWidgetWrapper();

jQuery(function() {
    var loadXPaymentsWidget = function() {
        var wrapper = window.xpaymentsWidgetInstance;
        if (
            'undefined' !== typeof xpaymentsWidgetConfig
            && !wrapper.initialized
        ) {
            wrapper.initialize(xpaymentsWidgetConfig, xpaymentsWidgetWrapperConfig)
        }

        if (wrapper.initialized) {
            wrapper.getWidget().config.applePay.enabled = wrapper.getWidget().config.applePay.checkoutMode = xpaymentsWidgetWrapperConfig.applePaySelected;
            wrapper.toggleApplePayButton(false);
            wrapper.load();
        }
    }
    loadXPaymentsWidget();
    core.bind('checkout.paymentTpl.loaded', loadXPaymentsWidget);
});
