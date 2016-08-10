=== CSS3 Transitions ===
Contributors: celloexpressions
Tags: css3, transitions, eye candy, ui, effects, smooth, automatic, auto, animate, animations
Requires at least: 3.0
Tested up to: 3.6
Stable tag: 1.3
Description: Automatically adds CSS3 transitions to your website/blog and the WordPress admin. Elements with hover/active/focus states get animated transitions.
License: GPLv2

== Description ==
This plugin automatically adds CSS3 transitions to your website/blog and the WordPress admin. Links, etc. get animated transitions between their normal and hover states. CSS3 Transitions are supported by the most recent version of every major browser (Chrome, Internet Explorer 10, Firefox, Opera, Safari); browsers without support will continue to render everything as they had before. This plugin adds the transitions (eye candy) to all `<a>` (link), `<li>` (list item, usually used in navigation menus), `<img>` (image), and `<input>` (form field and button) tags that have a hover or focus state defined (for example, if links change color when the mouse hovers over them). Other "buttons", form elements, and WordPress-specific selectors are also targeted. Transitions are between .2 and .3 seconds in duration, so they shouldn't cross the line between nice and distracting; however, depending on the colors used in your theme, the transitions may not be noticeable.

Also, please note that image sprites simply don't work well with blanket css3 transitions. If you see wierd animations where images scroll between their normal and hover states, they're using sprites. Depending on where the sprites are used, there are various ways to prevent the behavior on those elements, while retaining transitions where desired. One method is to add an inline style attribute to those elements: `style="transition: none; -webkit-transition: none;"`. Adding the css to your theme will override the plugin's css as long as you target the elements using sprites by class or id.

Please feel free to offer any feature suggestions you might have and I will consider them for future releases.

= CSS3 Transitions UX Theory =
Because of the way our brains process images, in simple terms, instant/sudden changes are generally not as well perceived as more gradual ones. In the physical space, we never see instant changes, like slides changing with no animation in a PowerPoint, but with digital technology this is a very common practice. When websites make use of hover states, for example, if a link changes color when the mouse hovers over it, they exhibit small, but instant visual changes. Adding the css3 transitions makes these changes more gradual, and therefore easier on the eye. For this same reason, operating systems now tend to make use of a lot of animations. There's a lot of neuroscience behind these concepts, but I'm not well versed in that. Basically, *slight* animations generally look better than instant changes. Some people will argue that things aren't as "snappy" or seem slugish with transitions, but if that's the case, it's only a matter of adjusting the animation timing function and duration.

== Installation ==
1. Take the easy route and install through the WordPress plugin adder OR
1. Download the .zip file and upload the unzipped folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. CSS3 transitions should automatically be added to your site and WordPress, as long as your theme has the `<?php wp_head() ?>` action hook

== Frequently Asked Questions ==
= The Transitions Aren't Working... =
First, make sure you know what the transitions look like (and you need to be using a mouse, not touch, for the majority of them, although they will show up for things that have css changes because of javascript too). Then, make sure that you are using a supported browser (Chrome, Internet Explorer 10+, Firefox 16+, Opera 12+, Safari 4+). Next, make sure that your theme's links have a different color or other effects when you mouse over them. This is the change that will be animated. Then, make sure that your theme's `header.php` file contains the `<?php wp_head() ?>` action hook. If none of that works, it's likely that your theme doesn't support transitions or has explicitly blocked them. However, you should still get the effects in the WordPress admin area if your browser supports them.

= Where's the settings page? =
For simplicity's sake, no settings page is included. While there are a few potential options, I don't feel that they would be worth the extra bloat of a settings page. If you would like to make adjustments (such as changing the animation duration), you may do so by editing the plugin's php file. 

== Changelog ==
= 1.3 =
* Introduce improved animation timing function (cubic-bezier(0.64,0.20,0.02,0.35))
* Remove -moz-, -ms-, and -o- browser prefixes. -webkit- is still required for Safari and older Android, but all other major browsers now support unprefixed transitions.
* Make the transitions faster
* Tested with WordPress 3.6 and the Twenty Thirteen theme

= 1.2 =
* Fixed a bug where transitions were being applied to the WordPress 3.5 color picker
* Fixed a bug where transitions were being applied to the WordPress nav menu editor drag-and-drop

= 1.1 =
* Fixed bug that made managing menus in the admin almost unusable because of unneeded transitions.
* Added targeting for several more elements, mostly form-related
* Updated readme

= 1.0 =
* First publically available version of the plugin
* Tested with WordPress 3.4 and 3.5. Should be compatible with most versions of WordPress

== Upgrade Notice ==
= 1.3 =
* Better animation timing function, faster animations, cleanup browser prefixes