<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\TenantRequest;
use App\Models\Tenant;
use App\Models\User;
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
        // Create a default User for the tenant
        $tenant->run(function () use ($data) {
            User::create([
                'name' => $data['name'] ?? 'User',
                'username' => $data['id'],
                'password' => bcrypt('password'),
                'role' => 'owner',
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
                return User::where('tenant_id', $tenant->id)->first();
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
        // Update the default User for the tenant
        $tenant->run(function () use ($tenant, $data) {
            User::updateOrCreate(
                [
                    'username' => $tenant->id,
                    'role' => 'owner',
                ],
                [
                    'name' => $data['name'] ?? 'User',
                    'username' => $tenant->id,
                    'password' => bcrypt('password'),
                    'role' => 'owner',
                ]
            );
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
