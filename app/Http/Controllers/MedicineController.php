<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\MedicineCategory;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    // Show all medicines
    public function index()
    {
        $medicines = Medicine::latest()->paginate(10);
        return view('medicines.index', compact('medicines'));
    }

    // Show create form
    public function create()
    {
        $categories = MedicineCategory::all();
        return view('medicines.create', compact('categories'));
    }

    // Store new medicine
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'quantity' => 'required|integer|min:0',
        ]);

        Medicine::create($request->all());

        return redirect()->route('admin.medicines.index')->with('success', 'Medicine added successfully.');
    }

    // Show edit form
    public function edit($id)
    {
        $medicine = Medicine::findOrFail($id);
        $categories = MedicineCategory::all();
        return view('medicines.edit', compact('medicine', 'categories'));
    }


    // Update medicine
    public function update(Request $request, Medicine $medicine)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:medicine_categories,id',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'expiry_date' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        $medicine->update($validated);

        return redirect()->route('admin.medicines.index')
            ->with('success', 'Medicine updated successfully.');
    }


    // Delete medicine
    public function destroy(Medicine $medicine)
    {
        $medicine->delete();

        return redirect()->route('admin.medicines.index')->with('success', 'Medicine deleted successfully.');
    }
}
