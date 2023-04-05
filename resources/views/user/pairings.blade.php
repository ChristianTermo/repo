<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('/css/specMenu.css') }}" />
    <title>Pairings</title>
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
                <th>Player 1</th>
                <th>Player 2</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($roundData as $index => $value)
            <tr>
                <td>{{$roundData[$index]->CurrentRoundNumber}}</td>
                <td>{{$roundData[$index]->Number}}</td>
                <td>{{$firstName1[$index]}} {{$lastName1[$index]}}</td>
                <td>{{$firstName2[$index]}} {{$lastName2[$index]}}</td>
                <td></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>