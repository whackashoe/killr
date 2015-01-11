<?php
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Paste extends Eloquent {
    use SoftDeletingTrait;

	protected $table = 'pastes';
    protected $fillable = ['ip', 'code', 'slug', 'parent_id', 'views'];
    protected $dates = ['deleted_at'];


    public static $rules = [
        'code'        => 'required|max:64000',
        'ip'          => 'required|ip',
        'parent_slug' => 'size:5'
    ];

    public function parent()
    {
        return $this->belongsTo('Paste', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('Paste', 'parent_id');
    }

    public function mods(){
        return $this->hasMany('Paste', 'parent_id');
    }

    public function getModsCountAttribute()
    {
        return count($this->mods);
    }
}
