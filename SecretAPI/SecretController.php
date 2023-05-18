<?php
require_once 'Secret.php';
require_once 'SecretRepository.php';

class SecretController {
    private $secretRepository;

    public function __construct(SecretRepository $secretRepository) {
        $this->secretRepository = $secretRepository;
    }

    public function addSecret($secretText, $expireAfterViews, $expireAfter) {
        // Generate unique hash
        $hash = $this->generateUniqueHash();
        
        // Create a new Secret object
        $secret = new Secret($hash, $secretText, date('Y-m-d H:i:s'), $this->calculateExpiration($expireAfter), $expireAfterViews);
        
        // Save the secret in the repository
        $this->secretRepository->saveSecret($secret);
        
        // Return the secret properties
        return $secret->getProperties();
    }

    public function getSecretByHash($hash) {
        // Retrieve the secret from the repository
        $secret = $this->secretRepository->getSecretByHash($hash);

        // Validate the access
        if ($this->secretValidator($secret)){
            echo('404 ');
            return null;
        }

        // Decrease remaining views count!
        $this->secretRepository->decreaseRemainingViews($hash);
            
        // Return the secret properties
        return $secret->getProperties();

    }
    
    // Helper functions

    private function generateUniqueHash() {
        return hash('sha256', uniqid());    
        // TODO: If it feels necessary, first check the DB if its really uniqe.
        // In this case, it would probably be less beneficial
    }
    
    private function calculateExpiration($expireAfter) {
        // No expiration
        if ($expireAfter == 0) {return null;}
        
        // Calculate the expiration date based on the given minutes and actual time
        $expiration = mktime(date('H'), date('i') + $expireAfter, date('s'), date('m')  , date('d'), date('Y'));
        
        // Return in date format
        return date('Y-m-d H:i:s', $expiration);
    }

    private function secretValidator(Secret $secret) {
        // Does it exist
        if (!$secret) {return 1;}

        // Has it expired
        $expireAfter = $secret->getProperty('expiresAt');
        if ($expireAfter < date('Y-m-d H:i:s')) {return 1;}

        // Does it have remaining view
        $remainingViews = $secret->getProperty('remainingViews');
        if ($remainingViews <= 0) {return 1;}

        return 0;
    }
}
?>