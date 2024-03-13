@extends('layout.dashboard.app', ['title' => 'List User'])

@section('content')
<section class="section">
    @foreach ($label as $item)
    @if ($item->code == 'user')
    <div class="section-title">
        <h3>{!! html_entity_decode($item->title) !!}</h3>
    </div>
    <p class="section-lead">
        {!! html_entity_decode($item->desc) !!}
    </p>
    @endif
    @endforeach
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>List</h4>
                    <div class="card-header-action">
                        <a href="{{ route('user.create') }}" class="btn btn-success" data-toggle="tooltip"
                           title="Add"><i class="fas fa-plus-circle"></i></a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                            <tr style="text-align:left">
                                <th>ACCOUNT</th>
                                <th>RIDER</th>
                                <th>PERMISSION</th>
                                <th>STATUS</th>
                                <th style="text-align:center">ACTION</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($data as $item)
                            <tr>
                                <td>
                                    <div class="m-3">
                                        <div class="badge badge-dark">#{{ $item->id }}</div>
                                        <div><i class="fas fa-user"></i> {{ strtoupper($item->name) }}</div>
                                        <div>( {{ $item->username }} )</div>
                                        <div><i class="fas fa-envelope"></i> {{ $item->email }}</div>
                                        <div><i class="fas fa-phone"></i> {{ $item->phone }}</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="m-3">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <img
                                                    src="{{ isset($item->member->image) ? asset('storage/rider/'.$item->member->image) : asset('assets/img/avatar/avatar-1.png') }}"
                                                    alt="avatar" class="rounded-circle" width="50" height="50">
                                            </div>
                                            <div class="col-md-9">
                                                @if ($item->member)
                                                <div class="badge badge-primary">#{{ $item->member->code ?? '' }}</div>
                                                <div><i class="fas fa-bicycle"></i> {{ strtoupper($item->member->name)
                                                    }}
                                                </div>
                                                <div><i class="fas fa-birthday-cake"></i> {{ $item->member->place ?? ''
                                                    }}, {{
                                                    date('d M Y',
                                                    strtotime($item->member->date)) ?? '' }}
                                                </div>
                                                <div><i class="fas fa-venus-mars"></i>
                                                    {{ $item->member->gender == 'L' ? 'Boy' : 'Girl' }}
                                                </div>
                                                @else
                                                <div class="badge badge-info">Setup your rider profile for
                                                    participate
                                                    event
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @php
                                    $badgeClass = '';
                                    $iconClass = 'fas fa-key';
                                    switch ($item->permission) {
                                    case 'ADMIN':
                                    $badgeClass = 'badge-info';
                                    break;
                                    case 'EVENT':
                                    $badgeClass = 'badge-primary';
                                    break;
                                    case 'MEMBER':
                                    $badgeClass = 'badge-warning';
                                    break;
                                    default:
                                    $badgeClass = 'badge-dark';
                                    }
                                    @endphp
                                    <div class="badge {{ $badgeClass }}">
                                        <i class="{{ $iconClass }}"></i> {{ $item->permission }}
                                    </div>
                                </td>
                                <td>
                                    <div class="badge badge-{{ $item->status == 'ACTIVE' ? 'success' : 'danger' }}">
                                        {{ $item->status }}
                                    </div>
                                </td>
                                <td colspan="2">
                                    <div class="row justify-content-md-center">
                                        @if ($item->member)
                                        <a href="{{ route('user.profile.show', $item->id) }}"
                                           class="btn btn-primary btn-action m-1" data-toggle="tooltip"
                                           title="Detail Rider"><i
                                                class="fas fa-bicycle"></i></a>
                                        @else
                                        <a href="{{ route('user.profile', $item->id) }}"
                                           class="btn btn-info btn-action m-1" data-toggle="tooltip"
                                           title="Setup Rider"><i
                                                class="fas fa-bicycle"></i></a>
                                        @endif
                                        <a href="{{ route('user.edit', $item->id) }}"
                                           class="btn btn-warning btn-action m-1" data-toggle="tooltip" title="Edit"><i
                                                class="fas fa-pencil-alt"></i></a>
                                        <button class="btn btn-danger m-1"
                                                onclick="deleteConfirmation('{{$item->id}}','{{ $item->username }}')"
                                                data-toggle="tooltip" title="Delete"><i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <div class="alert alert-dark m-5">
                                Data not found
                            </div>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="d-felx justify-content-center">
                    <div class="card-footer text-right">
                        {{ $data->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function deleteConfirmation(id, username) {
            swal({
                title: "Are you sure you delete data " + username + " ?",
                text: "Please confirm and then confirm !",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Delete",
                cancelButtonText: "Cancel",
                cancelButtonColor: "#F0E701",
                confirmButtonColor: "#1AA13E",
                reverseButtons: !0
            }).then(function (e) {
                if (e.value === true) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        type: 'POST',
                        url: "{{url('/user/destroy')}}/" + id,
                        data: {
                            _token: CSRF_TOKEN,
                            _method: 'DELETE',
                            "id": id
                        },
                        dataType: 'JSON',
                        success: function (results) {
                            if (results.success === true) {
                                swal("Success", results.message, "success");
                                window.location.replace("{{ url('user') }}");
                            } else {
                                swal("Failed", results.message, "error");
                            }
                        }
                    });
                } else {
                    e.dismiss;
                }
            }, function (dismiss) {
                return false;
            })
        }
    </script>

</section>
@endsection
