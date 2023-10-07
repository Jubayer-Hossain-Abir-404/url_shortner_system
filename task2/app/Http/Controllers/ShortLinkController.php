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
        $shortLinks = ShortLink::latest()->where('user_id', Auth::id())->get(); // user wise shortlink display

        return view('shortenLink', compact('shortLinks'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'link' => 'required|url' // link has to be url
        ]);

        $short_link = new ShortLink();
        $short_link->link = $request->link;

        $short_link->link_name = !empty($request->link_name) ? $request->link_name : null; // if no link name is sent then set to null

        // to fetch out unique short link code and never be duplicate
        while(1){
            $short_link->code = Str::random(6); 

            $check_code_exist = DB::table('short_links')->where('code', '=', $short_link->code)->get();

            if(count($check_code_exist) == 0){
                break;
            }
        }

        $short_link->user_id = Auth::id(); // save user id

        $short_link->updated_by_id = Auth::id();

        if($short_link->save()){
            return redirect('/')
                ->with('success', 'Shorten Link Generated Successfully!');
        }else{
            return redirect('/')
                ->with('error', 'Shorten Link Generation Failed!');
        }
        
    }

    public function edit(ShortLink $shortLink)
    {
        $shortLinks = ShortLink::latest()->where('user_id', Auth::id())->get();
        return view('shortenLink', compact('shortLink', 'shortLinks'));
    }

    public function update(Request $request, ShortLink $short_link)
    {
        $request->validate([
            'link' => 'required|url'
        ]);

        // only the creator of this short link will be able to update it
        if($short_link->user_id != Auth::id()){
            return redirect('/')
                ->with('error', 'Unauthorized to do this action!');
        }

        $short_link->link = $request->link;

        $short_link->link_name = !empty($request->link_name) ? $request->link_name : null;

        $short_link->updated_by_id = Auth::id();

        if ($short_link->update()) {
            return redirect('/')
                ->with('success', 'Shorten Link Updated Successfully!');
        } else {
            return redirect('/')
                ->with('error', 'Shorten Link Update Failed!');
        }
    }


    public function shortenLink($code)
    {
        $find = ShortLink::where('code', $code)->first();

        if($find){
            $find->click_count = (int) $find->click_count + 1; // get the click count

            $find->update();

            return redirect($find->link); // redirect to the required link
        }
        return redirect('/'); // else redirect to home page
    }

    public function destroy(ShortLink $short_link){
        // only the creator of this short link will be able to delete it
        if ($short_link->user_id != Auth::id()) {
            return redirect('/')
                ->with('error', 'Unauthorized to do this action!');
        }
        if($short_link->delete()){
            return redirect('/')
                ->with('success', 'Shorten Link Deleted Successfully!');
        }else{
            return redirect('/')
                ->with('error', 'Shorten Link Delete Failed!');
        }
    }
}
