<?php namespace App\Models;

use asligresik\easyapi\Models\BaseModel;
use App\Models\UserTokensModel;

class UserModel extends BaseModel
{
    protected $table = 'user';
    //protected $returnType = 'App\Entities\User';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'created_at',
		'email',
		'password',
		'role',
		'deleted'
    ];
    protected $validationRules = [
        'id' => 'numeric|max_length[11]|required|is_unique[user.id,id,{id}]',
		'email' => [
            'rules'  => 'max_length[128]|required|valid_email|is_unique[user.email]',
            'errors' => [
                'valid_email' => 'Указан не корректный email',
                'is_unique' => 'Пользователь таким email уже есть на сайте',
            ]
        ],
        'password' => [
            'rules'  => 'min_length[6]|max_length[255]',
            'errors' => [
                'min_length' => 'Минимальная длинна пароля - 6 символов',
                'max_length' => 'Максимальная длинна пароля - 255 символов',
            ]
        ],
		'role' => 'numeric|max_length[11]|required|in_db[user_roles.id]',
    ];
    protected $typeFields = [
        'id' => 'int',
        'role' => 'int',
        'user_statuses_id' => 'int',
        'created_at' => 'int',
        'passport_serial' => 'int',
        'passport_number' => 'int',
        'img_passport' => 'int',
        'img_snils' => 'int',
        'img_inn' => 'int',
        'photo' => 'int',
    ];

    protected $joinFields = [
        'user.role' => [
            'table'  => 'user_roles',
            'alias'  => 'role',
            'fields' => 'role.title as user_roles_title'
        ],
    ];

    public function getUserByToken($token){
        if(is_string($token) and !empty($token)){
            $UserTokensModel = new UserTokensModel();
            $join = $this->joinFields;
            if (!empty($join)) {
                $tables = '';

                foreach ($join as $field => $values) {
                    $tables = $tables.((empty($tables))?'':',').$values['table'];
                }

                foreach ($join as $field => $values) {
                    $this->select("$this->table.*, ".$values['fields']);
                    $this->join($values['table'].' AS '.$values['alias'], $field.' = '.$values['alias'].'.id', 'left');
                }
            }
            $token_user =  $UserTokensModel->where('token', $token)->where('date_end >', time())->first();

            if(!empty($token_user)){
                $user =  $this->find($token_user['user_id']);
                $user['access_token'] = $token_user['token'];
                unset($user['password']);
            } else {
                return ['errors' => ['token'=>'Пользователь по токену не найден'], 'code'=>422];
            }
            if(!empty($user)){
                return ['info'=>['user'=>$user], 'code'=> 200];
            } else {
                return ['errors' => ['token'=>'Пользователь по токену не найден'], 'code'=>422];
            }

        } else {
            return ['info'=>['message' => 'Invalid token'.$token.''], 'code'=>400];
        }
    }

    public function auth($email, $password){
        if(!empty($email) AND !empty($password)){
            $join = $this->joinFields;
            if (!empty($join)) {
                $tables = '';

                foreach ($join as $field => $values) {
                    $tables = $tables.((empty($tables))?'':',').$values['table'];
                }

                foreach ($join as $field => $values) {
                    $this->select("$this->table.*, ".$values['fields']);
                    $this->join($values['table'].' AS '.$values['alias'], $field.' = '.$values['alias'].'.id', 'left');
                }
            }
            $user =  $this->where('email', $email)->where('password', md5($password))->where('deleted', 0)->first();
            unset($user['auth_key']);
            unset($user['access_code']);
            unset($user['password']);
            return $user;
        } return false;
    }

    public function forgot($email){
        if(!empty($email)){
            return $this->where('email', $email)->first();
        } return false;
    }

    public function getToken($authHeader){
        //$authHeader = ;
        $arr        = explode(' ', $authHeader);
        $token      = isset($arr[1]) ? $arr[1] : '';
        return isset($arr[1]) ? $arr[1] : '';
    }

    public function find_id_compact($id){
        $this->select("user.id, user.surname, user.name, user.patronymic, f.path AS photo_path, f.server AS photo_server");
        $this->join('files AS f', 'user.photo = f.id', 'left');
        return $this->find($id);
    }

    public function get_birthdays(){
        return $this->query('SELECT id,name,patronymic, surname, photo, birthdate FROM `user` WHERE deleted = 0 ORDER BY CONCAT(SUBSTR(`birthdate`,6) < SUBSTR(CURDATE(),6), SUBSTR(`birthdate`,6)) LIMIT 9')->getResultArray();
    }
}
