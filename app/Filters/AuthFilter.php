<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Config\Services;
use Firebase\JWT\JWT;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;

class AuthFilter implements FilterInterface
{
    use ResponseTrait;

    public function before(RequestInterface$request, $arguments = null)
    {

        $key        = Services::getSecretKey();
        $authHeader = $request->getServer('HTTP_AUTHORIZATION');

        $arr        = explode(' ', $authHeader);
        $token      = isset($arr[1]) ? $arr[1] : '';
        $request->data['token'] = isset($arr[1]) ? $arr[1] : '';

        $UserModel = new UserModel();
        $user = $UserModel->getUserByToken($token);

        if($user['code']!=200){
            return Services::response()->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED)->setJSON(['errors'=>['token'=>'Не корректный токен']]); //$this->respond(, 422);
            //return Services::response()->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
        }

    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
