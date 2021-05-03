<?php

namespace App\Http\Livewire;

use App\Models\Passwd;
use Livewire\Component;
use Livewire\WithPagination;

class SoldIpListFilter extends Component
{
    use WithPagination;

    /**
     * The selected users
     *
     * @var array
     */
    public $checked = [];

    /**
     * The number of records to be shown in a page
     *
     * @var int
     */
    public $paginationValue = 10;

    /**
     * The selected filter name
     *
     * @var string
     */
    public $filterName = 'all';

    /**
     * Whether the select all button is pressed or not
     *
     * @var bool
     */
    public $selectAll = false;

    /**
     * The users are shown in the current page
     *
     * @var array
     */
    public $userArray = [];

    /**
     * The used CSS framework
     *
     * @var string
     */
    protected $paginationTheme = 'bootstrap';



    /**
     * This method is provided by livewire. This method renders the view to be displayed in the blade file.
     *
     * @return void
     */
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

    /**
     * This method deletes the selected user information from the datastore.
     *
     * @return void
     */
    public function deleteRecords()
    {
        Passwd::whereKey($this->checked)->delete();
        $this->checked = [];
        session()->flash('message', 'Selected records are deleted successfully!');
    }

    /**
     * This method exports the selected user information in a text file.
     *
     * @return void
     */
    public function exportRecords()
    {
        $ips = Passwd::whereKey($this->checked)->get();
        $headers = array(
            'Content-Type' => 'text',
            'Content-Disposition' => 'attachment; filename=sold-ip(s)' . now() . '.txt'
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

    /**
     * This method is provided by livewire. This method updates the user array on selecting/unselecting the select all button in front end.
     *
     * @param  boolean $value
     * @return void
     */
    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->checked = $this->userArray;
        } else {
            $this->checked = [];
        }
    }
}
