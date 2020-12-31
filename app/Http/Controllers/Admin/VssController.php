<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Vessel;
use Carbon\Carbon;


class VssController extends Controller
{
        
        
    public function index(Request $request)
    {
        date_default_timezone_set('Asia/Tokyo');
        for ($i = 0; $i < 7; $i++){
            $day = new Carbon();
            $weeks[] = $day->modify("+$i days")->format('Y/m/d');
        }
        
        $cond_title = $request->cond_title;
        foreach ($weeks as $day) {
            $vesselQuery = Vessel::where('eta', 'like', $day . "%");
            if ($cond_title != '') {
                $vesselQuery->where('vessel', 'like', "%" . $cond_title . "%");
            }
            $vessels[] = $vesselQuery->orderBy('eta', 'asc')->get();
        }
        
        // dd($vessels);
        return view('admin.vessel.index',[
            'vessels' => $vessels,
            'cond_title' => $cond_title,
            'weeks' => $weeks,
        ]);
    }
    
    public function tokyo(Request $request)
    {
        date_default_timezone_set('Asia/Tokyo');
        for ($i = 0; $i < 7; $i++){
            $day = new Carbon();
            $weeks[] = $day->modify("+$i days")->format('Y/m/d');
        }
        
        $cond_title = $request->cond_title;
        foreach ($weeks as $day) {
            $vesselQuery = Vessel::where('port', '東京')->where('eta', 'like', $day . "%");
            if ($cond_title != '') {
                $vesselQuery->where('vessel', 'like', "%" . $cond_title . "%");
            }
            $vessels[] = $vesselQuery->orderBy('eta', 'asc')->get();
        }
        
        return view('admin.vessel.tokyo',[
            'vessels' => $vessels,
            'weeks' => $weeks,
            'cond_title' => $cond_title,
        ]);
    }
    
    public function yokohama(Request $request)
    {
        date_default_timezone_set('Asia/Tokyo');
        for ($i = 0; $i < 7; $i++){
            $day = new Carbon();
            $weeks[] = $day->modify("+$i days")->format('Y/m/d');
        }
        
        $cond_title = $request->cond_title;
        foreach ($weeks as $day) {
            $vesselQuery = Vessel::where('port', '横浜')->where('eta', 'like', $day . "%");
            if ($cond_title != '') {
                $vesselQuery->where('vessel', 'like', "%" . $cond_title . "%");
            }
            $vessels[] = $vesselQuery->orderBy('eta', 'asc')->get();
        }
        
        return view('admin.vessel.yokohama',[
            'vessels' => $vessels,
            'weeks' => $weeks,
            'cond_title' => $cond_title,
        ]);
    }
    
    public function ohsaka(Request $request)
    {
        date_default_timezone_set('Asia/Tokyo');
        for ($i = 0; $i < 7; $i++){
            $day = new Carbon();
            $weeks[] = $day->modify("+$i days")->format('Y/m/d');
        }
        
        $cond_title = $request->cond_title;
        foreach ($weeks as $day) {
            $vesselQuery = Vessel::where('port', '大阪')->where('eta', 'like', $day . "%");
            if ($cond_title != '') {
                $vesselQuery->where('vessel', 'like', "%" . $cond_title . "%");
            }
            $vessels[] = $vesselQuery->orderBy('eta', 'asc')->get();
        }
        
        return view('admin.vessel.ohsaka',[
            'vessels' => $vessels,
            'weeks' => $weeks,
            'cond_title' => $cond_title,
        ]);
    }
    
    public function kobe(Request $request)
    {
        date_default_timezone_set('Asia/Tokyo');
        for ($i = 0; $i < 7; $i++){
            $day = new Carbon();
            $weeks[] = $day->modify("+$i days")->format('Y/m/d');
        }
        
        $cond_title = $request->cond_title;
        foreach ($weeks as $day) {
            $vesselQuery = Vessel::where('port', '神戸')->where('eta', 'like', $day . "%");
            if ($cond_title != '') {
                $vesselQuery->where('vessel', 'like', "%" . $cond_title . "%");
            }
            $vessels[] = $vesselQuery->orderBy('eta', 'asc')->get();
        }
        
        return view('admin.vessel.kobe',[
            'vessels' => $vessels,
            'weeks' => $weeks,
            'cond_title' => $cond_title,
        ]);
    }
}
