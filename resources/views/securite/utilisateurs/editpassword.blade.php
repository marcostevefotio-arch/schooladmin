@extends("securite.utilisateurs.profile")

@section("passwordform")

    <div class="col-sm-8 col-sm-offset-2">
        <hr>
        <form action="{{ route("passwordUpdate", ["slug"=>auth()->user()->id]) }}" method="post">
            {{ csrf_field() }}
            <h2 class="green"><i class="fa fa-lock"></i>Modification de mot de passe</h2>
            @if(Session::has("errors"))
                <div class="form-group">
                    <span class="alert alert-danger block">{{ Session::get("errors") }}</span>
                </div>
            @endif
            <div class="form-group">
                <input type="password" name="oldpassword" class="form-control @error('oldpassword') is-invalid @enderror" placeholder="Ancien mot de passe" required>
                @error('oldpassword')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Nouveau mot de passe" required autocomplete="new-password">
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirmer le nouveau mot de passe" required autocomplete="new-password">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success">Enregistrer</button>
                <a href="{{ route("userProfile", ["slug"=>auth()->user()->id]) }}" class="btn btn-default">Annuler</a>
            </div>
        </form>
        <hr>
    </div>
@endsection