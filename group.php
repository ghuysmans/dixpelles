<?php
function select($fields) {
    return function($r) use($fields) {
        $arr = [];
        foreach ($fields as $f)
            $arr[$f] = $r[$f];
        return $arr;
    };
}

function group($q, $f) {
    $g = null;
    $arr = [];
    while ($r = $q->fetch()) {
        $k = $f($r);
        if ($g != $k) {
            if (!is_null($g)) {
                yield array('group' => $g, 'items' => $arr);
                $arr = [];
            }
            $g = $k;
        }
        $arr[] = $r;
    }
    yield array('group' => $g, 'items' => $arr);
}
