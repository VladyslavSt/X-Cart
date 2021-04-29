/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Terms and conditions fake vue component to control the real one
 *
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

define(
  'checkout_fastlane/blocks/fake_tos_consent',
  [
    'vue/vue',
    'checkout_fastlane/sections/payment',
    'checkout_fastlane/blocks/tos_consent'
  ],
  function (Vue, Payment, _TosConsent) {
    var FakeTosConsent = Vue.extend({
      replace: false,
      name: 'fake-tos-consent',

      vuex: {
        getters: {
          tosConsent: function (state) {
            return typeof state.sections.tos_consent !== 'undefined'
              ? state.sections.tos_consent
              : true
          }
        }
      },

      computed: {
        isValid: {
          cache: false,
          get: function () {
            return this.tosConsent
          }
        }
      },

      watch: {
        tosConsent: function () {
          this.$dispatch('update', {})

          this.$nextTick(function () {
            $('form.place').change()
          })
        }
      }
    })

    Vue.registerComponent(Payment, FakeTosConsent)

    return FakeTosConsent
  }
)
