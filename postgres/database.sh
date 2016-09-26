#!/bin/bash
set -e

psql --username "$POSTGRES_USER" <<-EOSQL
    CREATE DATABASE rhythm;
EOSQL

psql --username "$POSTGRES_USER" rhythm<<-EOSQL
    create table runs (id serial primary key, trainings integer, date timestamp default current_timestamp, uid integer, password text, mturkid text, rhythm boolean, rule boolean, checkcode text);
    create table inputs (id serial PRIMARY KEY, run_id integer CONSTRAINT f_ir REFERENCES runs(id),input int[], training boolean, pwd text, pwdtest text);
    create table survey (id serial primary key, findrhythm integer, easyrhythm integer, age integer, browser text, instrument integer, run_id integer constraint s_ir references runs(id));
EOSQL