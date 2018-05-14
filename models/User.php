<?php

namespace app\models;

use yii\db\ActiveRecord;
use app\models\Photo;
class User extends ActiveRecord implements \yii\web\IdentityInterface{
   
   public static function tableName() {
       return 'users';
   }
   
   public function getPhotos() {
      
       return $this->hasMany(Photo::className(), ['user_id' => 'id']);
   }
   
   public function getRelations() {
       return $this->hasMany(Relation::className(), ['second_id' => 'id']);
   }


    public function getId() {
        return $this->id;
    }


    public static function findIdentity($id) {
        return User::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null) {
        
    }

    public function getAuthKey() {
        
    }

    public function validateAuthKey($authKey) {
        
    }
    
    public static function findByLogin($login) {
        return User::find()->where(['login' => $login])->one();
    }
    
    public function validatePassword($password) {
        return ($this->password == sha1($password)) ? true : false;
    }
    
    public function setPassword($password) {
        $this->password = sha1($password);
    }
    
    public static function getRecommendUsers() {
        return User::find()->limit(3)->all();
    }
}
