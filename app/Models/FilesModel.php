<?php namespace App\Models;

use asligresik\easyapi\Models\BaseModel;

class FilesModel extends BaseModel
{
    protected $table = 'files';
    //protected $returnType = 'App\Entities\Files';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name',
		'type',
		'size',
		'user_id',
		'date_create',
		'path',
		'server',
		'mime_type',
		'post_type',
		'post_id',
		'comment',
    ];
    protected $validationRules = [
        'id' => 'numeric|max_length[11]|required|is_unique[files.id,id,{id}]',
		'name' => 'max_length[255]|required',
		'type' => 'max_length[10]|required',
		'size' => 'max_length[255]|required',
		'user_id' => 'numeric|max_length[11]|required|in_db[user.id]',
		'date_create' => 'numeric|max_length[11]|required',
		'path' => 'max_length[1000]|required',
		'server' => 'max_length[255]|required',
		'mime_type' => 'max_length[255]|required',
    ];
    protected $typeFields = [
		'id' => 'int',
		'user_id' => 'int',
		'date_create' => 'int',
		'post_id' => 'int',
		'size' => 'int',
    ];

    protected $joinFields = [
        'files.user_id' => [
            'table'  => 'user',
            'alias'  => 'u',
            'fields' => 'u.name as user_name, u.surname as user_surname,u.patronymic as user_patronymic, '
        ],
        'u.role' => [
            'table'  => 'user_roles',
            'alias'  => 'ur',
            'fields' => 'ur.title as role_title'
        ],
    ];


    /**
     *
     * Загрузка файла
     *
     * @param    array  $files Масив $_FILES
     * @param    array  $name Name загружаемого файла в массиве $_FILES
     * @param    array  $current_user авторизованый пользователь
     * @param    object  $post доп. информация передоваемая через $_POST
     * @param    string  $validate_ext разрешенные форматы через запятую
     * @return   array
     *
     */

    public function upload_file($files, $name, $current_user, $post = [], $validate_ext = 'png,jpg,jpeg,gif,pdf,zip,mp3,mp4,avi,rar,doc,docx,xls,xlsx,csv,html,dot,txt,bmp,pot,potx,ppa,ppt,rtf,wmv,xml,PNG,JPG,JPEG,GIF,PDF,ZIP,MP3,MP4,AVI,RAR,DOC,DOCX,XLS,XLSX,CSV,HTML,DOT,TXT,BMP,POT,POTX,PPA,PPT,RTF,WMV,XML'){

        if(isset($files[$name])){
            if($file = $files[$name] ){
                if ($file->isValid() && ! $file->hasMoved()){
                    $type = $file->getClientExtension();
                    $validate_rules = explode(',', $validate_ext);
                    if(in_array($type, $validate_rules)){
                        if(isset($current_user['errors'])){
                            return $this->respond(['errors' => ['user_id'=>'Пользователь не найден.']], 423);
                        } else {
                            $path_download = WRITEPATH.'uploads/'.date('d_m_Y');
                            $newName = $file->getRandomName();
                            $file->move($path_download, $newName);

                            $url_file = 'writable/uploads/'.date('d_m_Y').'/'.$file->getName();
                            $msg['url'] = 'Saved: '.$url_file;
                            $data_insert = [
                                'name' => $file->getClientName(),
                                'path' => $url_file,
                                'type' => $file->getClientExtension(),
                                'mime_type' => $file->getClientMimeType(),
                                'date_create' => time(),
                                'size' => $file->getSize(),
                                'user_id' => $current_user['info']['user']['id'],
                                'server' => base_url(),
                                'post_type' => @$post->post_type,
                                'post_id' => @$post->post_id,
                                'comment' => @$post->comment,
                            ];

                            $data_insert['id'] = $this->insert($data_insert);
                            $return = ['data'=>$data_insert, 'code'=>200];
                            return $return;
                        }
                    } else {
                        $return = ['data'=>['errors' => ['file'=>'Не допустимый тип файла.']], 'code'=>423];
                        return $return;
                    }
                } else {
                    $return = ['data'=>['errors' => ['file'=>$file->getErrorString().'('.$file->getError().')']], 'code'=>423];
                    return $return;
                }
            } else {
                $return = ['data'=>['errors' => ['file'=>'Файл не найден.']], 'code'=>423];
                return $return;
            }
        } else {
            $return = ['data'=>['errors' => ['file'=>'Файл не найден.']], 'code'=>423];
            return $return;
        }

    }

    public function get_avatars($comments){
        if(!empty($comments) and is_array($comments)){
            foreach ($comments as $comment_key => $comment) {
                $avatar = $this->find_id($comment['user_photo']);
                //echo "<pre>"; print_r($avatar); echo "</pre>";
                if(!empty($avatar) and !empty(@$avatar['path'])){
                    $comments[$comment_key]['photo_path'] = @$avatar['path'];
                    $comments[$comment_key]['photo_server'] = @$avatar['server'];
                } else {
                    $comments[$comment_key]['photo_path'] = 'writable/uploads/image-empty.jpg';
                    $comments[$comment_key]['photo_server'] = base_url();
                }
            }
            return $comments;
        } else {
            return false;
        }
    }

}
