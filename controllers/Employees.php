<?php

class Employees extends Controller {
    /**
     * Cette méthode affiche la liste de tous les employés
     *
     * @return void
     */
    public function getAll() {
        // Headers requis
        // Format des données envoyées
        header("Content-Type: application/json; charset=UTF-8");
        // Méthode autorisée
        header("Access-Control-Allow-Methods: GET");
        // Durée de vie de la requête
        header("Access-Control-Max-Age: 3600");
        // Entêtes autorisées
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

        if($_SERVER['REQUEST_METHOD'] == 'GET') {
            // On instancie le modèle "Employees"
            $this->loadModel('Employee');

            $stmt = $this->Employee->getAll();

            // On vérifie si on a au moins 1 employé
            if($stmt->rowCount() > 0) {
                // On initialise un tableau associatif
                $tableauEmployees = [];
                $tableauEmployees['employees'] = [];

                // On parcourt les produits
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);

                    $employee = [
                        "id" => $id,
                        "name" => $name,
                        "email" => $email,
                        "age" => $age,
                        "designation" => $designation,
                        "created" => $created
                    ];

                    $tableauEmployees['employees'][] = $employee;
                }
                // On envoie le code réponse 200 OK
                http_response_code(200);

                // On encode en json et on envoie
                echo json_encode($tableauEmployees);
            }
        } else {
            // Mauvaise méthode, on gère l'erreur
            http_response_code(405);
            echo json_encode(["message" => "La méthode n'est pas autorisée"]);
        }
    }

    /**
     * Cette méthode affiche la liste d'un employé dont l'id est donné en paramètre'
     *
     * @return void
     */
    public function get(string $id) {
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: GET");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

        if($_SERVER['REQUEST_METHOD'] == 'GET') {
            // On instancie le modèle "Employee"
            $this->loadModel('Employee');

            $this->Employee->id = $id;
            $query = $this->Employee->getOne();
            extract($query);

            $employee = [
                "id" => $id,
                "name" => $name,
                "email" => $email,
                "age" => $age,
                "designation" => $designation,
                "created" => $created
            ];
            // On envoie le code réponse 200 OK
            http_response_code(200);

            // On encode en json et on envoie
            echo json_encode($employee);
        } else {
            // Mauvaise méthode, on gère l'erreur
            http_response_code(405);
            echo json_encode(["message" => "La méthode n'est pas autorisée"]);
        }
    }

    public function create() {
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: GET");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->loadModel('Employee');
            $employee = $this->Employee;

            // On récupère les données reçues
            $donnees = json_decode(file_get_contents("php://input"));
            if (!empty($donnees->name) && !empty($donnees->email) && !empty($donnees->age) && !empty($donnees->designation)) {
                $employee->name = $donnees->name;
                $employee->email = $donnees->email;
                $employee->age = $donnees->age;
                $employee->designation = $donnees->designation;
                $employee->created = date('Y-m-d H:i:s');

                if($employee->create()){
                    http_response_code(201);
                    echo json_encode(["message" => "L'ajout a été effectué"]);
                } else{
                    http_response_code(503);
                    echo json_encode(["message" => "L'ajout n'a pas été effectué"]);
                }
            }
        } else {
            // Mauvaise méthode, on gère l'erreur
            http_response_code(405);
            echo json_encode(["message" => "La méthode n'est pas autorisée"]);
        }
    }

    public function modify() {
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: GET");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

        if($_SERVER['REQUEST_METHOD'] == 'PUT') {
            $this->loadModel('Employee');
            $employee = $this->Employee;

            // On récupère les données reçues
            $donnees = json_decode(file_get_contents("php://input"));
            if (!empty($donnees->id) && !empty($donnees->name) && !empty($donnees->email) && !empty($donnees->age) && !empty($donnees->designation)) {
                $employee->id = $donnees->id;
                $employee->name = $donnees->name;
                $employee->email = $donnees->email;
                $employee->age = $donnees->age;
                $employee->designation = $donnees->designation;

                if($employee->modify()) {
                    http_response_code(200);
                    echo json_encode(["message" => "La modification a été effectuée"]);
                } else {
                    http_response_code(503);
                    echo json_encode(["message" => "La modification n'a pas été effectuée"]);
                }
            }
        } else {
            // Mauvaise méthode, on gère l'erreur
            http_response_code(405);
            echo json_encode(["message" => "La méthode n'est pas autorisée"]);
        }
    }

    public function delete() {
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: GET");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

        if($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            $this->loadModel('Employee');
            $employee = $this->Employee;

            // On récupère les données reçues
            $donnees = json_decode(file_get_contents("php://input"));
            if (!empty($donnees->id)) {
                $employee->id = $donnees->id;

                if($employee->delete()) {
                    http_response_code(200);
                    echo json_encode(["message" => "La suppression a été effectuée"]);
                }else{
                    http_response_code(503);
                    echo json_encode(["message" => "La suppression n'a pas été effectuée"]);
                }
            }
        } else {
            // Mauvaise méthode, on gère l'erreur
            http_response_code(405);
            echo json_encode(["message" => "La méthode n'est pas autorisée"]);
        }
    }

}