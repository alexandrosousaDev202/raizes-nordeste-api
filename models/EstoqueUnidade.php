<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "estoque_unidade".
 *
 * @property int $unidade_id
 * @property int $produto_id
 * @property int|null $quantidade_disponivel
 * @property string|null $atualizado_em
 *
 * @property Produto $produto
 * @property Unidade $unidade
 */
class EstoqueUnidade extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'estoque_unidade';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quantidade_disponivel'], 'default', 'value' => 0],
            [['unidade_id', 'produto_id'], 'required'],
            [['unidade_id', 'produto_id', 'quantidade_disponivel'], 'default', 'value' => null],
            [['unidade_id', 'produto_id', 'quantidade_disponivel'], 'integer'],
            [['atualizado_em'], 'safe'],
            [['unidade_id', 'produto_id'], 'unique', 'targetAttribute' => ['unidade_id', 'produto_id']],
            [['produto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Produto::class, 'targetAttribute' => ['produto_id' => 'id']],
            [['unidade_id'], 'exist', 'skipOnError' => true, 'targetClass' => Unidade::class, 'targetAttribute' => ['unidade_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'unidade_id' => 'Unidade ID',
            'produto_id' => 'Produto ID',
            'quantidade_disponivel' => 'Quantidade Disponivel',
            'atualizado_em' => 'Atualizado Em',
        ];
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

    /**
     * Gets query for [[Unidade]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUnidade()
    {
        return $this->hasOne(Unidade::class, ['id' => 'unidade_id']);
    }

}
