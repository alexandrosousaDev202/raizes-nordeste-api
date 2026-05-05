<?php

namespace app\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\HttpBearerAuth;

class PedidoItemController extends ActiveController
{
    public $modelClass = 'app\models\PedidoItem'; 

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
        ];
        
        return $behaviors;
    }
}