<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pedido".
 *
 * @property int $id
 * @property int $usuario_id
 * @property int $unidade_id
 * @property string $canal_pedido
 * @property string $status
 * @property float $valor_total
 * @property string|null $criado_em
 *
 * @property PagamentoMock[] $pagamentoMocks
 * @property PedidoItem[] $pedidoItems
 * @property Produto[] $produtos
 * @property Unidade $unidade
 * @property Usuario $usuario
 */
class Pedido extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pedido';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario_id', 'unidade_id', 'canal_pedido', 'status', 'valor_total'], 'required'],
            [['usuario_id', 'unidade_id'], 'default', 'value' => null],
            [['usuario_id', 'unidade_id'], 'integer'],
            [['valor_total'], 'number'],
            [['criado_em'], 'safe'],
            [['canal_pedido', 'status'], 'string', 'max' => 50],
            [['unidade_id'], 'exist', 'skipOnError' => true, 'targetClass' => Unidade::class, 'targetAttribute' => ['unidade_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::class, 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'usuario_id' => 'Usuario ID',
            'unidade_id' => 'Unidade ID',
            'canal_pedido' => 'Canal Pedido',
            'status' => 'Status',
            'valor_total' => 'Valor Total',
            'criado_em' => 'Criado Em',
        ];
    }

    /**
     * Gets query for [[PagamentoMocks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPagamentoMocks()
    {
        return $this->hasMany(PagamentoMock::class, ['pedido_id' => 'id']);
    }

    /**
     * Gets query for [[PedidoItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPedidoItems()
    {
        return $this->hasMany(PedidoItem::class, ['pedido_id' => 'id']);
    }

    /**
     * Gets query for [[Produtos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProdutos()
    {
        return $this->hasMany(Produto::class, ['id' => 'produto_id'])->viaTable('pedido_item', ['pedido_id' => 'id']);
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

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::class, ['id' => 'usuario_id']);
    }

    public function fields()
    {
        $fields = parent::fields();
        
        $fields['cliente'] = 'usuario';
        $fields['loja'] = 'unidade';
        $fields['itens'] = 'pedidoItems';
        $fields['pagamento'] = 'pagamentoMocks';
        
        return $fields;
    }

}
