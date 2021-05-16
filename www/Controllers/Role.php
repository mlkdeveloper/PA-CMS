<?php


namespace App\Controller;


use App\Core\FormValidator;
use App\Core\View;
use App\Models\Role as modelRole;
use App\Models\User;

class Role
{

    public function showAllAction(){

        $role = new modelRole();
        $listRoles = $role->select()->where("id > 1")->get();

        $view = new View("displayRole.back", "back");
        $view->assign("title", "Admin - Liste des rôles");
        $view->assign("listRoles",$listRoles);

    }

    public function newRoleAction(){

        $role = new modelRole();
        $view = new View("createRole.back", "back");
        $view->assign("title", "Admin - Rôle");

        $form = $role->formBuilderRegister();

        if (!empty($_POST)){

            $errors = FormValidator::checkFormRole($form, $_POST,false);

            if (empty($errors)){
                $role->populate($_POST);
                $role->save();
                $view->assign("success", "Le rôle a bien été créé !");

            }else{
                $view->assign("errors", $errors);
            }
        }
    }

    public function updateRoleAction(){

        if (isset($_GET['id']) && !empty($_GET['id']) && $_GET['id'] != 1){

            $role = new modelRole();
            $verifyId = $role->select("id,name")->where("id = :id")->setParams(["id" => $_GET['id']])->get();

            if (empty($verifyId))
                header("Location: /admin/role");

            $view = new View("updateRole.back", "back");

            $form = $role->formBuilderRegister();

            if (!empty($_POST)){

                $errors = FormValidator::checkFormRole($form, $_POST,trim($_POST['name']) === $verifyId[0]["name"] );
                if (empty($errors)){
                    $role->populate($_POST);
                    $role->setId($_GET['id']);
                    $role->save();
                    $view->assign("success", "Le rôle a bien été modifié !");
                }else{
                    $view->assign("errors", $errors);
                }
            }

            $values = $role->select()->where("id = :id")->setParams(["id" => $_GET['id']])->get();
            $view->assign("values", ...$values);
            $view->assign("title", "Admin - Rôle");

        }else{
            header("Location: /admin/role");
        }
    }

    public function deleteRoleAction(){

        if (isset($_GET['id']) && !empty($_GET['id']) && $_GET['id'] != 1){

            $user = new User();
            $role = new modelRole();
            $isAssign = $user->select("id")->where("id_role = :id")->setParams(["id" => $_GET['id']])->get();
            session_start();
            if (empty($isAssign)){
                $role->where("id = :id")->setParams(["id" => $_GET['id']])->delete();
                header("Location: /admin/role");
                $_SESSION['successDeleteRole'] = "Le rôle a bien été supprimé !";
            }else{
                header("Location: /admin/role");
                $_SESSION['errorDeleteRole'] = "Le rôle n'a pas pu être supprimé car il est assigné à un utilisateur !";
            }

        }

    }
}