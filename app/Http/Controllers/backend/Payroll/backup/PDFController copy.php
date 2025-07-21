<?php
namespace App\Http\Controllers\backend\Payroll;

namespace App\Http\Controllers\backend\Payroll;

use App\Http\Controllers\Controller;
use App\Mapping;
use App\Models\Payroll\EmployeeBank;
use App\Models\AccountHead;
use App\Models\Payroll\BankBranch;
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
    public function generatePayslip(Request $request)
    {
        // dd($request->month);
        // $month = date('m',strtotime($request->month));
        // $data = PaymentInformation::where('month', $request->month)->where('year', $request->year)->select('coloum_name')->distinct()->get(); //this is distinct  
        $datas = PaymentInformation::whereMonth('created_at', $request->month)->whereYear('created_at', $request->year)->get(); //this is distinct  
        return view('backend.pdf.payslip', compact('datas'));
    }

    public function generateManagementReport(Request $request)
    {
        $months = $request->month;
        $years = $request->year;
        $month = date('m',strtotime($request->month));
        // $data = PaymentInformation::where('month', $request->month)->where('year', $request->year)->select('coloum_name')->distinct()->get(); //this is distinct  
        $datas = PaymentInformation::whereMonth('created_at', $month)->whereYear('created_at', $request->year)->get(); //this is distinct  
        return view('backend.pdf.managementReport', compact('datas', 'months', 'years'));
    }
    
}