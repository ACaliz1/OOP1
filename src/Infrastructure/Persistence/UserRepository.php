<?php
    namespace App\Infrastructure\Persistence;

use App\School\Repositories\IUserRepository;
    use App\School\Entities\User;

    class UserRepository implements IUserRepository{
        private \PDO $db;

        function __construct(\PDO $db){

            $this->db=$db;
        }

        // Guarda un nuevo usuario
        function save(User $user){
            $stmt=$this->db->prepare("INSERT INTO users(username,email) VALUES(:username,:email)");
            $stmt->execute([
                'username'=>$user->getFirstName(),
                'email'=>$user->getEmail()
            ]);

        }

        // Encuentra un usuario por su DNI
        function findByDni(string $dni):?User{
            $stmt=$this->db->prepare("SELECT * FROM users WHERE dni=:dni");
            $stmt->execute(['dni'=>$dni]);
            return $stmt->fetchObject(User::class);
        }
    }