@extends('layouts.master')
@section('contenu')
<div class="row mt">
    <div class="col-lg-7 col-md-7 col-sm-12">
    <h4>Rapport vente</h4>
    <table class="table table-striped table-hover table-sm table-bordered">
          <thead>
                <th>#</th>
                <th>client</th>
                <th>produit</th>
                <th>nombre</th>
                <th>montant</th>
                <th>date jour</th>
          </thead>
          <tbody> 
            @foreach($sale as $pro)
                <tr>
                    <td>{{ $pro->id }}</td>
                    <td>{{ $pro->client_id }}</td>
                    <td>{{ $pro->category_id }}</td>
                    <td>{{ $pro->nombre }}</td>
                    <td>{{ $pro->montant }}</td>
                    <td>{{ $pro->dates }}</td>
                </tr>
          @endforeach
          </tbody>
    </table>
    </div>
    <!-- /col-lg-6 -->
    <div class="col-lg-5 col-md-5 col-sm-12">
      <div style="background:white;padding:5px;border-radius:7px;">
        <button id="button" type="button" class="btn" data-toggle="modal" data-target="#myModal">
            + Vente
        </button>
      <a class="btn btn-danger btn-round" style="margin-left: 150px;" href="#">Imprimer</a>
        <h4 class="mt-2">Stock des articles</h4>
    <table class="table table-striped table-hover table-sm table-bordered">
        <thead>
            <th>#</th>
            <th>Article</th>
            <th>Quantite Stock</th>
        </thead>
        <tbody>
            @foreach($stock as $stk)
                <tr>
                    <td>{{ $stk->id }}</td>
                    <td>{{ $stk->article }}</td>
                    <td>{{ $stk->quantite }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
      <br>
        <a class="btn btn-danger btn-round" style="margin-left: 250px;" href="#">Facture</a>
        <h4>Panier</h4>
    <table class="table table-striped table-hover table-sm table-bordered">
        <thead>
            <th >#</th>
            <th >client</th>
            <th >article</th>
            <th >nombre</th>
            <th >montant</th>
        </thead>
        <tbody>
            @foreach($panier as $pan)
                <tr>
                    <td>{{ $pan->id }}</td>
                    <td>{{ $pan->client }}</td>
                    <td>{{ $pan->article }}</td>
                    <td>{{ $pan->nombre }}</td>
                    <td>{{ $pan->montant }}</td>
                </tr>
            @endforeach          
        </tbody>
    </table>
    </div>
</div>
</div>
@endsection
@section('modal')
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Ajouter Vente</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('productsale.store') }}">
                    @csrf
                    <div class="form-goup">
                        <label for="client">client</label>
                        <select name="client" id="client" class="form-control btn-round">
                            <option value=""></option>  
                            @foreach ($client as $item)
                              <option value="{{ $item->prenom }}">{{ $item->prenom }}</option> 
                            @endforeach  
                        </select> 
                    <div class="form-goup"> 
                        <label for="designation">designation</label>
                        <select name="designation" id="designation" class="form-control btn-round">
                            <option value=""></option>
                            @foreach ($prod as $item)
                            <option value="{{ $item->designation }}">{{ $item->designation }}</option> 
                            @endforeach
                        </select>
                    </div> 
                    <div class="form-goup">
                        <label for="nombre">Nombre</label>
                        <input type="number" name="nombre" id="nombre" min="0" oninput="this.value=Math.abs(this.value)" class="form-control btn-round"> 
                    </div>
                    <div class="form-goup">
                        <label for="prix">Montant</label>
                        <input type="number" name="montant" id="montant" min="0" oninput="this.value=Math.abs(this.value)" class="form-control btn-round"> 
                    </div> <br>
                        <input type="submit" id="button" value="Ajouter" class="btn btn-info btn-round">
                    </div> 
                </form>
            </div>
        </div>
    </div>
</div>
@endsection