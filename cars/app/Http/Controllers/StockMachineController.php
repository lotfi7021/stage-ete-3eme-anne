<?php

namespace App\Http\Controllers;

use App\Models\Gestion_machine;
use App\Models\stock_machine;
use Illuminate\Http\Request;
use DataTables;

class StockMachineController extends Controller
{
    public function adminlist_stockM(Request $request)
    {
        $titleSeo = 'Liste de stocks';
        if ($request->ajax()) {
            $data = stock_machine::with('produit')->orderBy('id', 'desc');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('id_produit', function ($item) {
                    return $item->produit ? $item->produit->titre : '';
                })
                ->addColumn('action', function ($row) {
                    return '<a href="' . $row->id . '/edit_machine" class="badge bg-success" style="padding:5px;margin-right:2px;"><i class="fa fa-pencil-alt"></i></a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('back.gestion_machine.Stock.list', compact('titleSeo'));
    }

    public function edit($id)
    {
        $stock = stock_machine::findOrFail($id);
        $titleSeo = 'Modifier stock';
        return view('back.gestion_machine.Stock.edit', compact('titleSeo', 'stock'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'qte_initial' => 'required|integer|min:0|max:99999999',
            'mouvement' => 'required|integer|min:0|max:99999999',
            'qte_final' => 'required|integer|min:0|max:99999999',
        ]);

        $stock = stock_machine::findOrFail($id);
        $stock->update($request->only('qte_initial', 'mouvement', 'qte_final'));

        return redirect()->route('admin.list_stock.machine')->with('success', 'Stock mis à jour');
    }
}
