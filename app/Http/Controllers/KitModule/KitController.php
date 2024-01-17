<?php

namespace App\Http\Controllers\KitModule;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Kit;
use App\Models\InventoryPurchaseDetail;
use App\Models\Division;
use App\Models\Post;
use App\Models\Zone;
Use App\User;
use App\Models\ItemName;
use App\Models\Store;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
use PDF;



class KitController  extends Controller
{


   public function master(){

    $item_size = DB::table('kit_size')->select('*')->get();
    $entitlement = DB::table('rank_group')->get();
    return view('Kit.KitMaster',compact('item_size','entitlement'));
}
public function addmaster(Request $request){


    $data = DB::table('kit_item_names')->select('*')
            ->where('name','=',$request->input('Uniform_Item'))
            ->get();

    // dd(count($data));
    if(count($data) == 0){
        $name = strtolower($request->input('Uniform_Item'));
        $item_size = $request->input('item_size');
        $item_scale = $request->input('item_scale');
        $codal_life_years=$request->input('codal_life_years');
        $codal_life_months=$request->input('codal_life_months');
        $codal_life_days=$request->input('codal_life_days');
        $entitlement=$request->input('entitlement');
        $entitlement = implode(',', $entitlement);

        DB::table('kit_item_names')->insert(
            ['name' => $name,  'scale' => $item_scale, 'codal_life_years' => $codal_life_years,'codal_life_months' => $codal_life_months,'codal_life_days' => $codal_life_days, 'Entitlement'=>$entitlement
        ]);
        $id=DB::table('kit_item_names')->select("id")->where("name","=",$name)->get();

        $id=$id[0]->id;
        $item_size = explode(',', $item_size);
        if(count($item_size) > 1){
            foreach($item_size as $size){

                DB::table('kit_size')->insert(["size" => $size,"kit_name_id" => $id]);
            }
        }else{
            DB::table('kit_size')->insert(["size" => $item_size,"kit_name_id" => $id]);
        }
        return ["status"=>"success"];
    }else{
        return ["status"=>"false"];
    }

}
    public function create()
    {
        $data['stores'] = Store::get()->pluck('name','id')->toArray();
        $data['stores_type'] = Store::get()->pluck('type','id')->toArray();
        $kit_item = DB::table('kit_item_names')->get();
        $item_size = DB::table('kit_size')->select('*')->get();
        return view('Kit.PurchaseKit',compact('item_size','kit_item'),$data);
    }


    public function addstore(Request $request)
    {
        $date = Carbon::now();
        $user = Auth::user();
        // dd($user);
        $user_id = $user->id;
        $role_id = $user->role_id;
        $zone_id = $user->zone_id;
        $division_id = $user->division_id;
        // dd($division_id);
        $post_id = $user->post_id;
        $Item_Purchased = $request->input('Item_Purchased');
        $Item_Name = $request->input('Item_Name');
        $Item_Size = $request->input('Item_Size');
        $quantity  = $request->input('quantity');
        $Vendor_Department_Details=$request->input('Vendor_Department_Details');
        $Vendor_Contact_No=$request->input('Vendor_Contact_No');
        $P_O_W_O_Regs_No=$request->input('P_O_W_O_Regs_No');
        $P_O_W_O_Regs_Date=$request->input('P_O_W_O_Regs_Date');
        $Challan_Issued_Note_No=$request->input('Challan_Issued_Note_No');
        $Challan_Issued_Note_Date=$request->input('Challan_Issued_Note_Date');
        $Ivoice_Bill_Date=$request->input('Ivoice_Bill_Date');
        $Inspection_On=$request->input('Inspection_On');
        $Inspection_By =$request->input('Inspection_By');
        DB::table('purchase_kit')->insert(
            ['user_id' =>$user_id,'role_id' =>$role_id,'zone_id' =>$zone_id,'division_id' =>$division_id,'post_id' =>$post_id,'Item_Purchased' => $Item_Purchased, 'Item_Name' => $Item_Name, 'Item_Size' => $Item_Size,'quantity' =>$quantity, 'Vendor_Department_Details' => $Vendor_Department_Details, 'Vendor_Contact_No'=>$Vendor_Contact_No,
            'P_O_W_O_Regs_No' => $P_O_W_O_Regs_No, 'P_O_W_O_Regs_Date' => $P_O_W_O_Regs_Date, 'Challan_Issued_Note_No' => $Challan_Issued_Note_No, 'Challan_Issued_Note_Date'=>$Challan_Issued_Note_Date,
            'Ivoice_Bill_Date' => $Ivoice_Bill_Date, 'Inspection_On' => $Inspection_On, 'Inspection_By' => $Inspection_By
        ]);



        $data = DB::table('zone_division_quantity_update')
        ->select('*')
        ->where('item_name', '=',$Item_Name)
        ->where('item_size', '=',$Item_Size)
        ->where('user_id', '=',$user_id)
        ->get();

        // dd($data);

        if (count($data) == 0) {

            DB::table('zone_division_quantity_update')->insert(
                ['Item_Name' => $Item_Name, 'Item_Size' => $Item_Size,'quantity' =>$quantity,'user_id' =>$user_id,'role_id' =>$role_id,'zone_id' =>$zone_id,'division_id' =>$division_id,'post_id' =>$post_id, 'created_at' =>$date,'updated_at'=>$date
            ]);
        }else {

            DB::table('zone_division_quantity_update')
                ->where('id','=',$data[0]->id)
                ->update(
                ['quantity' =>$data[0]->quantity + $quantity, 'created_at' =>$date,'updated_at'=>$date
            ]);
        }


    }

