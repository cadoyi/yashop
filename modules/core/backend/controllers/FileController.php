<?php

namespace core\backend\controllers;

use Yii;
use backend\controllers\Controller;
use core\models\file\Uploader;
use core\models\file\exceptions\UploadUserException;

/**
 * 处理文件上传
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class FileController extends Controller
{




    /**
     * 上传文件
     *
     * @param  string $id  上传 ID 用于获取配置信息。 
     */
    public function actionUpload($id)
    {
        $fileId = $this->request->post('file_id');
        try {
            $uploader = new Uploader($id);
            $uploader->upload('file');
            if($uploader->done()) {
                $data = [
                    'success'   => true,                        
                    'file_id'   => $fileId,
                    'data'      => [
                        'filename' => $uploader->getUploadedFilename(),
                        'url'      => (string) $uploader->getUrl(),
                    ],
                ];
            } else {
                $data = ['success' => true, 'file_id' => $fileId];
            }
            return $this->asJson($data);
        } catch(UploadUserException $e) {
            $data = [
                'success' => false,
                'message' => $e->getMessage(),
                'file_id' => $fileId,
            ];
            return $this->asJson($data);
        }
        
    }






}