<?php

namespace app\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\HttpBearerAuth;

class PagamentoMockController extends ActiveController
{
    public $modelClass = 'app\models\PagamentoMock';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
        ];
        
        return $behaviors;
    }
}