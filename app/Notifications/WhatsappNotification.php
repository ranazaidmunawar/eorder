<?php

namespace App\Notifications;

use App\Channels\Messages\WhatsAppMessage;
use App\Channels\WhatsAppChannel;
use App\Models\User\BasicExtended;
use App\Models\User\ProductOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class WhatsappNotification extends Notification
{
    use Queueable;

    public $order;

    public function __construct(ProductOrder $order)
    {
      $this->order = $order;
     
    }

    public function via($notifiable)
    {
      
      return [WhatsAppChannel::class];
    }

    public function toWhatsApp($notifiable)
    {
      $order = $this->order;
      $userId = Auth::guard('web')->user()->id ?? $order->user_id;
      $be = BasicExtended::query()
          ->where('user_id', $userId)
          ->select('base_currency_symbol_position', 'base_currency_symbol')
          ->first();

      $orderNum = $order->order_number;

      $oitems = $order->orderitems;

      $message = "🧾 Order *[$orderNum]*\n";
      $sMethod = ucwords(str_replace("_"," ",$order->serving_method));
      if ($sMethod == 'Home Delivery') {
        $message .= "🏠";
      } elseif ($sMethod == 'Pick Up') {
        $message .= "🚶‍♂️";
      } elseif ($sMethod == 'On Table') {
        $message .= "📃 *Token No:* " . $order->token_no . "\n";
        $message .= "🪑";
      }
      $message .= " *$sMethod*\n\n";

      $message .= "🍛 *Items:*\n\n";

      foreach ($oitems as $oitem) {

        $name = $oitem->title;
        $message .= "✅ $oitem->qty X $name ----- " . $this->setCurrPos($oitem->product_price, $be) . "\n";

        $variations = !empty($oitem->variations) ? json_decode($oitem->variations, true) : [];
        if (!empty($variations)) {
          $message .= "   • Variations ----- " . $this->setCurrPos($oitem->variations_price, $be) . ": ";
          $i = 0;
          foreach ($variations as $key => $var) {
            $i++;
            if ($i == 1) {
              $message .= " ";
            }
            $message .= ucwords(str_replace("_"," ",$key)) . ": " . $var['name'];
            if ($i < count($variations)) {
              $message .= ", ";
            }
          }
          $message .= "\n";
        }

        $addons = !empty($oitem->addons) ? json_decode($oitem->addons, true) : [];
        if (!empty($addons)) {
          $message .= "   • Addons ----- " . $this->setCurrPos($oitem->addons_price, $be) . ": ";
          $i = 0;
          foreach ($addons as $key => $addon) {
            $i++;
            if ($i == 1) {
              $message .= " ";
            }
            $message .= $addon['name'];
            if ($i < count($addons)) {
              $message .= ", ";
            }
          }
          $message .= "\n";
        }

        $message .= "\n";

      }

      if (!empty($order->order_notes)) {
        $message .= "💬 *Order Notes:* ";
        $message .= $order->order_notes . "\n\n";
      }

      if ($order->coupon > 0) {
        $message .= "➖ *Discount:* " . $this->setCurrPos($order->coupon, $be) . "\n";
      }
      if ($sMethod == 'Home Delivery') {
        if($order->shipping_charge){
          $message .= "➕ *Delivery Charge:* " . $this->setCurrPos($order->shipping_charge, $be) . "\n";
        }
      }
      if($order->tax){
        $message .= "➕ *Tax:* " . $this->setCurrPos($order->tax, $be) . "\n";
      }
      $message .= "💵 *Total:* " . $this->setCurrPos($order->total, $be) . "\n\n";

      if ($sMethod == "Home Delivery") {
        if($order->delivery_date && $order->delivery_time_start && $order->delivery_time_end){
          $message .= "🗓 *Preferred Delivery Date:* " . $order->delivery_date . "\n";
          $message .= "⏰ *Preferred Delivery Time:* " . $order->delivery_time_start . " - " . $order->delivery_time_end . "\n\n";
        }
      } elseif ($sMethod == "Pick Up") {
        $message .= "🗓 *Pick up Date:* " . $order->pick_up_date . "\n";
        $message .= "⏰ *Pick up Time:* " . $order->pick_up_time . "\n\n";
      } elseif ($sMethod == "On Table") {
        $message .= "🔢 *Table Number:* " . $order->table_number . "\n";
        if($order->waiter_name){
          $message .= "🙍‍♂️ *Waiter:* " . $order->waiter_name . "\n\n";
        }
      }
  
      $message .= "💰 *Payment Method:* " . ucwords($order->method) . "\n";
      $message .= "🚦 *Order status:* " . ucwords($order->order_status) . "\n\n";
     
      return (new WhatsAppMessage)->content($message);
    }

    public function setCurrPos($amount, $be) {
      return ($be->base_currency_symbol_position == 'left' ? $be->base_currency_symbol : '') . $amount . ($be->base_currency_symbol_position == 'right' ? $be->base_currency_symbol : '');
    }
}
