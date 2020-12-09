{{-- @section('css')
<link rel="stylesheet" href="{{ URL::asset('backend/css/content-styles.css') }}">
@endsection --}}

@section('content')
<form method="post" action="" id="form"
    onsubmit="return checkForm();" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-12 col-md-3 pt-3 ml-3">
            <label>標題 :</label>
            <input name="uid" id="uid" style="display:none;">
            <input name="title" id="title">
            <div class="flex-fill" id="titleMess" style="width:200px; color:#FF0000; display:none;"></div>
        </div>
        <div class="col-12 col-md-3 pt-3 ml-3">
            <div class="date d-flex">
                <input type="text" class="form-control" name="date" id="date" placeholder="公告時間" readonly>
                <button class="btn btn-outline-secondary selectDate" type="button"><i
                        class="fa fa-calendar"></i></button>
            </div>
            <div class="flex-fill" id="dateMess" style="width:200px; color:#FF0000; display:none;"></div>
        </div>
    </div>

    <textarea name="content" id="editor">
    </textarea>
    <textarea name="getContent" id="getContent" style="display:none;">
    </textarea>
    <div class="row">
        <div class="col-12 col-md-12 text-left py-1 align-self-center">
            <div class="form-group">
                <button type="button" class="btn btn-secondary" onclick="history.back()">取消</button>
                <button type="submit" class="btn btn-primary save">儲存</button>

                <button type="button" class="btn btn-primary" style="float:right;" onclick="goPreview();">預覽</button>
            </div>
        </div>
    </div>
</form>
<div class="nav ck-content">
    <div id="output" class="px-2"></div>
</div>
@show

@section('js')
<script src="https://cdn.bootcss.com/jquery/1.11.0/jquery.min.js"></script>
<script src="http://code.changer.hk/jquery/plugins/jquery.cookie.js"></script>
{{-- date time picker --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"
    integrity="sha256-bqVeqGdJ7h/lYPq6xrPv/YGzMEb6dNxlfiTUHSgRCp8=" crossorigin="anonymous"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"
    integrity="sha256-siyOpF/pBWUPgIcQi17TLBkjvNgNQArcmwJB8YvkAgg=" crossorigin="anonymous" />
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">

{{-- <script src="https://cdn.ckeditor.com/ckeditor5/23.1.0/classic/ckeditor.js"></script> --}}
<script src="/ckeditor5/build/ckeditor.js"></script>


<script>
    var preview;
    var editorContainer = document.querySelector('#editor');

    var clear_input_if_empty_content = function(input) {
        let $form = $(input).parents('form');
        $form.on('submit', function() {
            getContent.innerHTML =  editorContainer.innerHTML;
        });
    };

    var goPreview = function() {
        previewData = preview.getData();
        localStorage.setItem('content', previewData);

    }

    function checkForm(input)
    {
        let ckeck = true;
        let title = document.getElementById("title");
        let titleMess = document.getElementById("titleMess");
        let date = document.getElementById("date");
        let dateMess = document.getElementById("dateMess");

        if (title.value == "") {
            titleMess.innerHTML = '* 標題為必填';
            titleMess.style.display="block";
            ckeck = false;
        } else {
            titleMess.style.display="none";
        }

        if (date.value == "") {
            dateMess.innerHTML = '* 時間為必填';
            dateMess.style.display="block";
            ckeck = false;
        } else {
            dateMess.style.display="none";
        }

        // return false;
        if (ckeck == true) {
            return true;
        } else {
            return false;
        }
    }

    ClassicEditor
        .create( editorContainer, {
            ckfinder: {
                uploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&responseType=json'
            },
            image: {
                // Configure the available styles.
                styles: [
                    'alignLeft', 'alignCenter', 'alignRight'
                ],

                // Configure the available image resize options.
                resizeOptions: [
                    {
                        name: 'imageResize:original',
                        label: 'Original',
                        value: null
                    },
                    {
                        name: 'imageResize:50',
                        label: '50%',
                        value: '50'
                    },
                    {
                        name: 'imageResize:75',
                        label: '75%',
                        value: '75'
                    }
                ],

                // You need to configure the image toolbar, too, so it shows the new style
                // buttons as well as the resize buttons.
                toolbar: [
                    'imageStyle:alignLeft', 'imageStyle:alignCenter', 'imageStyle:alignRight',
                    '|',
                    'imageResize',
                    '|',
                    'imageTextAlternative',
                    '|',
                    'linkImage'
                ]
            },
            mediaEmbed: {
                previewsInData: true
                // 設定影片為可見的格式
            },
            fontSize: {
                options: [
                    9,
                    11,
                    13,
                    'default',
                    15,
                    18,
                    21,
                    24,
                    36,
                    48
                ]
            },
            toolbar: [
                'Alignment',
                'fontSize',
                'fontFamily',
                'fontColor',
                'fontBackgroundColor',
                '|',
                'bold',
                'italic',
                'link',
                'bulletedList',
                'numberedList',
                '|',
                'indent',
                'outdent',
                '|',
                'imageUpload',
                'blockQuote',
                'insertTable',
                'mediaEmbed',
                'undo',
                'redo',
            ],
        } )
        .then(function(editor) {
            preview = editor;
            clear_input_if_empty_content(editorContainer);
        } )
        .catch( error => {
            console.error( error );
        } );
</script>

<script type="text/javascript">
    // 日期功能
    $('.date').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
        clearBtn: true,
        todayHighlight: true,
        language: "zh-TW"
    });
</script>
@show