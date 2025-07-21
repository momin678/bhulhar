{{-- <script type="text/javascript">
    $(function() {
            $("#datepickers").datepicker({ dateFormat: "dd/mm/yy" }).val()
    });
</script> --}}
<script>
 // **********************************************************calculation modal show****************************************

    $(document).on("change", ".risk-rating", function(e) {
            var type = $(this).data('risk_rating');
            var value = $(this).val();
            if (value == 'Medium') {
                $(type).val(2);
                this.style.backgroundColor = '#EBEDA3'
                document.querySelector(type).style.backgroundColor = '#EBEDA3';
            } else if (value == 'High') {
                $(type).val(3);
                this.style.backgroundColor = '#E77CB1'
                document.querySelector(type).style.backgroundColor = '#E77CB1';
            } else {
                $(type).val(1);
                this.style.backgroundColor = '#A2F189'
                document.querySelector(type).style.backgroundColor = '#A2F189';
            }
            //  alert(type)
        });
    //
    // ********************************************************** add modal show****************************************
    $(document).on("click", ".employee_modal_open", function(e) {
        var modal = $(this).data('modal');
        // $('.employee_form')[0].reset();

        // document.querySelector('.fupdate-note').style.display = 'none';
        // document.querySelector('.fupdatate-1').style.display = 'none';
        // document.querySelector('.fsave-1').style.display = 'block';
        // document.querySelector('#fappprove-rejection-button').style.display = 'none';

        $(modal).modal('show');
    });

    // ********************************************************** add modal show****************************************

    // ********************************************************** file upload  modal ****************************************
    $(document).on("click", ".employee_file_uplod", function(e) {

        $("#employee_file_uplod_modal").modal('show');
    });

    // ********************************************************** file uploadl show****************************************

    // **************************  show and eidt modal and update data by ajax*************************************
var j = 0;
    $(document).on("click", ".employee", function(e) {
        var id = $(this).data('id');
        
        // alert(id);
        $.ajax({
            url: id,
            method: 'get',
            processData: false,
            contentType: false,
            success: function(res) {
                console.log(res.info);
                if(i == 0){
                    $(".t-body").append('<tr style="border-bottom: 1px solid rgb(243, 243, 243)"><td><input type="text" name="emp_name"  id="emp_name" style="width: 100%;background:#B4C6E7; height: 34px"></td><td><select name="employee_id" id="employee_id" style="width: 100% !important;background:#B4C6E7; height: 34px" required><option value="">Select ...</option>@foreach ($employees as $employee)<option value="{{$employee->id}}">{{$employee->first_name.' '.$employee->last_name}}</option>@endforeach</select></td><td><select name="division" id="division" style="width: 100% !important;background:#B4C6E7; height: 34px" required><option value="">Select </option>@foreach ($divisions as $division)<option value="{{$division->id}}">{{$division->name}}</option>@endforeach</select></td><td><input type="text" name="description" id="description" required style="width: 100%;background:#B4C6E7; height: 34px"></td><td><input type="number" name="amount" id="amount" required style="width: 100%;background:#B4C6E7; height:35px"></td><td><input type="text" name="date" class="datepicker" placeholder="DD/MM/YY" id="datepickers" required style="width: 100%;background:#B4C6E7; height:35px"></td><td colspan="2"><input type="file" name="file" style="width: 100%;background:#B4C6E7; height:34px"></td></tr>'); 
                }
                // $('#employee-modal-edit').modal('show');
                $("#employee_id").val(res.info.employee_id).change();
                $("#amount").val(res.info.amount).focus();
                $("#description").val(res.info.description);
                $('#datepickers').val($.datepicker.formatDate('dd/m/yy', new Date(res.info.date)));
                $("#shows").css("display","");
                $(".datepicker").datepicker({ dateFormat: "dd/mm/yy" });
                // $("form.TTWForm.ui-sortable-disabled").removeAttr("action");
                // $("#myform").attr('action', id);
                var url="{{url('deduction-edit')}}/"+res.info.id;
              
                // var hululu=+9+;
                // alert(hululu);
                $("#myform").attr('action', url);

                i++;
            },
        });
    });

    // Employee edit start
    $(document).on("click", ".employee-edit", function(e) {
        
            
        var id = $(this).data('id');
        // alert(id);
        $.ajax({
            url: id,
            method: 'get',
            processData: false,
            contentType: false,
            success: function(res) {
                $("#edit-modal").empty().append(res.page);
            },
            error: function(err) {
                let error = err.responseJSON;
                $.each(error.errors, function(index, value) {
                    toastr.error(value);

                })
            }
        });
        $('#employee-modal-edit').modal('show');
    });
    // ********************************************************** edit modal show end****************************************
</script>
<script>


    // **********************************************************t type add*****************************************
    $(document).on('click', '#employee_form', function(e) {
        e.preventDefault();
        var form_data = new FormData(document.querySelector('.employee_form'));
       // alert('hello')
        $.ajax({
            url: "{{ route('employees.store') }}",
            method: 'post',
            processData: false,
            contentType: false,
            data: form_data,
            success: function(res) {
                //console.log(res.status)
                if (res.status == 'success') {
                    $('#employee-modal').modal('hide');
                    $('.employee_form')[0].reset();
                    $('.employee_change').load(location.href + ' .employee_change');

                    location.reload();
                  //   $(' ul li a[href="#LEGAL-STATUS"]').click();
                    toastr.success('New employee add successfully');
                }
            },
            error: function(err) {
                let error = err.responseJSON;
                $.each(error.errors, function(index, value) {
                    toastr.error(value);

                })
            }
        });
    })
   
</script>
