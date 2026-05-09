<?php

namespace app\controllers;

use Yii;
use yii\rest\Controller;
use app\models\Usuario;

class AuthController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::class,
            'cors' => [
                'Origin' => [
                    'https://raizes-nordeste-api.vercel.app', 
                    'http://localhost:5173'
                ], 
                'Access-Control-Request-Method' => ['POST', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
            ],
        ];

        return $behaviors;
    }

    public function actionLogin()
    {
        $email = Yii::$app->request->post('email');
        $senha = Yii::$app->request->post('senha');
        

        $usuario = Usuario::findOne(['email' => $email]);

        if ($usuario && $usuario->validarSenha($senha)) {

            $agora = (new \DateTimeImmutable())->modify('-1 minute');
            $jwt = Yii::$app->jwt;

            $token = $jwt->getBuilder()
                ->issuedBy('raizes-nordeste-api')
                ->issuedAt($agora)
                ->expiresAt($agora->modify('+2 hours'))
                ->withClaim('uid', $usuario->id)
                ->getToken(
                    $jwt->getConfiguration()->signer(),
                    $jwt->getConfiguration()->signingKey()
                );

            return [
                'status' => 'sucesso',
                'token' => $token->toString()
            ];
        }

        Yii::$app->response->statusCode = 401;
        return [
            'status' => 'erro',
            'mensagem' => 'E-mail ou senha inválidos'
        ];
    }

    public function actionRegister()
    {
        $request = Yii::$app->request;

        $usuario = new Usuario();
        $usuario->nome = $request->post('nome');
        $usuario->email = $request->post('email');
        $usuario->cpf = $request->post('cpf');
        $usuario->perfil = 'admin';

        $senhaPlana = $request->post('senha');
        if ($senhaPlana) {
            $usuario->senha_hash = Yii::$app->security->generatePasswordHash($senhaPlana);
        }

        if ($usuario->save()) {
            return [
                'status' => 'sucesso',
                'mensagem' => 'Usuário cadastrado com sucesso!',
                'usuario_id' => $usuario->id
            ];
        }

        Yii::$app->response->statusCode = 400;
        return [
            'status' => 'erro',
            'erros' => $usuario->getErrors()
        ];
    }
}