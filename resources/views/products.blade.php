@extends('layouts.Master')
@section('contenu')
<div class="row mt">
    <div class="col-lg-4 col-md-4 col-sm-12" >
      <div style="background:white;z-index: 0;border-radius:7px;">
         <h3>Approvisionnement</h3>
            @if(\Session::has('message'))
                {{-- <script>
                  Swal.fire({
                      title: 'Custom animation with Animate.css',
                      showClass: {
                        popup: {{ \Session::get('message') }}
                      },
                      hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                      }
                    })
                </script> --}}
            <div class="alert alert-primary">{{ \Session::get('message') }}</div>
            @endif
      <form method="POST" action="{{ route('products.store') }}" style="padding:5px;">
        @csrf
        <div class="form-goup">
             <label for="designation">Designation</label>
             <select name="designationP" id="designationP" class="form-control btn-round">
              <option value=""> -- Selectionner la Categorie</option>
              @foreach ($categ as $item)
                  <option value="{{ $item->designation }}">{{ $item->designation }}</option>
              @endforeach
            </select>
        </div>
        <div class="form-goup">
             <label for="nombre">Nombre</label>
             <input type="number" name="nombreP" id="nombreP" min="0" oninput="this.value=Math.abs(this.value)" class="form-control btn-round"> 
        </div>
        <div class="form-goup">
            <label for="prix">Montant</label>
            <input type="number" name="montantP" id="montantP" min="0" oninput="this.value=Math.abs(this.value)" class="form-control btn-round"> 
        </div>
        <div class="form-goup">
            <label for="fournisseur">Fournisseur</label>
            <select name="fournisseurP" id="fournisseurP" class="form-control btn-round">
              <option value=""> -- Selectionner le Fournisseur</option> 
              @foreach ($fournisseur as $item)
                  <option value="{{ $item->prenom }}">{{ $item->prenom }}</option>
              @endforeach
            </select>
        </div>
            <input type="submit" id="button" class="btn m-3 btn-round" value="Enregistrer" class="btn-round">
      </form>
        <button id="button" type="button" style="margin-left: 230px;" class="btn" data-toggle="modal" data-target="#myModal">
             + Categorie
        </button>
      </div>
    </div>
    <!-- /col-lg-6 -->
    <div class="col-lg-8 col-md-8 col-sm-12">
      <table class="table table-striped table-hover table-sm table-bordered">
          <thead>
            <th>#</th>
            <th>designation</th>
            <th>nombre</th>
            <th>montant</th>
            <th>fournisseur</th>
            <th>date jour</th>
            <th>paramettre</th>
          </thead>
          <tbody> 
            @foreach($product as $pro)
                <tr>
                    <td>{{ $pro->id }}</td>
                    <td>{{ $pro->Produit }}</td> 
                    <td>{{ $pro->nombre }}</td>
                    <td>{{ $pro->montant }}</td>
                    <td>{{ $pro->Fournisseur }}</td>
                    <td>{{ $pro->dates }}</td>
                    <td>
                    <button type="button" id="button" class="btn btn-info edit">edit</button>
                    </td>
                </tr>
           @endforeach
          </tbody>
      </table>
    </div>
  </div>
@endsection
@section('modal')
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Ajouter Categorie</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <form id="monformulaire">
                  @csrf
                    <div class="form-goup">
                      <label for="designation">Designation</label>
                      <input type="text" name="designation" id="designation" class="form-control btn-round"> 
                    </div> <br>
                    <input type="submit" value="Ajouter" id="button" class="btn btn-info">
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('monscript')
  <script>
    $('#monformulaire').submit(function(event){
        event.preventDefault();
        $.ajax({
            url : '{{ route("categorie.store") }}',
            method : 'POST',
            data : new FormData(this),
            processData : false,
            contentType : false,
            cache : false,
            headers : {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
            
            success : function(data){
                alert('Inserted succes');
                $('#monformulaire')[0].reset();
            }
        });
    });
  </script>
@endsection