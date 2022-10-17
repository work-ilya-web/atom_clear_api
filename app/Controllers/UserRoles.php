<?php namespace App\Controllers;

use asligresik\easyapi\Controllers\BaseResourceController;
use App\Models\UserModel;
use App\Models\UserAccessModel;
use App\Models\PagesModel;
class UserRoles extends BaseResourceController
{
    protected $modelName = 'App\Models\UserRolesModel';

     /**
     * @OA\Get(
     *     path="/userRoles",
     *     tags={"UserRoles"},
     *     summary="Получение списка записей",
     *     description="",
     *     operationId="getUserRoles",
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
     *            @OA\Property(property="data",type="array",@OA\Items(ref="#/components/schemas/UserRoles")),
     *            @OA\Property(property="pagination",type="object",@OA\Property(property="currentPage", type="integer"),@OA\Property(property="totalPage", type="integer")),
     *         ),
     *         @OA\XmlContent(type="object",
     *            @OA\Property(property="data",type="array",@OA\Items(ref="#/components/schemas/UserRoles")),
     *            @OA\Property(property="pagination",type="array",@OA\Items(ref="#/components/schemas/UserRoles")),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="UserRoles не найден"
     *     ),
     *     security={
     *         {"bearer_auth": {}}
     *     }
     * )
     *
     */

    /**
     * @OA\Get(
     *     path="/userRoles/{id}",
     *     tags={"UserRoles"},
     *     summary="Возвращает одну запись",
     *     description="Returns a single UserRoles",
     *     operationId="getUserRolesById",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of UserRoles to return",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/UserRoles"),
     *         @OA\XmlContent(ref="#/components/schemas/UserRoles"),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid ID supplier"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="UserRoles not found"
     *     ),
     *     security={
     *         {"bearer_auth": {}}
     *     }
     * )
     *
     */

    /**
     * @OA\Post(
     *     path="/userRoles",
     *     tags={"UserRoles"},
     *     summary="Добавить запись",
     *     operationId="addUserRoles",
     *     @OA\Response(
     *         response=201,
     *         description="Created UserRoles",
     *         @OA\JsonContent(ref="#/components/schemas/UserRoles"),
     *         @OA\XmlContent(ref="#/components/schemas/UserRoles"),
     *     ),
     *     @OA\Response(
     *         response=405,
     *         description="Invalid input"
     *     ),
     *     security={
     *         {"bearer_auth": {}}
     *     },
     *     requestBody={"$ref": "#/components/requestBodies/UserRoles"}
     * )
     */
     public function create()
 	 {
        $PagesModel = new PagesModel();
        $UserAccessModel = new UserAccessModel();

        $data = $this->request->getJSON();
		if(empty($data)){
            $data = (object)$_POST;
        }
 		if (!$this->model->insert($data)) {
 			return $this->fail($this->model->errors());
 		} else {
            $id = $this->model->insertID();
            $pages = $PagesModel->findAll();
            foreach ($pages as $page) {
                $insert = [
                    'id_roles'  => $id,
                    'id_pages'  => $page['id'],
                    'access'    => 2,
                ];
                $UserAccessModel->insert($insert);
            }
        }
        $this->writeLog();
 		return $this->respondCreated($data, 'product created');
 	 }

    /**
     * @OA\Put(
     *     path="/userRoles/{id}",
     *     tags={"UserRoles"},
     *     summary="Обновить запись",
     *     operationId="updateUserRoles",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="UserRoles id to update",
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
     *         description="UserRoles not found"
     *     ),
     *     @OA\Response(
     *         response=405,
     *         description="Validation exception"
     *     ),
     *     security={
     *         {"bearer_auth": {}}
     *     },
     *     requestBody={"$ref": "#/components/requestBodies/UserRoles"}
     * )
     */

    /**
     * @OA\Delete(
     *     path="/userRoles/{id}",
     *     tags={"UserRoles"},
     *     summary="Удалить запись",
     *     operationId="deleteUserRoles",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="UserRoles id to delete",
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
     public function delete($id = null)
     {
        $UserModel = new UserModel();
        $UserAccessModel = new UserAccessModel();

        $user = $UserModel->where('role', $id)->findAll();
        if(count($user)==0){
        	$delete = $this->model->delete($id);
        	if ($this->model->db->affectedRows() === 0) {
        		return $this->failNotFound(sprintf(
        			'item with id %d not found or already deleted',
        			$id
        		));
        	}
            $deleteAccess = $UserAccessModel->where('id_roles', $id)->delete();

            $this->writeLog();
        	return $this->respondDeleted(['id' => $id, 'message'=>'data deleted'], );
        } else {
            return $this->respond(['errors' => ['roles'=>'Для данной роли назначены пользователи.']], 423);
        }
     }
}
