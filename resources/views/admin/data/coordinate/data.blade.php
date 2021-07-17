@extends('admin.layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Data Coordinate') }}
    </h2>
@endsection
@section('card-title')
    Data Coordinate
@endsection
@section('content')
    <table id="table1" class="display">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Range</th>
                <th>ID Tower</th>
                <th>Latitude</th>
                <th>Longitude</th>
                <th>Operator</th>
                <th>Option</th>
            </tr>
        </thead>
        <tbody>
            @forelse($coordinate as $key => $coordinate)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $coordinate->name }}</td>
                    <td>{{ $coordinate->range }}</td>
                    <td>{{ $coordinate->serial }}</td>
                    <td>{{ $coordinate->latitude }}</td>
                    <td>{{ $coordinate->longitude }}</td>
                    <td>{{ $operator->where('id', $coordinate->id_operator)->pluck('name')->first() }}
                    </td>
                    <td>
                        <ul class="list-inline m-0">
                            <li class="list-inline-item"><a href="/admin/coordinate/{{ $coordinate->id }}"
                                    style="text-decoration: none; color: white;">
                                    <button class="btn btn-success btn-sm rounded-0" type="button" data-toggle="tooltip"
                                        data-placement="top" title="View Detail"><i class="fa fa-edit"></i>
                                    </button>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <form action="{{ route('admin.coordinate.destroy', ['coordinate' => $coordinate->id]) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm rounded-0" type="submit" data-toggle="tooltip"
                                        data-placement="top" title="Delete"><i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">Tidak Ada Data...</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    @push('scripts')
        <script>
            $(document).ready(function() {
                $.noConflict();
                var table = $('#table1').DataTable({
                    responsive: true,
                    "columnDefs": [{
                        "width": "10%",
                        "orderable": false,
                        "targets": -1,
                    }]
                });
            });
        </script>
    @endpush
@endsection
