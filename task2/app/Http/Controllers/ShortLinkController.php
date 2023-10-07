<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShortLink;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ShortLinkController extends Controller
{
    public function index()
    {
        $shortLinks = ShortLink::latest()->get();

        return view('shortenLink', compact('shortLinks'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'link' => 'required|url'
        ]);

        $short_link = new ShortLink();
        $short_link->link = $request->link;
        // $short_link->code = Str::random(6);
        
        while(1){
            $short_link->code = Str::random(6);

            $check_code_exist = DB::table('short_links')->where('code', '=', $short_link->code)->get();

            if(count($check_code_exist) == 0){
                break;
            }
        }

        $short_link->user_id = Auth::id();

        $short_link->updated_by_id = Auth::id();

        if($short_link->save()){
            return redirect('/')
                ->with('success', 'Shorten Link Generated Successfully!');
        }else{
            return redirect('/')
                ->with('error', 'Shorten Link Generation Failed!');
        }
        
    }


    public function shortenLink($code)
    {
        $find = ShortLink::where('code', $code)->first();

        $find->click_count = (int)$find->click_count + 1;

        $find->update();

        return redirect($find->link);
    }
}
