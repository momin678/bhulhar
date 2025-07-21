
@if (isset($attendances) && count($attendances)>0)
<div class="row" id="table-bordered">
    <div class="col-12">
        <div class="cardStyleChange">
            <div class="card-header">
                <h4 class="card-title">Update Student Attendance</h4>

            </div>
            <div class="card-body">
                <form action="{{ route('update_st_attend')}}" method="POST">
                    @csrf
                    <p class="text-right">
                        <button type="button" class="btn btn-success present-all ">Present All</button>
                        <button type="button" class="btn btn-danger absent-all">Absent All</button>
                    </p>

                    <!-- table bordered -->
                    <div class="table-responsive">
                        <table class="table mb-0 table-sm table-hover">
                            <thead  class="thead-light">
                                <tr style="height: 50px;">
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Late Time</th>
                                    <th>Reason</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($attendances as $key => $attendance)

                                <tr class="trFontSize border-bottom">
                                <td>{{ $attendance->student->fname.' '.$attendance->student->mname }}
                                    <input type="hidden" name="attendance_id[]" value="{{$attendance->id}}">
                                </td>
                                <td>
                                    <ul class="list-unstyled mb-0">

                                        <li class="d-inline-block pr-2">
                                            <fieldset>
                                                <div class="radio set-time-reason">
                                                    <input type="radio" class="present-status" name="status[{{$key}}]" id="present-{{$attendance->id}}" value="1" {{$attendance->status==1 ? 'checked': ''}} >
                                                    <label for="present-{{$attendance->id}}">P</label>
                                                </div>
                                            </fieldset>
                                        </li>
                                        <li class="d-inline-block pr-2">
                                            <fieldset>
                                                <div class="radio set-time-reason">
                                                    <input type="radio" class="absent-status" name="status[{{$key}}]" id="absent-{{$attendance->id}}" value="0" {{$attendance->status==0 ? 'checked' : ''}}>
                                                    <label for="absent-{{$attendance->id}}">A</label>
                                                </div>
                                            </fieldset>
                                        </li>
                                        <li class="d-inline-block pr-2">
                                            <fieldset>
                                                <div class="radio remove-time-reason">
                                                    <input type="radio" class="late-status" name="status[{{$key}}]" id="late-{{$attendance->id}}" value="2" {{$attendance->status==2 ? 'checked': ''}} >
                                                    <label for="late-{{$attendance->id}}">L</label>
                                                </div>
                                            </fieldset>
                                        </li>
                                    </ul>
                                </td>
                                <td>
                                    <input type="time" name="time[]" value="{{$attendance->time?$attendance->time:date('H:i')}}" class="{{$attendance->status==2 ? '': 'd-none'}} set-new-class">
                                </td>
                                <td>
                                    <input type="text" name="reason[]" value="{{$attendance->reason}}" class="{{$attendance->status==2 ? '': 'd-none'}} set-new-class">
                                </td>

                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-12 d-flex justify-content-end">
                            <input type="hidden" name="class_id" value="{{$inputs['class_name']}}">
                            <input type="hidden" name="date" value="{{$inputs['date']}}">
                            <input type="hidden" name="section_id" value="{{$inputs['section']->id}}">
                            <button type="submit" class="btn btn-primary btn_create formButton mt-1" title="Save">
                                <div class="d-flex">
                                    <div class="formSaveIcon">
                                        <img src="{{asset('assets/backend/app-assets/icon/save-icon.png')}}" width="25">
                                    </div>
                                    <div><span>Save</span></div>
                                </div>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@elseif(isset($students) && count($students)>0)
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="cardStyleChange">
                <div class="card-header">
                    <h4 class="card-title">Take Student Attendance</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('attendance.store')}}" method="POST">
                        @csrf
                        <p class="text-right">
                            <button type="button" class="btn btn-success present-all ">Present All</button>
                            <button type="button" class="btn btn-danger absent-all">Absent All</button>
                        </p>

                        <!-- table bordered -->
                        <div class="table-responsive">
                            <table class="table mb-0 table-sm table-hover">
                                <thead  class="thead-light">
                                    <tr style="height: 50px;">
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Late Time</th>
                                        <th>Reason</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students as $key => $each_student)

                                    <tr class="trFontSize border-bottom">
                                        <td>{{ $each_student->fname.' '.$each_student->mname }}
                                            <input type="hidden" name="student_id[]" value="{{$each_student->id}}">
                                        </td>
                                        <td>
                                            <ul class="list-unstyled mb-0">
                                                <li class="d-inline-block pr-2">
                                                    <fieldset>
                                                        <div class="radio set-time-reason" data-id="p-radio-{{$each_student->id}}">
                                                            <input type="radio" class="present-status" name="status[{{$key}}]" id="present-{{$each_student->id}}" checked value="1" >
                                                            <label for="present-{{$each_student->id}}">P</label>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block pr-2">
                                                    <fieldset>
                                                        <div class="radio set-time-reason" data-id="a-radio-{{$each_student->id}}">
                                                            <input type="radio" class="absent-status" name="status[{{$key}}]" id="absent-{{$each_student->id}}" value="0">
                                                            <label for="absent-{{$each_student->id}}">A</label>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block pr-2">
                                                    <fieldset>
                                                        <div class="radio remove-time-reason" data-id="l-radio-{{$each_student->id}}">
                                                            <input type="radio" class="late-status" name="status[{{$key}}]" id="late-{{$each_student->id}}" value="2">
                                                            <label for="late-{{$each_student->id}}">L</label>
                                                        </div>
                                                    </fieldset>
                                                </li>

                                            </ul>
                                        </td>
                                        <td>
                                            <input type="time" name="time[]" value="{{date_default_timezone_set('Asia/Dubai') ? date('H:i') : '' }}" class="d-none set-new-class">
                                        </td>
                                        <td>
                                            <input type="text" name="reason[]" value="" class="d-none set-new-class">
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-12 d-flex justify-content-end">
                                <input type="hidden" name="class_id" value="{{$inputs['class_name']}}">
                                <input type="hidden" name="date" value="{{$inputs['date']}}">
                                <input type="hidden" name="section_id" value="{{$inputs['section']->id}}">
                                <button type="submit" class="btn btn-primary btn_create formButton mt-1" title="Save">
                                    <div class="d-flex">
                                        <div class="formSaveIcon">
                                            <img src="{{asset("assets/backend/app-assets/icon/save-icon.png")}}" width="25">
                                        </div>
                                        <div><span>Save</span></div>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif
