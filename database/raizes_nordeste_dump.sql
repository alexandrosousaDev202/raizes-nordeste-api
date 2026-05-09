--
-- PostgreSQL database dump
--

-- Dumped from database version 15.16 (2e05eff)
-- Dumped by pg_dump version 15.3

-- Started on 2026-05-09 10:06:08

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 4 (class 2615 OID 2200)
-- Name: public; Type: SCHEMA; Schema: -; Owner: pg_database_owner
--

CREATE SCHEMA public;


ALTER SCHEMA public OWNER TO pg_database_owner;

--
-- TOC entry 3412 (class 0 OID 0)
-- Dependencies: 4
-- Name: SCHEMA public; Type: COMMENT; Schema: -; Owner: pg_database_owner
--

COMMENT ON SCHEMA public IS 'standard public schema';


SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 221 (class 1259 OID 24611)
-- Name: estoque_unidade; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.estoque_unidade (
    unidade_id integer NOT NULL,
    produto_id integer NOT NULL,
    quantidade_disponivel integer DEFAULT 0,
    atualizado_em timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.estoque_unidade OWNER TO neondb_owner;

--
-- TOC entry 227 (class 1259 OID 24676)
-- Name: fidelidade; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.fidelidade (
    usuario_id integer NOT NULL,
    saldo_pontos integer DEFAULT 0,
    aceita_termos_lgpd boolean
);


ALTER TABLE public.fidelidade OWNER TO neondb_owner;

--
-- TOC entry 214 (class 1259 OID 24576)
-- Name: migration; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.migration (
    version character varying(180) NOT NULL,
    apply_time integer
);


ALTER TABLE public.migration OWNER TO neondb_owner;

--
-- TOC entry 226 (class 1259 OID 24662)
-- Name: pagamento_mock; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.pagamento_mock (
    id integer NOT NULL,
    pedido_id integer NOT NULL,
    metodo character varying(50) NOT NULL,
    status_transacao character varying(50) NOT NULL,
    payload_retorno text,
    criado_em timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.pagamento_mock OWNER TO neondb_owner;

--
-- TOC entry 225 (class 1259 OID 24661)
-- Name: pagamento_mock_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.pagamento_mock_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.pagamento_mock_id_seq OWNER TO neondb_owner;

--
-- TOC entry 3413 (class 0 OID 0)
-- Dependencies: 225
-- Name: pagamento_mock_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.pagamento_mock_id_seq OWNED BY public.pagamento_mock.id;


--
-- TOC entry 223 (class 1259 OID 24629)
-- Name: pedido; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.pedido (
    id integer NOT NULL,
    usuario_id integer NOT NULL,
    unidade_id integer NOT NULL,
    canal_pedido character varying(50) NOT NULL,
    status character varying(50) NOT NULL,
    valor_total numeric(10,2) NOT NULL,
    criado_em timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.pedido OWNER TO neondb_owner;

--
-- TOC entry 222 (class 1259 OID 24628)
-- Name: pedido_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.pedido_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.pedido_id_seq OWNER TO neondb_owner;

--
-- TOC entry 3414 (class 0 OID 0)
-- Dependencies: 222
-- Name: pedido_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.pedido_id_seq OWNED BY public.pedido.id;


--
-- TOC entry 224 (class 1259 OID 24646)
-- Name: pedido_item; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.pedido_item (
    pedido_id integer NOT NULL,
    produto_id integer NOT NULL,
    quantidade integer NOT NULL,
    preco_unitario numeric(10,2) NOT NULL
);


ALTER TABLE public.pedido_item OWNER TO neondb_owner;

--
-- TOC entry 220 (class 1259 OID 24603)
-- Name: produto; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.produto (
    id integer NOT NULL,
    nome character varying(255) NOT NULL,
    descricao text,
    preco numeric(10,2) NOT NULL,
    ativo boolean,
    imagem_url text
);


ALTER TABLE public.produto OWNER TO neondb_owner;

--
-- TOC entry 219 (class 1259 OID 24602)
-- Name: produto_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.produto_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.produto_id_seq OWNER TO neondb_owner;

--
-- TOC entry 3415 (class 0 OID 0)
-- Dependencies: 219
-- Name: produto_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.produto_id_seq OWNED BY public.produto.id;


--
-- TOC entry 218 (class 1259 OID 24594)
-- Name: unidade; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.unidade (
    id integer NOT NULL,
    nome character varying(255) NOT NULL,
    endereco character varying(255),
    ativa boolean
);


ALTER TABLE public.unidade OWNER TO neondb_owner;

--
-- TOC entry 217 (class 1259 OID 24593)
-- Name: unidade_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.unidade_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.unidade_id_seq OWNER TO neondb_owner;

--
-- TOC entry 3416 (class 0 OID 0)
-- Dependencies: 217
-- Name: unidade_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.unidade_id_seq OWNED BY public.unidade.id;


--
-- TOC entry 216 (class 1259 OID 24582)
-- Name: usuario; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.usuario (
    id integer NOT NULL,
    nome character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    senha_hash character varying(255) NOT NULL,
    perfil character varying(50) NOT NULL,
    cpf character varying(14),
    criado_em timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.usuario OWNER TO neondb_owner;

--
-- TOC entry 215 (class 1259 OID 24581)
-- Name: usuario_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.usuario_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.usuario_id_seq OWNER TO neondb_owner;

--
-- TOC entry 3417 (class 0 OID 0)
-- Dependencies: 215
-- Name: usuario_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.usuario_id_seq OWNED BY public.usuario.id;


--
-- TOC entry 3220 (class 2604 OID 24665)
-- Name: pagamento_mock id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.pagamento_mock ALTER COLUMN id SET DEFAULT nextval('public.pagamento_mock_id_seq'::regclass);


--
-- TOC entry 3218 (class 2604 OID 24632)
-- Name: pedido id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.pedido ALTER COLUMN id SET DEFAULT nextval('public.pedido_id_seq'::regclass);


--
-- TOC entry 3215 (class 2604 OID 24606)
-- Name: produto id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.produto ALTER COLUMN id SET DEFAULT nextval('public.produto_id_seq'::regclass);


--
-- TOC entry 3214 (class 2604 OID 24597)
-- Name: unidade id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.unidade ALTER COLUMN id SET DEFAULT nextval('public.unidade_id_seq'::regclass);


--
-- TOC entry 3212 (class 2604 OID 24585)
-- Name: usuario id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.usuario ALTER COLUMN id SET DEFAULT nextval('public.usuario_id_seq'::regclass);


--
-- TOC entry 3400 (class 0 OID 24611)
-- Dependencies: 221
-- Data for Name: estoque_unidade; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.estoque_unidade (unidade_id, produto_id, quantidade_disponivel, atualizado_em) FROM stdin;
\.


--
-- TOC entry 3406 (class 0 OID 24676)
-- Dependencies: 227
-- Data for Name: fidelidade; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.fidelidade (usuario_id, saldo_pontos, aceita_termos_lgpd) FROM stdin;
\.


--
-- TOC entry 3393 (class 0 OID 24576)
-- Dependencies: 214
-- Data for Name: migration; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.migration (version, apply_time) FROM stdin;
m000000_000000_base	1778179572
m260502_171528_create_tabelas_iniciais	1778179584
\.


--
-- TOC entry 3405 (class 0 OID 24662)
-- Dependencies: 226
-- Data for Name: pagamento_mock; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.pagamento_mock (id, pedido_id, metodo, status_transacao, payload_retorno, criado_em) FROM stdin;
\.


--
-- TOC entry 3402 (class 0 OID 24629)
-- Dependencies: 223
-- Data for Name: pedido; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.pedido (id, usuario_id, unidade_id, canal_pedido, status, valor_total, criado_em) FROM stdin;
1	1	1	web	pendente	18.50	2026-05-07 18:55:27
2	1	1	web	pendente	18.50	2026-05-07 18:55:35
3	1	1	web	pendente	18.50	2026-05-07 18:55:40
4	1	1	web	pendente	18.50	2026-05-07 18:55:44
5	1	1	web	pendente	18.50	2026-05-07 18:55:49
6	1	1	web	pendente	35.90	2026-05-08 12:45:34
7	1	1	web	pendente	35.90	2026-05-08 12:46:07
8	1	1	web	pendente	18.50	2026-05-08 12:54:53
9	1	1	web	pendente	18.50	2026-05-08 17:30:35
10	1	1	web	pendente	22.50	2026-05-08 17:56:50
11	1	1	web	pendente	25.00	2026-05-08 17:59:00
12	1	1	web	pendente	18.50	2026-05-08 18:20:50
13	1	1	web	pendente	18.50	2026-05-08 18:20:53
14	1	1	web	pendente	25.00	2026-05-09 02:21:14
15	1	1	web	pendente	25.00	2026-05-09 02:21:20
\.


--
-- TOC entry 3403 (class 0 OID 24646)
-- Dependencies: 224
-- Data for Name: pedido_item; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.pedido_item (pedido_id, produto_id, quantidade, preco_unitario) FROM stdin;
1	1	1	18.50
2	1	1	18.50
3	1	1	18.50
4	1	1	18.50
5	1	1	18.50
8	1	1	18.50
9	1	1	18.50
10	3	1	22.50
11	4	1	25.00
13	1	1	18.50
12	1	1	18.50
14	4	1	25.00
15	4	1	25.00
\.


--
-- TOC entry 3399 (class 0 OID 24603)
-- Dependencies: 220
-- Data for Name: produto; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.produto (id, nome, descricao, preco, ativo, imagem_url) FROM stdin;
4	Acarajé Tradicional	Bolinho de feijão fradinho frito no azeite de dendê, recheado com vatapá, caruru, camarão seco e vinagrete.	25.00	t	/pratos/acaraje.jpg
2	Baião de Dois Completo	Mistura clássica de arroz, feijão de corda, queijo coalho, bacon e calabresa. Acompanha farofa.	35.90	t	/pratos/baiao-de-dois.webp
1	Tapioca de Carne de Sol com Queijo Coalho	Massa fina de tapioca recheada com suculenta carne de sol desfiada e queijo coalho derretido.	18.50	t	/pratos/tapioca.avif
3	Cuscuz com Charque	Cuscuz de milho fofinho acompanhado de charque desfiada e acebolada com um toque de manteiga de garrafa.	22.50	t	/pratos/cuscuz.png
\.


--
-- TOC entry 3397 (class 0 OID 24594)
-- Dependencies: 218
-- Data for Name: unidade; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.unidade (id, nome, endereco, ativa) FROM stdin;
1	Raízes do Nordeste - Matriz	\N	\N
\.


--
-- TOC entry 3395 (class 0 OID 24582)
-- Dependencies: 216
-- Data for Name: usuario; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.usuario (id, nome, email, senha_hash, perfil, cpf, criado_em) FROM stdin;
1	Cliente Web	cliente@web.com	sem_senha	cliente	\N	2026-05-07 18:53:18
\.


--
-- TOC entry 3418 (class 0 OID 0)
-- Dependencies: 225
-- Name: pagamento_mock_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.pagamento_mock_id_seq', 1, false);


--
-- TOC entry 3419 (class 0 OID 0)
-- Dependencies: 222
-- Name: pedido_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.pedido_id_seq', 15, true);


--
-- TOC entry 3420 (class 0 OID 0)
-- Dependencies: 219
-- Name: produto_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.produto_id_seq', 4, true);


--
-- TOC entry 3421 (class 0 OID 0)
-- Dependencies: 217
-- Name: unidade_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.unidade_id_seq', 1, false);


--
-- TOC entry 3422 (class 0 OID 0)
-- Dependencies: 215
-- Name: usuario_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.usuario_id_seq', 1, true);


--
-- TOC entry 3224 (class 2606 OID 24580)
-- Name: migration migration_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.migration
    ADD CONSTRAINT migration_pkey PRIMARY KEY (version);


--
-- TOC entry 3240 (class 2606 OID 24670)
-- Name: pagamento_mock pagamento_mock_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.pagamento_mock
    ADD CONSTRAINT pagamento_mock_pkey PRIMARY KEY (id);


--
-- TOC entry 3236 (class 2606 OID 24635)
-- Name: pedido pedido_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.pedido
    ADD CONSTRAINT pedido_pkey PRIMARY KEY (id);


--
-- TOC entry 3234 (class 2606 OID 24617)
-- Name: estoque_unidade pk-estoque_unidade; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.estoque_unidade
    ADD CONSTRAINT "pk-estoque_unidade" PRIMARY KEY (unidade_id, produto_id);


--
-- TOC entry 3242 (class 2606 OID 24681)
-- Name: fidelidade pk-fidelidade; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.fidelidade
    ADD CONSTRAINT "pk-fidelidade" PRIMARY KEY (usuario_id);


--
-- TOC entry 3238 (class 2606 OID 24650)
-- Name: pedido_item pk-pedido_item; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.pedido_item
    ADD CONSTRAINT "pk-pedido_item" PRIMARY KEY (pedido_id, produto_id);


--
-- TOC entry 3232 (class 2606 OID 24610)
-- Name: produto produto_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.produto
    ADD CONSTRAINT produto_pkey PRIMARY KEY (id);


--
-- TOC entry 3230 (class 2606 OID 24601)
-- Name: unidade unidade_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.unidade
    ADD CONSTRAINT unidade_pkey PRIMARY KEY (id);


--
-- TOC entry 3226 (class 2606 OID 24592)
-- Name: usuario usuario_email_key; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.usuario
    ADD CONSTRAINT usuario_email_key UNIQUE (email);


--
-- TOC entry 3228 (class 2606 OID 24590)
-- Name: usuario usuario_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.usuario
    ADD CONSTRAINT usuario_pkey PRIMARY KEY (id);


--
-- TOC entry 3243 (class 2606 OID 24623)
-- Name: estoque_unidade fk-estoque-produto; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.estoque_unidade
    ADD CONSTRAINT "fk-estoque-produto" FOREIGN KEY (produto_id) REFERENCES public.produto(id);


--
-- TOC entry 3244 (class 2606 OID 24618)
-- Name: estoque_unidade fk-estoque-unidade; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.estoque_unidade
    ADD CONSTRAINT "fk-estoque-unidade" FOREIGN KEY (unidade_id) REFERENCES public.unidade(id);


--
-- TOC entry 3250 (class 2606 OID 24682)
-- Name: fidelidade fk-fidelidade-usuario; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.fidelidade
    ADD CONSTRAINT "fk-fidelidade-usuario" FOREIGN KEY (usuario_id) REFERENCES public.usuario(id);


--
-- TOC entry 3247 (class 2606 OID 24651)
-- Name: pedido_item fk-item-pedido; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.pedido_item
    ADD CONSTRAINT "fk-item-pedido" FOREIGN KEY (pedido_id) REFERENCES public.pedido(id);


--
-- TOC entry 3248 (class 2606 OID 24656)
-- Name: pedido_item fk-item-produto; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.pedido_item
    ADD CONSTRAINT "fk-item-produto" FOREIGN KEY (produto_id) REFERENCES public.produto(id);


--
-- TOC entry 3249 (class 2606 OID 24671)
-- Name: pagamento_mock fk-pagamento-pedido; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.pagamento_mock
    ADD CONSTRAINT "fk-pagamento-pedido" FOREIGN KEY (pedido_id) REFERENCES public.pedido(id);


--
-- TOC entry 3245 (class 2606 OID 24641)
-- Name: pedido fk-pedido-unidade; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.pedido
    ADD CONSTRAINT "fk-pedido-unidade" FOREIGN KEY (unidade_id) REFERENCES public.unidade(id);


--
-- TOC entry 3246 (class 2606 OID 24636)
-- Name: pedido fk-pedido-usuario; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.pedido
    ADD CONSTRAINT "fk-pedido-usuario" FOREIGN KEY (usuario_id) REFERENCES public.usuario(id);


--
-- TOC entry 2072 (class 826 OID 16390)
-- Name: DEFAULT PRIVILEGES FOR SEQUENCES; Type: DEFAULT ACL; Schema: public; Owner: cloud_admin
--

ALTER DEFAULT PRIVILEGES FOR ROLE cloud_admin IN SCHEMA public GRANT ALL ON SEQUENCES  TO neon_superuser WITH GRANT OPTION;


--
-- TOC entry 2071 (class 826 OID 16389)
-- Name: DEFAULT PRIVILEGES FOR TABLES; Type: DEFAULT ACL; Schema: public; Owner: cloud_admin
--

ALTER DEFAULT PRIVILEGES FOR ROLE cloud_admin IN SCHEMA public GRANT ALL ON TABLES  TO neon_superuser WITH GRANT OPTION;


-- Completed on 2026-05-09 10:06:18

--
-- PostgreSQL database dump complete
--

