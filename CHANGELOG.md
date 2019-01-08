## [2.3.0] - 2018-01-08

### New

- Extended support for FacetWP addons:
  - "Load More" https://facetwp.com/add-ons/load-more/
  - "Bookings" https://facetwp.com/add-ons/bookings/
  - "Hierarchy Select" https://facetwp.com/add-ons/hierarchy-select/
  - "Alphabetical Listing" https://facetwp.com/add-ons/alphabetical-listing/
  - "Color" https://facetwp.com/add-ons/color/

### Fix

- Further `:focus` accessibility improvements.
- Fallback to default shop sidebar on dynamic shop page mobile filters.
- Avoid Javascript error when focus element on horizontal nav bar does not exist.
- Avoid PHP syntax error.

## [2.2.0] - 2018-12-27

### New

- Accessibility improvements:
  - Better tabbing order for shop filters and results.
  - "Skip to content" and "Skip to result" skip links.
  - Ensure all focus outlines are visible.
- Upgrade developer experience:
  - Use more `@wordpress` `npm` packages (`eslint`, `browserslist`)
  - Update JS coding standards.
  - Update PHP coding standards.
  - Update CSS coding standards.
- Request a Google Fonts API key when generating font list.
- Allow integrations to define helper files to be autoloaded.

### Fix

- Avoid error if offcanvas drawer source or target does not exist.

## [2.1.0] - 2018-12-18

### New

- WordPress 5.x compatibility.
- Gutenberg 4.x compatibility.
- WooCommerce 3.5.x compatibility.

### Fix

- Ensure button color is accurately reflected.
- Coding standard updates.

## [2.0.0] - 2018-11-06

### Breaking

- Base stylesheet enqueued with wp_enqueue_script priority 20 (was 10).
- Base stylesheet renamed to app.scss (was style.scss) -- child themes referencing this need to update.

### New

- Gutenberg 4.2 compatibility.
- WooCommerce 3.5.1 compatibility.
- WooCommerce Bookings custom styles support.
- Keyboard accessibility improvements for desktop and mobile menus.

### Fix

- Do not output inline CSS for values that have not been customized.
- Stripe gateway checkout styles.
- More precise `em` to `px` conversions for better font smoothing.
- Icon menu alignment for icons of all sizes.
- WooCommerce message button alignment.
- Ensure external WooCommerce products are purchaseable.
- Ensure blockUI library uses accurate background color.

### Tweaks

- Default grid to be 80% page width at extra large device size.
- Better separation of integration CSS.
- Move integration views to main views directory.
- Remove fitvids in favor of Gutenberg responsive embeds.
- Remove offcanvas drawer cache for better dynamic content support.
- More consistent dynamic widget area names ("Page Name Sidebar (Left)")
- Adjust shop sidebar widths to be smaller.
- Grouped product purchase form appearance.

## [1.15.2] - 2018-10-12

### Fix

- WooCommerce 3.5 compatibility.

## [1.15.1] - 2018-10-12

### Fix

- Undefined PHP variables.
- Better UI feedback when checking and unchecking inputs in FacetWP.

## [1.15.0] - 2018-10-12

### New

- Gutenberg 3.9+ compatibility.
- Continued codebase improvements.

## [1.14.0] - 2018-08-25

### New

- WooCommerce Product Vendors support: https://woocommerce.com/products/product-vendors/
- Improved Gutenberg 3.5+ button support.
- Improved horizontal navigation user experience.
- Option to hide inventory counts in the product catalog.
- WooCommerce 3.5 template compatibility.

## [1.13.0] - 2018-08-14

### New

- Improve keyboard accessibility user interface.
- Allow CSS color variables to be overridden in a child theme.
- Gutenberg 3.5 compatibility (including custom font size support).

## [1.12.1] - 2018-08-02

### Fix

- Improved CSS architecture for easier child theme development.
- Ensure shop category list uses rounded corners.
- Fix syntax errors in `apply_filters()` calls.

## [1.12.0] - 2018-07-30

### New

- Improved UI for cart totals and shipping.
- WooCommerce 3.4.4 compatibility.
- Add Social Icons.
 - Can be used inline with `<i class="bigbox-icon bigbox-icon--twitter"></i>`.
 - Automatically applied to menu item links with social URLs.

### Fix

- Remove unneeded usage of `wp_kses_post()`
- Ensure scrolling is enabled after offcanvas drawer is closed.
- Simplify FacetWP and WooCommerce asset depenencies.
- Ensure WooCommece alert's are always 100% width.
- Update to WordPress Coding Standards 1.0.0

## [1.11.3] - 2018-07-24

### Fix

- Avoid double faux inputs on FacetWP filters.

## [1.11.2] - 2018-07-24

### Fix

- Don't output shipping calculator toggle when calculator is not output.
- Don't lazyload the custom logo.
- Properly add available stock to dropdown quantity.
- Spacing above checkout completion button.
- Ensure dynamic "Information" color is used for `.button--color-information` class.

## [1.11.1] - 2018-07-21

### Fix

- Ensure out of stock variations cannot be added to the cart.
- Spacing on cart totals.
- Ensure footer remains sticky when using widgets.

## [1.11.0] - 2018-07-20

### New

- Improve cart totals and shipping UI.
- Column support for Gutenberg 3.2.
- Bold product information titles.
- Remove bottom border when there is only a single line of products.

- `bigbox_is_rounded` filter to turn off rounded edges.
- `bigbox_integrations` filter to allow child themes to add more integrations.
- `bigbox_services` filter to allow child themes to add more services.
- `bigbox_customize_inline_css_' . $key` filter to modify the configuration CSS for each customizer option.
- `bigbox_woocommerce_product_price_before` action.
- `bigbox_woocommerce_product_price_after` action.
- `bigbox_woocommerce_loop_product_price_before` action.
- `bigbox_woocommerce_loop_product_price_after` action.

### Fix

- Improvements for easier child theme integration.
- Improvements to FacetWP integration.
- Don't output "See More Options" when a product is out of stock.
- WooCommerce view order escaping HTML.
- Avoid Javascript error in the customizer when no previous customizations have been made.

### Tweaks

- Output product sale flash via `bigbox_woocommerce_loop_product_price_before` and `bigbox_woocommerce_product_price_after`
- Add `product__meta` class to all product card meta items.

## [1.10.0] - 2018-07-11

### New

- Improved cart and checkout Shipping + Totals UX.
- Show product name first in Grouped Product table.
- Add border to WooCommerce placeholder image.

### Fix

- Add missing text domain in license manager.
- Remove unused file.
- Avoid unnecessary double escaping.
- Ensure theme remains active when PHP version is not met so message can be viewed.

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
