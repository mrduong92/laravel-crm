<?php

namespace App\MediaLibrary\PathGenerator;

use Spatie\MediaLibrary\Support\PathGenerator\DefaultPathGenerator;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class TenantPathGenerator extends DefaultPathGenerator
{
    public function getPath(Media $media): string
    {
        $tenantId = tenant('id') ?? 'default'; // fallback nếu chưa có tenant
        return "tenants/{$tenantId}/" . $media->id . '/';
    }
}
