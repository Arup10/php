<?php

namespace App\Http\Livewire;

use App\Http\Controllers\PasswdController;
use App\Models\Passwd;
use Livewire\Component;
use Livewire\WithPagination;

class UnsoldIpListFilter extends Component
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
     * The customer name for whom the ip will be assigned
     *
     * @var string
     */
    public $custName = 'proxybazaar';



    /**
     * This method is provided by livewire. This method renders the view to be displayed in the blade file.
     *
     * @return void
     */
    public function render()
    {
        info("Inside render method");
        $data = Passwd::where('sold', '=', 0)->paginate($this->paginationValue);
        info("all " . $data->count());
        $this->userArray = $data->pluck('user')->map(fn ($item) => (string) $item)->toArray();
        return view('livewire.unsold-ip-list-filter', compact('data'));
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
        session()->flash('message', 'Selected records are deleted successfully! Please refresh the page.');
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

    /**
     * This method marks the selected ips as sold in the datastore.
     *
     * @return void
     */
    public function sellIps()
    {
        Passwd::whereKey($this->checked)->update(['sold' => 1, 'fullname' => $this->custName, 'sold_timestamp' => now(), 'expiry_timestamp' => now()->addDays(30)]);
        $this->checked = [];
        session()->flash('message', 'Selected records are updated successfully! Please refresh the page.');
    }
}
