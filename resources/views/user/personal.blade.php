<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('/css/specMenu.css') }}" />
    <title>Document</title>
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
                <th>Round</th>
                <th>Table</th>
                <th>Opponent</th>
                <th>Result</th>
            </tr>
        </thead>
        <tbody>
            @foreach($player_data as $index => $player)
            <tr>
                <td>{{$player->CurrentRoundNumber}}</td>
                <td>{{$player->Number}}</td>
                <td>{{$firstName[$index]}} {{$lastName[$index]}}</td>
                <td>{{$player->results}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>