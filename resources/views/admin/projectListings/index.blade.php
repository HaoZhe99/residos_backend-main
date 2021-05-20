@extends('layouts.admin')
@section('content')
@can('project_listing_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.project-listings.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.projectListing.title_singular') }}
            </a>
        </div>
    </div>
@endcan

{{-- search --}}
<div class="card">
    <div class="card-header">
        {{ trans('cruds.projectListing.title_singular') }} {{ trans('global.list') }} {{ trans('global.search') }}
    </div>
    <div class="card-body">
        <div class="row" id="search">
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.projectListing.fields.project_code') }}</label>
                <input type="text" class="form-control" id="project_code"
                    placeholder="{{ trans('cruds.projectListing.fields.project_code') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.projectListing.fields.name') }}</label>
                <input type="text" class="form-control" id="name"
                    placeholder="{{ trans('cruds.projectListing.fields.name') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.projectListing.fields.type') }}</label>
                <input type="text" class="form-control" id="type"
                    placeholder="{{ trans('cruds.projectListing.fields.type') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.projectListing.fields.address') }}</label>
                <input type="text" class="form-control" id="address"
                    placeholder="{{ trans('cruds.projectListing.fields.address') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.projectListing.fields.developer') }}</label>
                <input type="text" class="form-control" id="developer"
                    placeholder="{{ trans('cruds.projectListing.fields.developer') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.projectListing.fields.tenure') }}</label>
                <select class="form-control select2" id="tenure">
                    <option value="All">{{ trans('global.all') }}</option>
                    @foreach (App\Models\ProjectListing::TENURE_SELECT as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.projectListing.fields.area') }}</label>
                <input type="text" class="form-control" id="area"
                    placeholder="{{ trans('cruds.projectListing.fields.area') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.projectListing.fields.pic') }}</label>
                <input type="text" class="form-control" id="pic"
                    placeholder="{{ trans('cruds.projectListing.fields.pic') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-6">
                <label>{{ trans('cruds.facilityBook.fields.date_range') }}</label>
                <div class="input-group">
                    <input type="date" class="form-control date-range-filter" id="min-date">
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                    </div>
                    <input type="date" class="form-control date-range-filter" id="max-date">
                </div>
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.projectListing.fields.status') }}</label>
                <select class="form-control select2" id="status">
                    <option value="All">{{ trans('global.all') }}</option>
                    @foreach (App\Models\ProjectListing::TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-12 col-lg-6 align-self-end">
                <button type="button" id="search_form_submit" class="btn btn-primary btn_controller" disabled>
                    {{ trans('global.search') }}
                </button>
                <button type="button" id="reset" class="btn btn-danger btn_controller" disabled>
                    {{ trans('global.reset') }}
                </button>
            </div>
            <div class="form-check col-12 text-right">
                <label class="checkbox-inline mr-2">
                    <input class="form-check-input" type="checkbox" value="" id="refresh" checked>
                    <label class="form-check-label" for="refresh">
                        {{ trans('global.auto_refresh') }}
                    </label>
                </label>
                <button type="button" id="refresh_button" class="btn btn-light btn_controller" disabled>
                    {{ trans('global.refresh') }} (<span id="countdown_number">15</span>)
                </button>
            </div>
        </div>
    </div>
</div>
{{-- /search --}}

<div class="card">
    <div class="card-header">
        {{ trans('cruds.projectListing.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-ProjectListing">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.projectListing.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.projectListing.fields.project_code') }}
                    </th>
                    <th>
                        {{ trans('cruds.projectListing.fields.name') }}
                    </th>
                    <th>
                        {{ trans('cruds.projectListing.fields.type') }}
                    </th>
                    <th>
                        {{ trans('cruds.projectListing.fields.address') }}
                    </th>
                    <th>
                        {{ trans('cruds.projectListing.fields.developer') }}
                    </th>
                    <th>
                        {{ trans('cruds.projectListing.fields.tenure') }}
                    </th>
                    <th>
                        {{ trans('cruds.projectListing.fields.completion_date') }}
                    </th>
                    <th>
                        {{ trans('cruds.projectListing.fields.status') }}
                    </th>
                    <th>
                        {{ trans('cruds.projectListing.fields.sales_gallery') }}
                    </th>
                    <th>
                        {{ trans('cruds.projectListing.fields.website') }}
                    </th>
                    <th>
                        {{ trans('cruds.projectListing.fields.fb') }}
                    </th>
                    <th>
                        {{ trans('cruds.projectListing.fields.block') }}
                    </th>
                    <th>
                        {{ trans('cruds.projectListing.fields.unit') }}
                    </th>
                    <th>
                        {{ trans('cruds.projectListing.fields.is_new') }}
                    </th>
                    <th>
                        {{ trans('cruds.projectListing.fields.area') }}
                    </th>
                    <th>
                        {{ trans('cruds.projectListing.fields.pic') }}
                    </th>
                    <th>
                        {{ trans('cruds.projectListing.fields.create_by') }}
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- set up the modal to start hidden and fade in and out -->
<div class="modal fade" id="approveModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">{{ trans('global.areYouSure') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- dialog body -->
            <div class="modal-body">
                <img class="container" id="img">
                <div class="container">
                    <form method="POST" id="approve-form">
                        @method('PUT')
                        @csrf
                        <table class="table table-hover table-bordered">
                            <tr>
                                <td>{{ trans('cruds.projectListing.fields.name') }}</td>
                                <td><input class="form-control" type="text" id="name" name="name" readonly></td>
                            </tr>
                            <tr>
                                <td>{{ trans('cruds.projectListing.fields.type') }}</td>
                                <td><input class="form-control" type="text" name="type" id="type" readonly></td>
                            </tr>
                            <tr>
                                <td>{{ trans('cruds.projectListing.fields.address') }}</td>
                                <td><input class="form-control" type="text" name="address" id="address" readonly></td>
                            </tr>
                            <tr>
                                <td>{{ trans('cruds.projectListing.fields.tenure') }}</td>
                                <td><input class="form-control" type="text" name="tenure" id="tenure" readonly></td>
                            </tr>
                            <tr>
                                <td>{{ trans('cruds.projectListing.fields.completion_date') }}</td>
                                <td><input class="form-control" type="text" name="completion_date" id="completion_date" readonly></td>
                            </tr>
                            <tr>
                                <td>{{ trans('cruds.projectListing.fields.create_by') }}</td>
                                <td><input class="form-control" type="text" name="create_by" id="create_by" readonly></td>
                            </tr>
                        </table>
                        <input type="hidden" name="status" value="approve">
                    </form>
                </div>
            </div>
            <!-- dialog buttons -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-info" onclick="event.preventDefault();document.getElementById('approve-form').submit();">Confirm</button>
            </div>
        </div>
    </div>
</div>

<!-- set up the modal to start hidden and fade in and out -->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">{{ trans('global.areYouSure') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- dialog body -->
            <div class="modal-body">
                <img class="container" id="img">
                <div class="container">
                    <form method="POST" id="reject-form">
                        @method('PUT')
                        @csrf
                        <table class="table table-hover table-bordered">
                            <tr>
                                <td>{{ trans('cruds.projectListing.fields.name') }}</td>
                                <td><input class="form-control" type="text" id="name" name="name" readonly></td>
                            </tr>
                            <tr>
                                <td>{{ trans('cruds.projectListing.fields.type') }}</td>
                                <td><input class="form-control" type="text" name="type" id="type" readonly></td>
                            </tr>
                            <tr>
                                <td>{{ trans('cruds.projectListing.fields.address') }}</td>
                                <td><input class="form-control" type="text" name="address" id="address" readonly></td>
                            </tr>
                            <tr>
                                <td>{{ trans('cruds.projectListing.fields.tenure') }}</td>
                                <td><input class="form-control" type="text" name="tenure" id="tenure" readonly></td>
                            </tr>
                            <tr>
                                <td>{{ trans('cruds.projectListing.fields.completion_date') }}</td>
                                <td><input class="form-control" type="text" name="completion_date" id="completion_date" readonly></td>
                            </tr>
                            <tr>
                                <td>{{ trans('cruds.projectListing.fields.create_by') }}</td>
                                <td><input class="form-control" type="text" name="create_by" id="create_by" readonly></td>
                            </tr>
                        </table>
                        <input type="hidden" name="status" value="reject">
                    </form>
                </div>
            </div>
            <!-- dialog buttons -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-info" onclick="event.preventDefault();document.getElementById('reject-form').submit();">Confirm</button>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
@parent
<script>
    $(function () {
        var firstTime = true;
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('project_listing_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.project-listings.massDestroy') }}",
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
        pageLength: localStorage.getItem("projectListing") ? JSON.parse(localStorage.getItem("projectListing"))['length'] ? JSON.parse(localStorage.getItem("projectListing"))['length'] :10 : 10,
        search :{
            regex : true,
        },
        bSort: false,
        orderCellsTop: true,
        ajax: {
            url: "{{ route('admin.project-listings.index') }}",
            data: function(d) {

                if (localStorage.getItem("projectListing") && firstTime) {
                    var projectListing = JSON.parse(localStorage.getItem("projectListing"));

                    var page = projectListing['page'] ? projectListing['page'] : 0;
                    var length = projectListing['length'] ? projectListing['length'] : 10;

                    d.start = page * length;
                }

                d.min_date = moment($('#min-date').val()).format('YYYY-MM-DD');
                d.max_date = moment($('#max-date').val()).format('YYYY-MM-DD');
            }
        },
        initComplete: function(settings, json) {
            if (localStorage.getItem("projectListing")) {
                var projectListing = JSON.parse(localStorage.getItem("projectListing"));
                if (projectListing['page']) {
                    const api = $.fn.dataTable.Api(settings);
                    api.page(projectListing['page']).draw(false);
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
            { data: 'project_code', name: 'project_code' },
            { data: 'name', name: 'name' },
            { data: 'type_type', name: 'type.type' },
            { data: 'address', name: 'address' },
            { data: 'developer_company_name', name: 'developer.company_name' },
            { data: 'tenure', name: 'tenure' },
            { data: 'completion_date', name: 'completion_date' },
            { data: 'status', name: 'status' },
            { data: 'sales_gallery', name: 'sales_gallery' },
            { data: 'website', name: 'website' },
            { data: 'fb', name: 'fb' },
            { data: 'block', name: 'block' },
            { data: 'unit', name: 'unit' },
            { data: 'is_new', name: 'is_new' },
            { data: 'area_area', name: 'area.area' },
            { data: 'pic_name', name: 'pic.name' },
            { data: 'create_by', name: 'user.name' },
            { data: 'actions', name: '{{ trans('global.actions') }}' }
        ],
    };
    let table = $('.datatable-ProjectListing').DataTable(dtOverrideGlobals);
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });

        $('.datatable-ProjectListing').on( 'page.dt', function () {
            datatable_set_page_and_length();
        });

        $('.datatable-ProjectListing').on( 'length.dt', function ( e, settings, len ) {
            datatable_set_page_and_length();
        });

        function datatable_set_page_and_length() {
            var info = table.page.info();

            if (localStorage.getItem("projectListing")) {
                var projectListing = JSON.parse(localStorage.getItem("projectListing"));
            }

            projectListing['page'] = info.page;
            projectListing['length'] = info.length;

            localStorage.setItem("projectListing", JSON.stringify(projectListing));
        }

        $("#refresh_button").click(function() {
            reset_reload_button();
        })

        var doUpdate = function() {
            if ($('#refresh').is(':checked')) {
                var count = parseInt($('#countdown_number').html());
                if (count !== 0) {
                    $('#countdown_number').html(count - 1);
                } else {
                    reset_reload_button();
                }
            }
        };

        function reset_reload_button() {
            $('.btn_controller').prop('disabled', true);
            $('#countdown_number').html(15);
            table.ajax.reload(null, false);
        }

        setInterval(doUpdate, 1000);

        $('#search #tenure').select2({
            multiple: true,
            placeholder: "{{ trans('cruds.projectListing.fields.tenure') }}",
            allowClear: true
        });

        var today = moment();

        $('#min-date').change(function() {
            var min = moment($('#min-date').val());
            var max = moment($('#max-date').val());

            if (min.isAfter(today, 'days')) {
                $('#min-date').val(today.format("YYYY-MM-DD"))
                alert('Cannot choose over today')
            }

            if (min.isAfter(max, 'days') && min) {
                $('#max-date').val($('#min-date').val())
            }
        });
        $('#max-date').change(function() {
            var min = moment($('#min-date').val());
            var max = moment($('#max-date').val());

            // if (max.isAfter(today, 'days')) {
            //     $('#max-date').val(today.format("YYYY-MM-DD"))
            //     alert('cannot choose over today')
            // }

            if (max.isBefore(min, 'days') && max) {
                $('#min-date').val($('#max-date').val())
            }
        });

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
            // set min date / max date default value
            $('#min-date').val(moment().format("YYYY-MM-DD"));
            $('#max-date').val(moment().format("YYYY-MM-DD"));

            $('#search #project_code').val('');
            $('#search #name').val('');
            $('#search #type').val('');
            $('#search #address').val('');
            $('#search #developer').val('');
            $('#search #area').val('');
            $('#search #pic').val('');

            $('#search #tenure').val('All').trigger('change');
        }

        function Default() {
            if (localStorage.getItem("projectListing")) {
                var searching = JSON.parse(localStorage.getItem("projectListing"));

                // set min date / max date default value
                $('#search #min-date').val(searching['min-date'] ? searching['min-date'] : moment().format("YYYY-MM-DD"));
                $('#search #max-date').val(searching['max-date'] ? searching['max-date'] : moment().format("YYYY-MM-DD"));

                $('#search #project_code').val(searching['project_code'] ? searching['project_code'] : '');
                $('#search #name').val(searching['name'] ? searching['name'] : '');
                $('#search #type').val(searching['type'] ? searching['type'] : '');
                $('#search #address').val(searching['address'] ? searching['address'] : '');
                $('#search #developer').val(searching['developer'] ? searching['developer'] : '');
                $('#search #area').val(searching['area'] ? searching['area'] : '');
                $('#search #pic').val(searching['pic'] ? searching['pic'] : '');

                $('#search #tenure').val(searching['tenure'] ? searching['tenure'] : 'All').trigger('change');

                Searching();
            } else {
                Reset();
                Searching();
            }
        }

        Default();

        function Searching() {
            table.ajax.reload();

            var project_code = $('#search #project_code').val();
            table
                .columns(2)
                .search(project_code)
                .draw();

            var name = $('#search #name').val();
            table
                .columns(3)
                .search(name)
                .draw();

            var type = $('#search #type').val();
            table
                .columns(4)
                .search(type)
                .draw();

            var address = $('#search #address').val();
            table
                .columns(5)
                .search(address)
                .draw();

            var developer = $('#search #developer').val();
            table
                .columns(6)
                .search(developer)
                .draw();

            var tenure = $('#search #tenure').val();
            if(jQuery.inArray("All", tenure) === -1) {
                searchingFunction(tenure, 7);
            } else {
                table
                    .columns(7)
                    .search('',true,false)
                    .draw();
            }

            var area = $('#search #area').val();
            table
                .columns(15)
                .search(area)
                .draw();

            var pic = $('#search #pic').val();
            table
                .columns(16)
                .search(pic)
                .draw();

            var projectListing = {
                'project_code'  : project_code,
                'name'          : name,
                'type'          : type,
                'address'       : address,
                'developer'     : developer,
                'tenure'        : tenure,
                'area'          : area,
                'pic'           : pic,
                'min-date'      : $('#min-date').val(),
                'max-date'      : $('#max-date').val()
            };

            if (localStorage.getItem("projectListing") && firstTime) {
                var projectListing = JSON.parse(localStorage.getItem("projectListing"));

                var page = projectListing['page'] ? projectListing['page'] : 0;
                var length = projectListing['length'] ? projectListing['length'] : 10;

                projectListing['page'] = page;
                projectListing['length'] = length;
            }

            localStorage.setItem("projectListing", JSON.stringify(projectListing));
        }

        $('#search_form_submit').on('click', function(e) {
            e.preventDefault();

            $('.btn_controller').prop('disabled', true);

            Searching();
        })

});

