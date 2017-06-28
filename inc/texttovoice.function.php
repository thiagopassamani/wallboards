<?php 
/***************************************	
* Nova API
* https://cloud.google.com/translate/v2/quickstart#JSONP
* https://console.cloud.google.com/freetrial?_ga=1.254914251.2107440938.1463774890&pli=1 (Conta - Pagamento)
*/

function plugin_wallboards_apigoogle_text_voice( $text_to_voice, $language )
{

  // $language = array('pt-BR', 'en', 'fr');
  $dir_sounds = "../sounds/";

  // API Google Translate (não pode ser > 100 caracteres).
  $text = substr($text_to_voice, 0, 100);
  
  // Substituição caracter alfa-numerico
  // The spaces in the sentence are replaced with the Plus symbol
  $text = urlencode( $text_to_voice );
 
  // Será gerado o arquivo .mp3 com nome hash MD5.
  $file_mp3  = $dir_sounds . md5($text) . ".mp3";
  $file_ogg  = $dir_sounds . md5($text) . ".ogg";
  $file_wav  = $dir_sounds . md5($text) . ".wav";
 
  // Se o arquivo .mp3 existir, não será feita uma nova requisição.
  if ( (!file_exists($file_mp3)) || (!file_exists($file_ogg)) || (!file_exists($file_wav)) )
  {
      $text_sound = file_get_contents( 'http://translate.google.com/translate_tts?ie=UTF-8&q=' . $text . '&tl='. $language );

      file_put_contents($file_mp3, $text_sound);
      file_put_contents($file_ogg, $text_sound);
      file_put_contents($file_wav, $text_sound);
  }

  if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') )
  {
    echo '<!--[if IE]>'. PHP_EOL;
    echo '<embed src="'. $file_mp3 .'" autostart="true" width="0" height="0" type="application/x-mplayer2"></embed>'. PHP_EOL;
    echo '<![endif]-->'. PHP_EOL;
  }
  else
  {
    echo '<audio autoplay style="width:80%;" preload="auto">'. PHP_EOL;
    echo '<source src="'. $file_ogg .'" type="audio/ogg">'. PHP_EOL;
    echo '<source src="'. $file_mp3 .'" type="audio/mpeg">'. PHP_EOL;
    echo '<source src="'. $file_wav .'" type="audio/wav">'. PHP_EOL;
    echo '</audio>';
  }
}
//echo plugin_wallboards_apigoogle_text_voice('Google Api - Texto para Voz', 'pt-BR' );
echo plugin_wallboards_apigoogle_text_voice('GLPI informa: Há um chamado não atribuído', 'pt-BR');
//echo plugin_wallboards_apigoogle_text_voice('GLPI informa: Há 2 chamados não atribuídos', 'pt-BR'); // até 50
//echo plugin_wallboards_apigoogle_text_voice('Test Thiago Passamani', 'en' );
//echo plugin_wallboards_apigoogle_text_voice('Test Thiago Passamani', 'en-us' );
//echo plugin_wallboards_apigoogle_text_voice('Test Thiago Passamani', 'fr' );
?>