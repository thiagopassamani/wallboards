<?php

class PluginWallboardsConfig extends CommonDBTM
{

  	// static protected $notable = true;

	static function getMenuName()
   	{
      	return __('Wallboards', 'wallboards');
   	}
   
   	static function getMenuContent()
   	{
   		//global $CFG_GLPI, $LANG;
   
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

   	static function configUpdate($input)
   	{
      	$input['configuration'] = 1 - $input['configuration'];
      	$input['language'] = 1 - $input['language'];

      	return $input;
   	}

   	static function pingWallboards( $host, $port=80, $timeout=6 )
	{
    	$fsock = fsockopen( $host, $port, $errno, $errstr, $timeout );
     
    	if ( !$fsock )
    	{
        	echo '<img src="../pics/off.png" title="Site Bloqueado, favor liberar" />';
    	}
    	else
    	{
        	echo '<img src="../pics/on.png" title="Site Liberado" />';
    	}
        fclose($fsock);
	}
   	
   	function showFormWallboards()
   	{
      	global $CFG_GLPI, $DB;
      	
      	if (!Session::haveRight("config", UPDATE))
      	{
        	return false;
      	}

      	$my_config = Config::getConfigurationValues('plugin:wallboards');
      	echo "<form name='form' action=\"".Toolbox::getItemTypeFormURL('Config')."\" method='post'>";
      	echo "<div class='center' id='tabsbody'>";
      	echo "<table class='tab_cadre_fixe'>";
      	echo "<tr><th colspan='4'>" . __('Configuration') . "</th></tr>";
      	echo "<td >" . __('My boolean choice :') . "</td>";
      	echo "<td colspan='3'>";
      	echo "<input type='hidden' name='config_class' value='".__CLASS__."'>";
      	echo "<input type='hidden' name='config_context' value='plugin:Wallboards'>";
      	Dropdown::showYesNo("configuration", $my_config['configuration']);
      	echo "</td></tr>";

      	echo "<tr><th colspan='4'>" . __('Aviso sonoro (GLPI INFORMA)') . "</th></tr>";
      	echo '<td colspan="3">O plugin wallboards utiliza o link para a API Google Translate [ <strong>http://translate.google.com</strong> ], para converter texto em voz e caso o site não esteja liberado, o aviso sonoro não funcionará. Se o botão estiver verde o site está liberado, caso contrário, será necessário liberar.</td>';
		echo '<td>'; PluginWallboardsConfig::pingWallboards("translate.google.com", 80, 10); echo '</td>';
		
		echo '<tr><td>Laguange</td><td>';
		Dropdown::showLanguages("language", array('value' => "pt_BR"));  // Utilizado para emição de voz pelo GLPI
		echo '</td></tr>';

		echo '</tr>';

		echo "<tr><th colspan='4'>" . __('Hora do Café') . "</th></tr>";
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

		Html::closeForm();
   	}
}   	
?>