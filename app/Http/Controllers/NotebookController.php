<?php 

namespace App\Http\Controllers;

use App\Models\Notebook;
use Illuminate\Http\Request;

class NotebookController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->query('page', 1);
        $limit = 10;

        $notebooks = Notebook::paginate($limit);
        return response()->json($notebooks);
    }

    public function store(Request $request)
    {
        $request->validate([
            'fio' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        $notebook = Notebook::create($request->all());
        return response()->json(['status' => 'success', 'id' => $notebook->id], 201);
    }

    public function show($id)
    {
        $notebook = Notebook::find($id);
        if (!$notebook) {
            return response()->json(['message' => 'Запись не найдена'], 404);
        }
        return response()->json($notebook);
    }

    public function update(Request $request, $id)
    {
        $notebook = Notebook::find($id);
        if (!$notebook) {
            return response()->json(['message' => 'Запись не найдена'], 404);
        }

        $request->validate([
            'fio' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        $notebook->update($request->all());
        return response()->json(['status' => 'success']);
    }

    public function destroy($id)
    {
        $notebook = Notebook::find($id);
        if (!$notebook) {
            return response()->json(['message' => 'Запись не найдена'], 404);
        }

        $notebook->delete();
        return response()->json(['status' => 'success']);
    }
}