<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Support;
use Illuminate\Http\Request;
use DataTables;

class SupportController extends Controller
{
    public function adminlist_support(Request $request)
    {
        $titleSeo = 'Liste des Tickets';
        if ($request->ajax()) {
            $data = Support::select('*')->orderBy('id', 'desc');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="support/' . $row->id . '/show" class="badge bg-success" style="padding:5px;margin-right:2px;"><i class="fa fa-eye"></i></a>';
                    $btn .= '<a onclick="return confirm(\'Vous êtes sûr de supprimer le ticket?\')" href="support/' . $row->id . '/destroy" class="badge bg-danger" style="padding:5px;margin-right:2px;"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('back.support.list', compact('titleSeo'));
    }

    public function show($id)
    {
        $support = Support::findOrFail($id);
        $titleSeo = 'Détail support';
        return view('back.support.show', compact('support', 'titleSeo'));
    }

    public function create()
    {
        $admin = Admin::where('role', 'admin')->get();
        $titleBreadcrumbs = 'Contact';
        $titleSeo = 'Contact - SAV';
        $descriptionSeo = 'contact';
        return view('back.support.add', compact('titleBreadcrumbs', 'titleSeo', 'descriptionSeo', 'admin'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sujet' => 'required|string|max:255',
            'support' => 'required|string|max:255',
            'message' => 'required|string',
            'id_client' => 'required|integer|exists:admins,id',
        ]);

        Support::create($request->only('id_client', 'sujet', 'support', 'message'));

        return redirect()->route('dashboard')->with('success', 'Réclamation confirmée ! Un e-mail récapitulatif des détails vous sera bientôt envoyé.');
    }

    public function destroy($id)
    {
        Support::findOrFail($id)->delete();
        return redirect()->route('admin.list_support')->with('success', 'Support supprimé');
    }
}
