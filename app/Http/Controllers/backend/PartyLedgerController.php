<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Journal;
use App\JournalRecord;
use App\PartyInfo;
use Illuminate\Http\Request;

class PartyLedgerController extends Controller
{
        //work by tarek
        public function partyLedger()
        {
            $parties=PartyInfo::get();
            return view('backend.partyLedger.partyLedger',compact('parties'));
        }

        public function findPartyLedgers(Request $request)
        {
            // return $request->all();
                $partyInfo=PartyInfo::find($request->party);

                $ac_payable_id=26;
                $ac_receivable_id=27;
                if($request->from ==null && $request->to==null)
                {
                    $receivable_recordes=JournalRecord::where('party_info_id',$partyInfo->id)->where('account_head_id',$ac_receivable_id)->orderBy('journal_date','ASC')->get();
                    $payable_recordes=JournalRecord::where('party_info_id',$partyInfo->id)->where('account_head_id',$ac_payable_id)->orderBy('journal_date','ASC')->get();
                }
                elseif($request->from !=null && $request->to==null)
                {
                    $from = $request->from;

                    $old_date = explode('/', $from);
                    $new_data = $old_date[0].'-'.$old_date[1].'-'.$old_date[2];
                    $new_date = date('Y-m-d', strtotime($new_data));

                    $receivable_recordes=JournalRecord::where('party_info_id',$partyInfo->id)->where('account_head_id',$ac_receivable_id)->whereDate('journal_date','>=',$new_date)->orderBy('journal_date','ASC')->get();
                    $payable_recordes=JournalRecord::where('party_info_id',$partyInfo->id)->where('account_head_id',$ac_payable_id)->whereDate('journal_date','>=',$new_date)->orderBy('journal_date','ASC')->get();
                }
                elseif($request->to!=null && $request->from ==null)
                {
                    $to = $request->to;
                    
                    $old_date2 = explode('/', $to);
                    $new_data2 = $old_date2[0].'-'.$old_date2[1].'-'.$old_date2[2];
                    $new_date2 = date('Y-m-d', strtotime($new_data2));

                    $receivable_recordes=JournalRecord::where('party_info_id',$partyInfo->id)->where('account_head_id',$ac_receivable_id)->whereDate('journal_date','<=',$new_date2)->orderBy('journal_date','ASC')->get();
                    $payable_recordes=JournalRecord::where('party_info_id',$partyInfo->id)->where('account_head_id',$ac_payable_id)->whereDate('journal_date','<=',$new_date2)->orderBy('journal_date','ASC')->get();
                }
                else
                {
                    $from = $request->from;
                    $to = $request->to;
                    
                    $old_date = explode('/', $from);
                    $new_data = $old_date[0].'-'.$old_date[1].'-'.$old_date[2];
                    $new_date = date('Y-m-d', strtotime($new_data));
                    $old_date2 = explode('/', $to);
                    $new_data2 = $old_date2[0].'-'.$old_date2[1].'-'.$old_date2[2];
                    $new_date2 = date('Y-m-d', strtotime($new_data2));


                    $receivable_recordes=JournalRecord::where('party_info_id',$partyInfo->id)->where('account_head_id',$ac_receivable_id)->whereDate('journal_date','>=',$new_date)->whereDate('journal_date','<=',$new_date2)->orderBy('journal_date','ASC')->get();
                    $payable_recordes=JournalRecord::where('party_info_id',$partyInfo->id)->where('account_head_id',$ac_payable_id)->whereDate('journal_date','>=',$new_date)->whereDate('journal_date','<=',$new_date2)->orderBy('journal_date','ASC')->get();
                }

                if ($request->ajax()) {
                    return Response()->json([
                        'page' => view('backend.partyLedger.partyLedgerAjax', ['receivable_recordes'=>$receivable_recordes,'payable_recordes'=>$payable_recordes,'from'=>$new_date,'to'=>$new_date2,'partyInfo'=>$partyInfo])->render(),
                        'success' => true,
                    ]);
            }
        }


        public function findPartyLedgersDate(Request $request)
        {
            // return $request->all();
            $partyInfo=PartyInfo::find($request->party);
                $journals=Journal::where('party_info_id',$request->party)->whereDate('date',$request->date)->select('date','party_info_id')->distinct()->get();
                if ($request->ajax()) {
                    return Response()->json([
                        'page' => view('backend.partyLedger.partyLedgerDateAjax', ['journals'=>$journals,'date'=>$request->date,'partyInfo'=>$partyInfo])->render(),
                        'success' => true,
                    ]);
                }
        }


        public function printLedger($from,$to,$party)
        {
                $partyInfo=PartyInfo::find($party);
                $journals=Journal::where('party_info_id',$party)->whereDate('date','>=',$from)->whereDate('date','<=',$to)->select('date','party_info_id')->distinct()->get();
                return view('backend.partyLedger.partyLedgerPrint',compact('journals','from','to','party','partyInfo'));
        }

        public function printLedgerDate($date,$party)
        {
            // dd(1);
                $partyInfo=PartyInfo::find($party);
                $journals=Journal::where('party_info_id',$party)->whereDate('date',$date)->select('date','party_info_id')->distinct()->get();
                // dd($journals);
                return view('backend.partyLedger.partyLedgerPrint',compact('journals','date','party','partyInfo'));
        }

        public function new_party_ledger(Request $request){
            $parties=PartyInfo::get();
            return view('backend.partyLedger.new-party-ledger',compact('parties'));
        }
}
