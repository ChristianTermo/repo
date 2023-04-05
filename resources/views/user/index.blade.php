<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('/css/specMenu.css') }}" />
    <title>Index</title>
</head>

<body>
    <h1>Online Pairings</h1>

    <form action="{{ route('RedirectToPersonal')}}" method="get">
        @csrf
        <select name="torneo" id="">
            @foreach($tournaments as $tournament)
            <option value="{{$tournament->nome_torneo}}">{{$tournament->nome_torneo}}</option>
            @endforeach
        </select>
        <br>
        <button type="submit">Submit</button>
    </form>

</body>

</html>

<style>
    h1 {
        text-align: center;
    }

    a {
        font-size: 20px;
    }

    select {
        display: block;
        margin: 0 auto;
        width: 200px;
        height: 30px;
        background-color: whitesmoke;
    }

    button {
        display: block;
        margin: 0 auto;
        background-color: whitesmoke;
        color: black;
        border-style: outset;
        border-color: #0066A2;
        height: 30px;
        width: 200px;
        font: bold15px arial, sans-serif;
        text-shadow: none;
    }
</style>