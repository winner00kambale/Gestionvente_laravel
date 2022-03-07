@extends('layouts.master')
@section('contenu')
<h3 class="mt-2">Nos Fournisseurs</h3>
        <button id="button" type="button" class="btn" data-toggle="modal" data-target="#myModal">
            New Fournisseur
        </button>
<table class="table table-striped table-hover table-sm table-bordered mt-2">
   <thead>
       <th>#</th>
       <th>nom</th>
       <th>postnom</th>
       <th>prenom</th>
       <th>sexe</th>
       <th>adresse</th>
       <th>nom shop</th>
       <th>telephone</th>
       <th>paremettre</th>
   </thead>
   <tbody> 
      @foreach($fournisseur as $ligne)
      <tr>
            <td>{{ $ligne->id }}</td>
            <td>{{ $ligne->nom }}</td>
            <td>{{ $ligne->postnom }}</td>
            <td>{{ $ligne->prenom }}</td>
            <td>{{ $ligne->sexe }}</td>
            <td>{{ $ligne->adresse }}</td>
            <td>{{ $ligne->shop }}</td>
            <td>{{ $ligne->telephone }}</td>
            <td>
               <button type="button" id="button" class="btn edit">Modifier</button>
            </td>
      </tr>
      @endforeach
   </tbody>
</table>
@endsection
@section('modal')
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
       <div class="modal-content">
           <div class="modal-header">
               <h4 class="modal-title" id="myModalLabel">Ajouter fournisseur</h4>
               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
           </div>
           <div class="modal-body">
               <form id="monformulaire">
                   <div class="form-group">
                       <label for="nom">nom</label>
                       <input type="text" name="nom" id="nom" class="form-control btn-round">
                       <label for="postnom">postnom</label>
                       <input type="text" name="postnom" id="prenom" class="form-control btn-round">
                       <label for="prenom">prenom</label>
                       <input type="text" name="prenom" id="prenom" class="form-control btn-round">
                       <label for="sexe">sexe</label>
                       <select name="sexe" id="sexe" class="form-control btn-round">
                           <option value="m">M</option>
                           <option value="f">F</option>
                       </select>
                       <label for="quartier">Adresse</label>
                       <input type="text" name="adresse" id="adresse" class="form-control btn-round">
                       <label for="shop">Shop</label>
                       <input type="text" name="shop" id="shop" class="form-control btn-round">
                       <label for="telephone">telephone</label>
                       <input type="tel" name="telephone" id="telephone" class="form-control btn-round">
                   </div>
                   <input type="submit" id="button" value="Enregistrer" class="btn btn-info btn-round">
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
                <h4 class="modal-title" id="ModalLabel">Modifier fournisseur</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('fournisseurs.update') }}">
                    @csrf
                    <div class="form-group">
                      <input type="hidden" name="id" id="id">
                        <label for="nom">nom</label>
                        <input type="text" name="nom" id="mod_nom" class="form-control btn-round">
                        <label for="postnom">postnom</label>
                        <input type="text" name="postnom" id="mod_postnom" class="form-control btn-round">
                        <label for="prenom">prenom</label>
                        <input type="text" name="prenom" id="mod_prenom" class="form-control btn-round">
                        <label for="sexe">sexe</label>
                        <select name="sexe" id="mod_sexe" class="form-control btn-round">
                            <option value="m">M</option>
                            <option value="f">F</option>
                        </select>
                        <label for="quartier">Adresse</label>
                        <input type="text" name="adresse" id="mod_adresse" class="form-control btn-round">
                        <label for="shop">Shop</label>
                        <input type="text" name="shop" id="mod_shop" class="form-control btn-round">
                        <label for="telephone">telephone</label>
                        <input type="tel" name="telephone" id="mod_telephone" class="form-control btn-round">
                    </div>
                    <input type="submit"  value="Modifier" id="button" class="btn btn-round">
                </form>
            </div>
        </div>
    </div>
</div>
 <!-- modal-end -->
@endsection
@section('monscript')
  <script>
    $('#monformulaire').submit(function(event){
        event.preventDefault();
        $.ajax({
            url : '{{ route("fournisseur.store") }}',
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
  <script>
    $(document).ready(function(){
      $('.edit').on('click',function(){
        $('#Modalmodif').modal('show');
        $tr=$(this).closest('tr');
        var data=$tr.children("td").map(function(){
          return $(this).text();
        }).get();
        console.log(data);
        $('#id').val(data[0]);
        $('#mod_nom').val(data[1]);
        $('#mod_postnom').val(data[2]);
        $('#mod_prenom').val(data[3]);
        $('#mod_sexe').val(data[4]);
        $('#mod_adresse').val(data[5]);
        $('#mod_shop').val(data[6]);
        $('#mod_telephone').val(data[7]);
      });
    });
  </script>
@endsection