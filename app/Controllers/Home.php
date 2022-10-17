<?php namespace App\Controllers;


use App\Models\PagesModel;
use App\Models\UserRolesModel;
use App\Models\UserAccessModel;
class Home extends BaseController
{

    public function index(){
        return view('swagger/index');
    }
    /*public function createAssets()
 	{
        $PagesModel = new PagesModel();
        $UserRolesModel = new UserRolesModel();
        $UserAccessModel = new UserAccessModel();

        $pages = $PagesModel->findAll();
        $roles = $UserRolesModel->findAll();
        foreach ($roles as $role) {
            foreach ($pages as $page) {
                $insert = [
                    'id_roles'  => $role['id'],
                    'id_pages'  => $page['id'],
                    'access'    => 1,
                ];
                //$UserAccessModel->insert($insert);
                //echo "<pre>"; print_r($insert); echo "</pre>";
            }
        }
 	}*/


}
