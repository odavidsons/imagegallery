--
-- PostgreSQL database dump
--

-- Dumped from database version 14.8 (Ubuntu 14.8-0ubuntu0.22.04.1)
-- Dumped by pg_dump version 14.8 (Ubuntu 14.8-0ubuntu0.22.04.1)

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
-- Name: pgcrypto; Type: EXTENSION; Schema: -; Owner: -
--

CREATE EXTENSION IF NOT EXISTS pgcrypto WITH SCHEMA public;


--
-- Name: EXTENSION pgcrypto; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION pgcrypto IS 'cryptographic functions';


SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: categories; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.categories (
    id integer NOT NULL,
    name text
);


ALTER TABLE public.categories OWNER TO postgres;

--
-- Name: categories_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.categories_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.categories_id_seq OWNER TO postgres;

--
-- Name: categories_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.categories_id_seq OWNED BY public.categories.id;


--
-- Name: imagecomments; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.imagecomments (
    id integer NOT NULL,
    userid integer NOT NULL,
    imageid integer NOT NULL,
    text text,
    username text,
    date text DEFAULT CURRENT_TIMESTAMP(0)
);


ALTER TABLE public.imagecomments OWNER TO postgres;

--
-- Name: imagecomments_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.imagecomments_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.imagecomments_id_seq OWNER TO postgres;

--
-- Name: imagecomments_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.imagecomments_id_seq OWNED BY public.imagecomments.id;


--
-- Name: images; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.images (
    id integer NOT NULL,
    name text,
    path text,
    uploaded_by text,
    upload_date text DEFAULT CURRENT_TIMESTAMP(0),
    description text,
    category text
);


ALTER TABLE public.images OWNER TO postgres;

--
-- Name: images_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.images_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.images_id_seq OWNER TO postgres;

--
-- Name: images_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.images_id_seq OWNED BY public.images.id;


--
-- Name: imagestats; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.imagestats (
    id integer NOT NULL,
    imageid integer NOT NULL,
    likes integer DEFAULT 0,
    dislikes integer DEFAULT 0,
    favourites integer DEFAULT 0,
    comments integer DEFAULT 0
);


ALTER TABLE public.imagestats OWNER TO postgres;

--
-- Name: imagestats_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.imagestats_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.imagestats_id_seq OWNER TO postgres;

--
-- Name: imagestats_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.imagestats_id_seq OWNED BY public.imagestats.id;


--
-- Name: logs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.logs (
    id integer NOT NULL,
    type text NOT NULL,
    name text NOT NULL,
    username text,
    date text DEFAULT CURRENT_TIMESTAMP(0)
);


ALTER TABLE public.logs OWNER TO postgres;

--
-- Name: logs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.logs_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.logs_id_seq OWNER TO postgres;

--
-- Name: logs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.logs_id_seq OWNED BY public.logs.id;


--
-- Name: sessions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sessions (
    id integer NOT NULL,
    userid text,
    session text,
    expires text
);


ALTER TABLE public.sessions OWNER TO postgres;

--
-- Name: sessions_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sessions_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sessions_id_seq OWNER TO postgres;

--
-- Name: sessions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.sessions_id_seq OWNED BY public.sessions.id;


--
-- Name: userimagefavourites; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.userimagefavourites (
    userid integer NOT NULL,
    imageid integer NOT NULL,
    date text DEFAULT CURRENT_TIMESTAMP(0)
);


ALTER TABLE public.userimagefavourites OWNER TO postgres;

--
-- Name: userimagevotes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.userimagevotes (
    userid integer NOT NULL,
    imageid integer NOT NULL,
    date text DEFAULT CURRENT_TIMESTAMP(0),
    type text
);


ALTER TABLE public.userimagevotes OWNER TO postgres;

--
-- Name: userinfo; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.userinfo (
    id integer NOT NULL,
    username text,
    password text,
    join_date text DEFAULT CURRENT_TIMESTAMP(0),
    type integer DEFAULT 0
);


ALTER TABLE public.userinfo OWNER TO postgres;

--
-- Name: userinfo_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.userinfo_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.userinfo_id_seq OWNER TO postgres;

--
-- Name: userinfo_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.userinfo_id_seq OWNED BY public.userinfo.id;


--
-- Name: userstats; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.userstats (
    id integer NOT NULL,
    total_uploaded integer DEFAULT 0,
    active_uploaded integer DEFAULT 0,
    userid integer NOT NULL,
    total_comments integer DEFAULT 0
);


ALTER TABLE public.userstats OWNER TO postgres;

--
-- Name: userstats_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.userstats_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.userstats_id_seq OWNER TO postgres;

--
-- Name: userstats_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.userstats_id_seq OWNED BY public.userstats.id;


--
-- Name: categories id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categories ALTER COLUMN id SET DEFAULT nextval('public.categories_id_seq'::regclass);


--
-- Name: imagecomments id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.imagecomments ALTER COLUMN id SET DEFAULT nextval('public.imagecomments_id_seq'::regclass);