    public function kitdashboard(){



        $user = Auth::user();
        // dd($user);
        $user_id = $user->id;
        $zone_id = $user->zone_id;
        $division_id = $user->division_id;
        // dd($division_id);
        $post_id = $user->post_id;
        if(empty($division_id)){

            $query = DB::table('zone_division_quantity_update as zdqu')
            ->select('zdqu.*','item.*','size.*')
            ->leftjoin('kit_item_names as item','item.id','=','zdqu.item_name')
            ->leftjoin('kit_size as size','size.id','=','zdqu.item_size')
            ->where('zdqu.zone_id','=',$zone_id)
            ->where('zdqu.division_id','=',$division_id)
            ->orderBy('zdqu.updated_at','desc')
            ->get();
            // dd($query);
        }

        if(empty($post_id)){

            $query = DB::table('zone_division_quantity_update as zdqu')
            ->select('zdqu.*','item.*','size.*')
            ->leftjoin('kit_item_names as item','item.id','=','zdqu.item_name')
            ->leftjoin('kit_size as size','size.id','=','zdqu.item_size')
            ->where('zdqu.zone_id','=',$zone_id)
            ->where('zdqu.division_id','=',$division_id)
            ->where('zdqu.post_id','=',$post_id)
            ->orderBy('zdqu.updated_at','desc')
            ->get();
            // dd($query);
        }



        // if(!empty($query[0]))
        $purchase = DB::table('purchase_kit')->where('user_id','=',$user_id)->get();
        $distribute = DB::table('kit_distridution as kd')->where('kd.user_id','=',$user_id)->get();
        $recieveditems = DB::table('kit_distridution as kd')->where('kd.distribution_division','=',$division_id)->get();

        $total_data = count($query);
        $total_purchase = count($purchase);
        $total_distribute =count($distribute);
        $total_recieveditems = count($recieveditems);

        // dd($query);
        $data = ([

            'query' =>$query,
            'total_data' => $total_data,
            'total_purchase' => $total_purchase,
            'total_distribute' => $total_distribute,
            'total_recieveditems' => $total_recieveditems

        ]);

        // dd($purchase);
        return view('Kit.Kitdashboard',$data);
    }

