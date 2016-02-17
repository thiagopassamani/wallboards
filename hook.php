<?php

function plugin_wallboards_install(){
	
	global $DB;

	/* Criando as tabelas necessárias para o plugin wallboards */
	$query_c_wallboards  = "CREATE TABLE IF NOT EXISTS `glpi_plugin_wallboards` (
							`id` INT(11) NOT NULL auto_increment, 
							`plugin_name` VARCHAR(20) NOT NULL, 
							`plugin_description` TEXT NOT NULL, 
							`plugin_version` CHAR(10) NOT NULL, 
							`plugin_language` VARCHAR(5) NOT NULL, 
							`plugin_dev` VARCHAR(50) NOT NULL, 
							`plugin_url` VARCHAR(120) NOT NULL, 
							`plugin_install` DATETIME NOT NULL, 
							PRIMARY KEY (`id`)
						) COLLATE='utf8_unicode_ci' ENGINE=InnoDB; ";

	$query_c_wallboards_status  = "CREATE TABLE IF NOT EXISTS `glpi_plugin_wallboards_ticket_status` ( 
									`status` INT(11) NOT NULL, 
									`name` VARCHAR(50) NOT NULL, 
									`status_on_ticket` VARCHAR(50) NOT NULL, 
									`order` INT(11) NOT NULL,
									PRIMARY KEY (`status`)
								) COLLATE='utf8_unicode_ci' ENGINE=InnoDB; ";

	/* Insere as informações do plugin */
	$query_i_wallboards = "INSERT IGNORE INTO `glpi_plugin_wallboards` (`id`, `plugin_name`, `plugin_description`, `plugin_version`, `plugin_language`, `plugin_dev`, `plugin_url`, `plugin_install`) 
	VALUES (0, 'wallboards', 'Plugin desenvolvido para visualizar informações do GLPI em uma dashboard na TV.', '0.2.0', 'pt-BR', 'Thiago Passamani', 'http://www.thiagopassamani.com.br', NOW() ); ";
	
	$query_i_wallboards_status = " INSERT IGNORE INTO `glpi_plugin_wallboards_ticket_status` (`status`, `name`, `status_on_ticket`, `order`) 
	VALUES  (1, 'Novo', 'INCOMING', 1), 
		  	(2, 'Proc.(Atribuido)', 'ASSIGNED', 2), 
			(3, 'Proc.(Planejado)', 'PLAN', 3), 
			(4, 'Pendente', 'WAITING', 6), 
			(5, 'Solucionado', 'SOLVED', 8), 
			(6, 'Fechado', 'CLOSED', 9), 
			(7, 'Aceito', 'ACCEPTED', 10), 
			(8, 'Observado', 'OBSERVED', 11), 
			(9, 'Avaliação', 'EVALUATION', 12), 
			(10, 'Aprovado', 'APPROVAL', 13), 
			(11, 'Teste', 'TEST', 14), 
			(12, 'Qualificação', 'QUALIFICATION', 15), 
			(13, 'Aguardando Feedback', 'FEEDBACK', 5), 
			(14, 'Lista de Espera', 'WAITING_LIST', 7), 
			(15, 'Em Atendimento', 'IN_ATTENDANCE', 4); ";

	// Criando as Views
	$query_c_view_wallboards_last_tickets =  "CREATE OR REPLACE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW glpi_plugin_wallboards_view_last_tickets AS
	SELECT `gt`.`id`, `gt`.`name`, `gp`.`name` AS `ticketstatusname`
	FROM  `glpi_tickets` AS `gt`
	INNER JOIN `glpi_plugin_wallboards_ticket_status` AS `gp` ON(`gt`.`status` = `gp`.`status`) 
	WHERE `gt`.`is_deleted` = 0 AND `gt`.`entities_id` = 0 
	ORDER BY `gt`.`id` DESC 
	LIMIT 0, 10; ";			

	$query_c_view_wallboards_tech = "CREATE OR REPLACE VIEW glpi_plugin_wallboards_view_tech AS
	SELECT COUNT(gt.id) AS 'techqtd', CONCAT(gu.firstname, ' ',  gu.realname) AS 'techname' 
	FROM glpi_tickets AS gt 
	INNER JOIN glpi_tickets_users AS gtu ON(gtu.tickets_id = gt.id) 
	INNER JOIN glpi_users AS gu ON(gu.id = gtu.users_id) 
	WHERE gt.is_deleted = 0
	AND gt.date >= (NOW() - INTERVAL 90 DAY) 
	AND gtu.type = 2 
	AND gu.is_active = 1 AND gu.is_deleted = 0 
	-- AND MONTH(gt.date) = MONTH(NOW())  
	-- AND YEAR(gt.date) = YEAR(NOW())
	GROUP BY gu.id 
	ORDER BY techqtd DESC; ";

	$query_c_view_wallboards_news_tickets = "CREATE OR REPLACE VIEW glpi_plugin_wallboards_view_news_tickets AS
	SELECT COUNT(gt.id) AS 'news'
	FROM glpi_tickets AS gt
	WHERE gt.status = 1
	AND gt.is_deleted = 0; ";

	$query_c_view_wallboards_global_tickets =  "CREATE OR REPLACE VIEW glpi_plugin_wallboards_view_global_tickets AS
	(SELECT	gpdts.name,
		( SELECT COUNT(gt.id)
			FROM glpi_tickets AS gt
			WHERE gt.status = gpdts.status
		) AS 'qtd',
		gpdts.order 'order_status',
		gpdts.status_on_ticket
	FROM glpi_plugin_wallboards_ticket_status AS gpdts
	WHERE gpdts.order < 10
	ORDER BY gpdts.order ASC )
	UNION	
	( SELECT 'Excluidos', COUNT(gte.id) AS 'qtd', '99', 'deleted'
	FROM glpi_tickets AS gte
	WHERE gte.is_deleted = 1 )	
	ORDER BY order_status ASC; ";

	$query_c_view_wallboards_now_tickets =  "CREATE OR REPLACE VIEW glpi_plugin_wallboards_view_now_tickets AS
	SELECT COUNT(gt.id) AS 'now',
	(
		SELECT COUNT(gt.id)
			FROM glpi_tickets AS gt
			WHERE gt.is_deleted = 1
			AND DATE_FORMAT(gt.date,'%Y-%m-%d') = DATE_FORMAT(NOW(),'%Y-%m-%d')
	)	AS 'deleted'
	FROM glpi_tickets AS gt
	WHERE gt.is_deleted = 0
	AND DATE_FORMAT(gt.date,'%Y-%m-%d') = DATE_FORMAT(NOW(),'%Y-%m-%d'); ";

	$query_c_view_wallboards_analytics = "CREATE OR REPLACE VIEW glpi_plugin_wallboards_view_analytics AS
	SELECT COUNT(gt.id) AS 'News'

	,(SELECT COUNT(gt1.id)
		FROM glpi_tickets AS gt1
		WHERE gt1.is_deleted = 0		
		AND gt1.status IN(2,3,13,15)
	) AS 'In_Progress'
	
	,(SELECT COUNT(gt2.id)
		FROM glpi_tickets AS gt2
		WHERE gt2.is_deleted = 0
		AND gt2.status IN(4,14)
	) AS 'Waiting'
	
	,(SELECT COUNT(gt3.id)
		FROM glpi_tickets AS gt3
		WHERE gt3.is_deleted = 0
		AND (MONTH(gt3.date) AND YEAR(gt3.date))
		AND (MONTH(gt3.solvedate) = MONTH(NOW()) AND YEAR(gt3.solvedate) = YEAR(NOW()))		
		AND gt3.status = 5
	) AS 'Solved'
	
	,(SELECT COUNT(gt4.id)
		FROM glpi_tickets AS gt4
		WHERE gt4.is_deleted = 0
		AND (MONTH(gt4.closedate) = MONTH(NOW()) AND YEAR(gt4.closedate) = YEAR(NOW()))
		AND gt4.status = 6
	) AS 'Closed'

	FROM glpi_tickets AS gt
		
	WHERE gt.is_deleted = 0
	AND (MONTH(gt.date) = MONTH(NOW()) AND YEAR(gt.date) = YEAR(NOW()))
	AND gt.status = 1; ";

	if ( TableExists("glpi_plugin_wallboards") )
	{		
		$tables = array ( "glpi_plugin_wallboards",
						  "glpi_plugin_wallboards_ticket_status",
						  "glpi_plugin_wallboards_view_tech",
						  "glpi_plugin_wallboards_view_last_tickets",
						  "glpi_plugin_wallboards_view_news_tickets",
						  "glpi_plugin_wallboards_view_global_tickets",
						  "glpi_plugin_wallboards_view_now_tickets",
						  "glpi_plugin_wallboards_view_analytics" );

		foreach ($tables as $table)
   		{
   			// Exclui as tabelas e views
   			$query_dropOrDie = "DROP TABLE IF EXISTS  $table";
      		$DB->queryOrDie( $query_dropOrDie, 'Error droping table on MySQL.' );
   		}        
    }
    else
    {
    	$var_querys =  array ( $query_c_wallboards,
    						   $query_i_wallboards,
    						   $query_c_wallboards_status,
    						   $query_i_wallboards_status,
    						   $query_c_view_wallboards_tech,
    						   $query_c_view_wallboards_last_tickets,
    						   $query_c_view_wallboards_news_tickets,
    						   $query_c_view_wallboards_global_tickets,
    						   $query_c_view_wallboards_now_tickets,
    						   $query_c_view_wallboards_analytics );

		foreach ($var_querys as $var_query)
   		{
   			// Executa as query e adiciona as tabelas e views
   			$DB->queryOrDie( $var_query, 'Error creating $var_table on MySQL.' );
   		} 
    }
    
	return true;
}

function plugin_wallboards_uninstall()
{
	global $DB;

	$tables = array ( "glpi_plugin_wallboards", 
					  "glpi_plugin_wallboards_ticket_status",
					  "glpi_plugin_wallboards_view_tech",
					  "glpi_plugin_wallboards_view_last_tickets",
					  "glpi_plugin_wallboards_view_news_tickets",
					  "glpi_plugin_wallboards_view_global_tickets",
					  "glpi_plugin_wallboards_view_now_tickets",
					  "glpi_plugin_wallboards_view_analytics" );

	if ( TableExists("glpi_plugin_wallboards") )
	{
		foreach ($tables as $table)
   		{
   			$query_dropOrDie = "DROP TABLE IF EXISTS  $table";
      		$DB->queryOrDie( $query_dropOrDie, 'Error creating table $table on MySQL.' );
   		}        
    }
	
	return true;
}

?>