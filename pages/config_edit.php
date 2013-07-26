<?php
form_security_validate( 'plugin_MingleIntegration_config_edit' );

auth_reauthenticate( );
access_ensure_global_level( config_get( 'manage_plugin_threshold' ) );

$f_mingle_url_instance = gpc_get_string( 'mingle_url_instance' );
$f_mingle_username = gpc_get_string( 'mingle_username' );
$f_mingle_password = gpc_get_string( 'mingle_password' );
$f_project = gpc_get_string( 'project' );
$f_default_card_type = gpc_get_string( 'default_card_type' );

if( plugin_config_get( 'mingle_url_instance' ) != $f_mingle_url_instance ) {
  plugin_config_set( 'mingle_url_instance', $f_mingle_url_instance );
}

if( plugin_config_get( 'mingle_username' ) != $f_mingle_username ) {
  plugin_config_set( 'mingle_username', $f_mingle_username );
}

if( plugin_config_get( 'mingle_password' ) != $f_mingle_password ) {
  plugin_config_set( 'mingle_password', $f_mingle_password );
}

if( plugin_config_get( 'project' ) != $f_project ) {
  plugin_config_set( 'project', $f_project );
}

if( plugin_config_get( 'default_card_type' ) != $f_default_card_type ) {
  plugin_config_set( 'default_card_type', $f_default_card_type );
}

form_security_purge( 'plugin_MingleIntegration_config_edit' );

print_successful_redirect( plugin_page( 'config', true ) );
