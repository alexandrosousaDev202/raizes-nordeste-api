<?php

namespace app\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\HttpBearerAuth;

class PedidoController extends ActiveController
{
    public $modelClass = 'app\models\Pedido';

   public function behaviors()
    {
        $behaviors = parent::behaviors();
        
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class, 
        ];
        
        return $behaviors;
    }
}