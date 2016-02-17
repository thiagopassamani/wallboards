<?php

include ("../../../inc/includes.php");
 
Plugin::load('wallboards', true);

Html::header(PluginWallboardsMenu::getTypeName(), $_SERVER["PHP_SELF"], "plugins", "PluginWallboardsMenu");

$config = new PluginWallboardsConfig();
$config->showFormWallboards();

Html::footer();

?>