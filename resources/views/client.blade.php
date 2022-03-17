@extends('layouts.master')
@section('contenu')
    <h3 class="mt-2">Nos Clients</h3>
    <button id="button" type="button" class="btn" data-toggle="modal" data-target="#myModal">
        New Client
    </button>
    <table class="table table-hover table-striped table-sm  table-bordered mt-2">
        <thead>
            <tr>
                <th>#</th>
                <th>nom</th>
                <th>postnom</th>
                <th>prenom</th>
                <th>genre</th>
                <th>quartier</th>
                <th>avenue</th>
                <th>telephone</th>
                <th>options</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($client as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->nom }}</td>
                    <td>{{ $item->postnom }}</td>
                    <td>{{ $item->prenom }}</td>
                    <td>{{ $item->sexe }}</td>
                    <td>{{ $item->quartier }}</td>
                    <td>{{ $item->avenue }}</td>
                    <td>{{ $item->telephone }}</td>
                    <td>
                        <button type="button" id="button" class="btn btn-info edit">edit</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
@section('modal')
    <!-- Modal d'insertion -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Ajouter client</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="modal_insert">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nom">nom</label>
                                    <input type="text" name="nom" id="nom" class="form-control btn-round">
                                    <label for="postnom">postnom</label>
                                    <input type="text" name="postnom" id="postnom" class="form-control btn-round">
                                    <label for="prenom">prenom</label>
                                    <input type="text" name="prenom" id="prenom" class="form-control btn-round">
                                    <label for="sexe">sexe</label>
                                    <select name="sexe" id="sexe" class="form-control btn-round">
                                        <option value="m">M</option>
                                        <option value="f">F</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="quartier">quartier</label>
                                    <input type="text" name="quartier" id="quartier" class="form-control btn-round">
                                    <label for="avenue">avenue</label>
                                    <input type="text" name="avenue" id="avenue" class="form-control btn-round">
                                    <label for="telephone">telephone</label>
                                    <input type="tel" name="telephone" id="telephone" class="form-control btn-round">
                                </div>
                                <input type="submit" value="Enregistrer" id="button" class="btn btn-round">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- modal-star modification -->
    <div class="modal fade" id="Modalmodif" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="ModalLabel">modifier client</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('client.update') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="hidden" name="id" id="id" value=""> <br>
                                    <label for="nom">nom</label>
                                    <input type="text" name="nom" id="mod_nom" value="" class="form-control btn-round">
                                    <label for="postnom">postnom</label>
                                    <input type="text" name="postnom" id="mod_postnom" value=""
                                        class="form-control btn-round">
                                    <label for="prenom">prenom</label>
                                    <input type="text" name="prenom" id="mod_prenom" value=""
                                        class="form-control btn-round">
                                    <label for="sexe">sexe</label>
                                    <select name="sexe" id="mod_sexe" class="form-control btn-round">
                                        <option value="m">M</option>
                                        <option value="f">F</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <br>
                                    <label for="quartier">quartier</label>
                                    <input type="text" name="quartier" id="mod_quartier" value=""
                                        class="form-control btn-round">
                                    <label for="avenue">avenue</label>
                                    <input type="text" name="avenue" id="mod_avenue" value=""
                                        class="form-control btn-round">
                                    <label for="telephone">telephone</label>
                                    <input type="tel" name="telephone" id="mod_telephone" value=""
                                        class="form-control btn-round">
                                </div>
                                <input type="submit" id="button" value="Update" class="btn btn-info btn-round">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('monscript')
    <script>
        $('#modal_insert').submit(function(event) {
            event.preventDefault();
            $.ajax({
                url: '{{ route('clients.store') }}',
                method: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                cache: false,
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },

                success: function(data) {
                    alert('Inserted succes');
                    $('#modal_insert')[0].reset();
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.edit').on('click', function() {
                $('#Modalmodif').modal('show');
                $tr = $(this).closest('tr');
                var data = $tr.children("td").map(function() {
                    return $(this).text();
                }).get();
                console.log(data);
                $('#id').val(data[0]);
                $('#mod_nom').val(data[1]);
                $('#mod_postnom').val(data[2]);
                $('#mod_prenom').val(data[3]);
                $('#mod_sexe').val(data[4]);
                $('#mod_quartier').val(data[5]);
                $('#mod_avenue').val(data[6]);
                $('#mod_telephone').val(data[7]);
            });
        });
    </script>
@endsection
