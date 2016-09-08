<?php
    $dbconn = pg_connect("host=pg dbname=postgres user=postgres") or die('Verbindungsaufbau fehlgeschlagen: ' . pg_last_error());

    $data = json_decode(file_get_contents("php://input"));

    $id = $data->id;
    $inputs = $data->inputs;

    $params = array(
        "options_id" => $data->options_id,
        "trainings" => $data->trainings,
        "password" => $data->password,
        "uid" => $id
    );

    pg_insert($dbconn, "runs", $params);

    $result = pg_query("SELECT max(id) from runs where uid = ".$id);

    $new_id = pg_fetch_row($result)[0];

    for ($x = 0; $x < count($inputs); $x++) {
        $cur_input = $inputs[$x];

        $array_txt = "array[";
        for($y = 0; $y < count($cur_input[0]); $y++){
           $array_txt .= $cur_input[0][$y].",";
        }
        $array_txt = substr($array_txt, 0, -1)."]";

        pg_query("INSERT INTO inputs (input, training, run_id, pwd, pwdtest) VALUES (".$array_txt.",".($cur_input[3] == 1?"true":"false").",".$new_id.", '".$cur_input[1]."','".$cur_input[2]."')");
    }

?>

