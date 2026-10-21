{{-- resources/views/back/commandeM/edit.blade.php --}}
{{-- Styles migrés vers assets/back/css/rm-back.css (section « Confirmation de commande ») --}}
@extends('back.app')
@section('title', 'Assigner Livreur')

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

                <div class="form-group">
                    <label for="id_livreur">Livreur</label>
                    <select name="id_livreur" id="id_livreur" class="form-control" required>
                        <option value="">-- Choisir un livreur --</option>
                        @foreach($livreurs as $livreur)
                            <option value="{{ $livreur->id }}" @selected(old('id_livreur', $commande->id_livreur) == $livreur->id)>
                                {{ $livreur->nom }} {{ $livreur->prenom }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_livreur')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="confirm-btn" id="confirmButton">
                    ✅ Confirmer
                </button>
            </form>
        </div>
    </div>
</div>

@push('js')
<script>
document.getElementById('confirmForm').addEventListener('submit', function() {
    const button = document.getElementById('confirmButton');
    button.classList.add('loading');
    button.innerHTML = 'En cours...';
});
</script>
@endpush
@endsection
