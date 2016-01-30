<?php
/**
 * Created by PhpStorm.
 * User: Amrit
 * Date: 2016-01-25
 * Time: 7:53 PM
 */

// quick sanity checking

$files = [
    'html' => 'html.inc',
];

foreach ($files as $key => $value)
{
    if (!file_exists($value))
    {
        die ('Sanity check!'. $key .' does not exist');
    }
}

if (isset($_REQUEST['source']))
{
    echo 'Filename: '.  __FILE__ .'<br /><br />';
    highlight_file(__FILE__);
    echo '<hr>';

    foreach ($files as $key => $value)
    {
        echo 'Filename: '. $value .'<br /><br />';
        highlight_file($value);
        echo '<hr>';
    }
    exit; // exit early
}
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'GET')
{
    header('Content-Type: text/html;charset=UTF-8');
    readfile('html.inc');
    exit; // exit early
}
// quick git updating
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_REQUEST['pull']) && is_dir('.git'))
{
    shell_exec('git reset --hard HEAD && git pull');
    echo "success";
    exit; //exit early
}

//acceptable operations
$operations = [
    '+',
    '-',
    '*',
    '/',
    '%',
];

//--------------------------------------------- lets begin -----------------


$in = input();
$out = output(true);

if (!empty($in['payload']) && !empty($in['payload']['line']))
{
    $line = $in['payload']['line'];
    $line = explode(' ', $line);
    $line = array_filter($line);

    $out['Meta']['Input'] = print_r($line, true);

    $total = count($line) -1;
    $o1 = $o2 = $op = null;

    $steps = [];

    for ($i = 0; $i > $total;) // no default increment
    {
        if (empty($o1))
        {
            $o1 = array_shift($line);
            $i++;
            if (!is_numeric($o1))
            {
                $out = output(false);
                $out['Payload']['Error']['Message'] = "Error parsing operand ".$i;
                $out['Payload']['Error']['Parameter'] = $o1;
                break;
            }
        }
        if (empty($o2))
        {
            $o2 = array_shift($line);
            $i++;
            if (!is_numeric($o2))
            {
                $out = output(false);
                $out['Payload']['Error']['Message'] = "Error parsing operand ".$i;
                $out['Payload']['Error']['Parameter'] = $o2;
                break;
            }
        }

        die(print_r([$o1, $o2, $op]));

        if (empty($op))
        {
            $op = array_shift($line);
            $i++;
            if (!in_array($op, $operations))
            {
                $out = output(false);
                $out['Payload']['Error']['Message'] = "Error parsing operand ".$i;
                $out['Payload']['Error']['Parameter'] = $op;
                break;
            }
        }

        //actual calc
        if (!empty($o1) && !empty($o2) && !empty($op))
        {
            $steps[] = [
                'o1' => $o1,
                'o2' => $o2,
                'op' => $op,
                'eval' => $o1.$op.$o2,
            ];

            $o1 = eval($o1.$op.$o2);
            $o2 = $op = null;
        }
        else
        {
            break;
        }
    }
    $out['Payload']['Answer'] = $o1;
    $out['Payload']['Steps'] = $steps;
}
else
{
    $out = output(false);
    $out['Payload']['Error'] = "Empty input line received";
}

response($out);

exit; // logical end of program

//--------------------------------------------- functions here -------------

/**
 * JSON encodes input array for output
 *
 * @param array $in
 * Writes a JSON Object to standard out
 */
function response($in)
{
    $in['Meta']['TimeOut'] = microtime(true);
    $in['Meta']['Duration'] = round(5, $in['Meta']['TimeOut'] - $_SERVER["REQUEST_TIME_FLOAT"]);

    header('Content-Type: application/json;charset=UTF-8');
    echo json_encode($in);
}

/**
 * Reads from the PHP standard input and parses JSON
 *
 * @return array|null
 */
function input()
{
    $in = null;
    $out = output(false);

    try
    {
        $in = json_decode(file_get_contents('php://input'), true);
    }
    catch (Exception $e)
    {
        $out['Payload']['Error'] = 'Caught exception decoding JSON';
        response($out);
        exit;
    }

    if (empty($in))
    {
        $out['Payload']['Error'] = 'Input was empty';
        response($out);
        exit;
    }

    return $in;
}

/**
 * Returns a new output template array
 * @param bool $success
 * @return array
 */
function output($success = true)
{
    $out = [
        'Meta' => [
            'TimeIn' => $_SERVER["REQUEST_TIME_FLOAT"],
            'TimeOut' => 0,
            'Duration' => 0,
            'Success' => $success,
        ],
        'Payload' => [

        ],
    ];
    return $out;
}
