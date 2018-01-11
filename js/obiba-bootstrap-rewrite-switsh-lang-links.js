/*
 * Copyright (c) 2018 OBiBa. All rights reserved.
 *
 * This program and the accompanying materials
 * are made available under the terms of the GNU Public License v3.0.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * @file
 * JsScript to deal for the switch links lang widget
 */

(function ($) {

  Drupal.behaviors.hrefLanWrapper = {
    attach: function (context, settings) {

      if (document === context) {
        var href = $('a.fragment-link-place-holder');
        href.each(function (i,link) {
          var newLink = $(link).attr('href') + window.location.hash;
          $(link).attr('href', newLink);
          $(link).on("click", function (event) {
            event.preventDefault();
            window.location = newLink;
          });
        });
      }
    }
  }

})(jQuery);
