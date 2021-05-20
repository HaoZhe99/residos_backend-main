@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('cruds.report.title') }}
    </div>

    <div class="card-body">
        <form action="{{ route('admin.reports.detail') }}" method="GET" enctype="multipart/form-data">
            <div class="row" id="search">
                <div class="form-group col-12 col-lg-6 col-xl-4">
                    <div class="row" style="min-height: 64px;max-height: 64px;">
                        <div class="col-sm-3 d-flex align-items-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="keyword" id="Yesterday" value="Yesterday">
                                <label class="form-check-label" for="Yesterday">{{ trans('cruds.report.fields.yesterday') }}</label>
                            </div>
                        </div>
                        <div class="col-sm-3 d-flex align-items-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="keyword" id="Today" value="Today">
                                <label class="form-check-label" for="Today">{{ trans('cruds.report.fields.today') }}</label>
                            </div>
                        </div>
                        <div class="col-sm-3 d-flex align-items-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="keyword" id="Last_Week" value="last_week">
                                <label class="form-check-label" for="Last_Week">{{ trans('cruds.report.fields.last_week') }}</label>
                            </div>
                        </div>
                        <div class="col-sm-3 d-flex align-items-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="keyword" id="This_Week" value="this_week">
                                <label class="form-check-label" for="This_Week">{{ trans('cruds.report.fields.this_week') }}</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group col-12 col-lg-6 col-xl-4">
                    <div class="row" style="min-height: 64px;max-height: 64px;">
                        <div class="col-sm-3 d-flex align-items-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="keyword" id="Last_Month" value="last_month">
                                <label class="form-check-label" for="Last_Month">{{ trans('cruds.report.fields.last_month') }}</label>
                            </div>
                        </div>
                        <div class="col-sm-3 d-flex align-items-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="keyword" id="This_Month" value="this_month">
                                <label class="form-check-label" for="This_Month">{{ trans('cruds.report.fields.this_month') }}</label>
                            </div>
                        </div>
                        <div class="col-sm-3 d-flex align-items-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="keyword" id="Last_Year" value="last_year">
                                <label class="form-check-label" for="Last_Year">{{ trans('cruds.report.fields.last_year') }}</label>
                            </div>
                        </div>
                        <div class="col-sm-3 d-flex align-items-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="keyword" id="This_Year" value="this_year">
                                <label class="form-check-label" for="This_Year">{{ trans('cruds.report.fields.this_year') }}</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group col-12 col-lg-6 col-xl-4">
                    <label>{{ trans('cruds.report.fields.type') }}</label>
                    <select class="form-control" id="type" name="type" required>
                        <option></option>
                        <option value="eBilling">{{ trans('cruds.eBilling.title') }}</option>
                        <option value="transaction">{{ trans('cruds.transaction.title') }}</option>
                    </select>
                </div>
                <div class="form-group col-12 col-lg-6 col-xl-6">
                    <label>{{ trans('cruds.report.fields.date_range') }}</label>
                    <div class="input-group">
                        <input type="date" class="form-control date-range-filter" name="min_date" id="min-date" required>
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="fas fa-chevron-right"></i>
                            </span>
                        </div>
                        <input type="date" class="form-control date-range-filter" name="max_date" id="max-date" required>
                    </div>
                </div>
                <div class="form-group col-12 col-lg-6 align-self-end">
                    <button type="submit" id="search_form_submit" class="btn btn-primary">
                        {{ trans('global.generate') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
@parent
<script>
    $(function () {
        var today = moment();

        $('#min-date').change(function() {
            var min = moment($('#min-date').val());
            var max = moment($('#max-date').val());

            if (min.isAfter(today, 'days')) {
                $('#min-date').val(today.format("YYYY-MM-DD"))
                alert('cannot choose over today')
            }

            if (min.isAfter(max, 'days') && min) {
                $('#max-date').val($('#min-date').val())
            }
        });

        $('#max-date').change(function() {
            var min = moment($('#min-date').val());
            var max = moment($('#max-date').val());

            if (max.isBefore(min, 'days') && max) {
                $('#min-date').val($('#max-date').val())
            }
        });
    });
</script>
<script>
	$('input[type="checkbox"]').on('change', function() {
	    $('input[type="checkbox"]').not(this).prop('checked', false);
	});

	$('input[type="checkbox"]').change(function () {
	    $("#max-date").prop("disabled",$(this).is(':checked'));
	    $("#min-date").prop("disabled",$(this).is(':checked'));
	    $('#max-date').val('');
	    $('#min-date').val('');
	});
</script>
@endsection