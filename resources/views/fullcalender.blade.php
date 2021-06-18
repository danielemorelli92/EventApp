<!DOCTYPE html>
<html>
<head>
    <title>EventApp Calendar</title>
</head>
<body>
@php
    function monthName(int $month) {
        switch($month) {
            case 1: return 'Gennaio';
            case 2: return 'Febbraio';
            case 3: return 'Marzo';
            case 4: return 'Aprile';
            case 5: return 'Maggio';
            case 6: return 'Giugno';
            case 7: return 'Luglio';
            case 8: return 'Agosto';
            case 9: return 'Settembre';
            case 10: return 'Ottobre';
            case 11: return 'Novembre';
            case 12: return 'Dicembre';

        }
    }
@endphp
<h1>{{ monthName($month) }}
    <form style="display: inline;" action="/fullcalender/@php
        $newMonth = $month - 1;
        $newYear = $year;
        if($newMonth == 0) {
            $newMonth = 12;
            $newYear = $year - 1;
        }
        echo $newYear . '-' . $newMonth
    @endphp
        ">
        <button>←</button>
    </form>
    <form style="display: inline;" action="/fullcalender/@php
        $newMonth = $month + 1;
        $newYear = $year;
        if($newMonth == 13) {
            $newMonth = 1;
            $newYear = $year + 1;
        }
        echo $newYear . '-' . $newMonth
    @endphp
        ">
        <button>→</button>
    </form>
    {{ $year }}
    <form style="display: inline;" action="/fullcalender/{{ $year - 1 }}-{{ $month }}">
        <button>←</button>
    </form>
    <form style="display: inline;" action="/fullcalender/{{ $year + 1 }}-{{ $month }}">
        <button>→</button>
    </form>
</h1>
<table style="width: 90vw; height: 85vh">
    <tr>
        <th>LUN</th>
        <th>MAR</th>
        <th>MER</th>
        <th>GIO</th>
        <th>VEN</th>
        <th style="color: #dc0000;">SAB</th>
        <th style="color: #dc0000;">DOM</th>
    </tr>
    @for($i = 1; $i <= 6; $i++)
        <tr>
            @for($j = 1; $j <= 7; $j++)
                @if($date->month != $month)
                    <td class="inactive-day-box" style="color: rgba(128,128,128,0.49); border: 1px solid gray;">
                        {{$date->day}}
                    </td>
                @else
                    <td class="active-day-box" style="border: 2px solid gray; color: black;">
                        {{$date->day}}
                        @foreach($events as $event)

                            {{ 'test event' }}
                            {{ $event->title }}
                        @endforeach
                    </td>
                @endif
                @php
                    $date = $date->addDay()
                @endphp
            @endfor
        </tr>
    @endfor
</table>

</body>

</html>
