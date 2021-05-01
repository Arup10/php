<?php

namespace App\Http\Livewire;

use App\Http\Controllers\PasswdController;
use App\Models\Passwd;
use Livewire\Component;
use Livewire\WithPagination;

class SoldIpListFilter extends Component
{
    use WithPagination;
    public $checked = [];
    public $paginationValue = 10;
    public $filterName = 'all';
    public $selectAll = false;
    public $userArray = [];
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        info("Inside render method");
        if ($this->filterName == 'exp_in_5d') {
            $data = Passwd::where('expiry_timestamp', '<', now()->addDays(5))->where('expiry_timestamp', '>', now())->where('sold', '=', 1)->paginate($this->paginationValue);
            info("exp_in_5d " . $data->count());
        } else if ($this->filterName == 'exp_in_1m') {
            $data = Passwd::where('expiry_timestamp', '<', now()->addDays(30))->where('expiry_timestamp', '>', now())->where('sold', '=', 1)->paginate($this->paginationValue);
            info("exp_in_1m " . $data->count());
        } else if ($this->filterName == 'expired') {
            $data = Passwd::where('expiry_timestamp', '<', now())->where('sold', '=', 1)->paginate($this->paginationValue);
            info("expired " . $data->count());
        } else if ($this->filterName == 'all') {
            $data = Passwd::where('sold', '=', 1)->paginate($this->paginationValue);
            info("all " . $data->count());
        }
        $this->userArray = $data->pluck('user')->map(fn ($item) => (string) $item)->toArray();
        return view('livewire.sold-ip-list-filter', compact('data'));
    }

    /*  public function mount()
    {
        //$this->data = PasswdController::getAllIPs();
        $this->data = Passwd::paginate($this->paginationValue);
    } */

    public function filterList($input)
    {
        info("Inside filterList1 method" . $input);
        $this->filterName = $input;
        info("processed filterList1 method");
    }

    public function paginate($input)
    {
        $this->paginationValue = $input;
    }

    public function deleteRecords()
    {
        Passwd::whereKey($this->checked)->delete();
        $this->checked = [];
        session()->flash('message', 'Selected records are deleted successfully!');
    }

    public function exportRecords()
    {
        $ips = Passwd::whereKey($this->checked)->get();
        $headers = array(
            'Content-Type' => 'text',
        );
        $callback = function () use ($ips) {
            $FH = fopen('php://output', 'w');
            foreach ($ips as $ip) {
                $op = [$ip->ip . ':' . $ip->port . ':' . $ip->user . ':' . $ip->password];
                fputcsv($FH, $op);
            }
            fclose($FH);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function updatedSelectAll($value)
    {
        //dd($this->userArray);
        if ($value) {
            $this->checked = $this->userArray;
        } else {
            $this->checked = [];
        }
    }

    /* public function setData($value)
    {
        $this->dataSet = $value;
        info("data set in dataSet variable with size: " . $this->dataSet->count());
    }

    public function getData()
    {
        return $this->dataSet;
    } */
}
