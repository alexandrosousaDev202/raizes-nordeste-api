<?php

use yii\db\Migration;

/**
 * Class m260502_XXXXXX_create_tabelas_iniciais
 * (Mantenha o nome da classe que o Yii2 gerou no seu arquivo original, só substitua o que está dentro!)
 */
class m260502_171528_create_tabelas_iniciais extends Migration // <-- ATENÇÃO: NÃO MUDE O NOME DA CLASSE AQUI
{
    public function safeUp()
    {
        // 1. usuario
        $this->createTable('usuario', [
            'id' => $this->primaryKey(),
            'nome' => $this->string(255)->notNull(),
            'email' => $this->string(255)->unique()->notNull(),
            'senha_hash' => $this->string(255)->notNull(),
            'perfil' => $this->string(50)->notNull(),
            'cpf' => $this->string(14),
            'criado_em' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // 2. unidade
        $this->createTable('unidade', [
            'id' => $this->primaryKey(),
            'nome' => $this->string(255)->notNull(),
            'endereco' => $this->string(255),
            'ativa' => $this->boolean(),
        ]);

        // 3. produto
        $this->createTable('produto', [
            'id' => $this->primaryKey(),
            'nome' => $this->string(255)->notNull(),
            'descricao' => $this->text(),
            'preco' => $this->decimal(10, 2)->notNull(),
            'ativo' => $this->boolean(),
        ]);

        // 4. estoque_unidade (Tabela associativa com PK composta)
        $this->createTable('estoque_unidade', [
            'unidade_id' => $this->integer()->notNull(),
            'produto_id' => $this->integer()->notNull(),
            'quantidade_disponivel' => $this->integer()->defaultValue(0),
            'atualizado_em' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
        $this->addPrimaryKey('pk-estoque_unidade', 'estoque_unidade', ['unidade_id', 'produto_id']);
        $this->addForeignKey('fk-estoque-unidade', 'estoque_unidade', 'unidade_id', 'unidade', 'id');
        $this->addForeignKey('fk-estoque-produto', 'estoque_unidade', 'produto_id', 'produto', 'id');

        // 5. pedido
        $this->createTable('pedido', [
            'id' => $this->primaryKey(),
            'usuario_id' => $this->integer()->notNull(),
            'unidade_id' => $this->integer()->notNull(),
            'canal_pedido' => $this->string(50)->notNull(),
            'status' => $this->string(50)->notNull(),
            'valor_total' => $this->decimal(10, 2)->notNull(),
            'criado_em' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
        $this->addForeignKey('fk-pedido-usuario', 'pedido', 'usuario_id', 'usuario', 'id');
        $this->addForeignKey('fk-pedido-unidade', 'pedido', 'unidade_id', 'unidade', 'id');

        // 6. pedido_item (Tabela associativa com PK composta)
        $this->createTable('pedido_item', [
            'pedido_id' => $this->integer()->notNull(),
            'produto_id' => $this->integer()->notNull(),
            'quantidade' => $this->integer()->notNull(),
            'preco_unitario' => $this->decimal(10, 2)->notNull(),
        ]);
        $this->addPrimaryKey('pk-pedido_item', 'pedido_item', ['pedido_id', 'produto_id']);
        $this->addForeignKey('fk-item-pedido', 'pedido_item', 'pedido_id', 'pedido', 'id');
        $this->addForeignKey('fk-item-produto', 'pedido_item', 'produto_id', 'produto', 'id');

        // 7. pagamento_mock
        $this->createTable('pagamento_mock', [
            'id' => $this->primaryKey(),
            'pedido_id' => $this->integer()->notNull(),
            'metodo' => $this->string(50)->notNull(),
            'status_transacao' => $this->string(50)->notNull(),
            'payload_retorno' => $this->text(),
            'criado_em' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
        $this->addForeignKey('fk-pagamento-pedido', 'pagamento_mock', 'pedido_id', 'pedido', 'id');

        // 8. fidelidade
        $this->createTable('fidelidade', [
            'usuario_id' => $this->integer()->notNull(),
            'saldo_pontos' => $this->integer()->defaultValue(0),
            'aceita_termos_lgpd' => $this->boolean(),
        ]);
        $this->addPrimaryKey('pk-fidelidade', 'fidelidade', 'usuario_id');
        $this->addForeignKey('fk-fidelidade-usuario', 'fidelidade', 'usuario_id', 'usuario', 'id');
    }

    public function safeDown()
    {
        // A função safeDown desfaz o que a safeUp fez, na ordem inversa para não quebrar as chaves estrangeiras.
        $this->dropTable('fidelidade');
        $this->dropTable('pagamento_mock');
        $this->dropTable('pedido_item');
        $this->dropTable('pedido');
        $this->dropTable('estoque_unidade');
        $this->dropTable('produto');
        $this->dropTable('unidade');
        $this->dropTable('usuario');
    }
}