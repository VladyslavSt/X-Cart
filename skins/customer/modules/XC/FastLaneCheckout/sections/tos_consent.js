/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Terms and conditions vue component
 *
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

define(
  'checkout_fastlane/blocks/tos_consent',
  [
    'vue/vue',
    'checkout_fastlane/sections/section_change_button'
  ],
  function (Vue, ChangeButton) {
    var TosConsent = Vue.extend({
      name: 'tos-consent-checkbox',

      vuex: {
        actions: {
          updateTosConsent: function (store, value) {
            Vue.set(store.state.sections, 'tos_consent', value)
          }
        }
      },

      created: function () {
        this.updateTosConsent(false)
      },

      data: function () {
        return {
          checked: false
        }
      },

      watch: {
        checked: {
          handler: function (value) {
            this.updateTosConsent(value)
          }
        }
      }

    })

    Vue.registerComponent(ChangeButton, TosConsent)

    return TosConsent
  }
)
