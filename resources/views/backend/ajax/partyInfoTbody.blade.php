@foreach ($partyInfos as $pInfo)
<tr class="trFontSize">
    <td>{{ $pInfo->pi_code }}</td>
    <td>{{ $pInfo->short_code }}</td>
    <td>{{ $pInfo->pi_name }}</td>
    <td>{{ $pInfo->pi_type }}</td>
    <td>{{ $pInfo->trn_no }}</td>
    <td>{{ $pInfo->con_person }}</td>
    <td style="padding-bottom: 11px; padding-top: 0px">
        <div class="d-flex justify-content-end">
            <a href="#" class="btn partyCenterView" style="height: 30px; width: 30px;" title="Preview" id="{{$pInfo->id}}"><img src="{{ asset('assets/backend/app-assets/icon/view-icon.png')}}" style=" height: 30px; width: 30px;"></a>
            <a href="{{ route('partyInfoEdit', $pInfo) }}}" class="btn" style="height: 30px; width: 30px;" title="Eidt"><img src="{{ asset('assets/backend/app-assets/icon/edit-icon.png')}}" style=" height: 30px; width: 30px;"></a>
            <a href="{{ route('partyInfoDelete', $pInfo) }}" onclick="return confirm('about to delete master account. Please, Confirm?')"  class="btn" style="height: 30px; width: 30px;" title="Delete"><img src="{{ asset('assets/backend/app-assets/icon/delete-icon.png')}}" style=" height: 30px; width: 30px; margin-left: -12px;"></a>
        </div>

     </td>
</tr>
@endforeach
