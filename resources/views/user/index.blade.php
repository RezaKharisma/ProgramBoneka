<x-app-layout title="User">
    <div class="my-3 row align-items-center">
        <div class="col">
            <h2 class="page-title">User</h2>
        </div>
        <div class="col-auto">
            <a href="{{ route('user.index') }}" class="mr-3 btn btn-sm"><span class="fe fe-refresh-ccw fe-16 text-muted"></span></a>
        </div>
    </div>

    <div class="my-4 row">
        <!-- Small table -->
        <div class="col-md-12">
            <div class="shadow card">
                <div class="card-body">
                    <!-- table -->
                    <table class="table datatables nowrap table-hover" id="dataUser">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp @forelse ($user as $u)
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $u->name }}</td>
                                <td>{{ $u->role }}</td>
                                <td>
                                    <form action="{{ route('user.updateStatus', $u->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        @if ($u->status == "Aktif")
                                            <button class="btn btn-success btn-sm" type="submit">{{ $u->status }}</button>
                                        @else
                                            <button class="btn btn-danger btn-sm" type="submit">{{ $u->status }}</button>
                                        @endif
                                    </form>
                                </td>
                                <td>
                                    <a href="{{ route('user.edit', $u->id) }}" class="mb-1 btn btn-warning btn-sm data-stok">Update</a>
                                </td>
                            </tr>
                            @php $no++; @endphp @empty
                            <tr>
                                <td colspan="8" align="center">
                                    <div class="alert alert-warning">DATA KOSONG!</div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- simple table -->
    </div>
    <!-- end section -->

    @section('modals')

    @endsection

    @push('scripts')
        <script>
            $(document).ready(function () {
                $("#dataUser").DataTable({
                    autoWidth: true,
                    columns: [null, null, null, { searchable: false, orderable: false }],
                    // dom: 'Bfrtip',
                });
            });
        </script>
    @endpush
</x-app-layout>
