=== Plugin Name ===
Contributors: KenazChan
Company link: http://centil.co/
Tags: alert, connection error, customization, database down, database error, email alert, monitor, responsive, template, website down
Requires at least: 3.0.1
Tested up to: 4.7.1
Stable tag: 2.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

With DB Error Customizer, it helps you to handle Error establishing a database connection problem easily and professionally.

== Description ==

Database not responding is a very common issue in hosting a WordPress website. Instead of showing a blank page with an error message **Error establishing a database connection**, DB Error Customizer helps you to handle it professionally. Not only you can easily customize a beautifully designed database error page using our predefined templates, it tells your visitors that everything is under control.

> ### Premium Support
> Our team does not always provide active support for the DB Error Customizer plugin on the WordPress.org. One-on-one email support is available to people who bought the [DB Error Customizer Premium](http://dec.centil.co) plugin only.
>
> Note that the DB Error Customizer Premium plugin has many extra features too, including beautifully designed templates, animation effects and auto email alert. It might be well worth your investment!

Below are the features of DB Error Customizer:

* Comes with basic templates and allows you to customize:
   * Main message to show your visitor, instead of standard error
   * Sub message below main message
   * Font size adjustment
   * Font color adjustment
   * Background color
* Preview customized output before saving
* Inform search engine that the error page is temporarily (HTTP 500 Internal Server Error header) and it should not cache it

== Installation ==

Please refer the official [WordPress Plugin Installation Guide](https://codex.wordpress.org/Managing_Plugins#Installing_Plugins) to proceed. After you've installed and enabled DB Error Customizer, you shall goto **Settings->DB Error Customizer** to customize and setup the error page.

*Note: If you installed an older/premium version earlier, please disable the plugin and remove it before installing a newer version.*

== Customize DB Error Page ==

After enabling DB Error Customizer, you can access it at **Settings->DB Error Customizer**. Below is description of each feature:

* **Template:** Drop down option for you to select a predefined templates. The selected template will unlock different other options. (Free version only supports basic template)
* **Background Color:** Change background color via color picker.
* **Font Color:** Change main/sub title color via color picker.
* **Main Title:** The main title of database error page.
* **Main Title Size:** The size of main title.
* **Sub Title:** The sub title of database error page.
* **Sub Title Size:** The size of sub title.

**Preview:** When you press Preview button at the bottom of dashboard, a message box will apear at the top of dashboard with message Preview page generated successfully! Click Preview to proceed. You can press the Preview link to launch the preview page.

**Setup/Update DB Error Page:** When you press Setup/Update DB Error Page button at the bottom of dashboard, the plugin will save your settings and install this customized database error page to your WordPress. The page will automatically show up to visitor when your website's database does not respond.

== Screenshots ==
1. Basic template (Background/font color, title and sub-title are fully customizable)

== Frequently Asked Questions ==

= How can I check if DB Error Customizer can work on my server? =
There is a feature to allow user to test their server compatibility. You can run the test by pressing Check Compatibility button at the admin page.

= There is an error when I try to preview or setup database error page =
The error that you are seeing most likely is due to DB Error Customizer does not has write/read access to certain required file(s). A quick workaround is to temporarily [change the reported file permission](https://codex.wordpress.org/Changing_File_Permissions) to 777, proceed with DB Error Customizer setup and once you are done, using similar method to revert the file permission to its original state.

= How can I test if the customized error page is working on my live server? =
After error page setup, you can test it by:

* Force stop your database service (Requires root permission). Please remember to restart database service once you are done.
* Manually set invalid database configuration in your wp-config.php. Please remember to revert to original setting once you are done.

== Support ==
Please refer the developer's site at [Centil Technology](http://centil.co). If you would like to provide feedback/contact or just drop us an email, please feel free to contact us at info[at]centil[dot]co

== Changelog ==

= 2.0 =
* Major refactoring and bug fixes
* Tested with WordPress 4.7.1

= 1.3 =
* Tested with WordPress 4.5.3

= 1.2 =
* Enhanced plugin to better handle security.

= 1.1 =
* Enhanced plugin to better generate file in WordPress core system.

= 1.0 =
* First complete version