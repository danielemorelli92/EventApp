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
        <table style="box-shadow: none; width: 100%; height: 100%"> <!-- calendario -->
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
                <tr style="vertical-align: top;">
                    @for($j = 1; $j <= 7; $j++)
                        @if($date->month != $month)
                            <td class="inactive-day-box"
                                style=" color: rgba(128,128,128,0.49); border: 1px solid gray;">
                                {{$date->day}}
                            </td>
                        @else
                            <td class="active-day-box" style=" border: 2px solid gray; color: black; max-width: 30px;">
                                <p style="margin: 0;">{{$date->day}}</p>
                                <div style="display: flex; flex-direction: column; align-items: flex-start;">
                                    @foreach($events->toQuery()->whereDay('starting_time', $date->day)->whereMonth('starting_time', $month)->get() as $event)
                                        <form action="/event/{{$event->id}}">
                                            <button style="background-color: rgba(172,200,255,0.77);"
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
