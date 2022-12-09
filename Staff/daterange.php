<?php
include('../Includes/header.php');
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>jQuery UI Datepicker functionality</title>
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

    <!-- Javascript -->

    <script>
        $(function() {

            var minDate = new Date();
            minDate.setDate(minDate.getDate())

            var range = 5;
            var start = "2021-09-10";
            var today = new Date(start);
            today = today.getTime() //time milliseconds
            var fourDays = today + (range * (24 * 60 * 60 * 1000)); //plus 4 days

            $('#dt').datepicker({
                dateFormat: 'yy-mm-dd',
                timepicker: false,
                minDate: minDate,
                beforeShowDay: function(date) {
                    var time = date.getTime();
                    return [time < today || time >= fourDays];
                }

            });

            $('#toggle').on('click', function() {
                $('#dt').datepicker('toggle')
            })



        });
    </script>

    <style>
        div.ui-datepicker {
            font-size: 1.5rem;
        }
    </style>
</head>

<body>
    <!-- HTML -->
    <form action="#" method="POST">
        <div class="input-group">
            <div class="input-group-prepend">
                <button type="button" id="toggle" class="input-group-text"><i class="fa fa-calendar-alt"></i></button>
            </div>
            <input type="text" class="col-sm-2 col-xl-12 form-control" name="Sarival" id="dt" placeholder="select date and time" />
        </div>

        <input type="submit" name="btnsubmit" value="Save">
    </form>
    <?php
    include('../Includes/footer.php');

    ?>

    <?php
    include('../Includes/conn.php');

    if (isset($_POST['btnsubmit'])) {
    }



    ?>