<div>
    <div class="card shadow mb-4">
        <div class="d-flex card-header py-3 justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
        </div>
        <div class="d-flex justify-content-between card-header py-3">
            <div class="input-group col-md-2">
                 <label for="paginationBox">Result Per Page: </label>
                 <input type="number" class="form-control form-control-sm ml-1" id="paginationBox" wire:model.lazy="paginationValue">
            </div>
            <div class="input-group">
                @if ($checked)

                <button type="button" class="btn btn-outline-secondary ml-2" wire:click="exportRecords()">Export
                    ({{ count($checked) }})</button>
                <button type="button" class="btn btn-outline-secondary ml-2" data-toggle="modal" data-target="#custNameModal">Mark As Sold
                    ({{ count($checked) }})</button>
                <!-- Modal -->
                <div class="modal fade" id="custNameModal" tabindex="-1" role="dialog" aria-labelledby="custNameModalTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="custNameModalTitle">Enter Customer Name</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input type="text" class="form-control" value="proxybazaar" aria-label="CustomerName" aria-describedby="namelHelp" wire:model.lazy="custName">
                                <small id="namelHelp" class="form-text text-muted">Default Name: proxybazaar</small>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" wire:click="sellIps()">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-outline-danger ml-2" onclick="confirm('Are you sure you want to delete these Records?') || event.stopImmediatePropagation()" wire:click="deleteRecords()">Delete
                    ({{ count($checked) }})</button>

                @endif
            </div>
            <div class="input-group justify-content-end">
                <input type="text" class="bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                    </button>
                </div>
            </div>
        </div>
        <div>
            <div class="text-primary strong p-3">
                <p>{{$data->count()}} result(s) shown out of {{$data->total()}}</p>
            </div>
        </div>
        <div>
            @if(session()->has('message'))
            <div class="p-3 text-light bg-primary">
                {{session('message')}}
            </div>
            @endif
        </div>
        <div class="card-body">
            @if($data->count()>0)
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" wire:model="selectAll" />
                            </th>
                            <th>IP</th>
                            <th>Port</th>
                            <th>User</th>
                            <th>Password</th>
                            <th>Full Name</th>
                            <th>comment</th>
                            <th>Enabled</th>
                            <th>Created Time</th>
                            <th>Sold At</th>
                            <th>Expiry Time</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th>IP</th>
                            <th>Port</th>
                            <th>User</th>
                            <th>Password</th>
                            <th>Full Name</th>
                            <th>comment</th>
                            <th>Enabled</th>
                            <th>Created Time</th>
                            <th>Sold At</th>
                            <th>Expiry Time</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($data as $ipVO)
                        <tr>
                            <td>
                                <input type="checkbox" value="{{$ipVO->user}}" wire:model="checked" />
                            </td>
                            <td>{{$ipVO->ip}}</td>
                            <td>{{$ipVO->port}}</td>
                            <td>{{$ipVO->user}}</td>
                            <td>{{$ipVO->password}}</td>
                            <td>{{$ipVO->fullname}}</td>
                            <td>{{$ipVO->comment}}</td>
                            <td>{{$ipVO->enabled}}</td>
                            <td>{{$ipVO->created_timestamp}}</td>
                            <td>{{$ipVO->sold_timestamp}}</td>
                            <td>{{$ipVO->expiry_timestamp}}</td>
                        </tr>
                        @endforeach
                        {{ $data->links() }}
                    </tbody>
                </table>
            </div>
            @else
            <p>No Data found!</p>
            @endif
        </div>
    </div>
</div>