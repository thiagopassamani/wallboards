<?php

class PluginWallboardsConfig extends Config {

    static private $_instance = NULL;

    function getName($with_comment=0) {
        return __('Wallboards for GLPI', 'wallboards');
    }

    /**
     * Singleton for the unique config record
     */
    static function getInstance() {

        if (!isset(self::$_instance)) {
            self::$_instance = new self();
            if (!self::$_instance->getFromDB(1)) {
                self::$_instance->getEmpty();
            }
        }
        return self::$_instance;
    }

    static function pingWallboards( $host, $port=80, $timeout=6 )
    {
        $fsock = fsockopen( $host, $port, $errno, $errstr, $timeout );
     
        if ( !$fsock )
        {
            echo '<img src="../plugins/wallboards/pics/off.png" title="Site Bloqueado, favor liberar" />';
        }
        else
        {
            echo '<img src="../plugins/wallboards/pics/on.png" title="Site Liberado" />';
        }
        fclose($fsock);
    }

    static function showConfigForm($item) {
        global $DB;

        $config = self::getInstance();

        $config->showFormHeader();

        echo "<tr class='tab_bg_1'>";
        echo "<td colspan=2>".__('Google Informa - Aviso sonoro')."&nbsp;:</td><td colspan=2>";
        Dropdown::showYesNo("google_voice",$config->fields["google_voice"]);
        echo "</td></tr>\n";

        if( $config->fields["google_voice"] > 0 )
		{
        	echo "<tr class='tab_bg_1'>";
        	echo "<td colspan='2'><strong>". __('Aviso sonoro: ') ."</strong><br/> O plugin utiliza a API Google Translate [ <strong>http://translate.google.com</strong> ], para converter texto em voz e caso o site não esteja liberado, o aviso sonoro não funcionará. Se o botão estiver verde o site está liberado, caso contrário, será necessário liberar.</td>";
        	echo "<td>"; PluginWallboardsConfig::pingWallboards("translate.google.com", 80, 10); echo "</td>";
        }   

        echo "<tr class='tab_bg_1'>";
        echo "<td colspan=2>". __('Meta') ."&nbsp;:</td><td colspan=2>";
        echo "<input type='text' name='kpi_meta' value='".$config->fields['kpi_meta']."' placeholder='90'>%" ;
        echo "</td></tr>\n";

        echo "<tr class='tab_bg_1'>";
        echo "<td colspan=2>".__('Tempo de atualização')."&nbsp;:</td><td colspan=2>";
        echo "<input type='text' name='time_update' value='".$config->fields['time_update']."'> segundos" ;
        echo "</td></tr>\n";

        echo "<tr class='tab_bg_1'>";
        echo "<td colspan=2>".__('Exibir quantos dias?')."&nbsp;:</td><td colspan=2>";
        echo "<input type='text' name='show_day' value='".$config->fields['show_day']."'>  dias" ;
        echo "</td></tr>\n";

        echo "<tr class='tab_bg_1'>";
        echo "<td colspan=2>".__('Comentario')."&nbsp;:";
        echo "</td><td colspan=2 class='center'>";
        echo "<textarea cols='60' rows='5' name='comment' >".$config->fields['comment']."</textarea>";
        echo "</td></tr>\n";

        echo "<tr class='tab_bg_1'>";
        echo "<td colspan=2>".__('Última modificação')."&nbsp;: </td><td colspan=2>";
        echo Html::convDateTime($config->fields["date_mod"]);
        echo "</td></tr>\n";

        $config->showFormButtons(array('candel'=>false));

        return false;
    }


    function getTabNameForItem(CommonGLPI $item, $withtemplate=0) {
        global $LANG;

        if ($item->getType()=='Config') {
           return __('Wallboards for GLPI', 'wallboards');
        }
        return '';
    }


    static function displayTabContentForItem(CommonGLPI $item, $tabnum=1, $withtemplate=0) {

        if ($item->getType()=='Config') {
            self::showConfigForm($item);
        }
        return true;
    }

    function prepareInputForUpdate($input){
       return $input ;
    }

}
