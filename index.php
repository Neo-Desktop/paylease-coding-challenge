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
    echo 'Filename: '. basename(__FILE__) .'<br /><br />';
    highlight_file(__FILE__);
    echo '<hr>';

    foreach ($files as $key => $value)
    {
        echo 'Filename: '. basename($value) .'<br /><br />';
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
    '^',
];

//--------------------------------------------- lets begin -----------------


$in = input();
$out = output(true);

if (!empty($in['payload']) && !empty($in['payload']['line']))
{
    $line = $in['payload']['line'];

    $line = explode(' ', $line); //space separated input
    $line = array_filter($line);

    $steps = $stack = [];

    if (count($line) < 3)
    {
        $out = output(false);
        $out['Payload']['Error']['Message'] = "Input needs at least three operands";
        $out['Payload']['Input'] = $in['payload']['line'];
        response($out);
        exit; //exit early
    }

    $argc = count($line);

    /**
     * This loops over each element in the input array
     *
     * Numbers in the input are unshift()ed into $stack
     * Operations calculate the first two arguments shift()ed from $stack
     */
    for ($i = 0; $i < $argc;)
    {
        // numbers are added to the stack
        if (is_numeric($line[$i]) && !empty($line[$i]))
        {
            array_unshift($stack, $line[$i]);
            $i++;
            continue;
        }

        // operations calculate the stack
        else if (in_array($line[$i], $operations))
        {
            $o2 = array_shift($stack); // operation pairing
            $o1 = array_shift($stack); // order matters here
            $op = $line[$i]; // line cursor

            //actual calc
            if (!empty($o1) && !empty($o2) && !empty($op))
            {
                if ($op == '^') { // shim for PHP exponent syntax
                    $op = '**';
                }
                if ($op == 'x') { // shim for multiplication
                    $op = '*';
                }

                $result = eval('return '. $o1.$op.$o2 .';'); //calc here
                array_unshift($stack, $result);

                $steps[] = [
                    'o1' => $o1,
                    'o2' => $o2,
                    'op' => $op,
                    'eval' => $o1.$op.$o2,
                    'result' => $result,
                ]; // debug individual steps
            }
            else //we're missing something
            {
                $out = output(false);
                $out['Payload']['Error'] = [
                    'Message'   => 'Error executing operation '. $op,
                    'Arguments' => [
                        'o1' => $o1,
                        'o2' => $o2,
                        'op' => $op,
                    ],
                    'Stack' => $stack,
                ];
            }
            $i++;
        }

        // anything else is a syntax error
        else
        {
            $out = output(false);
            $out['Payload']['Error'] = [
                'Message' => "Syntax error at argument '".$line[$i]."'",
            ];
            break;
        }
    }

    //final output validation
    if (!empty($stack[0]) && count($stack[0]) == 1)
    {
        // success
        $out['Payload']['Answer'] = array_shift($stack);
        $out['Payload']['Steps'] = $steps;
        $out['Payload']['Input'] = $in['payload']['line'];
    }
    else
    {
        // failure
        if (empty($out))
        {
            $out = output(false);
            $out['Payload']['Error']['Message'] = 'Unable to calculate result';
        }
        $out['Payload']['Steps'] = $steps;
        $out['Payload']['Input'] = $in['payload']['line'];
    }
}
else
{
    $out = output(false);
    $out['Payload']['Error']['Message'] = "Empty input line received";
    $out['Payload']['Input'] = $in['payload']['line'];
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
    // always calculate time
    $in['Meta']['TimeOut'] = microtime(true);
    $in['Meta']['Duration'] = round($in['Meta']['TimeOut'] - $_SERVER["REQUEST_TIME_FLOAT"], 5);

    header('Content-Type: application/json;charset=UTF-8'); // make sure we are json
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
        $out['Payload']['Error']['Message'] = 'Caught exception decoding JSON';
        response($out);
        exit;
    }

    if (empty($in))
    {
        $out['Payload']['Error']['Message'] = 'Input was empty';
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
