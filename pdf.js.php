<?php
class PDFJs {
    private $workerSrc;

    public function __construct() {
        $this->workerSrc = '';
    }

    public function setWorkerSrc($workerSrc) {
        $this->workerSrc = $workerSrc;
    }

    public function getDocument($data) {
        return new PDFDocument($data);
    }
}

class PDFDocument {
    private $data;
    private $numPages;

    public function __construct($data) {
        $this->data = $data;
        // Assume there are 5 pages in the document
        $this->numPages = 5;
    }

    public function getNumPages() {
        return $this->numPages;
    }

    public function getPage($pageNum) {
        return new PDFPage();
    }
}

class PDFPage {
    private $textContent;

    public function __construct() {
        // Assume some text content for demonstration
        $this->textContent = array(
            'items' => array(
                array('str' => 'This is page text.'),
                array('str' => 'Another line of text.'),
                // You can add more lines as needed.
            )
        );
    }

    public function getTextContent() {
        return $this->textContent;
    }
}
?>
