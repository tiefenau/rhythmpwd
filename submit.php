<?php
    $dbconn = pg_connect("host=pg dbname=rhythm user=postgres") or die('Verbindungsaufbau fehlgeschlagen: ' . pg_last_error());

    $data = json_decode(file_get_contents("php://input"));

    $id = $data->id;
    $inputs = $data->inputs;

    $params = array(
        "trainings" => $data->trainings,
        "uid" => $id
    );

    pg_insert($dbconn, "runs", $params);

    $result = pg_query("SELECT max(id) from runs where uid = ".$id);

    $new_id = pg_fetch_row($result)[0];

    for ($x = 0; $x < count($inputs); $x++) {
        $cur_input = $inputs[$x];

        $params = array(
            "run_id" => $new_id,
            "training" => $cur_input[1],
            "input" => $cur_input[0]
        );

        $array_txt = "array[";
        for($y = 0; $y < count($cur_input[0]); $y++){
           $array_txt .= $cur_input[0][$y].",";
        }
        $array_txt = substr($array_txt, 0, -1)."]";

        pg_query("INSERT INTO inputs (input, training, run_id) VALUES (".$array_txt.",".($cur_input[1] == 1?"true":"false").",".$new_id.")");
    }

?>

