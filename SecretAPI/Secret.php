<?php
class Secret {
    private $properties;
    
    public function __construct($hash, $secretText, $createdAt, $expiresAt, $remainingViews) {
        $this->properties = [
            'hash' => $hash,
            'secretText' => $secretText,
            'createdAt' => $createdAt,
            'expiresAt' => $expiresAt,
            'remainingViews' => $remainingViews
        ];
    }
    
    public function getProperty($name) {return $this->properties[$name] ?? null;}
    
    public function getProperties() {return $this->properties ?? null;}
}
?>