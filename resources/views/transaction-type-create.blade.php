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
            <form method="POST" action="{{ route('admin.transaction_types.store') }}" enctype="multipart/form-data">
              {{ csrf_field() }}
              <div class="card-body">
                <div class="form-group">
                  <label for="name">Name</label>
                  <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" placeholder="Enter name">
                </div>
                <div class="form-group">
                  <label for="code">Code</label>
                  <input type="text" class="form-control" name="code" id="code" value="{{ old('code') }}" placeholder="code">
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
                  <label for="status">Action</label>
                  <select name="action" class="custom-select" id="action">
                    <option value="">- No Action -</option>
                    <option value="dr" {{ (old('action') === 'dr') ? "selected" : "" }}>Debit</option>
                    <option value="cr" {{ (old('action') === 'cr') ? "selected" : "" }}>Credit</option>
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