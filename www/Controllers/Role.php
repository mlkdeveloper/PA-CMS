<?php


namespace App\Controller;


use App\Core\FormValidator;
use App\Core\View;
use App\Models\Role as modelRole;

class Role
{

    public function newRoleAction(){

        $role = new modelRole();
        $view = new View("createRole.back", "back");
        $view->assign("title", "Admin - Rôle");

        $form = $role->formBuilderRegister();

        if (!empty($_POST)){

            $errors = FormValidator::checkFormRole($form, $_POST);

            if (empty($errors)){

                $role->populate($_POST);
                $role->save();

            }else{

                $view->assign("errors", $errors);

            }

        }
    }

}