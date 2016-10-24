#!/bin/bash
set -e

psql --username "$POSTGRES_USER" <<-EOSQL
    CREATE DATABASE rhythm;
EOSQL

psql --username "$POSTGRES_USER" rhythm<<-EOSQL
    create table runs (id serial primary key, trainings integer, date timestamp default current_timestamp, password text, mturkid text, rhythm boolean, rule boolean, checkcode text);
    create table inputs (id serial PRIMARY KEY, run_id integer CONSTRAINT f_ir REFERENCES runs(id),input int[], pwd text, backspaces integer, firstkeypress integer, requirementserror text);
    create table survey (id serial primary key, age text, browser text, instrument integer, run_id integer constraint s_ir references runs(id), q1 integer, q2 integer, q3 integer, q4 integer, q5 integer, q6 integer, q7 integer, q8 integer, q9 integer, q10 integer, q11 integer, q12 integer, q13 integer, q14 integer, q15 integer, q16 integer, q17 integer);
    create table durations (id serial primary key, duration integer, page integer, run_id integer constraint n_ir references runs(id));
EOSQL