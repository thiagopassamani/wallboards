<?php

header('Content-Type: application/javascript');

include_once("../../../../inc/includes.php");
include_once("../../../../config/config.php");
include_once("../../../../config/config_db.php");

global $DB;

$DayInitial = 01;
$DataIni = date("Y-m-$DayInitial H:i:s");

//$query 	= "SET @Ini = CAST('' AS DATETIME); ";
$query = "SELECT COUNT(`gt`.`id`) AS 'Ch_Mes_Corrente',
  (
    SELECT COUNT(`gt1`.`id`)
      FROM `glpi_tickets` AS `gt1`
      WHERE `gt1`.`entities_id` = 0 AND `gt1`.`is_deleted` = 0
      AND `gt1`.`date` < CAST('$DataIni' AS DATETIME)
      AND ( (MONTH(`gt1`.`solvedate`) = MONTH(NOW())) AND (YEAR(`gt1`.`solvedate`) = YEAR(NOW())) OR
          (MONTH(`gt1`.`closedate`) = MONTH(NOW())) AND (YEAR(`gt1`.`closedate`) = YEAR(NOW())) OR
          (`gt1`.`status` NOT IN(5,6)) )
  ) AS 'Ch_Meses_Antiores', 
  (
  SELECT COUNT(`gt2`.`id`)
      FROM `glpi_tickets` AS `gt2`
      WHERE `gt2`.`entities_id` = 0 AND `gt2`.`is_deleted` = 0
      AND `gt2`.`status` NOT IN(4,5,6,14)   
  ) AS 'Ch_Em_Andamento',
  (
    SELECT COUNT(`gt3`.`id`)
      FROM `glpi_tickets` AS `gt3`
      WHERE `gt3`.`entities_id` = 0 AND `gt3`.`is_deleted` = 0
      AND `gt3`.`status` IN(4,14)   
  ) AS 'Ch_Pendetes',
  
  (
    SELECT COUNT(`gt4`.`id`)
      FROM `glpi_tickets` AS `gt4`
      WHERE `gt4`.`entities_id` = 0 AND `gt4`.`is_deleted` = 0
      AND MONTH(`gt4`.`solvedate`) = MONTH(NOW()) 
      AND YEAR(`gt4`.`solvedate`) = YEAR(NOW()) 
      AND `gt4`.`status` = 5
  ) AS 'Ch_Solucionados',
  
  (
    SELECT COUNT(`gt5`.`id`)
      FROM `glpi_tickets` AS `gt5`
      WHERE `gt5`.`entities_id` = 0 AND `gt5`.`is_deleted` = 0
      AND MONTH(`gt5`.`closedate`) = MONTH(NOW()) 
      AND YEAR(`gt5`.`closedate`) = YEAR(NOW())
      AND `gt5`.`status` = 6
  ) AS 'Ch_Fechados'  
          
  
  FROM `glpi_tickets` AS `gt`
  WHERE `gt`.`entities_id` = 0 AND `gt`.`is_deleted` = 0
  AND ((MONTH(`gt`.`date`) = MONTH(NOW())) AND (YEAR(`gt`.`date`) = YEAR(NOW()))) ";

$result = $DB->query($query);
$dados 	= $DB->fetch_assoc($result);

$anteriores 	= $dados['Ch_Mes_Corrente']; 
$novos 			  = $dados['Ch_Meses_Antiores']; 
$andamento 		= $dados['Ch_Em_Andamento'];
$pendentes 		= $dados['Ch_Pendetes'];
$solucionados = $dados['Ch_Solucionados'];
$fechados 		= $dados['Ch_Fechados'];

/* Soma */
$demanda 	 = $anteriores + $novos;
$atendimento = $andamento + $pendentes;
$resolvidos  = $solucionados + $fechados;

?>

