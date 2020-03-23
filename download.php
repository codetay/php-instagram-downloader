<?php

if (isset($_REQUEST['download'])) {
    $download = json_decode(base64_decode($_REQUEST['download']));
    $fileName = trim(preg_replace(['/[\x00-\x1F\x7F-\xFF]/', '/[^a-zA-Z0-9]/', '/\s+/'], ['', ' ', ' '], $download->title));
    $fileName .= $download->type;
        
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $fileName . '"');
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    //header('Content-Length: ' . filesize($filepath));
    echo file_get_contents($download->downloadLink);
    flush(); // Flush system output buffer
    ob_end_flush();
}
