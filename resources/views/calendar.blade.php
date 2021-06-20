@extends('layouts.layout-header-one-columns')

@section('script')
    <script>
    </script>
@endsection


@section('content')
    <body>

    <div class="main-content-column">


        <div class="big-form-container" style="max-width: none; margin-left: auto; margin-right: auto; width: 80%; height: calc(100% - 16px)">
            <h2 style="margin-bottom: 20px;">Il tuo calendario</h2>
        <div class="big-form-group" style="width: 100%; height: 100%" >


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
        <div style="display: flex; flex-direction: row; align-items: center; justify-content: center;">
            <form style="display: inline;" action="/calendar/@php
                $newMonth = $month - 1;
                $newYear = $year;
                if($newMonth == 0) {
                    $newMonth = 12;
                    $newYear = $year - 1;
                }
                echo $newYear . '-' . $newMonth
            @endphp
                ">
                <button class="circle-button">←</button>
            </form>
            <h2>{{ monthName($month) }}</h2>
            <form style="display: inline;" action="/calendar/@php
                $newMonth = $month + 1;
                $newYear = $year;
                if($newMonth == 13) {
                    $newMonth = 1;
                    $newYear = $year + 1;
                }
                echo $newYear . '-' . $newMonth
            @endphp
                ">
                <button class="circle-button">→</button>
            </form>
            <form style="margin-left: auto; display: inline;" action="/calendar/{{ $year - 1 }}-{{ $month }}">
                <button class="circle-button">←</button>
            </form>
            <h2>{{ $year }}</h2>
            <form style="display: inline;" action="/calendar/{{ $year + 1 }}-{{ $month }}">
                <button class="circle-button">→</button>
            </form>
        </div>
        <table style="-webkit-border-radius:0; -moz-border-radius:0; border-radius:0; box-shadow: none; width: 100%; height: 100%; border-collapse: collapse; border-spacing: 0;" > <!-- calendario -->
            <tr     style="height: 20px">
                <th style="height: 20px">LUN</th>
                <th style="height: 20px">MAR</th>
                <th style="height: 20px">MER</th>
                <th style="height: 20px">GIO</th>
                <th style="height: 20px">VEN</th>
                <th style="height: 20px; color: #0090E1;">SAB</th>
                <th style="height: 20px; color: #0090E1;">DOM</th>
            </tr>

            @for($i = 1; $i <= 6; $i++)
                <tr style="vertical-align: top;">
                    @for($j = 1; $j <= 7; $j++)
                        @if($date->month != $month)
                            <td class="calendar-day-inactive-box" >
                                {{$date->day}}
                            </td>
                        @else
                            <td class="calendar-day-active-box">
                                <p style="margin: 0;">{{$date->day}}</p>
                                <div style="width: 100%; display: flex; flex-direction: column; align-items: flex-start;">
                                    @foreach($events->toQuery()->whereDay('starting_time', $date->day)->whereMonth('starting_time', $month)->get() as $event)
                                        <form style="width: 98.5%; height: auto" action="/event/{{$event->id}}">
                                            <button class="calendar-event-clickable-item"
                                                    type="submit">{{ $event->title }}</button>
                                        </form>
                                    @endforeach
                                </div>

                            </td>
                        @endif
                        @php
                            $date = $date->addDay()
                        @endphp
                    @endfor
                </tr>
            @endfor
        </table>
        </div>
    </div>
    </div>

    </body>

    </html>
@endsection
