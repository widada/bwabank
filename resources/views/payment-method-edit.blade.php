@extends('base')

@section('title', 'Payment Methods')

@section('header_title', 'Payment Methods')

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <div class="card-body table-responsive p-0">
            @if ($errors->any())
              <div class="alert alert-danger">
                <ul>
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif
            <form method="POST" action="{{ route('admin.payment_methods.update', $payment_method->id) }}" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <div class="card-body">
                <div class="form-group">
                  <label for="name">Name</label>
                  <input type="text" class="form-control" name="name" id="name" value="{{ $payment_method->name }}" placeholder="Enter name">
                </div>
                <div class="form-group">
                  <label for="code">Code</label>
                  <input type="text" class="form-control" name="code" id="code" value="{{ $payment_method->code }}" placeholder="Midtrans code">
                </div>
                <div class="form-group">
                  <label for="thumbnail">Thumbnail</label>
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" name="thumbnail" id="thumbnail">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="status">Status</label>
                  <select name="status" class="custom-select" id="status">
                    <option value="">- No status -</option>
                    <option value="active" {{ ($payment_method->status === 'active') ? "selected" : "" }}>Active</option>
                    <option value="inactive" {{ ($payment_method->status === 'inactive') ? "selected" : "" }}>Inactive</option>
                  </select>
                </div>
              </div>
              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection