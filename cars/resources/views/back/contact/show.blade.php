





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
            <p><strong>Nom:</strong>   {{!! $contact->nom !!}}</p>
                <p><strong>Email:</strong>   {{!! $contact->email !!}}</p>
                <p><strong>telephone:</strong>       {{!! $contact->telephone !!}}  </p>
                <p><strong>Sujet:</strong>         {{!! $contact->sujet !!}}</p>
              

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
