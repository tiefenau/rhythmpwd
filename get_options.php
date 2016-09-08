<?php
    $dbconn = pg_connect("host=pg dbname=postgres user=postgres") or die('Verbindungsaufbau fehlgeschlagen: ' . pg_last_error());

    $result = pg_query("select * from options where id = (SELECT o.id from options o left outer join runs r on o.id = r.options_id group by o.id order by count(*) limit 1)");

    $options = pg_fetch_row($result);

    echo "{\"options_id\":".$options[0].",\"rhythm\":".($options[1]=="t"?"true":"false").",\"rule\":".($options[2]=="t"?"true":"false")."}";
?>