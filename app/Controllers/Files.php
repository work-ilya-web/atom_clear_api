<?php namespace App\Controllers;

use asligresik\easyapi\Controllers\BaseResourceController;
use App\Models\UserModel;
class Files extends BaseResourceController
{
    protected $modelName = 'App\Models\FilesModel';

     /**
     * @OA\Get(
     *     path="/files",
     *     tags={"Files"},
     *     summary="Получение списка записей",
     *     description="Получение списка записей",
     *     operationId="getFiles",
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
     *            @OA\Property(property="data",type="array",@OA\Items(ref="#/components/schemas/Files")),
     *            @OA\Property(property="pagination",type="object",@OA\Property(property="currentPage", type="integer"),@OA\Property(property="totalPage", type="integer")),
     *         ),
     *         @OA\XmlContent(type="object",
     *            @OA\Property(property="data",type="array",@OA\Items(ref="#/components/schemas/Files")),
     *            @OA\Property(property="pagination",type="array",@OA\Items(ref="#/components/schemas/Files")),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Files не найден"
     *     ),
     *     security={
     *         {"bearer_auth": {}}
     *     }
     * )
     *
     */

    /**
     * @OA\Get(
     *     path="/files/{id}",
     *     tags={"Files"},
     *     summary="Возвращает одну запись по ID",
     *     description="",
     *     operationId="getFilesById",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of Files to return",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Files"),
     *         @OA\XmlContent(ref="#/components/schemas/Files"),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid ID supplier"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Files not found"
     *     ),
     *     security={
     *         {"bearer_auth": {}}
     *     }
     * )
     *
     */



     /**
      * @OA\Post(
      *     path="/files",
      *     tags={"Files"},
      *     summary="Добавить файл",
      *     operationId="addFiles",
      *     @OA\RequestBody(
      *       required=true,
      *       description="Email user",
      *       @OA\MediaType(
      *           mediaType="multipart/form-data",
      *           @OA\Schema(
      * 				type="object",
      * 				@OA\Property(property="file",type="file",description="Файл"),
      * 				@OA\Property(property="post_type",type="text",description="Тип записи"),
      * 				@OA\Property(property="post_id",type="text",description="id записи"),
      * 				@OA\Property(property="comment",type="text",description="Коментарий к файлу")
      * 			)
      *       ),
      * 	   ),
      *     @OA\Response(
      *         response=200,
      *         description="Password recovery success",
      *         @OA\JsonContent(
      * 			@OA\Schema(
      * 				type="object",
      * 				@OA\Property(property="password",type="string"),
      * 				@OA\Property(property="email",type="string"),
      * 				@OA\Property(property="user",type="object")
      * 			)
      * 		),
      *     ),
      *     @OA\Response(
      *         response=400,
      *         description="Invalid email supplied"
      *     ),
      *     @OA\Response(
      *         response=404,
      *         description="Пользователя с таким email не найдено"
      *     ),
      * )
      */

      public function create(){
          $UserModel = new UserModel();
          $token = $UserModel->getToken($this->request->getServer('HTTP_AUTHORIZATION'));
          $current_user = $UserModel->getUserByToken($token);
          $files = $this->request->getFiles();
          $post = $this->request->getJSON();
          if(empty($post)){ $post = (object)$_POST;}
          $result = $this->model->upload_file($files, 'file', $current_user, $post);
          return $this->respond($result['data'], $result['code']);
       }

    /**
     * @OA\Put(
     *     path="/files/{id}",
     *     tags={"Files"},
     *     summary="Обновить запись",
     *     operationId="updateFiles",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Files id to update",
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
     *         description="Files not found"
     *     ),
     *     @OA\Response(
     *         response=405,
     *         description="Validation exception"
     *     ),
     *     security={
     *         {"bearer_auth": {}}
     *     },
     *     requestBody={"$ref": "#/components/requestBodies/Files"}
     * )
     */

    /**
     * @OA\Delete(
     *     path="/files/{id}",
     *     tags={"Files"},
     *     summary="Удалить запись",
     *     operationId="deleteFiles",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id файлов для удаления, можно писать несколько id через запятую, например 1,2,3",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
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
        $ids = explode(',', $id);
        foreach ($ids as $id_file) {
            if(is_numeric($id_file)){
                $file = $this->model->find($id_file);
                if($file){
                    unlink($_SERVER['DOCUMENT_ROOT'].'/'.$file['path']);
                }

         		$delete = $this->model->delete($id_file);
         		if ($this->model->db->affectedRows() === 0) {
         			return $this->failNotFound(sprintf(
         				'item with id %d not found or already deleted',
         				$id_file
         			));
         		}
                 $this->writeLog();
            }
     	}
        return $this->respondDeleted(['files' => $ids], 'data deleted');
 	}

}
