<?php
$value =1;
echo $value < 10 ? '00'.$value : ($value < 100 ? '0'.$value : $value);