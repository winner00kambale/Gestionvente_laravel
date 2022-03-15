@extends('layouts.master')
@section('contenu')
<div class="row">
    <div class="col-md-5">
        <h3 class="mt-2">Les factures</h3>
        <hr>
    <div class="table-responsive p-0"> 
        <table class="table align-items-center mb-0 table-hover"> 
            <thead>
                <tr>
                    <th>#</th>
                    <th>clients</th>
                    <th>unites</th>
                    <th>montant Tot</th>
                    <th>dates</th>
                    <th>params</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($facture as $fac)
                    <tr>
                        <td>{{ $fac->id }}</td>
                        <td>{{ $fac->client }}</td>
                        <td>{{ $fac->unites }}</td>
                        <td>{{ $fac->montant_total }}</td>
                        <td>{{ $fac->datepaye }}</td>
                        <td>
                            <button type="button" id="button" class="btn btn-info edit">edit</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </div>
    <div class="col-md-5">
        <h3 style="color: #0C61AA;" class="mt-2">Rapport de payements</h3>
        <hr>
    <div class="table-responsive p-0"> 
        <table class="table table-bordered mb-0 table-hover"> 
            <thead>
                <tr style="background: #0C61AA;color:#ffffff">
                    <th>clients</th>
                    <th>facture</th>
                    <th>libelle</th>
                    <th>montant</th>
                    <th>dates</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payment as $paye)
                    <tr>
                        <td>{{ $paye->client }}</td>
                        <td>{{ $paye->facture }}</td>
                        <td>{{ $paye->libelle }}</td>
                        <td>{{ $paye->montant_total }}</td>
                        <td>{{ $paye->datepaye }}</td>
                    </tr>
                @endforeach
                
            </tbody>
        </table>
    </div>
    </div>
    <div class="col-md-2 mt-3">
        <h5>Caisse</h5>
        <div class="table-responsive p-0"> 
        <table class="table mt-2 table-bordered mb-0 table-hover">
            <thead>
                <tr>
                    <th style="background:red;color:white;">Solde</th>
                    <th style="background:red;color:white;">Devise</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    @foreach ($caisse as $caiss)
                        <td style="font-size: 25px;">{{ $caiss->montant }}</td>
                        <td style="font-size: 20px;">USD</td>
                    @endforeach
                </tr>
            </tbody>
        </table>
    </div>
    </div>
</div>
@endsection
@section('modal')
<!-- modal-star modification -->
<div class="modal fade" id="Modalmodif" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="ModalLabel">Save payments</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('payment.index') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                            <input type="hidden" name="id" id="id" value=""> <br>
                            <label for="nom">nom</label>
                            <input type="text" name="nom" id="nom" class="form-control" required>
                            <label for="facture">nume fac </label>
                            <input type="number" name="facture" class="form-control" id="facture" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <br>
                            <label for="montant">montant</label>
                            <input type="number" name="montant" class="form-control" id="montant" required>
                            <label for="libelle">libelle</label>
                            <input type="text" name="libelle" id="libelle" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <input class="btn round" id="button" type="submit" value="Save Payment">
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
    $(document).ready(function(){
      $('.edit').on('click',function(){
        $('#Modalmodif').modal('show');
        $tr=$(this).closest('tr');
        var data=$tr.children("td").map(function(){
          return $(this).text();
        }).get();
        console.log(data);
        $('#id').val(data[0]);
        $('#nom').val(data[1]);
        $('#facture').val(data[0]);
        $('#montant').val(data[3]);
      });
    });
  </script>
@endsection