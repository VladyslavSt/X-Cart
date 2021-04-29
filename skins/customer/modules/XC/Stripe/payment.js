/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Stripe initialize
 *
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

core.bind(
  'checkout.main.initialize',
  function() {
    core.bind(
      'checkout.common.ready',
      function(event, state) {
        var box = jQuery('.stripe-box');

        var isNewCheckout = typeof Checkout !== 'undefined'
            && typeof Checkout.instance !== 'undefined';

        if (box.length
            && box.data('key')
            && (!isNewCheckout || Checkout.instance.getState().sections.current.name === 'payment')
        ) {
          var form = jQuery('form.place');
          form.removeAttr('onsubmit');
          form[0].commonController.submitBackground(
            function (XMLHttpRequest, textStatus, data, isValid) {
              data = JSON.parse(data);

              var stripe = Stripe(box.data('key'));
              stripe.redirectToCheckout({ sessionId: data.sessionId });

              return false;
            }.bind(this)
          );
        }
      }
    );
  }
);
