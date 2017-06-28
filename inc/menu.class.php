<?php 

class PluginWallboardsMenu extends CommonDBTM
{
   	static protected $notable = true;
   
   	static function getMenuName()
   	{
		return __('Wallboards TV', 'wallboards');
   	}
   
   	static function getMenuContent()
   	{
    	$menu = array();

		$menu['title']   = self::getMenuName();
		$menu['page']    = '/plugins/wallboards/front/index.php';

    	return $menu;    	
   }
}