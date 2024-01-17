<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;


class Dependentcontroller extends Controller
{
    //

    public function index(){
        $country_list = DB::table('country')->get();
        return view('dependentselect',compact('country_list'));
    }

    public function selectstate(Request $request){

        $country_id = $request->post('country_id');
        // dd($country_id);
        $state = DB::table('state')->where('country',$country_id)->get();
        // dd($state);
        $html ='<option value="">Select State</option>';

        foreach ($state as $list) {
            
            $html.='<option value="' .$list->id.'">'.$list->state.'</option>';
        }
    
        echo $html;
        //  return view('dependentselect',compact(''));

    }
}