    public function purchasedashboard(){




        $user = Auth::user();
        $user_id = $user->id;
        $division_id = $user->division_id;
        $purchase = DB::table('purchase_kit as ak')
                    ->select('ak.*','item.*','size.size','s.name as store')
                    ->leftjoin('kit_item_names as item','item.id','=', 'ak.Item_Name')
                    ->leftjoin('kit_size as size','size.id','=', 'ak.Item_Size')
                    ->leftjoin('stores as s','s.id','=', 'ak.Item_Purchased')
                    ->where('ak.user_id','=',$user_id)
                    ->orderBy('ak.updated_at','desc')
                    ->get();

        $distribute = DB::table('kit_distridution as kd')->where('kd.user_id','=',$user_id)->get();
        $query = DB::table('zone_division_quantity_update as zdqu')->where('zdqu.user_id','=',$user_id)->get();
        $recieveditems = DB::table('kit_distridution as kd')->where('kd.distribution_division','=',$division_id)->get();
        $total_data = count($query);
        $total_purchase = count($purchase);
        $total_distribute =count($distribute);
        $total_recieveditems = count($recieveditems);

        // dd($query);
        $data = ([

            'query' =>$query,
            'purchase' => $purchase,
            'total_data' => $total_data,
            'total_purchase' => $total_purchase,
            'total_distribute' => $total_distribute,
            'total_recieveditems' => $total_recieveditems

        ]);

        // dd($purchase);
        return view('Kit.purchasedashboard',$data);
    }

    public function distributedashboard(){


        $user = Auth::user();
        $user_id = $user->id;
        $division_id = $user->division_id;
        $distribute = DB::table('kit_distridution as kd')
                    ->select('kd.*','item.*','size.*','p.name as post','d.name as division','u.name as user_name')
                    ->leftjoin('kit_item_names as item','item.id','=', 'kd.item_name')
                    ->leftjoin('kit_size as size','size.id','=', 'kd.item_size')
                    ->leftjoin('posts as p','p.id','=', 'kd.distribution_post')
                    ->leftjoin('divisions as d','d.id','=', 'kd.distribution_division')
                    ->leftjoin('users as u','u.id','=', 'kd.user_id')
                    ->where('kd.user_id','=',$user_id)
                    ->orderBy('kd.updated_at','desc')
                    ->get();

        // dd($distribute);
        $purchase = DB::table('purchase_kit')->where('user_id','=',$user_id)->get();
        // $distribute = DB::table('kit_distridution as kd')->where('kd.user_id','=',$user_id)->get();
        $query = DB::table('zone_division_quantity_update as zdqu')->where('zdqu.user_id','=',$user_id)->get();
        $recieveditems = DB::table('kit_distridution as kd')->where('kd.distribution_division','=',$division_id)->get();
        $total_data = count($query);
        $total_purchase = count($purchase);
        $total_distribute =count($distribute);
        $total_recieveditems = count($recieveditems);

        // dd($distribute);
        $data = ([
            'distribute' =>$distribute,
            'total_data' => $total_data,
            'total_purchase' => $total_purchase,
            'total_distribute' => $total_distribute,
            'total_recieveditems' => $total_recieveditems

        ]);

        // dd($purchase);
        return view('Kit.distributedashboard',$data);
    }


    public function recieveditemsdashboard(){




        $item = DB::table('kit_item_names')->get();
        $user = Auth::user();
        $user_id = $user->id;
        $division_id = $user->division_id;
        $recieveditems = DB::table('kit_distridution as kd')
                    ->select('kd.*','item.*','size.size','u.name as user_name','d.name as division')
                    ->leftjoin('kit_item_names as item','item.id','=', 'kd.item_name')
                    ->leftjoin('kit_size as size','size.id','=', 'kd.item_size')
                    ->leftjoin('users as u','u.id','=', 'kd.user_id')
                    ->leftjoin('divisions as d','d.id','=', 'kd.distribution_division')
                    ->where('kd.distribution_division','=',$division_id)
                    ->orderBy('kd.updated_at','desc')
                    ->get();

                    // dd($recieveditems);
        $purchase = DB::table('purchase_kit')->where('user_id','=',$user_id)->get();
        $distribute = DB::table('kit_distridution as kd')->where('kd.user_id','=',$user_id)->get();
        $query = DB::table('zone_division_quantity_update as zdqu')->where('zdqu.user_id','=',$user_id)->get();
        $total_data = count($query);
        $total_recieveditems = count($recieveditems);
        $total_distribute =count($distribute);
        $total_purchase = count($purchase);




        $data = ([
            'item' => $item,
            'query' =>$query,
            'distribute' =>$distribute,
            'recieveditems' => $recieveditems,
            'total_data' => $total_data,
            'total_purchase' => $total_purchase,
            'total_recieveditems' => $total_recieveditems,
            'total_distribute' => $total_distribute,

        ]);

        // dd($purchase);
        return view('Kit.recieveditemsdashboard',$data);
    }

