<html>

<head>
    <!--    匯入jQuery    -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    @include('common.coverBlock', ['type'=>'html'])
    @include('common.coverBlock', ['type'=>'js'])

    <script>
        window.onload = function(){
            // 啟動 loading
            coverObj.show();

        }
    </script>

</head>

</html>
@section('footer')


@yield('footer')
@endsection