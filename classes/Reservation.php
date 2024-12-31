<?php
class Reservation {
    private $id;
    private $date;
    private $heure;
    private $ligne;
    private $utilisateurId;
    private $status;
    private $db;

    public function __construct($id = null, $date = null, $heure = null, $ligne = null, $utilisateurId = null, $status = null) {
        // Ensure database connection is always available
        $this->db = (new Database())->connect(); // Assuming the Database class connects to 'gestion_transport' DB
        $this->id = $id;
        $this->date = $date;
        $this->heure = $heure;
        $this->ligne = $ligne;
        $this->utilisateurId = $utilisateurId;
        $this->status = $status;
    }

    // Create a reservation
    public function create() {
        $query = $this->db->prepare("INSERT INTO reservation (date, heure, ligne, utilisateur_id, status) VALUES (?, ?, ?, ?, ?)");
        return $query->execute([$this->date, $this->heure, $this->ligne, $this->utilisateurId, $this->status]);
    }

    // Update a reservation
    public function update() {
        $query = $this->db->prepare("UPDATE reservation SET date = ?, heure = ?, ligne = ?, status = ? WHERE id = ?");
        return $query->execute([$this->date, $this->heure, $this->ligne, $this->status, $this->id]);
    }

    // Delete a reservation
    public function delete() {
        $query = $this->db->prepare("DELETE FROM reservation WHERE id = ?");
        return $query->execute([$this->id]);
    }

    // Get all reservations
    public static function getAll($db) {
        $query = $db->prepare("SELECT * FROM reservation");
        $query->execute();

        $reservation = [];
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $reservation[] = new Reservation(
                $row['id'],
                $row['date'],
                $row['heure'],
                $row['ligne'],
                $row['utilisateur_id'],
                $row['status']
            );
        }

        return $reservation;
    }

    public static function getById($id, $db) {
        $query = $db->prepare("SELECT * FROM reservation WHERE id = ?");
        $query->execute([$id]);
        $row = $query->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Reservation(
                $row['id'],
                $row['date'],
                $row['heure'],
                $row['ligne'],
                $row['utilisateur_id'],
                $row['status']
            );
        }
        return null;
    }

    // Getters and setters
    public function getId() { return $this->id; }
    public function getDate() { return $this->date; }
    public function getHeure() { return $this->heure; }
    public function getLigne() { return $this->ligne; }
    public function getStatus() { return $this->status; }
    public function setDate($date) { $this->date = $date; }
    public function setHeure($heure) { $this->heure = $heure; }
    public function setLigne($ligne) { $this->ligne = $ligne; }
    public function setStatus($status) { $this->status = $status; }
}
?>
