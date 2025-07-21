<div class="nav nav-tabs master-tab-section" id="nav-tab" role="tablist">
    <a href="{{route("vehicle.index")}}" class="nav-item nav-link {{Request::route()->getName()=='vehicle.index'?'active':''}}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('assets/backend/app-assets/icon/vehicle-icon.png')}}" alt="" srcset="" class="img-fluid" width="100">
        </div>
        <div class="text-center"> Vehicle</div>
    </a>
    <a href="{{route('vehicle-service')}}" class="nav-item nav-link {{Request::route()->getName()=='vehicle-service'?'active':''}}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('assets/backend/app-assets/icon/service-icon.png')}}" alt="" srcset="" class="img-fluid" width="55">
        </div>
        <div>&nbsp;&nbsp;&nbsp;&nbsp; Service &nbsp;&nbsp;&nbsp;&nbsp;</div>
    </a>
    <a href="{{route("driver.index")}}" class="nav-item nav-link {{Request::route()->getName()=='driver.index'?'active':''}}"" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('assets/backend/app-assets/icon/employee-icon.png')}}" alt="" srcset="" class="img-fluid" width="55">
        </div>
        <div>&nbsp;&nbsp;&nbsp; Driver &nbsp;&nbsp;&nbsp;</div>
    </a>
    <a href="{{route("material.index")}}" class="nav-item nav-link {{Request::route()->getName()=='material.index'?'active':''}}"" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('assets/backend/app-assets/icon/truck-icon.png')}}" alt="" srcset="" class="img-fluid" width="55">
        </div>
        <div> &nbsp;&nbsp;Material &nbsp;&nbsp;</div>
    </a>
    <a href="{{route("crusher.index")}}" class="nav-item nav-link {{Request::route()->getName()=='crusher.index'?'active':''}}"" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('assets/backend/app-assets/icon/collection-icon.png')}}" alt="" srcset="" class="img-fluid" width="55">
        </div>
        <div>&nbsp;&nbsp; Source &nbsp;&nbsp;</div>
    </a>
    <a href="{{route("destination.index")}}" class="nav-item nav-link {{Request::route()->getName()=='destination.index'?'active':''}}"" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('assets/backend/app-assets/icon/collection-head-icon.png')}}" alt="" srcset="" class="img-fluid" width="55">
        </div>
        <div>Destination</div>
    </a>
    <a href="{{route('rate.index')}}" class="nav-item nav-link {{Request::route()->getName()=='rate.index'?'active':''}}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('assets/backend/app-assets/icon/business-icon.png')}}" alt="" srcset="" class="img-fluid" width="65">
        </div>
        <div>&nbsp;&nbsp; &nbsp; Route &nbsp; &nbsp;&nbsp;</div>
    </a>
    
</div>