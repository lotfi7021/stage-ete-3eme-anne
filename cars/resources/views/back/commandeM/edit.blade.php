{{-- resources/views/back/commandeM/assign.blade.php --}}
@extends('back.app')
@section('title', 'Assigner Livreur')

@push('styles')
<style>
    body {
        font-family: 'Poppins', sans-serif;
    }

    .confirm-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 90vh;
        padding: 20px;
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
    }
    
    .confirm-card {
        background: #fff;
        padding: 50px 40px;
        border-radius: 25px;
        box-shadow: 0 25px 70px rgba(0, 0, 0, 0.2);
        text-align: center;
        max-width: 520px;
        width: 100%;
        animation: fadeInScale 0.6s ease-out;
        position: relative;
    }
    
    .confirm-icon {
        font-size: 5rem;
        margin-bottom: 20px;
        animation: bounce 2s infinite;
        color: #6a11cb;
    }
    
    .confirm-title {
        font-size: 2.4rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 15px;
        text-shadow: 0 3px 6px rgba(0,0,0,0.1);
    }
    
    .confirm-subtitle {
        font-size: 1.1rem;
        color: #4a5568;
        margin-bottom: 35px;
        line-height: 1.6;
    }
    
    .confirm-btn {
        background: linear-gradient(135deg, #00c6ff 0%, #0072ff 100%);
        color: white;
        border: none;
        padding: 18px 55px;
        font-size: 1.2rem;
        font-weight: 600;
        border-radius: 50px;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 10px 30px rgba(0, 114, 255, 0.4);
        position: relative;
        overflow: hidden;
        transform: translateY(0);
    }
    
    .confirm-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
        transition: left 0.6s ease;
    }
    
    .confirm-btn:hover {
        transform: translateY(-4px);
        box-shadow: 0 15px 40px rgba(0, 114, 255, 0.6);
    }
    
    .confirm-btn:hover::before {
        left: 100%;
    }
    
    .confirm-btn:active {
        transform: translateY(-1px);
    }
    
    /* Loading animation */
    .loading {
        pointer-events: none;
        opacity: 0.8;
    }
    
    .loading::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 22px;
        height: 22px;
        margin: -11px 0 0 -11px;
        border: 3px solid transparent;
        border-top: 3px solid #fff;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    
    @keyframes fadeInScale {
        from {
            opacity: 0;
            transform: scale(0.9) translateY(20px);
        }
        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }
    
    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
        40% { transform: translateY(-12px); }
        60% { transform: translateY(-6px); }
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .confirm-card {
            margin: 15px;
            padding: 35px 25px;
        }
        
        .confirm-title {
            font-size: 1.9rem;
        }
        
        .confirm-btn {
            width: 100%;
            padding: 15px;
            font-size: 1.1rem;
        }
        
        .confirm-icon {
            font-size: 4rem;
        }
    }
</style>
@endpush

@section('content')
<div class="content-wrapper">
    <div class="confirm-container">
        <div class="confirm-card">
            <div class="confirm-icon">📦</div>
            <h1 class="confirm-title">Confirmer la commande</h1>
            <p class="confirm-subtitle">Cliquez sur le bouton ci-dessous pour confirmer cette commande.</p>
            
            <form name="update" method="POST" action="{{ route('admin.list_commandeM.edit', $commande->id)}}" enctype="multipart/form-data" id="confirmForm">
                {{ method_field('post') }}
                {{ csrf_field() }}
                
                <button type="submit" class="confirm-btn" id="confirmButton">
                    ✅ Confirmer
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('confirmForm').addEventListener('submit', function() {
    const button = document.getElementById('confirmButton');
    button.classList.add('loading');
    button.innerHTML = 'En cours...';
});
</script>
@endpush
@endsection