--
-- Name: images id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.images ALTER COLUMN id SET DEFAULT nextval('public.images_id_seq'::regclass);


--
-- Name: imagestats id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.imagestats ALTER COLUMN id SET DEFAULT nextval('public.imagestats_id_seq'::regclass);


--
-- Name: logs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.logs ALTER COLUMN id SET DEFAULT nextval('public.logs_id_seq'::regclass);


--
-- Name: sessions id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sessions ALTER COLUMN id SET DEFAULT nextval('public.sessions_id_seq'::regclass);


--
-- Name: userinfo id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.userinfo ALTER COLUMN id SET DEFAULT nextval('public.userinfo_id_seq'::regclass);


--
-- Name: userstats id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.userstats ALTER COLUMN id SET DEFAULT nextval('public.userstats_id_seq'::regclass);


--
-- Data for Name: categories; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.categories (id, name) FROM stdin;
\.


--
-- Data for Name: imagecomments; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.imagecomments (id, userid, imageid, text, username, date) FROM stdin;
\.


--
-- Data for Name: images; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.images (id, name, path, uploaded_by, upload_date, description, category) FROM stdin;
\.


--
-- Data for Name: imagestats; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.imagestats (id, imageid, likes, dislikes, favourites, comments) FROM stdin;
\.


--
-- Data for Name: logs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.logs (id, type, name, username, date) FROM stdin;
\.


--
-- Data for Name: sessions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.sessions (id, userid, session, expires) FROM stdin;
\.


--
-- Data for Name: userimagefavourites; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.userimagefavourites (userid, imageid, date) FROM stdin;
\.


--
-- Data for Name: userimagevotes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.userimagevotes (userid, imageid, date, type) FROM stdin;
\.


--
-- Data for Name: userinfo; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.userinfo (id, username, password, join_date, type) FROM stdin;
1	Administrator	$2y$10$Ebk79HvtmOvJEn0E1bbRyeIsHZPtm3El8D7TqZ6bL22XMEyHObUAi	2023-05-26 15:50:33+01	1
\.


--
-- Data for Name: userstats; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.userstats (id, total_uploaded, active_uploaded, userid, total_comments) FROM stdin;
1	0	0	1	0
\.


--
-- Name: categories_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.categories_id_seq', 1, false);


--
-- Name: imagecomments_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.imagecomments_id_seq', 23, true);


--
-- Name: images_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.images_id_seq', 1, true);


--
-- Name: imagestats_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.imagestats_id_seq', 1, true);


--
-- Name: logs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.logs_id_seq', 90, true);


--
-- Name: sessions_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.sessions_id_seq', 1, false);


--
-- Name: userinfo_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.userinfo_id_seq', 1, true);


--
-- Name: userstats_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.userstats_id_seq', 1, true);


--
-- Name: categories categories_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categories
    ADD CONSTRAINT categories_pkey PRIMARY KEY (id);


--
-- Name: imagecomments imagecomments_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.imagecomments
    ADD CONSTRAINT imagecomments_pkey PRIMARY KEY (id);


--
-- Name: images images_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.images
    ADD CONSTRAINT images_pkey PRIMARY KEY (id);


--
-- Name: imagestats imagestats_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.imagestats
    ADD CONSTRAINT imagestats_pkey PRIMARY KEY (id);


--
-- Name: logs logs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.logs
    ADD CONSTRAINT logs_pkey PRIMARY KEY (id);


--
-- Name: sessions sessions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sessions
    ADD CONSTRAINT sessions_pkey PRIMARY KEY (id);


--
-- Name: userinfo userinfo_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.userinfo
    ADD CONSTRAINT userinfo_pkey PRIMARY KEY (id);


--
-- Name: userstats userstats_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.userstats
    ADD CONSTRAINT userstats_pkey PRIMARY KEY (id);


--
-- Name: userimagevotes fk_imageid; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.userimagevotes
    ADD CONSTRAINT fk_imageid FOREIGN KEY (imageid) REFERENCES public.images(id) ON DELETE CASCADE;


--
-- Name: imagecomments fk_imageid; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.imagecomments
    ADD CONSTRAINT fk_imageid FOREIGN KEY (imageid) REFERENCES public.images(id) ON DELETE CASCADE;


--
-- Name: userimagefavourites fk_imageid; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.userimagefavourites
    ADD CONSTRAINT fk_imageid FOREIGN KEY (imageid) REFERENCES public.images(id) ON DELETE CASCADE;


--
-- Name: imagestats fk_imageid; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.imagestats
    ADD CONSTRAINT fk_imageid FOREIGN KEY (imageid) REFERENCES public.images(id) ON DELETE CASCADE;


--
-- Name: userimagevotes fk_userid; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.userimagevotes
    ADD CONSTRAINT fk_userid FOREIGN KEY (userid) REFERENCES public.userinfo(id) ON DELETE CASCADE;


--
-- Name: userstats fk_userid_userinfo; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.userstats
    ADD CONSTRAINT fk_userid_userinfo FOREIGN KEY (userid) REFERENCES public.userinfo(id) ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--

