<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use DataTables;

class BannerController extends Controller
{
   


    public function adminlist_banner(Request $request)
    {
        $titleSeo = 'Liste des bannières'; 
        if ($request->ajax()) {
            $data = Banner::select('*')->orderBy('id','desc');
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('image', function ($image) {
                        $url= $image->image;
                        return $url;
                    })  
                   
                    ->addColumn('action', function($row){
                            
                            $btn = '<a href="list_banners/'.$row->id.'/edit" class="badge  bg-success" style="padding:5px;margin-right:2px;"><i class="fa fa-pencil-alt"></i></a>';
                            $btn .= '<a onclick="return confirm(\'Vous êtes sûr de supprimer le bannière?\')" href="list_banners/'.$row->id.'/delete" class="badge  bg-danger" style="padding:5px;margin-right:2px;"><i class="fa fa-trash"></i></a>';
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
    return view('back.banner.list', compact('titleSeo'));
    }

    
    public function create()
    {
        $titleSeo = "Ajouter une bannière";
        return view('back.banner.add',compact('titleSeo'));

    }

   
    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required',
            'image' => 'file|required|mimes:jpg,png|max:800',
        ]);
        $banner = new Banner();
        if($request->file('image')) {
            $file = $request->file('image');
            $filename1 = time().'_'.$file->getClientOriginalName();
            $location = public_path('/images/banners');
            $file->move($location,$filename1);
          }
          $banner->titre = $request->titre;
          $banner->image = $filename1;
          $banner->save();
          return redirect()->route('admin.list_banners')->with('success', 'Bannière ajouter avec succèes');
        
    }

   
   
                 public function edit($id)
                     {
                         $titleSeo= "Modifier le bannière";
                         $banner = Banner::where('id',$id)->first();
                         if(is_null($banner)){
                                     return abort(404);
                                 }

                         return view('back.banner.edit',compact('titleSeo','banner'));
                     }

    public function update(Request $request, $id)
    {
        $request->validate([
            'titre' => 'required',
        ]);
        $banner = Banner::find($id);
        if($request->file('image')) {
            $file = $request->file('image');
            $filename1 = time().'_'.$file->getClientOriginalName();
            $location = public_path('/images/banners');
            $file->move($location,$filename1);
          }
          else {
            $filename1 = $banner->image;
          }
          $banner->titre = $request->titre;
          $banner->image = $filename1;
          $banner->save();
          return redirect()->route('admin.list_banners')->with('success','Merci!');
        
    }

   
    public function destroy($id)
    {
        $banner = Banner::where('id',$id)->firstOrFail()->delete();
        return redirect()->route('admin.list_banners')->with('success','Banner Supprimer');

    }


}
