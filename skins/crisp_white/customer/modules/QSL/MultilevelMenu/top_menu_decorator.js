/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Top menu decorator
 *
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

decorate(
  'TopMenuAutoHide',
  'updateMenu',
  function () {
    arguments.callee.previousMethod.apply(this, arguments);

    const $moreSubmenu = this.$element.children('.more');
    fixHtmlStructure($moreSubmenu);
  }
);

function fixHtmlStructure(submenu) {
  submenu.find('.has-sub').each(function () {
    $submenu = $(this);
    $subsubmenu = $submenu
      .children('.submenu_block')
      .children('ul');

    $submenu
      .children('.submenu_block')
      .remove();

    $submenu.append($subsubmenu);
  });
}
