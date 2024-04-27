<?php
require_once '/var/lib/vendor/autoload.php';

$twig = require 'shared/twig_init.php';

$operators = [
    'add' => '+',
    'sub' => '-',
    'mul' => '*',
    'div' => '/'
];

$valid_operator = function ($operator) use ($operators) {
    return in_array($operator, array_keys($operators));
};


if (
    filter_input(INPUT_POST, 'a', FILTER_VALIDATE_FLOAT) &&
    filter_input(INPUT_POST, 'b', FILTER_VALIDATE_FLOAT) &&
    filter_input(INPUT_POST, 'operator', FILTER_CALLBACK, array('options' => $valid_operator))
) {
    switch ($_POST['operator']) {
        case 'add': $result = $_POST['a'] + $_POST['b']; break;
        case 'sub': $result = $_POST['a'] - $_POST['b']; break;
        case 'mul': $result = $_POST['a'] * $_POST['b']; break;
        case 'div': $result = $_POST['a'] / $_POST['b']; break;
        default:
    }
    echo $twig->load('step2.html')->render([
        'result' => $result,
        'operator' => $operators[$_POST['operator']],
        'a' => $_POST['a'],
        'b' => $_POST['b']
    ]);
    exit;
}

echo $twig->load('step1.html')->render();
