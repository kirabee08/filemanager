<?php
class File {
    private $file;

    public function __construct($path) {
        $this->file = $path;
    }

    function getInfo() {
        $stat = stat($this->file);
        $created = filectime($this->file);

        $data = array(
            'size' => $stat['size'],
            'uploadDate' => $created
        );

        return $data;
    }

    function getContent() {
        $content = file($this->file);

        return $content;
    }

    function delete() {
        if (unlink($this->file)) {
            return true;
        } else {
            return false;
        }
    }
}
?>