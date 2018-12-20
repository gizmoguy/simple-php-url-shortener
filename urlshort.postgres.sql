--
-- PostgreSQL database dump
--

-- Dumped from database version 9.6.10
-- Dumped by pg_dump version 9.6.10

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: urlshort; Type: DATABASE; Schema: -; Owner: postgres
--

CREATE DATABASE urlshort WITH TEMPLATE = template0 ENCODING = 'UTF8' LC_COLLATE = 'en_NZ.UTF-8' LC_CTYPE = 'en_NZ.UTF-8';


ALTER DATABASE urlshort OWNER TO postgres;

\connect urlshort

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: urlshort; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.urlshort (
    id integer NOT NULL,
    longurl text NOT NULL,
    created timestamp with time zone DEFAULT now() NOT NULL,
    hits integer DEFAULT 0 NOT NULL,
    lastused timestamp with time zone
);


ALTER TABLE public.urlshort OWNER TO postgres;

--
-- Name: urlshort_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.urlshort_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.urlshort_id_seq OWNER TO postgres;

--
-- Name: urlshort_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.urlshort_id_seq OWNED BY public.urlshort.id;


--
-- Name: urlshort id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.urlshort ALTER COLUMN id SET DEFAULT nextval('public.urlshort_id_seq'::regclass);


--
-- Name: urlshort idx_24819_primary; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.urlshort
    ADD CONSTRAINT idx_24819_primary PRIMARY KEY (id);


--
-- PostgreSQL database dump complete
--
