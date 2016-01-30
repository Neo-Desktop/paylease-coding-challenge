<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="author" content="Amrit Panesar">
    <meta name="keywords" content="Reverse,Polish,Notation,Calculator,Sausage">
    <meta name="description" content="A calculator that utilizes reverse polish notation">
    <meta name="joke" content="https://xkcd.com/645/">

    <title>Reverse Polish Notation Calculator</title>

    <!-- Styles //-->
    <link href="//maxcdn.bootstrapcdn.com/bootswatch/3.3.6/slate/bootstrap.min.css"
          rel="stylesheet"
          integrity="sha256-purz3wKA8uL+3JryAuYkSkIZL1CHBSzJ2UwvxAOmYmM= sha512-ge9yLSNqO8D9q8z+kLuUnluXxJTVKdLCwzYBS9rZ3eDW7oJK+mLjRsQa4995TpGINC4GWYi4S2ocDssunh1q3g=="
          crossorigin="anonymous">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <!-- Nav //-->
    <div class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <a href="#" class="navbar-brand">RPN Calc</a>
                <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="navbar-collapse collapse" id="navbar-main">

                <ul class="nav navbar-nav navbar-right">
                    <li><a href="http://neo.neo.yt" target="_blank">Amrit Panesar</a></li>
                </ul>

            </div>
        </div>
    </div>

    <!-- Body //-->
    <div class="container">
        <!-- Header //-->
        <div class="page-header" id="banner">
            <div class="row">
                <div class="col-lg-8 col-md-7 col-sm-6">
                    <h1>Reverse Polish Calculator</h1>
                    <p class="lead">By <a href="http://neo.neo.yt">Amrit Panesar</a></p>
                </div>
            </div>
        </div>

        <!-- Content //-->
        <div class="row">
            <div class="col-xs-4">
                <div class="well">
                    <div class="row">
                        <div class="form-group">
                            <input title="Calculator line" class="form-control" id="line" type="text" value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-1">
                            <a class="num btn btn-info" data-rpn="/">/</a>
                        </div>
                        <div class="col-xs-1">
                            <a class="num btn btn-info" data-rpn="*">*</a>
                        </div>
                        <div class="col-xs-1">
                            <a class="num btn btn-info" data-rpn="-">-</a>
                        </div>
                        <div class="col-xs-1">
                            <a class="num btn btn-info" data-rpn="+">+</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-1">
                            <a class="num btn btn-default" data-rpn="7">7</a>
                        </div>
                        <div class="col-xs-1">
                            <a class="num btn btn-default" data-rpn="8">8</a>
                        </div>
                        <div class="col-xs-1">
                            <a class="num btn btn-default" data-rpn="9">9</a>
                        </div>
                        <div class="col-xs-1">
                            <a class="num btn btn-info" data-rpn="%">%</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-1">
                            <a class="num btn btn-default" data-rpn="4">4</a>
                        </div>
                        <div class="col-xs-1">
                            <a class="num btn btn-default" data-rpn="5">5</a>
                        </div>
                        <div class="col-xs-1">
                            <a class="num btn btn-default" data-rpn="6">6</a>
                        </div>
                        <div class="col-xs-1">
                            <a class="num btn btn-info" data-rpn="^">^</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-1">
                            <a class="num btn btn-default" data-rpn="1">1</a>
                        </div>
                        <div class="col-xs-1">
                            <a class="num btn btn-default" data-rpn="2">2</a>
                        </div>
                        <div class="col-xs-1">
                            <a class="num btn btn-default" data-rpn="3">3</a>
                        </div>
                        <div class="col-xs-1">
                            <a class="num btn btn-danger" data-rpn="clear">C</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-1">
                            <a class="num btn btn-default" data-rpn="0">0</a>
                        </div>
                        <div class="col-xs-1">
                            <a class="num btn btn-default" data-rpn=".">.</a>
                        </div>
                        <div class="col-xs-1">
                            <a class="num btn btn-success" data-rpn="send">ENT</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-8">
                <div class="row well">
                    <h4>Calculator Log</h4>
                    <div id="loglines"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts //-->
    <script src="//code.jquery.com/jquery-2.1.4.min.js"
            integrity="sha384-R4/ztc4ZlRqWjqIuvf6RX5yb/v90qNGx6fS48N0tRxiGkqveZETq72KgDVJCp2TC sha256-8WqyJLuWKRBVhxXIL1jBDD7SDxU936oZkCnxQbWwJVw="
            crossorigin="anonymous"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
            integrity="sha256-KXn5puMvxCw+dAYznun+drMdG1IFl3agK0p/pqT9KAo= sha512-2e8qq0ETcfWRI4HJBzQiA3UoyFk6tbNyG+qSaIBZLyW9Xf3sWZHN/lxe9fTh1U45DpPf07yj94KsUHHWe4Yk1A=="
            crossorigin="anonymous"></script>
    <script>

        //----------------- body is ready --------
        $(document).ready(function() {
            debug = true;

            $('[data-rpn]').click(function(e) { // select all rpn buttons
                line = $('#line');
                data = e.target.dataset.rpn;
                if (data != 'send' && data != 'clear') {
                    // not the enter key
                    appendOperand(data);
                    if (debug) {
                        console.log('Button Pushed ' + data + '\nLine is:' + line.val()); //debug
                    }
                }
                else if (data == 'send') {
                    // submit line
                    if (debug) {
                        console.log("Submitting line to backend");
                    }
                    sendLine();
                }
                else if (data == 'clear') {
                    if (debug) {
                        console.log("Clearing line and log");
                    }
                    line.val('');
                    $('#loglines').empty();
                }
            });

            $('html').keypress(function(e) {
                if (debug) {
                    //console.log(e);
                }

                keyi = e.which;
                keya = String.fromCharCode(keyi);

                if (!($("input").is(":focus"))) {
                    if (keya >= '0' && keya <= '9') {
                        appendOperand(parseInt(keya));
                    }
                    else if (
                        keyi == 32 ||   // <space>
                        keyi == 37 ||   // %
                        keyi == 42 ||   // *
                        keyi == 43 ||   // +
                        keyi == 45 ||   // -
                        keyi == 47 ||   // /
                        keyi == 94      // ^
                    )
                    {
                        appendOperand(keya);
                    }
                }
                if (keyi == 13) // enter
                {
                    sendLine();
                }
            });

            $('html').keydown(function (e) {
                //trap the backspace
                keyi = e.which;
                if ((keyi == $.ui.keyCode.BACKSPACE || keyi == $.ui.keyCode.DELETE) &&
                    !($("input").is(":focus"))) {
                    line = $('#line');
                    line.val(line.val().substring(0, line.val().length - 1));
                    e.preventDefault();
                }
            });
        });

        //---------------- functions here ----------------
        function appendOperand(data) {
            line = $('#line');
            line.val(line.val() + data);
        }

        function appendResponse(data) {
            // new row
            row = $('<div />', {
                class: 'row'
            });

            // add answer
            $('<pre/>', {
               text: data.Input + " = " + data.Answer
            }).appendTo(row);

            // add duration
            $('<p/>', {
                class: 'text-right',
                text: 'Duration: ' + data.Duration
            }).appendTo(row);

            // append to dom
            $(row).appendTo('#loglines');
            $('#line').val(data.Answer);
        }

        function validateLine() {
            return true;
        }

        function parseResponse(data) {
            if (data.Meta.Success == true) {
                out = {
                    Input: data.Payload.Input,
                    Duration: data.Meta.Duration,
                    Answer: data.Payload.Answer
                };
                appendResponse(out);
            } else {
                alert("Something went wrong\n"+data.Payload.Error.Message);
            }
        }

        function sendLine() {
            line = $('#line');
            line.val(line.val().trim());

            if (debug) {
                console.log('Sending line: '+ line.val());
            }

            if (validateLine()) {
                out = { meta: {}, payload: {line: line.val()} };
                $.ajax({
                    url: 'index.php',
                    type: 'POST',
                    data: JSON.stringify(out),
                    contentType: 'application/json; charset=utf-8',
                    dataType: 'json',
                    async: true,
                    success: function(msg) {
                        parseResponse(msg);
                    }
                });
                line.val('');
                line.focus();
            }
        }
    </script>
</body>
</html>