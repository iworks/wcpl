<?php
/*
  Plugin Name: WordCamp Polska
  Plugin URI: http://wordpress.org/extend/plugins/wcpl/
  Description: Promotion materials for WordPress Polska.
  Author: Marcin Pietrzak
  Author URI: http://iworks.pl/
  Version: 0.1

Copyright Marcin Pietrzak (marcin@iworks.pl)

this program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

 */

if ( !defined( 'WPINC' ) ) {
    die;
}

include_once dirname(__FILE__).'/etc/options.php';

$vendor = dirname(__FILE__).'/vendor';

require_once $vendor.'/iworks/wordcamp/widget.php';

add_action( 'widgets_init', function(){
    register_widget( 'iWorks_WordCamp_Widget' );
});

if ( !class_exists('iworks_options') ) {
    include_once $vendor.'/iworks/options.php';
}
include_once $vendor.'/iworks/wordcamp/poland.php';

/**
 * i18n
 */
load_plugin_textdomain( 'wcpl', false, dirname( plugin_basename( __FILE__) ).'/languages' );

/**
 * load options
 */
function get_iworks_wordcamp_poland_options()
{
    $options = new iworks_options();
    $options->set_option_function_name( 'iworks_wordcamp_poland_options' );
    $options->set_option_prefix( 'wcpl_' );
    $options->init();
    return $options;
}

function iworks_wordcamp_poland_activate()
{
    $options = get_iworks_wordcamp_poland_options();
    $options->activate();
}

function iworks_wordcamp_poland_deactivate()
{
    $options->set_option_prefix( iworks_wordcamp_poland);
    $options->deactivate();
}
/**
 * start
 */
new iworks_wordcamp_poland();
