=== Piwik PRO UTM Converter ===
Contributors: piwikpro, PiotrPress
Tags: Piwik PRO, Piwik, Piwik PRO UTM Converter, UTM, PK, analytics, campaign parameters, campaign, url parameters
Requires PHP: 7.0
Requires at least: 4.7.3
Tested up to: 4.9.4
Stable tag: trunk
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.txt

The plugin redirects a URL to URL with converted utm_* to pk_* or pk_* to utm_* campaign parameters.

== Description ==

The WordPress Piwik PRO UTM Converter plugin automatically recognizes campaign parameters and redirects a URL to the URL with converted parameters: `utm_*` to `pk_*` or `pk_*` to `utm_*`, depending on the plugin's settings.

Conversion `pk_*` to `utm_*`:

* pk_source => utm_source
* pk_medium => utm_medium
* pk_campaign => utm_campaign
* piwik_campaign => utm_campaign
* pk_keyword => utm_term
* pk_kwd => utm_term
* piwik_kwd => utm_term
* pk_content => utm_content

Conversion `utm_*` to `pk_*`:

* utm_source => pk_source
* utm_medium => pk_medium
* utm_campaign => pk_campaign
* utm_term => pk_keyword
* utm_content => pk_content

== Installation ==

= From your WordPress Dashboard =

1. Go to 'Plugins > Add New'
2. Search for 'Piwik PRO UTM Converter'
3. Activate the plugin from the Plugin section in your WordPress Dashboard.

= From WordPress.org =

1. Download 'Piwik PRO UTM Converter'.
2. Upload the 'piwik-pro-utm-converter' directory to your '/wp-content/plugins/' directory using your favorite method (ftp, sftp, scp, etc...)
3. Activate the plugin from the Plugin section in your WordPress Dashboard.

= Once Activated =

Visit 'Settings > Piwik PRO UTM Converter' and choose a conversion method.

= Multisite =

The plugin can be activated and used for just about any use case.

* Activate at the site level to load the plugin on that site only.
* Activate at the network level for full integration with all sites in your network (this is the most common type of multisite installation).

== Frequently Asked Questions ==

= What are minimum requirements for the plugin? =

* PHP interpreter version >= 5.4

== Screenshots ==

1. **WordPress General Settings** - Visit 'Settings > Piwik PRO UTM Converter' and choose a conversion method.


== Changelog ==

= 1.0.1 =
*Release date: 08.03.2018*

* Fixed: Compatibility with WooCommerce.

= 1.0.0 =
*Release date: 14.03.2017*

* First stable version of the plugin.