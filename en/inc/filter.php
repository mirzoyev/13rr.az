<?php

$dbh = db_connect();

function arr_drtdx_r_dritt_fill() {
 global $dbh, $user_id;
 $res = array();
 $rs = $dbh->prepare("exec dbo.list_user_restaurants_only ".$user_id);
 $rs->execute();
 if (($dbh->errorCode() == "00000") && ($rs->errorCode() == "00000")) while ($r = $rs->fetchObject()) $res[$r->id] = $r->title;
 unset($rs);

 return $res;
}

$arr_drtdx_r_dritt = arr_drtdx_r_dritt_fill();

function arr_drtdx_r_dritt_out($x) {
 global $arr_drtdx_r_dritt;
 $r = "";
 foreach($arr_drtdx_r_dritt as $a => $b) $r.= "<option".(($a == $x) ? " selected":"")." value=\"".$a."\">".$b."</option>";
 return $r;
}

echo "<form method=\"POST\" action=\"$script\" class=\"filter_form\">";
echo "from:<input type=\"text\" name=\"d1\" value=\"$d1\">";
echo "&nbsp;till:<input type=\"text\" name=\"d2\" value=\"$d2\">";
echo "&nbsp;<select name=\"r\"><option value=\"\">all</option>".arr_drtdx_r_dritt_out($r)."</select>";
echo "&nbsp;<input type=\"submit\" value=\"change\"></form>";

?>

