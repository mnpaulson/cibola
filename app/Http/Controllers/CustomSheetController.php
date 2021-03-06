<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CustomSheet;
use App\Estimate;
use App\EstValue;
use Storage;
use DB;
use Carbon\Carbon;
use stdClass;
use DateTime;

class CustomSheetController extends Controller
{

    public function index()
    {
        $customSheet = CustomSheet::all();
        return response()->json($customSheet);
    }

    // public function recentCustomSheetsList()
    // {
    //     $customSheet = \App\CustomSheet::with('CustomSheet_images')
    //         ->with('customer')
    //         ->orderBy('updated_at', 'desc')
    //         ->take(13)
    //         ->get();    

   

    //     return response()->json($customSheet);
    // }

    public function create(Request $request) 
    {
        $customSheet = new CustomSheet;

        if ($request->customer_id == 0) {
            trigger_error("Customer cannot be blank");
        }

        $customSheet->customer_id = $request->customer_id;
        $customSheet->name = $request->name;
        $customSheet->note = $request->note;

        $customSheet->save();

        $est_vals = array();
        foreach ($request->estimates as $key => $estimate)
        {
            $est_vals = array();
            foreach($estimate['estValues'] as $k => $val)
            {
                $v = new EstValue([
                    'type' => $val['type'],
                    'name' => $val['name'],
                    'amt' => $val['amt'],
                    'pricePer' => $val['pricePer'],
                    'priceType' => $val['priceType']
                ]);
                array_push($est_vals, $v);
            }


            $e = new Estimate([
                'name' => $estimate['name'],
                'note' => $estimate['note'],
                'isPrimary' => $estimate['isPrimary']
            ]);
            
            $customSheet->estimates()->save($e);
            $e->EstValues()->saveMany($est_vals);
        }

        $customSheet->estimatesWithValues;
        return response()->json($customSheet);
    }

    public function update(Request $request) 
    {
        $customSheet = new CustomSheet;

        //check customer id
        if ($request->customer_id == 0) {
            trigger_error("Customer cannot be blank");
        }

        //update custom sheet
        if (isset($request->customSheet_id) && $request->customSheet_id !== 0)
        {
            $customSheet = CustomSheet::where('id', $request->customSheet_id)->first();
            $customSheet->name = $request->name;
            $customSheet->note = $request->note;
            $customSheet->save();
        } 
        else
        {
            return "No Custom sheet found to update";
        }

        foreach ($request->estimatesToDelete as $delEst)
        {
            $e = Estimate::where('id', $delEst)->first()->delete();
            $v = EstValue::where('estimate_id', $delEst)->delete();

        }

        $newEstimates = array();

        foreach ($request->estimates as $key => $estimate)
        {
            $newEstVals = array();
            //Update Estimates
            if (isset($estimate['id']))
            {

                $estimateToUpdate = estimate::where('id', $estimate['id'])->first();

                $estimateToUpdate->name = $estimate['name'];
                $estimateToUpdate->note = $estimate['note'];
                $estimateToUpdate->isPrimary = $estimate['isPrimary'];
                
                foreach ($estimate['estValuesToDelete'] as $es)
                {
                    $v = EstValue::where('id', $es)->delete();
                }

                //Est values loop
                foreach ($estimate['estValues'] as $k => $val)
                {
                    //Update est values
                    if (isset($val['id']))
                    {


                        DB::table('est_values')
                        ->where('id', $val['id'])
                        ->update([
                            'name' => $val['name'],
                            'priceType' => $val['priceType'],
                            'type'=> $val['type'],
                            'pricePer' => $val['pricePer'],
                            'amt' => $val['amt']
                        ]);


                    }
                    //new Est values
                    else 
                    {
                        $v = new EstValue([
                            'type' => $val['type'],
                            'name' => $val['name'],
                            'amt' => $val['amt'],
                            'pricePer' => $val['pricePer'],
                            'priceType' => $val['priceType']
                        ]);

                        array_push($newEstVals, $v);
                    }

                }
                $estimateToUpdate->EstValues()->saveMany($newEstVals);
                $estimateToUpdate->save();
            }
            //New Estimate
            else
            {
                $newEstVals = array();

                $e = new Estimate([
                    'name' => $estimate['name'],
                    'note' => $estimate['note'],
                    'isPrimary' => $estimate['isPrimary']
                ]);

                foreach($estimate['estValues'] as $k => $val)
                {
                    $v = new EstValue([
                        'type' => $val['type'],
                        'name' => $val['name'],
                        'amt' => $val['amt'],
                        'pricePer' => $val['pricePer'],
                        'priceType' => $val['priceType']
                    ]);
                    array_push($newEstVals, $v);
                }

                array_push($newEstimates, $newEstVals);

                $customSheet->estimates()->save($e);
                $e->EstValues()->saveMany($newEstVals);
            }
        }


        $customSheet->estimatesWithValues;
        return response()->json($customSheet);
    }

    public function delete(Request $request) 
    {
        $customSheet = CustomSheet::where('id', $request->customSheet_id)->first();

        $estimates = Estimate::where('custom_sheet_id', $customSheet->id)->get();

        foreach($estimates as $e => $val) 
        {
            EstValue::where('estimate_id', $val->id)->delete();
            $val->delete();
        }

        // $estimates->delete();

        $customSheet->delete();        
    }

    public function show(Request $request)
    {
        $customSheet = \App\CustomSheet::where('id', $request->id)->first();
        // $customSheet->estimates;
        $customSheet->estimatesWithValues;        
        return response()->json($customSheet);
    }

    public function customerCustomSheets(Request $request)
    {
        $customSheets = \App\CustomSheet::where('customer_id', $request->id)->get();
        return response()->json($customSheets);
    }

    public function allCustomSheetDetails(Request $request)
    {
        $order = "";
        if ($request->descending) $desc = 'desc';
        else $desc = 'asc';
        $customSheet = \App\CustomSheet::with('customer')
        ->orderBy($request->sortBy, $desc)        
        ->paginate($request->rowsPerPage);   
        // $customSheet->estimatesWithValues;

        return response()->json($customSheet);  
    }

}
