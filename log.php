<?php
class Log {
    // Dateihandle
    private $handle;

    // Konstruktor
    public function __construct($filename) {
        $this->handle = fopen($filename, 'a');
    }
    // Schreibt eine Nachricht in die Logdatei
    public function write($message) {
        fwrite($this->handle, date('Y-m-d G:i:s') . ' - '. print_r( $message,true) . "\n");
    }
    // Destruktor
    public function __destruct() {
        fclose($this->handle);
    }
}