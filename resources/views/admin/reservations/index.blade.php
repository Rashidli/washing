@include('admin.includes.header')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Reservations list!</h4>
                    <p class="mb-0">Washing dashboard template</p>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('admin_dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Reservations</a></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Reservations Datatable</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="display" style="min-width: 845px">
                                <thead>
                                <tr>
                                    <th>Reservation id</th>
                                    <th>User name</th>
                                    <th>Washing name</th>
                                    <th>Vehicle type</th>
                                    <th>Service type</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($reservations as $reservation)
                                    <tr style="color: #593bdb;">
                                        <td>{{$reservation->id}}</td>
                                        <td>{{$reservation->name}}</td>
                                        <td>{{$reservation->washing_name}}</td>
                                        <td>{{$reservation->vehicle_type}}</td>
                                        <td>{{$reservation->service_type}}</td>
                                        <td>@if($reservation->cancel == 0)
                                                active
                                            @else
                                            deactive
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Washing name</th>
                                    <th>Owner name</th>
                                    <th>Owner phone</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                    <th>Status</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('admin.includes.footer')
