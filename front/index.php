<?php

if (!defined('GLPI_ROOT')) define('GLPI_ROOT', '../../..');
if (!defined('WALLBOARDS_ROOT')) define('WALLBOARDS_ROOT', '..');

include_once (GLPI_ROOT . "/inc/includes.php");
include_once (GLPI_ROOT . "/config/config.php");
include_once (GLPI_ROOT . "/config/config_db.php");
include_once (GLPI_ROOT . "/inc/dbconnection.class.php");
//include_once (WALLBOARDS_VERSION . "/inc/texttovoice.function.php");

// Tempo para atualização da página (Config.php)
// Cria um HOOK na index.php principal com um botão para o DashTI
?>
<!DOCTYPE html>
<html lang="pt_BR"> 
<head>
<title><?php echo __('Wallboards for GLPI','wallboards'); ?></title>
<meta charset="utf-8"/>
<meta name="author" content="Thiago Passamani <thiagopassamani@gmail.com>" />
<meta name="description" content="Plugin para GLPI: Wallboards for GLPI">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<link rel="shortcut icon" type="images/x-icon" href="../../../pics/favicon.ico">
<link rel="stylesheet" type="text/css" href="<?php echo WALLBOARDS_ROOT; ?>/lib/css/wallboards.bootstrap.css" />    
<link rel="stylesheet" type="text/css" href="<?php echo WALLBOARDS_ROOT; ?>/lib/css/wallboards.main.css" />
<link rel="stylesheet" type="text/css" href="<?php echo WALLBOARDS_ROOT; ?>/lib/css/wallboards.fonts.css" />
<link rel="stylesheet" type="text/css" href="<?php echo WALLBOARDS_ROOT; ?>/lib/css/jquery.fullPage.css"/>
<script type="text/javascript" src="<?php echo WALLBOARDS_ROOT; ?>/lib/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo WALLBOARDS_ROOT; ?>/lib/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo WALLBOARDS_ROOT; ?>/lib/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo WALLBOARDS_ROOT; ?>/lib/js/jquery.slimscroll.min.js"></script>
<script type="text/javascript" src="<?php echo WALLBOARDS_ROOT; ?>/lib/js/jquery.fullPage.min.js"></script>
<script type="text/javascript" src="<?php echo WALLBOARDS_ROOT; ?>/lib/js/donut_charts_edgePreload.js"></script>
<script type="text/javascript" src="<?php echo WALLBOARDS_ROOT; ?>/lib/js/highcharts.js"></script>
<script type="text/javascript" src="<?php echo WALLBOARDS_ROOT; ?>/lib/js/clock.js"></script>  	
<script type="text/javascript">StartClock('d/m/Y','H:i:s');</script>
<script type="text/javascript">
$(document).ready(function()
{
	var pepe = $.fn.fullpage(
	{
		anchors: ['dash-0', 'dash-1', 'dash-2'],
		scrollingSpeed: 700,
		easing: 'easeInQuart',
		resize : true,
		autoScrolling: true,
		keyboardScrolling: true,
		loopBottom: true,
		sectionSelector: '.dash',
		onLeave: function(index, direction){},
		afterLoad: function(anchorLink, index){},
		afterRender: function()
		{
			setInterval(function()
			{
				$.fn.fullpage.moveSectionDown();
  	 	}, 15000); /* Slide move */	
  	},
  	afterSlideLoad: function(anchorLink, index, slideAnchor, slideIndex){},
  	onSlideLeave: function(anchorLink, index, slideIndex, direction){},
 	});
});	
</script>
<!--[if lt IE 9]><script type="text/javascript" src="<?php echo WALLBOARDS_ROOT; ?>/lib/js/html5.js"></script><![endif]-->
</head>
<body>
  <!-- ------------------------------------------------------------------------------------------------ -->
  <section id="dash0" class="dash dash-0 section container">
   	<div class="row">        	
     	<div id="logo" class="col-sm-3 col-lg-3">
     		<div class="half-unit">
     			<dtitle><?php echo 'Wallboards for GLPI '. WALLBOARDS_VERSION .', GLPI '. $CFG_GLPI["version"]; ?></dtitle>
	      	    <hr>
				<div class="thumbnail">
					<img src="<?php echo WALLBOARDS_ROOT; ?>/pics/wallboards.png" alt="" style="width:64px;height:52px;"/>
					<br/>
					<strong><?php echo __('Wallboards for GLPI','wallboards'); ?></strong>
				</div>					
			</div><!-- LOGO -->
			<div class="half-unit">
				<dtitle><?php echo __('Schedule','wallboards'); ?></dtitle>
				<hr>
				<div class="clockcenter">
				    <digiclock id="clock_tm">Time</digiclock>
		   		    <p><span id="clock_dt">Date</span></p>
                </div>
            </div><!-- HORARIO -->
        </div><!-- /logo -->

	    <div id="analitycs-tickets" class="col-sm-9 col-lg-9">
			<div class="dash-unit graph">
				<dtitle>Termometro de Atendimento Analitico</dtitle>
				<hr>
			 	<div id="Stage" class="EDGE-1404005"></div>
			</div>		
		</div><!-- /analitycs-tickets -->

		<div id="view-global" class="col-sm-3 col-lg-3">
       		<div class="dash-unit">
       			<dtitle>Visão Geral</dtitle>
       			<hr>
            	<ul class="ticket-list" style="list-style:nones">
