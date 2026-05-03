<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "unidade".
 *
 * @property int $id
 * @property string $nome
 * @property string|null $endereco
 * @property bool|null $ativa
 *
 * @property EstoqueUnidade[] $estoqueUnidades
 * @property Pedido[] $pedidos
 * @property Produto[] $produtos
 */
class Unidade extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'unidade';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['endereco', 'ativa'], 'default', 'value' => null],
            [['nome'], 'required'],
            [['ativa'], 'boolean'],
            [['nome', 'endereco'], 'string', 'max' => 255],
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
            'endereco' => 'Endereco',
            'ativa' => 'Ativa',
        ];
    }

    /**
     * Gets query for [[EstoqueUnidades]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEstoqueUnidades()
    {
        return $this->hasMany(EstoqueUnidade::class, ['unidade_id' => 'id']);
    }

    /**
     * Gets query for [[Pedidos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPedidos()
    {
        return $this->hasMany(Pedido::class, ['unidade_id' => 'id']);
    }

    /**
     * Gets query for [[Produtos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProdutos()
    {
        return $this->hasMany(Produto::class, ['id' => 'produto_id'])->viaTable('estoque_unidade', ['unidade_id' => 'id']);
    }

}