    public function getData(Request $request)
    {

        $user = Auth::user();
        $user_id = $user->id;
        $division_id = $user->division_id;
        $recieveditems = DB::table('kit_distridution as kd')
                    ->select('kd.*','item.*','size.size','u.name as user_name','d.name as division')
                    ->leftjoin('kit_item_names as item','item.id','=', 'kd.item_name')
                    ->leftjoin('kit_size as size','size.id','=', 'kd.item_size')
                    ->leftjoin('users as u','u.id','=', 'kd.user_id')
                    ->leftjoin('divisions as d','d.id','=', 'kd.distribution_division')
                    ->where('kd.distribution_division','=',$division_id)
                    ->orderBy('kd.updated_at','desc')
                    ->get();


        return DataTables::of($recieveditems)
        ->addIndexColumn()
       ->make(true);

    //    return response()->json(['message' => 'Invalid request'], 400);
    }


    public function countData(Request $request)
    {

        $user = Auth::user();
        $user_id = $user->id;
        $division_id = $user->division_id;
        $recieveditems = DB::table('kit_distridution as kd')
                    ->select('kd.*','item.*','size.size','u.name as user_name','d.name as division')
                    ->leftjoin('kit_item_names as item','item.id','=', 'kd.item_name')
                    ->leftjoin('kit_size as size','size.id','=', 'kd.item_size')
                    ->leftjoin('users as u','u.id','=', 'kd.user_id')
                    ->leftjoin('divisions as d','d.id','=', 'kd.distribution_division')
                    ->where('kd.distribution_division','=',$division_id)
                    ->orderBy('kd.updated_at','desc')
                    ->get();

              $total_recieveditems = count($recieveditems);

       return response()->json(['total_recieveditems' => $total_recieveditems]);
    }


