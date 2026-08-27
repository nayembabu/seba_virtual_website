@extends('layouts.app')

@section('title','Page Not Found')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Not Found</title>
    <style>
        @import "https://cdnjs.cloudflare.com/ajax/libs/bourbon/5.1.0/bourbon.min.css";

        $green: #1ff042;

        @keyframes cursor-blink {
            0% {
                opacity: 0;
            }
            50% {
                opacity: 1;
            }
            100% {
                opacity: 0;
            }
        }

        body {
            background-color: black;
            color: white;
            font-family: 'Courier New', Courier, monospace;
        }

        .container {
            position: relative;
            top: 0;
            left: 0;
            min-height: 100vh;
            min-width: 100vw;
            z-index: 2;
            background-color: black;
            transition: opacity 300ms ease-out;
            text-align: center;
        }

        .terminal {
            padding: 4rem;
        }

        .prompt {
            color: $green;
            display: block;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 0.9em;
            white-space: pre-wrap;
            line-height: 1;
            margin-bottom: 0.75em;
        }

        .new-output {
            display: inline-block;
        }

        .new-output:after {
            display: inline-block;
            vertical-align: -0.15em;
            width: 0.75em;
            height: 1em;
            margin-left: 5px;
            background: $green;
            animation: cursor-blink 1.25s steps(1) infinite;
            content: '';
        }

        .kittens {
            p {
                letter-spacing: 0;
                opacity: 0;
                line-height: 1rem;
            }
        }

        .kitten-gif {
            margin: 20px;
            max-width: 300px;
        }

        .four-oh-four-form {
            position: fixed;
            top: 0;
            left: 0;
            opacity: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <form class="four-oh-four-form">
            <input type="text" class="404-input" placeholder="Type a command...">
        </form>

        <div class="terminal">
            <p class="prompt">The page you requested cannot be found right meow. Try typing 'kittens'.</p>
            <p class="prompt output new-output"></p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        var inputReady = true;
        var input = $('.404-input');
        input.focus();
        $('.container').on('click', function() {
            input.focus();
        });

        input.on('keyup', function() {
            $('.new-output').text(input.val());
        });

        $('.four-oh-four-form').on('submit', function(e) {
            e.preventDefault();
            var val = $(this).children($('.404-input')).val().toLowerCase();
            if (val === 'kittens') {
                showKittens();
            } else {
                resetForm();
            }
        });

        function resetForm(withKittens) {
            var message = "Sorry that command is not recognized.";
            if (withKittens) {
                $('.kittens').removeClass('kittens');
                message = "Huzzzzzah Kittehs!";
            }

            $('.new-output').removeClass('new-output');
            input.val('');
            $('.terminal').append('<p class="prompt">' + message + '</p><p class="prompt output new-output"></p>');
            $('.new-output').velocity('scroll', { duration: 100 });
        }

        function showKittens() {
            $('.terminal').append("<div class='kittens'>" +
                "<p class='prompt'>                             ,----,         ,----,                                          ,---,</p>" +
                "<p class='prompt'>       ,--.                ,/   .`|       ,/   .`|                     ,--.              ,`--.' |</p>" +
                "<p class='prompt'>   ,--/  /|    ,---,     ,`   .'  :     ,`   .'  :     ,---,.        ,--.'|   .--.--.    |   :  :</p>" +
                "<p class='prompt'>,---,': / ' ,`--.' |   ;    ;     /   ;    ;     /   ,'  .' |    ,--,:  : |  /  /    '.  '   '  ;</p>" +
                "<p class='prompt'>:   : '/ /  |   :  : .'___,/    ,'  .'___,/    ,'  ,---.'   | ,`--.'`|  ' : |  :  /`. /  |   |  |</p>" +
                "<p class='prompt'>|   '   ,   :   |  ' |    :     |   |    :     |   |   |   .' |   :  :  | | ;  |  |--`   '   :  ;</p>" +
                "<p class='prompt'>'   |  /    |   :  | ;    |.';  ;   ;    |.';  ;   :   :  |-, :   |   \\ | : |  :  ;_     |   |  '</p>" +
                "<p class='prompt'>|   ;  ;    '   '  ; `----'  |  |   `----'  |  |   :   |  ;/| |   : '  '; |  \\  \\    `.  '   :  |</p>" +
                "<p class='prompt'>:   '   \\   |   |  |     '   :  ;       '   :  ;   |   :   .' '   ' ;.    ;   `----.   \\ ;   |  ;</p>" +
                "<p class='prompt'>'   : |.  \\ |   |  '     '   :  |       '   :  |   '   :  ;/| '   : |  ; .'  /  /`--'  /  `--..`;  </p>" +
                "<p class='prompt'>|   | '_\\.' '   :  |     ;   |.'        ;   |.'    |   |    \\ |   | '`--'   '--'.     /  .--,_   </p>" +
                "<p class='prompt'>'   : |     ;   |.'      '---'          '---'      |   :   .' '   : |         `--'---'   |    |`.  </p>" +
                "<p class='prompt'>;   |,'     '---'                                  |   | ,'   ;   |.'                    `-- -`, ; </p>" +
                "<p class='prompt'>'---'                                              `----'     '---'                        '---`'</p>" +
                "<p class='prompt'>                                                              </p></div>");

            var lines = $('.kittens p');
            $.each(lines, function(index, line) {
                setTimeout(function() {
                    $(line).css({ "opacity": 1 });
                    textEffect($(line));
                }, index * 100);
            });

            $('.new-output').velocity('scroll', { duration: 100 });

            setTimeout(function() {
                $.get('https://api.giphy.com/v1/gifs/random?api_key=dc6zaTOxFJmzC&tag=kittens', function(result) {
                    var gif = result.data.image_url;
                    $('.terminal').append('<img class="kitten-gif" src="' + gif + '"">');
                    resetForm(true);
                });
            }, (lines.length * 100) + 1000);
        }

        function textEffect(line) {
            var alpha = [';', '.', ',', ':', ';', '~', '`'];
            var animationSpeed = 10;
            var index = 0;
            var string = line.text();
            var splitString = string.split("");
            var copyString = splitString.slice(0);
            var emptyString = copyString.map(function(el) {
                return [alpha[Math.floor(Math.random() * (alpha.length))], index++];
            });

            emptyString = shuffle(emptyString);

            $.each(copyString, function(i, el) {
                var newChar = emptyString[i];
                toUnderscore(copyString, line, newChar);
                setTimeout(function() {
                    fromUnderscore(copyString, splitString, newChar, line);
                }, i * animationSpeed);
            });
        }

        function toUnderscore(copyString, line, newChar) {
            copyString[newChar[1]] = newChar[0];
            line.text(copyString.join(''));
        }

        function fromUnderscore(copyString, splitString, newChar, line) {
            copyString[newChar[1]] = splitString[newChar[1]];
            line.text(copyString.join(''));
        }

        function shuffle(array) {
            for (let i = array.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [array[i], array[j]] = [array[j], array[i]];
            }
            return array;
        }
    </script>
</body>
</html>


@endsection
