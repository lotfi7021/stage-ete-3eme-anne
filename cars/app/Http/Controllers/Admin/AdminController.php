<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Front\DashController;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\StoreLivreurRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use Illuminate\Support\Facades\Log;
use DataTables;

class AdminController extends Controller
{
    public function login_form()
    {
        $titleSeo = 'Connexion - SelectCars';

        if (!Auth::guard('admin')->check()) {
            return view('back.admin_login', compact('titleSeo'));
        } else {
            return redirect()->route('admin.list_machine');
        }
    }

    public function login_functionality(Request $request)
    {
        $request->validate([
            'login' => 'required|string|max:255',
            'password' => 'required|string|max:255',
        ]);

        if (Auth::guard('admin')->attempt(['login' => $request->login, 'password' => $request->password, 'status' => 1])) {
            $admin = Admin::where('login', $request->login)->first();
            Session::put('user', $admin->id);

            switch ($admin->role) {
                case 'admin':
                    return redirect()->route('admin.list_machine');
                case 'client':
                    return redirect()->route('client.list_machine');
                case 'livreur':
                    return redirect()->route('dashboardL');
                default:
                    return redirect()->route('login.form');
            }
        } else {
            Log::warning('Échec de connexion', [
                'login' => $request->input('login'),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
            Session::flash('error-message', 'Login ou mot de passe incorrect.');
            return back();
        }
    }

    public function dashboard()
    {
        return app(DashController::class)->support();
    }

    public function settings(Request $request)
    {
        $titleSeo = 'Settings';
        $admin = Admin::findOrFail($request->id);
        return view('back.settings', compact('admin', 'titleSeo'));
    }

    public function logoutadmin()
    {
        Auth::guard('admin')->logout();
        Session::forget('user');
        return redirect()->route('login.form');
    }

    // ── Gestion des comptes admin ──

    public function adminlist_compte(Request $request)
    {
        $titleSeo = 'Liste des Comptes';
        if ($request->ajax()) {
            $data = Admin::where('status', 1)->orderBy('id', 'desc');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return $row->role != 'admin'
                        ? $this->actionBadges(route('admin.settings', $row->id), route('admin.list_compte.delete', $row->id), 'Vous êtes sûr de désactiver le compte?')
                        : $this->actionBadges(route('admin.settings', $row->id));
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('back.compte.list', compact('titleSeo'));
    }

    public function clientlist_compte(Request $request)
    {
        $titleSeo = 'Liste des Comptes';
        if ($request->ajax()) {
            $data = Admin::where('role', 'client')
                ->where('status', 1)
                ->orderBy('id', 'desc');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return $this->actionBadges(route('admin.list_client.edit', $row->id), route('admin.list_compte.delete_client', $row->id), 'Vous êtes sûr de supprimer le compte?');
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('back.Client.list', compact('titleSeo'));
    }

    // ── Gestion des comptes client ──

    public function store_client(StoreClientRequest $request)
    {
        Admin::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'nom_de_la_societe' => $request->nom_de_la_societe,
            'code_TVA' => $request->code_TVA,
            'adresse' => $request->adresse,
            'telephone' => $request->telephone,
            'Email' => $request->Email,
            'type' => 1,
            'login' => $request->login,
            'role' => 'client',
            'status' => 1,
            'groupe' => $request->groupe,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.client_compte')->with('success', 'Succès');
    }

    public function edit_client($id)
    {
        $client = Admin::findOrFail($id);
        $titleSeo = 'Modifier le client';
        return view('back.Client.edit', compact('titleSeo', 'client'));
    }

    public function update_client(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'telephone' => ['required', 'regex:/^\d{8}$/'],
            'Email' => 'required|email|max:255',
        ]);

        $client = Admin::findOrFail($id);
        $client->update($request->only('nom', 'prenom', 'nom_de_la_societe', 'code_TVA', 'adresse', 'telephone', 'login', 'Email'));

        return redirect()->route('admin.client_compte')->with('success', 'Merci!');
    }

    // ── Gestion des comptes admin ──

    public function create()
    {
        $titleSeo = 'Ajouter un compte';
        return view('back.compte.add', compact('titleSeo'));
    }

    public function store(StoreAdminRequest $request)
    {
        Admin::create([
            'nom' => $request->nom,
            'prenom' => '',
            'nom_de_la_societe' => '',
            'code_TVA' => '',
            'adresse' => '',
            'telephone' => 0,
            'Email' => '',
            'type' => 1,
            'login' => $request->login,
            'role' => $request->role,
            'groupe' => 0,
            'status' => 1,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('compte')->with('success', 'Succès');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'login' => 'required|string',
        ]);

        $admin = Admin::findOrFail($id);
        $admin->nom = $request->nom;
        $admin->login = $request->login;

        if ($request->filled('prenom')) {
            $admin->prenom = $request->prenom;
        }
        if ($request->filled('telephone')) {
            $admin->telephone = $request->telephone;
        }
        if ($request->filled('role')) {
            $admin->role = $request->role;
        }

        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }

        $admin->save();
        return redirect()->route('compte')->with('success', 'Succès');
    }

    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->status = $admin->status == 0 ? 1 : 0;
        $admin->save();
        return redirect()->back()->with('success', 'Compte mis à jour');
    }

