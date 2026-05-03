<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fidelidade".
 *
 * @property int $usuario_id
 * @property int|null $saldo_pontos
 * @property bool|null $aceita_termos_lgpd
 *
 * @property Usuario $usuario
 */
class Fidelidade extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fidelidade';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['aceita_termos_lgpd'], 'default', 'value' => null],
            [['saldo_pontos'], 'default', 'value' => 0],
            [['usuario_id'], 'required'],
            [['usuario_id', 'saldo_pontos'], 'default', 'value' => null],
            [['usuario_id', 'saldo_pontos'], 'integer'],
            [['aceita_termos_lgpd'], 'boolean'],
            [['usuario_id'], 'unique'],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::class, 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'usuario_id' => 'Usuario ID',
            'saldo_pontos' => 'Saldo Pontos',
            'aceita_termos_lgpd' => 'Aceita Termos Lgpd',
        ];
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::class, ['id' => 'usuario_id']);
    }

}
