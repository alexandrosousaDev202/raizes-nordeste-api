<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pedido_item".
 *
 * @property int $pedido_id
 * @property int $produto_id
 * @property int $quantidade
 * @property float $preco_unitario
 *
 * @property Pedido $pedido
 * @property Produto $produto
 */
class PedidoItem extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pedido_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pedido_id', 'produto_id', 'quantidade', 'preco_unitario'], 'required'],
            [['pedido_id', 'produto_id', 'quantidade'], 'default', 'value' => null],
            [['pedido_id', 'produto_id', 'quantidade'], 'integer'],
            [['preco_unitario'], 'number'],
            [['pedido_id', 'produto_id'], 'unique', 'targetAttribute' => ['pedido_id', 'produto_id']],
            [['pedido_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pedido::class, 'targetAttribute' => ['pedido_id' => 'id']],
            [['produto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Produto::class, 'targetAttribute' => ['produto_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pedido_id' => 'Pedido ID',
            'produto_id' => 'Produto ID',
            'quantidade' => 'Quantidade',
            'preco_unitario' => 'Preco Unitario',
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

    /**
     * Gets query for [[Produto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduto()
    {
        return $this->hasOne(Produto::class, ['id' => 'produto_id']);
    }

}
