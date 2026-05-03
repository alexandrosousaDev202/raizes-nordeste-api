<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "produto".
 *
 * @property int $id
 * @property string $nome
 * @property string|null $descricao
 * @property float $preco
 * @property bool|null $ativo
 *
 * @property EstoqueUnidade[] $estoqueUnidades
 * @property PedidoItem[] $pedidoItems
 * @property Pedido[] $pedidos
 * @property Unidade[] $unidades
 */
class Produto extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'produto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descricao', 'ativo'], 'default', 'value' => null],
            [['nome', 'preco'], 'required'],
            [['descricao'], 'string'],
            [['preco'], 'number'],
            [['ativo'], 'boolean'],
            [['nome'], 'string', 'max' => 255],
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
            'descricao' => 'Descricao',
            'preco' => 'Preco',
            'ativo' => 'Ativo',
        ];
    }

    /**
     * Gets query for [[EstoqueUnidades]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEstoqueUnidades()
    {
        return $this->hasMany(EstoqueUnidade::class, ['produto_id' => 'id']);
    }

    /**
     * Gets query for [[PedidoItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPedidoItems()
    {
        return $this->hasMany(PedidoItem::class, ['produto_id' => 'id']);
    }

    /**
     * Gets query for [[Pedidos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPedidos()
    {
        return $this->hasMany(Pedido::class, ['id' => 'pedido_id'])->viaTable('pedido_item', ['produto_id' => 'id']);
    }

    /**
     * Gets query for [[Unidades]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUnidades()
    {
        return $this->hasMany(Unidade::class, ['id' => 'unidade_id'])->viaTable('estoque_unidade', ['produto_id' => 'id']);
    }

}
