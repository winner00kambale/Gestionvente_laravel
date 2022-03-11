@extends('layouts.master')
@section('contenu')
<div class="container-fluid py-4">
    <div class="row">
      <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div id="mondiv" class="card">
          <div class="card-body p-3">
            <div class="row">
              <div class="col-8">
                <div class="numbers">
                  <p class="text-sm mb-0 text-capitalize font-weight-bold">Today's Sales</p>
                  <h5 class="font-weight-bolder mb-0">
                    $53,000
                    <span class="text-success text-sm font-weight-bolder">+55%</span>
                  </h5>
                </div>
              </div>
              <div class="col-4 text-end">
                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                  <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true">
                      <img id="log" src="{{ asset('img/logo.PNG') }}" alt="mon logo">
                  </i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div id="mondiv" class="card">
          <div class="card-body p-3">
            <div class="row">
              <div class="col-8">
                <div class="numbers">
                  <p class="text-sm mb-0 text-capitalize font-weight-bold">Clients</p>
                  <h5 class="font-weight-bolder mb-0">
                    2,300
                    <span class="text-success text-sm font-weight-bolder">+3%</span>
                  </h5>
                </div>
              </div>
              <div class="col-4 text-end">
                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                  <i class="ni ni-world text-lg opacity-10" aria-hidden="true">
                    <img id="log" src="{{ asset('img/logo.PNG') }}" alt="mon logo">
                  </i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div id="mondiv" class="card">
          <div class="card-body p-3">
            <div class="row">
              <div class="col-8">
                <div class="numbers">
                  <p class="text-sm mb-0 text-capitalize font-weight-bold">New Clients</p>
                  <h5 class="font-weight-bolder mb-0">
                    +3,462
                    <span class="text-danger text-sm font-weight-bolder">-2%</span>
                  </h5>
                </div>
              </div>
              <div class="col-4 text-end">
                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                  <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true">
                    <img id="log" src="{{ asset('img/logo.PNG') }}" alt="mon logo">
                  </i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6">
        <div id="mondiv" class="card">
          <div class="card-body p-3">
            <div class="row">
              <div class="col-8">
                <div class="numbers">
                  <p class="text-sm mb-0 text-capitalize font-weight-bold">Sales</p>
                  <h5 class="font-weight-bolder mb-0">
                    $103,430
                    <span class="text-success text-sm font-weight-bolder">+5%</span>
                  </h5>
                </div>
              </div>
              <div class="col-4 text-end">
                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                  <i class="ni ni-cart text-lg opacity-10" aria-hidden="true">
                    <img id="log" src="{{ asset('img/logo.PNG') }}" alt="mon logo">
                  </i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
<div class="row">
    <div class="col-7">
        <div id="dash" class=" pt-2 container">
            <h3 style="color: brown">Alert Stock</h3>
            <table class="table table-striped table-hover table-sm table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Designation</th>
                        <th>Quantite stock</th>
                    </tr>
                </thead>
                <tbody>
                        @foreach ($alert as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->article }}</td>
                                <td>{{ $item->quantite }}</td>
                            </tr>
                        @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-5"></div>
</div>    
@endsection