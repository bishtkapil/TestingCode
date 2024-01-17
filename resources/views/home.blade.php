@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in! {{ Auth::user()->name}}

                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a class="navbar-brand" href="#">Logo</a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                          <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                          <ul class="navbar-nav mr-auto">
                            <li class="nav-item active">
                              <a class="nav-link" href="{{ url('/testingform')}}">Add Form <span class="sr-only">(current)</span></a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" href="{{ url('/kit/master')}}">Add Kit Items</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Display Data
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="nav-link" href="{{ url('show')}}">Display Data</a>
                                    <a class="nav-link" href="{{ url('ajaxdisplay')}}">Ajax Display Data</a>
                                    <a class="nav-link" href="{{ url('table')}}">Table Data</a>
                                    <a class="nav-link" href="{{ url('multiple')}}">Multiple Form</a>
                                  <div class="dropdown-divider"></div>

                                </div>
                              </li>
                            <li class="nav-item">

                              </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('kit/add')}}">Purchase Items</a>
                              </li>
                            <li class="nav-item dropdown">
                              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Dashboard
                              </a>
                              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ url('kitdashboard')}}">Total Stock</a>
                                <a class="dropdown-item" href="{{ url('purchasedashboard')}}">Purchase</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Something else here</a>
                              </div>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" href="{{ url('testingcode')}}">testingcode</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('select')}}">Dependentselect</a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" href="{{ url('/display-email-data')}}">emaildata</a>
                              </li>

                          </ul>

                        </div>
                      </nav>

    </div>
</div>

@endsection
