<?php

if (!isset($_SESSION)) {
    session_start();
}

if (empty($_SESSION) or ($_SESSION['compteType'] != "serveillant")) {
    header('location:./login.php');
}
?>
<?php
function Calc_Note($cef)
{
    global $db;
    // calc Abs
    $abs = $db->Select("absence", "Duree", "CEF = $cef");
    $sum = 0;
    foreach ($abs as $key => $value) {
        $sum += $value->Duree;
    }
    $Nombre_Absence = floor(($sum / 60) / 4);


    // calc Ret
    $ret = $db->Select("absence", "Count(*) as total", " CEF = $cef  and type = 'retard'");
    $Nombre_Retard = floor($ret[0]->total / 4);
    // Poins à deduire
    $points = ($Nombre_Absence + $Nombre_Retard);
    // Sanctions
    switch ($points) {
        case '0':
            $msg = "accune Sanctions";
            break;
        case '1':
            $msg = "1ére Mise en gargde";
            break;
        case '2':
            $msg = "2ére Mise en gargde";
            break;
        case '3':
            $msg = "1re avertissement";
            break;
        case '4':
            $msg = "2re avertissement";
            break;
        case '5':
            $msg = "Blâme";
            break;
        case '6':
            $msg = "Exclusion de 2 jours";
            break;
        case '7':
            $msg = "Exclusion temporaire ou définitive a l'appreciation du Conseil de Discipline";
            break;
        case '8':
            $msg = "Exclusion temporaire ou définitive a l'appreciation du Conseil de Discipline";
            break;
        case '9':
            $msg = "Exclusion temporaire ou définitive a l'appreciation du Conseil de Discipline";
            break;
        case '10':
            $msg = "Exclusion temporaire ou définitive a l'appreciation du Conseil de Discipline";
            break;
        default:
            $msg = "Exclusion Definitive";
            break;
    }
    // Note/15
    $note15 = 15 - $points;
    // note general
    $res = $db->Select('note', '*', "CEF = $cef");
    if (empty($res)) {
        $insert = $db->Insert('note', ['CEF', 'note'], [$cef, $note15]);
    } elseif ($res[0]->comportement == 0) {
        $update = $db->Update('note', "note = $note15", "CEF = $cef");
    }


    $data["Nombre_Absence"] = $Nombre_Absence;
    $data["Nombre_Retard"] = $Nombre_Retard;
    $data["points"] = $points;
    $data["msg"] = $msg;
    $data["note15"] = $note15;
    return $data;
}
?>