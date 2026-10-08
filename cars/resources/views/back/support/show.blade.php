
@extends('back.app')

@Push('css') 
     <!-- Ekko Lightbox -->
  <link rel="stylesheet" href="{{ asset('assets/back/plugins/ekko-lightbox/ekko-lightbox.css')}}">
@endpush

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

 <div class="support-details">
        <div class="container">
            <div class="card">
                <h3>Client: {{!! $support->id_client !!}}   </h3>
                <p><strong>Type de support:</strong>   {{!! $support->support !!}}</p>
                <p><strong>Sujet:</strong>   {{!! $support->sujet !!}}</p>
                <p><strong>Message:</strong>                      {{!! $support->message !!}}
                </p>
            </div>
      
        </div>
    </div>
    </div>

@stop

@Push('js')
<script src="{{asset('assets/back/plugins/ekko-lightbox/ekko-lightbox.min.js')}}"></script>
<script>
  $(function () {
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
      event.preventDefault();
      $(this).ekkoLightbox({
        alwaysShowClose: true
      });
    });

  })
</script>

@endpush
