<?php

namespace app\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\HttpBearerAuth;

class UnidadeController extends ActiveController
{
    public $modelClass = 'app\models\Unidade';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class, 
        ];
        
        return $behaviors;
    }
}