    public function DueList()
    {

        $ranks = DB::table('ranks')->select('*')->get();

        $kit= DB::table('kit_item_names')->select('*')->get();

        $codal_life =DB::table("kit_item_names")->select("codal_life_years","codal_life_months","codal_life_days")->where("id",1)->get();
        $current_date=Carbon::now();
        $newDateTime = Carbon::now()->subYear($codal_life[0]->codal_life_years)->subMonth($codal_life[0]->codal_life_months)->subDays($codal_life[0]->codal_life_days);



        $data=DB::connection("mysql")->table("kit_item_names as ktn")->select('emp.employee_name','emp.pay_slip_employee_no','ktn.id as item_id','r.name','emp.id',"emp.ein as emp_id","ktn.name as item_name")->where("ktn.id","=",1)->leftjoin("rpf_e_suvidha.employee as emp",function($join){
            $join->whereRaw("find_in_set(emp.current_rank_id,ktn.entitlement)");
        })
        ->leftJoin('ranks as r','r.id', '=', 'rpf_e_suvidha.emp.current_rank_id')
        ->whereNotIn("emp.pay_slip_employee_no",DB::table("kit_transaction as kt")->select("kt.pay_slip_number")->where("kt.item_name","=","Peak Cap")->whereBetween("kt.physicaly_assign_date",[$newDateTime, $current_date]))
        ->paginate(10);

        // dd($s);
        return view('frontend.app.Kit.duekit',compact('kit','data'));
    }

public function DueEmpList(Request $request){

    $id = $request->post('id');
    error_log($id);
    $kit= DB::table('kit_item_names')->select('*')->get();
    $id = $request->post('id');
    $codal_life =DB::table("kit_item_names")->select("codal_life_years","codal_life_months","codal_life_days")->where("id",$id)->get();
    $current_date=Carbon::now();
    $newDateTime = Carbon::now()->subYear($codal_life[0]->codal_life_years)->subMonth($codal_life[0]->codal_life_months)->subDays($codal_life[0]->codal_life_days);



    $data=DB::connection("mysql")->table("kit_item_names as ktn")->select('emp.employee_name','emp.pay_slip_employee_no','ktn.id as item_id','r.name','emp.id',"emp.ein as emp_id","ktn.name as item_name")->where("ktn.id","=",2)->leftjoin("rpf_e_suvidha.employee as emp",function($join){
        $join->whereRaw("find_in_set(emp.current_rank_id,ktn.entitlement)");
    })
    ->leftJoin('ranks as r','r.id', '=', 'rpf_e_suvidha.emp.current_rank_id')
    ->whereNotIn("emp.pay_slip_employee_no",DB::table("kit_transaction as kt")->select("kt.pay_slip_number")->where("kt.item_name","=","Peak Cap")->whereBetween("kt.physicaly_assign_date",[$newDateTime, $current_date]))
    ->paginate(10);


    // dd($data);
return view('frontend.app.Kit.duekit',compact('kit','data'));
}
// new
public function addduelist(Request $request)
    {


            $query=DB::table('')
            ->where('employee_name', 'like', '%' . $request->employee_name . '%')
                ->where('pf_no', 'like', '%' . $request->pf_no . '%')
                ->where('rank', 'like', '%' . $request->rank . '%')
                ->where('item_physically_assign_date', 'like', '%' . $request->item_physically_assign_date . '%')
                ->where('sydtem_assign_date', 'like', '%' . $request->sydtem_assign_date . '%')
                ->where('Item_Size', 'like', '%' . $request->Item_Size . '%')
                ->get();
    }

    public function due(Request $request, $id){



        $Stock =  DB::connection('mysql2')->table('employee as emp')
        ->select ('emp.employee_name','emp.pay_slip_employee_no','r.name','emp.id')
        ->leftJoin('assets_management_sys.ranks as r','r.id', '=', 'emp.current_rank_id')
        ->where('emp.id','=',$id)
        ->get();

        // dd($Stock);


        return view('frontend.app.Kit.duelist',compact('Stock'));
    }



    public function value(Request $request){
        $id = $request->post('id');
        // dd($id);
        error_log($id);

    }


    public function duesubmit(Request $request)
    {
        $employee_name = $request->input('employee_name');
        $pay_slip_number = $request->input('pay_slip_number');
        $rank = $request->input('rank');
        $item_name = $request->input('item_name');
        $scale = $request->input('scale');
        $system_assign_date = $request->input('system_assign_date');
        $physicaly_assign_date = $request->input('physicaly_assign_date');
        $description = $request->input('description');

          DB::table('assets_management_sys.kit_transaction')->insert(
             ['employee_name' => $employee_name, 'pay_slip_number' => $pay_slip_number, 'rank' => $rank, 'item_name'=>$item_name,
             'scale' => $scale, 'system_assign_date' => $system_assign_date, 'physicaly_assign_date' => $physicaly_assign_date, 'description'=>$description,
        ]);
    }


    public function kitdistribution(){
        $item_size = DB::table('kit_size')->select('*')
        ->get();
        $item_name = DB::table('kit_item_names')->get();
        $post = DB::table('posts')->get();
        $posts= DB::table('posts as p')->select('*')
        ->where('p.division_id','=', Auth::user()->division_id)
        ->get();

        $division = DB::table('divisions')->select('*')
        ->where('divisions.zone_id','=',Auth::user()->zone_id)
        ->get();

        return view('frontend.app.Kit.kitdistribution',compact('item_size','item_name','posts','division','post'));
    }

