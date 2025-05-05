<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Reservasi;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Notification;

class MidtransCallbackController extends Controller
{
    public function handle(Request $request)
    {
        try {
            $notification = new Notification();
            
            $order_id = $notification->order_id;
            $status_code = $notification->status_code;
            $transaction_status = $notification->transaction_status;
            
            // Ekstrak ID reservasi dari order_id (format: REPAINT-{id}-{timestamp})
            $exploded = explode('-', $order_id);
            $reservasi_id = $exploded[1];
            
            $payment = Payment::where('reservasi_id', $reservasi_id)->first();
            
            if ($payment) {
                $payment->transaction_id = $notification->transaction_id;
                $payment->payment_type = $notification->payment_type;
                
                if ($transaction_status == 'capture' || $transaction_status == 'settlement') {
                    $payment->status_pembayaran = 'success';
                    
                    // Update status reservasi
                    $reservasi = Reservasi::find($reservasi_id);
                    if ($reservasi) {
                        $reservasi->status = 'confirmed';
                        $reservasi->save();
                    }
                } elseif ($transaction_status == 'pending') {
                    $payment->status_pembayaran = 'pending';
                } elseif ($transaction_status == 'deny' || $transaction_status == 'expire' || $transaction_status == 'cancel') {
                    $payment->status_pembayaran = 'failed';
                }
                
                $payment->save();
                
                return response()->json(['status' => 'success']);
            }
            
            return response()->json(['status' => 'error', 'message' => 'Payment not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
