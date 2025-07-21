<table class="table table-sm table-bordered show_table_data">
                            <thead>
                                <tr>
                                    <th>Style ID</th>
                                    <th>Item Name</th>
                                    <th>B Price</th>
                                    <th>Vat</th>
                                    <th>S Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="user-table-body">
                                @foreach ($itme_lists as $itme_list)
                                    <tr  class="data-row">
                                        <td>{{$itme_list->style->style_name}}</td>
                                        <td>{{$itme_list->item_name}}</td>
                                        <td>{{$itme_list->sell_price}}</td>
                                        <td>{{$itme_list->vat_amount}}</td>
                                        <td>{{$itme_list->total_amount}}</td>
                                        <td>
                                            <div class="btn-group ">
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Actions
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item" href="{{route('item-list.edit', $itme_list->id)}}">Edit</a>
                                                        <a class="dropdown-item" href="{{route('item-list.show', $itme_list->id)}}">View</a>
                                                        <a class="dropdown-item" href="{{ route('item-list.item-delete', $itme_list->id)}}">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>