<?php

/*
	Plugin Name: Piwik PRO UTM Converter
	Plugin URI: https://wordpress.org/plugins/piwik-pro-utm-converter
	Description: The plugin redirects a URL to URL with converted utm_* to pk_* or pk_* to utm_* campaign parameters.
	Version: 1.0.1
	Author: piwikpro
	Author URI: https://piwik.pro
	Text Domain: piwik-pro-utm-converter
	Domain Path: /languages/
	License: GPLv3
	License URI: http://www.gnu.org/licenses/gpl-3.0.txt

	Copyright (C) 2018 by Piwik PRO <https://piwik.pro>
	and associates (see AUTHORS.txt file).

	This file is part of Piwik PRO UTM Converter plugin.

	Piwik PRO UTM Converter plugin is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	Piwik PRO UTM Converter plugin is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with Piwik PRO UTM Converter plugin; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

namespace PiwikPRO\UTM_Converter;

use PiwikPRO\UTM_Converter;
use Exception;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'get_plugin_data' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

foreach ( array( 'singleton', 'filterer', 'plugin' ) as $file ) {
	require_once( __DIR__ . "/framework/$file.php" );
}

foreach ( array( 'utm-converter', 'functions' ) as $file ) {
	require_once( __DIR__ . "/includes/$file.php" );
}

try {
	spl_autoload_register( __NAMESPACE__ . '::autoload' );

	if ( ! has_action( __NAMESPACE__ ) ) {
		do_action( __NAMESPACE__, UTM_Converter::instance( __FILE__, $_SERVER['REQUEST_URI'] ) );
	}
} catch ( Exception $exception ) {
	if ( WP_DEBUG && WP_DEBUG_DISPLAY ) {
		echo $exception->getMessage();
	}
}
