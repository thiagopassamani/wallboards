<?php

include ("../../../inc/includes.php");
 
Plugin::load('wallboards', true);

Html::header(PluginWallboardsMenu::getMenuName(), $_SERVER["PHP_SELF"], "plugins", "PluginWallboardsMenu");

$menu = new PluginWallboardsMenu();
$menu->showFormWallboards();

Html::footer();

?>