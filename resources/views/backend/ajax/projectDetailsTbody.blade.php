@foreach ($projDetails as $proj)
<tr class="trFontSize">
    <td>{{ $proj->proj_no }}</td>
    <td>{{ $proj->proj_name }}</td>
    <td>{{ $proj->proj_type }}</td>
    <td>{{ $proj->owner_name }}</td>
    <td>{{ $proj->address }}</td>
    <td>{{ $proj->cons_agent }}</td>
    <td>{{ $proj->cont_no }}</td>
    <td style="padding-bottom: 11px; padding-top: 0px">
        <div class="d-flex justify-content-end">
            <a href="{{ route('projectView', $proj) }}" class="btn partyCenterView" style="height: 30px; width: 30px;" title="Preview"">
                <img src="{{ asset('assets/backend/app-assets/icon/view-icon.png')}}" style=" height: 30px; width: 30px;"></a>
            <a href="{{ route('projectEdit', $proj) }}" class="btn" style="height: 30px; width: 30px;" title="Eidt">
                <img src="{{ asset('assets/backend/app-assets/icon/edit-icon.png')}}" style=" height: 30px; width: 30px;">
            </a>
            <a href="{{ route('projectDelete', $proj) }}" onclick="return confirm('about to delete project. Please, Confirm?')"  class="btn" style="height: 30px; width: 30px;" title="Delete">
                <img src="{{ asset('assets/backend/app-assets/icon/delete-icon.png')}}" style=" height: 30px; width: 30px; margin-left: -12px;">
            </a>
        </div>
     </td>
</tr>
@endforeach