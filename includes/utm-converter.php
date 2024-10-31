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

namespace PiwikPRO;

use PiwikPRO\UTM_Converter\Plugin;
use PiwikPRO\UTM_Converter\Settings;

if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! class_exists( __NAMESPACE__ . '\UTM_Converter' ) ) {
	class UTM_Converter extends Plugin {
		protected $scheme    = '';
		protected $user      = '';
		protected $pass      = '';
		protected $host      = '';
		protected $port      = '';
		protected $path      = '';
		protected $query     = [];
		protected $fragment  = '';

		static protected $pk2utm = [
			'pk_source'      => 'utm_source',
			'pk_medium'      => 'utm_medium',
			'pk_campaign'    => 'utm_campaign',
			'piwik_campaign' => 'utm_campaign',
			'pk_keyword'     => 'utm_term',
			'pk_kwd'         => 'utm_term',
			'piwik_kwd'      => 'utm_term',
			'pk_content'     => 'utm_content'
		];

		static protected $utm2pk = [
			'utm_source'   => 'pk_source',
			'utm_medium'   => 'pk_medium',
			'utm_campaign' => 'pk_campaign',
			'utm_term'     => 'pk_keyword',
			'utm_content'  => 'pk_content'
		];

		public function __construct( $file, $url ) {
			parent::__construct( $file );

			Settings::instance();

			foreach( self::parse_url( $url ) as $key => $value )
				if ( isset( $this->$key ) and ! empty( $value ) ) $this->$key = $value;

			if ( $this->has_query() ) $this->query = self::parse_query( $this->query );
		}

		public function has_query() {
			return ! empty( $this->query );
		}

		public function filter_plugin_action_links( $actions, $plugin_file, $plugin_data, $context ) {
			if ( empty( static::$name        ) ) return $actions;
			if ( empty( $plugin_data['Name'] ) ) return $actions;
			if ( static::$name == $plugin_data['Name'] )
				array_unshift( $actions, static::get_template( 'link', [
					'url'   => get_admin_url( null, sprintf( Settings::URL, static::$slug ) ),
					'link'  => static::__( 'Settings' ),
				] ) );

			return $actions;
		}

		public function action_plugins_loaded() {
			if ( ! $this->has_query() ) return;

			$query = 'pk2utm' == Settings::get_option() ? self::pk2utm( $this->query ) : self::utm2pk( $this->query );
			if ( $query == self::build_query( $this->query ) ) return;

			$url = self::build_url( $this->scheme, $this->user, $this->pass, $this->host, $this->port, $this->path, $query, $this->fragment );
			if ( wp_redirect( $url ) ) exit;
		}

		static public function convert( $function, $query, $convert = [] ) {
			if ( ! is_array( $query ) ) $query = self::parse_query( $query );

			$convert = array_merge( self::$$function, $convert );
			$convert = apply_filters( $function, $convert );

			$query = self::array_change_keys( $query, $convert );
			return self::build_query( $query );
		}

		static public function pk2utm( $query, $convert = [] ) {
			return self::convert( 'pk2utm', $query, $convert );
		}

		static public function utm2pk( $query, $convert = [] ) {
			return self::convert( 'utm2pk', $query, $convert );
		}

		static public function array_change_keys( $array, $keys ) {
			foreach( array_keys( $array ) as $key ) if ( array_key_exists( $key, $keys ) ) $array = self::array_change_key( $array, $key, $keys[$key] );
			return $array;
		}

		static public function array_change_key( $array, $old_key, $new_key ) {
			if ( array_key_exists( $old_key, $array ) ) {
				$array[$new_key] = $array[$old_key];
				unset( $array[$old_key] );
			}
			return $array;
		}

		static public function parse_query( $query ) {
			$array = [];
			parse_str( $query, $array );
			return $array;
		}

		static public function build_query( $query ) {
			return http_build_query( $query );
		}

		static public function parse_url( $url ) {
			return parse_url( $url );
		}

		static public function build_url( $scheme = '', $user = '', $pass = '', $host = '', $port = '', $path = '', $query = '', $fragment = '' ) {
			if ( '//' == $scheme ) $url = '//';
			elseif( in_array( $scheme, [ 'http', 'https' ] ) ) $url = $scheme . '://';
			else $url = '';

			if ( $user ) {
				$url .= $user;
				if ( $pass ) $url .= ':' . $pass;
				$url .= '@';
			}
			$url .= $host;
			if ( $port )     $url .= ':' . $port;
			if ( $path )     $url .= $path;
			if ( $query )    $url .= '?' . $query;
			if ( $fragment ) $url .= '#' . $fragment;

			return $url;
		}
	}
}
