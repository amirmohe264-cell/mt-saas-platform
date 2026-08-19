--
-- PostgreSQL database dump
--

\restrict Ep17rhaY23nGpgBuVYhw6VWLgQMNhw3pyBjUidXqecuhzaaQASMcJDxtpK0pvX9

-- Dumped from database version 16.14
-- Dumped by pg_dump version 16.14

-- Started on 2026-08-19 20:49:53

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

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 232 (class 1259 OID 17008)
-- Name: cart; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cart (
    id integer NOT NULL,
    customer_id integer NOT NULL,
    product_id integer NOT NULL,
    quantity integer DEFAULT 1,
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);


ALTER TABLE public.cart OWNER TO postgres;

--
-- TOC entry 231 (class 1259 OID 17007)
-- Name: cart_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.cart_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.cart_id_seq OWNER TO postgres;

--
-- TOC entry 5106 (class 0 OID 0)
-- Dependencies: 231
-- Name: cart_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.cart_id_seq OWNED BY public.cart.id;


--
-- TOC entry 218 (class 1259 OID 16880)
-- Name: categories; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.categories (
    id integer NOT NULL,
    category_name character varying(255) NOT NULL,
    category_description text,
    category_image character varying(255),
    is_active boolean DEFAULT true NOT NULL,
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);


ALTER TABLE public.categories OWNER TO postgres;

--
-- TOC entry 217 (class 1259 OID 16879)
-- Name: categories_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.categories_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.categories_id_seq OWNER TO postgres;

--
-- TOC entry 5107 (class 0 OID 0)
-- Dependencies: 217
-- Name: categories_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.categories_id_seq OWNED BY public.categories.id;


--
-- TOC entry 244 (class 1259 OID 17118)
-- Name: cms_pages; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cms_pages (
    id integer NOT NULL,
    slug character varying(100) NOT NULL,
    title character varying(255) NOT NULL,
    content text NOT NULL,
    is_active boolean DEFAULT true,
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);


ALTER TABLE public.cms_pages OWNER TO postgres;

--
-- TOC entry 243 (class 1259 OID 17117)
-- Name: cms_pages_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.cms_pages_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.cms_pages_id_seq OWNER TO postgres;

--
-- TOC entry 5108 (class 0 OID 0)
-- Dependencies: 243
-- Name: cms_pages_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.cms_pages_id_seq OWNED BY public.cms_pages.id;


--
-- TOC entry 224 (class 1259 OID 16932)
-- Name: customers; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.customers (
    id integer NOT NULL,
    tenant_id integer,
    first_name character varying(100) NOT NULL,
    last_name character varying(100) NOT NULL,
    email character varying(255) NOT NULL,
    phone character varying(20),
    password character varying(255) NOT NULL,
    is_active boolean DEFAULT true,
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);


ALTER TABLE public.customers OWNER TO postgres;

--
-- TOC entry 223 (class 1259 OID 16931)
-- Name: customers_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.customers_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.customers_id_seq OWNER TO postgres;

--
-- TOC entry 5109 (class 0 OID 0)
-- Dependencies: 223
-- Name: customers_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.customers_id_seq OWNED BY public.customers.id;


