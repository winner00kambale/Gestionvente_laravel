@extends('layouts.master')
@section('contenu')
    <div class="row mt">
        <div class="col-lg-4 col-md-4 col-sm-12">
            <h3>Stock de securite</h3>
            <form method="POST" action="{{ route('alert.store') }}">
                @csrf
                @if (\Session::has('message'))
                    <div style="text-align: center" class="alert alert-danger">{{ \Session::get('message') }}</div>
                @endif
                <div class="form-group">
                    <input type="number" name="nombre_sec" id="nombre_sec" min="0" oninput="this.value=Math.abs(this.value)"class="form-control btn-round" required />
                </div>
                <input type="submit" id="button" class="btn btn btn-round" value="Enregistrer">
            </form> <br>
            <table class="table table-striped table-hover table-sm table-bordered">
                <thead>
                    <th>#</th>
                    <th>Quantite</th>
                </thead>
                <tbody>
                    @foreach ($stockAlerte as $alerte)
                        <tr>
                            <td>{{ $alerte->id }}</td>
                            <td>{{ $alerte->nombre }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-12"></div>
        <!-- /col-lg-6 -->
        <div class="col-lg-5 col-md-5 col-sm-12">
            <h3>Inscripption des utilisateurs</h3>
            <form>
                <div class="form-group">
                    <label for="username">username</label>
                    <input type="text" name="username" id="username" class="form-control btn-round">
                    <label for="password">password</label>
                    <input type="password" name="password" id="password" class="form-control btn-round">
                    <label for="mail">mail</label>
                    <input type="mail" name="mail" id="mail" class="form-control btn-round">
                </div>
                <input type="submit" id="button" value="Inscrire" class="btn btn-info btn-round">
            </form>
            <div> <br>
                <table class="table table-striped table-hover table-sm table-bordered">
                    <thead>
                        <th>#</th>
                        <th>nom</th>
                        <th>username</th>
                        <th>password</th>
                        <th>Email</th>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('monscript')
@endsection
