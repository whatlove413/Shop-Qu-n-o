<?php
$t='levannhieu';
echo $t;
if(preg_match('/"/',$t))
    echo "yes";
else
    echo "no";