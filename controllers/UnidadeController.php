<?php

namespace app\controllers;

use yii\rest\ActiveController;
use bizley\jwt\JwtHttpBearerAuth;

class UnidadeController extends ActiveController
{
    public $modelClass = 'app\models\Unidade';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        
        $behaviors['authenticator'] = [
            'class' => JwtHttpBearerAuth::class,
        ];
        
        return $behaviors;
    }
}