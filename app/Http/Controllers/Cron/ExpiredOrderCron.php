<?php

namespace App\Http\Controllers\Cron;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ExpiredOrderCron extends Controller
{
    # delete expired order and update stock product
    public function execute()
    {
        $orders = DB::table('orders')
                    ->where('status', 'unpaid')
                    ->whereDate('due_date', '<', date('Y-m-d'))
                    ->get()
                    ->all();
                    
        $this->expiredOrders($orders);
        return response()->json('success');
    }

    private function expiredOrders($orders)
    {
        foreach ($orders as $order) {
            # if due_date is expired
            if ($order->due_date <= date('Y-m-d H:i:s')) {
                $this->updateStock($order);
                Order::find($order->order_id)->delete();
            }
        }
    }

    # update stock
    private function updateStock($order)
    {
        $items = OrderDetail::where('order_id', $order->order_id)->get()->all();
        foreach ($items as $item) {
            $product = Product::find($item->product_id);

            $sizeStock = array_combine(json_decode($product->sizes), json_decode($product->stocks));
            if (array_key_exists($item->size, $sizeStock)) {
                $sizeStock[$item->size]++;
            } else {
                $sizeStock[$item->size] = 1;
            }

            $product->update([
                'sizes' => json_encode(array_keys($sizeStock)),
                'stocks' => json_encode(array_values($sizeStock)),
            ]);
        }
    }
}