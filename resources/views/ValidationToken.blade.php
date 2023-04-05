<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('/css/logstyle.css') }}" />
    <title>ValidationToken</title>
</head>

<body>

    <div class="main">
        <div class="content">
            <div class="controls">
                <div class="icon">

                </div>
                <form action=" {{ route('validateToken') }} " method="POST">
                    @csrf
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="inputs">
                        <input class="input" type="text" placeholder="token" id="" name="token" required>
                        <button class="button">
                            <div class="circle animate"></div><span class="sign-in">Verify token</span>
                            <div class="loader"></div>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>