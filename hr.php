<?php
$agora = date("Y-m-d h:i:s");
$agora2 = date("Y-m-d h:i:s", strtotime('+3 hours'));

echo $agora.'<br>';
echo $agora2;
?>
