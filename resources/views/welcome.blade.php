<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>HTML5 Бронювання кімнат в готелі (JavaScript/PHP/MySQL)</title>
    <!-- допоміжні бібліотеки -->
    <script  src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js" type="text/javascript"></script>
    <!-- бібліотека daypilot -->
    <script src="{{asset('js/daypilot-all.min.js')}}" type="text/javascript"></script>
    <style>
        .scheduler_default_rowheader_inner
        {
            border-right: 1px solid #ccc;
        }
        .scheduler_default_rowheader.scheduler_default_rowheadercol2
        {
            background: #fff;
        }
        .scheduler_default_rowheadercol2 .scheduler_default_rowheader_inner
        {
            top: 2px;
            bottom: 2px;
            left: 2px;
            background-color: transparent;
            border-left: 5px solid #1a9d13; /* green */
            border-right: 0px none;
        }
        .status_dirty.scheduler_default_rowheadercol2 .scheduler_default_rowheader_inner
        {
            border-left: 5px solid #ea3624; /* red */
        }
        .status_cleanup.scheduler_default_rowheadercol2 .scheduler_default_rowheader_inner
        {
            border-left: 5px solid #f9ba25; /* orange */
        }
    </style>
</head>
<body>
<header>
    <div class="bg-help">
        <div class="inBox">
            <h1 id="logo">HTML5 Бронювання кімнат в готелі (JavaScript/PHP)</h1>
            <p id="claim">AJAX'овий Календар-застосунок з JavaScript/HTML5/jQuery</p>
            <hr class="hidden" />
        </div>
    </div>
</header>
<main>
    <div>
        <div>
            <label>Create room</label>
            <button id="newRoom">Create</button>
        </div>
        <div>
            <label>Show Room</label>
            <select id="filter">
                <option value="0" selected>Всі</option>
                <option value="1">Одномісні</option>
                <option value="2">Двомісні</option>
                <option value="4">Сімейні</option>
            </select>
        </div>
        <div id="nav">
            <div id="dp"></div>
        </div>
    </div>
</main>
<div class="clear">
</div>
<footer>
    <address>(с)Автор лабораторної роботи: студент спеціальності ІПЗ, Бургела Олександр</address>
</footer>
<script>
    var GlobalVariable = {!! $GlobalVariable !!};
</script>
<script src="{{asset('js/index.js')}}"></script>
</body>
</html>