--
-- TOC entry 216 (class 1259 OID 16851)
-- Name: migrations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.migrations (
    id bigint NOT NULL,
    version character varying(255) NOT NULL,
    class character varying(255) NOT NULL,
    "group" character varying(255) NOT NULL,
    namespace character varying(255) NOT NULL,
    "time" integer NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO postgres;

--
-- TOC entry 215 (class 1259 OID 16850)
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.migrations_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.migrations_id_seq OWNER TO postgres;

--
-- TOC entry 5110 (class 0 OID 0)
-- Dependencies: 215
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- TOC entry 242 (class 1259 OID 17107)
-- Name: notifications; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.notifications (
    id integer NOT NULL,
    user_id integer,
    user_type character varying(50) NOT NULL,
    title character varying(255) NOT NULL,
    message text NOT NULL,
    is_read boolean DEFAULT false,
    created_at timestamp without time zone,
    CONSTRAINT notifications_user_type_check CHECK (((user_type)::text = ANY ((ARRAY['customer'::character varying, 'store_owner'::character varying, 'super_admin'::character varying])::text[])))
);


ALTER TABLE public.notifications OWNER TO postgres;

--
-- TOC entry 241 (class 1259 OID 17106)
-- Name: notifications_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.notifications_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.notifications_id_seq OWNER TO postgres;

--
-- TOC entry 5111 (class 0 OID 0)
-- Dependencies: 241
-- Name: notifications_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.notifications_id_seq OWNED BY public.notifications.id;


--
-- TOC entry 236 (class 1259 OID 17052)
-- Name: order_items; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.order_items (
    id integer NOT NULL,
    order_id integer NOT NULL,
    product_id integer NOT NULL,
    product_name character varying(255) NOT NULL,
    price numeric(10,2) NOT NULL,
    quantity integer NOT NULL,
    total numeric(10,2) NOT NULL
);


ALTER TABLE public.order_items OWNER TO postgres;

--
-- TOC entry 235 (class 1259 OID 17051)
-- Name: order_items_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.order_items_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.order_items_id_seq OWNER TO postgres;

--
-- TOC entry 5112 (class 0 OID 0)
-- Dependencies: 235
-- Name: order_items_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.order_items_id_seq OWNED BY public.order_items.id;


--
-- TOC entry 234 (class 1259 OID 17026)
-- Name: orders; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.orders (
    id integer NOT NULL,
    tenant_id integer NOT NULL,
    customer_id integer NOT NULL,
    order_number character varying(50) NOT NULL,
    total_amount numeric(10,2) NOT NULL,
    shipping_address text NOT NULL,
    city character varying(100) NOT NULL,
    postal_code character varying(20),
    phone character varying(20) NOT NULL,
    payment_method character varying(50) NOT NULL,
    payment_status character varying(50) DEFAULT 'pending'::character varying,
    order_status character varying(50) DEFAULT 'pending'::character varying,
    notes text,
    created_at timestamp without time zone,
    updated_at timestamp without time zone,
    CONSTRAINT orders_order_status_check CHECK (((order_status)::text = ANY ((ARRAY['pending'::character varying, 'confirmed'::character varying, 'processing'::character varying, 'shipped'::character varying, 'delivered'::character varying, 'cancelled'::character varying])::text[]))),
    CONSTRAINT orders_payment_method_check CHECK (((payment_method)::text = ANY ((ARRAY['cod'::character varying, 'online'::character varying])::text[]))),
    CONSTRAINT orders_payment_status_check CHECK (((payment_status)::text = ANY ((ARRAY['pending'::character varying, 'paid'::character varying, 'failed'::character varying, 'refunded'::character varying])::text[])))
);


ALTER TABLE public.orders OWNER TO postgres;

--
-- TOC entry 233 (class 1259 OID 17025)
-- Name: orders_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.orders_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.orders_id_seq OWNER TO postgres;

--
-- TOC entry 5113 (class 0 OID 0)
-- Dependencies: 233
-- Name: orders_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.orders_id_seq OWNED BY public.orders.id;


--
-- TOC entry 230 (class 1259 OID 16995)
-- Name: product_images; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.product_images (
    id integer NOT NULL,
    product_id integer NOT NULL,
    image_url character varying(255) NOT NULL,
    is_primary boolean DEFAULT false,
    created_at timestamp without time zone
);


ALTER TABLE public.product_images OWNER TO postgres;

--
-- TOC entry 229 (class 1259 OID 16994)
-- Name: product_images_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.product_images_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.product_images_id_seq OWNER TO postgres;

--
-- TOC entry 5114 (class 0 OID 0)
-- Dependencies: 229
-- Name: product_images_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.product_images_id_seq OWNED BY public.product_images.id;


--
-- TOC entry 228 (class 1259 OID 16967)
-- Name: products; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.products (
    id integer NOT NULL,
    tenant_id integer NOT NULL,
    category_id integer NOT NULL,
    subcategory_id integer,
    product_name character varying(255) NOT NULL,
    product_description text,
    price numeric(10,2) NOT NULL,
    old_price numeric(10,2),
    quantity integer DEFAULT 0,
    product_image character varying(255),
    status character varying(50) DEFAULT 'draft'::character varying,
    is_active boolean DEFAULT true,
    created_at timestamp without time zone,
    updated_at timestamp without time zone,
    CONSTRAINT products_status_check CHECK (((status)::text = ANY ((ARRAY['draft'::character varying, 'published'::character varying, 'archived'::character varying])::text[])))
);


ALTER TABLE public.products OWNER TO postgres;

--
-- TOC entry 227 (class 1259 OID 16966)
-- Name: products_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.products_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.products_id_seq OWNER TO postgres;

--
-- TOC entry 5115 (class 0 OID 0)
-- Dependencies: 227
-- Name: products_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.products_id_seq OWNED BY public.products.id;


--
-- TOC entry 240 (class 1259 OID 17086)
-- Name: reviews; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.reviews (
    id integer NOT NULL,
    product_id integer NOT NULL,
    customer_id integer NOT NULL,
    rating integer NOT NULL,
    review_title character varying(255),
    review_comment text,
    is_approved boolean DEFAULT false,
    created_at timestamp without time zone,
    updated_at timestamp without time zone,
    CONSTRAINT reviews_rating_check CHECK (((rating >= 1) AND (rating <= 5)))
);


ALTER TABLE public.reviews OWNER TO postgres;

--
-- TOC entry 239 (class 1259 OID 17085)
-- Name: reviews_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.reviews_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.reviews_id_seq OWNER TO postgres;

--
-- TOC entry 5116 (class 0 OID 0)
-- Dependencies: 239
-- Name: reviews_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.reviews_id_seq OWNED BY public.reviews.id;


--
-- TOC entry 246 (class 1259 OID 17130)
-- Name: settings; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.settings (
    id integer NOT NULL,
    setting_key character varying(100) NOT NULL,
    setting_value text,
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);


ALTER TABLE public.settings OWNER TO postgres;

--
-- TOC entry 245 (class 1259 OID 17129)
-- Name: settings_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.settings_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.settings_id_seq OWNER TO postgres;

--
-- TOC entry 5117 (class 0 OID 0)
-- Dependencies: 245
-- Name: settings_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.settings_id_seq OWNED BY public.settings.id;


--
-- TOC entry 248 (class 1259 OID 17142)
-- Name: store_requests; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.store_requests (
    id integer NOT NULL,
    store_name character varying(255) NOT NULL,
    owner_name character varying(255) NOT NULL,
    owner_email character varying(255) NOT NULL,
    owner_phone character varying(50) NOT NULL,
    store_description text,
    store_address text,
    business_type character varying(100),
    status character varying(50) DEFAULT 'pending'::character varying,
    reviewed_by integer,
    reviewed_at timestamp without time zone,
    created_at timestamp without time zone,
    updated_at timestamp without time zone,
    legal_documents character varying(500),
    owner_email_password character varying(255),
    CONSTRAINT store_requests_status_check CHECK (((status)::text = ANY ((ARRAY['pending'::character varying, 'approved'::character varying, 'rejected'::character varying])::text[])))
);


ALTER TABLE public.store_requests OWNER TO postgres;

--
-- TOC entry 247 (class 1259 OID 17141)
-- Name: store_requests_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.store_requests_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.store_requests_id_seq OWNER TO postgres;

--
-- TOC entry 5118 (class 0 OID 0)
-- Dependencies: 247
-- Name: store_requests_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.store_requests_id_seq OWNED BY public.store_requests.id;


--
-- TOC entry 226 (class 1259 OID 16949)
-- Name: subcategories; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.subcategories (
    id integer NOT NULL,
    category_id integer NOT NULL,
    tenant_id integer NOT NULL,
    subcategory_name character varying(255) NOT NULL,
    is_active boolean DEFAULT true,
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);


ALTER TABLE public.subcategories OWNER TO postgres;

--
-- TOC entry 225 (class 1259 OID 16948)
-- Name: subcategories_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.subcategories_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.subcategories_id_seq OWNER TO postgres;

--
-- TOC entry 5119 (class 0 OID 0)
-- Dependencies: 225
-- Name: subcategories_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.subcategories_id_seq OWNED BY public.subcategories.id;


--
-- TOC entry 222 (class 1259 OID 16913)
-- Name: system_users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.system_users (
    id integer NOT NULL,
    tenant_id integer,
    full_name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    password character varying(255) NOT NULL,
    role character varying(50) DEFAULT 'customer'::character varying,
    store_name character varying(255),
    is_active boolean DEFAULT true,
    created_at timestamp without time zone,
    updated_at timestamp without time zone,
    CONSTRAINT system_users_role_check CHECK (((role)::text = ANY ((ARRAY['super_admin'::character varying, 'store_owner'::character varying, 'customer'::character varying])::text[])))
);


ALTER TABLE public.system_users OWNER TO postgres;

--
-- TOC entry 221 (class 1259 OID 16912)
-- Name: system_users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.system_users_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.system_users_id_seq OWNER TO postgres;

--
-- TOC entry 5120 (class 0 OID 0)
-- Dependencies: 221
-- Name: system_users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.system_users_id_seq OWNED BY public.system_users.id;


--
-- TOC entry 220 (class 1259 OID 16902)
-- Name: tenants; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tenants (
    id integer NOT NULL,
    store_name character varying(255) NOT NULL,
    store_logo character varying(255),
    store_description text,
    contact_email character varying(255) NOT NULL,
    contact_phone character varying(50),
    store_address text,
    status character varying(50) DEFAULT 'pending'::character varying,
    created_at timestamp without time zone,
    updated_at timestamp without time zone,
    CONSTRAINT tenants_status_check CHECK (((status)::text = ANY ((ARRAY['pending'::character varying, 'active'::character varying, 'suspended'::character varying, 'disabled'::character varying])::text[])))
);


ALTER TABLE public.tenants OWNER TO postgres;

--
-- TOC entry 219 (class 1259 OID 16901)
-- Name: tenants_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tenants_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.tenants_id_seq OWNER TO postgres;

--
-- TOC entry 5121 (class 0 OID 0)
-- Dependencies: 219
-- Name: tenants_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tenants_id_seq OWNED BY public.tenants.id;


--
-- TOC entry 238 (class 1259 OID 17069)
-- Name: wishlist; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.wishlist (
    id integer NOT NULL,
    customer_id integer NOT NULL,
    product_id integer NOT NULL,
    created_at timestamp without time zone
);


ALTER TABLE public.wishlist OWNER TO postgres;

--
-- TOC entry 237 (class 1259 OID 17068)
-- Name: wishlist_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.wishlist_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.wishlist_id_seq OWNER TO postgres;

--
-- TOC entry 5122 (class 0 OID 0)
-- Dependencies: 237
-- Name: wishlist_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.wishlist_id_seq OWNED BY public.wishlist.id;


--
-- TOC entry 4833 (class 2604 OID 17011)
-- Name: cart id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cart ALTER COLUMN id SET DEFAULT nextval('public.cart_id_seq'::regclass);


--
-- TOC entry 4816 (class 2604 OID 16883)
-- Name: categories id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categories ALTER COLUMN id SET DEFAULT nextval('public.categories_id_seq'::regclass);


--
-- TOC entry 4844 (class 2604 OID 17121)
-- Name: cms_pages id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cms_pages ALTER COLUMN id SET DEFAULT nextval('public.cms_pages_id_seq'::regclass);


--
-- TOC entry 4823 (class 2604 OID 16935)
-- Name: customers id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.customers ALTER COLUMN id SET DEFAULT nextval('public.customers_id_seq'::regclass);


--
-- TOC entry 4815 (class 2604 OID 16854)
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- TOC entry 4842 (class 2604 OID 17110)
-- Name: notifications id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.notifications ALTER COLUMN id SET DEFAULT nextval('public.notifications_id_seq'::regclass);


--
-- TOC entry 4838 (class 2604 OID 17055)
-- Name: order_items id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.order_items ALTER COLUMN id SET DEFAULT nextval('public.order_items_id_seq'::regclass);


--
-- TOC entry 4835 (class 2604 OID 17029)
-- Name: orders id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.orders ALTER COLUMN id SET DEFAULT nextval('public.orders_id_seq'::regclass);


--
-- TOC entry 4831 (class 2604 OID 16998)
-- Name: product_images id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.product_images ALTER COLUMN id SET DEFAULT nextval('public.product_images_id_seq'::regclass);


--
-- TOC entry 4827 (class 2604 OID 16970)
-- Name: products id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.products ALTER COLUMN id SET DEFAULT nextval('public.products_id_seq'::regclass);


--
-- TOC entry 4840 (class 2604 OID 17089)
-- Name: reviews id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.reviews ALTER COLUMN id SET DEFAULT nextval('public.reviews_id_seq'::regclass);


--
-- TOC entry 4846 (class 2604 OID 17133)
-- Name: settings id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.settings ALTER COLUMN id SET DEFAULT nextval('public.settings_id_seq'::regclass);


--
-- TOC entry 4847 (class 2604 OID 17145)
-- Name: store_requests id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.store_requests ALTER COLUMN id SET DEFAULT nextval('public.store_requests_id_seq'::regclass);


--
-- TOC entry 4825 (class 2604 OID 16952)
-- Name: subcategories id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.subcategories ALTER COLUMN id SET DEFAULT nextval('public.subcategories_id_seq'::regclass);


--
-- TOC entry 4820 (class 2604 OID 16916)
-- Name: system_users id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.system_users ALTER COLUMN id SET DEFAULT nextval('public.system_users_id_seq'::regclass);


--
-- TOC entry 4818 (class 2604 OID 16905)
-- Name: tenants id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tenants ALTER COLUMN id SET DEFAULT nextval('public.tenants_id_seq'::regclass);


--
-- TOC entry 4839 (class 2604 OID 17072)
-- Name: wishlist id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.wishlist ALTER COLUMN id SET DEFAULT nextval('public.wishlist_id_seq'::regclass);


--
-- TOC entry 5084 (class 0 OID 17008)
-- Dependencies: 232
-- Data for Name: cart; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cart (id, customer_id, product_id, quantity, created_at, updated_at) FROM stdin;
11	2	10	1	2026-08-15 09:14:32	2026-08-15 09:14:32
12	1	11	1	2026-08-18 08:19:01	2026-08-18 08:19:01
13	1	7	1	2026-08-18 08:20:38	2026-08-18 08:20:38
\.


--
-- TOC entry 5070 (class 0 OID 16880)
-- Dependencies: 218
-- Data for Name: categories; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.categories (id, category_name, category_description, category_image, is_active, created_at, updated_at) FROM stdin;
1	Electronics	Gadgets, computers, audio, and more	\N	t	2026-08-09 10:26:13.782378	\N
2	Fashion	Clothing, shoes, accessories, and jewelry	\N	t	2026-08-09 10:26:13.782378	\N
3	Home & Living	Furniture, decor, kitchen, and appliances	\N	t	2026-08-09 10:26:13.782378	\N
4	Beauty	Skincare, makeup, hair, and wellness products	\N	t	2026-08-09 10:26:13.782378	\N
5	Sports	Fitness equipment, outdoor gear, and activewear	\N	t	2026-08-09 10:26:13.782378	\N
6	Books	Fiction, non-fiction, and educational books	\N	t	2026-08-09 10:26:13.782378	\N
8	Automotive	Parts, accessories, and tools	\N	t	2026-08-09 10:26:13.782378	\N
10	food 	food	\N	t	2026-08-10 09:16:11	2026-08-10 09:16:11
\.


--
-- TOC entry 5096 (class 0 OID 17118)
-- Dependencies: 244
-- Data for Name: cms_pages; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cms_pages (id, slug, title, content, is_active, created_at, updated_at) FROM stdin;
1	about	About Us	<h1>About ShopEase</h1><p>ShopEase is a multi-tenant e-commerce platform that empowers businesses to sell online.</p>	t	2026-08-09 10:26:13.782378	\N
2	privacy	Privacy Policy	<h1>Privacy Policy</h1><p>We take your privacy seriously...</p>	t	2026-08-09 10:26:13.782378	\N
3	terms	Terms & Conditions	<h1>Terms & Conditions</h1><p>Welcome to ShopEase...</p>	t	2026-08-09 10:26:13.782378	\N
\.


--
-- TOC entry 5076 (class 0 OID 16932)
-- Dependencies: 224
-- Data for Name: customers; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.customers (id, tenant_id, first_name, last_name, email, phone, password, is_active, created_at, updated_at) FROM stdin;
1	\N	Amir	Mohammed	amirmohe264@gmail.com	0973030412	$2y$10$TeYdBSuPKw1wrbVHqsu1i.xE6aHJba6A5sJN434Rtsj93pbbSne.C	t	2026-08-09 15:43:57	2026-08-09 15:43:57
2	\N	yosef	girma	yos1@gmail.com	0973030412	$2y$10$BzYO/0.nHZ.AOvgmv7Is7uykhmzL/NEBne9b1To6.JiSAnZ9mxWCi	t	2026-08-10 12:24:13	2026-08-10 12:24:13
3	\N	kebe	non	kebe@gmail.com	0988775544	$2y$10$WYOsUiTfhI30mlnqxmNnU.Kpbou/jaafWdFPAcja86WZNDAZHKhvC	t	2026-08-11 08:49:59	2026-08-11 08:49:59
4	\N	Test	User	test@example.com	\N	$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi	t	2026-08-13 12:43:01.277983	\N
5	\N	jewad	shemsu	jewad@gmail.com	0973030412	$2y$10$xhNpHLNNypnkNx9R0oQwAOxo79R.i7U4OTVlJceBcdTAEtnHxnW22	t	2026-08-15 09:11:54	2026-08-15 09:11:54
\.


--
-- TOC entry 5068 (class 0 OID 16851)
-- Dependencies: 216
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.migrations (id, version, class, "group", namespace, "time", batch) FROM stdin;
5	2026-08-07-000001	App\\Database\\Migrations\\CreateTenantsTable	default	App	1786090525	1
7	2026-08-07-000003	App\\Database\\Migrations\\CreateCategoriesTable	default	App	1786090525	1
8	2026-08-07-000002	App\\Database\\Migrations\\CreateSystemUsersTable	default	App	1786090870	2
9	2026-08-07-000004	App\\Database\\Migrations\\CreateCustomersTable	default	App	1786131739	3
\.


--
-- TOC entry 5094 (class 0 OID 17107)
-- Dependencies: 242
-- Data for Name: notifications; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.notifications (id, user_id, user_type, title, message, is_read, created_at) FROM stdin;
\.


--
-- TOC entry 5088 (class 0 OID 17052)
-- Dependencies: 236
-- Data for Name: order_items; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.order_items (id, order_id, product_id, product_name, price, quantity, total) FROM stdin;
\.


--
-- TOC entry 5086 (class 0 OID 17026)
-- Dependencies: 234
-- Data for Name: orders; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.orders (id, tenant_id, customer_id, order_number, total_amount, shipping_address, city, postal_code, phone, payment_method, payment_status, order_status, notes, created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 5082 (class 0 OID 16995)
-- Dependencies: 230
-- Data for Name: product_images; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.product_images (id, product_id, image_url, is_primary, created_at) FROM stdin;
\.


--
-- TOC entry 5080 (class 0 OID 16967)
-- Dependencies: 228
-- Data for Name: products; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.products (id, tenant_id, category_id, subcategory_id, product_name, product_description, price, old_price, quantity, product_image, status, is_active, created_at, updated_at) FROM stdin;
7	13	2	\N	airmax	nmnkln'l	22.00	44.00	4	uploads/products/product_1786612774_1786612774_7a9ab308a71c081181c4.jpg	published	t	2026-08-13 09:19:34	2026-08-13 09:19:34
8	13	2	\N	NIKE	nnkm,/nm,	33.00	98.88	4	uploads/products/product_1786612817_1786612817_5ba1aa4a754173a9e5c6.jpg	published	t	2026-08-13 09:20:17	2026-08-13 09:20:17
9	13	2	\N	skechers	kmk'j'l	22.00	11.00	16	uploads/products/product_1786612864_1786612864_f9d30168f8b1b481d380.jpg	published	t	2026-08-13 09:21:04	2026-08-13 09:21:04
10	13	2	\N	allstar	'km'm.m/	33.00	22.00	4	uploads/products/product_1786612908_1786612908_d7eefb8ce44a1e89fced.jpg	published	t	2026-08-13 09:21:48	2026-08-13 09:21:48
11	13	2	\N	t shert	jn'ww'	33.00	22.00	3	uploads/products/product_1786612956_1786612956_8f0e812f9b17b3c03156.jpg	published	t	2026-08-13 09:22:36	2026-08-13 09:22:36
12	13	8	8	elentra	yioghglhghl	777.00	86.92	3	uploads/products/product_1787141371_1787141371_0e0cfc211511427886ab.jpg	published	t	2026-08-19 12:09:31	2026-08-19 12:09:31
13	13	8	8	Elentra	tfgkjkdy	455.00	566.00	2	uploads/products/product_1787142416_1787142416_483db090ba3a7f2017cb.jpg	published	t	2026-08-19 12:26:56	2026-08-19 12:26:56
14	13	8	7	hylux	jnelfn'lqern'len'l	33.00	43.00	5	uploads/products/product_1787143057_1787143057_6543ff8478da6b65df71.jpg	published	t	2026-08-19 12:37:37	2026-08-19 12:37:37
15	13	8	7	landcruser	efn;ktq	45.00	23.00	1	uploads/products/product_1787143111_1787143111_b434e02b82e5d2202b3f.jpg	published	t	2026-08-19 12:38:31	2026-08-19 12:38:31
16	13	8	7	gemechis	jne'fjn	33.00	88.00	3	uploads/products/product_1787143181_1787143181_fed6dc205dc00bfce526.jpg	published	t	2026-08-19 12:39:41	2026-08-19 12:39:41
17	13	1	6	samaung ultra	nbjf;jk;jk	344.00	230.87	2	uploads/products/product_1787144062_1787144062_334c17b18fd80d24e2de.jpg	published	t	2026-08-19 12:54:22	2026-08-19 12:54:22
18	13	1	6	google pixel	fjn;jn;fgkwn	220.22	42.85	4	uploads/products/product_1787144115_1787144115_41ef808259913515cec3.jpg	published	t	2026-08-19 12:55:15	2026-08-19 12:55:15
19	13	1	6	iphone	;qnwqnbw	23.00	43.83	4	uploads/products/product_1787144172_1787144172_750567e02407da373fba.jpg	published	t	2026-08-19 12:56:12	2026-08-19 12:56:12
20	13	1	11	hilk	bwfnkwej	33.00	42.00	3	uploads/products/product_1787144241_1787144241_64bd27aed7a94cf55121.jpg	published	t	2026-08-19 12:57:21	2026-08-19 12:57:21
21	13	1	11	erd	ndfqw	23.00	43.00	2	uploads/products/product_1787144297_1787144297_bee04f73dc5ecfd01822.jpg	published	t	2026-08-19 12:58:17	2026-08-19 12:58:17
22	13	2	13	smart	mner;jqj	33.00	54.87	16	uploads/products/product_1787145972_1787145972_dc3b7deab62498e10224.jpg	draft	t	2026-08-19 13:26:12	2026-08-19 13:26:12
23	13	2	3	cool	hwkb	12.07	23.08	3	uploads/products/product_1787149006_1787149006_25fc9ca365e82ab8544d.jpg	published	t	2026-08-19 14:16:46	2026-08-19 14:16:46
24	13	2	3	rool	lleh;	42.91	53.93	3	uploads/products/product_1787149047_1787149047_d48483bd18f51cc3414f.jpg	published	t	2026-08-19 14:17:27	2026-08-19 14:17:27
\.


--
-- TOC entry 5092 (class 0 OID 17086)
-- Dependencies: 240
-- Data for Name: reviews; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.reviews (id, product_id, customer_id, rating, review_title, review_comment, is_approved, created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 5098 (class 0 OID 17130)
-- Dependencies: 246
-- Data for Name: settings; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.settings (id, setting_key, setting_value, created_at, updated_at) FROM stdin;
1	platform_name	ShopEase	2026-08-09 10:26:13.782378	\N
2	platform_email	admin@shopease.com	2026-08-09 10:26:13.782378	\N
3	default_currency	USD	2026-08-09 10:26:13.782378	\N
4	default_language	en	2026-08-09 10:26:13.782378	\N
\.


--
-- TOC entry 5100 (class 0 OID 17142)
-- Dependencies: 248
-- Data for Name: store_requests; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.store_requests (id, store_name, owner_name, owner_email, owner_phone, store_description, store_address, business_type, status, reviewed_by, reviewed_at, created_at, updated_at, legal_documents, owner_email_password) FROM stdin;
5	amirs	Amir Mohammed	amirmohe264@gmail.com	+251973030412	nef onhkqrjejqe	09 kebele	manufacturer	approved	1	2026-08-10 08:47:29	\N	\N	uploads/store_documents/doc_1786351618_1786351618_897ee424b33ef3d7caf1.png	uf11d3P2bNb3PkJZLvHwrQ==
6	Demo Fresh	yonas desalegn	yo@gmail.com	+251977668833	rdtfygjkgj	Addis Abeba	wholesale	approved	1	2026-08-11 07:38:09	\N	\N	uploads/store_documents/doc_1786432100_1786432100_024c85a73ace2f95eb5f.docx	lOh7cNraNsh8CjCmBWdUlg==
7	hhhh	nati	nati@gmail.com	+251973030412	qenrrn;ml	Addis Abeba	wholesale	approved	1	2026-08-11 08:10:39	\N	\N	uploads/store_documents/doc_1786435085_1786435085_dd1202833852c06acf49.docx	lOh7cNraNsh8CjCmBWdUlg==
\.


--
-- TOC entry 5078 (class 0 OID 16949)
-- Dependencies: 226
-- Data for Name: subcategories; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.subcategories (id, category_id, tenant_id, subcategory_name, is_active, created_at, updated_at) FROM stdin;
6	1	13	cell phone	t	2026-08-17 12:23:25	2026-08-19 11:53:29
5	2	13	hudy	t	2026-08-17 12:23:02	2026-08-19 11:54:17
4	2	13	jaket	t	2026-08-17 12:22:44	2026-08-19 11:54:22
3	2	13	short	t	2026-08-17 12:22:19	2026-08-19 11:54:30
2	2	13	showe	t	2026-08-17 12:21:59	2026-08-19 11:54:36
7	8	13	toyota	t	2026-08-19 11:36:00	2026-08-19 11:54:43
1	2	13	Tshert	t	2026-08-17 12:21:31	2026-08-19 11:54:48
8	8	13	hyunday	t	2026-08-19 11:55:11	2026-08-19 11:55:11
9	8	13	nisane	t	2026-08-19 11:55:30	2026-08-19 11:55:30
10	1	13	laptop	t	2026-08-19 12:40:28	2026-08-19 12:40:28
11	1	13	headphone	t	2026-08-19 12:40:44	2026-08-19 12:40:44
12	1	13	mouse	t	2026-08-19 12:41:08	2026-08-19 12:41:08
13	2	13	Watch	t	2026-08-19 13:25:22	2026-08-19 13:25:22
\.


--
-- TOC entry 5074 (class 0 OID 16913)
-- Dependencies: 222
-- Data for Name: system_users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.system_users (id, tenant_id, full_name, email, password, role, store_name, is_active, created_at, updated_at) FROM stdin;
1	\N	Super Admin	admin@shopease.com	$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi	super_admin	\N	t	2026-08-09 10:26:13.782378	\N
4	9	Amir Mohammed	amirmohe264@gmail.com	$2y$10$j5MZJgiA2OnNlbSHRsPZlOS0piVUtiGHZBkRSjO2yGy9iptlD2Hz6	store_owner	amirs	t	2026-08-10 08:47:29	2026-08-10 08:47:29
5	10	yonas desalegn	yo@gmail.com	$2y$10$o6T.yZGuzUuLrkloYB3i8O0J1/kF8Zubr1UFAolOFXaDwBh7Jh6A6	store_owner	Demo Fresh	t	2026-08-11 07:38:09	2026-08-11 07:38:09
6	11	yonas desalegn	yosss@gmail.com	$2y$10$PigpbrFoRIEKdJrgzslmiuUhCFrssMoErJTNbxAzugisW.gdw2UcK	store_owner	yoniclothe	t	2026-08-11 07:41:38	2026-08-11 07:41:38
8	13	nati	nati11@gmail.com	$2y$10$d/Xa3AmNeCe447UqJLeizOljMVt2qtIvrRpAYWga27E6QVx8J5WGO	store_owner	natis	t	2026-08-11 08:16:19	2026-08-11 08:16:19
7	12	nati	nati@gmail.com	$2y$10$ENPSDQtD5Hu7fw6dok4HJuMz8eaEvRJnm71paRDtq.N7/Z.VE4ccK	store_owner	hhhh	t	2026-08-11 08:10:39	2026-08-11 08:17:12
\.


--
-- TOC entry 5072 (class 0 OID 16902)
-- Dependencies: 220
-- Data for Name: tenants; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tenants (id, store_name, store_logo, store_description, contact_email, contact_phone, store_address, status, created_at, updated_at) FROM stdin;
9	amirs	\N	nef onhkqrjejqe	amirmohe264@gmail.com	+251973030412	09 kebele	active	2026-08-10 08:47:28	2026-08-10 08:47:28
10	Demo Fresh	\N	rdtfygjkgj	yo@gmail.com	+251977668833	Addis Abeba	active	2026-08-11 07:38:09	2026-08-11 07:38:09
11	yoniclothe	\N	jngjn;jlng	yosss@gmail.com	+251977668833	Addis Abeba	active	2026-08-11 07:41:38	2026-08-11 07:41:38
12	hhhh	\N	qenrrn;ml	nati@gmail.com	+251973030412	Addis Abeba	active	2026-08-11 08:10:39	2026-08-11 08:10:39
13	natis	\N	jjn2efn	nati11@gmail.com	+251977668833	Addis Abeba	active	2026-08-11 08:16:18	2026-08-11 08:16:18
\.


--
-- TOC entry 5090 (class 0 OID 17069)
-- Dependencies: 238
-- Data for Name: wishlist; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.wishlist (id, customer_id, product_id, created_at) FROM stdin;
\.


--
-- TOC entry 5123 (class 0 OID 0)
-- Dependencies: 231
-- Name: cart_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.cart_id_seq', 17, true);


--
-- TOC entry 5124 (class 0 OID 0)
-- Dependencies: 217
-- Name: categories_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.categories_id_seq', 10, true);


--
-- TOC entry 5125 (class 0 OID 0)
-- Dependencies: 243
-- Name: cms_pages_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.cms_pages_id_seq', 3, true);


--
-- TOC entry 5126 (class 0 OID 0)
-- Dependencies: 223
-- Name: customers_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.customers_id_seq', 5, true);


--
-- TOC entry 5127 (class 0 OID 0)
-- Dependencies: 215
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.migrations_id_seq', 9, true);


--
-- TOC entry 5128 (class 0 OID 0)
-- Dependencies: 241
-- Name: notifications_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.notifications_id_seq', 1, false);


--
-- TOC entry 5129 (class 0 OID 0)
-- Dependencies: 235
-- Name: order_items_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.order_items_id_seq', 1, false);


--
-- TOC entry 5130 (class 0 OID 0)
-- Dependencies: 233
-- Name: orders_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.orders_id_seq', 1, false);


--
-- TOC entry 5131 (class 0 OID 0)
-- Dependencies: 229
-- Name: product_images_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.product_images_id_seq', 1, false);


--
-- TOC entry 5132 (class 0 OID 0)
-- Dependencies: 227
-- Name: products_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.products_id_seq', 24, true);


--
-- TOC entry 5133 (class 0 OID 0)
-- Dependencies: 239
-- Name: reviews_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.reviews_id_seq', 1, false);


--
-- TOC entry 5134 (class 0 OID 0)
-- Dependencies: 245
-- Name: settings_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.settings_id_seq', 4, true);


--
-- TOC entry 5135 (class 0 OID 0)
-- Dependencies: 247
-- Name: store_requests_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.store_requests_id_seq', 7, true);


--
-- TOC entry 5136 (class 0 OID 0)
-- Dependencies: 225
-- Name: subcategories_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.subcategories_id_seq', 13, true);


--
-- TOC entry 5137 (class 0 OID 0)
-- Dependencies: 221
-- Name: system_users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.system_users_id_seq', 8, true);


--
-- TOC entry 5138 (class 0 OID 0)
-- Dependencies: 219
-- Name: tenants_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tenants_id_seq', 13, true);


--
-- TOC entry 5139 (class 0 OID 0)
-- Dependencies: 237
-- Name: wishlist_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.wishlist_id_seq', 1, false);


--
-- TOC entry 4879 (class 2606 OID 17014)
-- Name: cart cart_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cart
    ADD CONSTRAINT cart_pkey PRIMARY KEY (id);


--
-- TOC entry 4893 (class 2606 OID 17126)
-- Name: cms_pages cms_pages_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cms_pages
    ADD CONSTRAINT cms_pages_pkey PRIMARY KEY (id);


--
-- TOC entry 4895 (class 2606 OID 17128)
-- Name: cms_pages cms_pages_slug_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cms_pages
    ADD CONSTRAINT cms_pages_slug_key UNIQUE (slug);


--
-- TOC entry 4869 (class 2606 OID 16942)
-- Name: customers customers_email_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.customers
    ADD CONSTRAINT customers_email_key UNIQUE (email);


--
-- TOC entry 4871 (class 2606 OID 16940)
-- Name: customers customers_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.customers
    ADD CONSTRAINT customers_pkey PRIMARY KEY (id);


--
-- TOC entry 4891 (class 2606 OID 17116)
-- Name: notifications notifications_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.notifications
    ADD CONSTRAINT notifications_pkey PRIMARY KEY (id);


--
-- TOC entry 4885 (class 2606 OID 17057)
-- Name: order_items order_items_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.order_items
    ADD CONSTRAINT order_items_pkey PRIMARY KEY (id);


--
-- TOC entry 4881 (class 2606 OID 17040)
-- Name: orders orders_order_number_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.orders
    ADD CONSTRAINT orders_order_number_key UNIQUE (order_number);


--
-- TOC entry 4883 (class 2606 OID 17038)
-- Name: orders orders_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.orders
    ADD CONSTRAINT orders_pkey PRIMARY KEY (id);


--
-- TOC entry 4861 (class 2606 OID 16888)
-- Name: categories pk_categories; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categories
    ADD CONSTRAINT pk_categories PRIMARY KEY (id);


--
-- TOC entry 4859 (class 2606 OID 16858)
-- Name: migrations pk_migrations; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT pk_migrations PRIMARY KEY (id);


--
-- TOC entry 4877 (class 2606 OID 17001)
-- Name: product_images product_images_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.product_images
    ADD CONSTRAINT product_images_pkey PRIMARY KEY (id);


--
-- TOC entry 4875 (class 2606 OID 16978)
-- Name: products products_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.products
    ADD CONSTRAINT products_pkey PRIMARY KEY (id);


--
-- TOC entry 4889 (class 2606 OID 17095)
-- Name: reviews reviews_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.reviews
    ADD CONSTRAINT reviews_pkey PRIMARY KEY (id);


--
-- TOC entry 4897 (class 2606 OID 17137)
-- Name: settings settings_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.settings
    ADD CONSTRAINT settings_pkey PRIMARY KEY (id);


--
-- TOC entry 4899 (class 2606 OID 17139)
-- Name: settings settings_setting_key_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.settings
    ADD CONSTRAINT settings_setting_key_key UNIQUE (setting_key);


--
-- TOC entry 4901 (class 2606 OID 17153)
-- Name: store_requests store_requests_owner_email_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.store_requests
    ADD CONSTRAINT store_requests_owner_email_key UNIQUE (owner_email);


--
-- TOC entry 4903 (class 2606 OID 17151)
-- Name: store_requests store_requests_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.store_requests
    ADD CONSTRAINT store_requests_pkey PRIMARY KEY (id);


--
-- TOC entry 4873 (class 2606 OID 16955)
-- Name: subcategories subcategories_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.subcategories
    ADD CONSTRAINT subcategories_pkey PRIMARY KEY (id);


--
-- TOC entry 4865 (class 2606 OID 16925)
-- Name: system_users system_users_email_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.system_users
    ADD CONSTRAINT system_users_email_key UNIQUE (email);


--
-- TOC entry 4867 (class 2606 OID 16923)
-- Name: system_users system_users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.system_users
    ADD CONSTRAINT system_users_pkey PRIMARY KEY (id);


--
-- TOC entry 4863 (class 2606 OID 16911)
-- Name: tenants tenants_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tenants
    ADD CONSTRAINT tenants_pkey PRIMARY KEY (id);


--
-- TOC entry 4887 (class 2606 OID 17074)
-- Name: wishlist wishlist_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.wishlist
    ADD CONSTRAINT wishlist_pkey PRIMARY KEY (id);


--
-- TOC entry 4912 (class 2606 OID 17015)
-- Name: cart cart_customer_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cart
    ADD CONSTRAINT cart_customer_id_fkey FOREIGN KEY (customer_id) REFERENCES public.customers(id) ON DELETE CASCADE;


--
-- TOC entry 4913 (class 2606 OID 17020)
-- Name: cart cart_product_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cart
    ADD CONSTRAINT cart_product_id_fkey FOREIGN KEY (product_id) REFERENCES public.products(id) ON DELETE CASCADE;


--
-- TOC entry 4905 (class 2606 OID 16943)
-- Name: customers customers_tenant_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.customers
    ADD CONSTRAINT customers_tenant_id_fkey FOREIGN KEY (tenant_id) REFERENCES public.tenants(id) ON DELETE SET NULL;


--
-- TOC entry 4914 (class 2606 OID 17161)
-- Name: cart fk_cart_customer; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cart
    ADD CONSTRAINT fk_cart_customer FOREIGN KEY (customer_id) REFERENCES public.customers(id) ON DELETE CASCADE;


--
-- TOC entry 4915 (class 2606 OID 17166)
-- Name: cart fk_cart_product; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cart
    ADD CONSTRAINT fk_cart_product FOREIGN KEY (product_id) REFERENCES public.products(id) ON DELETE CASCADE;


--
-- TOC entry 4918 (class 2606 OID 17058)
-- Name: order_items order_items_order_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.order_items
    ADD CONSTRAINT order_items_order_id_fkey FOREIGN KEY (order_id) REFERENCES public.orders(id) ON DELETE CASCADE;


--
-- TOC entry 4919 (class 2606 OID 17063)
-- Name: order_items order_items_product_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.order_items
    ADD CONSTRAINT order_items_product_id_fkey FOREIGN KEY (product_id) REFERENCES public.products(id) ON DELETE CASCADE;


--
-- TOC entry 4916 (class 2606 OID 17046)
-- Name: orders orders_customer_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.orders
    ADD CONSTRAINT orders_customer_id_fkey FOREIGN KEY (customer_id) REFERENCES public.customers(id) ON DELETE CASCADE;


--
-- TOC entry 4917 (class 2606 OID 17041)
-- Name: orders orders_tenant_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.orders
    ADD CONSTRAINT orders_tenant_id_fkey FOREIGN KEY (tenant_id) REFERENCES public.tenants(id) ON DELETE CASCADE;


--
-- TOC entry 4911 (class 2606 OID 17002)
-- Name: product_images product_images_product_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.product_images
    ADD CONSTRAINT product_images_product_id_fkey FOREIGN KEY (product_id) REFERENCES public.products(id) ON DELETE CASCADE;


--
-- TOC entry 4908 (class 2606 OID 16984)
-- Name: products products_category_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.products
    ADD CONSTRAINT products_category_id_fkey FOREIGN KEY (category_id) REFERENCES public.categories(id) ON DELETE CASCADE;


--
-- TOC entry 4909 (class 2606 OID 16989)
-- Name: products products_subcategory_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.products
    ADD CONSTRAINT products_subcategory_id_fkey FOREIGN KEY (subcategory_id) REFERENCES public.subcategories(id) ON DELETE SET NULL;


--
-- TOC entry 4910 (class 2606 OID 16979)
-- Name: products products_tenant_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.products
    ADD CONSTRAINT products_tenant_id_fkey FOREIGN KEY (tenant_id) REFERENCES public.tenants(id) ON DELETE CASCADE;


--
-- TOC entry 4922 (class 2606 OID 17101)
-- Name: reviews reviews_customer_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.reviews
    ADD CONSTRAINT reviews_customer_id_fkey FOREIGN KEY (customer_id) REFERENCES public.customers(id) ON DELETE CASCADE;


--
-- TOC entry 4923 (class 2606 OID 17096)
-- Name: reviews reviews_product_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.reviews
    ADD CONSTRAINT reviews_product_id_fkey FOREIGN KEY (product_id) REFERENCES public.products(id) ON DELETE CASCADE;


--
-- TOC entry 4906 (class 2606 OID 16956)
-- Name: subcategories subcategories_category_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.subcategories
    ADD CONSTRAINT subcategories_category_id_fkey FOREIGN KEY (category_id) REFERENCES public.categories(id) ON DELETE CASCADE;


--
-- TOC entry 4907 (class 2606 OID 16961)
-- Name: subcategories subcategories_tenant_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.subcategories
    ADD CONSTRAINT subcategories_tenant_id_fkey FOREIGN KEY (tenant_id) REFERENCES public.tenants(id) ON DELETE CASCADE;


--
-- TOC entry 4904 (class 2606 OID 16926)
-- Name: system_users system_users_tenant_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.system_users
    ADD CONSTRAINT system_users_tenant_id_fkey FOREIGN KEY (tenant_id) REFERENCES public.tenants(id) ON DELETE SET NULL;


--
-- TOC entry 4920 (class 2606 OID 17075)
-- Name: wishlist wishlist_customer_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.wishlist
    ADD CONSTRAINT wishlist_customer_id_fkey FOREIGN KEY (customer_id) REFERENCES public.customers(id) ON DELETE CASCADE;


--
-- TOC entry 4921 (class 2606 OID 17080)
-- Name: wishlist wishlist_product_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.wishlist
    ADD CONSTRAINT wishlist_product_id_fkey FOREIGN KEY (product_id) REFERENCES public.products(id) ON DELETE CASCADE;


-- Completed on 2026-08-19 20:49:54

--
-- PostgreSQL database dump complete
--

\unrestrict Ep17rhaY23nGpgBuVYhw6VWLgQMNhw3pyBjUidXqecuhzaaQASMcJDxtpK0pvX9

