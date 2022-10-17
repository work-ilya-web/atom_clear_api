<?php namespace App\Controllers;

use asligresik\easyapi\Controllers\BaseResourceController;
use App\Models\UserModel;
use App\Models\FilesModel;
class Users extends BaseResourceController
{
    protected $modelName = 'App\Models\UserModel';

     /**
     * @OA\Get(
     *     path="/users",
     *     tags={"User"},
     *     summary="Получение списка записей",
     *     description="Получение списка записей",
     *     operationId="getUser",
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="поиск по определенному столбцу",
     *         @OA\Schema(
     *             type="object"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="order",
     *         in="query",
     *         description="сортировка по определенному столбцу",
     *         @OA\Schema(
     *             type="object"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Страница",
     *         @OA\Schema(
     *             type="int32"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         description="Элементов на странице",
     *         @OA\Schema(
     *             type="int32"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="успешная операция",
     *         @OA\JsonContent(type="object",
     *            @OA\Property(property="data",type="array",@OA\Items(ref="#/components/schemas/User")),
     *            @OA\Property(property="pagination",type="object",@OA\Property(property="currentPage", type="integer"),@OA\Property(property="totalPage", type="integer")),
     *         ),
     *         @OA\XmlContent(type="object",
     *            @OA\Property(property="data",type="array",@OA\Items(ref="#/components/schemas/User")),
     *            @OA\Property(property="pagination",type="array",@OA\Items(ref="#/components/schemas/User")),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User не найден"
     *     ),
     *     security={
     *         {"bearer_auth": {}}
     *     }
     * )
     *
     */

     public function index()
 	{
 		$search = (array)$this->request->getGet('search');
 		$concat = (array)$this->request->getGet('concat');
 		$order = $this->request->getGet('order');
 		$page = $this->request->getGet('page') ?? 1;
 		$limit = $this->request->getGet('limit') ?? $this->limit;
 		$types = $this->model->typeFields;

        $search['deleted'] = 0;

        $token = $this->model->getToken($this->request->getServer('HTTP_AUTHORIZATION'));
        $current_user = $this->model->getUserByToken($token);


 		if ($limit > 0) {
 			$total = $this->model->search($search,$order,$concat)->findAll();
 			$data = $this->model->search($search,$order,$concat)->paginate($limit, 'default', $page);
 			$sql = $this->model->getLastQuery()->getQuery();

 			$this->writeLog();
 			$pagination = [
 				'currentPage' => $this->model->pager->getCurrentPage(),
 				'totalPage' => $this->model->pager->getPageCount(),
 				'total' => count($total),
 			];
 			if(!empty($types)){
 				foreach ($data as  $row=>$item) {
 					foreach ($item as $key => $field) {
 						if(@$types[$key]=='int'){
 							$data[$row][$key] = (int)$field;
 						}
 						if(@$types[$key]=='string'){
 							$data[$row][$key] = (string)$field;
 						}
 						if(@$types[$key]=='bool'){
 							$data[$row][$key] = (boolean)$field;
 						}
 					}
 				}
 			}
        }

 		if ($limit == -1) {
 			$data = $this->model->search($search,$order,$concat)->findAll();
 			if(!empty($types)){
 				foreach ($data as  $row=>$item) {
 					foreach ($item as $key => $field) {
 						if(@$types[$key]=='int'){
 							$data[$row][$key] = (int)$field;
 						}
 						if(@$types[$key]=='string'){
 							$data[$row][$key] = (string)$field;
 						}
 						if(@$types[$key]=='bool'){
 							$data[$row][$key] = (boolean)$field;
 						}
 					}
 				}
 			}
 		}
        if($current_user['info']['user']['role']!= 1 AND $current_user['info']['user']['role'] != 2){
            $new_data = [];
            foreach ($data as $key => $value) {
                $new_data[$key]['id'] =  $value['id'];
                $new_data[$key]['created_at'] =  $value['created_at'];
                $new_data[$key]['email'] =  $value['email'];
                $new_data[$key]['role'] =  $value['role'];
                $new_data[$key]['user_statuses_id'] =  $value['user_statuses_id'];
                $new_data[$key]['surname'] =  $value['surname'];
                $new_data[$key]['name'] =  $value['name'];
                $new_data[$key]['patronymic'] =  $value['patronymic']; 
                $new_data[$key]['phone'] =  $value['phone'];
                $new_data[$key]['birthdate'] =  $value['birthdate'];
                $new_data[$key]['photo'] =  $value['photo'];
                $new_data[$key]['user_subdivisions_id'] =  $value['user_subdivisions_id'];
                $new_data[$key]['deleted'] =  $value['deleted'];
                $new_data[$key]['user_subdivisions_title'] =  $value['user_subdivisions_title'];
                $new_data[$key]['user_subdivisions_color'] =  $value['user_subdivisions_color'];
                $new_data[$key]['user_roles_title'] =  $value['user_roles_title'];
                $new_data[$key]['user_statuses_color_bg'] =  $value['user_statuses_color_bg'];
                $new_data[$key]['user_statuses_color_text'] =  $value['user_statuses_color_text'];
                $new_data[$key]['user_statuses_color_text'] =  $value['user_statuses_color_text'];
                $new_data[$key]['user_statuses_comment'] =  $value['user_statuses_comment'];
                $new_data[$key]['user_statuses_name'] =  $value['user_statuses_name'];
                $new_data[$key]['photo_path'] =  $value['photo_path'];
                $new_data[$key]['photo_server'] =  $value['photo_server'];
            }
            $data = $new_data;
        }

        if ($limit > 0) {
            return $this->respond(['data' => $data, 'pagination' => $pagination]);
        }
        if ($limit == -1) {
            return $this->respond(['data' => $data]);
        }

 	}


