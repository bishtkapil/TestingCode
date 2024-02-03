<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use DB;
use Yajra\DataTables\Facades\DataTables;
use App\Models\delete;
use PDF;
use App\Country;
use App\State;
use App\Zone;
use App\Division;
use App\Post;
use App\City;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

     public function relation()
     {
        $country = Country::with('state')->with('city')->get()->toArray();
        // $state = $country['state'];
        // dd($country);
        //    dd($state[0]['state']);
        // $country = Country::with('state')->get()->toArray();
        // $zoneData = Zone::with('division.post')->find(3)->toArray();
        $zoneData = Zone::with('division')->with('posts')->find(3)->toArray();
        return view('relationsselect',compact('country'));
    //    dd($country);
     }


    public function index()
    {     $data  =  DB::table('testing')->get();
        return view('home',compact('data'));
    }

    function form(){
        $data  =  DB::table('testing')->get();
        $country = DB::table('country')->get();
        return view('testingform',compact('data','country'));
    }

    public function display(){
        $data  =  DB::table('testing as t')
                        ->select('t.*','c.country','c.id as country_id')
                        ->leftjoin('country as c','c.id','=','t.country')
                        ->get();
        return response()->json($data);

    }

    public function show(){

        $country = DB::table('country')->get();
        return view('display',compact('country'));

    }
    function formstore(Request $request){

        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'course' => 'required',
            'phone' => 'required',
            'country' => 'required'
        ]);
       DB::table('testing')->insert([
            'name' => $request->input('name'),
            'course' => $request->input('course'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'country' => $request->input('country'),
       ]);

       return redirect('testingform')->with('success', 'Successfully inserted.');
    }

    function edit(Request $request){
        // dd(Auth::user());
        $edit_id = $request->route('id');
        $data = DB::table('testing')->where('id',$edit_id)->get();
        return view('edit',compact('data'));
    }


    function update(Request $request ,$id){

        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'course' => 'required',
            'phone' => 'required',
        ]);
       DB::table('testing')
            ->where('id',$id)
            ->update([
            'name' => $request->input('name'),
            'course' => $request->input('course'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),

       ]);

       return redirect('home')->with('success', 'Successfully Updated.');
    }

    function delete(Request $request ,$id){


       DB::table('testing')
            ->where('id',$id)
            ->delete();

       return redirect('show')->with('success', 'Successfully Deleted.');
    }


    function ajaxdisplay(Request $request){

        $country = DB::table('country')->get();

        // $data = DB::table('testing as t')
        // ->select('t.*','c.country','c.id as country_id')
        // ->leftjoin('country as c','c.id','=','t.country')
        // ->get();
        // dd($data);
        return view('ajaxdisplay',compact('country'));
     }


     public function getData(Request $request)
     {

        // ->addIndexColumn()
             $data = DB::table('testing as t')
             ->select('t.*','c.country','c.id as country_id')
             ->leftjoin('country as c','c.id','=','t.country')
             ->get();


               // Filter by category
               if ($request->has('category')) {
              $data->where('country', $request->input('category'));


            }

             return DataTables::of($data)
                 ->addIndexColumn()
                 ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0);" data-id="'.$row->id.'" class="edit btn btn-primary btn-sm">Edit</a>';
                    $btn .= '<a href="javascript:void(0);" data-id="'.$row->id.'" class="delete btn btn-danger btn-sm">Delete</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);

         return response()->json(['message' => 'Invalid request'], 400);
     }

     public function remove(Request $request){

        $res = delete::where('id',$request->id)->delete();
        if($res){
            $output['status'] = true;
            return json_encode($output);
        }

    }


    public function downloadPdf()
    {
        $data = DB::table('testing as t')
        ->select('t.*','c.country','c.id as country_id')
        ->leftjoin('country as c','c.id','=','t.country')
        ->get();

        $pdf = PDF::loadView('pdf', compact('data'));

        return $pdf->download('table.pdf');
    }



    public function getfilterData(Request $request)
    {

                // $x = $request->input('yourVariable');
                // $r = $request->input('country');

         // country input filter
        if(!empty($request->input('yourVariable'))){
                $data = DB::table('testing as t')
                ->select('t.*','c.country','c.id as country_id')
                ->leftjoin('country as c','c.id','=','t.country')
                ->where('c.country', $request->input('yourVariable'))
                ->get();


        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '<a href="javascript:void(0);" data-id="'.$row->id.'" class="edit btn btn-primary btn-sm">Edit</a>';
                $btn .= '<a href="javascript:void(0);" data-id="'.$row->id.'" class="delete btn btn-danger btn-sm">Delete</a>';

                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }

        //email input field filter

        if(!empty($request->input('filteremail'))){
            $data = DB::table('testing as t')
            ->select('t.*','c.country','c.id as country_id')
            ->leftjoin('country as c','c.id','=','t.country')
            ->where('t.email', $request->input('filteremail'))
            ->get();


    return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($row){
            $btn = '<a href="javascript:void(0);" data-id="'.$row->id.'" class="edit btn btn-primary btn-sm">Edit</a>';
            $btn .= '<a href="javascript:void(0);" data-id="'.$row->id.'" class="delete btn btn-danger btn-sm">Delete</a>';

            return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    //name input field filter

            if(!empty($request->input('filtername'))){
                $data = DB::table('testing as t')
                ->select('t.*','c.country','c.id as country_id')
                ->leftjoin('country as c','c.id','=','t.country')
                ->where('t.name', $request->input('filtername'))
                ->get();


        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '<a href="javascript:void(0);" data-id="'.$row->id.'" class="edit btn btn-primary btn-sm">Edit</a>';
                $btn .= '<a href="javascript:void(0);" data-id="'.$row->id.'" class="delete btn btn-danger btn-sm">Delete</a>';

                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }

        if(empty($request->input('yourVariable') && $request->input('filteremail') )){
            $data = DB::table('testing as t')
            ->select('t.*','c.country','c.id as country_id')
            ->leftjoin('country as c','c.id','=','t.country')
            ->get();


        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($row){
            $btn = '<a href="javascript:void(0);" data-id="'.$row->id.'" class="edit btn btn-primary btn-sm">Edit</a>';
            $btn .= '<a href="javascript:void(0);" data-id="'.$row->id.'" class="delete btn btn-danger btn-sm">Delete</a>';

            return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
        }

    }


    public function multiple(Request $request){

        $country = DB::table('country')->get();
        return view('multiform',compact('country'));

    }

    public function multiplestore(Request $request)
    {

        // Validate the form data
        $validatedData = $request->validate([
            'name.*' => 'required',
            'course.*' => 'required',
            'email.*' => 'required|email',
            'country.*' => 'required',
            'phone.*' => 'required',
        ]);

        // Extract form data
        $name = $validatedData['name'];
        $course = $validatedData['course'];
        $email = $validatedData['email'];
        $country = $validatedData['country'];
        $phone = $validatedData['phone'];

        // Combine the data into an array of associative arrays
        $formData = [];
        $count = count($name);

        for ($i = 0; $i < $count; $i++) {
            $formData[] = [
                'name' => $name[$i],
                'course' => $course[$i],
                'email' => $email[$i],
                'country' => $country[$i],
                'phone' => $phone[$i],
            ];
        }

        // Insert the data into the 'form_data' table
        DB::table('testing')->insert($formData);
    }


}
