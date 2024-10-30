=== Croct - Content Personalization for WordPress ===
Contributors: Marcos Passos
Tags: croct, personalization, dynamic content, content personalization, optimization, marketing
Text Domain: croct
Requires at least: 4.0
Tested up to: 5.5.1
Stable tag: 1.0
Requires PHP: 5.4
License: MIT
License URI: https://opensource.org/licenses/MIT

Understand your audience interests and deliver the right content, to the right person, at the right time.

== Description ==

Understand your audience interests and deliver the right content, to the right person, at the right time.

Croct for WordPress provides powerful personalization capabilities using plain English. Personalize your content with more than 100 variables such as visitor context, device, browser, location, and much more!

## WHAT IS CONTENT PERSONALIZATION?

Content personalization refers to the ability to generate content dynamically based on the visitor's context.

## WHAT'S IN IT FOR YOU IF YOU USE PERSONALIZATION?

* Boost sales and engagement
* Sell more products
* Increase customer loyalty
* Increase the time users spend on your website
* Help visitors find the right content

## WHAT IS CROCT?

Croct is a personalization platform that provides a solution for developers to create natively personalized applications, as well as for marketing and product professionals to craft unique experiences based on the user's behavior, interests, and browsing history.

## CROCT PLUGIN FEATURES

* Fully integrated with WordPress with just a few clicks.
* Shortcodes for inline content personalization.
* Over 100 user variables, such as interests, device, browser, geolocation, referrers, query strings, etc.
* Visitor interest tracking on a per-post basis.

## HOW TO SET-UP AND APPLY PERSONALIZATION?

It only takes a few clicks to install the plugin and unlock the power of personalization. No need to insert code snippets or play with the styling of the plugin.

Once the plugin is installed, on the left-side menu, click Croct to open the settings page. Next, enter your app ID and click "Save Changes" to activate the integration.

If you do not have an account, please [get in touch](https://croct.com?utm_source=plugin&utm_medium=WordPress&utm_campaign=readme), so we can set up an account for you.

## HOW TO CAPTURE THE AUDIENCE'S INTERESTS?

Croct can help you understand your audience's interests based on posts and pages they visit. All you need to do is tell Croct what interests are related to each post in the section "Croct - User Interest" (on the sidebar menu, under Document) when publishing or updating a post. You can enter multiple interests separated by commas.

## HOW TO INSERT DYNAMIC CONTENT?

This plugin introduces two new shortcodes that allow you to create personalized posts.

The `[personalized]` shortcode works as a placeholder for contextual information, while the `[if]` shortcode allows you to show a content block conditionally.

The following example shows a conditional content block that will be displayed only for people who are sailing from Brazil. The content of the block is personalized according to the visitor's city, with fallback to "Brazil" in case the visitor's location is unknown.

> [if condition="location's country is 'BR'"]
> This paragraph is personalized for everyone who lives in [personalized value="location's city"]Brazil[/personalized].
> [/if]

Although the example shows the use of the `[personalized]` and `[if]` shortcodes combined, they can be used standalone. For example:

> Hello everyone from `[personalized value="location's city"]`Brazil`[/personalized]`!

## Data Processing

This plugin collects information about the visitor activities and sends to Croct to help you better understand your audience and personalize the content for them.

By installing and activating the Croct for WordPress plugin you agree to our [Terms of Service](https://croct.com/legal/customer/terms-of-service) and [Privacy Policy](https://croct.com/legal/customer/privacy-policy).

== Installation ==

1. Go to the Plugins > Add New page in your WordPress admin.
2. Search for "Croct" and click on the "Install Now" button.
3. Click on the "Activate" button.
4. Click Croct on the left side menu, enter your Application ID and save.

That's it! Your are all set.

== Frequently Asked Questions ==

= What does Croct do? =

Croct allows you to create personalized content based on your audience's interests, behavior, location, marketing campaign, and other 100+ variables.

= Who should use Croct? =

Content creators and marketing professionals that want to increase the engagement and time spent on the site.

= Does Croct work with caching? =

As the personalization is applied in real-time on the client-side, the plugin works even on WordPress sites with caching enabled.

= Is Croct compliant with data privacy laws? =

As a processor, Croct only tracks anonymous data automatically. If you intend to collect personal data, you, as a controller, need to get the user's consent before collecting and sending it to Croct.

= Do I have to install the code manually? =

No, the plugin handles all the installation for you. You only need to enter the Application ID once installed to activate the integration.

= Do I need a developer to use Croct Plugin? =

No, the personalization is codeless! You can write expressions in plain English :)

= What's required to use Croct Plugin? =

You must have a WordPress website and a Croct account.

= Can I use the plugin without having a Croct account? =

The plugin itself is free, but you need a Croct account to use it. If you do not have an account, please [get in touch](https://croct.com?utm_source=plugin&utm_medium=WordPress&utm_campaign=readme) so we can set up an account for you.

== Screenshots ==

1. Croct settings.
2. Input for defining audience's interests on a per-post basis.

== Changelog ==

= 1.0.0 (2020-09-18): =
* Initial Release

= 1.0.1 (2020-09-23): =
* Fix dependencies sort order (#2), thanks amorimjuliana!

= 1.0.2 (2020-09-23): =
* Fix release workflow to correctly set plugin version (#3), thanks Fryuni!

= 1.0.3 (2020-09-24): =
* Fix interest auto-complete (#4), thanks marcospassos!

= 1.0.4 (2021-01-07): =
* Add support for async script loading (#5), thanks marcospassos!

= 1.0.5 (2021-01-07): =
* Fix interest tracking with async script loading (#6), thanks marcospassos!

= 1.0.6 (2021-01-08): =
* Fix initialization script (#7), thanks marcospassos!

= 1.1.0 (2021-02-17): =
* Replace inline script with meta tags (#10), thanks marcospassos!
