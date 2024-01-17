

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
      <title>Document</title>
<style>

.top{
    margin-top: 50px;
}
</style>
</head>
<body>
    <div class="container card p-5 top">
        <div class="row" style="display: flex;">
        <div class="col-xl-2 col-md-6">
        <a href="{{ url('kitdashboard')}}" >
            <div class="card bg-transparent">
                <button id="Bb1" type="button" class="btn btn-primary waves-effect waves-light  badge-button" data-target="customBadge1">
                    <span class="pull-left">Total Stock</span>
                    <label class="badge custom-badge1 pull-right">{{ $total_data}}</label>
                </button>
            </div>
         </a>
        </div>
        @if(Auth::user()->role_id === 3 || Auth::user()->role_id === 2)
            <div class="col-xl-2 col-md-6">
            <a href="{{ url('purchasedashboard')}}" >
                <div class="card bg-transparent">
                    <button id="Bb2" type="button" class="btn btn-success waves-effect waves-light btn-outline-success badge-button" data-target="customBadge2">
                        <span class="pull-left">Purchased</span>
                     <label class="badge custom-badge2 pull-right">{{ $total_purchase}}</label>
                    </button>
                </div>
            </div>
          </a>
            <div class="col-xl-2 col-md-6">
                <a href="{{ url('distributedashboard')}}" >
                <div class="card bg-transparent">
                    <button id="Bb3" type="button" class="btn waves-effect waves-light btn-warning btn-outline-warning badge-button" data-target="customBadge3">
                        <span class="pull-left">Distribute Items</span>
                        <label class="badge custom-badge3 pull-right">{{ $total_distribute}}</label>
                    </button>
                </div>
            </div>
        </a>
        @endif
        @if(Auth::user()->role_id === 3)

        <div class="col-xl-2 col-md-6">
        <a href="{{ url('recieveditemsdashboard')}}" >
            <div class="card bg-transparent">
                <button id="received" type="button" class="btn btn-success waves-effect waves-light btn-outline-success badge-button" data-target="customBadge2">
                    {{-- <span class="pull-left">Recevied From Zone</span>
                    <label class="badge custom-badge2 pull-right"></label> --}}
                </button>
            </div>
            </a>
        </div>
    @endif
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-block">
                        <select  id="filter" name="filter">
                          <option value=""> select </option>
                            @foreach($item as $list)
                                        <option value="{{ $list->name}}"> {{ $list->name}} </option>
                                        @endforeach
                                    </select>
            <div class="dt-responsive table-responsive custom-badge-div" id="customBadge1">
                        <table id="table-id" class="table table-striped table-bordered js-serial">
                            <thead>
                                <tr>
                                    <th>s.no</th>
                                    <th>Item Name</th>
                                    <th>Item Size</th>
                                    <th>Quantity</th>
                                    <th>Recevied From</th>
                                    <th>Distribute Division</th>
                                    <th>Recevied Date / Time</th>

                                </tr>
                            </thead>
                            <tbody>
                            @foreach($recieveditems as $list)

                                <tr data-name="{{ $list->name }}">
                                <td>{{ $list->name }}</td>
                                <td>{{ $list->size }}</td>
                                <td>{{ $list->quantity}}</td>
                                <td>{{ $list->user_name }}</td>
                                <td>{{ $list->division }}</td>
                                <td> {{ $list->updated_at}}  </td>

                            </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="placed_at_modal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="items_name"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <form id="main" method="post" action='' novalidate>
                    <div class="modal-body">
                        @csrf
                        <div id="quantity_html">

                        </div>
                        <input type="hidden" name="warranty_type" id="warranty_type">
                        <input type="hidden" name="item_id" id="item_id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <!-- <button type="submit" class="btn btn-primary waves-effect waves-light ">Save changes</button> -->
                        <button type="button" class="btn btn-primary m-b-0 storeUsedItem">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>

<!-- Add these lines within the <head> section -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<!-- DataTables Buttons JS -->
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.1.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.1.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<!-- DataTables Buttons CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.1.1/css/buttons.dataTables.min.css">
<!-- pdfmake -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/vfs_fonts.js"></script>
<script>




    </script>

