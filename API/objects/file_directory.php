<?php
class FileDirectory {
    private $dir;

    public function __construct($path) {
        $this->dir = $path;
    }

    function getFiles() {
        $files = scandir($this->dir);

        return $files;
    }
}
?>