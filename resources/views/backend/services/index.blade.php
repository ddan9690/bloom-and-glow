@extends('layouts.backend')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center my-4">
        <h1 class="h3 mb-0 text-gray-800">Services Management</h1>
        <a href="{{ route('backend.services.create') }}" class="btn btn-primary">
            <i class="fas fa-plus fa-sm"></i> Add New Service
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered align-middle" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Category</th>
                            <th>Service Name</th>
                            <th>Price</th>
                            <th>Duration (Mins)</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($services as $service)
                            <tr>
                                <td>{{ $service->id }}</td>
                                <td>
                                    <span class="badge bg-info text-dark">
                                        {{ $service->category->name ?? 'Unassigned' }}
                                    </span>
                                </td>
                                <td><strong>{{ $service->name }}</strong></td>
                                <td>{{ number_format($service->price, 2) }}</td>
                                <td>{{ $service->duration }} mins</td>
                                <td class="text-center">
                                    <a href="{{ route('backend.services.edit', $service->id) }}" class="btn btn-sm btn-info text-white">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('backend.services.destroy', $service->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this service?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">No services found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection