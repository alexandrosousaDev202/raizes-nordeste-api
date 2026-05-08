<?php

namespace app\controllers;

use yii\rest\ActiveController;
use yii\filters\Cors;
use app\models\PedidoItem;

class PedidoItemController extends ActiveController
{
    public $modelClass = PedidoItem::class;

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $auth = $behaviors['authenticator'] ?? null;
        if ($auth) {
            unset($behaviors['authenticator']);
        }

        $behaviors['corsFilter'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
            ],
        ];

        if ($auth) {
            $behaviors['authenticator'] = $auth;
            $behaviors['authenticator']['except'] = ['create', 'index', 'view', 'options'];
        }

        return $behaviors;
    }
}