@extends('base')

@section('title', 'Payment Methods')

@section('header_title', 'Payment Methods')

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          @if (session('success'))
            <div class="alert alert-success">
              {{ session('success') }}
            </div>
          @endif
          <div class="card-body table-responsive p-0">
            <table id="payment-method" class="table table-hover text-nowrap">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Thumbnail</th>
                  <th>Type</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($payment_methods as $payment_method)
                  <tr>
                    <td>{{ $payment_method->id }}</td>
                    <td>{{ $payment_method->name }}</td>
                    <td><img alt="thumbnail" src="{{ asset('storage/'.$payment_method->thumbnail) }}" width="100" height="100"></td>
                    <td>{{ $payment_method->status }}</td>
                    <td>
                      <form action="{{ route('admin.payment_methods.destroy', $payment_method->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <a href="{{ route('admin.payment_methods.edit', $payment_method->id) }}">
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
      $('#payment-method').DataTable();
    </script>
@endsection