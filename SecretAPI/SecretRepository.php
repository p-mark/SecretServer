<?php
require_once 'Secret.php';
require_once 'pdo.php';

class SecretRepository extends DB{

    public function saveSecret(Secret $secret) {
        $sql = "INSERT INTO secrets (hash, secretText, createdAt, expiresAt, remainingViews) VALUES (?,?,?,?,?)";

        $stmt = $this->connect()->prepare($sql);
        if(!$stmt->execute([$secret->getProperty('hash'),$secret->getProperty('secretText'),$secret->getProperty('createdAt'),
                            $secret->getProperty('expiresAt'),$secret->getProperty('remainingViews')]))
        {
            return 1;
        }
        return 0;
    }

    public function getSecretByHash($hash) {
        $sql = "SELECT * FROM secrets WHERE hash = ?";

        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$hash]);
        $result = $stmt->fetch();

        if (!$result) {return null;}
        return new Secret($result['hash'], $result['secretText'], $result['createdAt'], $result['expiresAt'], $result['remainingViews']);
    }

    public function decreaseRemainingViews($hash) {
        $sql = "UPDATE secrets SET remainingViews = remainingViews - 1 WHERE hash = ?";

        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$hash]);
    }
}
?>