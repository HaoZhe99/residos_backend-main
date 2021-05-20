<style>
    .dataTables_wrapper .dataTables_processing {
        z-index: 10;
        background: rgba(255, 255, 255, 0.9);
        border: none;
        border-radius: 3px;
    }

@keyframes spinner {
    to {transform: rotate(360deg);}
}

.spinner:before {
    content: '';
    box-sizing: border-box;
    position: absolute;
    top: 50%;
    left: 50%;
    width: 20px;
    height: 20px;
    margin-top: -10px;
    margin-left: -10px;
    border-radius: 50%;
    border: 2px solid #ccc;
    border-top-color: #333;
    animation: spinner .6s linear infinite;
}
</style>

<div id="sidebar" class="c-sidebar c-sidebar-fixed c-sidebar-lg-show">

    <div class="c-sidebar-brand d-md-down-none">
        <a class="c-sidebar-brand-full h4" href="#">
            {{ trans('panel.site_title') }}
        </a>
    </div>

    <ul class="c-sidebar-nav">
        <li class="c-sidebar-nav-item">
            <a href="{{ route("admin.home") }}" class="c-sidebar-nav-link">
                <i class="c-sidebar-nav-icon fas fa-fw fa-tachometer-alt">

                </i>
                {{ trans('global.dashboard') }}
            </a>
        </li>
        @can('resident_management_access')
            <li class="c-sidebar-nav-dropdown">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.residentManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('unit_access')
                        <li class="c-sidebar-nav-dropdown {{ request()->is("admin/unit-mangements*") ? "c-show" : "" }} {{ request()->is("admin/add-units*") ? "c-show" : "" }} {{ request()->is("admin/add-blocks*") ? "c-show" : "" }}">
                            <a class="c-sidebar-nav-dropdown-toggle" href="#">
                                <i class="fa-fw fas fa-home c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.unit.title') }}
                            </a>
                            <ul class="c-sidebar-nav-dropdown-items">
                                @can('unit_mangement_access')
                                    <li class="c-sidebar-nav-item">
                                        <a href="{{ route("admin.unit-mangements.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/unit-mangements") || request()->is("admin/unit-mangements/*") ? "c-active" : "" }}">
                                            <i class="fa-fw fas fa-home c-sidebar-nav-icon">

                                            </i>
                                            {{ trans('cruds.unitMangement.title') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('add_unit_access')
                                    <li class="c-sidebar-nav-item">
                                        <a href="{{ route("admin.add-units.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/add-units") || request()->is("admin/add-units/*") ? "c-active" : "" }}">
                                            <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                            </i>
                                            {{ trans('cruds.addUnit.title') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('add_block_access')
                                    <li class="c-sidebar-nav-item">
                                        <a href="{{ route("admin.add-blocks.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/add-blocks") || request()->is("admin/add-blocks/*") ? "c-active" : "" }}">
                                            <i class="fa-fw fas fa-plus-circle c-sidebar-nav-icon">

                                            </i>
                                            {{ trans('cruds.addBlock.title') }}
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
                    @can('access_management_access')
                        <li class="c-sidebar-nav-dropdown {{ request()->is("admin/vehicle-logs*") ? "c-show" : "" }} {{ request()->is("admin/locations*") ? "c-show" : "" }} {{ request()->is("admin/gateways*") ? "c-show" : "" }} {{ request()->is("admin/qrs*") ? "c-show" : "" }} {{ request()->is("admin/gate-histories*") ? "c-show" : "" }}">
                            <a class="c-sidebar-nav-dropdown-toggle" href="#">
                                <i class="fa-fw fas fa-sign-in-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.accessManagement.title') }}
                            </a>
                            <ul class="c-sidebar-nav-dropdown-items">
                                @can('vehicle_log_access')
                                    <li class="c-sidebar-nav-item">
                                        <a href="{{ route("admin.vehicle-logs.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/vehicle-logs") || request()->is("admin/vehicle-logs/*") ? "c-active" : "" }}">
                                            <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                            </i>
                                            {{ trans('cruds.vehicleLog.title') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('location_access')
                                    <li class="c-sidebar-nav-item">
                                        <a href="{{ route("admin.locations.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/locations") || request()->is("admin/locations/*") ? "c-active" : "" }}">
                                            <i class="fa-fw fas fa-map-pin c-sidebar-nav-icon">

                                            </i>
                                            {{ trans('cruds.location.title') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('gateway_access')
                                    <li class="c-sidebar-nav-item">
                                        <a href="{{ route("admin.gateways.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/gateways") || request()->is("admin/gateways/*") ? "c-active" : "" }}">
                                            <i class="fa-fw fas fa-door-closed c-sidebar-nav-icon">

                                            </i>
                                            {{ trans('cruds.gateway.title') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('qr_access')
                                    <li class="c-sidebar-nav-item">
                                        <a href="{{ route("admin.qrs.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/qrs") || request()->is("admin/qrs/*") ? "c-active" : "" }}">
                                            <i class="fa-fw fas fa-qrcode c-sidebar-nav-icon">

                                            </i>
                                            {{ trans('cruds.qr.title') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('gate_history_access')
                                    <li class="c-sidebar-nav-item">
                                        <a href="{{ route("admin.gate-histories.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/gate-histories") || request()->is("admin/gate-histories/*") ? "c-active" : "" }}">
                                            <i class="fa-fw fas fa-history c-sidebar-nav-icon">

                                            </i>
                                            {{ trans('cruds.gateHistory.title') }}
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
                    @can('facility_management_access')
                        <li class="c-sidebar-nav-dropdown {{ request()->is("admin/facility-listings*") ? "c-show" : "" }} {{ request()->is("admin/facility-books*") ? "c-show" : "" }} {{ request()->is("admin/facility-maintains*") ? "c-show" : "" }}">
                            <a class="c-sidebar-nav-dropdown-toggle" href="#">
                                <i class="fa-fw fas fa-swimming-pool c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.facilityManagement.title') }}
                            </a>
                            <ul class="c-sidebar-nav-dropdown-items">
                                @can('facility_listing_access')
                                    <li class="c-sidebar-nav-item">
                                        <a href="{{ route("admin.facility-listings.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/facility-listings") || request()->is("admin/facility-listings/*") ? "c-active" : "" }}">
                                            <i class="fa-fw fas fa-bars c-sidebar-nav-icon">

                                            </i>
                                            {{ trans('cruds.facilityListing.title') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('facility_book_access')
                                    <li class="c-sidebar-nav-item">
                                        <a href="{{ route("admin.facility-books.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/facility-books") || request()->is("admin/facility-books/*") ? "c-active" : "" }}">
                                            <i class="fa-fw far fa-calendar-plus c-sidebar-nav-icon">

                                            </i>
                                            {{ trans('cruds.facilityBook.title') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('facility_maintain_access')
                                    <li class="c-sidebar-nav-item">
                                        <a href="{{ route("admin.facility-maintains.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/facility-maintains") || request()->is("admin/facility-maintains/*") ? "c-active" : "" }}">
                                            <i class="fa-fw fas fa-wrench c-sidebar-nav-icon">

                                            </i>
                                            {{ trans('cruds.facilityMaintain.title') }}
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
                    @can('defect_management_access')
                        <li class="c-sidebar-nav-dropdown {{ request()->is("admin/defect-categories*") ? "c-show" : "" }} {{ request()->is("admin/status-controls*") ? "c-show" : "" }} {{ request()->is("admin/defect-listings*") ? "c-show" : "" }}">
                            <a class="c-sidebar-nav-dropdown-toggle" href="#">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.defectManagement.title') }}
                            </a>
                            <ul class="c-sidebar-nav-dropdown-items">
                                @can('defect_category_access')
                                    <li class="c-sidebar-nav-item">
                                        <a href="{{ route("admin.defect-categories.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/defect-categories") || request()->is("admin/defect-categories/*") ? "c-active" : "" }}">
                                            <i class="fa-fw fas fa-unlink c-sidebar-nav-icon">

                                            </i>
                                            {{ trans('cruds.defectCategory.title') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('status_control_access')
                                    <li class="c-sidebar-nav-item">
                                        <a href="{{ route("admin.status-controls.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/status-controls") || request()->is("admin/status-controls/*") ? "c-active" : "" }}">
                                            <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                            </i>
                                            {{ trans('cruds.statusControl.title') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('defect_listing_access')
                                    <li class="c-sidebar-nav-item">
                                        <a href="{{ route("admin.defect-listings.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/defect-listings") || request()->is("admin/defect-listings/*") ? "c-active" : "" }}">
                                            <i class="fa-fw fas fa-list c-sidebar-nav-icon">

                                            </i>
                                            {{ trans('cruds.defectListing.title') }}
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
                    @can('car_park_management_access')
                        <li class="c-sidebar-nav-dropdown {{ request()->is("admin/vehicle-managements*") ? "c-show" : "" }} {{ request()->is("admin/carparklocations*") ? "c-show" : "" }}">
                            <a class="c-sidebar-nav-dropdown-toggle" href="#">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.carParkManagement.title') }}
                            </a>
                            <ul class="c-sidebar-nav-dropdown-items">
                                @can('vehicle_management_access')
                                    <li class="c-sidebar-nav-item">
                                        <a href="{{ route("admin.vehicle-managements.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/vehicle-managements") || request()->is("admin/vehicle-managements/*") ? "c-active" : "" }}">
                                            <i class="fa-fw fas fa-car c-sidebar-nav-icon">

                                            </i>
                                            {{ trans('cruds.vehicleManagement.title') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('carparklocation_access')
                                    <li class="c-sidebar-nav-item">
                                        <a href="{{ route("admin.carparklocations.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/carparklocations") || request()->is("admin/carparklocations/*") ? "c-active" : "" }}">
                                            <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                            </i>
                                            {{ trans('cruds.carparklocation.title') }}
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
                    @can('family_control_access')
                        <li class="c-sidebar-nav-dropdown {{ request()->is("admin/family-controls*") ? "c-show" : "" }}">
                            <a class="c-sidebar-nav-dropdown-toggle" href="#">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                Family Management
                            </a>
                            <ul class="c-sidebar-nav-dropdown-items">
                                @can('family_control_access')
                                    <li class="c-sidebar-nav-item">
                                        <a href="{{ route("admin.family-controls.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/family-controls") || request()->is("admin/family-controls/*") ? "c-active" : "" }}">
                                            <i class="fa-fw fas fa-car c-sidebar-nav-icon">

                                            </i>
                                            Family Control
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
                    @can('tenant_control_access')
                        <li class="c-sidebar-nav-dropdown {{ request()->is("admin/tenant-controls*") ? "c-show" : "" }}">
                            <a class="c-sidebar-nav-dropdown-toggle" href="#">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                Tenant Management
                            </a>
                            <ul class="c-sidebar-nav-dropdown-items">
                                @can('tenant_control_access')
                                    <li class="c-sidebar-nav-item">
                                        <a href="{{ route("admin.tenant-controls.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/tenant-controls") || request()->is("admin/tenant-controls/*") ? "c-active" : "" }}">
                                            <i class="fa-fw fas fa-car c-sidebar-nav-icon">

                                            </i>
                                            Tenant Control
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
                    @can('visitor_control_access')
                        <li class="c-sidebar-nav-dropdown {{ request()->is("admin/visitor-controls*") ? "c-show" : "" }}">
                            <a class="c-sidebar-nav-dropdown-toggle" href="#">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.visitorManagement.title') }}
                            </a>
                            <ul class="c-sidebar-nav-dropdown-items">
                                @can('visitor_control_access')
                                    <li class="c-sidebar-nav-item">
                                        <a href="{{ route("admin.visitor-controls.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/visitor-controls") || request()->is("admin/visitor-controls/*") ? "c-active" : "" }}">
                                            <i class="fa-fw fas fa-users c-sidebar-nav-icon">

                                            </i>
                                            {{ trans('cruds.visitorControl.title') }}
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
                    @can('water_utility_payment_access')
                        <li class="c-sidebar-nav-dropdown {{ request()->is("admin/water-utility-payments*") ? "c-show" : "" }}">
                            <a class="c-sidebar-nav-dropdown-toggle" href="#">
                                <i class="fa-fw fas fa-tint c-sidebar-nav-icon">

                                </i>
                                Water Utility Management
                            </a>
                            <ul class="c-sidebar-nav-dropdown-items">
                                @can('water_utility_payment_access')
                                    <li class="c-sidebar-nav-item">
                                        <a href="{{ route("admin.water-utility-payments.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/water-utility-payments") || request()->is("admin/water-utility-payments/*") ? "c-active" : "" }}">
                                            <i class="fa-fw fas fa-dollar-sign c-sidebar-nav-icon">

                                            </i>
                                            Water Utility Payment
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('rent_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/rents*") ? "c-show" : "" }} {{ request()->is("admin/amenities*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.tenantRelationship.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('rent_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.rents.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/rents") || request()->is("admin/rents/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-warehouse c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.rent.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('amenity_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.amenities.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/amenities") || request()->is("admin/amenities/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-swimmer c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.amenity.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('e_billing_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/e-bill-listings*") ? "c-show" : "" }} {{ request()->is("admin/transactions*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-dollar-sign c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.eBilling.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('e_bill_listing_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.e-bill-listings.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/e-bill-listings") || request()->is("admin/e-bill-listings/*") ? "c-active" : "" }}">
                                <i class="fa-fw far fa-money-bill-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.eBillListing.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('transaction_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.transactions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/transactions") || request()->is("admin/transactions/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.transaction.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('event_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/event-categories*") ? "c-show" : "" }} {{ request()->is("admin/event-listings*") ? "c-show" : "" }} {{ request()->is("admin/event-enrolls*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw far fa-calendar c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.event.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('event_category_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.event-categories.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/event-categories") || request()->is("admin/event-categories/*") ? "c-active" : "" }}">
                                <i class="fa-fw far fa-calendar c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.eventCategory.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('event_listing_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.event-listings.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/event-listings") || request()->is("admin/event-listings/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.eventListing.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('event_enroll_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.event-enrolls.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/event-enrolls") || request()->is("admin/event-enrolls/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-users c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.eventEnroll.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('project_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/developer-listings*") ? "c-show" : "" }} {{ request()->is("admin/project-listings*") ? "c-show" : "" }} {{ request()->is("admin/pics*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-door-open c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.project.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('developer_listing_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.developer-listings.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/developer-listings") || request()->is("admin/developer-listings/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.developerListing.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('project_listing_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.project-listings.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/project-listings") || request()->is("admin/project-listings/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.projectListing.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('pic_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.pics.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/pics") || request()->is("admin/pics/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.pic.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('user_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/users*") ? "c-show" : "" }} {{ request()->is("admin/audit-logs*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-users c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.userManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('user_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.users.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/users") || request()->is("admin/users/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.user.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('audit_log_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.audit-logs.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/audit-logs") || request()->is("admin/audit-logs/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-file-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.auditLog.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('feedback_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/feedback-categories*") ? "c-show" : "" }} {{ request()->is("admin/feedback-listings*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw far fa-comments c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.feedback.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('feedback_category_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.feedback-categories.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/feedback-categories") || request()->is("admin/feedback-categories/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.feedbackCategory.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('feedback_listing_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.feedback-listings.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/feedback-listings") || request()->is("admin/feedback-listings/*") ? "c-active" : "" }}">
                                <i class="fa-fw far fa-comment-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.feedbackListing.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('content_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/content-listings*") ? "c-show" : "" }} {{ request()->is("admin/content-types*") ? "c-show" : "" }} {{ request()->is("admin/notice-boards*") ? "c-show" : "" }} {{ request()->is("admin/notifications*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.content.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('content_listing_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.content-listings.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/content-listings") || request()->is("admin/content-listings/*") ? "c-active" : "" }}">
                                <i class="fa-fw far fa-file-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.contentListing.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('content_type_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.content-types.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/content-types") || request()->is("admin/content-types/*") ? "c-active" : "" }}">
                                <i class="fa-fw far fa-file c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.contentType.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('notice_board_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.notice-boards.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/notice-boards") || request()->is("admin/notice-boards/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.noticeBoard.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('notification_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.notifications.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/notifications") || request()->is("admin/notifications/*") ? "c-active" : "" }}">
                                <i class="fa-fw far fa-bell c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.notification.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('setting_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/generals*") ? "c-show" : "" }} {{ request()->is("admin/designs*") ? "c-show" : "" }} {{ request()->is("admin/seos*") ? "c-show" : "" }} {{ request()->is("admin/payment-settings*") ? "c-show" : "" }} {{ request()->is("admin/advance-settings*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.setting.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('general_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.generals.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/generals") || request()->is("admin/generals/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.general.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('design_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.designs.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/designs") || request()->is("admin/designs/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-pen c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.design.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('seo_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.seos.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/seos") || request()->is("admin/seos/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.seo.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('application_access')
                        <li class="c-sidebar-nav-dropdown {{ request()->is("admin/user-applications*") ? "c-show" : "" }} {{ request()->is("admin/admin-applications*") ? "c-show" : "" }} {{ request()->is("admin/sms-settings*") ? "c-show" : "" }} {{ request()->is("admin/e-mail-settings*") ? "c-show" : "" }} {{ request()->is("admin/social-logins*") ? "c-show" : "" }} {{ request()->is("admin/notification-settings*") ? "c-show" : "" }}">
                            <a class="c-sidebar-nav-dropdown-toggle" href="#">
                                <i class="fa-fw fas fa-rocket c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.application.title') }}
                            </a>
                            <ul class="c-sidebar-nav-dropdown-items">
                                @can('user_application_access')
                                    <li class="c-sidebar-nav-item">
                                        <a href="{{ route("admin.user-applications.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/user-applications") || request()->is("admin/user-applications/*") ? "c-active" : "" }}">
                                            <i class="fa-fw far fa-user c-sidebar-nav-icon">

                                            </i>
                                            {{ trans('cruds.userApplication.title') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('admin_application_access')
                                    <li class="c-sidebar-nav-item">
                                        <a href="{{ route("admin.admin-applications.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/admin-applications") || request()->is("admin/admin-applications/*") ? "c-active" : "" }}">
                                            <i class="fa-fw fas fa-toolbox c-sidebar-nav-icon">

                                            </i>
                                            {{ trans('cruds.adminApplication.title') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('sms_setting_access')
                                    <li class="c-sidebar-nav-item">
                                        <a href="{{"/admin/sms-settings/1/edit"}}" class="c-sidebar-nav-link {{ request()->is("admin/sms-settings") || request()->is("admin/sms-settings/*") ? "c-active" : "" }}">
                                            <i class="fa-fw far fa-envelope c-sidebar-nav-icon">

                                            </i>
                                            {{ trans('cruds.smsSetting.title') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('e_mail_setting_access')
                                    <li class="c-sidebar-nav-item">
                                        <a href="{{ route("admin.e-mail-settings.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/e-mail-settings") || request()->is("admin/e-mail-settings/*") ? "c-active" : "" }}">
                                            <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                            </i>
                                            {{ trans('cruds.eMailSetting.title') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('social_login_access')
                                    <li class="c-sidebar-nav-item">
                                        <a href="{{ route("admin.social-logins.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/social-logins") || request()->is("admin/social-logins/*") ? "c-active" : "" }}">
                                            <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                            </i>
                                            {{ trans('cruds.socialLogin.title') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('notification_setting_access')
                                    <li class="c-sidebar-nav-item">
                                        <a href="{{ route("admin.notification-settings.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/notification-settings") || request()->is("admin/notification-settings/*") ? "c-active" : "" }}">
                                            <i class="fa-fw far fa-bell c-sidebar-nav-icon">

                                            </i>
                                            {{ trans('cruds.notificationSetting.title') }}
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
                    @can('area_setting_access')
                        <li class="c-sidebar-nav-dropdown {{ request()->is("admin/countries*") ? "c-show" : "" }} {{ request()->is("admin/states*") ? "c-show" : "" }} {{ request()->is("admin/areas*") ? "c-show" : "" }}">
                            <a class="c-sidebar-nav-dropdown-toggle" href="#">
                                <i class="fa-fw fas fa-globe-asia c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.areaSetting.title') }}
                            </a>
                            <ul class="c-sidebar-nav-dropdown-items">
                                @can('country_access')
                                    <li class="c-sidebar-nav-item">
                                        <a href="{{ route("admin.countries.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/countries") || request()->is("admin/countries/*") ? "c-active" : "" }}">
                                            <i class="fa-fw fas fa-flag c-sidebar-nav-icon">

                                            </i>
                                            {{ trans('cruds.country.title') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('state_access')
                                    <li class="c-sidebar-nav-item">
                                        <a href="{{ route("admin.states.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/states") || request()->is("admin/states/*") ? "c-active" : "" }}">
                                            <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                            </i>
                                            {{ trans('cruds.state.title') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('area_access')
                                    <li class="c-sidebar-nav-item">
                                        <a href="{{ route("admin.areas.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/areas") || request()->is("admin/areas/*") ? "c-active" : "" }}">
                                            <i class="fa-fw fas fa-thumbtack c-sidebar-nav-icon">

                                            </i>
                                            {{ trans('cruds.area.title') }}
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
                    @can('payment_method_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.payment-settings.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/payment-settings") || request()->is("admin/payment-settings/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.paymentSetting.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('resident_setting_access')
                        <li class="c-sidebar-nav-dropdown {{ request()->is("admin/facility-categories*") ? "c-show" : "" }} {{ request()->is("admin/defect-settings*") ? "c-show" : "" }}">
                            <a class="c-sidebar-nav-dropdown-toggle" href="#">
                                <i class="fa-fw fas fa-home c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.residentSetting.title') }}
                            </a>
                            <ul class="c-sidebar-nav-dropdown-items">
                                @can('facility_category_access')
                                    <li class="c-sidebar-nav-item">
                                        <a href="{{ route("admin.facility-categories.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/facility-categories") || request()->is("admin/facility-categories/*") ? "c-active" : "" }}">
                                            <i class="fa-fw fas fa-folder c-sidebar-nav-icon">

                                            </i>
                                            {{ trans('cruds.facilityCategory.title') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('defect_setting_access')
                                    <li class="c-sidebar-nav-item">
                                        <a href="{{ route("admin.defect-settings.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/defect-settings") || request()->is("admin/defect-settings/*") ? "c-active" : "" }}">
                                            <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                            </i>
                                            {{ trans('cruds.defectSetting.title') }}
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
                    @can('role_premission_access')
                        <li class="c-sidebar-nav-dropdown {{ request()->is("admin/permissions*") ? "c-show" : "" }} {{ request()->is("admin/roles*") ? "c-show" : "" }}">
                            <a class="c-sidebar-nav-dropdown-toggle" href="#">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.rolePremission.title') }}
                            </a>
                            <ul class="c-sidebar-nav-dropdown-items">
                                @can('permission_access')
                                    <li class="c-sidebar-nav-item">
                                        <a href="{{ route("admin.permissions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "c-active" : "" }}">
                                            <i class="fa-fw fas fa-unlock-alt c-sidebar-nav-icon">

                                            </i>
                                            {{ trans('cruds.permission.title') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('role_access')
                                    <li class="c-sidebar-nav-item">
                                        <a href="{{ route("admin.roles.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/roles") || request()->is("admin/roles/*") ? "c-active" : "" }}">
                                            <i class="fa-fw fas fa-briefcase c-sidebar-nav-icon">

                                            </i>
                                            {{ trans('cruds.role.title') }}
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
                    @can('project_setting_access')
                        <li class="c-sidebar-nav-dropdown {{ request()->is("admin/project-categories*") ? "c-show" : "" }} {{ request()->is("admin/project-types*") ? "c-show" : "" }}">
                            <a class="c-sidebar-nav-dropdown-toggle" href="#">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.projectSetting.title') }}
                            </a>
                            <ul class="c-sidebar-nav-dropdown-items">
                                @can('project_category_access')
                                    <li class="c-sidebar-nav-item">
                                        <a href="{{ route("admin.project-categories.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/project-categories") || request()->is("admin/project-categories/*") ? "c-active" : "" }}">
                                            <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                            </i>
                                            {{ trans('cruds.projectCategory.title') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('project_type_access')
                                    <li class="c-sidebar-nav-item">
                                        <a href="{{ route("admin.project-types.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/project-types") || request()->is("admin/project-types/*") ? "c-active" : "" }}">
                                            <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                            </i>
                                            {{ trans('cruds.projectType.title') }}
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
                    @can('vehicle_access')
                        <li class="c-sidebar-nav-dropdown {{ request()->is("admin/vehicle-brands*") ? "c-show" : "" }} {{ request()->is("admin/vehicle-models*") ? "c-show" : "" }}">
                            <a class="c-sidebar-nav-dropdown-toggle" href="#">
                                <i class="fa-fw fas fa-car c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.vehicle.title') }}
                            </a>
                            <ul class="c-sidebar-nav-dropdown-items">
                                @can('vehicle_brand_access')
                                    <li class="c-sidebar-nav-item">
                                        <a href="{{ route("admin.vehicle-brands.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/vehicle-brands") || request()->is("admin/vehicle-brands/*") ? "c-active" : "" }}">
                                            <i class="fa-fw fab fa-bimobject c-sidebar-nav-icon">

                                            </i>
                                            {{ trans('cruds.vehicleBrand.title') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('vehicle_model_access')
                                    <li class="c-sidebar-nav-item">
                                        <a href="{{ route("admin.vehicle-models.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/vehicle-models") || request()->is("admin/vehicle-models/*") ? "c-active" : "" }}">
                                            <i class="fa-fw fas fa-car c-sidebar-nav-icon">

                                            </i>
                                            {{ trans('cruds.vehicleModel.title') }}
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
                    @can('advance_setting_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.advance-settings.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/advance-settings") || request()->is("admin/advance-settings/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.advanceSetting.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('water_utility_setting_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.water-utility-settings.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/water-utility-settings") || request()->is("admin/water-utility-settings/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                Water Utility Setting
                            </a>
                        </li>
                    @endcan
                    @can('term_and_policy_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.term-and-policies.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/term-and-policies") || request()->is("admin/term-and-policies/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                Term And Policy
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('bank_account_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/bank-acc-listings*") ? "c-show" : "" }} {{ request()->is("admin/bank-names*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-university c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.bankAccount.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('bank_acc_listing_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.bank-acc-listings.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/bank-acc-listings") || request()->is("admin/bank-acc-listings/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-university c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.bankAccListing.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('bank_name_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.bank-names.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/bank-names") || request()->is("admin/bank-names/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.bankName.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('report_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.reports.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/reports") || request()->is("admin/reports/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-book-open c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.report.title') }}
                </a>
            </li>
        @endcan
        @php($unread = \App\Models\QaTopic::unreadCount())
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.messenger.index") }}" class="{{ request()->is("admin/messenger") || request()->is("admin/messenger/*") ? "c-active" : "" }} c-sidebar-nav-link">
                    <i class="c-sidebar-nav-icon fa-fw fa fa-envelope">

                    </i>
                    <span>{{ trans('global.messages') }}</span>
                    @if($unread > 0)
                        <strong>( {{ $unread }} )</strong>
                    @endif

                </a>
            </li>
            @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
                @can('profile_password_edit')
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'c-active' : '' }}" href="{{ route('profile.password.edit') }}">
                            <i class="fa-fw fas fa-key c-sidebar-nav-icon">
                            </i>
                            {{ trans('global.change_password') }}
                        </a>
                    </li>
                @endcan
            @endif
            <li class="c-sidebar-nav-item">
                <a href="#" class="c-sidebar-nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                    <i class="c-sidebar-nav-icon fas fa-fw fa-sign-out-alt">

                    </i>
                    {{ trans('global.logout') }}
                </a>
            </li>
    </ul>

</div>
