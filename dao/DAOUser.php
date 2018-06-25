<?php

namespace BWB\Framework\mvc\dao;

use BWB\Framework\mvc\DAO;

/**
 * Users
 */
class DAOUser extends DAO 
{
    public function create($array) {
        
    }

    public function delete($id) {
        
    }

    public function getAll() 
    {
        $sql = 'SELECT id, email FROM users ORDER BY created_date DESC LIMIT 0,10';
        $req = $this->getPdo()->query($sql);
        
        return $req->fetchAll();
    }

    public function getAllBy($filter) {
        
    }

    public function retrieve($id) 
    {
        $sql = 'SELECT id, email, firstname, lastname, zip_code, tel, birthday FROM users WHERE id = :id';
        $req = $this->getPdo()->prepare($sql);
        $req->bindParam(':id', $id);
        $req->execute();

        return $req->fetch();
    }

    public function update($array) 
    {
        $sql = 'UPDATE users SET email = :email, firstname = :firstname, lastname = :lastname, zip_code = :zip_code, tel = :tel, birthday = :birthday, updated_date = NOW() WHERE id = :id';
        $req = $this->getPdo()->prepare($sql);
        $req->bindParam(':email', $array['email']);
        $req->bindParam(':firstname', $array['firstname']);
        $req->bindParam(':lastname', $array['lastname']);
        $req->bindParam(':zip_code', $array['zip_code']);
        $req->bindParam(':tel', $array['phone']);
        $req->bindParam(':birthday', $array['birthday']);
        $req->bindParam(':id', $array['id']);
        return $req->execute();
    }
}
