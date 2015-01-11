<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;

class PasteController extends BaseController {
    protected $paste;

    public function __construct(Paste $paste)
    {
        $this->paste = $paste;
    }
    
	public function get($slug)
    {
        try {
            $paste = $this->paste->where('slug', '=', $slug)->firstOrFail();
        } catch(ModelNotFoundException $e) {
            App::abort(404);
        }

        $ip = Request::getClientIp();
        if(strcmp($paste->ip, $ip) != 0) {
            $paste->increment('views');
            $paste->save();
        }

		return View::make('editor', ['paste' => $paste]);
	}

    public function mods($slug)
    {
        try {
            $paste = $this->paste->with('children')->where('slug', '=', $slug)->firstOrFail();
        } catch(ModelNotFoundException $e) {
            App::abort(404);
        }

        return View::make('mods', ['paste' => $paste]);
    }

	public function create()
    {
        $cmdline = false;
        if(Input::has('code')) {
            $input = Input::only('code', 'parent_id');
        } else {
            $input = [];
            $req = Request::instance();
            $input['code'] = $req->getContent();
            $cmdline = !empty($req);
        }
        $input = array_merge($input, ['ip' => Request::getClientIp()]);

        $validator = Validator::make($input, Paste::$rules);
        if($validator->fails()) {
            return Response::json((object) ['success' => false, 'errors' => $validator->messages()]);
        }

        do {
            $slug = strtolower(str_random(5));
        } while(Paste::find($slug) != null);

        $paste = new Paste;
        $paste->ip = $input['ip'];
        $paste->code = $input['code'];
        $paste->slug = $slug;
        $parent_id = Input::get('parent_id', null);
        if($parent_id != null && $parent_id != 0) {
            $paste->parent_id = $parent_id;
        }
        $paste->save();

        if($cmdline) {
            return url($paste->slug) . "\n";
        }
        return Response::json((object) ['success' => true, 'slug' => $paste->slug]);
	}

    public function delete($slug)
    {
        try {
            $paste = $this->paste->where('slug', '=', $slug)->firstOrFail();
        } catch(ModelNotFoundException $e) {
            return Response::json(['success' => false, 'errors' => ['404' => 'model not found']]);
        }

        $ip = Request::getClientIp();

        if(strcmp($paste->ip, $ip) != 0) {
            return Response::json(['success' => false, 'errors' => ['not creator' => 'you have different ip than creator']]);
        }

        $paste->delete();
        return Response::json(['success' => true]);
    }
}
