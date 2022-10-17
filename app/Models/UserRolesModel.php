<?php namespace App\Models;

use asligresik\easyapi\Models\BaseModel;

class UserRolesModel extends BaseModel
{
    protected $table = 'user_roles';
    //protected $returnType = 'App\Entities\UserRoles';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id_subdivisions',
		'title',
		'status'
    ];
    protected $typeFields = [
        'id' => 'int',
        'id_subdivisions' => 'int',
		'status'=> 'int',
		'title'=> 'string',
    ];
    protected $validationRules = [
        'id' => 'numeric|max_length[11]|required|is_unique[user_roles.id,id,{id}]',
		'id_subdivisions' => 'numeric|max_length[10]|required',
		'title' => 'max_length[255]|required',
		'status' => 'numeric|max_length[1]|required'
    ];
}