/***********************
* Adobe Edge Animate Composition Actions
*
* Edit this file with caution, being careful to preserve 
* function signatures and comments starting with 'Edge' to maintain the 
* ability to interact with these actions from within Adobe Edge Animate
*
***********************/
(function($, Edge, compId){
var Composition = Edge.Composition, Symbol = Edge.Symbol; // aliases for commonly used Edge classes

   //Edge symbol: 'stage'
   (function(symbolName) {
      
      
      Symbol.bindElementAction(compId, symbolName, "document", "compositionReady", function(sym, e) {

// VARIABLES SETUP ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// Thiago Passamani
var elements = [ 

<?php 
echo " {instance:'box1', numbers:[". $demanda .", ". $anteriores.", ".$novos."],  numberColors:['#61df1b', '#0ea800'], numberTexts:['',''], donutColors:['#61df1b','#61df1b'], donut2ndColors:['#0ea800','#0ea800'], text:'Demanda', textColor:'#fff', legendTitles: ['Anteriores','Novos']}, ";
echo " {instance:'box2', numbers:[". $atendimento .", ". $andamento.", ".$pendentes."],    numberColors:['#49dbe8','#3081b9'],  numberTexts:['',''], donutColors:['#49dbe8','#49dbe8'], donut2ndColors:['#3081b9','#3081b9'], text:'Atendimento', textColor:'#fff', legendTitles: ['Andamento','Pendente']}, ";
echo " {instance:'box3', numbers:[". $resolvidos .", ". $solucionados.", ".$fechados."],  numberColors:['#FA8072', '#FF0000'], numberTexts:['',''], donutColors:['#FA8072','#FA8072'], donut2ndColors:['#FF0000','#FF0000'], text:'Resolvidos',  textColor:'#fff', legendTitles: ['Solucionados','Fechados']}, ";
?>
];

//var legendTitles = ["Desktop","Mobile"]; // Thiago Passamani

var chartDiameter = 80;
var chartRotate = 0; /* degrees: -360 to 360. */

var donutStrokeLinecap = "butt"; /* butt | round */
var donutStroke = 8;
var donutStrokeBigger = 20;
var fullDonutStroke = 20;
var fullDonutColor = "#f1f1f1";

var circlePortion = 70; /* percents: 0 to 100. */

var numberTextSize = 100; /* percents: 0 to 100. */
var numberTextOpacity = 1; /* 0 to 1. */
var makeBiggerValueBold = true; /* Highlight bigger value with bold text */

var animationDirection = "CW"; /* CW:clockwise | CCW:counterclockwise */
var animationDuration = "1s";
var animationEasing = "cubic-bezier(0.785, 0.135, 0.15, 0.86)"; /* linear | ease | cubic-bezier(0.785, 0.135, 0.15, 0.86) */

var ruler = false; /* true | false */
var rulerSegments = 24;
var rulerThickness = 20;
var rulerColor = "#fff";
var rulerDashThickness = 1;
var rulerLineCap = "butt"; /* butt | round */
var rulerDashOffset = 0; /* reposition for fine-tuning */
var rulerScaleFactor = 1;
var rulerHideFirstLast = true; /* true | false */
var rulerOpacity = 0.8; /* 0 to 1. */

// VARIABLES SETUP (END) ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// Don't edit the code below unless you know what you're doing

// detect IE
var ua = window.navigator.userAgent;
var msie = ua.indexOf('MSIE ');
var trident = ua.indexOf('Trident/');
var nav_user_agent_ie;
if ((msie > 0) || (trident > 0)) { nav_user_agent_ie = true;}

var embdStyle = "";

anDir = (animationDirection == "CCW" ? "1,0" : "1,1"); /* CW:1,1 | CCW:1,0 */
balanceDir = (animationDirection == "CCW" ? 180 : -180);
balanceDegrees = balanceDir*(circlePortion/100)+90+chartRotate;


boxWidth = parseInt(sym.getSymbol(elements[0].instance).$("svg_container").css("width"));
boxWidthHalf = boxWidth/2;
donutRadius = (chartDiameter*2*boxWidthHalf)/boxWidth;         
donutPath = "M "+boxWidthHalf+", "+boxWidthHalf+" m -"+donutRadius+", 0 a "+donutRadius+","+donutRadius+" 0 "+anDir+" "+donutRadius*2+",0 a "+donutRadius+","+donutRadius+" 0 "+anDir+" -"+donutRadius*2+",0 Z";


/* center-align group of boxes in "Group" */
groupWidth = sym.$("Group").css("width");
sym.$("Group").css({"left":"50%","margin-left":"-"+parseInt(groupWidth)/2+"px"});

var rulers_transforms_ie = "";

if (nav_user_agent_ie) {
    rulers_transforms_ie = " transform='matrix("+rulerScaleFactor+", 0, 0, "+rulerScaleFactor+", "+(boxWidthHalf-rulerScaleFactor*boxWidthHalf)+", "+(boxWidthHalf-rulerScaleFactor*boxWidthHalf)+")' ";
}

// loop ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
for (var i = 0; i < elements.length; i++) {

svg = "<svg version='1.1' id='chart"+i+"' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' x='0px' y='0px' width='"+boxWidth+"' height='"+boxWidth+"px' viewBox='0 0 "+boxWidth+" "+boxWidth+"' enable-background='new 0 0 "+boxWidth+" "+boxWidth+"' xml:space='preserve'>";

svg += "<defs>";
svg += "<linearGradient id='lg"+i+"' x1='0%' y1='0%' x2='100%' y2='100%' spreadMethod='pad'>";
svg += "    <stop offset='0%'   stop-color='"+elements[i].donutColors[0]+"' stop-opacity='1'/>";
svg += "    <stop offset='100%' stop-color='"+elements[i].donutColors[1]+"' stop-opacity='1'/>";
svg += "</linearGradient>";
svg += "<linearGradient id='lg2nd"+i+"' x1='0%' y1='0%' x2='100%' y2='100%' spreadMethod='pad'>";
svg += "    <stop offset='0%'   stop-color='"+elements[i].donut2ndColors[0]+"' stop-opacity='1'/>";
svg += "    <stop offset='100%' stop-color='"+elements[i].donut2ndColors[1]+"' stop-opacity='1'/>";
svg += "</linearGradient>";
svg += "</defs>";

donutStroke1 = elements[i].numbers[1]>elements[i].numbers[2] ? donutStrokeBigger : donutStroke;
donutStroke2 = elements[i].numbers[1]>elements[i].numbers[2] ? donutStroke : donutStrokeBigger;

if (typeof makeBiggerValueBold === 'undefined' || makeBiggerValueBold == false) {
    fontWeight1 = 'normal';
    fontWeight2 = 'normal';    
} else {
    fontWeight1 = elements[i].numbers[1]>elements[i].numbers[2] ? 'bold' : 'normal';
    fontWeight2 = elements[i].numbers[1]>elements[i].numbers[2] ? 'normal' : 'bold';
}

direction = (animationDirection == "CCW" ? -1 : 1);
chartRotate2 = 360*circlePortion/100*elements[i].numbers[1]/elements[i].numbers[0]*direction;

var svg_g_ie = "";
var ani_donut2nd_transforms_ie = "";

if (nav_user_agent_ie) {
    svg_g_ie = " transform='rotate("+balanceDegrees+" "+boxWidthHalf+" "+boxWidthHalf+")' ";
    ani_donut2nd_transforms_ie = "transform='rotate("+chartRotate2+" "+boxWidthHalf+" "+boxWidthHalf+")'";
}

svg += "<g class='svg_g' "+svg_g_ie+" >";    
svg += "   <path class='full_donut'   d='"+donutPath+"' stroke-linecap='"+donutStrokeLinecap+"' stroke-width='"+fullDonutStroke+"px' fill='none' stroke='"+fullDonutColor+"' />";
svg += "   <path class='ani_donut'    d='"+donutPath+"' stroke-linecap='"+donutStrokeLinecap+"' stroke-width='"+donutStroke1+"px' fill='none' stroke='url(#lg"+i+")' />";
svg += "   <path class='ani_donut2nd' "+ani_donut2nd_transforms_ie+" d='"+donutPath+"' stroke-linecap='"+donutStrokeLinecap+"' stroke-width='"+donutStroke2+"px' fill='none' stroke='url(#lg2nd"+i+")' />";

if (ruler) {svg += "   <path class='rulers' "+rulers_transforms_ie+" d='"+donutPath+"' fill='none' />";}

svg += "</g>";
svg += "</svg>";
         
  box = sym.getSymbol(elements[i].instance);

  box.$("svg_container").html(svg);
  box.$("number").html("<span class='number' style='font-weight:"+fontWeight1+";'>"+elements[i].numbers[1]+"<span>"+elements[i].numberTexts[0]+"</span></span>");
  box.$("number_2nd").html("<span class='number' style='font-weight:"+fontWeight2+";'>"+elements[i].numbers[2]+"<span>"+elements[i].numberTexts[1]+"</span></span>");
  box.$("text").html(""+elements[i].text+"");

  box.$("number").css({"color":elements[i].numberColors[0]});
  box.$("number_2nd").css({"color":elements[i].numberColors[1]});
  box.$("text").css({"color":elements[i].textColor});

  box.$("legend_title").html(elements[i].legendTitles[0]); // Thiago Passamani
  box.$("legend_title_2nd").html(elements[i].legendTitles[1]); // Thiago Passamani

  box.$("legend_color").css({"background-color":elements[i].numberColors[0]});
  box.$("legend_color_2nd").css({"background-color":elements[i].numberColors[1]});

  if (i==0) {
    var path = document.querySelector('#chart'+i+' path.ani_donut');
    pathLength = path.getTotalLength();
  }

pathLengthTo  = pathLength-pathLength*(elements[i].numbers[1]*circlePortion/elements[i].numbers[0])/100;
pathLengthTo2 = pathLength-pathLength*(elements[i].numbers[2]*circlePortion/elements[i].numbers[0])/100;
////////////chartRotate2 = chartRotate+360*circlePortion/100*elements[i].numbers[1]/elements[i].numbers[0]*direction;
//direction = (animationDirection == "CCW" ? -1 : 1);
//chartRotate2 = 360*circlePortion/100*elements[i].numbers[1]/elements[i].numbers[0]*direction;

embdStyle +="#chart"+i+" .ani_donut {";
embdStyle +="    stroke-dasharray: "+pathLength+" 9999; stroke-dashoffset: "+ (nav_user_agent_ie == true ? pathLengthTo : pathLength) +";";
embdStyle +="}";

embdStyle +="#chart"+i+" .ani_donut2nd {";
embdStyle +="    stroke-dasharray: "+pathLength+" 9999; stroke-dashoffset: "+(nav_user_agent_ie == true ? pathLengthTo2 : pathLength)+";";
if (nav_user_agent_ie != true) {
    embdStyle +="    -webkit-transform:rotate("+chartRotate2+"deg); -webkit-transform-origin:"+boxWidthHalf+"px "+boxWidthHalf+"px;";
    embdStyle +="       -moz-transform:rotate("+chartRotate2+"deg);    -moz-transform-origin:"+boxWidthHalf+"px "+boxWidthHalf+"px;";
    embdStyle +="         -o-transform:rotate("+chartRotate2+"deg);      -o-transform-origin:"+boxWidthHalf+"px "+boxWidthHalf+"px;";
    embdStyle +="            transform:rotate("+chartRotate2+"deg);         transform-origin:"+boxWidthHalf+"px "+boxWidthHalf+"px;";
}
embdStyle +="}";

if (nav_user_agent_ie != true) {
    embdStyle +=".run_animation"+i+" {";
    embdStyle +="    -webkit-animation: ani"+i+" "+animationDuration+" "+animationEasing+" forwards 0.5s;";
    embdStyle +="       -moz-animation: ani"+i+" "+animationDuration+" "+animationEasing+" forwards 0.5s;";
    embdStyle +="         -o-animation: ani"+i+" "+animationDuration+" "+animationEasing+" forwards 0.5s;";
    embdStyle +="            animation: ani"+i+" "+animationDuration+" "+animationEasing+" forwards 0.5s;";
    embdStyle +="}";

    embdStyle +=".run_animation2nd"+i+" {";
    embdStyle +="    -webkit-animation: ani2nd"+i+" "+animationDuration+" "+animationEasing+" forwards 0.5s;";
    embdStyle +="       -moz-animation: ani2nd"+i+" "+animationDuration+" "+animationEasing+" forwards 0.5s;";
    embdStyle +="         -o-animation: ani2nd"+i+" "+animationDuration+" "+animationEasing+" forwards 0.5s;";
    embdStyle +="            animation: ani2nd"+i+" "+animationDuration+" "+animationEasing+" forwards 0.5s;";
    embdStyle +="}";

    embdStyle +="@-webkit-keyframes ani"+i+" {";
    embdStyle +="    from { stroke-dashoffset: "+pathLength+";}";
    embdStyle +="      to { stroke-dashoffset: "+pathLengthTo+";}";
    embdStyle +="}";
    embdStyle +="@-moz-keyframes ani"+i+" {";
    embdStyle +="    from { stroke-dashoffset: "+pathLength+";}";
    embdStyle +="      to { stroke-dashoffset: "+pathLengthTo+";}";
    embdStyle +="}";
    embdStyle +="@-o-keyframes ani"+i+" {";
    embdStyle +="    from { stroke-dashoffset: "+pathLength+";}";
    embdStyle +="      to { stroke-dashoffset: "+pathLengthTo+";}";
    embdStyle +="}";
    embdStyle +="@keyframes ani"+i+" {";
    embdStyle +="    from { stroke-dashoffset: "+pathLength+";}";
    embdStyle +="      to { stroke-dashoffset: "+pathLengthTo+";}";
    embdStyle +="}";

    embdStyle +="@-webkit-keyframes ani2nd"+i+" {";
    embdStyle +="    from { stroke-dashoffset: "+pathLength+";}";
    embdStyle +="      to { stroke-dashoffset: "+pathLengthTo2+";}";
    embdStyle +="}";
    embdStyle +="@-moz-keyframes ani2nd"+i+" {";
    embdStyle +="    from { stroke-dashoffset: "+pathLength+";}";
    embdStyle +="      to { stroke-dashoffset: "+pathLengthTo2+";}";
    embdStyle +="}";
    embdStyle +="@-o-keyframes ani2nd"+i+" {";
    embdStyle +="    from { stroke-dashoffset: "+pathLength+";}";
    embdStyle +="      to { stroke-dashoffset: "+pathLengthTo2+";}";
    embdStyle +="}";
    embdStyle +="@keyframes ani2nd"+i+" {";
    embdStyle +="    from { stroke-dashoffset: "+pathLength+";}";
    embdStyle +="      to { stroke-dashoffset: "+pathLengthTo2+";}";
    embdStyle +="}";

    embdStyle +="#Stage_box"+(i+1)+"_svg_container {";
    embdStyle +="    -webkit-transform:rotate("+balanceDegrees+"deg); -webkit-transform-origin:"+boxWidthHalf+"px "+boxWidthHalf+"px;";
    embdStyle +="       -moz-transform:rotate("+balanceDegrees+"deg);    -moz-transform-origin:"+boxWidthHalf+"px "+boxWidthHalf+"px;";
    embdStyle +="         -o-transform:rotate("+balanceDegrees+"deg);      -o-transform-origin:"+boxWidthHalf+"px "+boxWidthHalf+"px;";
    embdStyle +="            transform:rotate("+balanceDegrees+"deg);         transform-origin:"+boxWidthHalf+"px "+boxWidthHalf+"px;";
    embdStyle +="}";
}

};
// loop END ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------


embdStyle +=".full_donut {";
embdStyle +="    stroke-dasharray: "+pathLength*circlePortion/100+" 9999; stroke-dashoffset: 0;";
embdStyle +="}";

// ruler check
if (ruler) {

    rulerLength = pathLength*circlePortion/100;
    rulerSpace = rulerLength/rulerSegments-rulerDashThickness;
    strk_da = "";

    if (rulerHideFirstLast) {
      strk_da += "0 ";
      strk_da += (rulerSpace+rulerDashThickness/2) + " ";

      for (var d = 0; d < rulerSegments-2; d++) {
        strk_da += rulerDashThickness + " ";
        strk_da += rulerSpace + " ";
      };

    } else {

      for (var d = 0; d < rulerSegments; d++) {
        strk_da += rulerDashThickness + " ";
        strk_da += rulerSpace + " ";
      };
    }

    strk_da += rulerDashThickness + " 9999";

    embdStyle +=".rulers {";
    embdStyle +="    stroke-dasharray: "+strk_da+";";
    embdStyle +="    stroke-dashoffset: "+rulerDashOffset+";";
    embdStyle +="    stroke: "+rulerColor+";";
    embdStyle +="    stroke-linecap: "+rulerLineCap+";";
    embdStyle +="    stroke-width: "+rulerThickness+"px;";
    if (nav_user_agent_ie != true) {
        embdStyle +="    -webkit-transform:scale("+rulerScaleFactor+"); -webkit-transform-origin:"+boxWidthHalf+"px "+boxWidthHalf+"px;";
        embdStyle +="       -moz-transform:scale("+rulerScaleFactor+");    -moz-transform-origin:"+boxWidthHalf+"px "+boxWidthHalf+"px;";
        embdStyle +="         -o-transform:scale("+rulerScaleFactor+");      -o-transform-origin:"+boxWidthHalf+"px "+boxWidthHalf+"px;";
        embdStyle +="            transform:scale("+rulerScaleFactor+");         transform-origin:"+boxWidthHalf+"px "+boxWidthHalf+"px;";
    }
    embdStyle +="    opacity:"+rulerOpacity+";";
    embdStyle +="}";

} // ruler check END

embdStyle +=".number {";
embdStyle +="    margin-left:0;";
embdStyle +="    font-weight:bold;";
embdStyle +="}";
embdStyle +=".number span {";
embdStyle +="    font-size:"+numberTextSize+"%;";
embdStyle +="    opacity:"+numberTextOpacity+";";
embdStyle +="}";

$("<style>"+embdStyle+"</style>").appendTo("head"); 

// run animation for non IE browsers
if (nav_user_agent_ie != true) {
    for (var i = 0; i < elements.length; i++) {
      element = document.querySelector('#chart'+i+' .ani_donut');
      element.classList.add("run_animation"+i);
      element2 = document.querySelector('#chart'+i+' .ani_donut2nd');
      element2.classList.add("run_animation2nd"+i);
    }
}

         

      });
      //Edge binding end

   })("stage");
   //Edge symbol end:'stage'

   //=========================================================
   
   //Edge symbol: 'r'
   (function(symbolName) {   
   
      Symbol.bindSymbolAction(compId, symbolName, "creationComplete", function(sym, e) {
         /* initially hide the element */
         // this.element.css({"opacity":"0"});
         

      });
      //Edge binding end

   })("box");
   //Edge symbol end:'box'

})(jQuery, AdobeEdge, "EDGE-1404005");