@extends('layouts.app')

@section('content')

    @include('components.alert')

    <div class="row">
        <marketing-journey></marketing-journey>

    </div>
@endsection
@push('script')
    <script>
      $(function () {
        {{--let AjaxUrl = "{{route('marketing-journey.json')}}";--}}

        {{--jQuery.ajax({--}}
        {{--  method: "GET",--}}
        {{--  url: AjaxUrl,--}}
        {{--  data: {'get_records': true},--}}
        {{--  dataType: "JSON"--}}
        {{--}).done(function(resp){--}}
        {{-- console.log(resp)--}}
        {{--});--}}


        $('#datatable').DataTable({
          "responsive":true,
          "autoWidth": false,
          "ajax": "{{route('marketing-journey.json')}}",
          "columns": @json($columns),
          "order": [[ 1, "desc" ]],
          "columnDefs": [
            {
              targets: 0,
              visible: false
            },
            {{--{--}}
            {{--  targets: 1,--}}
            {{--  render: function (data, type, row) {--}}
            {{--    return '<a href="{{url('marketing-journey./edit')}}/'+row['id']+'">'+data+'</a>';--}}
            {{--  },--}}
            {{--  orderable: false--}}
            {{--},--}}
            {{--{--}}
            {{--  targets: -1,--}}
            {{--  render: function (data, type, row) {--}}
            {{--    let edit = '<a href="{{url('marketing-journey./edit')}}/'+data+'" class="btn btn-info btn-sm text-white"><i class="fas fa-edit"></i></a>';--}}
            {{--    let trash = '<a href="{{url('marketing-journey./delete')}}/'+data+'" class="btn btn-danger btn-sm text-white" onclick="return confirm(\'This schedule will be deleted immediatly.\')"><i class="fas fa-trash"></i></a>';--}}
            {{--    return edit + '&nbsp;&nbsp;|&nbsp;&nbsp;' + trash;--}}
            {{--  },--}}
            {{--  orderable: false--}}
            {{--},--}}
            {
              targets: [-2, -5, -6],
              render: function (data, type, row) {
                if (!data) {
                  return '';
                }
                return moment.parseZone(data).format('llll');
              }
            },
            {
              targets: -4,
              render: function (data, type, row) {
                let stats = '<span class="badge badge-danger">Inactive</span>';
                if (data == 1) {
                  stats = '<span class="badge badge-success">Active</span>';
                }
                return stats;
              }
            },
            {
              targets: -3,
              render: function (data, type, row) {
                let stats = '<span class="badge badge-danger">No</span>';
                if (data == 1) {
                  stats = '<span class="badge badge-success">Yes</span>';
                }
                return stats;
              }
            },
          ]
        });
      });
    </script>
@endpush
<script>
  // import MarketingJourneyComponent from "../../../js/components/MarketingJourneyComponent";
  // export default {
  //   components: {MarketingJourneyComponent}
  // }
</script>
