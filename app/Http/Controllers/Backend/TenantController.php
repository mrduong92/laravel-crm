<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\TenantRequest;
use App\Models\Tenant;
use App\Models\Owner;
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
            'name',
            'domain',
        ]);

        $tenant = Tenant::create(['id' => $data['id']]);
        $tenant->domains()->create(['domain' => $data['domain']]);
        // Create a default owner for the tenant
        $tenant->run(function () use ($data) {
            Owner::create([
                'name' => $data['name'] ?? 'Owner',
                'tenant_id' => $data['id'],
                'password' => bcrypt('password'),
            ]);
        });
        // TODO: Send mail or notification

        $request->session()->flash('success', __('backend.created', ['name' => 'tenant']));

        return redirect(route('tenants.index'));
    }

    public function edit(Tenant $tenant)
    {
        $domain = $tenant->domains->first();
        $name = $tenant->run(
            function () use ($tenant) {
                return Owner::where('tenant_id', $tenant->id)->first();
            }
        );
        return view('backend.tenants.edit', compact('tenant', 'domain', 'name'));
    }

    public function update(TenantRequest $request, Tenant $tenant)
    {
        $data = $request->only([
            'name',
            'domain',
        ]);
        $domain = $tenant->domains->first();
        $domain->update(['domain' => $data['domain']]);
        // Update the default owner for the tenant
        $tenant->run(function () use ($tenant, $data) {
            Owner::where('tenant_id', $tenant->id)->update([
                'name' => $data['name'] ?? 'Owner',
                'password' => bcrypt('password'),
            ]);
        });
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
