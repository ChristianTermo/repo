<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('/css/specMenu.css') }}" />
    <title>Standings</title>
</head>

<body>
    @extends('layouts.layout-bootstrap')
    <ul class="topnav">
        <li><a href="{{ route('index') }}">Home</a></li>
        <li><a href="{{ route('RedirectToPersonal') }}">Player</a></li>
        <li><a href="{{ route('getPairingsPage') }}">Pairings</a></li>
        <li><a href="{{ route('getStandingsPage') }}">Standings</a></li>
    </ul>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Rank</th>
                <th>Name</th>
                <th>Points</th>
                <th>OMW</th>
                <th>Game Win</th>
                <th>OGW</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stats as $index => $value)
            <tr>
                <td>{{$stats[$index]->rank}}</td>
                <td>{{$firstName[$index]}} {{$lastName[$index]}}</td>
                <td>{{$stats[$index]->points}}</td>
                <td>{{$stats[$index]->OMW}}</td>
                <td>{{$stats[$index]->Game_Win}}</td>
                <td>{{$stats[$index]->OGW}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>