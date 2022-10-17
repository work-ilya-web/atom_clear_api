<?php namespace App\Models;

use asligresik\easyapi\Models\BaseModel;

class UserTokensModel extends BaseModel
{
    protected $table = 'user_tokens';
    //protected $returnType = 'App\Entities\UserTokens';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'user_id',
		'token',
		'date_end'
    ];
    protected $validationRules = [
        'id' => 'numeric|max_length[20]|required|is_unique[user_tokens.id,id,{id}]',
		'user_id' => 'numeric|max_length[11]|required|in_db[user.id]',
		'token' => 'max_length[255]|required',
		'date_end' => 'numeric|max_length[11]|required'
    ];
    protected $typeFields = [
        'id' => 'int',
        'user_id' => 'int',
		'date_end' => 'int'
    ];
}
