<!DOCTYPE html>
<html>
    <head>
        <title>Yetz Card - Desafio Técnico</title>

        <!--Import materialize.css-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

        <!--JQuery-->
        <script
            src="https://code.jquery.com/jquery-3.6.0.js"
            integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
            crossorigin="anonymous">
        </script>

    </head>

    <script>
        var contentToastMsg = "";
        var contentToastMsgColor = "";
    </script>

    <body>

        <header>
            <nav class="menu orange">
                <div class="nav-wrapper">
                    <a href="#" class="brand-logo" style="font-size: 1.4rem; margin-left: 10px;">Yetz Cards - Desafio Técnico</a>
                    <ul id="nav-mobile" class="right hide-on-med-and-down">
                        <li><a href="{{ route("home") }}"><b>Home</b></a></li>
                        <li><a href="{{ route("jogadores") }}"><b>Jogadores</b></a></li>
                        <li><a href="{{ route("sorteios") }}"><b>Sorteios</b></a></li>
                    </ul>
                </div>
            </nav>

        </header>



