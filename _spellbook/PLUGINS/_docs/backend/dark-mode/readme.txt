=== Dark Mode ===
Contributors: danieltj, munyagu, travel_girl, melchoyce, afercia, hedgefield, megane9988, presskopp, willrad
Tags: accessibility, admin, dashboard, profile, style
Requires at least: 4.0
Tested up to: 4.9
Stable tag: 1.5
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Lets your users make the WordPress admin dashboard darker.

== Description ==

= About the Plugin =

This is a beta plugin that might one day be part of the WordPress core. Please don't use this on production websites unless you're happy with the stability as some things may still be experimental.

Using technology at night time can have a negative effect on your eyesight. Dark Mode will darken the colours of your admin dashboard making it easier for you to work at night time.

For information on the progress of this plugin, please refer to the [Trac ticket](https://core.trac.wordpress.org/ticket/41928) or you can get involved on the [GitHub repository](https://github.com/danieltj27/Dark-Mode).

= Plugin Developers =

As some plugins make use of custom stylesheets, you can use the `doing_dark_mode` action hook to include a custom stylesheet that supports Dark Mode for your own plugin interfaces when it's enabled. Alternatively you can use the `dark_mode_css` filter hook to change the Dark Mode stylesheet for your own version if you'd prefer.

== Installation ==

1. Upload the package to the `wp-content/plugins` directory.
2. Login to the dashboard and activate the plugin.
3. Go to your profile and enable Dark Mode.

== Frequently Asked Questions ==

= Why is there a plugin for this? =

WordPress by default has a very bright colour scheme and this can hurt your eyes if you're working on a website late at night. Dark Mode provides a nice, darker alternative when it's late.

= What does this plugin do? =

It adds an option for people to enable a 'Dark Mode' which will turn the admin dashboard darker so it's nicer to use at night time.

= Can I contribute to this plugin? =

Yes, you can follow the Trac ticket for updates and get involved on GitHub with suggestions, feedback and code contributions.

= How can I remove the feedback link? =

The Feedback link will take a user to the GitHub repository and will only be shown when Dark Mode is currently on. To remove it for every user, put `define( 'DARK_MODE_FEEDBACK', false );` in your `wp-config.php` file.

== Screenshots ==

1. The dashboard with Dark Mode turned off.
2. The dashboard with Dark Mode turned on.
3. Dark Mode with an admin colour scheme in use.
4. The Dark Mode settings on a user's profile page.

== Changelog ==

= 1.5 =

* Added support for Code Mirror editor styles.
* Fixed a bug where automatic Dark Mode was set incorrectly.
* Improvements to how some core functions worked.
* Improvements to translation strings.

= 1.4 =

* Updated the stylesheet to now include new Customiser styles.
* Further updates to the readme.txt file to address typos and updates.
* Moved the toolbar links to the right and added feedback to a drop down.
* Fixed an issue with Dark Mode being automatically turned on or off.

= 1.3 =

* Added link to GitHub repository for people to provide feedback.
* Added the ability to schedule Dark Mode to come on between certain times.
* Improved the implementation of certain core functions for better control.
* Updated the styles to include more areas that were previously unstyled.

= 1.2 =

* Added CSS source maps to files making it easier to develop the stylesheet further.
* Updated a translation string for better clarity.
* Updated the documentation comments for a few functions.
* Fixed more issues with elements that are not styled. Thanks to all those who spotted them!
* Minor optimisations made to the stylesheet to help reduce the file size.

= 1.1.2 =

* Further updates to the colour palette used in the new design.
* More elements within the dashboard have been styled.

= 1.1.1 =

* Updated the readme.txt file information.
* Minor improvements to code documentation blocks.
* Restyled the new Try Gutenberg banner on the dashboard index.
* Updated the colour palette and swapped blue for purple!

= 1.1 =

* Redesigned (most of) the admin dashboard into a darker design.
* Added a filter hook to change the URL of the Dark Mode stylesheet.
* Minor improvements to the code.

= 1.0 =

* Initial version.
