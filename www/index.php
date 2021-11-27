<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Language" content="Ru" />
    <script src="https://code.jquery.com/jquery-3.3.1.js"
        integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <link href="./assets/css/reset.css" rel="stylesheet">
    <link href="./assets/css/main.css" rel="stylesheet">
</head>

<body>
    <div class="main_content">
        <section class="text-color d-flex justify-content-center mt-5">
            <form class="text-color__form" id="TextColor" method="post">
                <div class="text-color__form__items">
                    <div class="text-color__form__items__item">
                        <label for="red">Red</label>
                        <input type="number" name="red" id="red" min="0" max="255" value="255">
                    </div>
                    <div class="text-color__form__items__item">
                        <label for="green">Green</label>
                        <input type="number" name="green" id="green" min="0" max="255" value="255">
                    </div>
                    <div class="text-color__form__items__item">
                        <label for="blue">Blue</label>
                        <input type="number" name="blue" id="blue" min="0" max="255" value="255">
                    </div>
                </div>
                <button type="submit">Change</button>
                <span class="text-color__result" id="text-color__result">Text for testing</span>
            </form>
        </section>

        <section class="d-flex flex-column mt-5">
            <form class="calendar__form" id="calendarForm">
                <div class="text-color__form__items">
                    <div class="text-color__form__items__item">
                        <label for="month">Month</label>
                        <input type="number" name="month" id="month" min="1" max="12" value="" placeholder="M">
                    </div>
                </div>
                <button class="mt-3" type="submit">Change</button>
            </form>
            <div class="calendar" id="calendar">
                <div class="calendar__week">
                    <div class="calendar__week__day">Mo</div>
                    <div class="calendar__week__day">Tu</div>
                    <div class="calendar__week__day">We</div>
                    <div class="calendar__week__day">Th</div>
                    <div class="calendar__week__day">Fr</div>
                    <div class="calendar__week__day calendar__week__day--red">Sa</div>
                    <div class="calendar__week__day calendar__week__day--red">Su</div>
                </div>
            </div>
        </section>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {

            $('#TextColor').submit(function (e) {
                e.preventDefault();

                $.ajax({
                    type: 'POST',
                    url: "common.php",
                    data: {
                        action: 'changeText',
                        red: $('#red').val(),
                        green: $('#green').val(),
                        blue: $('#blue').val()
                    },
                    beforeSend: function () {
                        $('#text-color__resut').css('display', 'none');
                    },
                    success: function (data) {
                        console.log(data);
                        data = JSON.parse(data);
                        console.log(data);
                        if (data['success']) {
                            $('#text-color__result').css('background-color', data[
                                'background-color']);
                            $('#text-color__result').css('color', data['color']);
                        }
                    },
                    error: function (errors) {}
                });

            });

            $('#calendarForm').submit(function (e) {
                e.preventDefault();

                if ($('#month').val() == '') {
                    return alert('Вы не ввели месяц!');
                }

                $.ajax({
                    type: 'POST',
                    url: "common.php",
                    data: {
                        action: 'calendar',
                        month: $('#month').val()
                    },
                    beforeSend: function () {
                        let html = '<div class="calendar__week">\n' +
                            '            <div class="calendar__week__day">Mo</div>\n' +
                            '            <div class="calendar__week__day">Tu</div>\n' +
                            '            <div class="calendar__week__day">We</div>\n' +
                            '            <div class="calendar__week__day">Th</div>\n' +
                            '            <div class="calendar__week__day">Fr</div>\n' +
                            '            <div class="calendar__week__day calendar__week__day--red">Sa</div>\n' +
                            '            <div class="calendar__week__day calendar__week__day--red">Su</div>\n' +
                            '        </div>';
                        $('#calendar').html(html);
                    },
                    success: function (data) {
                        data = JSON.parse(data);

                        let tmp = $('#calendar').html();
                        tmp += data;

                        $('#calendar').html(tmp);
                    },
                    error: function (errors) {
                        alert(errors);
                    }
                });

            });
        });
    </script>
</body>

</html>