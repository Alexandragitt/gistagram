<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class UploadForm extends Model {
   
    public $image;
    
    
    public function rules() {
        return [
            ['image', 'required'],
            ['image', 'image'],
        ];
    }
    
    public function upload(\yii\web\UploadedFile $file) {
       return $file->saveAs($this->getFolder() . $this->generateName($file));
    }
    
    public function hash($name) {
        return md5($name);
    }
    
    public function getFolder() {
        return Yii::getAlias("@webroot") . '/uploads/';
    }
    
    public function generateName(\yii\web\UploadedFile $file) {
        return $this->hash($file->baseName) . '.' . $file->extension; 
    }
    
    
    
    
}
