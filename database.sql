create database rhythm;
create table runs (id serial primary key, trainings integer, date timestamp default current_timestamp, uid integer);
create table inputs (id serial PRIMARY KEY, run_id integer CONSTRAINT f_ir REFERENCES runs(id),input int[], training boolean);