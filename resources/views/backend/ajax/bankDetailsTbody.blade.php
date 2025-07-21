@foreach ($bankDetails as $bank)
    <tr>
        <td>{{ $bank->bank_code }}</td>
        <td>{{ $bank->bank_name }}</td>
        <td>{{ $bank->branch }}</td>
        <td>{{ $bank->signatory }}</td>
        <td>{{ $bank->ac_no }}</td>
        <td style="padding-bottom: 11px; padding-top: 0px">
            <div class="d-flex justify-content-end">
                <a href="{{ route('bankEdit', $bank) }}" class="btn" style="height: 30px; width: 30px;" title="Eidt">
                    <img src="{{ asset('assets/backend/app-assets/icon/edit-icon.png')}}" style=" height: 30px; width: 30px;">
                </a>
                <a href="{{ route('bankDelete', $bank) }}" onclick="return confirm('about to delete project. Please, Confirm?')"  class="btn" style="height: 30px; width: 30px;" title="Delete">
                    <img src="{{ asset('assets/backend/app-assets/icon/delete-icon.png')}}" style=" height: 30px; width: 30px; margin-left: -12px;">
                </a>
            </div>
            </td>
    </tr>
@endforeach