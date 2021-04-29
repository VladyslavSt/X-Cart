/* X-Payments Cloud widget wrapper */

function XPaymentsWidgetWrapper()
{
    this.widget = new XPaymentsWidget();
    this.initialized = false;

    this.load = function() {
        this.disableSubmit();
        this.getWidget().load();
    }
    this.getWidget = function() {
        return this.widget;
    }

    this.getDialogElm = function() {
        var btn = jQuery('.popup-button.add-new-card').get(0);
        return jQuery(btn.linkedDialog)
    }

    this.disableSubmit = function() {
        assignWaitOverlay($('.widget-xpay-xpaymentscloud-cardsetup'));
        jQuery('#save_card').attr('disabled', true);
    }

    this.enableSubmit = function() {
        unassignWaitOverlay($('.widget-xpay-xpaymentscloud-cardsetup'));
        jQuery('#save_card').removeAttr('disabled');
    }
}

XPaymentsWidgetWrapper.prototype.initialize = function(settings, wrapperSettings) {
    this.getWidget().init(settings);

    // Assign handlers
    this.getWidget().on('fail', function() {
        this.enableSubmit();
    }, this).on('alert', function(params) {
        var closeDialog = false;
        var messageText = params.message;

        if ('popup' === params.type) {
            core.trigger('message', {type: 'info', message: messageText});
        } else {
            closeDialog = ('error' === params.type || 'tokenizeCardError' === params.type);

            if ('tokenizeCardError' === params.type) {
                messageText = wrapperSettings.tokenizeCardError;
            }
            core.showError(messageText);
        }
        if (closeDialog) {
            this.getDialogElm().dialog('close');
        }
    }, this).on('success', function(params) {
        var $form = jQuery('form.card-setup');
        jQuery('<input type="hidden" name="xpaymentsToken">').val(params.token).appendTo($form);
        $form.submit();
    }).on('loaded', function(params) {
        this.enableSubmit();
        // Center popup after widget is loaded
        this.getDialogElm().dialog('option', 'position', {my: 'center', at: 'center', of: window});
    }, this);

    jQuery('#save_card').click((function() {
        this.disableSubmit();
        this.getWidget().submit();
        return false;
    }).bind(this))

    this.initialized = true;

    return this;
}

window.xpaymentsWidgetInstance = new XPaymentsWidgetWrapper();
