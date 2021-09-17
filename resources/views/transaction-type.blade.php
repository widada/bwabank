@extends('base')

@section('title', 'Payment Methods')

@section('header_title', 'Payment Methods')

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <a href="{{ route('admin.transaction_types.create') }} " class="btn btn-primary">
            <i class="far fa-plus-square"></i>
          </a>
          @if (session('success'))
            <div class="alert alert-success">
              {{ session('success') }}
            </div>
          @endif
          <div class="card-body table-responsive p-0">
            <table id="transaction-type" class="table table-hover text-nowrap">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Thumbnail</th>
                  <th>Code</th>
                  <th>Type</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($transaction_types as $transaction_type)
                  <tr>
                    <td>{{ $transaction_type->id }}</td>
                    <td>{{ $transaction_type->name }}</td>
                    <td><img alt="thumbnail" src="{{ asset('storage/'.$transaction_type->thumbnail) }}" width="100" height="100"></td>
                    <td>{{ $transaction_type->code }}</td>
                    <td>{{ ($transaction_type->action == 'dr') ? 'Debit' : 'Credit' }}</td>
                    <td>
                      <form action="{{ route('admin.transaction_types.destroy', $transaction_type->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <a href="{{ route('admin.transaction_types.edit', $transaction_type->id) }}">
                          <i class="fas fa-edit  fa-lg"></i>
                        </a>
                        <button type="submit" title="delete" style="border: none; background-color:transparent;"">
                          <i class="fas fa-trash fa-lg text-danger"></i>
                        </button>
                      </form>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
    <script>
      $('#transaction-type').DataTable();
    </script>
@endsection