<?php       
						// Seleciona os últimos chamados registrados em ordem decrescente.
            $query_global  = " SELECT * FROM `glpi_plugin_wallboards_view_global_tickets`; ";

            $resul_global = $DB->query( $query_global );

            if ($DB->numrows($resul_global) > 0)
            {
              while ($global = $DB->fetch_assoc($resul_global))
              {
               	echo '<li>' . $global["name"] . ' '. $global["qtd"] .'</li>';
              }
            }            
            else
            {
            	echo '<li>Sem dados para exibir.</li>';
            }
	?>        </ul>    	
					</div>
        </div><!-- /ticket-list -->

       	<div id="last-tickets" class="col-sm-6 col-lg-6">
       		<div class="dash-unit">
						<dtitle>Satisfação de atendimento (Últimos 60 dias) </dtitle>
		  			<hr>
					</div>
       	</div><!-- /last-tickets -->
         
        <div class="col-sm-3 col-lg-3">

					<div class="half-unit">
	      		<dtitle>Meta de Atendimento Mensal</dtitle>
	      		<hr>
	      		<div class="cont">
<?php
						// Definir no config.php $meta
						$result_meta = "76,82";
						$meta = "90";

						if($result_meta < $meta)
						{
							echo '<bold style="color:red">'.$result_meta.'%</bold>';
						}
						elseif($resulta_meta > $meta)
						{
							echo '<bold style="color:green">'.$result_meta.'%</bold>';
						}
						else
						{
							echo '<bold>Meta não definida</bold>';	
						}
?>
						</div>
					</div>
	     		<div class="half-unit">
      			<dtitle>Último chamado - Verificar</dtitle>
	      		<hr>
	      		<div class="cont">
	      			<p>ID <bold>43000</bold></p>
	      			<p>Registrados hoje 30</p>
	     			</div>
					</div>
				</div>
			</div><!-- /row -->		
    </section><!-- DASH-0 -->

    <!-- ------------------------------------------------------------------------------------------------ -->
    <section id="dash1" class="dash dash-1 section container">
		<div class="row">
			<div class="col-sm-6 col-lg-6">
				<div class="dash-unit dash-unit-full">
					<dtitle>Últimos Chamados (Novo)</dtitle>
		  		<hr/>
          <ul class="ticket-list" style="list-style:none;">
<?php 			
// Seleciona os últimos chamados registrados em ordem decrescente.
$query_list  = " SELECT * FROM `glpi_plugin_wallboards_view_last_tickets` LIMIT 0,10; ";

$resul_list = $DB->query( $query_list );

if ($DB->numrows($resul_list) > 0)
{
	while ($list = $DB->fetch_assoc($resul_list))
	{	
    	echo '<li><bold>' . $list["id"] . '</bold> '. $list["ticketstatusname"] . " - ".$list["name"] . '</li>';
	}
}            
else
{
	echo '<li>Sem dados para exibir.</li>';
}                                
?>          </ul>
				</div>		
			</div>
			<div class="col-sm-3 col-lg-3">
				<div class="dash-unit ">
					<dtitle>Site Bandwidth</dtitle>
		  		<hr />
	        <div id="load"></div>
				</div>		
			</div>
			<div class="col-sm-3 col-lg-3">
				<div class="dash-unit ">
					<dtitle>Site Bandwidth</dtitle>
		  			<hr>
	        		<div id="load"></div>
				</div>		
			</div>
			<div class="col-sm-6 col-lg-6">
				<div class="dash-unit ">
					<dtitle>Site Bandwidth</dtitle>
		  			<hr>
	        		<div id="load"></div>
				</div>		
			</div>
		</div><!-- /row -->
	</section><!-- DASH-1 -->

	<!-- ------------------------------------------------------------------------------------------------ -->
	<section id="dash2" class="dash dash-2 section container">
		<div class="row">

			<div class="col-sm-6 col-lg-6">
				<div class="dash-unit ">
					<dtitle>Site Bandwidth</dtitle>
		  			<hr>
	        		<div id="load"></div>
				</div>		
			</div>

			<div class="col-sm-3 col-lg-3">
				<div class="dash-unit ">
					<dtitle>Site Bandwidth</dtitle>
		  			<hr>
	        		<div id="load"></div>
				</div>		
			</div>

			<div class="col-sm-3 col-lg-3">
				<div class="dash-unit ">
					<dtitle>Site Bandwidth</dtitle>
		  			<hr>
	        		<div id="load"></div>
				</div>		
			</div>

        <div class="col-sm-3 col-lg-3">
      		<div class="half-unit">
      			<dtitle>Último chamado</dtitle>
	      		<hr>
	      		<div class="cont">
	      			<p>ID <bold>43000</bold></p>
	      			<p>Registrados hoje 30</p>
	      		</div>
			</div>
			<div class="half-unit">
				<dtitle>Server Uptime</dtitle>
	      		<hr>
	      		<div class="cont">
					
				</div>
			</div>
	    </div>
		</div><!-- /row-3-->
	</section><!-- DASH-2 -->
  </body>
</html>