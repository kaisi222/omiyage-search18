<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GiftsController extends Controller
{

    public function create()
    {
        $keyword = request()->keyword;
        $gifts = [];
        if ($keyword) {
            $client = new \RakutenRws_Client();
            $client->setApplicationId(env('RAKUTEN_APPLICATION_ID'));

            $rws_response = $client->execute('IchibaItemSearch', [
                'keyword' => $keyword,
                'imageFlag' => 1,
                'hits' => 20,
            ]);

            // 扱い易いように Gift としてインスタンスを作成する（保存はしない）
            foreach ($rws_response->getData()['Gifts'] as $rws_gift) {
                $gift = new \App\Gift();
                $gift->code = $rws_gift['Item']['itemCode'];
                $gift->name = $rws_gift['Item']['itemName'];
                $gift->url = $rws_gift['Item']['itemUrl'];
                $gift->image_url = str_replace('?_ex=128x128', '', $rws_gift['Item']['mediumImageUrls'][0]['imageUrl']);
                $gifts[] = $gift;
            }
        }

        return view('gifts.create', [
            'keyword' => $keyword,
            'gifts' => $gifts,
        ]);
    }
    
}