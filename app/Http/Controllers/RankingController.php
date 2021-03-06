<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Item;

class RankingController extends Controller
{
    public function like()
    {
        $items = \DB::table('item_user')->join('items', 'item_user.item_id', '=', 'items.id')->select('items.*', \DB::raw('COUNT(*) as count'))->where('type', 'like')->groupBy('items.id')->orderBy('count', 'DESC')->take(10)->get();

        return view('ranking.like', [
            'items' => $items,
        ]);
    }
}