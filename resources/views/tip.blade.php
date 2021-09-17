@extends('base')

@section('title', 'Payment Methods')

@section('header_title', 'Payment Methods')

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <a href="{{ route('admin.tips.create') }} " class="btn btn-primary">
            <i class="far fa-plus-square"></i>
          </a>
          @if (session('success'))
            <div class="alert alert-success">
              {{ session('success') }}
            </div>
          @endif
          <div class="card-body table-responsive p-0">
            <table id="tips" class="table table-hover text-nowrap">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Title</th>
                  <th>Thumbnail</th>
                  <th>Url</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($tips as $tip)
                  <tr>
                    <td>{{ $tip->id }}</td>
                    <td>{{ $tip->title }}</td>
                    <td><img alt="thumbnail" src="{{ asset('storage/'.$tip->thumbnail) }}" width="100" height="100"></td>
                    <td>
                      <a href="{{ $tip->url }}" target="_blank">{{ $tip->url }}</a>
                    </td>
                    <td>
                      <form action="{{ route('admin.tips.destroy', $tip->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <a href="{{ route('admin.tips.edit', $tip->id) }}">
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
      $('#tips').DataTable();
    </script>
@endsection