<?php

header('Content-Type: application/javascript');

if (!defined('GLPI_ROOT')) define('GLPI_ROOT', '../../../..');

include_once (GLPI_ROOT . "/inc/includes.php");
include_once (GLPI_ROOT . "/config/config.php");
include_once (GLPI_ROOT . "/config/config_db.php");
include_once (GLPI_ROOT . "/inc/dbconnection.class.php");

global $DB;

$query_tech = " SELECT * FROM `glpi_plugin_wallboards_view_tech`; ";

$resul_tech = $DB->queryOrDie($query_tech); // Estudar forma de resolver o problema
$resul_tech1 = $DB->queryOrDie($query_tech); // Estudar forma de resolver o problema

if ($DB->numrows($resul_tech) > 0)
{
	echo "/**
* @author thiagopassamani@gmail.com (Thiago Passamani)
*/

$(function(){
  $('#graphTech').highcharts({
        chart: {
            type: 'bar',
            backgroundColor:'rgba(255, 255, 255, 0.1)'
        },
        title: {
            text: 'Chamados por Técnico'
        },
        subtitle: {
            text: 'Últimos 90 dias'
        },
        xAxis: {
            categories: [";

			while ($tech1 = $DB->fetch_array($resul_tech1))
    		{  
                echo "'".$tech1[1]."', ";
         	}

echo    "],

        title: {
                text: null
            }
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -10,
            y: -5,
            floating: true,
            backgroundColor:'rgba(255, 255, 255, 0.1)',
            shadow: false
        },
        credits: {
            enabled: false
        },
        series: [ ";         
   
    	echo "{ name: '". date('Y'). "', ";

    	echo "data: [ "; 
    	
    	while ($tech = $DB->fetch_array($resul_tech))
    	{  
	        echo $tech[0].", ";   
	    }

    echo "] }";
echo "  ]
    }); ";
}

// Seleciona os últimos chamados registrados em ordem decrescente.
$query_analytics  = " SELECT * FROM `glpi_plugin_wallboards_view_analytics`; ";

$resul_analytics = $DB->query( $query_analytics );

if ($DB->numrows($resul_analytics) > 0)
{
echo "
    $('#graphAnalytics').highcharts({
        chart: {
            type: 'pyramid',
            marginRight: 100,
            backgroundColor:'rgba(255, 255, 255, 0.1)'
        },
        title: {
            text: 'Analytics',
            x: -50
        },
        plotOptions: {
            series: {
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b> ({point.y:,.0f})',
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black',
                    softConnector: true
                }
            }
        },
        legend: {
            enabled: false
        },
        series: [{
            name: 'Tickets',
            data: [";
            while ($analytics = $DB->fetch_array($resul_analytics))
            {  
                echo "['Fechados',".        $analytics[4] . "],\n"; // Closed 
                echo "['Solucionados',".    $analytics[3] . "],\n"; // Solved
                echo "['Pendentes',".       $analytics[2] . "],\n"; // Waiting
                echo "['Em atendimento',".  $analytics[1] . "],\n"; // In Progress
                echo "['Novos',".           $analytics[0] . "]"; // News               
            }
            echo "]
        }]
    });
});" ;
}