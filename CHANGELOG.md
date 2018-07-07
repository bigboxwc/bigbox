## [1.9.0] - 2018-07-07

### New

- Better font weight fallbacks when no alternatives are available.
- Gutenberg 3.2 support.
- WooCommerce 3.5 support.
- Helpful customizer color control suggestions.
- Remove jQuery dependencies and optimize all Javascript (reducing file sizes).

## [1.8.0] - 2018-06-29

### New

- Update Node package project requirements.
- Project coding standard updates.
- Add more helpful color palette controls.

### Fix

- Ensure LazyLoad falls back when a full `srcset` is unavailable.
- Ensure FacetWP checkboxes and radio inputs load.

## [1.7.1] - 2018-06-25

### Fix

- Ensure images are lazy loaded again once FacetWP refreshes.
- Match Gutenberg title block to frontend.

## [1.7.0] - 2018-06-17

### New

- Better Grouped product support in WooCommerce.
- Lazyload images.

### Fix

- Cart and Order Review product title size.
- Ensure "Minimal" templates keep branding centered on mobile devices.

### Tweaks

- Various project management items.

## [1.6.0] - 2018-06-12

### New

- Allow catalog image sizes to be dynamically set in the Customizer.

### Fix

- More Gutenberg compatibility.
- Avoid PHP error on activation.
- Ensure header search spacing is equal when header account menu items are hidden.
- Add specific CSS class (`.product__meta--price`) to loop price output.
- WooCommerce pagination previous arrow direction.

## [1.5.0] - 2018-05-05

### New

- Automatically use Google's suggested fallback font category.

### Fix

- Remove unused starter content images.
- Remove unused walkthrough step when not needed.
- Gutenberg 3.0 compatibility.
- Remove unused string translation.

## [1.4.1] - 2018-04-31

### Fix

- Do not show Walkthrough pointer until needed.

## [1.4.0] - 2018-04-30

### New

- WooCommerce 3.4.1 compatibility.
- Add interactive Customization walkthrough with the ability to importer starter content.
- Attempt to automatically install WooCommerce on activation to allow for easy configuration.
- Show WooCommerce image placeholder by default. Add option to disable in Customize > WooCommerce > Product Images.
- Add reminder to enter a license key after 1 week of use.
- Filter `bigbox_navbar_search_form_url` -- https://docs.bigboxwc.com/article/29-change-the-url-of-the-header-search-form

### Fix

- Avoid running extraneous HTTP requests in dashboard when checking for updates.

## [1.3.0] - 2018-04-23

### New

- Show WooCommerce image placeholder by default. Add option to disable in Customize > WooCommerce > Product Images.
- Filter `bigbox_navbar_search_form_url` -- https://docs.bigboxwc.com/article/29-change-the-url-of-the-header-search-form

## [1.2.0] - 2018-04-22

### New

- Allow a font family fallback when using Google Fonts.

### Fix

- Avoid PHP error in `app/customize/preview.php`.
- Default to first font weight when the previously set weight no longer exists.
- Coding standard updates.

## [1.1.0] - 2018-04-21

### New

- Create dynamic shop landing pages using the "Shop" page template.
- Add more intuitive default widgets and sidebar usage.
- Allow default shop sidebar to be completely hidden.

## [1.0.2] - 2018-04-16

### Fix

- Automatic updater improvements.

## [1.0.1] - 2018-04-16

### Fix

- Mobile menu child menus now page forward and backwards consistently.

## [1.0.0] - 2018-04-15

### New

- Initial release.
