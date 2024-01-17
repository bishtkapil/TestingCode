
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script> --}}
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>Document</title>
    <style>
        .badge {
            top: 2px !important;
            color: #ffffff !important;
        }

        .custom-badge1 {
            background-color: #4099ff !important;
        }

        .custom-badge2 {
            background-color: #2ed8b6 !important;
        }

        .custom-badge3 {
            background-color: #ff9d10 !important;
        }

        .custom-badge4 {
            background-color: #FF5370 !important;
        }

        .custom-badge5 {
            background-color: #00bcd4 !important;
        }

        .table {
            width: 100% !important;
        }

        table.dataTable tbody td {
            word-wrap: break-word;
            word-break: break-all;
            white-space: normal;
        }

        label.block{
            font-weight : bolder;
        }
        .mytooltip {
    display: inline;
    position: relative;
    z-index: 999;
    }

    .center {
    margin-top: 100px;
    border-bottom: 2px solid black;
    padding-bottom: 30px;
    }

    p{
    justify-content: center;
    align-items: center;
    align-content: center;
    /* margin: auto; */
    display: flex;
    font-size: 24px;
    margin-top: 25px;
    text-decoration: none;
    }

    a:hover {

    text-decoration:none !important;
    }


    .pagination li:hover{
    cursor: pointer;
    }

    .pagination {
    margin: 0;
    padding: 0;
    text-align: center;
    float:right;
    }
    .pagination li {
    display: inline
    }
    .pagination li a {
    display: inline-block;
    text-decoration: none;
    padding: 5px 10px;
    color: #000
    }

    /* .pagi{
    background-color: #4099ff;
    border: none;
    color: white!important;
    padding: 5px 12px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;

    } */
    .cent {
    justify-content: center;
    }
    .top{
            margin-top:50px;
        }
        /* .card{
            background: #ddd;
             border: 2px solid;
        } */
        form{
            padding:10px;
        }

    </style>
</head>
<body>
    <div class="container card p-5 top">
    <div class="row" style="display: flex;">
        <div class="col-xl-2 col-md-6">
        <a href="{{ url('kitdashboard')}}" >
            <div class="card bg-transparent">
                <button id="Bb1" type="button" class="btn btn-success waves-effect waves-light btn-outline-success  badge-button" data-target="customBadge1"style="background-color: #4099ff;color: #fff;">
                    <span class="pull-left">Total Stock</span>
                    <label class="badge custom-badge1 pull-right">{{ $total_data}}</label>
                </button>
            </div>
            </a>
        </div>
        {{-- @if(Auth::user()->role_id === 3 || Auth::user()->role_id === 2 ) --}}

            <div class="col-xl-2 col-md-6">
            <a href="{{ url('purchasedashboard')}}" >
                <div class="card bg-transparent">
                    <button id="Bb2" type="button" class="btn btn-success waves-effect waves-light btn-outline-success badge-button" data-target="customBadge2">
                        <span class="pull-left">Purchased Items</span>
                        <label class="badge custom-badge2 pull-right">{{ $total_purchase}}</label>
                    </button>
                </div>
                </a>
            </div>

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
        {{-- @endif --}}
        {{-- @if(Auth::user()->role_id === 3) --}}

        <div class="col-xl-2 col-md-6">
        <a href="{{ url('recieveditemsdashboard')}}" >
            <div class="card bg-transparent">
                <button id="Bb2" type="button" class="btn btn-success waves-effect waves-light btn-outline-success badge-button" data-target="customBadge2">
                    <span class="pull-left">Recevied Items</span>
                    <label class="badge custom-badge2 pull-right">{{ $total_recieveditems}}</label>
                </button>
            </div>
            </a>
        </div>
    {{-- @endif --}}
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-block">
                <label for="pages">No of records per page</label>
						<select name="pageno"  name="state" id="maxRows"  style="width: 40px; background-color: white; color:#4099ff;">
							<option value="5"> 5 </option>
  							<option value="10">10</option>
  							<option value="15">15</option>
  							<option value="20">20</option>
							<option value="25">25</option>
						</select>

                    <div class="dt-responsive table-responsive custom-badge-div" id="customBadge1">
                        <table id="table-id" class="table table-striped table-bordered js-serial">
                            <thead>
                                <tr>
                                    <th>Item Name</th>
                                    <th>Item Size</th>
                                    <th>Codal Life(In Years)</th>
                                    <th>Codal Life(In Months)</th>
                                    <th>Codal Life(In Days)</th>
                                    <th>Quantity</th>

                                </tr>
                            </thead>
                            <tbody>

                            @foreach($query as $list)
                            <tr>

                                <td>{{ $list->name}}</td>
                                <td>{{ $list->size}}</td>
                                <td>{{ $list->codal_life_years}}</td>
                                <td>{{ $list->codal_life_months}}</td>
                                <td>{{ $list->codal_life_days}}</td>
                                <td>{{ $list->quantity}}</td>


                            </tr>
                            @endforeach
                            </tbody>
                        </table>

<!--		Start Pagination -->
<div class='pagination-container' >
				<nav>
				  <ul class="pagination">

            <li data-page="prev" class="pagi">
								     <span> < <span class="sr-only">(current)</span></span>
								    </li>
				   <!--	Here the JS Function Will Add the Rows -->
        <li data-page="next" id="prev" class="pagi">
								       <span> > <span class="sr-only">(current)</span></span>
								    </li>
				  </ul>
				</nav>
			</div>

