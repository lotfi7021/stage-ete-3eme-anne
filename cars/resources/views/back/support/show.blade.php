
@extends('back.app')

@Push('css') 
     <!-- Ekko Lightbox -->
  <link rel="stylesheet" href="{{ asset('assets/back/plugins/ekko-lightbox/ekko-lightbox.css')}}">
@endpush

@section('content')
<!-- Content Wrapper. Contains page content -->
<style>
        .support-details {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .support-details .container {
            display: flex;
            flex-direction: column;
            gap: 20px;
            width: 80%;
            max-width: 800px;
        }

        .support-details .card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .support-details .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .support-details .card h3 {
            margin-top: 0;
            font-size: 24px;
        }

        .support-details .card p {
            margin: 10px 0;
            font-size: 18px;
        }
    </style>
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
