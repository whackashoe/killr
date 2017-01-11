<?php
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Preview extends Eloquent {
    use SoftDeletingTrait;

	protected $table = 'previews';
    protected $fillable = ['ip', 'code', 'slug'];
    protected $dates = ['deleted_at'];


    public static $rules = [
        'code'        => 'required|max:64000',
        'ip'          => 'required|ip',
    ];
}
