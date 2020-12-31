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
        
        $goutte = GoutteFacade::request('GET', 'https://www.toyoshingo.com/');
        $carriers = $goutte->filter('div#linklist ul li a')->each(function ($node) {
            return $node->attr('href');
        });   //各船会社のurl取得
        
        // $carriers = array("oocl");

        foreach ($carriers as $carrier) {
            $carrierUrl = "https://www.toyoshingo.com/" . $carrier;
            $goutte = GoutteFacade::request('GET', $carrierUrl);
            
            // $portUrls = $goutte->filter('div#subcontents a')->each(function ($node) {
            //     if (preg_match("/port=/",$node->attr('href'))) {
            //     return $node->attr('href');
            //     }
            // });      //各船会社ページの各港のurl取得
        
            $portUrls = array(
                "東京" => "index.php?port=13",
                "横浜" => "index.php?port=11",
                "大阪" => "index.php?port=40",
                "神戸" => "index.php?port=41");
                                  
            // $newPortUrls = array_filter($portUrls);        //nullの要素を削除
            // array_push($newPortUrls," ");                   //最後に空欄を追加
            
                foreach($portUrls as $portUrl) {
                    $eachUrl = $carrierUrl . "/" . $portUrl;
                    $goutte = GoutteFacade::request('GET', $eachUrl);
                    $eachUrls = $goutte->filter('.oneline div a')->each(function ($node) {
                        return $node->attr('href');
                    });
                    
                    
                    foreach ($eachUrls as $eachUrl) {
                        $targetUrl = $carrierUrl . "/" . $eachUrl;
                        $goutte = GoutteFacade::request('GET', $targetUrl);
                        $shipInfo = $goutte->filter('table tr td')->each(function($element){
                            return $element->text();
                        });
                        // dd($shipInfo);
                        
                       
                        
                    
                        $shipInfoDefines = [
                            'maersk' => [
                                'dataDefines' => [
                                    'vessel' => 0,
                                    'eta' => 1,
                                ]
                            ],
                            'tslines' => [
                                'dataDefines' => [
                                    'vessel' => 0,
                                    'eta' => 5,
                                ]
                            ],
                            'cmacgm' => [
                                'dataDefines' => [
                                    'vessel' => 0,
                                    'eta' => 5,
                                ]
                            ],
                            'oocl' => [
                                'dataDefines' => [
                                    'vessel' => 0,
                                    'eta' => 5,
                                ]
                            ],
                            'pancon' => [
                                'dataDefines' => [
                                    'vessel' => 0,
                                    'eta' => 5,
                                ]
                            ],
                            'msc' => [
                                'dataDefines' => [
                                    'vessel' => 1,
                                    'eta' => 7,
                                ]
                            ],
                            'sitc' => [
                                'dataDefines' => [
                                    'vessel' => 0,
                                    'eta' => 5,
                                ]
                            ],
                            'wanhai' => [
                                'dataDefines' => [
                                    'vessel' => 0,
                                    'eta' => 6,
                                ]
                            ],
                            'interasia' => [
                                'dataDefines' => [
                                    'vessel' => 0,
                                    'eta' => 6,
                                ]
                            ],'dongjin' => [
                                'dataDefines' => [
                                    'vessel' => 0,
                                    'eta' => 4,
                                ]
                            ],
                            'kmtc' => [
                                'dataDefines' => [
                                    'vessel' => 0,
                                    'eta' => 5,
                                ]
                            ],
                            'evergreen' => [
                                'dataDefines' => [
                                    'vessel' => 0,
                                    'eta' => 6,
                                ]
                            ],
                            'one' => [
                                'dataDefines' => [
                                    'vessel' => 0,
                                    'eta' => 6,
                                ]
                            ],
                            'namsung' => [
                                'dataDefines' => [
                                    'vessel' => 0,
                                    'eta' => 6,
                                ]
                            ],
                            'tclc' => [
                                'dataDefines' => [
                                    'vessel' => 0,
                                    'eta' => 5,
                                ]
                            ],
                            'ckline' => [
                                'dataDefines' => [
                                    'vessel' => 0,
                                    'eta' => 5,
                                ]
                            ],
                            'starocean' => [
                                'dataDefines' => [
                                    'vessel' => 0,
                                    'eta' => 5,
                                ]
                            ],
                            'hasco' => [
                                'dataDefines' => [
                                    'vessel' => 0,
                                    'eta' => 5,
                                ]
                            ],
                            'sinokor' => [
                                'dataDefines' => [
                                    'vessel' => 0,
                                    'eta' => 5,
                                ]
                            ],
                            'heunga' => [
                                'dataDefines' => [
                                    'vessel' => 0,
                                    'eta' => 5,
                                ]
                            ],
                            'yangming' => [
                                'dataDefines' => [
                                    'vessel' => 0,
                                    'eta' => 6,
                                ]
                            ],
                        ];
                        
                            $key = $carrier;
                            $infos = $shipInfoDefines[$key];
                            $dataDefines = $infos['dataDefines'];
                            
                            $vessel = [
                                'vessel' => '',
                                'eta' => '',
                            ];
                            
                            $vessel = new Vessel();
                            foreach ($dataDefines as $key => $value) {
                                $vessel[$key] = $shipInfo[$value];
                            }
                            $portName = array_keys($portUrls, $portUrl);
                            $vessel->port = $portName[0];
                            $vessel->save();
                            
                    }      
                    
                }
            }
            
            
            
            
            
        echo 'スクリプトを終了します。' . PHP_EOL;
    
    
    }
}
