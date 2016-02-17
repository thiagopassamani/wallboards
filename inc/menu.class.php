<?php 

if (!defined('WALLBOARDS_ROOT')) define('WALLBOARDS_ROOT', '..');

class PluginWallboardsMenu extends CommonDBTM {

   //static protected $notable = true;
   
   static function getMenuName() {
      return __('Wallboards for GLPI', 'wallboards');
   }
   
   static function getMenuContent() {
    global $CFG_GLPI, $LANG;
   
    $menu = array();

      $menu['title']           = self::getMenuName();
      $menu['page']            = self::getSearchURL(false);

      if (Session::haveRight("config", UPDATE)) {
         $menu['links']['add'] = self::getFormURL(false);
      }
        
    return $menu;
   }
   function showFormWallboards() {
      global $CFG_GLPI;

      echo "<form name='form' action='' method='post'>";
      echo "<div class='center' id='tabsbody'>";
      echo "<table class='tab_cadre_fixe'>";
      echo "<tr><th colspan='4'>" . __('Acesso Wallboards') . "</th></tr>";
      echo "<td >" . __('Clique no link :') . "</td>";
      echo "<td colspan='4' class='center'>";
      echo "<a href='". WALLBOARDS_ROOT ."/front/index.php' target='_blank'>".__('Acesse aqui')."</a>";
      echo "</td></tr>";
      echo "</table></div>";
      Html::closeForm();
   }
}
