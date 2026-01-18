<?php

namespace App\Http\Controllers;

use App\Models\OrderData;
use App\Models\OrderTracking;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


class OrderTrackingController extends Controller
{

    public function create(){
        
        return view('create_order_tracking');
    }

    public function index(){
        $order_tracking = OrderTracking::orderBy('order_date', 'desc')->get();

        $pageKey = 'order_tracking_list';

        DB::table('page_visits')->updateOrInsert(
            ['page' => $pageKey],
            ['visits' => DB::raw('visits + 1')]
        );

        $visitCount = DB::table('page_visits')
            ->where('page', $pageKey)
            ->value('visits');

        return view('order_tracking', compact('order_tracking', 'visitCount'));
    }

    public function store(Request $request){

        $data = $request->except('link');
        
        if ($request->hasFile('link')) {
            $file = $request->file('link');

            // filename: timestamp_originalname.pdf
            $fileName = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.pdf';

            // move to public/pdfs
            $file->move(public_path('pdfs'), $fileName);

            // save full public path
            $data['link'] = 'pdfs/' . $fileName;
        }

        OrderTracking::create($data);
        
        return redirect()->back()->with('success', 'Order tracking record created successfully.');
    }

    public function orderDataIndex(){
        return view('order_data');
    }

    public function orderDataStore(Request $request){
        // dd($request->all());
        $request->validate([
            'order_number' => [
                'required',
                'string',
                'max:255',
                Rule::unique('order_data')->where(function ($query) use ($request) {
                    return $query->where('order_date', $request->order_date);
                })
            ],
            'order_date' => 'nullable|date',
        ]);
        
        OrderData::create([
            'order_type'  => $request->order_type,
            'subject'     => $request->subject,
            'order_number'=> $request->order_number,
            'order_date'  => $request->order_date,
            'link'        => $request->link,
        ]);

        return redirect()->back()->with('success', 'Order data record created successfully.');
    }

    public function orderRecords(){
        $records = OrderData::latest()->get();
        return view('order_records', compact('records'));
    }
    
}
