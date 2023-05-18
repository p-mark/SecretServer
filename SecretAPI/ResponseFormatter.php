<?php
class ResponseFormatter {
    private $acceptHeader;
    
    public function __construct($acceptHeader) {
        $this->acceptHeader = $acceptHeader;
    }
    
    public function formatResponse($response) {
        //Format the response based on the acceptHeader
        switch ($this->acceptHeader) {
            case 'application/xml':
                return xmlrpc_encode($response);
            case 'application/json':
                return json_encode($response);
            // Add cases for other formats here
            default:
                return 'Unsupported format';
        }
    }
}
?>