    /**
     * @OA\Get(
     *     path="/users/{id}",
     *     tags={"User"},
     *     summary="Возвращает одну запись по ID",
     *     description="",
     *     operationId="getUserById",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of User to return",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/User"),
     *         @OA\XmlContent(ref="#/components/schemas/User"),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid ID supplier"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     ),
     *     security={
     *         {"bearer_auth": {}}
     *     }
     * )
     *
     */


     public function show($id = null)
 	{

 		$types = $this->model->typeFields;
 		$record = $this->model->find_id($id);
 		$this->writeLog();
 		if (!$record) {
 			return $this->failNotFound(sprintf(
 				'item with id %d not found',
 				$id
 			));
 		}
 		if(!empty($types)){
 			foreach ($record as $key => $field) {
 				if(@$types[$key]=='int'){
 					$record[$key] = (int)$field;
 				}
 				if(@$types[$key]=='string'){
 					$record[$key] = (string)$field;
 				}
 				if(@$types[$key]=='bool'){
 					$record[$key] = (boolean)$field;
 				}
 			}
 		}
        if($record['deleted']==0){
            return $this->respond($record);
        } else {
            return $this->failNotFound(sprintf(
 				'Пользователь удален'
 			));
        }

 	}

    /**
     * @OA\Post(
     *     path="/users",
     *     tags={"User"},
     *     summary="Добавить запись",
     *     operationId="addUser",
     *     @OA\Response(
     *         response=201,
     *         description="Created User",
     *         @OA\JsonContent(ref="#/components/schemas/User"),
     *         @OA\XmlContent(ref="#/components/schemas/User"),
     *     ),
     *     @OA\Response(
     *         response=405,
     *         description="Invalid input"
     *     ),
     *     security={
     *         {"bearer_auth": {}}
     *     },
     *     requestBody={"$ref": "#/components/requestBodies/User"}
     * )
     */
     public function create(){
        helper(['text']);
        $UserModel = new UserModel();
        $token = $UserModel->getToken($this->request->getServer('HTTP_AUTHORIZATION'));
        $current_user = $UserModel->getUserByToken($token);
        $data = $this->request->getJSON();
        $files = $this->request->getFiles();
        if(empty($data)){ $data = (object)$_POST;}
        if(empty($data->password)){
            $password = random_string('alnum', 8);
        } else {
            $password = $data->password;
        }

        $data->password = md5($password);
        $data->created_at = time();

 		if (!$UserModel->insert($data)) {
            $error_insert = $UserModel->errors();
 			return $this->fail($error_insert);
 		} else {
            $data->id = $UserModel->insertID();

            $email = \Config\Services::email();
            $email->setTo($data->email);
            $email->setSubject('Вас зарегистрировали в ERP ALT');
            $email->setMessage("Здравствуйте, {$data->name}.<br> Пароль для входа в личный кабинет: <strong>{$password}</strong> <br> <a href='".str_replace('-api','', base_url())."'>Войти</a>");
            $result = $email->send();

     		return $this->respondCreated($data, 'user created');
        }
    }

