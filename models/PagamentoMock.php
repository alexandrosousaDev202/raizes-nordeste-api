<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pagamento_mock".
 *
 * @property int $id
 * @property int $pedido_id
 * @property string $metodo
 * @property string $status_transacao
 * @property string|null $payload_retorno
 * @property string|null $criado_em
 *
 * @property Pedido $pedido
 */
class PagamentoMock extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pagamento_mock';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['payload_retorno'], 'default', 'value' => null],
            [['pedido_id', 'metodo', 'status_transacao'], 'required'],
            [['pedido_id'], 'default', 'value' => null],
            [['pedido_id'], 'integer'],
            [['payload_retorno'], 'string'],
            [['criado_em'], 'safe'],
            [['metodo', 'status_transacao'], 'string', 'max' => 50],
            [['pedido_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pedido::class, 'targetAttribute' => ['pedido_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pedido_id' => 'Pedido ID',
            'metodo' => 'Metodo',
            'status_transacao' => 'Status Transacao',
            'payload_retorno' => 'Payload Retorno',
            'criado_em' => 'Criado Em',
        ];
    }

    /**
     * Gets query for [[Pedido]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPedido()
    {
        return $this->hasOne(Pedido::class, ['id' => 'pedido_id']);
    }

}
