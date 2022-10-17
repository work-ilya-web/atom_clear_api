<?php
namespace App\Controllers;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\RESTful\ResourceController;
use Config\Services;
use Firebase\JWT\JWT;
use App\Models\UserModel;
use App\Models\UserTokensModel;
use App\Models\SettingsAuthModel;

use App\Models\UserRolesModel;
use App\Models\PagesModel;
/**
* Class Auth
* @OA\Schema(
*     title="Authentication",
*     description="Авторизация"
* )
*
* @OA\Tag(
*     name="Authentication",
*     description="Все, что касается авторизации"
* )
*/
class Auth extends ResourceController
{

    //protected $format = 'json';

    /**
     * @OA\Post(
     *     path="/auth/login",
     *     tags={"Authentication"},
     *     summary="Авторизация пользователя.",
     *     operationId="userLogin",
     *     @OA\RequestBody(
     *       required=true,
     *       description="Email user",
     *       @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(
     * 				type="object",
     * 				@OA\Property(property="email",type="string",description="admin@mail.ru"),
     * 				@OA\Property(property="password",type="string",description="123456"),
     * 			)
     *       ),
     * 	   ),
     *     @OA\Response(
     *         response=200,
     *         description="Login successed",
     *         @OA\JsonContent(
     * 			@OA\Schema(
     * 				type="object",
     * 				@OA\Property(property="token",type="string")
     * 			)
     * 		),
     *         @OA\XmlContent(
     * 			@OA\Schema(
     * 				type="object",
     * 				@OA\Property(property="token",type="string")
     * 			)
     * 		),
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Invalid username/password supplied"
     *     ),
     * )
     */

    public function login(){
        helper(['functions']);
        $UserModel = new UserModel();
        $UserTokensModel = new UserTokensModel();
        $data = getDataPost($this->request->getJSON());
        $email = $data->email;
        $password = $data->password;

        if(!empty($email) AND !empty($password)){
            $user = $UserModel->auth(trim($email), trim($password));

            if ($user) {
                $key = Services::getSecretKey();
                $payload = [
                    'aud' => 'https://222324.fornex.cloud',
                    'iat' => time(),
                    'nbf' => time() - 100,
                ];
                $jd = json_encode($payload);
                $jwt = JWT::encode($payload, $key);
                $insert_token = [
                    'user_id'=>$user['id'],
                    'token'=>$jwt,
                    'date_end'=>time() + 86400 * 10 # срок жизни токена 10 дней
                ];
                $UserTokensModel->insert($insert_token);
                $user['access_token'] = $jwt;


                return $this->respond(['token' => $jwt,  'user'=>$user], 200);
            } else {
                return $this->respond(['errors' => [
                    'email' => 'Не корректный логин или пароль',
                    'password' => 'Не корректный логин или пароль'
                ]], 423);
            }
        } else {
            $errors = [];
            if(empty($email)){
                $errors['errors']['email'] = 'Не указан email';
            }
            if(empty($password)){
                $errors['errors']['password'] = 'Не указан пароль';
            }
            return $this->respond($errors, 422);
        }
    }


    /**
     * @OA\Get(
     *     path="/auth/getUserByToken/{token}",
     *     tags={"Authentication"},
     *     summary="Получает пользователя по токену",
     *     operationId="getUserByToken",
     *     @OA\Parameter(
     *         name="token",
     *         in="path",
     *         description="token",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Вернется масив с пользователем",
     *         @OA\JsonContent(type="object",
     *            @OA\Property(property="user",type="array",@OA\Items(ref="#/components/schemas/User")),
     *         ),
     *         @OA\XmlContent(type="object",
     *            @OA\Property(property="user",type="array",@OA\Items(ref="#/components/schemas/User")),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid token"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Пользователь не найден"
     *     ),

     * )
     */
    public function getUserByToken($token){

        helper(['functions']);

        if(!empty($token)){
            $UserModel = new UserModel();
            $user = $UserModel->getUserByToken($token);
            if (empty($user['errors'])) {
                return $this->respond($user['info']['user'], $user['code']);
            } else {
                return $this->respond($user, $user['code']);
            }

        } else {
            $errors = [];
            if(empty($password)){
                $errors['errors']['token'] = 'Не указан токен';
            }
            return $this->respond($errors, 422);
        }
    }








}
