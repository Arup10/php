<div>
    <div class="card shadow mb-4">
        <div class="d-flex card-header py-3 justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
            <div class="dropdown">
                @csrf
                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Filter With
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" wire:click="filterList('exp_in_5d')">Will expire in 5 days</a>
                    <a class="dropdown-item" wire:click="filterList('exp_in_1m')">Will expire in a month</a>
                    <a class="dropdown-item" wire:click="filterList('expired')">Expired</a>
                    <a class="dropdown-item" wire:click="filterList('all')">All Entries</a>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-between card-header py-3">
            <div class="input-group col-md-2">
                <label for="paginationBox">Result Per Page: </label>
                <input type="number" class="form-control form-control-sm ml-1" id="paginationBox" wire:model.lazy="paginationValue">
            </div>
            <div class="input-group">
                @if ($checked)

                <button type="button" class="btn btn-outline-secondary ml-4" wire:click="exportRecords()">Export
                    ({{ count($checked) }})</button>

                <button type="button" class="btn btn-outline-danger ml-4" data-toggle="modal" data-target="#confirmModal">Delete
                    ({{ count($checked) }})</button>
                <!-- Modal -->
                <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="confirmModalTitle">Warning</h4>
                                <i class="fas fa-exclamation-triangle py-2 ml-2 fa-lg"></i>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <h5>Are you sure to delete the selected records?</h5>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-danger" wire:click="deleteRecords()">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
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