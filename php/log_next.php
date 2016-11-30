<?php
    $dbconn = pg_connect("host=postgres dbname=rhythm user=postgres") or die('Verbindungsaufbau fehlgeschlagen: ' . pg_last_error());
    $data = json_decode(file_get_contents("php://input"));

    $params = array(
        "run_id" => $data->run_id,
        "page" => $data->page,
        "duration" => $data->duration
    );

    pg_insert($dbconn, "durations", $params);

    switch($data->page){
        case 4:
            pg_query("UPDATE runs SET password = '".$data->password."' WHERE id = ".$data->run_id);
        case 5:
        case 6:
        case 7:
        case 8:
        case 10:
            $array_txt = "array[";
            for($y = 0; $y < count($data->input); $y++){
               $array_txt .= $data->input[$y].",";
            }
            $array_txt = substr($array_txt, 0, -1)."]";

            $arrayshift_txt = "array[";
            for($y = 0; $y < count($data->shifts); $y++){
               $arrayshift_txt .= $data->shifts[$y].",";
            }
            $arrayshift_txt = substr($arrayshift_txt, 0, -1)."]";

            pg_query("INSERT INTO inputs (input, shifts, run_id, pwd, backspaces, firstkeypress, requirementserror) VALUES (".$array_txt.",".$arrayshift_txt.",".$data->run_id.", '".$data->password."',".$data->backspaces.",".$data->firstkeypress.",'".$data->requirementserror."')");

            break;

        case 9:
            pg_query("INSERT INTO survey (age, gender, instrument, browser, run_id, q1, q2, q3, q4, q5, q6, q7, q8, q9, q10, q11, q12, q13, q14, q15, q16, q17) VALUES (".
                       "'".$data->age."',".$data->gender.",".$data->instrument.",'".$data->browser."',".$data->run_id.",".
                       $data->q1.",". $data->q2.",". $data->q3.",". $data->q4.",". $data->q5.",". $data->q6.",". $data->q7.",". $data->q8.",".
                       $data->q9.",". $data->q10.",". $data->q11.",". $data->q12.",". $data->q13.",". $data->q14.",". $data->q15.",". $data->q16.",". $data->q17 .")");
            break;
    }

    if($data->page >= 4 && $data->page <=8){
        $result = pg_query("SELECT id FROM runs WHERE id = ".$data->run_id." AND password = '".$data->password."'");
        if(pg_num_rows($result) == 0){
            echo "0";
        }
    }

    if($data->page == 10){
        $result = pg_query("SELECT checkcode FROM runs where id = ".$data->run_id);
        echo pg_fetch_row($result)[0];
    }
?>
