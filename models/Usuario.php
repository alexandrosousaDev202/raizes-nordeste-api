<?php

namespace app\models;
use yii\web\IdentityInterface;
use Lcobucci\JWT\Validation\Constraint\SignedWith;

use Yii;

/**
 * This is the model class for table "usuario".
 *
 * @property int $id
 * @property string $nome
 * @property string $email
 * @property string $senha_hash
 * @property string $perfil
 * @property string|null $cpf
 * @property string|null $criado_em
 *
 * @property Fidelidade $fidelidade
 * @property Pedido[] $pedidos
 */
class Usuario extends \yii\db\ActiveRecord implements IdentityInterface
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cpf'], 'default', 'value' => null],
            [['nome', 'email', 'senha_hash', 'perfil'], 'required'],
            [['criado_em'], 'safe'],
            [['nome', 'email', 'senha_hash'], 'string', 'max' => 255],
            [['perfil'], 'string', 'max' => 50],
            [['cpf'], 'string', 'max' => 14],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
            'email' => 'Email',
            'senha_hash' => 'Senha Hash',
            'perfil' => 'Perfil',
            'cpf' => 'Cpf',
            'criado_em' => 'Criado Em',
        ];
    }

    /**
     * Gets query for [[Fidelidade]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFidelidade()
    {
        return $this->hasOne(Fidelidade::class, ['usuario_id' => 'id']);
    }

    /**
     * Gets query for [[Pedidos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPedidos()
    {
        return $this->hasMany(Pedido::class, ['usuario_id' => 'id']);
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

  public static function findIdentityByAccessToken($token, $type = null)
    {
        try {
            $jwt = \Yii::$app->jwt;
            
            $parsedToken = $jwt->parse((string) $token);
            
            $signer = $jwt->getConfiguration()->signer();
            $key = $jwt->getConfiguration()->verificationKey();
            $regraAssinatura = new \Lcobucci\JWT\Validation\Constraint\SignedWith($signer, $key);
            
            $validator = $jwt->getConfiguration()->validator();
            $valido = $validator->validate($parsedToken, $regraAssinatura);
            
            if (!$valido) {
                return null; 
            }
            
            $uid = (int) $parsedToken->claims()->get('uid');
            return static::findOne(['id' => $uid]);
            
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return null; 
    }

    public function validateAuthKey($authKey)
    {
        return false;
    }

    public function validarSenha($senha)
    {
        return \Yii::$app->security->validatePassword($senha, $this->senha_hash);
    }

    public function fields()
    {
        $fields = parent::fields();
        
        unset($fields['senha_hash']);
        unset($fields['cpf']);
        
        return $fields;
    }

}
