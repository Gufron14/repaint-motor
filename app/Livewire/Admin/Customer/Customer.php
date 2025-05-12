<?php

namespace App\Livewire\Admin\Customer;

use App\Models\User;
use App\Models\Reservasi;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Daftar Customer')]
#[Layout('livewire.admin.layouts.app')]

class Customer extends Component
{
    use WithPagination;
    
    protected $paginationTheme = 'bootstrap';
    
    public function render()
    {
        $customers = User::whereHas('roles', function($query) {
            $query->where('name', 'user');
        })->with(['reservasis' => function($query) {
            $query->latest()->with('tipeMotor');
        }])->paginate(10);
        
        return view('livewire.admin.customer.customer', [
            'customers' => $customers
        ]);
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
