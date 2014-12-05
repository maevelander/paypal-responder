=== PayPal Responder ===
Contributors: EnigmaWeb
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=CEJ9HFWJ94BG4
Tags: paypal, paypal responder, paypal return url, paypal email, autoresponder, auto-responder, email responder, email responder paypal
Requires at least: 3.1
Tested up to: 4.0.1
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A really simple PayPal plugin.

== Description ==

PayPal Responder processes payment for a product via PayPal, then sends an email responder to the customer and returns them to a URL of your choice. That's it.

You can use it to sell any type of product/s on your website. There is no cart, checkout process or anything complicated - it just lets the user buy a single product in 1 click, then returns them to a URL of your choice, and emails them the auto-responder.

= Example Usage =

Let's say you're selling an eBook. User clicks "Buy" button > user is directed through PayPal checkout > once checkout it completed user is returned to a thank you URL and emailed the eBook.

I developed this plugin for a usage similar to above example. I didn't want a fully fledged eCommerce system, and many other solutions include Add to Cart and then whole heap of other stop screens that hindered the transaction.

= Key Features =

*	Simple, light-weight PayPal plugin
*	Can handle multiple products
*	Can accept any currency PayPal can handle
*	Set customer return URL 
*	Helpful tags available to use in auto-responder template
*	Use default PayPal 'buy now' button or upload a png button of your own

= Pro Version Available =

[Get Pro Version](http://enigmaplugins.com/plugins/paypal-responder-pro/) if you need the following advanced features:

*	Attach a file to responder (simple digital delivery of your product)
*	Unlimited responder templates (so you can use a different email responder for each different product)


== Installation ==

1. Upload the `paypal-responder` folder to the `/wp-content/plugins/` directory
1. Activate the PayPal Responder plugin through the 'Plugins' menu in WordPress
1. Configure the plugin by going to the `PayPal Responder` tab that appears in your admin menu.
1. Add buy buttons to any page using shortcode which is generated in the Manage Products area
 
== Frequently Asked Questions ==

= What could I sell with this plugin? =

You can sell whatever you want. There aren't any fancy features in this plugin - like it doesn't have delivery options, order management etc so it's really designed for just a single simple product. For example I use it to sell access to a private site - after successful checkout user is sent the password to log in. You could use it for other similar things like to sell a PDF or eBook, or you might use it for selling a virtual product or service like say consultation services for example. 

= Can I add more than 1 product? =

Yes the plugin can have any number of products. In this free version you can only set 1 return URL and 1 email auto-responder template.
 
= Can I attach a file to send with the auto-responder? =

Not in free version. You can in Pro - [available here.](http://enigmaplugins.com/plugins/paypal-responder-pro/)

= Where can I get support for this plugin? =

If you've tried all the obvious stuff and it's still not working please request support via the forum.


== Screenshots ==

1. The General Settings screen in WP-Admin
2. The Product Management screen in WP-Admin

== Changelog ==

= 1.2 =
* Added PayPal partner code

= 1.1 =
* Security patch for hiding PayPal amount field
* Corrected currency text on settings screen

= 1.0 =
* Initial release

== Upgrade Notice ==

= 1.2 =
* Added PayPal partner code

= 1.1 =
* Security patch for hiding PayPal amount field
* Corrected currency text on settings screen

= 1.0 =
* Initial release
