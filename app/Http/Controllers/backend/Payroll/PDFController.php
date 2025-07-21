<?php
namespace App\Http\Controllers\backend\Payroll;

namespace App\Http\Controllers\backend\Payroll;

use App\Http\Controllers\Controller;
use App\Mapping;
use App\Models\Payroll\EmployeeBank;
use App\Models\AccountHead;
use App\Models\Payroll\BankBranch;
use App\Models\Payroll\DeductionProcess;
use App\Models\Payroll\Employee;
use App\Models\Payroll\EmployeeSalary;
use App\Models\Payroll\PaymentInformation;
use App\Models\Payroll\PaySalary;
use App\Models\Payroll\SalaryProcess;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;
use PDF;
  
class PDFController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function generatePDF()
    {
        $data = PaySalary::all()->toArray();
        // dd($data);
        // $pdf = PDF::loadView('myPDF', ['datas' => $data]);
  
        // return $pdf->download('itsolutionstuff.pdf');
    }
    public function generatePayslip(Request $request) {

        // dd($request->all());
        // $month = date('m',strtotime($request->month));
        // $data = PaymentInformation::where('month', $request->month)->where('year', $request->year)->distinct()->get(); //this is distinct  
        // dd($request->year);
        if ($request->grade) {
            if ($request->employee) {
                $datas = PaySalary::where('employee_id', $request->employee)->where('month', $request->month)->where('year', $request->year)->get();
            // dd($datas);
            }else{
                $datas = PaySalary::where('month', $request->month)->where('year', $request->year)->get();
            }
        } elseif($request->employee) {
            $datas = PaySalary::where('employee_id', $request->employee)->where('month', $request->month)->where('year', $request->year)->get();
        
        } else {
            $datas = PaySalary::where('month', $request->month)->where('year', $request->year)->get();
        }
        // $salary_conponents = SalaryProcess::where('employee_id', $request->employee)->where('month', $request->month)->where('year', $request->year)->get();
        // dd($datas);
        if(count($datas)>0){
            return view('backend.pdf.payslip', compact('datas'));
        }else{
            $notification= array(
                'message'       => 'There have no Pay Slip',
                'alert-type'    => 'error'
            );
            return redirect('pay-salary')->with($notification);
        }
       
    }
    public function pay_salary_print($id){
        $datas = PaySalary::where('id', $id)->get();
        return view('backend.pdf.payslip', compact('datas'));
    }
    public function generateManagementReport(Request $request)
    {
        
        $datas = SalaryProcess::where('status', 1)->orderBy('employee_id')->distinct()->get('employee_id');
        $deducts = DeductionProcess::where('status', 1)->orderBy('employee_id')->distinct()->get('employee_id');
        // dd($datas->empl);
        $months = SalaryProcess::where('status', 1)->first();
        if(!$months){
            $notification= array(
                'message'       => 'Salary does not started yet!',
                'alert-type'    => 'warning'
            );
            return redirect()->back()->with($notification);
        }
        // $data = PaymentInformation::where('month', $request->month)->where('year', $request->year)->select('coloum_name')->distinct()->get(); //this is distinct  
        // $datas = PaymentInformation::whereMonth('created_at', $month)->whereYear('created_at', $request->year)->get(); //this is distinct  
        return view('backend.pdf.managementReport', compact('datas', 'months','deducts'));
    }
    
}