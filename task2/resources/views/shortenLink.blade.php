@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <?php if(!isset($shortLink)) { ?>
                    <form method="POST" 
                    action="{{ route('generate.shorten.link.post') }}"
                    >
                <?php } else {?>
                    <form method="POST" 
                    action="{{ route('generate.shorten.link.update', $shortLink->id) }}"
                    >
                    @method('PUT')
                <?php } ?>
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" name="link_name" class="form-control" placeholder="Enter URL Name" aria-label="Enter URL" aria-describedby="basic-addon2" value="{{ isset($shortLink->link_name) ? $shortLink->link_name : ''  }}">
                        <input type="text" name="link" class="form-control w-50" placeholder="Enter URL" aria-label="Enter URL" aria-describedby="basic-addon2" value="{{ isset($shortLink->link) ? $shortLink->link : ''  }}">
                        <div class="input-group-append">
                            <?php if(!isset($shortLink)) { ?>
                                <button class="btn btn-success" type="submit">Generate Shorten Link</button>
                            <?php } else{ ?>
                                <button class="btn btn-success" type="submit">Update</button>
                            <?php } ?>
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
                        <div class="alert alert-danger">
                            <p>{{ Session::get('error') }}</p>
                        </div>
                    @endif
        
                    <table class="table table-bordered table-sm" id="shortList">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Short Link</th>
                                <th>Link</th>
                                <th>Click Count</th>
                                <th>Created Time</th>
                                <th>Updated Time</th>
                                <th>Edit</th>
                                <?php if(!isset($shortLink)){ ?>
                                    <th>Delete</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($shortLinks as $row)
                                <tr>
                                    <td>{{ $row->id }}</td>
                                    <td>{{ $row->link_name }}</td>
                                    <td><a href="{{ route('shorten.link', $row->code) }}" target="_blank">{{ route('shorten.link', $row->code) }}</a></td>
                                    <td>{{ $row->link }}</td>
                                    <td>{{ $row->click_count }}</td>
                                    <td>{{ date_format($row->created_at,"Y-m-d h:i A") }}</td>
                                    <td>{{ date_format($row->updated_at,"Y-m-d h:i A") }}</td>
                                    <td><a class="btn btn-warning" href="{{ route('generate.shorten.link.edit', $row->id) }}" role="button">Edit</a></td>
                                    <?php if(!isset($shortLink)){ ?>
                                        <td><a class="btn btn-danger" href="{{ route('deleteShortLink', $row->id) }}" onclick="return confirmDelete();" role="button">Delete</a></td>
                                    <?php } ?>
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
            $("#shortList").DataTable({
                "order": [[ 0, "desc" ]],
            });
        });

        const confirmDelete = () => {
            if (confirm("Do you wish to continue")) {
                return true;
            }
            return false;
        }
    </script>
@endsection


