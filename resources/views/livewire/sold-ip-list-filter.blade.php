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
        <div class="d-flex flex-row card-header py-3">
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownPaginationButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Results Per Page
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" wire:click="paginate('10')">10</a>
                    <a class="dropdown-item" wire:click="paginate('20')">20</a>
                    <a class="dropdown-item" wire:click="paginate('30')">30</a>
                </div>
            </div>
            <div class="d-flex flex-row ">
                @if ($checked)

                <button  type="button" class="btn btn-outline-secondary ml-4" wire:click="exportRecords()">Export
                    ({{ count($checked) }})</button>

                <button  type="button" class="btn btn-outline-danger ml-4" onclick="confirm('Are you sure you want to delete these Records?') || event.stopImmediatePropagation()" wire:click="deleteRecords()">Delete
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