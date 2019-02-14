<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Aesthethics</title>
    <link href="https://fonts.googleapis.com/css?family=Press+Start+2P" rel="stylesheet">
    <style>
        @font-face {
          font-family: 'PressStart2P';
          font-style: normal;
          font-weight: 400;
          src: local('Press Start 2P Regular'), local('PressStart2P-Regular'), url(https://fonts.gstatic.com/s/pressstart2p/v7/e3t4euO8T-267oIAQAu6jDQyK3nVivM.woff2) format('woff2');
          unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }
                /* cyrillic-ext */
        @font-face {
          font-family: 'PressStart2P';
          font-style: normal;
          font-weight: 400;
          src: local('Press Start 2P Regular'), local('PressStart2P-Regular'), url(https://fonts.gstatic.com/s/pressstart2p/v7/e3t4euO8T-267oIAQAu6jDQyK3nYivN04w.woff2) format('woff2');
          unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
        }
        /* cyrillic */
        @font-face {
          font-family: 'PressStart2P';
          font-style: normal;
          font-weight: 400;
          src: local('Press Start 2P Regular'), local('PressStart2P-Regular'), url(https://fonts.gstatic.com/s/pressstart2p/v7/e3t4euO8T-267oIAQAu6jDQyK3nRivN04w.woff2) format('woff2');
          unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
        }
        body
        {
            font-family: 'PressStart2P';
            background: url(https://cdn.glitch.com/8c44c056-16d9-43cb-85f8-3ac42ac960cb%2Fdownload.gif?1550066772612);
            background-size: cover;
            height: 100vh;
            overflow: hidden;
            margin: 0;
            display: -webkit-flex;
            display: -moz-flex;
            display: -ms-flex;
            display: -o-flex;
            display: flex;
            justify-content: center;
            -ms-align-items: center;
            align-items: center;
        }
        #charmap
        {
            padding: 20px;
            background: black;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
    <canvas id="charmap"width="1920" height="1080"></canvas>

    <script>
        var canvas = document.getElementById('charmap');

        var ctx = canvas.getContext('2d');

        let blink = false;
        setInterval(function() {blink = !blink;}, 500);
        let width = 60;
        let height = 30; 
        let w = 16;
        let h = 24;
        canvas.width = width*w+10;
        canvas.height = height*h;
        ctx.font = "16px PressStart2P";
        ctx.fillStyle = "white";
        var snd;
        let curx = 0;
        let cury = 0;
        let input = "";

        let commands = {
            // 'sum': {
            //     process: function(argv)
            //     {
            //         //console.log(argv.length)
            //         if (argv.length > 3) 
            //         {
            //             writestr('Incorrect amount of parameters');
            //         }
            //         writestr(''+(parseInt(argv[1])+parseInt(argv[2])));
            //         cury++;
            //     },
            //     'desc': "Sums 2 numbers"
            // },
            'sum': {
                process: function(argv)
                {
                    var num = 0;
                    if (argv.length < 3) 
                    {
                        writestr('Incorrect amount of parameters');
                        return;
                    }

                    for (let i = 1; i < argv.length; i++)
                    {
                        num += parseInt(argv[i]);
                    }
                    //console.log(argv.length)

                    writestr(''+num);
                    // cury++;
                },
                'desc': "Sums numbers"
            },
            'help':
            {
                process: function(argv)
                {
                    writestr("Aesthethic shell v1.0")
                    cury++;
                    printHelp();
                },
                'desc': "Prints help"
            },
            'theme':
            {
                process: function(argv)
                {
                    if (argv.length <= 1)
                    {
                        writestr('Choose a theme: default, commodore, apple2, small, big');
                        return;
                    }

                    if (argv[1] == "commodore")
                    {
                        canvas.style.background = "#4040E0";
                        canvas.style.boxShadow = "0 0 0 200px #A0A0FF";
                        ctx.fillStyle = "#A0A0FF";
                    }
                    else if (argv[1] == "default")
                    {
                        canvas.style.background = "#000";
                        canvas.style.boxShadow = "none";
                        ctx.fillStyle = "#FFF";
                    }
                    else if (argv[1] == "apple2")
                    {
                        canvas.style.background = "#000";
                        canvas.style.boxShadow = "none";
                        ctx.fillStyle = "#0F0";
                    }
                    else if (argv[1] == "small")
                    {
                        ctx.font = "8px PressStart2P";
                        w = 8;
                        h = 8;
                        width = 120;
                        height = 60;
                    }
                    else if (argv[1] == "big")
                    {   
                        ctx.font = "16px PressStart2P";
                        w = 16;
                        h = 16;
                        width = 60;
                        height = 30;
                    }
                    else
                    {
                        writestr('theme not found');    
                    }
                },
                'desc': "Choose a theme: default, commodore, apple2, small, big"
            },
            'hello':
            {
                process: function(argv)
                {
                    writestr('Hello! =)');
                },
                'desc': "Greets you"
            },
            'clear':
            {
                process: function(argv)
                {
                    curx = 0;
                    cury = 0;
                    for (let i = 0; i < height; i++)
                    {
                        for (let j = 0; j < width; j++)
                        {
                            charmap[i][j] = 0;
                        }
                    }
                },
                'desc': "Clears screen"
            },
            'player':
            {
                process: function(argv)
                {
                    if (argv.length <= 1)
                    {
                        writestr('Incorrect amount of parameters');
                        return;
                    }
                    if (argv[1] == "stop")
                    {
                        if (snd == undefined)
                        {
                            writestr('no music is playing');
                            return;
                        }
                        snd.pause();
                        return;
                    }
                    if (argv[1] == "macintosh_plus")
                    {
                        snd = new Audio("https://cdn.glitch.com/8c44c056-16d9-43cb-85f8-3ac42ac960cb%2F%E3%83%AA%E3%82%B5%E3%83%95%E3%83%A9%E3%83%B3%E3%82%AF420-_-%E7%8F%BE%E4%BB%A3%E3%81%AE%E3%82%B3%E3%83%B3%E3%83%94%E3%83%A5%E3%83%BC.mp3?1550066683432"); // buffers automatically when created
                        snd.play();
                        writestr('done');
                    }
                    else
                    {
                        writestr('song not found');
                    }

                },
                'desc': "Play song"
            }
        }


        function printHelp() {
            
            for (var key in commands) 
            {
                writestr(key + ": " + commands[key]['desc']);
                cury++;
            }
        }

        let charmap = new Array(width);
        for (let i = 0; i < width; i++)
        {
            charmap[i] = new Array(height);
        }

        for (let i = 0; i < height; i++)
        {
            for (let j = 0; j < width; j++)
            {
                charmap[i][j] = 0;
            }
        }

        function writestr(str) {
            let offsety = 0;
            let offsetx = 0;
            curx = 0;
            for (let i = 0; i < str.length; i++)
            {
                charmap[cury+offsety][curx+offsetx] = str[i];
                offsetx++;
                if (curx+offsetx >= width)
                {
                    cury++;
                    offsetx = 0;
                }
                if (cury >= height-1)
                {
                    commands['clear'].process(0);
                    break;
                }
            }
        }

        function putc_input(c) {
            charmap[cury][curx] = c;
            curx++;
            if (curx >= width)
            {
                curx = 0;
                cury++;
            }
        }
        function rmc_input() {
            charmap[cury][curx-1] = 0;
            curx--;
            if (curx <= 0)
            {
                curx = width-1;
                cury++;
            }
        }

        function writestr_input(str) {
            let offsety = 0;
            let offsetx = 0;
            for (let i = 0; i < str.length; i++)
            {
                putc_input(curx+offsety, cury+offsetx) = str[i];
                offsetx++;
                if (curx+offsetx >= width)
                {
                    offsety++;
                    offsetx = 0;
                }
            }
        }

        function writeAsh() {         
            cury++;   
            writestr('/bin/ash#=>');
            curx = 12;
        }


        writestr('Aesthethic Shell version 1.0, type `help` for help');
        cury += 2;
        writeAsh();

        function render()
        {

            ctx.clearRect(0, 0, canvas.width, canvas.height);
            if (blink) ctx.fillRect(10+curx*w, (50-h)+cury*h, w, h);
        

            let realmap = '';
            for (let i = 0; i < height; i++)
            {
                for (let j = 0; j < width; j++)
                {
                    if (charmap[i][j] === 0 || charmap[i][j] === undefined) {ctx.fillText(' ', 10+j*20, w+i*h); continue;};
                    //if (charmap[i][j] === '\n') {realmap+='<br>'; continue;};
                    ctx.fillText(charmap[i][j], 10+j*w, 50+i*h);
                    realmap += charmap[i][j];
                }

            }
        }

        function parseCommand(input) {
            let formatted = input.split(' ');
            if (input.trim() == '') return;
            try
            {
                commands[formatted[0]].process(formatted);
            }
            catch(e)
            {
                writestr('command "'+formatted[0]+'" not found');
            }
        }
        render();


        $(document).on('keydown', function(e){
            
            if (e.key.length == 1 || e.key == 'Enter' || e.key == 'Backspace')
            {
                if (e.key == 'Enter')
                {
                    cury++;
                    parseCommand(input);
                    writeAsh();
                    input = '';
                    render();
                    return;
                }
                if (e.key == 'Backspace')
                {
                    if (input == '') return;
                    rmc_input();
                    input = input.substr(0, input.length-1);
                    render();
                    return;
                }
                input += e.key;
                putc_input(e.key);


            }
            render();
        });

         setInterval(render, 500)
    </script>
</body>
</html>