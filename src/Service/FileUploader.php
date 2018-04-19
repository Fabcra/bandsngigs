<?php
/**
 * Created by PhpStorm.
 * User: Fab
 * Date: 19/04/18
 * Time: 17:44
 */

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private $targetDir;

    public function __construct($targetDir)
    {
        $this->targetDir=$targetDir;
    }

    public function upload(UploadedFile $file){

        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        $file->move($this->getTargetDir(), $fileName);

        return $fileName;
    }

    public function getTargetDir(){

        return $this->targetDir;
    }

}