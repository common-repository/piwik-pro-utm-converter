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

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! function_exists( 'utm2pk' ) ) {
	function utm2pk( $query, $convert = [] ) {
		return UTM_Converter::utm2pk( $query, $convert );
	}
}

if ( ! function_exists( 'pk2utm' ) ) {
	function pk2utm( $query, $convert = [] ) {
		return UTM_Converter::pk2utm( $query, $convert );
	}
}
