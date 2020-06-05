<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>{{ $title }}</title>
        {{-- <title>test</title> --}}

        <link href="https://getbootstrap.com/docs/4.3/dist/css/bootstrap.min.css" rel="stylesheet">

        <style>
            html, body {
                height: 80%;
            }

            body {
                display: flex;
                align-items: center;
                padding-top: 40px;
                padding-bottom: 40px;
                background-color: #f5f5f5;
            }
            .form-signin {
                width: 100%;
                max-width: 420px;
                padding: 15px;
                margin: auto;
            }

            .form-label-group {
                position: relative;
                margin-bottom: 1rem;
            }
            .form-label-group > input,
            .form-label-group > label {
                height: 3.125rem;
                padding: .75rem;
            }
            .form-label-group > label {
                position: absolute;
                top: 0;
                left: 0;
                display: block;
                width: 100%;
                margin-bottom: 0; /* Override default `<label>` margin */
                line-height: 1.5;
                color: #495057;
                pointer-events: none;
                cursor: text; /* Match the input under the label */
                border: 1px solid transparent;
                border-radius: .25rem;
                transition: all .1s ease-in-out;
            }
            .form-label-group input::placeholder {
                color: transparent;
            }
            .form-label-group input:not(:placeholder-shown) {
                padding-top: 1.25rem;
                padding-bottom: .25rem;
            }
            .form-label-group input:not(:placeholder-shown) ~ label {
                padding-top: .25rem;
                padding-bottom: .25rem;
                font-size: 12px;
                color: #777;
            }

        </style>
    </head>
    <body>
        <form class="form-signin" method="POST">
            @csrf
            <div class="text-center">
                <img class="mb-1 rounded" src="" alt="icon" width="100%">
            </div>
            <div class="mb-4 text-center">
                <h2 class="font-weight-bold font-italic">後台管理系統</h2>
                <span class="">{{ $page->subtitle }}</span>
            </div>

            <div class="form-label-group">
                <input type="text" id="inputLogin" name="inputLogin" class="form-control" placeholder="帳號"
                    value="{{ old('inputLogin') }}" required autofocus>
                <label for="inputLogin">帳號</label>
            </div>

            <div class="form-label-group">
                <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="密碼"
                    value="" required>
                <label for="inputPassword">密碼</label>
            </div>

            @if( $page->showForget == true )
            <div class="form-label-group text-right">
                <a href="javascript:;" class="stretched-link" id="doForgetPasswd">忘記密碼?</a>
            </div>
            @endif

            <div class="form-label-group">
                {{-- @include('errorMsg') --}}
            </div>

            <button class="btn btn-lg btn-primary btn-block" type="submit">登入</button>

        </form>

        @if( env('APP_ENV') == 'local')
        <script>
        document.getElementById('inputLogin').value = 'yang';
        document.getElementById('inputPassword').value = '123456789';
        </script>
        @endif

    </body>
</html>
