<?php

function debug_print($obj) {
	echo '<!--';
    print_r($obj);
    echo '-->';
}