    // ── Gestion des livreurs ──

    public function livreurlist_compte(Request $request)
    {
        $titleSeo = 'Liste des livreurs';
        if ($request->ajax()) {
            $data = Admin::where('role', 'livreur')
                ->where('status', 1)
                ->orderBy('id', 'desc');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return $this->actionBadges(route('admin.list_livreur.edit', $row->id), route('admin.list_compte.delete_livreur', $row->id), 'Vous êtes sûr de supprimer le livreur?');
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('back.compte.list', compact('titleSeo'));
    }

    public function create_livreur()
    {
        $titleSeo = 'Ajouter un livreur';
        return view('back.compte.add', compact('titleSeo'));
    }

    public function store_livreur(StoreLivreurRequest $request)
    {
        Admin::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'nom_de_la_societe' => '',
            'code_TVA' => '',
            'adresse' => '',
            'telephone' => $request->telephone,
            'Email' => '',
            'type' => 1,
            'login' => $request->login,
            'role' => 'livreur',
            'groupe' => 0,
            'status' => 1,
            'region' => $request->region,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.list_livreur')->with('success', 'Livreur ajouté avec succès');
    }

    public function edit_livreur($id)
    {
        $admin = Admin::findOrFail($id);
        $titleSeo = 'Modifier le livreur';
        return view('back.compte.edit', compact('titleSeo', 'admin'));
    }

    public function update_livreur(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'telephone' => ['required', 'regex:/^\d{8}$/'],
            'region' => 'required|string|max:255',
        ]);

        $admin = Admin::findOrFail($id);
        $admin->update($request->only('nom', 'prenom', 'telephone', 'region'));

        return redirect()->route('admin.list_livreur')->with('success', 'Livreur mis à jour');
    }

    public function destroy_livreur($id)
    {
        Admin::where('id', $id)->firstOrFail()->delete();
        return redirect()->back()->with('success', 'Compte supprimé');
    }

    public function destroy_client($id)
    {
        Admin::where('id', $id)->firstOrFail()->delete();
        return redirect()->back()->with('success', 'Compte supprimé');
    }

    private function actionBadges(string $editRoute, ?string $deleteRoute = null, ?string $confirmMessage = null): string
    {
        $btn = '<a href="' . $editRoute . '" class="badge bg-success" style="padding:5px;margin-right:2px;"><i class="fa fa-pencil-alt"></i></a>';
        if ($deleteRoute !== null) {
            $btn .= '<a onclick="return confirm(\'' . $confirmMessage . '\')" href="' . $deleteRoute . '" class="badge bg-danger" style="padding:5px;margin-right:2px;"><i class="fa fa-trash"></i></a>';
        }
        return $btn;
    }
}