</div> <!-- 		End of Container -->

                    </div>

                    <!-- <div class="dt-responsive table-responsive custom-badge-div" id="customBadge3">
                        <h2 class="text-center">Badge 3</h2>
                    </div>
                    <div class="dt-responsive table-responsive custom-badge-div" id="customBadge4">
                        <h2 class="text-center">Badge 4</h2>
                    </div>
                    <div class="dt-responsive table-responsive custom-badge-div" id="customBadge5">
                        <h2 class="text-center">Badge 5</h2>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>




<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <script>
//   function addRowCount(tableAttr) {
//   $(tableAttr).each(function(){
//     $('th:first-child, thead td:first-child', this).each(function(){
//       var tag = $(this).prop('tagName');
//       $(this).before('<'+tag+' style="text-align:center";>S.No.</'+tag+'>');
//     });
//     $('td:first-child', this).each(function(i){
//       $(this).before('<td style="text-align:center";>'+(i+1)+'</td>');
//     });
//   });
// }

// // Call the function with table attr on which you want automatic serial number
// addRowCount('.js-serial');




getPagination('#table-id');




function getPagination(table) {
  var lastPage = 1;

  $('#maxRows')
    .on('change', function(evt) {
      //$('.paginationprev').html('');						// reset pagination

     lastPage = 1;
      $('.pagination')
        .find('li')
        .slice(1, -1)
        .remove();
      var trnum = 0; // reset tr counter
      var maxRows = parseInt($(this).val()); // get Max Rows from select option

      if (maxRows == 5000) {
        $('.pagination').hide();
      } else {
        $('.pagination').show();
      }

      var totalRows = $(table + ' tbody tr').length; // numbers of rows
      $(table + ' tr:gt(0)').each(function() {
        // each TR in  table and not the header
        trnum++; // Start Counter
        if (trnum > maxRows) {
          // if tr number gt maxRows

          $(this).hide(); // fade it out
        }
        if (trnum <= maxRows) {
          $(this).show();
        } // else fade in Important in case if it ..
      }); //  was fade out to fade it in
      if (totalRows > maxRows) {
        // if tr total rows gt max rows option
        var pagenum = Math.ceil(totalRows / maxRows); // ceil total(rows/maxrows) to get ..
        //	numbers of pages
        for (var i = 1; i <= pagenum; ) {
          // for each page append pagination li
          $('.pagination #prev')
            .before(
              '<li data-page="' +
                i +
                '">\
								  <span class="pagi">' +
                i++ +
                '<span class="sr-only">(current)</span></span>\
								</li>'
            )
            .show();
        } // end for i
      } // end if row count > max rows
      $('.pagination [data-page="1"]').addClass('active'); // add active class to the first li
      $('.pagination li').on('click', function(evt) {
        // on click each page
        evt.stopImmediatePropagation();
        evt.preventDefault();
        var pageNum = $(this).attr('data-page'); // get it's number

        var maxRows = parseInt($('#maxRows').val()); // get Max Rows from select option

        if (pageNum == 'prev') {
          if (lastPage == 1) {
            return;
          }
          pageNum = --lastPage;
        }
        if (pageNum == 'next') {
          if (lastPage == $('.pagination li').length - 2) {
            return;
          }
          pageNum = ++lastPage;
        }

        lastPage = pageNum;
        var trIndex = 0; // reset tr counter
        $('.pagination li').removeClass('active'); // remove active class from all li
        $('.pagination [data-page="' + lastPage + '"]').addClass('active'); // add active class to the clicked
        // $(this).addClass('active');					// add active class to the clicked
	  	limitPagging();
        $(table + ' tr:gt(0)').each(function() {
          // each tr in table not the header
          trIndex++; // tr index counter
          // if tr index gt maxRows*pageNum or lt maxRows*pageNum-maxRows fade if out
          if (
            trIndex > maxRows * pageNum ||
            trIndex <= maxRows * pageNum - maxRows
          ) {
            $(this).hide();
          } else {
            $(this).show();
          } //else fade in
        }); // end of for each tr in table
      }); // end of on click pagination list
	  limitPagging();
    })
    .val(5)
    .change();

  // end of on select change

  // END OF PAGINATION
}

function limitPagging(){
	// alert($('.pagination li').length)

	if($('.pagination li').length > 7 ){
			if( $('.pagination li.active').attr('data-page') <= 3 ){
			$('.pagination li:gt(5)').hide();
			$('.pagination li:lt(5)').show();
			$('.pagination [data-page="next"]').show();
		}if ($('.pagination li.active').attr('data-page') > 3){
			$('.pagination li:gt(0)').hide();
			$('.pagination [data-page="next"]').show();
			for( let i = ( parseInt($('.pagination li.active').attr('data-page'))  -2 )  ; i <= ( parseInt($('.pagination li.active').attr('data-page'))  + 2 ) ; i++ ){
				$('.pagination [data-page="'+i+'"]').show();

			}

		}
	}
}

$(function() {
  // Just to append id number for each row
  $('table tr:eq(0)').prepend('<th> S.no </th>');

  var id = 0;

  $('table tr:gt(0)').each(function() {
    id++;
    $(this).prepend('<td>' + id + '</td>');
  });
});





    </script>

