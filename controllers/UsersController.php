<?php 

namespace BWB\Framework\mvc\controllers;

use BWB\Framework\mvc\Controller;
use BWB\Framework\mvc\Helper;
use BWB\Framework\mvc\dao\DAOUser;
use BWB\Framework\mvc\Validation;

class UsersController extends Controller 
{
    private $dao_user;

    public function __construct()
    {
        if (!$this->helper()->is_auth()) {
            $this->helper()->redirect('login');
        }

        $this->dao_user = new DAOUser();
    }

    public function index()
    {
        if ($this->helper()->is_admin()) {

            $this->render('users/index', [
                'users' => $this->dao_user->getAll()
            ]);
        }
    }

    public function edit($id)
    {
        if ($this->helper()->is_admin()) {

            $this->render('users/edit', [
                'user' => $this->dao_user->retrieve($id)
            ]);
        }        
    }

    public function update($id)
    {
        if ($this->helper()->is_admin()) {
            $names = [
                'email' => 'e-mail',
                'firstname' => 'prénom',
                'lastname' => 'nom de famille',
                'zip_code' => 'code postal',
                'birthday' => 'date de naissance',
                'phone' => 'téléphone'
            ];
            
            $validation = new Validation($_POST, $names, $this->dao_user);

            $validation->field('email')->isEmail();
    
            if ($validation->isValid()) {
                
                $request = $this->dao_user->update([
                    'id' => $id,
                    'email' => $_POST['email'],
                    'firstname' => $_POST['firstname'],
                    'lastname' => $_POST['lastname'],
                    'zip_code' => $_POST['zip_code'],
                ]);
                    
                if ($request) {
                    $this->helper()->with('flash', [
                        'class' => 'is-success',
                        'message' => 'L\'utilisateur à bien été modifier.'
                    ])->redirect('admin/users/'. $id .'/edit');    
                }
            }
    
            $this->helper()->withErrors($validation->errors)->redirect('admin/users/'. $id .'/edit');            
        }
    }

    public function delete($id)
    {
        if ($this->helper()->is_admin()) {
            $user = $this->dao_user->delete($id);

            if ($user) {
                $this->helper()->with('flash', [
                    'class' => 'is-success',
                    'message' => 'L\'utilisateur à bien été supprimer.'
                ])->redirect('admin/users');
            }
        }
    }

    public function dashboard()
    {
        $this->render('users/dashboard', [
            'users' => $this->dao_user->getAll()
        ]);
    }

    public function getSettings()
    {
        $this->render('users/settings', [
            'user' => $this->dao_user->retrieve($_SESSION['user']['id'])
        ]);        
    }

    public function postSettings()
    {
        $names = [
            'email' => 'e-mail',
            'firstname' => 'prénom',
            'lastname' => 'nom de famille',
            'zip_code' => 'code postal',
            'birthday' => 'date de naissance',
            'phone' => 'téléphone'
        ];

        $validation = new Validation($_POST, $names, $this->dao_user);

        $validation->field('email')->isEmail();

        if ($validation->isValid()) {
            
            $request = $this->dao_user->update([
                'id' => $_SESSION['user']['id'],
                'email' => $_POST['email'],
                'firstname' => $_POST['firstname'],
                'lastname' => $_POST['lastname'],
                'zip_code' => $_POST['zip_code'],
            ]);
                
            if ($request) {
                $this->helper()->with('flash', [
                    'class' => 'is-success',
                    'message' => 'Vos paramètres on bien été modifier.'
                ])->redirect('settings');
            }
        }

        $this->helper()->withErrors($validation->errors)->redirect('settings');
    }
}