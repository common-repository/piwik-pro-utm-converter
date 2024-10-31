<?php

/*
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

if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! class_exists( __NAMESPACE__ . '\Settings' ) ) {
	class Settings extends Filterer {
		const URL = 'options-general.php?page=%s';

		public function action_admin_init() {
			register_setting(     UTM_Converter::$slug, UTM_Converter::class, [ __CLASS__, 'sanitize' ] );
			add_settings_section( UTM_Converter::$slug, UTM_Converter::$name, [ __CLASS__, 'section'  ], UTM_Converter::$slug );

			add_settings_field( UTM_Converter::$slug, UTM_Converter::__( 'Convert & Redirect' ), [ __CLASS__, 'field' ], UTM_Converter::$slug, UTM_Converter::$slug );
		}

		public function action_admin_menu_999() {
			add_options_page(
				UTM_Converter::$name,
				UTM_Converter::get_template( 'menu', [
					'class'   => 'dashicons-before dashicons-chart-area',
					'content' => UTM_Converter::$name
				] ),
				'manage_options',
				UTM_Converter::$slug,
				[ __CLASS__, 'page' ]
			);
		}

		static public function page() {
			echo UTM_Converter::get_template( 'page', [
				'option_group' => UTM_Converter::$slug,
				'page'         => UTM_Converter::$slug
			] );
		}

		static public function section() {
			echo UTM_Converter::get_template( 'section', [
				'content' => UTM_Converter::__( 'Settings' )
			] );
		}

		static public function field() {
			$utm = UTM_Converter::get_template( 'code', [ 'content' => 'utm_*' ] );
			$pk  = UTM_Converter::get_template( 'code', [ 'content' => 'pk_*'  ] );
			$to  = UTM_Converter::__( 'to' );

			foreach( [ 'utm2pk' => "$utm $to $pk", 'pk2utm' => "$pk $to $utm" ] as $key => $value )
				echo self::input( [
					'type'    => 'radio',
					'name'    => UTM_Converter::class,
					'value'   => $key,
					'after'   => $key,
					'checked' => checked( self::get_option(), $key, false ),
					'desc'    => sprintf( UTM_Converter::__( 'Redirects a URL to a URL with converted %s campaign parameters.' ), $value )
				] ) . '<br />';
		}

		static public function input( $args ) {
			extract( $args, EXTR_SKIP );

			echo UTM_Converter::get_template( 'input', [
					'atts' => self::implode( [
							'type'  => isset( $type )  ? $type  : '',
							'class' => isset( $class ) ? $class : '',
							'name'  => isset( $name )  ? $name  : '',
							'value' => isset( $value ) ? $value : ''
						]
					),
					'checked' => isset( $checked ) ? $checked : '',
					'before'  => isset( $before )  ? $before  : '',
					'after'   => isset( $after )   ? $after   : '',
					'desc'    => isset( $desc )    ? $desc    : ''
				]
			);
		}

		static public function implode( $atts = [] ) {
			array_walk( $atts, function ( &$value, $key ) {
				$value = sprintf( '%s="%s"', $key, esc_attr( $value ) );
			} );

			return implode( ' ', $atts );
		}

		static public function sanitize( $option = 'utm2pk' ) {
			return 'pk2utm' === $option ? 'pk2utm' : 'utm2pk';
		}

		static public function get_option() {
			return self::sanitize( get_option( UTM_Converter::class ) );
		}
	}
}
