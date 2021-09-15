@extends('base')

@section('title', 'Payment Methods')

@section('header_title', 'Payment Methods')

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
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
                    <td></td>
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