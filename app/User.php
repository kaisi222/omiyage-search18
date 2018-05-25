<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    
    
    public function followings()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'user_id', 'follow_id')->withTimestamps();
    }
    
    public function followers()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'follow_id', 'user_id')->withTimestamps();
    }
    
    
    public function follow($userId)
    {
    // 既にフォローしているかの確認 
    $exist = $this->is_following($userId);
    // 自分自身ではないかの確認 
    $its_me = $this->id == $userId;

    if ($exist || $its_me) {

        // 既にフォローしていれば何もしない

        return false;

        } else {

        // 未フォローであればフォローする

        $this->followings()->attach($userId);

        return true;

        }
    }

    public function unfollow($userId)
    {
    // 既にフォローしているかの確認
    $exist = $this->is_following($userId);
    // 自分自身ではないかの確認
    $its_me = $this->id == $userId;

    if ($exist && !$its_me) {
        // 既にフォローしていればフォローを外す
        $this->followings()->detach($userId);
        return true;
        } else {
        // 未フォローであれば何もしない
        return false;
        }
    }

    public function is_following($userId) {
        return $this->followings()->where('follow_id', $userId)->exists();
    }
    
    
    
    
    
    public function items()
    {
        return $this->belongsToMany(Item::class)->withPivot('type')->withTimestamps();
    }

    public function like_items()
    {
        return $this->items()->where('type', 'like');
    }

    public function like($itemId)
    {
        // 既に Like しているかの確認
        $exist = $this->is_liking($itemId);

        if ($exist) {
            // 既に Like していれば何もしない
            return false;
        } else {
            // 未 Like であれば Like する
            $this->items()->attach($itemId, ['type' => 'like']);
            return true;
        }
    }

    public function dont_like($itemId)
    {
        // 既に Like しているかの確認
        $exist = $this->is_liking($itemId);

        if ($exist) {
            // 既に Like していれば Like を外す
            \DB::delete("DELETE FROM item_user WHERE user_id = ? AND item_id = ? AND type = 'like'", [\Auth::user()->id, $itemId]);
        } else {
            // 未 Like であれば何もしない
            return false;
        }
    }

    public function is_liking($itemIdOrCode)
    {
        if (is_numeric($itemIdOrCode)) {
            $item_id_exists = $this->like_items()->where('item_id', $itemIdOrCode)->exists();
            return $item_id_exists;
        } else {
            $item_code_exists = $this->like_items()->where('code', $itemIdOrCode)->exists();
            return $item_code_exists;
        }
    }
}
