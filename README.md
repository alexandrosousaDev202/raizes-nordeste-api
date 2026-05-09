# 🍔 API Raízes do Nordeste - Projeto Multidisciplinar

Solução de Back-end desenvolvida em PHP com Yii2 para a rede de lanchonetes "Raízes do Nordeste". Este projeto atende aos requisitos de multicanalidade, controle de estoque distribuído por unidades e integração com mock de pagamento, conforme o escopo da disciplina de Análise e Desenvolvimento de Sistemas.

## 🛠️ Tecnologias e Requisitos

* **Linguagem:** PHP >= 8.1
* **Framework:** Yii2 (Basic Template)
* **Banco de Dados:** PostgreSQL >= 13
* **Hospedagem:** Render (API) e Vercel (Front-end)
* **Gerenciador de Dependências:** Composer

---

## 🚀 Ambiente de Produção (Live)

O projeto está hospedado em nuvem para facilitar os testes, avaliações e validações arquiteturais.

* **Front-end (Vercel):** `[https://raizes-nordeste-api.vercel.app]`
* **Back-end API (Render):** `[https://raizes-nordeste-api.onrender.com]`
* **Banco de Dados:** PostgreSQL hospedado no Neon DB.

> **⚠️ Nota Importante para Testes:** Como a API está hospedada no plano gratuito do Render, o servidor pode entrar em modo de suspensão (sleep) após períodos de inatividade. O primeiro acesso pode levar cerca de 15 a 30 segundos devido ao *cold start*. Os acessos subsequentes ocorrerão em velocidade normal.

---

## ⚙️ Como rodar o projeto localmente

Para fins de desenvolvimento e avaliação do código-fonte, siga os passos abaixo para configurar o ambiente local:

**1. Clone o repositório e instale as dependências:**
```bash
git clone https://github.com/alexandrosousaDev202/raizes-nordeste-api
cd raizes-nordeste-api
composer install
2. Configure as variáveis de ambiente:
Crie um arquivo .env na raiz do projeto (use o .env.example como base, se houver) e configure as credenciais do seu banco de dados PostgreSQL local:

Snippet de código
DB_DSN=pgsql:host=localhost;port=5432;dbname=raizes_nordeste
DB_USER=seu_usuario
DB_PASSWORD=sua_senha
JWT_SECRET=sua_chave
3. Execute as Migrations (Estrutura do Banco):

Bash
php yii migrate
4. Inicie o servidor embutido do PHP:

Bash
php yii serve --port=8080
A API estará disponível em http://localhost:8080.

💾 Backup do Banco de Dados (Dump)
Para facilitar a avaliação e os testes sem a necessidade de rodar as migrations e popular as tabelas manualmente, um dump completo do banco de dados foi disponibilizado.

Navegue até a pasta /database na raiz do projeto.

Importe o arquivo raizes_nordeste_dump.sql no seu SGBD (DBeaver, pgAdmin, etc) para um banco PostgreSQL.

Este dump já contém:

Estrutura completa de tabelas e relacionamentos.

Produtos pré-cadastrados (Acarajé, Tapioca, etc) com URLs de imagens válidas.

Unidades da lanchonete cadastradas para teste de estoque.

Um usuário com perfil de admin para testes de autenticação.

🏗️ Arquitetura e Padrões
Para garantir a manutenção, escalabilidade e a clareza das regras de negócio, a API foi estruturada em camadas:

Domain (Domínio): Representada pelas classes ActiveRecord. Mapeia as tabelas, define relacionamentos e aplica validações estritas de dados.

Application (Aplicação): Regras de negócio complexas centralizadas em classes de serviço (ex: PedidoService), orquestrando estoque e pagamentos.

Infrastructure (Infraestrutura): Migrations e clientes HTTP para comunicação com a API simulada (Mock) de pagamentos.

API (Controllers): Controladores RESTful responsáveis por receber requisições, validar tokens JWT, aplicar regras de CORS (habilitadas para Vercel e Localhost) e serializar respostas em JSON.

🔒 Segurança e Autenticação
JWT (JSON Web Token): A API utiliza autenticação Stateless. O acesso aos endpoints é controlado por perfis de usuário, garantindo autorização correta para ações sensíveis.

CORS: Configurado para aceitar requisições estritas das origens confiáveis (localhost e Vercel).

Proteção de Dados (LGPD): Implementação de aceite de termos para acúmulo de pontos de fidelidade e senhas protegidas com algoritmo de hashing seguro (BCrypt).

🧪 Testes e Endpoints
Uma coleção completa do Postman está disponível na pasta /docs (ou anexa ao projeto) com todos os cenários de testes de integração pré-configurados, incluindo:

POST /auth/login (Geração de Token)

POST /pedidos (Criação de pedido com validação de estoque e multicanalidade)

GET /unidades/{id}/produtos (Listagem de cardápio)

POST /pagamentos/mock (Simulação de Gateway de Pagamento)

Projeto acadêmico desenvolvido por Alexandro Sousa de Brito - 3º Semestre.
