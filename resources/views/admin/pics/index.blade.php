@extends('layouts.admin')
@section('content')
@can('pic_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.pics.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.pic.title_singular') }}
            </a>
        </div>
    </div>
@endcan

{{-- search --}}
<div class="card">
    <div class="card-header">
        {{ trans('cruds.pic.title_singular') }} {{ trans('global.list') }} {{ trans('global.search') }}
    </div>
    <div class="card-body">
        <div class="row" id="search">
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.pic.fields.name') }}</label>
                <input type="text" class="form-control" id="name"
                    placeholder="{{ trans('cruds.pic.fields.name') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.pic.fields.contact') }}</label>
                <input type="text" class="form-control" id="contact"
                    placeholder="{{ trans('cruds.pic.fields.contact') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.pic.fields.email') }}</label>
                <input type="text" class="form-control" id="email"
                    placeholder="{{ trans('cruds.pic.fields.email') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.pic.fields.position') }}</label>
                <input type="text" class="form-control" id="position"
                    placeholder="{{ trans('cruds.pic.fields.position') }}">
            </div>
            <div class="form-group col-12 col-lg-6 align-self-end">
                <button type="button" id="search_form_submit" class="btn btn-primary btn_controller" disabled>
                    {{ trans('global.search') }}
                </button>
                <button type="button" id="reset" class="btn btn-danger btn_controller" disabled>
                    {{ trans('global.reset') }}
                </button>
            </div>
        </div>
    </div>
</div>
{{-- /search --}}

<div class="card">
    <div class="card-header">
        {{ trans('cruds.pic.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Pic">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.pic.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.pic.fields.name') }}
                    </th>
                    <th>
                        {{ trans('cruds.pic.fields.contact') }}
                    </th>
                    <th>
                        {{ trans('cruds.pic.fields.email') }}
                    </th>
                    <th>
                        {{ trans('cruds.pic.fields.position') }}
                    </th>
                    <th>
                        {{ trans('cruds.pic.fields.fb') }}
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
            </thead>
        </table>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
        var firstTime = true;
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('pic_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.pics.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
          return entry.id
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

    let dtOverrideGlobals = {
        buttons: dtButtons,
        processing: true,
        language: {
            sUrl : "{{ asset('json/datatable_language.json') }}"
        },
        serverSide: true,
        retrieve: true,
        aaSorting: [],
        pageLength: localStorage.getItem("pic") ? JSON.parse(localStorage.getItem("pic"))['length'] ? JSON.parse(localStorage.getItem("pic"))['length'] :10 : 10,
        search :{
            regex : true,
        },
        bSort: false,
        orderCellsTop: true,
        ajax: {
            url: "{{ route('admin.pics.index') }}",
            data: function(d) {

                if (localStorage.getItem("pic") && firstTime) {
                    var pic = JSON.parse(localStorage.getItem("pic"));

                    var page = pic['page'] ? pic['page'] : 0;
                    var length = pic['length'] ? pic['length'] : 10;

                    d.start = page * length;
                }
            }
        },
        initComplete: function(settings, json) {
            if (localStorage.getItem("pic")) {
                var pic = JSON.parse(localStorage.getItem("pic"));
                if (pic['page']) {
                    const api = $.fn.dataTable.Api(settings);
                    api.page(pic['page']).draw(false);
                }
                firstTime = false;
            }
        },
        drawCallback: function(settings) {
            $('.btn_controller').prop('disabled', false);
        },
        columns: [
            { data: 'placeholder', name: 'placeholder' },
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'contact', name: 'contact' },
            { data: 'email', name: 'email' },
            { data: 'position', name: 'position' },
            { data: 'fb', name: 'fb' },
            { data: 'actions', name: '{{ trans('global.actions') }}' }
        ],
    };
    let table = $('.datatable-Pic').DataTable(dtOverrideGlobals);
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });

        $('.datatable-Pic').on( 'page.dt', function () {
            datatable_set_page_and_length();
        });

        $('.datatable-Pic').on( 'length.dt', function ( e, settings, len ) {
            datatable_set_page_and_length();
        });

        function datatable_set_page_and_length() {
            var info = table.page.info();

            if (localStorage.getItem("pic")) {
                var pic = JSON.parse(localStorage.getItem("pic"));
            }

            pic['page'] = info.page;
            pic['length'] = info.length;

            localStorage.setItem("pic", JSON.stringify(pic));
        }

        var searchingFunction = function (val, tableRow) {
            if (val.length > 1){
                valString = val.toString();
                valPiped =  valString.replace(/,/g,"|")

                table
                    .columns(tableRow)
                    .search( valPiped ? '^'+valPiped+'$' : '', true, false ) //find this value in this column, if it matches, draw it into the table.
                    .draw();
            } else if (val.length == 1) {
                table
                    .columns(tableRow)
                    .search( val ? '^'+val+'$' : '', true, false ) //find this value in this column, if it matches, draw it into the table.
                    .draw();
            } else {
                table
                    .columns(tableRow)
                    .search('',true,false)
                    .draw();
            }
        }

        $("#reset").on('click', function(e) {
            e.preventDefault();

            $('.btn_controller').prop('disabled', true);

            Reset();
            Searching();
        });

        function Reset() {
            $('#search #name').val('');
            $('#search #contact').val('');
            $('#search #email').val('');
            $('#search #position').val('');
        }

        function Default() {
            if (localStorage.getItem("pic")) {
                var searching = JSON.parse(localStorage.getItem("pic"));

                $('#search #name').val(searching['name'] ? searching['name'] : '');
                $('#search #contact').val(searching['contact'] ? searching['contact'] : '');
                $('#search #email').val(searching['email'] ? searching['email'] : '');
                $('#search #position').val(searching['position'] ? searching['position'] : '');

                Searching();
            } else {
                Reset();
                Searching();
            }
        }

        Default();

        function Searching() {
            table.ajax.reload();

            var name = $('#search #name').val();
            table
                .columns(2)
                .search(name)
                .draw();

            var contact = $('#search #contact').val();
            table
                .columns(3)
                .search(contact)
                .draw();

            var email = $('#search #email').val();
            table
                .columns(4)
                .search(email)
                .draw();

            var position = $('#search #position').val();
            table
                .columns(5)
                .search(position)
                .draw();

            var pic = {
                'name'      : name,
                'contact'   : contact,
                'email'     : email,
                'position'  : position
            };

            if (localStorage.getItem("pic") && firstTime) {
                var pic = JSON.parse(localStorage.getItem("pic"));

                var page = pic['page'] ? pic['page'] : 0;
                var length = pic['length'] ? pic['length'] : 10;

                pic['page'] = page;
                pic['length'] = length;
            }

            localStorage.setItem("pic", JSON.stringify(pic));
        }

        $('#search_form_submit').on('click', function(e) {
            e.preventDefault();

            $('.btn_controller').prop('disabled', true);

            Searching();
        })

});

</script>
@endsection
