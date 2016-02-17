<?php
/*
 * @version $Id$
 -------------------------------------------------------------------------
 GLPI - Gestionnaire Libre de Parc Informatique
 Copyright (C) 2003-2011 by the INDEPNET Development Team.
 http://indepnet.net/   http://glpi-project.org
 -------------------------------------------------------------------------
 LICENSE
 This file is part of GLPI.
 GLPI is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.
 GLPI is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.
 You should have received a copy of the GNU General Public License
 along with GLPI. If not, see <http://www.gnu.org/licenses/>.
 --------------------------------------------------------------------------
 */
class PluginWallboardsConfig extends CommonDBTM {

  // static protected $notable = true;

   static function getMenuName()
   {
      return __('Wallboards', 'wallboards');
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

   /*function getTabNameForItem(CommonGLPI $item, $withtemplate=0) {
      if (!$withtemplate) {
         if ($item->getType() == 'Config') {
            return __('Wallboards Example plugin');
         }
      }
      return '';
   }*/

   static function configUpdate($input) {
      $input['configuration'] = 1 - $input['configuration'];
      return $input;
   }
   
   function showFormWallboards() {
      global $CFG_GLPI;
      if (!Session::haveRight("config", UPDATE)) {
         return false;
      }
      $my_config = Config::getConfigurationValues('plugin:Wallboards');
      echo "<form name='form' action=\"".Toolbox::getItemTypeFormURL('Config')."\" method='post'>";
      echo "<div class='center' id='tabsbody'>";
      echo "<table class='tab_cadre_fixe'>";
      echo "<tr><th colspan='4'>" . __('Example setup') . "</th></tr>";
      echo "<td >" . __('My boolean choice :') . "</td>";
      echo "<td colspan='3'>";
      echo "<input type='hidden' name='config_class' value='".__CLASS__."'>";
      echo "<input type='hidden' name='config_context' value='plugin:Wallboards'>";
      Dropdown::showYesNo("configuration", $my_config['configuration']);
      echo "</td></tr>";
      /*

      */
      echo "<td >" . __('Hora do Café (Easter Egg), exibir:') . "</td>";
      echo "<td>";
      Dropdown::showYesNo("configuration", $my_config['configuration']);
      echo '<td>Se hora do café definida como SIM, digite qual será há hora: </td>';
	  echo '<td><input type="text" id="easter-egg-cafe" placeholder="15:00" /></td>';
      echo "</td></tr>";

      echo "<tr class='tab_bg_2'>";
      echo "<td colspan='4' class='center'>";
      echo "<input type='submit' name='update' class='submit' value=\""._sx('button','Save')."\">";
      echo "</td></tr>";      
      echo "</table></div>";
/*
echo '<div class="center"><br><table class="tab_cadre_fixehov">';

echo '<tr><th colspan="4">Wallboards for GLPI - Configuração</th></tr>';
echo '<tr class="tab_bg_2">';
echo '<td>Entidade: </td>';
echo '<td><select>';
echo '<option value="0" selected="">Entidade (Raiz)</option>';
echo '<option value="1">Entidade Filha (1)</option>';
echo '</select></td>';
echo '</tr>';

echo '<tr class="tab_bg_2">';
echo '<td>Hora do Café (Easter Egg), exibir: </td>';
echo '<td><select>';
echo '<option value="0" selected="">Não</option>';
echo '<option value="1">Sim</option>';
echo '</select></td>';
echo '<td>Se hora do café definida como SIM, digite qual será há hora: </td>';
echo '<td><input type="text" id="easter-egg-cafe" placeholder="15:00" /></td>';
echo '</tr>';

echo '<tr><th colspan="4">Aviso sonoro (GLPI INFORMA)</th></tr>';
echo '<tr>';
echo '<td colspan="3">O plugin wallboards utiliza o link para a API Google Translate [ <strong>http://translate.google.com</strong> ], para converter texto em voz e caso o site não esteja liberado, o aviso sonoro não funcionará. Se o botão estiver verde o site está liberado, caso contrário, será necessário liberar.</td>';
echo '<td>'; ping('translate.google.com', 80, 10); echo '</td>';
echo '</tr><tr>';
echo '<td colspan="3">Selecione o idioma utilizado para traduzir texto em voz (aviso sonoro), que será emitido pelo <strong>GLPI INFORMA</strong>:</td>';
echo '<td><select>';
echo '<option value="pt-BR" selected>Português (Brasil)</option>';
echo '<option value="en_GB">Inglês (Britânico)</option>';
echo '<option value="en_US">Inglês (Americano)</option>';
echo '<option value="fr_FR">Francês</option>';
echo '</select></td>';
echo '</tr>';

// Botão para salvar
echo '<tr><td colspan="4" class="center"><input type="submit" name="update" class="submit" value="Salvar"></td></tr>';

echo "</table></div>";

Html::footer();
*/



      Html::closeForm();
   }
   static function displayTabContentForItem(CommonGLPI $item, $tabnum=1, $withtemplate=0) {
      if ($item->getType() == 'Config') {
         $config = new self();
         $config->showFormWallboards();
      }
   }
}
?>