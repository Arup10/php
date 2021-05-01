<?php

namespace App\Http\Livewire;

use App\Http\Controllers\PasswdController;
use App\Models\Passwd;
use Livewire\Component;
use Livewire\WithPagination;

class UnsoldIpListFilter extends Component
{
    use WithPagination;
    public $checked = [];
    public $paginationValue = 10;
    public $selectAll = false;
    public $userArray = [];
    protected $paginationTheme = 'bootstrap';
    public $custName = 'proxybazaar';

    public function render()
    {
        info("Inside render method");
        $data = Passwd::where('sold', '=', 0)->paginate($this->paginationValue);
        info("all " . $data->count());
        $this->userArray = $data->pluck('user')->map(fn ($item) => (string) $item)->toArray();
        return view('livewire.unsold-ip-list-filter', compact('data'));
    }

    /*  public function mount()
    {
        //$this->data = PasswdController::getAllIPs();
        $this->data = Passwd::paginate($this->paginationValue);
    } */


    public function paginate($input)
    {
        $this->paginationValue = $input;
    }

    public function deleteRecords()
    {
        Passwd::whereKey($this->checked)->delete();
        $this->checked = [];
        session()->flash('message', 'Selected records are deleted successfully! Please refresh the page.');
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

    public function sellIps()
    {
        Passwd::whereKey($this->checked)->update(['sold' => 1, 'fullname' => $this->custName, 'sold_timestamp' => now(), 'expiry_timestamp' => now()->addDays(30)]);
        $this->checked = [];
        session()->flash('message', 'Selected records are updated successfully! Please refresh the page.');
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
