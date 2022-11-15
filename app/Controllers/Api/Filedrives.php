<?php namespace App\Controllers\Api;
use App\Controllers\Api\BaseApiController;

/**
 * Class Users
 * @package App\Controllers\Api
 * @author Bagus Aditia Setiawan
 * @contact 081214069289
 * @copyright saeapplication.com
 */
class Filedrives extends BaseApiController
{
    public $modelName = '\App\Models\FileDrives';

     public function upload()
     {
        if(is_null(session()->get('logged_in'))){            
            return $this->sendResponse('No Autheticated',403,'No Autheticated');
            die;
        }
        
        if($this->request->getFile('file')){
            if($filename = $this->request->getFile('file')->getClientName()){
                $file = $this->request->getFile('file');
                $tempfile = $file->getTempName();
                $ext = $file->getClientExtension();
                $newName = $file->getRandomName();
                $mime = $file->getClientMimeType();
                $path = 'uploads';
                $file->move(WRITEPATH.$path, $newName);

                $data = [
                    'id'=>$newName, 
                    'filename'=>$newName, 
                    'path'=>$path,
                    'extension'=>$ext,
                    'mime'  => $mime
                ];

                $this->model->insert($data);
                if($this->request->getGet('type') === 'catalog_item'){
                    $data = $this->insertToCatalog($id);
                }
                return $this->sendResponse($data, 200, 'Successfully insert');

            }
        }
        return $this->sendResponse(['file'=>'file required'], 400, 'Failed');
     }

     public function insertToCatalog($id)
     {
         $attachment = new \App\Models\Catalogs\Items\Attachments();
         $attachment->save([
             'id_catalog_item'  => $this->request->getGet('id_catalog_item') ?  $this->request->getGet('id_catalog_item') : 0 ,
             'id_file_drive'    => $id
         ]);
         $attachment->select('catalogs_items_attachments.*, filename, mime')->join('file_drives','file_drives.id = catalogs_items_attachments.id_file_drive');
         return $attachment->find($attachment->getInsertID());
     }

     public function show($id = null)
     {
        $find = $this->model->find($id);
        if(($image = file_get_contents(WRITEPATH.'uploads/'.$find->filename)) === FALSE)
        show_404();

    // choose the right mime type video/mp4
        $mimeType = $find->mime ? $find->mime : 'image/jpg';

        return $this->response
            ->setStatusCode(200)
            ->setContentType($mimeType)
            ->setBody($image)
            ->send();
     }
    //--------------------------------------------------------------------

}
