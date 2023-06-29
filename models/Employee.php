<?php
class Employee extends Model {

    public $name;
    public $email;
    public $age;
    public $designation;
    public $created;

	public function __construct() {
	    // Nous définissons la table par défaut de ce modèle
	    $this->table = "employee";

	    // Nous ouvrons la connexion à la base de données
	    $this->getConnection();
	}

    public function create() : bool {
        // Ecriture de la requête SQL en y insérant le nom de la table
        $sql = "INSERT INTO " . $this->table . " SET name=:name, email=:email, age=:age, designation=:designation, created=:created";

        // Préparation de la requête
        $query = $this->_connexion->prepare($sql);

        // Protection contre les injections
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->age=htmlspecialchars(strip_tags($this->age));
        $this->designation=htmlspecialchars(strip_tags($this->designation));

        // Ajout des données protégées
        $query->bindParam(":name", $this->name);
        $query->bindParam(":email", $this->email);
        $query->bindParam(":age", $this->age);
        $query->bindParam(":designation", $this->designation);
        $query->bindParam(":created", $this->created);

        // Exécution de la requête
        if($query->execute()){
            return true;
        }
        return false;
    }

    public function modify() : bool {
        // On écrit la requête
        $sql = "UPDATE " . $this->table . " SET name=:name, email=:email, age=:age, designation=:designation WHERE id=:id";

        // On prépare la requête
        $query = $this->_connexion->prepare($sql);

        // Protection contre les injections
        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->age=htmlspecialchars(strip_tags($this->age));
        $this->designation=htmlspecialchars(strip_tags($this->designation));

        // Ajout des données protégées
        $query->bindParam(":id", $this->id);
        $query->bindParam(":name", $this->name);
        $query->bindParam(":email", $this->email);
        $query->bindParam(":age", $this->age);
        $query->bindParam(":designation", $this->designation);

        // On exécute
        if($query->execute()){
            return true;
        }

        return false;
    }

    public function delete() : bool {
        // On écrit la requête
        $sql = "DELETE FROM " . $this->table . " WHERE id = ?";

        // On prépare la requête
        $query = $this->_connexion->prepare($sql);

        // Protection contre les injections
        $this->id=htmlspecialchars(strip_tags($this->id));

        // Ajout des données protégées
        $query->bindParam(1, $this->id);

        // On exécute
        if($query->execute()){
            return true;
        }

        return false;
    }

}