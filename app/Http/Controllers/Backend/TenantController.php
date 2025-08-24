<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\TenantRequest;
use App\Models\Tenant;
use App\DataTables\TenantsDataTable;

class TenantController extends Controller
{

    public function index(TenantsDataTable $dataTable)
    {
        return $dataTable->render('backend.tenants.index');
    }

    public function create()
    {
        return view('backend.tenants.create');
    }

    public function store(TenantRequest $request)
    {
        $data = $request->only([
            'id',
            'domain',
        ]);

        $tenant = Tenant::create(['id' => $data['id']]);
        $tenant->domains()->create(['domain' => $data['domain']]);
        $request->session()->flash('success', __('backend.created', ['name' => 'tenant']));

        return redirect(route('tenants.index'));
    }

    public function edit(Tenant $tenant)
    {
        $domain = $tenant->domains->first();
        return view('backend.tenants.edit', compact('tenant', 'domain'));
    }

    public function update(TenantRequest $request, Tenant $tenant)
    {
        $data = $request->only([
            'domain',
        ]);
        $domain = $tenant->domains->first();
        $domain->update(['domain' => $data['domain']]);
        $request->session()->flash('success', __('backend.updated', ['name' => 'tenant']));

        return redirect(route('tenants.index'));
    }

    public function destroy(Tenant $tenant, Request $request)
    {
        $tenant->delete();
        $request->session()->flash('success', __('backend.deleted', ['name' => 'tenant']));

        return redirect(route('tenants.index'));
    }
}
