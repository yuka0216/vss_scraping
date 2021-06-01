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
        //今日から一週間の日付の配列を作成
        for ($i = 0; $i < 7; $i++){
            $day = new Carbon();
            $weeks[] = $day->modify("+$i days")->format('Y-m-d');
        }
        
        //一週間の一日ごとの全体情報を取得、検索があったらそのデータを取得、
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
    
    //東京ページ
    public function tokyo(Request $request)
    {
        date_default_timezone_set('Asia/Tokyo');
        for ($i = 0; $i < 7; $i++){
            $day = new Carbon();
            $weeks[] = $day->modify("+$i days")->format('Y-m-d');
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
    
    //横浜ページ
    public function yokohama(Request $request)
    {
        date_default_timezone_set('Asia/Tokyo');
        for ($i = 0; $i < 7; $i++){
            $day = new Carbon();
            $weeks[] = $day->modify("+$i days")->format('Y-m-d');
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
    
    //大阪ページ
    public function ohsaka(Request $request)
    {
        date_default_timezone_set('Asia/Tokyo');
        for ($i = 0; $i < 7; $i++){
            $day = new Carbon();
            $weeks[] = $day->modify("+$i days")->format('Y-m-d');
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
    
    //神戸ページ
    public function kobe(Request $request)
    {
        date_default_timezone_set('Asia/Tokyo');
        for ($i = 0; $i < 7; $i++){
            $day = new Carbon();
            $weeks[] = $day->modify("+$i days")->format('Y-m-d');
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
