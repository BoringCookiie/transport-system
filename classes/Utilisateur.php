<?php
class Utilisateur {
    protected $id;
    protected $email;
    protected $motDePasse;

    public function __construct($id = null, $email = null, $motDePasse = null) {
        $this->id = $id;
        $this->email = $email;
        $this->motDePasse = $motDePasse;
    }

    
    public function getId() {
        return $this->id;
    }

    public function getEmail() {
        return $this->email;
    }

    // Setters
    public function setEmail($email) {
        $this->email = $email;
    }

    public function setMotDePasse($motDePasse) {
        $this->motDePasse = $motDePasse;
    }

    // Authenticate method
    public function authentifier($email, $motDePasse) {
        // Implementation of login logic
    }
}
?>
