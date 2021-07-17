@extends('admin.layouts.app')

@section('card-title')
    Data Operator
@endsection
@section('content')
    <table id="table1" class="display">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th># Tower</th>
            </tr>
        </thead>
        <tbody>
            @forelse($operator as $key => $operator)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $operator->name }}</td>
                    <td>{{ $operator->email }}</td>
                    <td>{{ $coordinate->where('id_operator', $operator->id)->count() }}</td>
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
                        "width": "3%",
                        "targets": 0,
                    }],
                    "columnDefs": [{
                        "width": "10%",
                        "targets": -1,
                        "className": 'dt-body-center',
                    }]
                });
            });
        </script>
    @endpush
@endsection
