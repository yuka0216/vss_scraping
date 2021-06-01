<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Weidner\Goutte\GoutteFacade as GoutteFacade;
use App\Vessel;
use Carbon\Carbon;

class scraping extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:scraping';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'スクレイピングを実行します';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        echo 'スクリプトを実行します。' . PHP_EOL;
        
        date_default_timezone_set('Asia/Tokyo');
        
        //各船会社のurl取得
        $goutte = GoutteFacade::request('GET', 'https://www.toyoshingo.com/');  
        $carriers = $goutte->filter('div#linklist ul li a')->each(function ($node) {
            return $node->attr('href');
        });   
        
        // $carriers = array("hasco");
        
        foreach ($carriers as $carrier) {
            $carrierUrl = "https://www.toyoshingo.com/" . $carrier;     
            
            $portUrls = array(
                "東京" => "index.php?port=13",
                "横浜" => "index.php?port=11",
                "大阪" => "index.php?port=40",
                "神戸" => "index.php?port=41");
                
                //取得元url http://www.toyoshingo.com/$carrier/$portUrl
                //各船会社の中の各港のページの各船の入港情報ページのurlをget
                foreach($portUrls as $portUrl) {
                    $eachUrl = $carrierUrl . "/" . $portUrl;        
                    $goutte = GoutteFacade::request('GET', $eachUrl);    
                    $eachUrls = $goutte->filter('.oneline div a')->each(function ($node) {
                        return $node->attr('href');
                    });
                    
                    //www.toyoshingo.com/$carrier/各船の情報ページ から全データを取得
                    foreach ($eachUrls as $eachUrl) {
                        $targetUrl = $carrierUrl . "/" . $eachUrl;       
                        $goutte = GoutteFacade::request('GET', $targetUrl);
                        $shipInfo = $goutte->filter('table tr td')->each(function($element){
                            return $element->text();
                        });
                        
                        // dd($shipInfo);
                        
                        $newShipInfo = [];
                        foreach ($shipInfo as $info) {
                            $info = mb_convert_kana($info, 's');
                            $newShipInfo[] = preg_replace("/(PM|--Skip--)/", "", $info );
                        }
                        
                        // dd($newShipInfo);
                        
                       
                       //船会社ごとにほしいデータの該当行数を定義
                        $shipInfoDefines = [
                            'maersk' => [
                                'dataDefines' => [
                                    'vessel' => 0,
                                    'eta' => 2,
                                    'etd' => 3,
                                    'yard' => 5,
                                    'voyage' => 0,
                                ]
                            ],
                            'tslines' => [
                                'dataDefines' => [
                                    'vessel' => 0,
                                    'eta' => 6,
                                    'etd' => 7,
                                    'yard' => 8,
                                    'voyage' => 2,
                                ]
                            ],
                            'cmacgm' => [
                                'dataDefines' => [
                                    'vessel' => 0,
                                    'eta' => 6,
                                    'etd' => 7,
                                    'yard' => 9,
                                    'voyage' => 1,
                                ]
                            ],
                            'oocl' => [
                                'dataDefines' => [
                                    'vessel' => 0,
                                    'eta' => 5,
                                    'etd' => 6,
                                    'yard' => 7,
                                    'voyage' => 1,
                                ]
                            ],
                            'pancon' => [
                                'dataDefines' => [
                                    'vessel' => 0,
                                    'eta' => 6,
                                    'etd' => 7,
                                    'yard' => 8,
                                    'voyage' => 2,
                                ]
                            ],
                            'msc' => [
                                'dataDefines' => [
                                    'vessel' => 1,
                                    'eta' => 6,
                                    'etd' => 9,
                                    'yard' => 10,
                                    'voyage' => 2,
                                ]
                            ],
                            'sitc' => [
                                'dataDefines' => [
                                    'vessel' => 0,
                                    'eta' => 6,
                                    'etd' => 7,
                                    'yard' => 8,
                                    'voyage' => 2,
                                ]
                            ],
                            'wanhai' => [
                                'dataDefines' => [
                                    'vessel' => 0,
                                    'eta' => 7,
                                    'etd' => 8,
                                    'yard' => 9,
                                    'voyage' => 2,
                                ]
                            ],
                            'interasia' => [
                                'dataDefines' => [
                                    'vessel' => 0,
                                    'eta' => 7,
                                    'etd' => 8,
                                    'yard' => 9,
                                    'voyage' => 2,
                                    
                                ]
                            ],'dongjin' => [
                                'dataDefines' => [
                                    'vessel' => 0,
                                    'eta' => 5,
                                    'etd' => 6,
                                    'yard' => 7,
                                    'voyage' => 1,
                                ]
                            ],
                            'kmtc' => [
                                'dataDefines' => [
                                    'vessel' => 0,
                                    'eta' => 6,
                                    'etd' => 7,
                                    'yard' => 8,
                                    'voyage' => 2,
                                ]
                            ],
                            'evergreen' => [
                                'dataDefines' => [
                                    'vessel' => 0,
                                    'eta' => 7,
                                    'etd' => 8,
                                    'yard' => 9,
                                    'voyage' => 2,
                                ]
                            ],
                            'one' => [
                                'dataDefines' => [
                                    'vessel' => 0,
                                    'eta' => 7,
                                    'etd' => 8,
                                    'yard' => 9,
                                    'voyage' => 2,
                                ]
                            ],
                            'namsung' => [
                                'dataDefines' => [
                                    'vessel' => 0,
                                    'eta' => 6,
                                    'etd' => 7,
                                    'yard' => 8,
                                    'voyage' => 2,
                                ]
                            ],
                            'tclc' => [
                                'dataDefines' => [
                                    'vessel' => 0,
                                    'eta' => 6,
                                    'etd' => 7,
                                    'yard' => 8,
                                    'voyage' => 2,
                                ]
                            ],
                            'ckline' => [
                                'dataDefines' => [
                                    'vessel' => 0,
                                    'eta' => 6,
                                    'etd' => 7,
                                    'yard' => 8,
                                    'voyage' => 2,
                                ]
                            ],
                            'starocean' => [
                                'dataDefines' => [
                                    'vessel' => 0,
                                    'eta' => 6,
                                    'etd' => 7,
                                    'yard' => 8,
                                    'voyage' => 2,
                                ]
                            ],
                            'hasco' => [
                                'dataDefines' => [
                                    'vessel' => 0,
                                    'eta' => 6,
                                    'etd' => 7,
                                    'yard' => 8,
                                    'voyage' => 2,
                                ]
                            ],
                            'sinokor' => [
                                'dataDefines' => [
                                    'vessel' => 0,
                                    'eta' => 6,
                                    'etd' => 7,
                                    'yard' => 8,
                                    'voyage' => 2,
                                ]
                            ],
                            'heunga' => [
                                'dataDefines' => [
                                    'vessel' => 0,
                                    'eta' => 6,
                                    'etd' => 7,
                                    'yard' => 8,
                                    'voyage' => 2,
                                ]
                            ],
                            'yangming' => [
                                'dataDefines' => [
                                    'vessel' => 0,
                                    'eta' => 7,
                                    'etd' => 8,
                                    'yard' => 9,
                                    'voyage' => 2,
                                ]
                            ],
                        ];
                        
                            $key = $carrier;
                            $infos = $shipInfoDefines[$key];
                            $dataDefines = $infos['dataDefines'];
                            
                            $vessel = [
                                'vessel' => '',
                                'eta' => '',
                                'etd' => '',
                                'yard' => '',
                                'voyage' => '',
                            ];
                            
                            
                            // 船会社ごとに定義した内容に従って必要なデータだけを格納
                            $vessel = new Vessel();
                            foreach ($dataDefines as $key => $value) {
                                $vessel[$key] = $newShipInfo[$value];
                            }
                            $portName = array_keys($portUrls, $portUrl);
                            $vessel->port = $portName[0];


                            //入船日、時間をdatetime型に加工
                            if (mb_strlen($vessel["eta"]) == 6) {
                                $vessel["eta"] = $vessel["eta"] . " 00:00:00";
                            } elseif (mb_strlen($vessel["eta"]) == 16) {
                                $vessel["eta"] = $vessel["eta"] = $vessel["eta"] . ":00";
                            } else {
                                $vessel["eta"] = null;
                            }
                            
                            $vessel["eta"] = new Carbon($vessel["eta"]);
                            $vessel["eta"]->format('Y-m-d H:i:s');
                            
                            
                            //船名の確認
                            $vesselName = $vessel["vessel"];
                            $etaTime = $vessel["eta"];
                            $seach = "(";
                            
                            if (strpos($vesselName, $seach) !== false) {            //$vesselNameの中に"("があるか確認
                                $vesselName = mb_substr($vesselName, 0, (mb_strpos($vesselName,'('))-2);      //あれば"("の2文字前までの文字だけを$vesselNameに入れなおす
                            }
                            
                            //すでにほかのページで取得済みの船出ないか確認
                            $vssQuery = Vessel::where('port', $portName[0])->where('eta', 'like', "%" . $etaTime . "%")->where('vessel', 'like', "%" . $vesselName . "%")->count();
                            if($vssQuery == 0) $vessel->save();
                    }      
                }
            }
            
        echo 'スクリプトを終了します。' . PHP_EOL;
    }
}
