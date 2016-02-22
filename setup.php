<?php

//============================================================================//
//==    Plugin para GLPI - Desenvolvido por: Thiago Passamani  -  ©2015     ==//
//==        http://thiagopassamani.com.br - thiagopassamani@gmail.com       ==//
//============================================================================//

//http://viduc.developpez.com/tutoriel/glpi/
//http://www.fortisfio.com/developper-un-plugin-glpi-v0-83-91/

include_once (GLPI_ROOT . "/inc/includes.php");
include_once (GLPI_ROOT . "/inc/commondbtm.class.php");

include_once ("inc/menu.class.php");
include_once ("inc/config.class.php");

if (!defined('GLPI_ROOT')) define('GLPI_ROOT', '../../..');
if (!defined('WALLBOARDS_VERSION')) define('WALLBOARDS_VERSION', '0.0.1'); // Versão do Plugin

/**
 * Versão do Plugin
 */
function plugin_version_wallboards()
{
  global $DB, $LANG;
  
  return array
  (
    'name'            => __('Wallboards for GLPI','wallboards'),
    'version'         =>  WALLBOARDS_VERSION,
    'author'          => '<a href="mailto:thiagopassamani@gmail.com">Thiago Passamani</a>',
    'license'         => 'GPLv2+',
    'homepage'        => 'https://github.com/thiagopassamani/wallboards',
    'minGlpiVersion'  => '0.85.1'
  );
}

/**
 * Verifica a versão se é compativel
 */
function plugin_wallboards_check_prerequisites()
{
  if (GLPI_VERSION >= '0.85.1')
  {
    return true;
  }
  else
  {
    echo "GLPI version not compatible, need > 0.85.1";
  }
}

/**
 * Checa a configuração do Plugin
 */
function plugin_wallboards_check_config( $verbose = false )
{
  if ( true )
  {
    return true;
  }
  
  if ( $verbose )
  {
    echo 'Installed / not configured';
  }

  return true;

}

/**
 * Inicia as entradas do plugin
 */
function plugin_init_wallboards()
{
    global $PLUGIN_HOOKS, $CFG_GLPI;

    $plugin = new Plugin();

    Plugin::registerClass('PluginWallboardsMenu', 'PluginWallboardsConfig');

    $PLUGIN_HOOKS['csrf_compliant']['wallboards'] = true;
    $PLUGIN_HOOKS['menu_toadd']['wallboards'] = array('plugins' => 'PluginWallboardsMenu',
                                                      'config'   => 'PluginWallboardsConfig');
    // Config page
    if (Session::haveRight('config',UPDATE))
    {
        $PLUGIN_HOOKS['config_page']['wallboards'] = 'front/config.php';
    }   

    /* Thiago Passamnai - Exibir no painel do usuário */
    //$PLUGIN_HOOKS["helpdesk_menu_entry"]['wallboards'] = true;
}
?>