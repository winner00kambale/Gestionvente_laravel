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
            <form method="POST" action="{{ route('users.store') }}">
            @csrf
                @if (\Session::has('messageuser'))
                    <div style="text-align: center" class="alert alert-danger">{{ \Session::get('messageuser') }}</div>
                @endif
                @if (\Session::has('messageupdate'))
                    <div style="text-align: center" class="alert alert-danger">{{ \Session::get('messageupdate') }}</div>
                @endif
                <div class="form-group">
                    <label for="username">username</label>
                    <input type="text" name="username" id="username" class="form-control btn-round">
                    <label for="password">password</label>
                    <input type="password" name="password" id="password" class="form-control btn-round">
                    <label for="mail">Email</label>
                    <input type="mail" name="email" id="email" class="form-control btn-round">
                </div>
                <input type="submit" id="button" value="Inscrire" class="btn btn-info btn-round">
            </form>
            <!-- <div> <br>
                <table class="table table-striped table-hover table-sm table-bordered">
                    <thead>
                        <th>#</th>
                        <th>username</th>
                        <th>Email</th>
                        <th>password</th>  
                    </thead>
                    <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->password }}</td>
                            <button type="button" id="button" class="btn btn-info edit">edit</button>
                            </td>
                        </tr>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div> -->
        </div>
    </div>
    <div class="row mt">
    <div class="col-lg-2 col-md-2 col-sm-12"></div>
    <div class="col-lg-8 col-md-8 col-sm-12">
    <table class="table table-striped table-hover table-sm table-bordered">
                    <thead>
                        <th>parametter</th> 
                        <th>#</th>
                        <th>username</th>
                        <th>Email</th>
                        <th>password</th>
                         
                    </thead>
                    <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>
                                <button type="button" id="button" class="btn btn-info edit">edit</button>
                            </td>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->password }}</td>       
                        </tr>
                    @endforeach
                    </tbody>
                </table>  
    </div>
    <div class="col-lg-2 col-md-2 col-sm-12"></div>  
    </div>
@endsection
@section('modal')
    <!-- modal-star modification -->
    <div class="modal fade" id="Modalmodif" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="ModalLabel">Update users</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('users.update') }}">
                        @csrf
                            <div class="form-group">
                                <input type="hidden" name="id" id="id" value="">
                                <label for="username">username</label>
                                <input type="text" name="username" id="usernamemod" class="form-control btn-round">
                                <label for="password">password</label>
                                <input type="password" name="password" id="passwordmod" class="form-control btn-round">
                                <label for="mail">Email</label>
                                <input type="mail" name="email" id="emailmod" class="form-control btn-round">
                            </div>
                                <input type="submit" id="button" value="Modifier" class="btn btn-info btn-round">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('monscript')
    <script>
        $(document).ready(function() {
            $('.edit').on('click', function() {
                $('#Modalmodif').modal('show');
                $tr = $(this).closest('tr');
                var data = $tr.children("td").map(function() {
                    return $(this).text();
                }).get();
                console.log(data);
                $('#id').val(data[1]);
                $('#usernamemod').val(data[2]);
                $('#emailmod').val(data[3]);
                $('#passwordmod').val(data[4]);
            });
        });
    </script>
@endsection

