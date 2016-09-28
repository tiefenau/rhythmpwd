<?php
    $dbconn = pg_connect("host=postgres dbname=rhythm user=postgres") or die('Verbindungsaufbau fehlgeschlagen: ' . pg_last_error());
    $data = json_decode(file_get_contents("php://input"));

    $params = array(
        "mturkid" => $data->mturkid,
        "rhythm" => $data->rhythm,
        "rule" => $data->rule,
        "trainings" => $data->trainings,
        "checkcode" => substr(str_shuffle(str_repeat($x='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(20/strlen($x)) )),1,20)
    );

    pg_insert($dbconn, "runs", $params);
    $result = pg_query("SELECT max(id) from runs where mturkid = '".$data->mturkid."'");
    $new_id = pg_fetch_row($result)[0];

    pg_query("INSERT INTO durations (duration, page, run_id) VALUES (".$data->duration.",".$data->page.",".$new_id.")");
    echo $new_id;
?>