    public function distribution(Request $request)
    {


        $date = Carbon::now();
        $item_name = $request->input('item_name');
        $division =  $request->input('division');
        $item_size = $request->input('item_size');
        $quantity = $request->input('quantity');
        $distribution_post = $request->input('distribution_post');
        $distribution_division =  $request->input('distribution_division');
        $through = $request->input('through');
        $date = $request->input('date');
        $remark = $request->input('remark');
        $user_id = Auth::user()->id;
        $pf_no = Auth::user()->pf_no;
        $user_zone_id = Auth::user()->zone_id;
        $user_division_id = Auth::user()->division_id;
        $user_post_id = Auth::user()->post_id;
          DB::table('kit_distridution')->insert(
             ['item_name' => $item_name, 'item_size'=>$item_size, 'distribution_post' => $distribution_post, 'distribution_division' => $distribution_division, 'through'=>$through,
             'date' => $date, 'remark' => $remark, 'quantity'=>$quantity, 'user_id'=>$user_id, 'pf_no'=>$pf_no, 'user_zone_id'=>$user_zone_id,'user_division_id'=>$user_division_id,'user_post_id'=>$user_post_id
        ]);



        $data = DB::table('zone_division_quantity_update')
        ->select('*')
        ->where('item_name', '=',$request->input('item_name'))
        ->where('item_size', '=',$request->input('item_size'))
        ->where('user_id', '=',Auth::user()->id)
        ->get();

        // dd($data[0]->quantity - $request->input('quantity'));

        if (count($data) == 1) {
        // error_reporting(543);
            DB::table('zone_division_quantity_update')
                ->where('id','=',$data[0]->id)
                ->update(
                ['quantity' =>$data[0]->quantity - $request->input('quantity'),
            ]);
        }

        if(empty($distribution_post)){
        $distribution_data = DB::table('zone_division_quantity_update')
        ->select('*')
        ->where('item_name', '=',$request->input('item_name'))
        ->where('item_size', '=',$request->input('item_size'))
        ->Where('division_id', '=',$request->input('distribution_division'))
        ->get();
        }else{

            $distribution_data = DB::table('zone_division_quantity_update')
            ->select('*')
            ->where('item_name', '=',$request->input('item_name'))
            ->where('item_size', '=',$request->input('item_size'))
            ->Where('division_id', '=',$request->input('distribution_division'))
            ->Where('post_id', '=',$request->input('distribution_post'))
            ->get();
        }
        // dd($distribution_data);

    if (empty($distribution_data)) {
        // error_log(1230);
        DB::table('zone_division_quantity_update')
            ->where('id','=',$distribution_data[0]->id)
            ->update(
            ['quantity' =>$distribution_data[0]->quantity + $request->input('quantity'),'created_at' =>$date,'updated_at'=>$date
            ]);
        }
    else{
        DB::table('zone_division_quantity_update')
            ->insert(
            ['item_name' =>$item_name,'item_size'=>$item_size,'quantity'=>$quantity,'zone_id' =>$user_zone_id,'division_id'=>$distribution_division,'post_id'=>$distribution_post,'created_at' =>$date,'updated_at'=>$date
    ]);

    }
        return redirect()->back()->with('success', 'Kit Distribution successfully!');
    }


    public function filterData(Request $request)
    {

        $user = Auth::user();
        $user_id = $user->id;
        $division_id = $user->division_id;
        $recieveditems = DB::table('kit_distridution as kd')
                    ->select('kd.*','item.*','size.size','u.name as user_name','d.name as division')
                    ->leftjoin('kit_item_names as item','item.id','=', 'kd.item_name')
                    ->leftjoin('kit_size as size','size.id','=', 'kd.item_size')
                    ->leftjoin('users as u','u.id','=', 'kd.user_id')
                    ->leftjoin('divisions as d','d.id','=', 'kd.distribution_division')
                    ->where('kd.distribution_division','=',$division_id)
                    ->orderBy('kd.updated_at','desc')
                    ->get();


        return DataTables::of($recieveditems)
        ->addIndexColumn()
       ->make(true);

    // Apply filter if a selected column is provided
    if ($request->has('filter')) {
        $selectedColumn = $request->input('filter');
        $recieveditems->orderBy($selectedColumn);
    }

    // Return the filtered data
    return DataTables::of($recieveditems->get())
        ->make(true);
    }




}
