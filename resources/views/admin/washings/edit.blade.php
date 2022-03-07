@include('admin.includes.header')

<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>{{$washing->washing_name}}</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('washing')}}">Car washings</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">{{$washing->washing_name}}</a></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <form action="{{route('washing_update', $washing->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Washing name</label>
                        <div class="col-sm-10">
                            <input type="text" value="{{$washing->washing_name}}" name="washing_name" class="form-control" placeholder="Washing name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Owner name</label>
                        <div class="col-sm-10">
                            <input type="text" value="{{$washing->owner_name}}" name="owner_name" class="form-control" placeholder="Owner name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Owner phone</label>
                        <div class="col-sm-10">
                            <input type="text" value="{{$washing->owner_tel}}" name="owner_tel" class="form-control" placeholder="Owner phone">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Washing address</label>
                        <div class="col-sm-10">
                            <input type="text" name="address" value="{{$washing->address}}" class="form-control" placeholder="Washing address">
                        </div>
                    </div>
                    <fieldset class="form-group">
                        <div class="row">
                            <label class="col-form-label col-sm-2 pt-0">Status</label>
                            <div class="col-sm-10">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" value="1"
                                    @if($washing->status == 1)
                                        checked
                                           @else

                                        @endif
                                        >
                                    <label class="form-check-label">
                                        Active
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" value="0"
                                           @if($washing->status == 0)
                                    checked
                                    @else

                                        @endif >
                                    <label class="form-check-label">
                                        Not active
                                    </label>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-10">
                            <img src="{{asset($washing->image)}}" alt="" width="50px" height="50px">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Washing image</label>
                        <div class="col-sm-10">
                            <input type="file" name="image" class="form-control" placeholder="Washing image">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

@include('admin.includes.footer')
