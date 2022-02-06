@extends('layouts.app')

@section('content')

@include('components.alert') 

<div class="row">
    <div class="col-lg-12">
        <table id="datatable" class="table table-bordered table-striped">
            <thead>
            <tr>
              @foreach ($table_header as $name=>$th)
                <th>{{$th}}</th>
              @endforeach
            </tr>
            </thead>
          </table>
    </div>
</div>
@endsection

@push('script')
<script>
    $(function () {
      $('#datatable').DataTable({
        "responsive": true,
        "autoWidth": false,
        "ajax": "{{route('user.json')}}",
        "columns": @json($columns),
        "order": [[ 7, "desc" ]],
        "columnDefs": [
          {
              targets: 0,
              visible: false
          },
          {
              targets: 1,
              render: function (data, type, row) {
                  return '<a href="{{url('user/edit')}}/'+row['id']+'">'+data+'</a>';
              },       
              orderable: false
          },
          {
              targets: -1,
              render: function (data, type, row) {
                  let edit = '<a href="{{url('user/edit')}}/'+data+'" class="btn btn-info btn-sm text-white"><i class="fas fa-edit"></i></a>';
                  let trash = '<a href="{{url('user/delete')}}/'+data+'" class="btn btn-danger btn-sm text-white" onclick="return confirm(\'This user will be deleted immediatly.\')"><i class="fas fa-trash"></i></a>';
                  return edit + '&nbsp;&nbsp;|&nbsp;&nbsp;' + trash;
              },       
              orderable: false
          },
          {
              targets: [-2, -3, -5],
              render: function (data, type, row) {
                  if (!data) {
                      return '';
                  }
                  return moment.parseZone(data).format('llll');
              }
          },
          {
              targets: 3,
              render: function (data, type, row) {
                  let stats = '<span class="badge badge-danger">Inactive</span>';
                  if (data == 1) {
                    stats = '<span class="badge badge-success">Active</span>';
                  }
                  return stats;
              }
          }
        ]
      });
    });
  </script>
@endpush