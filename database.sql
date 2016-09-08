create table options (id serial primary key, rhythm boolean, rule boolean);
create table runs (id serial primary key, trainings integer, date timestamp default current_timestamp, uid integer, password text, options_id int CONSTRAINT f_ro REFERENCES options(id));
create table inputs (id serial PRIMARY KEY, run_id integer CONSTRAINT f_ir REFERENCES runs(id),input int[], training boolean, pwd text, pwdtest text);

insert into options (rhythm, rule) values (true, true);
insert into options (rhythm, rule) values (true, false);
insert into options (rhythm, rule) values (false, true);
insert into options (rhythm, rule) values (false, false);