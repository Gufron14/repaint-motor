<?php

namespace App\Livewire\Admin\Customer;

use App\Models\User;
use App\Models\Reservasi;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Title('View Customer')]
#[Layout('livewire.admin.layouts.app')]

class ViewCustomer extends Component
{
    public $userId;
    public $user;
    public $reservasis;
    
    public function mount($id)
    {
        $this->userId = $id;
        $this->user = User::findOrFail($id);
        $this->reservasis = Reservasi::where('user_id', $id)
            ->with('tipeMotor')
            ->get();
    }
    
    public function render()
    {
        return view('livewire.admin.customer.view-customer');
    }
    
    public function formatPhoneNumber($phone)
    {
        // Remove any non-numeric characters
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // Check if the number starts with '0', replace with '62'
        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        }
        
        // If the number doesn't start with '62', add it
        if (substr($phone, 0, 2) !== '62') {
            $phone = '62' . $phone;
        }
        
        return $phone;
    }
}
