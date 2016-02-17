$(function(){
    //DOM Ready
    $(".gridster ul").gridster({
        widget_margins: [4, 4], /* 3, 3 */
        widget_base_dimensions: [270, 330], /* [250, 315] */
        max_cols: 5,
        max_rows: 2
    });

	/* Gráfico atendimento (Carteira de Atendimento) */
    $('#graphStatus').highcharts({
    	chart: {
    		backgroundColor:'rgba(255, 255, 255, 0.1)'
    	},
        title: {
            text: 'Gráfico'
        },
        xAxis: {
            categories: ['Mêses Anteriores', 'Registrados no Mês', 'Fechados no Mês', 'Em atendimento' ]
        },
        labels: {
            items: [{
                html: 'Total de Chamados',
                style: {
                    left: '10px',
                    top: '18px',
                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'black'
                }
            }]
        },
        series: [{
            type: 'column',
            name: 'Jane',
            data: [3, 2, 1, 4]
        }, {
            type: 'column',
            name: 'John',
            data: [2, 3, 5, 6]
        }, {
            type: 'column',
            name: 'Joe',
            data: [4, 3, 3, 9]
        }, {
            type: 'spline',
            name: 'Média',
            data: [3, 2.67, 3, 6.33],
            marker: {
                lineWidth: 2,
                lineColor: Highcharts.getOptions().colors[3],
                fillColor: 'white',
            }
        }, {
            type: 'pie',
            name: 'Total consumption',
            data: [{
                name: 'Jane',
                y: 13,
                color: Highcharts.getOptions().colors[0] // Jane's color
            }, {
                name: 'John',
                y: 23,
                color: Highcharts.getOptions().colors[1] // John's color
            }, {
                name: 'Joe',
                y: 19,
                color: Highcharts.getOptions().colors[2] // Joe's color
            }],
            center: [50, 50],
            size: 50,
            showInLegend: false,
            dataLabels: {
                enabled: false
            }
        }]
    });
	/* Gráfico por Técnicos */
	$('#graphTecn').highcharts({
        chart: {
            type: 'bar',
            backgroundColor:'rgba(255, 255, 255, 0.1)'
        },
        title: {
            text: 'Chamados por Técnico'
        },
        subtitle: {
            text: 'Mês (Janeiro)'
        },
        xAxis: {
            categories: ['João', 'José', 'Joel', 'Jonas', 'James', 'Daniel', 'Tiago', 'Pedro', 'Lucas'],
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
        series: [{
            name: '2015',
            data: [973, 914, 947, 408, 6, 457, 454, 732, 34]
        }]
    });
});