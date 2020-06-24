@if ( $type == 'html')

{{-- cover --}}
<div id="coverBlock" class="position-fixed w-100 h-100 invisible" style="top:0;left:0;z-index:1050;">
    <div class="position-absolute w-100 h-100 bg-dark" style="opacity:0.5;"></div>

    <div class="position-absolute w-100 h-100 d-flex justify-content-center align-items-center">
        <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
</div>

@elseif ( $type == 'js')

{{-- cover  --}}
<script>
    var coverObj = coverObj || {};
    coverObj.show = function(){
        $('#coverBlock').removeClass('invisible');
    }
    coverObj.hide = function(){
        $('#coverBlock').addClass('invisible');
    }
</script>

@endif