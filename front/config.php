<?php

include ("../../../inc/includes.php");
 
Plugin::load('wallboards', true);

Html::header(__('Wallboards Config', 'wallboards'), $_SERVER["PHP_SELF"], "config", "pluginwallboardsconfig");

$config = new PluginWallboardsConfig();
$config->showFormWallboards();

Html::footer();

?>