    /*public function create(){
       helper(['text']);
       $UserModel = new UserModel();
       $FilesModel = new FilesModel();
       $FilesModel2 = new FilesModel();
       $FilesModel3 = new FilesModel();
       $token = $UserModel->getToken($this->request->getServer('HTTP_AUTHORIZATION'));
       $current_user = $UserModel->getUserByToken($token);
       $data = $this->request->getJSON();
       $files = $this->request->getFiles();
       if(empty($data)){ $data = (object)$_POST;}
       if(empty($data->password)){
           $password = random_string('alnum', 8);
       } else {
           $password = $data->password;
       }

       $data->password = md5($password);
       $data->created_at = time();

       $img_passport = $FilesModel->upload_file($files, 'img_passport', $current_user, (object)['post_type'=>'user_img_passport'], 'png,jpg,gif,pdf');
       if(isset($img_passport['data']['id'])){
           $data->img_passport = $img_passport['data']['id'];
       } else {
           $errors_upload['img_passport'] = $img_passport['data'];
       }

       $img_snils = $FilesModel2->upload_file($files, 'img_snils', $current_user, (object)['post_type'=>'user_img_snils'], 'png,jpg,gif,pdf');
       if(isset($img_snils['data']['id'])){
           $data->img_snils = $img_snils['data']['id'];
       } else {
           $errors_upload['img_snils'] = $img_snils['data'];
       }

       $img_inn = $FilesModel3->upload_file($files, 'img_inn', $current_user, (object)['post_type'=>'user_img_inn'], 'png,jpg,gif,pdf');
       if(isset($img_inn['data']['id'])){
           $data->img_inn = $img_inn['data']['id'];
       } else {
           $errors_upload['img_inn'] = $img_inn['data'];
       }

       if(empty($data->employment_date)){
           $data->employment_date = time();
       }
       if (!$UserModel->insert($data)) {
           $error_insert = $UserModel->errors();
           if(isset($errors_upload) && count($errors_upload)>0){
               foreach ($errors_upload as $key => $value) {
                   $error_insert[$key] = $value['errors']['file'];
               }
           }

           return $this->fail($error_insert);
       } else {
           $data->id = $UserModel->insertID();
           $FilesModel->update($data->img_passport , ['post_id'=>$data->id]);
           $FilesModel->update($data->img_snils , ['post_id'=>$data->id]);
           $FilesModel->update($data->img_inn , ['post_id'=>$data->id]);

           $email = \Config\Services::email();
           $email->setTo($data->email);
           $email->setSubject('Вас зарегистрировали в ERP ALT');
           $email->setMessage("Здравствуйте, {$data->name}.<br> Пароль для входа в личный кабинет: <strong>{$password}</strong> <br> <a href='".str_replace('api.','', base_url())."'>Войти</a>");
           $result = $email->send();

           return $this->respondCreated($data, 'user created');
       }
   }*/

    /**
     * @OA\Put(
     *     path="/users/{id}",
     *     tags={"User"},
     *     summary="Обновить запись",
     *     operationId="updateUser",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="User id to update",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         ),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid ID supplied"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     ),
     *     @OA\Response(
     *         response=405,
     *         description="Validation exception"
     *     ),
     *     security={
     *         {"bearer_auth": {}}
     *     },
     *     requestBody={"$ref": "#/components/requestBodies/User"}
     * )
     */

     public function update($id = null){
        $UserModel = new UserModel();
        $token = $UserModel->getToken($this->request->getServer('HTTP_AUTHORIZATION'));
        $current_user = $UserModel->getUserByToken($token);

        $data       = $this->request->getJSON();
 		if(empty($data)){$data = $this->request->getRawInput();}

        if(!empty($data->password)){
            $password = md5($data->password);
        }
        //echo "<pre>"; print_r($data); echo "</pre>";

        $updateData = (array)$data;
 		$updateData[$this->model->primaryKey] = $id;

        if (!$this->model->save($updateData)) {
            $error_update = $this->model->errors();
            return $this->fail($error_update, 422);
 		} else {
            return $this->respond($data,200, 'data updated');
        }
 	}

    /**
     * @OA\Delete(
     *     path="/users/{id}",
     *     tags={"User"},
     *     summary="Удалить запись",
     *     operationId="deleteUser",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="User id to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         ),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid ID supplied",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Pet not found",
     *     ),
     *     security={
     *         {"bearer_auth": {}}
     *     },
     * )
     */

     public function delete($id = null){
 		$delete = $this->model->update($id, (array)['deleted'=>1]);
 		if ($this->model->db->affectedRows() === 0) {
 			return $this->failNotFound(sprintf(
 				'item with id %d not found or already deleted',
 				$id
 			));
 		}
        $this->writeLog();
 		return $this->respondDeleted(['id' => $id], 'data deleted');
 	}
}
