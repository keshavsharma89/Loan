--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: loans; Type: TABLE; Schema: public; Owner: test; Tablespace: 
--

CREATE TABLE loans (
    "loanId" integer NOT NULL,
    "userId" bigint NOT NULL,
    amount numeric(10,2) NOT NULL,
    interest numeric(10,2) NOT NULL,
    duration integer NOT NULL,
    "dateApplied" date NOT NULL,
    "dateLoanEnds" date NOT NULL,
    campaign integer NOT NULL,
    status boolean
);


ALTER TABLE loans OWNER TO test;

--
-- Name: Loans_loanId_seq; Type: SEQUENCE; Schema: public; Owner: test
--

CREATE SEQUENCE "Loans_loanId_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE "Loans_loanId_seq" OWNER TO test;

--
-- Name: Loans_loanId_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: test
--

ALTER SEQUENCE "Loans_loanId_seq" OWNED BY loans."loanId";


--
-- Name: users; Type: TABLE; Schema: public; Owner: test; Tablespace: 
--

CREATE TABLE users (
    "userId" integer NOT NULL,
    "firstName" text NOT NULL,
    "lastName" text NOT NULL,
    email text NOT NULL,
    "personalCode" bigint NOT NULL,
    phone bigint NOT NULL,
    active boolean,
    "isDead" boolean,
    lang text
);


ALTER TABLE users OWNER TO test;

--
-- Name: Users_userId_seq; Type: SEQUENCE; Schema: public; Owner: test
--

CREATE SEQUENCE "Users_userId_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE "Users_userId_seq" OWNER TO test;

--
-- Name: Users_userId_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: test
--

ALTER SEQUENCE "Users_userId_seq" OWNED BY users."userId";


--
-- Name: migration; Type: TABLE; Schema: public; Owner: test; Tablespace: 
--

CREATE TABLE migration (
    version character varying(180) NOT NULL,
    apply_time integer
);


ALTER TABLE migration OWNER TO test;

--
-- Name: loanId; Type: DEFAULT; Schema: public; Owner: test
--

ALTER TABLE ONLY loans ALTER COLUMN "loanId" SET DEFAULT nextval('"Loans_loanId_seq"'::regclass);


--
-- Name: userId; Type: DEFAULT; Schema: public; Owner: test
--

ALTER TABLE ONLY users ALTER COLUMN "userId" SET DEFAULT nextval('"Users_userId_seq"'::regclass);


--
-- Name: Loans_pkey; Type: CONSTRAINT; Schema: public; Owner: test; Tablespace: 
--

ALTER TABLE ONLY loans
    ADD CONSTRAINT "Loans_pkey" PRIMARY KEY ("loanId");


--
-- Name: Users_pkey; Type: CONSTRAINT; Schema: public; Owner: test; Tablespace: 
--

ALTER TABLE ONLY users
    ADD CONSTRAINT "Users_pkey" PRIMARY KEY ("userId");


--
-- Name: migration_pkey; Type: CONSTRAINT; Schema: public; Owner: test; Tablespace: 
--

ALTER TABLE ONLY migration
    ADD CONSTRAINT migration_pkey PRIMARY KEY (version);


--
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

