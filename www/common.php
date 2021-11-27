<?php

if (isset($_POST) && isset($_POST['action']) && !empty($_POST['action']))
{
    $res = array();
    switch ($_POST['action'])
    {
        case 'changeText':
            $res = action_ChangeText($_POST['red'], $_POST['green'], $_POST['blue']);
            break;
        case 'calendar':
            $res= action_GetCalendar($_POST['month']);
            break;
    }

    echo json_encode($res);
}


function action_ChangeText($r, $g, $b)
{
    return array('success' => true, 'background-color' => "rgb($r, $g, $b)", 'color' => '#c2c2c2');
}

function action_GetCalendar($month)
{
    $curentDate = new DateTime;

    $resDate = $curentDate->setDate($curentDate->format('Y'), $month, 1);
    $resDate = getdate($resDate->getTimestamp());

    $days = days_in_month($resDate['mon'], $curentDate->format('Y'));

    $weeks = "";
    ($resDate['wday'] == 0) ? $wday = 6 : $wday = $resDate['wday'] - 1;

    createWeek(1, $wday, $days, $weeks);

    return $weeks;
}

function createWeek($day, $wday, $restDays, &$weeks)
{
    if ($day <= $restDays)
    {
        ($wday < 7) ? $i = $wday : $i = 0;
        (($restDays - $day) >= 7) ? $endWeek = 7 : $endWeek = $restDays - $day;

        $wday = 7;
        $weeks .= '<div class="calendar__week">';

        if ($i != 0)
        {
            for ($j = 0; $j < $i; $j++)
            {
                $weeks .= "<div class=\"calendar__week__day calendar__week__day--empty\">&nbsp;</div>";
            }
        }

        for (; $i < $endWeek; $i++)
        {
            if ($i == 5 || $i == 6)
            {
                $weeks .= "<div class=\"calendar__week__day calendar__week__day--red\">$day</div>";
            }
            else
            {
                $weeks .= "<div class=\"calendar__week__day\">$day</div>";
            }
            $day++;
        }

        if ($endWeek != 7 && $day > 7)
        {
            if ($i == 6 || $i == 5)
            {
                $weeks .= "<div class=\"calendar__week__day calendar__week__day--red\">$day</div>";
            }
            else
            {
                $weeks .= "<div class=\"calendar__week__day\">$day</div>";
            }

        }

        if ($endWeek != 7 && $i < 7)
        {
            for ($j = $i + 1; $j < 7; $j++)
            {
                $weeks .= "<div class=\"calendar__week__day calendar__week__day--empty\">&nbsp;</div>";
            }
        }

        $weeks .= '</div>';

        if ($endWeek == 7 && $day == $restDays)
        {
            $weeks .= "<div class=\"calendar__week\"><div class=\"calendar__week__day\">$day</div></div>";
        }

        if ($day < $restDays)
        {
            createWeek($day, $wday, $restDays, $weeks);
        }
    }
}

function days_in_month($month, $year)
{
    return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31);
}

?>