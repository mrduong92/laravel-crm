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

    public function store(KnowledgeRequest $request)
    {
        $data = $request->validated();
        Knowledge::create($data);

        return redirect()->route('knowledges.index')->with('success', 'Tạo mới thành công');
    }

    public function edit(Knowledge $knowledge)
    {
        return view('tenant.knowledges.edit', compact('knowledge'));
    }

    public function update(KnowledgeRequest $request, Knowledge $knowledge)
    {
        $data = $request->validated();
        $knowledge->update($data);

        return redirect()->route('knowledges.index')->with('success', 'Cập nhật thành công');
    }

    public function destroy(Knowledge $knowledge)
    {
        $knowledge->delete();
        return redirect()->route('knowledges.index')->with('success', 'Xóa thành công');
    }
}
