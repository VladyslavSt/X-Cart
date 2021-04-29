/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Paypal initialize Express Checkout on click 'Place order'
 *
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

core.bind([
  'checkout.main.ready',
  'checkout.common.anyChange',
  'checkout.sections.payment.persist',
  'checkout.paymentTpl.loaded',
  'checkout.common.state.ready'
], function (event, controller) {

  // all paypal selectors that are hidden temporarily
  var affected_paypal_selectors = {}

  // show/hide opposite default_buttons/paypal_buttons
  var func_toggle_opposite_buttons = function (_selector, _show) {
    $(_selector).toggle(_show)
    $('.review-step form.place .button-row').toggle(!_show)
    $('.checkout_fastlane_section-buttons form.place .checkout_fastlane_section-place_order').toggle(!_show)
  }

  // step 2. Show all temporarily hidden paypal selectors
  $('#tosconsent').on('click', function () {
    for (var selector in affected_paypal_selectors) {
      func_toggle_opposite_buttons(selector, this.checked)
    }
  })

  var show_conditionally = function (selector) {
    var locked_by_toscheckbox = $('#tosconsent').length && $('#tosconsent').prop('checked') === false
    if (locked_by_toscheckbox) {
      // step 1. temporarily hide paypal buttons
      affected_paypal_selectors[selector] = 1
      func_toggle_opposite_buttons(selector, false)
    } else {
      // default behaviour wo this checkbox
      $(selector).show()
    }
  }

  if ($('.paypal-checkout-box').length > 0) {
    $('.review-step form.place .button-row').hide();
    show_conditionally('form.place .paypal-ec-checkout')
    $('form.place .paypal-ec-checkout-credit').hide();
    $('form.place .paypal-checkout-for-marketplaces').hide();

    //fastlane
    $('.checkout_fastlane_section-buttons form.place .checkout_fastlane_section-place_order').hide();
  } else if ($('.paypal-checkout-credit-box').length > 0) {
    $('.review-step form.place .button-row').hide();
    $('form.place .paypal-ec-checkout').hide();
    $('form.place .paypal-checkout-for-marketplaces').hide();

    //fastlane
    $('.checkout_fastlane_section-buttons form.place .checkout_fastlane_section-place_order').hide();

    show_conditionally('form.place .paypal-ec-checkout-credit')
  } else if ($('.paypal-checkout-for-marketplaces-box').length > 0) {
    $('.review-step form.place .button-row').hide();
    $('form.place .paypal-ec-checkout').hide();
    $('form.place .paypal-ec-checkout-credit').hide();

    if ($('.paypal-checkout-for-marketplaces').hasClass('unavailable')
      && $('.paypal-checkout-for-marketplaces').is(':hidden')
    ) {
      core.trigger('message', {type: 'warning', message: core.t('We are experiencing a problem with the "PayPal For Marketplaces" payment method.')});
    }

    //fastlane
    $('.checkout_fastlane_section-buttons form.place .checkout_fastlane_section-place_order').hide();

    show_conditionally('form.place .paypal-checkout-for-marketplaces')

  } else if ($('.pcp-checkout-box').length > 0) {
    $('.review-step form.place .button-row').hide();
    $('form.place .paypal-ec-checkout').hide();
    $('form.place .paypal-ec-checkout-credit').hide();

    //fastlane
    $('.checkout_fastlane_section-buttons form.place .checkout_fastlane_section-place_order').hide();

    show_conditionally('form.place .pcp-button-container')
    show_conditionally('form.place .pcp-hosted-fields-container')

  } else {
    $('.review-step form.place .button-row').show();
    $('form.place .pp-express-checkout-button').hide();
    $('form.place .pcp-button-container').hide();
    $('form.place .pcp-hosted-fields-container').hide();

    //fastlane
    $('.checkout_fastlane_section-buttons form.place .checkout_fastlane_section-place_order').show();
  }

  $(window).trigger('resize');
});

core.bind('checkout.common.state.nonready', function (state) {
  $('form.place .pp-express-checkout-button').addClass('nonready');
});

core.bind('checkout.common.state.ready', function (state) {
  $('form.place .pp-express-checkout-button').removeClass('nonready');
});

