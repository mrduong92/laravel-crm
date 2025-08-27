<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Knownledge;
use App\Http\Requests\KnownledgeRequest;
use Illuminate\Http\Request;
use App\DataTables\KnownledgesDataTable;

class KnownledgeController extends Controller
{
    public function index(KnownledgesDataTable $dataTable)
    {
        return $dataTable->render('tenant.knownledges.index');
    }

    public function create($type = 'text')
    {
        return view('tenant.knownledges.create', compact('type'));
    }

    public function store($type = 'text', KnownledgeRequest $request)
    {
        $data = $request->validated();
        dd($data);
        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('knownledges', 'public');
        }
        Knownledge::create($data);
        return redirect()->route('knownledges.index')->with('success', 'Tạo mới thành công');
    }

    public function edit(Knownledge $knownledge)
    {
        $this->authorize('update', $knownledge);
        return view('tenant.knownledges.edit', compact('knownledge'));
    }

    public function update(KnownledgeRequest $request, Knownledge $knownledge)
    {
        $data = $request->validated();
        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('knownledges', 'public');
        }
        $knownledge->update($data);
        return redirect()->route('knownledges.index')->with('success', 'Cập nhật thành công');
    }

    public function destroy(Knownledge $knownledge)
    {
        $this->authorize('delete', $knownledge);
        $knownledge->delete();
        return redirect()->route('knownledges.index')->with('success', 'Xóa thành công');
    }
}
