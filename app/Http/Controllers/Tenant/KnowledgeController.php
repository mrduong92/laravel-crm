<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Knowledge;
use App\Http\Requests\KnowledgeRequest;
use Illuminate\Http\Request;
use App\DataTables\KnowledgesDataTable;

class KnowledgeController extends Controller
{
    public function index(KnowledgesDataTable $dataTable)
    {
        return $dataTable->render('tenant.knowledges.index');
    }

    public function create($type = 'text')
    {
        return view('tenant.knowledges.create', compact('type'));
    }

    public function store($type = 'text', KnowledgeRequest $request)
    {
        $data = $request->validated();
        dd($data);
        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('knowledges', 'public');
        }
        Knowledge::create($data);
        return redirect()->route('knowledges.index')->with('success', 'Tạo mới thành công');
    }

    public function edit(Knowledge $knowledge)
    {
        $this->authorize('update', $knowledge);
        return view('tenant.knowledges.edit', compact('knowledge'));
    }

    public function update(KnowledgeRequest $request, Knowledge $knowledge)
    {
        $data = $request->validated();
        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('knowledges', 'public');
        }
        $knowledge->update($data);
        return redirect()->route('knowledges.index')->with('success', 'Cập nhật thành công');
    }

    public function destroy(Knowledge $knowledge)
    {
        $this->authorize('delete', $knowledge);
        $knowledge->delete();
        return redirect()->route('knowledges.index')->with('success', 'Xóa thành công');
    }
}
