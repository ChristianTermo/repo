<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('/css/logstyle.css') }}" />
    <title>Login</title>
</head>

<body>
    <div class="main">
        <div class="content">
            <div class="controls">
                <div class="icon">

                </div>
                <form action=" {{ route('log-in') }} " method="POST">
                    @csrf
                    @if(count($errors) > 0)
                    <ul>
                        @foreach($errors->all() as $error)
                        <li> {{ $error }} </li>
                        @endforeach
                    </ul>
                    @endif
                    <div class="inputs">
                        <svg class="login" xmlns="http://www.w3.org/2000/svg" width="44" height="40" viewBox="0 0 44 40">
                            <g stroke="#fff" fill="none" stroke-width="3.538" transform="translate(0 -1012.362)">
                                <ellipse ry="8.09" rx="8.244" cy="1022.221" cx="21.555" stroke-linecap="round" />
                                <path d="M1.858 1046.4c-.79 4.74 3.805 4.11 3.805 4.11H37.88s4.846.936 4.312-3.854c-.533-4.79-6.076-10.937-20.04-11.043-13.964-.106-19.504 6.047-20.294 10.786z" />
                            </g>
                        </svg>
                        <input class="input" type="email" placeholder="email" id="" name="email" required>

                        <button class="button">
                            <div class="circle animate"></div><span class="sign-in">Sign in</span>
                            <div class="loader"></div>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>