</script>

<script>
    $('#approveModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);    // Button that triggered the modal
        var data = button.data('row');          // Extract info from data-* attributes
        var img = button.data('img');
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this);
        // set image
        modal.find('.modal-body #img').attr('src', img);
        // set action
        var action = "{{ route('admin.project-listings.approve_project', 'id') }}";
        modal.find('.modal-body #approve-form').attr('action', action.replace('id', data.id));
        // set data
        modal.find('.modal-body #name').val(data.name);
        modal.find('.modal-body #type').val(data.type);
        modal.find('.modal-body #address').val(data.address);
        modal.find('.modal-body #tenure').val(data.tenure);
        modal.find('.modal-body #completion_date').val(data.completion_date);
        modal.find('.modal-body #create_by').val(data.create_by);
    });
</script>
<script>
    $('#rejectModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);    // Button that triggered the modal
        var data = button.data('row');          // Extract info from data-* attributes
        var img = button.data('img');
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this);
        // set image
        modal.find('.modal-body #img').attr('src', img);
        // set action
        var action = "{{ route('admin.project-listings.approve_project', 'id') }}";
        modal.find('.modal-body #reject-form').attr('action', action.replace('id', data.id));
        // set data
        modal.find('.modal-body #name').val(data.name);
        modal.find('.modal-body #type').val(data.type);
        modal.find('.modal-body #address').val(data.address);
        modal.find('.modal-body #tenure').val(data.tenure);
        modal.find('.modal-body #completion_date').val(data.completion_date);
        modal.find('.modal-body #create_by').val(data.create_by);
    });
</script>

@endsection
