/* Connect widget wrapper */

function XPaymentsConnectWrapper()
{
    this.widget = new XPaymentsConnect();
    this.load = function() {
        this.getWidget().load();
    }
    this.getWidget = function() {
        return this.widget;
    }
}

XPaymentsConnectWrapper.prototype.init = function(settings, wrapperSettings) {
    this.getWidget().init(settings);

    // Assign handlers
    this.getWidget().on('alert', function(params) {
        if ('error' === params.type) {
            core.showError(params.message);
        } else {
            core.trigger('message', {type: 'info', message: params.message});
        }
    }).on('config', function(params) {
        var data = {};
        data['settings[account]'] = params.account;
        data['settings[api_key]'] = params.apiKey;
        data['settings[secret_key]'] = params.secretKey;
        data['settings[widget_key]'] = params.widgetKey;
        data['settings[quickaccess_key]'] = params.quickAccessKey;
        if (wrapperSettings.justAdded) {
            data['just_added'] = 1;
        }
        data[xliteConfig.form_id_name] = xliteConfig.form_id;

        core.post(
            {
                target: 'payment_method',
                method_id: wrapperSettings.xpaymentsMethodId,
                action: 'update'
            },
            null,
            data
        );

        jQuery('#cloud-register-info').hide()
    }).on('cookiesBlocked', function (params) {
        if (jQuery('#cookies-blocked').length) {
            jQuery('#xpayments-iframe-container').hide();
            jQuery('#cloud-register-info').hide();
            jQuery('.payment-status').hide();
            jQuery('#cookies-blocked').show();
            jQuery('#xpayments-admin-link').attr('href', params.adminUrl)
        }
    });

    core.bind('xpaymentsReloadPaymentStatus', function () {
        core.get(
            URLHandler.buildURL({target: 'payment_method', method_id: wrapperSettings.currentMethodId, widget: '\\XLite\\View\\Payment\\MethodStatus'}),
            function(xhr, status, data) {
                var paymentStatus = jQuery(data).find('.payment-status');
                if (paymentStatus.length > 0) {
                    jQuery('.payment-status').html(paymentStatus.html());
                    var uuid = _.uniqueId();
                    core.parseResources(jQuery.parseHTML(data), uuid);
                    core.microhandlers.runAll();
                    core.autoload(PaymentMethodSwitcher);
                }
            }
        );
    })

    return this;
}

window.xpaymentsConnectInstance = new XPaymentsConnectWrapper();

jQuery(function() {
    xpaymentsConnectInstance.init(xpaymentsConnectConfig, xpaymentsConnectWrapperConfig);
    xpaymentsConnectInstance.load();
})
