@extends('layouts.app')

@section('content')
    <div class="container mt-5">
    
        <div class="card">
        <div class="card-header">
            <form method="POST" 
            action="{{ route('generate.shorten.link.post') }}"
            >
                @csrf
                <div class="input-group mb-3">
                    <input type="text" name="link" class="form-control" placeholder="Enter URL" aria-label="Enter URL" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-success" type="submit">Generate Shorten Link</button>
                    </div>
                </div>
                @error('link')
                    <span class="text-danger mb-4" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </form>
        </div>
        <div class="card-body">
    
                @if (Session::has('success'))
                    <div class="alert alert-success">
                        <p>{{ Session::get('success') }}</p>
                    </div>
                @endif

                @if (Session::has('error'))
                    <div class="alert alert-error">
                        <p>{{ Session::get('success') }}</p>
                    </div>
                @endif
    
                <table class="table table-bordered table-sm" id="shortList">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Short Link</th>
                            <th>Link</th>
                            <th>Click Count</th>
                            <th>Created Time</th>
                            <th>Updated Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($shortLinks as $row)
                            <tr>
                                <td>{{ $row->id }}</td>
                                <td><a href="{{ route('shorten.link', $row->code) }}" target="_blank">{{ route('shorten.link', $row->code) }}</a></td>
                                <td>{{ $row->link }}</td>
                                <td>{{ $row->click_count }}</td>
                                <td>{{ date_format($row->created_at,"Y-m-d H:i A") }}</td>
                                <td>{{ date_format($row->updated_at,"Y-m-d H:i A") }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
        </div>
        </div>
    
    </div>
@endsection

@section('script')
    <script>
        $( document ).ready(function() {
            $("#shortList").DataTable();
        });
    </script>
@endsection


