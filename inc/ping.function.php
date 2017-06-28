<?php
function ping( $host, $port=80, $timeout=6 )
{
    $fsock = fsockopen( $host, $port, $errno, $errstr, $timeout );
     
    if ( !$fsock )
    {
        echo '<img src="pics/off.png" title="Site Bloqueado, favor liberar" />';
    }
    else
    {
        echo '<img src="pics/on.png" title="Site Liberado" />';
    }
}