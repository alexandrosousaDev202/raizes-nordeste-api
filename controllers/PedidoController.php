<?php

namespace app\controllers;

use yii\rest\ActiveController;
use bizley\jwt\JwtHttpBearerAuth;

class PedidoController extends ActiveController
{
    public $modelClass = 'app\models\Pedido';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        
        $behaviors['authenticator'] = [
            'class' => JwtHttpBearerAuth::class,
        ];
        
        return $behaviors;
    }
}