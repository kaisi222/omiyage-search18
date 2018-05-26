<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Item;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        
        return view('users.index', [
            'users' => $users,
        ]);
    }
    
    
    public function show($id)
    {
        $user = User::find($id);
        $count_like = $user->like_items()->count();
        $items = \DB::table('items')->join('item_user', 'items.id', '=', 'item_user.item_id')->select('items.*')->where('item_user.user_id', $user->id)->distinct()->groupBy('items.id')->paginate(20);

        return view('users.show', [
            'user' => $user,
            'items' => $items,
            'count_like' => $count_like,
        ]);
    }
    
    
    
    // getでusers/id/editにアクセスされた場合の「更新画面表示処理」
    public function edit($id)
    {
        $user = User::find($id);

        return view('users.edit', [
            'user' => $user,
        ]);

    }

    // putまたはpatchでusers/idにアクセスされた場合の「更新処理」
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect('/home');
    }
}
